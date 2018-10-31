<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package legit
 */

if ( ! function_exists( 'legit_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function legit_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'legit' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'legit_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function legit_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'legit' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'legit_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function legit_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'legit' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'legit' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'legit' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'legit' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'legit' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'legit' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'legit_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function legit_post_thumbnail() {
		$legit_thumbnail = get_theme_mod( 'legit_thumbnail_layout', 'none' );

		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() || is_singular() || $legit_thumbnail === 'none' ) {
			return;
		}

		?>

		<figure class="legit-thumbnail">
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( $legit_thumbnail, array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				?>
			</a>
		</figure>

	<?php
	}
endif;

if ( ! function_exists( 'legit_banner' ) ) :
	function legit_banner( $post_id ) {

		$banner_shown = get_theme_mod( 'legit_banner_shown', 'none' );

		if ( 'none' === $banner_shown  ) {
			return;
		} elseif ( 'both' === $banner_shown ) {
			if ( ! ( is_front_page() || is_home() ) ) {
				return;
			}
		} elseif ( 'default' === $banner_shown ) {
			if ( ! ( is_front_page() && is_home() ) ) {
				return;
			}
		} elseif ( 'static' === $banner_shown ) {
			if ( ! is_front_page() ) {
				return;
			}
		} elseif ( 'posts' === $banner_shown ) {
			if ( ! is_home() ) {
				return;
			}
		}

		if ( is_paged() && ! 'all' === $banner_shown ) {
			return;
		}

		$legit_banner_title = get_theme_mod( 'legit_banner_title' );
		$legit_banner_text  = get_theme_mod( 'legit_banner_text' );

		?>

		<div class="legit-header-grid">

			<?php do_action( 'legit_before_banner' ); ?>

			<header class="legit-header">
				<?php  
				
				if ( $legit_banner_title ) {
					printf( '<h1 class="entry-title banner-title">%s</h1>', $legit_banner_title );
				}

				if ( $legit_banner_text ) {
					$legit_text = apply_filters( 'legit_content', $legit_banner_text );
					printf( '<div class="banner-text">%s</div>', $legit_text );
				}
				
				?>
			</header><!-- .legit-header -->

			<?php do_action( 'legit_after_banner_title' ); ?>

			<figure class="legit-header-image">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/onboarding.svg" >
			</figure>

			<?php do_action( 'legit_after_banner' ); ?>
		</div><!-- .legit-header-bg -->

		<?php
	}
endif;
