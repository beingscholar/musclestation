=== WP Slick Slider and Image Carousel Pro  ===
Contributors: wponlinesupport
Tags: slick, image slider, slick slider, slick image slider, slider, image slider, header image slider, responsive image slider, responsive content slider, carousel, image carousel, carousel slider, content slider, coin slider, touch slider, text slider, responsive slider, responsive slideshow, Responsive Touch Slider, wp slider, wp image slider, wp header image slider, photo slider, responsive photo slider  
Requires at least: 3.5
Tested up to: 5.3.2
Author URI: https://www.wponlinesupport.com

A quick, easy way to add and display multiple WP Slick Slider and carousel using a shortcode.

== Description ==

Display multiple slick image slider and carousel using shortcode with category. Fully responsive, Swipe enabled, Desktop mouse dragging and  Infinite looping.
Fully accessible with arrow key navigation  Autoplay, dots, arrows etc.

It uses a custom post type and taxonomy to create a slider, with almost unlimited options and support for multiple sliders on any page.
You can also display image slider on your website header.

= You can use 3 shortcodes =

<code>[slick-slider]</code> - Slick Slider
<code>[slick-carousel-slider]</code> - Slick Carousel Slider
<code>[slick-variable-slider]</code> - Slick Variable Slider

= Here is Template code =

<code><?php echo do_shortcode('[slick-slider]'); ?></code>
<code><?php echo do_shortcode('[slick-carousel-slider]'); ?></code>
<code><?php echo do_shortcode('[slick-variable-slider]'); ?></code>

= Features include =

* Display unlimited number of slider and carousel with the help of category.
* Touch-enabled Navigation.
* Fully responsive. Scales with its container.
* Fully accessible with arrow key navigation.
* Responsive
* Given shortcode and template code.
* Use for header image slider.

== Installation ==

1. Upload the 'wp-slick-slider-and-carousel-pro' folder to the '/wp-content/plugins/' directory.
2. Activate the "wp-slick-slider-and-carousel-pro" list plugin through the 'Plugins' menu in WordPress.
3. Add this short code where you want to display slider

<code>[slick-slider], [slick-carousel-slider] and [slick-variable-slider]</code>

== Changelog ==

= 1.5.2 (04, March 2019) =
* [+] New - Added 'lazyload' shortcode parameter for all slider shortcodes. Now you can able to set lazy loading in two different method lazyload="ondemand" OR lazyload="progressive".
* [+] Update - Minified some CSS and JS.
* [*] Fix - Minor CSS Changes.
* [*] Template File - Major template file has been updated. If you have override template file then verify with latest copy.

= 1.5.1 (03, Dec 2019) =
* [*] Fix - Minor CSS Changes.

= 1.5 (02, Dec 2019) =
* [+] New - Added Gutenberg block. Now use plugin easily with Gutenberg!
* [+] New - Added 'hover_pause' and 'focus_pause' shortcode parameter for all slider shortcodes. Now you can pause the slider on mouse hover and slider element focus.
* [+] New - Added 'centermode' shortcode parameter for '[slick-carousel-slider]' slider shortcode.
* [*] Fix - Resolved title color issue and title designing issue when title link is not applied.
* [*] Fix - Resolved hover issue in WordPress defualt theme "Twenty Ninteen".
* [+] Update - Minified some CSS and JS.
* [*] Tweak - Pagination will if page is divided into multiple pages with <!--nextpage--> tag.
* [*] Tweak - Pagination will work on single post also.
* [*] Tweak - Code optimization and performance improvements.
* [*] Template File - Major template file has been updated. If you have override template file then verify with latest copy.

= 1.4 (06, Sep 2018) =
* [+] New - Added Templating feature. Now you can override plugin design from your current theme!!
* [+] New - Added 'query_offset' parameter for shortcodes.
* [*] Tweak - Taken better care of Post Title as image ALT tag.

= 1.3.4 (30, April 2018) =
* [*] Resolved - "Show Read More" button parameter not working in some designs.
* [*] Resolved - Slide Content not supported in some designs.

= 1.3.3 (20, March 2018) =
* [+] Introduced 'Shortcode Generator' functionality with Preview Panel.
* [+] Added 'extra_class' shortcode parameter in plugin shortcode. Now you can add your extra class and use it for custom designing.
* [*] Used 'wp_reset_postdata' instead of 'wp_reset_query'.
* [*] Fixed some minor designing issues.

