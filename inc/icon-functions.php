<?php
/**
 * SVG icons related functions.
 *
 * @package WordPress
 * @subpackage Legit
 */

/**
 * Gets the SVG code for a given icon.
 */
function legit_get_icon_svg( $icon, $size=24 ) {
	return Legit_SVG_Icons::get_svg( 'ui', $icon, $size );
}

/**
 * Gets the SVG code for a given social icon.
 */
function legit_get_social_icon_svg( $icon, $size=24 ) {
	return Legit_SVG_Icons::get_svg( 'social', $icon, $size );
}

/**
 * Detects the social network from a URL and returns the SVG code for its icon.
 */
function legit_get_social_link_svg( $uri, $size=24 ) {
	return Legit_SVG_Icons::get_social_link_svg( $uri, $size );
}

/**
 * Switch search icon to a <button> instead of <a> element
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function legit_nav_menu_search_icon_html( $item_output, $item, $depth, $args ) {
	// Change the menu item html for the search icon into a <button>.
	if ( 'menu-1' === $args->theme_location && in_array( 'js-open-site-search', $item->classes ) ) {
		$item_output = preg_replace( '/<a(.*?)>/', '<button>', $item_output );
		$item_output = str_replace( '</a>', '</button>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'legit_nav_menu_search_icon_html', 10, 4 );

/**
 * Display the SVG search icon on menu items used to open the search bar
 * 
 * @param  array $sorted_menu_items The menu items.
 * @param  array $args              wp_nav_menu() arguments.
 * @return array $sorted_menu_items Updated menu items with the SVG added.
 */
function legit_nav_menu_search_icon( $sorted_menu_items, $args ) {
	// Loop through menu items and add the search SVG icon to item using .js-open-site-search class.
	foreach ( $sorted_menu_items as $item ) {
		if ( 'menu-1' === $args->theme_location && in_array( 'js-open-site-search', $item->classes ) ) {
			$svg_search = legit_get_icon_svg( 'search' );
			$item->title = '<span class="screen-reader-text">' . $item->title . '</span>' . $svg_search;
		}
	}
	
	return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'legit_nav_menu_search_icon', 10, 2 );

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function legit_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		$svg = legit_get_social_link_svg( $item->url, 26 );
		if ( empty( $svg ) ) {
			$svg = legit_get_icon_svg( 'link' );
		}
		$item_output = str_replace( $args->link_after, '</span>' . $svg, $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'legit_nav_menu_social_icons', 10, 4 );