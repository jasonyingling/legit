/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// Update colors in customizer
	wp.customize( 'legit_primary_color', function( value ) {
		value.bind( function( to ) {
			$('.has-legit-primary-color').css( {
				'color': to
			} );
			$('.has-legit-primary-background-color').css({
				'background-color': to
			});
		} );
	} );

	wp.customize('legit_secondary_color', function (value) {
		value.bind(function (to) {
			$('.has-legit-secondary-color').css({
				'color': to
			});
			$('.has-legit-secondary-background-color').css({
				'background-color': to
			});
		});
	});

} )( jQuery );