= 1.3.2.1 (21, Dec 2017) =
* [+] Added new shortcode parameter var_width="true" or var_width="false" for <code>[slick-variable-slider]</code> Shortcode.
	  Note : This parameter will not work well with following designs : 17 to 21, 23 to 30

= 1.3.2 (6, July 2017) =
* [+] Added new 6 designs in <code>[slick-slider] from prodesign-11 to prodesign-16 </code> (Now total 30 designs)
* [+] Added new 10 designs in <code>[slick-carousel-slider]  from prodesign-1 to prodesign-10</code> (Now total 30 designs)
* [+] Added new 11 designs in <code>[slick-variable-slider]  from prodesign-1 to prodesign-10 and prodesign-13 </code> (Now total 33 designs)
* [+] Added new shortcode parameter image_fit="false" OR image_fit="true".
* [*] Fixed all design issues.

= 1.3.1 (03, Feb 2017) =
* [+] Added 'arrow_design' shortcode parameter to choose different slider arrow style.
* [+] Added 'dots_design' shortcode parameter to choose different slider dots style.
* [+] Added 'center_width' shortcode parameter for [slick-variable-slider] to control center slide width.
* [+] Added 5 more designs for [slick-variable-slider]
* [*] Updated plugin translation code. Now user can put plugin languages file in WordPress 'language' folder so plugin language file will not be loss while plugin update.
* [*] Resolved 'sliderheight' issue. In some designs 'sliderheight' parameter is not working.
* [*] Improved some variable slider designs for better look.
* [*] Optimized some CSS.

= 1.3 (10, Nov 2016) =
* [+] Added 'How it Work' page for better user interface.
* [-] Removed 'Plugin Design' page.
* [*] Optimized some CSS.

= 1.2.9 (07, Nov 2016) =
* [*] Resolved some design bug.
* [*] Optimized CSS.

= 1.2.8 (05, Nov 2016) =
* [+] Added 9 new designs for slider, carousel and variable width.
* [*] Optimized CSS.

= 1.2.7 (20, Oct 2016) =
*[+] Added new design (design-21). It is a design from free plugin of slick slider(design-3) and added as per user request.

= 1.2.6 (12, Sep 2016) =
* [*] Removed plugin license page from plugin section and added in 'Slick Slider Pro' menu.
* [*] Updated plugin license page.
* Added SSL to https://www.wponlinesupport.com/ for secure updates.

= 1.2.5 (July, 20 2016) =
* [+] Added new designs.
* [+] Added new shortcode 'slick-variable-slider' for variable slider.
* [+] Added Visual Composer page builder support.
* [+] Added Drag & Drop feature to display slides in your desired order.
* [+] Added 'link_target' short code parameter for link behavior.
* [+] Added 'order' short code parameter for post ordering.
* [+] Added 'orderby' short code parameter for post order by.
* [+] Added 'posts' short code parameter to display only some specific post.
* [+] Added 'exclude_cat' short code parameter to exclude some category.
* [+] Added 'sliderheight' short code parameter for 'slick-carousel-slider' to control slider height.
* [+] Added default post featured image settings.
* [+] Added custom CSS setting for plugin.
* [+] Added some useful plugin links for user at plugins page.
* [+] Added 'read_more_text' short code parameter to change read more button text.
* [+] Added 'include_cat_child' short code parameter to show child category post or not.
* [+] Added 'loop' short code parameter to run slider continuously.
* [+] Added RTL support for slider.
* [*] Updated slider js to new version.
* [*] Improved designs.
* [*] Improved PRO plugin design page.
* [*] Improved plugin license page with instruction.
* [*] Optimized js for better performance.
* [*] Improved CSS to display images properly. Optimized CSS.
* [*] Optimized code.

= 1.2.4 (13, May 2016) =
* [*] Added new feature variable width for carousel slider.

= 1.2.3 (13, APR 2016) =
* [*] Fixed some css issues.
* [*] Resolved slick slider initialize issue.

= 1.2.2 =
* Added 'show_read_more' and 'slider_nav_column' shortcode parameter.
* Added anchor link on images, content and title.
* Fixed some css issues.

= 1.2.1 =
* Fixed some css issues.
* Fixed responsive issue.

= 1.2 =
* Fixed some css issues.
* Resolved multiple slider jquery conflict issue.

= 1.1 =
* Fixed some bugs.

= 1.0 =
* Initial release.