<?php
/**
 * legit Color Palette
 *
 * @package legit
 * TODO: Automatically create customizer.js colors with localize_script
 */

/**
 * Add colors here to be implemented into customizer and gutenberg
 */
$legit_color_options = array(
	array(
		'name' => esc_html__( 'Gutenberg Primary', 'legit' ),
		'description' => esc_html__( 'Describe how this color is used.', 'legit' ),
		'slug' => 'legit-primary',
		'option' => 'legit_primary_color',
		'default' => '#bada55',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Gutenberg Secondary', 'legit' ),
		'description' => esc_html__( 'Describe how this color is used.', 'legit' ),
		'slug' => 'legit-secondary',
		'option' => 'legit_secondary_color',
		'default' => '#ff0000',
		'transport' => 'refresh',
	),
);

$legit_color_options = apply_filters( 'legit_filter_color_options', $legit_color_options );

/**
 * Build out the Gutenberg color palette
 */
$legit_color_palette = array();

foreach ( $legit_color_options as $color ) {
	$legit_color_palette[] = array(
		'name' => $color['name'],
		'slug' => $color['slug'],
		'color' => esc_html( get_theme_mod( $color['option'], $color['default'] ) ),
	);
}