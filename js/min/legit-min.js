jQuery(document).ready(function(s){
// Fitvids
function e(){s(".entry-content").fitVids()}function c(){s(".js-open-site-search").addClass("site-search-open").removeClass("js-open-site-search").addClass("js-close-site-search"),s(".js-site-search").slideDown(),s(".js-site-search .search-field").focus()}function i(){s(".js-close-site-search").removeClass("site-search-open").removeClass("js-close-site-search").addClass("js-open-site-search"),s(".js-site-search").slideUp(),s(".legit-search").focus()}e(),
// Site Search Dropdown
s(".js-open-site-search").live("click",function(){c()}),s(".js-close-site-search").live("click",function(){i()})});