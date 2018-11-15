<?php
/**
 * legit Color Palette
 *
 * @package legit
 * 
 * Set up colors for the customizer and Gutenberg color palette.
 *
 * Add a new array to add new color options to the customizer and
 * Gutenberg color palette.
 *
 * @since 1.0.0
 *
 * @see add_theme_support( 'editor-color-palette' )
 */
$legit_color_options = array(
	array(
		'name' => esc_html__( 'Gutenberg Primary', 'legit' ),
		'description' => esc_html__( 'Describe how this color is used.', 'legit' ),
		'slug' => 'legit-primary',
		'option' => 'legit_primary_color',
		'default' => '#00CF86', // 🤘
		'transport' => 'postMessage',
	),
);

$legit_color_options = apply_filters( 'legit_filter_color_options', $legit_color_options );

/**
 * Build out the Gutenberg color palette to be used in add_theme_support( 'editor-color-palette' );
 */
$legit_color_palette = array();

foreach ( $legit_color_options as $color ) {
	$legit_color_palette[] = array(
		'name' => $color['name'],
		'slug' => $color['slug'],
		'color' => esc_html( get_theme_mod( $color['option'], $color['default'] ) ),
	);
}