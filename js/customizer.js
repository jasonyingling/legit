/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	
	function browserCanUseCssVariables() {
		return window.CSS && CSS.supports('color', 'var(--fake-var)');
	}

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

	// Setup color options in customizer from localized array
	$.each(JSON.parse(legit_color_options_js.colorOptions), function(key, color) {
		wp.customize( color.option, function (value) {
			value.bind(function (to) {
				$('.has-' + color.slug + '-color').css({
					'color': to
				});
				$('.has-' + color.slug + '-background-color').css(
					{
						'background-color': to
					}
				);
			});
		});
	});

	
	// Customizer Colors with CSS Custom Variables
	// Primary Text
	wp.customize('legit_text_color', function (value) {
		value.bind(function (to) {
			if (browserCanUseCssVariables()) {
				document.documentElement.style.setProperty('--textmain', to);
			} else {
				wp.customize.preview.send('refresh');
			}
		});
	});

	// Primary
	wp.customize('legit_primary_color', function (value) {
		value.bind(function (to) {
			if (browserCanUseCssVariables()) {
				document.documentElement.style.setProperty('--primary', to);
			} else {
				wp.customize.preview.send('refresh');
			}
		})
	});

	// Primary Dark
	wp.customize('legit_primary_dark_color', function (value) {
		value.bind(function (to) {
			if (browserCanUseCssVariables()) {
				document.documentElement.style.setProperty('--primarydark', to);
			} else {
				wp.customize.preview.send('refresh');
			}
		});
	});

	// Primary Light
	wp.customize('legit_primary_light_color', function (value) {
		value.bind(function (to) {
			if (browserCanUseCssVariables()) {
				document.documentElement.style.setProperty('--primarylight', to);
			} else {
				wp.customize.preview.send('refresh');
			}
		});
	});

	// Secondary
	wp.customize('legit_secondary_color', function (value) {
		value.bind(function (to) {
			if (browserCanUseCssVariables()) {
				document.documentElement.style.setProperty('--secondary', to);
			} else {
				wp.customize.preview.send('refresh');
			}
		});
	});

	// Secondary Light
	wp.customize('legit_secondary_light_color', function (value) {
		value.bind(function (to) {
			if (browserCanUseCssVariables()) {
				document.documentElement.style.setProperty('--secondary-light', to);
			} else {
				wp.customize.preview.send('refresh');
			}
		});
	});

	wp.customize('legit_banner_color', function(value) {
		value.bind(function(to) {
			$('.legit-banner').css({
				'background': to
			});
		});
	});

	// Banner Title and Text
	wp.customize('legit_banner_title', function(value) {
		value.bind(function(to) {
			$('.banner-title').text(to);
		});
	});

} )( jQuery );
