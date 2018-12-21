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
		'name' => esc_html__( 'Text', 'legit' ),
		'description' => esc_html__( 'The main text color.', 'legit' ),
		'slug' => 'legit-text',
		'option' => 'legit_text_color',
		'default' => '#292929',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Primary', 'legit' ),
		'description' => esc_html__( 'The primary color of the site.', 'legit' ),
		'slug' => 'legit-primary',
		'option' => 'legit_primary_color',
		'default' => '#00CF86',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Primary - Dark', 'legit' ),
		'description' => esc_html__( 'A darker version of the primary color.', 'legit' ),
		'slug' => 'legit-primary-dark',
		'option' => 'legit_primary_dark_color',
		'default' => '#006300',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Primary - Light', 'legit' ),
		'description' => esc_html__( 'A lighter version of the primary color.', 'legit' ),
		'slug' => 'legit-primary-light',
		'option' => 'legit_primary_light_color',
		'default' => '#c0ebda',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Secondary', 'legit' ),
		'description' => esc_html__( 'The secondary color of the site.', 'legit' ),
		'slug' => 'legit-secondary',
		'option' => 'legit_secondary_color',
		'default' => '#545459',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Secondary - Light', 'legit' ),
		'description' => esc_html__( 'A lighter version of the secondary color.', 'legit' ),
		'slug' => 'legit-secondary-light',
		'option' => 'legit_secondary_light_color',
		'default' => '#f4f4f4',
		'transport' => 'postMessage',
	),
	array(
		'name' => esc_html__( 'Banner Background', 'legit' ),
		'description' => esc_html__( 'Banner background color.', 'legit' ),
		'slug' => 'legit-banner',
		'option' => 'legit_banner_color',
		'default' => '#f6f6f6',
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