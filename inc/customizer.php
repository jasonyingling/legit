<?php
/**
 * legit Theme Customizer
 *
 * @package legit
 */

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