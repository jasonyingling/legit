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
	 * Sets or removes .focus class on an element in widgets
	 */function a(){
// Move up through the ancestors of the current link until we hit .nav-menu.
for(var e=this;-1===e.className.indexOf("widget");)
// On li elements toggle the class .focus.
"li"===e.tagName.toLowerCase()&&(-1!==e.className.indexOf("focus")?e.className=e.className.replace(" focus",""):e.className+=" focus"),e=e.parentElement}
/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */var t,s,n,l,i,c,o,r,d;if(s=document.getElementsByTagName("html")[0],t=document.getElementById("site-navigation"),
/**
	 * Setting up the .focus to work on widgets too
	 */
r=document.getElementsByClassName("widget_categories"),t||r){for(j=0,o=r.length;j<o-1;j++)if(r[j]&&1<r[j].getElementsByTagName("ul").length)for(d=r[j].getElementsByTagName("ul")[0],linksWidget=d.getElementsByTagName("a"),k=0,o=linksWidget.length;k<o;k++)linksWidget[k].addEventListener("focus",a,!0),linksWidget[k].addEventListener("blur",a,!0);if(void 0!==(n=t.getElementsByTagName("button")[0]))
// Hide menu toggle button if menu is empty and return early.
if(void 0!==(l=t.getElementsByTagName("ul")[0])){
// Each time a menu link is focused or blurred, toggle focus.
for(l.setAttribute("aria-expanded","false"),-1===l.className.indexOf("nav-menu")&&(l.className+=" nav-menu"),n.onclick=function(){-1!==t.className.indexOf("toggled")?(t.className=t.className.replace(" toggled",""),s.className=s.className.replace(" show-nav",""),n.setAttribute("aria-expanded","false"),l.setAttribute("aria-expanded","false")):(t.className+=" toggled",s.className+=" show-nav",n.setAttribute("aria-expanded","true"),l.setAttribute("aria-expanded","true"))},c=0,o=(
// Get all the link elements within the menu.
i=l.getElementsByTagName("a")).length;c<o;c++)i[c].addEventListener("focus",e,!0),i[c].addEventListener("blur",e,!0);
/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
!function(e){var a,t,s=e.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");if("ontouchstart"in window)for(a=function(e){var a=this.parentNode,t;if(a.classList.contains("focus"))a.classList.remove("focus");else{for(e.preventDefault(),t=0;t<a.parentNode.children.length;++t)a!==a.parentNode.children[t]&&a.parentNode.children[t].classList.remove("focus");a.classList.add("focus")}},t=0;t<s.length;++t)s[t].addEventListener("touchstart",a,!1)}(t)}else n.style.display="none"}}();