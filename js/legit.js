jQuery(document).ready(function ($) {

    // Site Search Dropdown
    $('.js-open-site-search').live( 'click', function () {
        openSearch();
    });

    $('.js-close-site-search').live( 'click', function () {
        closeSearch();
    });

    function openSearch() {
        $('.js-open-site-search')
			.addClass('site-search-open')
			.removeClass('js-open-site-search')
			.addClass('js-close-site-search');
        $('.js-site-search').slideDown();
        $('.js-site-search .search-field').focus();
    }

    function closeSearch() {
        $('.js-close-site-search')
			.removeClass('site-search-open')
			.removeClass('js-close-site-search')
			.addClass('js-open-site-search');
        $('.js-site-search').slideUp();
        $('.menu .js-open-site-search button').focus();
    }

});