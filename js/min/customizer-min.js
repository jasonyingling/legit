/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
!function(e){
// Site title and description.
wp.customize("blogname",function(t){t.bind(function(t){e(".site-title a").text(t)})}),wp.customize("blogdescription",function(t){t.bind(function(t){e(".site-description").text(t)})}),
// Header text color.
wp.customize("header_textcolor",function(t){t.bind(function(t){"blank"===t?e(".site-title, .site-description").css({clip:"rect(1px, 1px, 1px, 1px)",position:"absolute"}):(e(".site-title, .site-description").css({clip:"auto",position:"relative"}),e(".site-title a, .site-description").css({color:t}))})}),
// Setup color options in customizer from localized array
e.each(JSON.parse(legit_color_options_js.colorOptions),function(t,o){wp.customize(o.option,function(t){t.bind(function(t){e(".has-"+o.slug+"-color").css({color:t}),e(".has-"+o.slug+"-background-color").css({"background-color":t})})})}),
// Customizer Colors with CSS Custom Variables
// Primary Text
wp.customize("legit_text_color",function(t){t.bind(function(t){document.documentElement.style.setProperty("--textmain",t)})}),
// Primary
wp.customize("legit_primary_color",function(t){t.bind(function(t){document.documentElement.style.setProperty("--primary",t)})}),
// Primary Dark
wp.customize("legit_primary_dark_color",function(t){t.bind(function(t){document.documentElement.style.setProperty("--primarydark",t)})}),
// Primary Light
wp.customize("legit_primary_light_color",function(t){t.bind(function(t){document.documentElement.style.setProperty("--primarylight",t)})}),
// Secondary
wp.customize("legit_secondary_color",function(t){t.bind(function(t){document.documentElement.style.setProperty("--secondary",t)})}),
// Secondary Light
wp.customize("legit_secondary_light_color",function(t){t.bind(function(t){document.documentElement.style.setProperty("--secondary-light",t)})}),
// Banner Title and Text
wp.customize("legit_banner_title",function(t){t.bind(function(t){e(".banner-title").text(t)})})}(jQuery);