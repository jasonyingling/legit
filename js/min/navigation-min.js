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
	 * Sets or removes .focused class on an element.
	 */function a(){var e=this;(e=e.parentElement).classList.toggle("nav-open")}
/**
	 * Sets or removes .focus class on an element in widgets
	 */function t(){
// Move up through the ancestors of the current link until we hit .nav-menu.
for(var e=this;-1===e.className.indexOf("widget");)
// On li elements toggle the class .focus.
"li"===e.tagName.toLowerCase()&&(-1!==e.className.indexOf("focus")?e.className=e.className.replace(" focus",""):e.className+=" focus"),e=e.parentElement}
/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */var s,n,l,i,c,o,r,d,m,g,u,f,N;if(n=document.getElementsByTagName("html")[0],s=document.getElementById("site-navigation"),
/**
	 * Setting up the .focus to work on widgets too
	 */
f=document.getElementsByClassName("widget_categories"),s||f){for(d=0,u=f.length;d<u-1;d++)if(f[d]&&1<f[d].getElementsByTagName("ul").length)for(N=f[d].getElementsByTagName("ul")[0],linksWidget=N.getElementsByTagName("a"),m=0,u=linksWidget.length;m<u;m++)linksWidget[m].addEventListener("focus",t,!0),linksWidget[m].addEventListener("blur",t,!0);if(void 0!==(l=s.getElementsByClassName("menu-toggle")[0]))
// Hide menu toggle button if menu is empty and return early.
if(void 0!==(i=s.getElementsByTagName("ul")[0])){
// Each time a menu link is focused or blurred, toggle focus.
for(i.setAttribute("aria-expanded","false"),-1===i.className.indexOf("nav-menu")&&(i.className+=" nav-menu"),l.onclick=function(){-1!==s.className.indexOf("toggled")?(s.className=s.className.replace(" toggled",""),n.className=n.className.replace(" show-nav",""),l.setAttribute("aria-expanded","false"),i.setAttribute("aria-expanded","false")):(s.className+=" toggled",n.className+=" show-nav",l.setAttribute("aria-expanded","true"),i.setAttribute("aria-expanded","true"))},r=0,u=(
// Get all the link elements within the menu.
c=i.getElementsByTagName("a")).length;r<u;r++)c[r].addEventListener("focus",e,!0),c[r].addEventListener("blur",e,!0);for(o=i.getElementsByTagName("button"),g=0,u=c.length;g<u-1;g++)o[g]&&o[g].addEventListener("click",a,!0);
/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
!function(e){var a,t,s=e.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");if("ontouchstart"in window)for(a=function(e){var a=this.parentNode,t;if(a.classList.contains("focus"))a.classList.remove("focus");else{for(e.preventDefault(),t=0;t<a.parentNode.children.length;++t)a!==a.parentNode.children[t]&&a.parentNode.children[t].classList.remove("focus");a.classList.add("focus")}},t=0;t<s.length;++t)s[t].addEventListener("touchstart",a,!1)}(s)}else l.style.display="none"}}();