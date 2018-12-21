<?php
/**
 * legit Theme Customizer
 *
 * @package legit
 */

/**
 * Return whether we're previewing the front page or blog page.
 */
function legit_is_static_front_page() {
	if ( is_front_page() || is_home() ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Return whether the banner area is shown.
 */
function legit_is_banner_shown() {
	return get_theme_mod( 'legit_banner_shown' );
}

/**
 * Sanitize checkbox/
 */
function legit_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function legit_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'legit_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'legit_customize_partial_blogdescription',
		) );
	}

	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_panel( 'legit_theme_options_panel', array(
		'title'      => esc_html__( 'Theme Options', 'legit' ),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'legit_banner_panel', array(
		'title'           => esc_html__( 'Banner Options', 'legit' ),
		'panel'           => 'legit_theme_options_panel',
		'priority'        => 1,
	) );

	$wp_customize->add_section( 'legit_blog_layout', array(
		'title'      => esc_html__( 'Blog Options', 'legit' ),
		'panel'      => 'legit_theme_options_panel',
		'priority'   => 2,
	) );

	global $legit_color_options;

	/**
	 * Set custom theme colors
	 */
	foreach ( $legit_color_options as $color ) {
		$wp_customize->add_setting(
			$color['option'], array(
				'default'           => $color['default'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => $color['transport'],
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, $color['option'], array(
					'label'       => $color['name'],
					'description' => $color['description'],
					'section'     => 'colors',
				)
			)
		);
	}

	/**
	 * Create thumbnail layout customizer options.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	$wp_customize->add_setting( 
		'legit_thumbnail_layout', array(
			'default'           => 'none',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'legit_thumbnail_layout', array(
			'label'       => __( 'Legit Thumbnail Layout', 'legit' ),
			'description' => __( 'Select the layout for thumbnails on post archives.', 'legit' ),
			'section'     => 'legit_blog_layout',
			'type'        => 'select',
			'choices'     => array(
				'none'      => __( 'No thumbnail layout.', 'legit' ),
				'thumbnail' => __( 'Small thumbnail left of post.', 'legit' ),
				'large'     => __( 'Large thumbnail above post.', 'legit' ),
			),
			'priority'    => 1,
		)
	);

	/**
	 * Create banner customizer options.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	$wp_customize->add_setting(
		'legit_banner_shown', array(
			'default'           => 'none',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'legit_banner_shown', array(
			'label'       => __( 'Show Banner Section', 'legit' ),
			'section'     => 'legit_banner_panel',
			'type'        => 'select',
			'choices'     => array(
				'none'    => __( 'Don\'t Show', 'legit' ),
				'default' => __( 'Default Homepage', 'legit' ),
				'static'  => __( 'Static Homepage', 'legit' ),
				'posts'   => __( 'Blog Page', 'legit'),
				'both'    => __( 'Static Homepage & Blog Page', 'legit' ),
				'all'     => __( 'Everywhere!', 'legit' ),
			),
			'priority'    => 1,
		)
	);

	$wp_customize->add_setting(
		'legit_banner_title', array(
			'default'           => null,
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'legit_banner_title', array(
			'label'           => __( 'Banner Title', 'legit' ),
			'description'     => __( 'Set a title to show in the banner.', 'legit' ),
			'section'         => 'legit_banner_panel',
			'type'            => 'text',
			'priority'        => 2,
			'active_callback' => 'legit_is_banner_shown',
		)
	);

	$wp_customize->add_setting(
		'legit_banner_text', array(
			'default'           => null,
			'sanitize_callback' => 'wp_kses_post'
		)
	);

	$wp_customize->add_control(
		'legit_banner_text', array(
			'label'           => __( 'Banner Text', 'legit' ),
			'description'     => __( 'Set text to show in the banner. You can use basic HTML and shortcodes.', 'legit' ),
			'section'         => 'legit_banner_panel',
			'type'            => 'textarea',
			'priority'        => 3,
			'active_callback' => 'legit_is_banner_shown',
		)
	);

	$wp_customize->add_setting( 
		'legit_banner_image', array(
			'default'			=> '',
			'sanitize_callback'	=> 'absint',
			'transport'			=> 'postMessage'
		) 
	);

	$wp_customize->add_control( 
		new WP_Customize_Media_Control( 
			$wp_customize, 
			'legit_banner_image', array(
				'label'				=> __( 'Banner Image', 'legit' ),
				'mime_type'			=> 'image',
				'section'			=> 'legit_banner_panel',
				'priority'			=> 4
			)
		)
	);

	$wp_customize->add_setting(
		'legit_footer_title', array(
			'default'           => null,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'legit_footer_title', array(
			'label'           => __( 'Copyright Title', 'legit' ),
			'description'     => __( 'Set the copyright title.', 'legit' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'priority'        => 40,
		)
	);

	$wp_customize->add_setting(
		'legit_footer_title_link', array(
			'default'           => null,
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control(
		'legit_footer_title_link', array(
			'label'           => __( 'Copyright Link', 'legit' ),
			'description'     => __( '(optional) Set the copyright link.', 'legit' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'priority'        => 41,
		)
	);

}
add_action( 'customize_register', 'legit_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function legit_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function legit_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function legit_customize_preview_js() {
	global $legit_color_options;

	wp_enqueue_script( 'legit-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );

	wp_localize_script( 'legit-customizer', 'legit_color_options_js', array(
		'colorOptions' => json_encode( $legit_color_options ),
	) );
}
add_action( 'customize_preview_init', 'legit_customize_preview_js' );

/**
 * Add custom colors to Gutenberg.
 */
function legit_gutenberg_colors() {

	global $legit_color_options;

	if ( empty( $legit_color_options ) ) {
		return;
	}

	$css = '';

	foreach ( $legit_color_options as $color ) {
		$custom_color = get_theme_mod( $color['option'], $color['default'] );

		$css .= '.has-' . $color['slug'] . '-color { color: ' . esc_attr( $custom_color ) . ' !important; }';
		$css .= '.has-' . $color['slug'] . '-background-color { background-color: ' . esc_attr( $custom_color ) . '; }';
	}

	return wp_strip_all_tags( $css );
}

/**
 * Add Customizer Styles
 */
function legit_customizer_styles() {

	$css = "";

	$legit_text_color = get_theme_mod( 'legit_text_color', '#292929' );

	if ( '#292929' != $legit_text_color ) {
		$css .= "
			:root {
				--textmain: ${legit_text_color};
			}
			body, button, input, select, optgroup, textarea,
			button,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"],
			.legit-button,
			button.legit-button-alt:hover,
			button.legit-button-alt:focus,
			input[type=\"button\"].legit-button-alt:hover,
			input[type=\"button\"].legit-button-alt:focus,
			input[type=\"reset\"].legit-button-alt:hover,
			input[type=\"reset\"].legit-button-alt:focus,
			input[type=\"submit\"].legit-button-alt:hover,
			input[type=\"submit\"].legit-button-alt:focus,
			.legit-button.legit-button-alt:hover,
			.legit-button.legit-button-alt:focus,
			button.legit-button-white:hover,
			button.legit-button-white:focus,
			input[type=\"button\"].legit-button-white:hover,
			input[type=\"button\"].legit-button-white:focus,
			input[type=\"reset\"].legit-button-white:hover,
			input[type=\"reset\"].legit-button-white:focus,
			input[type=\"submit\"].legit-button-white:hover,
			input[type=\"submit\"].legit-button-white:focus,
			.legit-button.legit-button-white:hover,
			.legit-button.legit-button-white:focus,
			a,.site-title a:not(.wp-block-button__link):not(.button),
			.entry-title a:not(.wp-block-button__link):not(.button),
			.entry-content a:not(.wp-block-button__link):not(.button),
			.banner-text a:not(.wp-block-button__link):not(.button),
			.site-title a:not(.wp-block-button__link):not(.button):visited,
			.entry-title a:not(.wp-block-button__link):not(.button):visited,
			.entry-content a:not(.wp-block-button__link):not(.button):visited,
			.banner-text a:not(.wp-block-button__link):not(.button):visited,
			.site-title a:not(.wp-block-button__link):not(.button):hover,
			.site-title a:not(.wp-block-button__link):not(.button):focus,
			.site-title a:not(.wp-block-button__link):not(.button):active,
			.entry-title a:not(.wp-block-button__link):not(.button):hover,
			.entry-title a:not(.wp-block-button__link):not(.button):focus,
			.entry-title a:not(.wp-block-button__link):not(.button):active,
			.entry-content a:not(.wp-block-button__link):not(.button):hover,
			.entry-content a:not(.wp-block-button__link):not(.button):focus,
			.entry-content a:not(.wp-block-button__link):not(.button):active,
			.banner-text a:not(.wp-block-button__link):not(.button):hover,
			.banner-text a:not(.wp-block-button__link):not(.button):focus,
			.banner-text a:not(.wp-block-button__link):not(.button):active,
			.comment-author .fn a, .comment-author .fn a:visited, 
			comment-author .fn a:hover, .comment-author .fn a:focus,
			.comment-author .fn a:active,
			.widget_archive a:hover,
			.widget_archive a:focus,.widget_categories a:hover,.widget_categories a:focus,
			.widget_archive a:visited,.widget_categories a:visited, .comments-title,
			.comment-reply-link:hover, .comment-reply-link:focus, .wp-block-button__link:not(.has-text-color),
			.main-navigation a { 
				color: ${legit_text_color}; color: var(--textmain); 
			}
			.menu-toggle span, .menu-toggle:before, .menu-toggle:after { 
				background: ${legit_color_text}; 
				background: var(--textmain); 
			}
			@media screen and (min-width: 768px) {
				.main-navigation li:hover > a,
				.main-navigation li.focus > a { 
					color: ${legit_text_color};
					color: var(--textmain); 
				}
			}	
		";
	}

	$legit_primary_color = get_theme_mod( 'legit_primary_color', '#00cf86' );

	if ( '#00cf86' != $legit_primary_color ) {
		$css .= "
			:root {
				--primary: ${legit_primary_color};
			}
			blockquote, .wp-block-quote:not(.is-large):not(.is-style-large) { 
				border-color: ${legit_primary_color}; border-color: var(--primary); 
			}
			.site-title a:not(.wp-block-button__link):not(.button),
			.entry-title a:not(.wp-block-button__link):not(.button),
			.entry-content a:not(.wp-block-button__link):not(.button),
			.banner-text a:not(.wp-block-button__link):not(.button) { 
				border-color: ${legit_primary_color}; 
				border-color: var(--primary); 
				box-shadow: inset 0 -4px 0 0 ${legit_primary_color};
				box-shadow: inset 0 -4px 0 0 var(--primary); 
			}
			.site-title a:not(.wp-block-button__link):not(.button):hover,
			.site-title a:not(.wp-block-button__link):not(.button):focus,
			.site-title a:not(.wp-block-button__link):not(.button):active,
			.entry-title a:not(.wp-block-button__link):not(.button):hover,
			.entry-title a:not(.wp-block-button__link):not(.button):focus,
			.entry-title a:not(.wp-block-button__link):not(.button):active,
			.entry-content a:not(.wp-block-button__link):not(.button):hover,
			.entry-content a:not(.wp-block-button__link):not(.button):focus,
			.entry-content a:not(.wp-block-button__link):not(.button):active,
			.banner-text a:not(.wp-block-button__link):not(.button):hover,
			.banner-text a:not(.wp-block-button__link):not(.button):focus,
			.banner-text a:not(.wp-block-button__link):not(.button):active,
			.comment-author .fn a:hover, .comment-author .fn a:focus, .comment-author .fn a:active { 
				box-shadow: inset 0 -2em 0 0 ${legit_primary_color}; 
				box-shadow: inset 0 -2em 0 0 var(--primary); 
			}
			.comment-author .fn a { 
				border-color: ${legit_primary_color}; 
				border-color: var(--primary); 
				box-shadow: inset 0 -2px 0 0 ${legit_primary_color}; 
				box-shadow: inset 0 -2px 0 0 var(--primary); 
			}
			.entry-title a:not(.wp-block-button__link) { 
				box-shadow: inset 0 0 0 0 ${legit_primary_color}; 
				box-shadow: inset 0 0 0 0 var(--primary); 
			}
			button,
			input[type=\"button\"],
			input[type=\"reset\"],
			input[type=\"submit\"],
			.legit-button, .post-author-badge,
			.entry-content a:not(.wp-block-button__link):visited,
			.children .comment-body:before, .wp-block-button__link:not(.has-background) { 
				background-color: ${legit_primary_color}; 
				background-color: var(--primary); 
			}
			@media screen and (min-width: 768px) { 
				.main-navigation .menu > li:not(.menu-item-has-children):after { 
					background: ${legit_primary_color}; 
					background: var(--primary); 
				} 
				.main-navigation ul ul li:before { 
					background: ${legit_primary_color}; 
					background: var(--primary); 
				}
			}
		";
	}

	$legit_primary_dark = get_theme_mod( 'legit_primary_dark_color', '#006300' );

	if ( '#006300' != $legit_primary_dark ) {
		$css .= "
			:root {
				--primarydark: ${legit_primary_dark};
			}
			a:hover, a:focus, a:active, a:visited,
			.comment-metadata a:hover, .comment-metadata a:focus,
			.entry-meta a:hover, .entry-meta a:focus, .entry-meta a:active,
			.widget-area--footer .widget_nav_menu a:hover, .widget-area--footer .widget_nav_menu a:focus,
			button:hover, button:active, button:focus,
			input[type=\"button\"]:hover,input[type=\"button\"]:active,
			input[type=\"button\"]:focus,input[type=\"reset\"]:hover,
			input[type=\"reset\"]:active,input[type=\"reset\"]:focus,
			input[type=\"submit\"]:hover,input[type=\"submit\"]:active,
			input[type=\"submit\"]:focus,.legit-button:hover,.legit-button:active,.legit-button:focus,
			.wp-block-button__link:not(.has-background):hover,
			.wp-block-button__link:not(.has-background):active, .wp-block-button__link:not(.has-background):focus { 
				color: ${legit_primary_dark}; color: var(--primarydark); 
			}
		";
	}

	$legit_primary_light = get_theme_mod( 'legit_primary_light_color', '#c0ebda' );

	if ( '#c0ebda' != $legit_primary_light ) {
		$css .= "
			:root {
				--primarylight: ${legit_primary_light};
			}
			.wp-block-button__link:not(.has-background):hover,
			.wp-block-button__link:not(.has-background):active,
			.wp-block-button__link:not(.has-background):focus,
			button:hover, button:active, button:focus,
			input[type=\"button\"]:hover,input[type=\"button\"]:active,
			input[type=\"button\"]:focus,input[type=\"reset\"]:hover,
			input[type=\"reset\"]:active,input[type=\"reset\"]:focus,
			input[type=\"submit\"]:hover,input[type=\"submit\"]:active,
			input[type=\"submit\"]:focus,.legit-button:hover,.legit-button:active,
			.legit-button:focus { 
				background: ${legit_primary_light};
				background: var(--primarylight); 
			}
			.widget_archive a:visited, .widget_categories a:visited { 
				background-color: ${legit_primary_light}; 
				background-color: var(--primarylight); 
			}
		";
	}

	$legit_secondary = get_theme_mod( 'legit_secondary_color', '#545459' );

	if ( '#545459' != $legit_secondary ) {
		$css .= "
			:root {
				--secondary: ${legit_secondary};
			}
			abbr, acronym { 
				border-color: ${legit_secondary}; 
				border-color: var(--secondary); 
			}
			button.legit-button-alt,input[type=\"button\"].legit-button-alt,
			input[type=\"reset\"].legit-button-alt,
			input[type=\"submit\"].legit-button-alt,.legit-button.legit-button-alt,
			input[type=\"text\"],input[type=\"email\"],input[type=\"url\"],
			input[type=\"password\"],input[type=\"search\"],input[type=\"number\"],
			input[type=\"tel\"],input[type=\"range\"],input[type=\"date\"],
			input[type=\"month\"],input[type=\"week\"],input[type=\"time\"],
			input[type=\"datetime\"],input[type=\"datetime-local\"],input[type=\"color\"],
			textarea, .comment-metadata a, .widget_archive a, .widget_categories a,
			.site-description, .entry-meta, .entry-meta a, .comment-reply-link, .wp-block-latest-posts__post-date,
			.site-footer .site-info, .widget-area--footer .widget_nav_menu a  { 
				color: ${legit_secondary_color};
				color: var(--secondary); 
			}
		";
	}

	$legit_secondary_light = get_theme_mod( 'legit_secondary_light_color', '#f4f4f4' );

	if ( '#f4f4f4' != $legit_secondary_light ) {
		$css .= "
			:root {
				--secondarylight: ${legit_secondary_light};
			}
			.main-navigation .menu,
			.main-navigation.toggled > div { 
				background: ${legit_secondary_light};
				background: var(--secondarylight);
			}
			.wp-block-pullquote:not(.has-background).is-style-solid-color { 
				background-color: ${legit_secondary_light};
				background-color: var(--secondarylight); 
			}
		";
	}

	$legit_banner_color = get_theme_mod( 'legit_banner_color', '#f6f6f6' );

	if ( '#f6f6f6' != $legit_banner_color ) {
		$css .= "
			.legit-banner {
				background: ${legit_banner_color};
			}
		";
	}

	return wp_strip_all_tags( $css );

}

/**
 * Add Customizer Styles to the Editor
 */
function legit_customizer_editor_styles() {

	$css = "";

	$legit_text_color = get_theme_mod( 'legit_text_color', '#292929' );

	if ( '#292929' != $legit_text_color ) {
		$css .= "
			:root {
				--textmain: ${legit_text_color};
			}
			.editor-styles-wrapper body, .editor-styles-wrapper button, 
			.editor-styles-wrapper input, .editor-styles-wrapper select, 
			.editor-styles-wrapper optgroup, .editor-styles-wrapper textarea, 
			.editor-styles-wrapper button, .editor-styles-wrapper input[type=\"button\"],
			.editor-styles-wrapper input[type=\"reset\"], .editor-styles-wrapper input[type=\"submit\"], 
			.editor-styles-wrapper .legit-button, 
			.editor-styles-wrapper button.legit-button-alt:hover, 
			.editor-styles-wrapper button.legit-button-alt:focus, 
			.editor-styles-wrapper input[type=\"button\"].legit-button-alt:hover, 
			.editor-styles-wrapper input[type=\"button\"].legit-button-alt:focus, 
			.editor-styles-wrapper input[type=\"reset\"].legit-button-alt:hover, 
			.editor-styles-wrapper input[type=\"reset\"].legit-button-alt:focus, 
			.editor-styles-wrapper input[type=\"submit\"].legit-button-alt:hover, 
			.editor-styles-wrapper input[type=\"submit\"].legit-button-alt:focus, 
			.editor-styles-wrapper .legit-button.legit-button-alt:hover, 
			.editor-styles-wrapper .legit-button.legit-button-alt:focus,
			.editor-styles-wrapper button.legit-button-white:hover, 
			.editor-styles-wrapper button.legit-button-white:focus, 
			.editor-styles-wrapper input[type=\"button\"].legit-button-white:hover, 
			.editor-styles-wrapper input[type=\"button\"].legit-button-white:focus, 
			.editor-styles-wrapper input[type=\"reset\"].legit-button-white:hover, 
			.editor-styles-wrapper input[type=\"reset\"].legit-button-white:focus, 
			.editor-styles-wrapper input[type=\"submit\"].legit-button-white:hover, 
			.editor-styles-wrapper input[type=\"submit\"].legit-button-white:focus, 
			.editor-styles-wrapper .legit-button.legit-button-white:hover, 
			.editor-styles-wrapper .legit-button.legit-button-white:focus,
			.editor-styles-wrapper a, 
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button), 
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button), 
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button), .editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button),
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):visited, 
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):visited, 
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):visited, 
			.editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):visited,
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):hover, 
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):focus, .editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):active, .editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):hover, .editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):focus, .editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):active, .editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):hover, .editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):focus, .editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):active, .editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):hover, .editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):focus, .editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):active,
			.editor-styles-wrapper .comment-author .fn a, .editor-styles-wrapper .comment-author .fn a:visited, 
			.editor-styles-wrapper .comment-author .fn a:hover, 
			.editor-styles-wrapper .comment-author .fn a:focus, 
			.editor-styles-wrapper .comment-author .fn a:active,
			.editor-styles-wrapper .widget_archive a:hover, 
			.editor-styles-wrapper .widget_archive a:focus, 
			.editor-styles-wrapper .widget_categories a:hover, 
			.editor-styles-wrapper .widget_categories a:focus, 
			.editor-styles-wrapper .widget_archive a:visited, 
			.editor-styles-wrapper .widget_categories a:visited, 
			.editor-styles-wrapper .comments-title, 
			.editor-styles-wrapper .comment-reply-link:hover, 
			.editor-styles-wrapper .comment-reply-link:focus, 
			.editor-styles-wrapper .wp-block-button__link:not(.has-text-color),
			.editor-styles-wrapper .main-navigation a { 
				color: ${legit_text_color}; 
				color: var(--textmain); 
			}
			.editor-styles-wrapper .menu-toggle span, 
			.editor-styles-wrapper .menu-toggle:before, 
			.editor-styles-wrapper .menu-toggle:after { 
				background: ${legit_color_text}; 
				background: var(--textmain); 
			}
			@media screen and (min-width: 768px) {
				.editor-styles-wrapper .main-navigation li:hover > a,
				.editor-styles-wrapper .main-navigation li.focus > a { 
					color: ${legit_text_color}; 
					color: var(--textmain); 
				}
			}	
		";
	}

	$legit_primary_color = get_theme_mod( 'legit_primary_color', '#00cf86' );

	if ( '#00cf86' != $legit_primary_color ) {
		$css .= "
			:root {
				--primary: ${legit_primary_color};
			}
			.editor-styles-wrapper blockquote, 
			.editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large) { 
				border-color: ${legit_primary_color}; border-color: var(--primary); 
			}
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button),
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button),
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button),
			.editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button) { 
				border-color: ${legit_primary_color}; 
				border-color: var(--primary); 
				box-shadow: inset 0 -4px 0 0 ${legit_primary_color}; 
				box-shadow: inset 0 -4px 0 0 var(--primary); 
			}
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):hover,
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):focus,
			.editor-styles-wrapper .site-title a:not(.wp-block-button__link):not(.button):active,
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):hover,
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):focus,
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link):not(.button):active,
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):hover,
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):focus,
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):not(.button):active,
			.editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):hover,
			.editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):focus,
			.editor-styles-wrapper .banner-text a:not(.wp-block-button__link):not(.button):active,
			.editor-styles-wrapper .comment-author .fn a:hover,
			.editor-styles-wrapper .comment-author .fn a:focus,
			.editor-styles-wrapper .comment-author .fn a:active { 
				box-shadow: inset 0 -2em 0 0 ${legit_primary_color}; 
				box-shadow: inset 0 -2em 0 0 var(--primary); 
			}
			.editor-styles-wrapper .comment-author .fn a { 
				border-color: ${legit_primary_color};
				border-color: var(--primary);
				box-shadow: inset 0 -2px 0 0 ${legit_primary_color};
				box-shadow: inset 0 -2px 0 0 var(--primary);
			}
			.editor-styles-wrapper .entry-title a:not(.wp-block-button__link) { 
				box-shadow: inset 0 0 0 0 ${legit_primary_color}; 
				box-shadow: inset 0 0 0 0 var(--primary); 
			}
			.editor-styles-wrapper button, 
			.editor-styles-wrapper input[type=\"button\"], 
			.editor-styles-wrapper input[type=\"reset\"], 
			.editor-styles-wrapper input[type=\"submit\"], 
			.editor-styles-wrapper .legit-button, 
			.editor-styles-wrapper .post-author-badge, 
			.editor-styles-wrapper .entry-content a:not(.wp-block-button__link):visited,
			.editor-styles-wrapper .children .comment-body:before,
			.editor-styles-wrapper .wp-block-button__link:not(.has-background) { 
				background-color: ${legit_primary_color}; 
				background-color: var(--primary); 
			}
			@media screen and (min-width: 768px) { 
				.editor-styles-wrapper .main-navigation .menu > li:not(.menu-item-has-children):after { 
					background: ${legit_primary_color}; 
					background: var(--primary); 
				} 
				.editor-styles-wrapper .main-navigation ul ul li:before { 
					background: ${legit_primary_color}; 
					background: var(--primary); 
				}
			}
		";
	}

	$legit_primary_dark = get_theme_mod( 'legit_primary_dark_color', '#006300' );

	if ( '#006300' != $legit_primary_dark ) {
		$css .= "
			:root {
				--primarydark: ${legit_primary_dark};
			}
			.editor-styles-wrapper a:hover, 
			.editor-styles-wrapper a:focus,
			.editor-styles-wrapper a:active,
			.editor-styles-wrapper a:visited, 
			.editor-styles-wrapper .comment-metadata a:hover,
			.editor-styles-wrapper .comment-metadata a:focus, 
			.editor-styles-wrapper .entry-meta a:hover,
			.editor-styles-wrapper .entry-meta a:focus,
			.editor-styles-wrapper .entry-meta a:active, 
			.editor-styles-wrapper .widget-area--footer .widget_nav_menu a:hover,
			.editor-styles-wrapper .widget-area--footer .widget_nav_menu a:focus, 
			.editor-styles-wrapper button:hover,
			.editor-styles-wrapper button:active,
			.editor-styles-wrapper button:focus,
			.editor-styles-wrapper input[type=\"button\"]:hover,
			.editor-styles-wrapper input[type=\"button\"]:active,
			.editor-styles-wrapper input[type=\"button\"]:focus,
			.editor-styles-wrapper input[type=\"reset\"]:hover,
			.editor-styles-wrapper input[type=\"reset\"]:active,
			.editor-styles-wrapper input[type=\"reset\"]:focus,
			.editor-styles-wrapper input[type=\"submit\"]:hover,
			.editor-styles-wrapper input[type=\"submit\"]:active,
			.editor-styles-wrapper input[type=\"submit\"]:focus,
			.editor-styles-wrapper .legit-button:hover,
			.editor-styles-wrapper .legit-button:active,
			.editor-styles-wrapper .legit-button:focus, 
			.editor-styles-wrapper .wp-block-button__link:not(.has-background):hover, 
			.editor-styles-wrapper .wp-block-button__link:not(.has-background):active,
			.editor-styles-wrapper .wp-block-button__link:not(.has-background):focus { 
				color: ${legit_primary_dark}; color: var(--primarydark);
			}
		";
	}

	$legit_primary_light = get_theme_mod( 'legit_primary_light_color', '#c0ebda' );

	if ( '#c0ebda' != $legit_primary_light ) {
		$css .= "
			:root {
				--primarylight: ${legit_primary_light};
			}
			.editor-styles-wrapper .wp-block-button__link:not(.has-background):hover, 
			.editor-styles-wrapper .wp-block-button__link:not(.has-background):active,
			.editor-styles-wrapper .wp-block-button__link:not(.has-background):focus, 
			.editor-styles-wrapper button:hover, .editor-styles-wrapper button:active,
			.editor-styles-wrapper button:focus, .editor-styles-wrapper input[type=\"button\"]:hover,
			.editor-styles-wrapper input[type=\"button\"]:active,
			.editor-styles-wrapper input[type=\"button\"]:focus,
			.editor-styles-wrapper input[type=\"reset\"]:hover,
			.editor-styles-wrapper input[type=\"reset\"]:active,
			.editor-styles-wrapper input[type=\"reset\"]:focus,
			.editor-styles-wrapper input[type=\"submit\"]:hover,
			.editor-styles-wrapper input[type=\"submit\"]:active,
			.editor-styles-wrapper input[type=\"submit\"]:focus,
			.editor-styles-wrapper .legit-button:hover,
			.editor-styles-wrapper .legit-button:active,
			.editor-styles-wrapper .legit-button:focus { 
				background: ${legit_primary_light};
				background: var(--primarylight); 
			}
			.editor-styles-wrapper .widget_archive a:visited,
			.editor-styles-wrapper .widget_categories a:visited { 
				background-color: ${legit_primary_light};
				background-color: var(--primarylight); 
			}
		";
	}

	$legit_secondary = get_theme_mod( 'legit_secondary_color', '#545459' );

	if ( '#545459' != $legit_secondary ) {
		$css .= "
			:root {
				--secondary: ${legit_secondary};
			}
			.editor-styles-wrapper abbr,
			.editor-styles-wrapper acronym { 
				border-color: ${legit_secondary};
				border-color: var(--secondary);
			}
			.editor-styles-wrapper button.legit-button-alt,
			.editor-styles-wrapper input[type=\"button\"].legit-button-alt,
			.editor-styles-wrapper input[type=\"reset\"].legit-button-alt,
			.editor-styles-wrapper input[type=\"submit\"].legit-button-alt,
			.editor-styles-wrapper .legit-button.legit-button-alt, 
			.editor-styles-wrapper input[type=\"text\"],
			.editor-styles-wrapper input[type=\"email\"],
			.editor-styles-wrapper input[type=\"url\"],
			.editor-styles-wrapper input[type=\"password\"],
			.editor-styles-wrapper input[type=\"search\"],
			.editor-styles-wrapper input[type=\"number\"],
			.editor-styles-wrapper input[type=\"tel\"],
			.editor-styles-wrapper input[type=\"range\"],
			.editor-styles-wrapper input[type=\"date\"],
			.editor-styles-wrapper input[type=\"month\"],
			.editor-styles-wrapper input[type=\"week\"],
			.editor-styles-wrapper input[type=\"time\"],
			.editor-styles-wrapper input[type=\"datetime\"],
			.editor-styles-wrapper input[type=\"datetime-local\"],
			.editor-styles-wrapper input[type=\"color\"],
			.editor-styles-wrapper textarea, 
			.editor-styles-wrapper .comment-metadata a,
			.editor-styles-wrapper .widget_archive a,
			.editor-styles-wrapper .widget_categories a, 
			.editor-styles-wrapper .site-description,
			.editor-styles-wrapper .entry-meta,
			.editor-styles-wrapper .entry-meta a,
			.editor-styles-wrapper .comment-reply-link,
			.editor-styles-wrapper .wp-block-latest-posts__post-date, 
			.editor-styles-wrapper .site-footer .site-info,
			.editor-styles-wrapper .widget-area--footer .widget_nav_menu a  { 
				color: ${legit_secondary_color};
				color: var(--secondary);
			}
		";
	}

	$legit_secondary_light = get_theme_mod( 'legit_secondary_light_color', '#f4f4f4' );

	if ( '#f4f4f4' != $legit_secondary_light ) {
		$css .= "
			:root {
				--secondarylight: ${legit_secondary_light};
			}
			.editor-styles-wrapper .main-navigation .menu, 
			.editor-styles-wrapper .main-navigation.toggled > div { 
				background: ${legit_secondary_light}; 
				background: var(--secondarylight);
			}
			.editor-styles-wrapper .wp-block-pullquote:not(.has-background).is-style-solid-color { 
				background-color: ${legit_secondary_light};
				background-color: var(--secondarylight);
			}
		";
	}

	return wp_strip_all_tags( $css );

}

/**
 * Enqueue theme colors within Gutenberg.
 */
function legit_gutenberg_styles() {
	// Add custom colors to Gutenberg.
	wp_add_inline_style( 'legit-editor-styles', legit_gutenberg_colors() );
	wp_add_inline_style( 'legit-editor-styles', legit_customizer_styles() );
}
add_action( 'enqueue_block_editor_assets', 'legit_gutenberg_styles' );

/**
 * Enqueue theme colors.
 */
function legit_styles() {
	// Add custom colors to the front end.
	wp_add_inline_style( 'legit-style', legit_gutenberg_colors() );
	wp_add_inline_style( 'legit-style', legit_customizer_styles() );
}
add_action( 'wp_enqueue_scripts', 'legit_styles' );