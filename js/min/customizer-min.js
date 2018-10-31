/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
!function(o){
// Site title and description.
wp.customize("blogname",function(t){t.bind(function(t){o(".site-title a").text(t)})}),wp.customize("blogdescription",function(t){t.bind(function(t){o(".site-description").text(t)})}),
// Header text color.
wp.customize("header_textcolor",function(t){t.bind(function(t){"blank"===t?o(".site-title, .site-description").css({clip:"rect(1px, 1px, 1px, 1px)",position:"absolute"}):(o(".site-title, .site-description").css({clip:"auto",position:"relative"}),o(".site-title a, .site-description").css({color:t}))})}),
// Setup color options in customizer from localized array
o.each(JSON.parse(legit_color_options_js.colorOptions),function(t,i){wp.customize(i.option,function(t){t.bind(function(t){o(".has-"+i.slug+"-color").css({color:t}),o(".has-"+i.slug+"-background-color").css({"background-color":t})})})}),
// Banner Title and Text
wp.customize("legit_banner_title",function(t){t.bind(function(t){o(".banner-title").text(t)})})}(jQuery);