jQuery(document).ready(function(e){function s(s){e(s).addClass("site-search-open").removeClass("js-open-site-search").addClass("js-close-site-search"),e(".js-site-search").slideDown(),e(".js-site-search .search-field").focus()}function c(s){e(s).removeClass("site-search-open").removeClass("js-close-site-search").addClass("js-open-site-search"),e(".js-site-search").slideUp()}
// Fitvids
// function fitVids() {
//     $('.entry-content').fitVids();
// }
// fitVids();
// Site Search Dropdown
e(".js-open-site-search").live("click",function(){s(this)}),e(".js-close-site-search").live("click",function(){c(this)})});