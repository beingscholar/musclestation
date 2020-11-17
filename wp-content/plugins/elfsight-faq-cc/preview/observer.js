(function(window){"use strict";/*!
 * 
 * 	elfsight.com
 * 
 * 	Copyright (c) 2020 Elfsight, LLC. ALL RIGHTS RESERVED
 * 
 */
!function(t){var e={};function o(i){if(e[i])return e[i].exports;var r=e[i]={i:i,l:!1,exports:{}};return t[i].call(r.exports,r,r.exports,o),r.l=!0,r.exports}o.m=t,o.c=e,o.d=function(t,e,i){o.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:i})},o.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return o.d(e,"a",e),e},o.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},o.p="",o(o.s=0)}([function(t,e){(window.eapps=window.eapps||{}).observer=function(t,e,o){var i;t.$watch("widget.data.layout",function(){"accordion"===t.widget.data.layout?t.setPropertyVisibility("accordionIcon",!0):t.setPropertyVisibility("accordionIcon",!1)}),t.$watch("widget.data.displayCategoriesNames",function(){t.widget.data.displayCategoriesNames?t.setPropertyVisibility("categoryTextColor",!0):t.setPropertyVisibility("categoryTextColor",!1)}),t.$watch("widget.data.template",function(){"clean"===t.widget.data.template?(i=t.widget.data.itemBackgroundColor,t.widget.data.itemBackgroundColor="",t.setPropertyVisibility("itemBackgroundColor",!1)):(i&&(t.widget.data.itemBackgroundColor=i),t.setPropertyVisibility("itemBackgroundColor",!0))})}}]);})(window)