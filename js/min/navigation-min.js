/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
!function(){
/**
	 * Sets or removes .focus class on an element.
	 */
function e(){
// Move up through the ancestors of the current link until we hit .nav-menu.
for(var e=this;-1===e.className.indexOf("nav-menu");)
// On li elements toggle the class .focus.
"li"===e.tagName.toLowerCase()&&(-1!==e.className.indexOf("focus")?e.className=e.className.replace(" focus",""):e.className+=" focus"),e=e.parentElement}
/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */var a,t,s,n,l,i,c;if(t=document.getElementsByTagName("html")[0],(a=document.getElementById("site-navigation"))&&void 0!==(s=a.getElementsByTagName("button")[0]))
// Hide menu toggle button if menu is empty and return early.
if(void 0!==(n=a.getElementsByTagName("ul")[0])){
// Each time a menu link is focused or blurred, toggle focus.
for(n.setAttribute("aria-expanded","false"),-1===n.className.indexOf("nav-menu")&&(n.className+=" nav-menu"),s.onclick=function(){-1!==a.className.indexOf("toggled")?(a.className=a.className.replace(" toggled",""),t.className=t.className.replace(" show-nav",""),s.setAttribute("aria-expanded","false"),n.setAttribute("aria-expanded","false")):(a.className+=" toggled",t.className+=" show-nav",s.setAttribute("aria-expanded","true"),n.setAttribute("aria-expanded","true"))},i=0,c=(
// Get all the link elements within the menu.
l=n.getElementsByTagName("a")).length;i<c;i++)l[i].addEventListener("focus",e,!0),l[i].addEventListener("blur",e,!0);
/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
!function(e){var a,t,s=e.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");if("ontouchstart"in window)for(a=function(e){var a=this.parentNode,t;if(a.classList.contains("focus"))a.classList.remove("focus");else{for(e.preventDefault(),t=0;t<a.parentNode.children.length;++t)a!==a.parentNode.children[t]&&a.parentNode.children[t].classList.remove("focus");a.classList.add("focus")}},t=0;t<s.length;++t)s[t].addEventListener("touchstart",a,!1)}(a)}else s.style.display="none"}();