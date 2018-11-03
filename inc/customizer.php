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
			'default' => null,
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
 * Enqueue theme colors within Gutenberg.
 */
function legit_gutenberg_styles() {
	// Add custom colors to Gutenberg.
	wp_add_inline_style( 'legit-editor-styles', legit_gutenberg_colors() );
}
add_action( 'enqueue_block_editor_assets', 'legit_gutenberg_styles' );

/**
 * Enqueue theme colors.
 */
function legit_styles() {
	// Add custom colors to the front end.
	wp_add_inline_style( 'legit-style', legit_gutenberg_colors() );
}
add_action( 'wp_enqueue_scripts', 'legit_styles' );