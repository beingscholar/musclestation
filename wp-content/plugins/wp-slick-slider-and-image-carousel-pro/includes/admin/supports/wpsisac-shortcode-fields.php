<?php
/**
 * Shortcode Fields for Shortcode Preview
 *
 * @package WP Slick Slider And Image Carousel Pro
 * @since 1.3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Generate 'slick_slider' shortcode fields for preview
 * 
 * @package WP Slick Slider And Image Carousel Pro
 * @since 1.3.3
 */
function slick_slider_shortcode_fields( $shortcode ) {

	$fields = array(
			// General fields
			'general' => array(
					'title'     => __('General Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'   	=>  array(
									// General settings
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'design',
										'value' 	=> array(
															'prodesign-1'	=> __( 'Slider Design 1', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-2'	=> __( 'Slider Design 2', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-3'	=> __( 'Slider Design 3', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-4'	=> __( 'Slider Design 4', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-5'	=> __( 'Slider Design 5', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-6'	=> __( 'Slider Design 6', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-7'	=> __( 'Slider Design 7', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-8'	=> __( 'Slider Design 8', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-9'	=> __( 'Slider Design 9', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-10'	=> __( 'Slider Design 10', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-11'	=> __( 'Slider Design 11', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-12'	=> __( 'Slider Design 12', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-13'	=> __( 'Slider Design 13', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-14'	=> __( 'Slider Design 14', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-15'	=> __( 'Slider Design 15', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-16'	=> __( 'Slider Design 16', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-17'	=> __( 'Slider Design 17', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-18'	=> __( 'Slider Design 18', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-19'	=> __( 'Slider Design 19', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-20'	=> __( 'Slider Design 20', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-21'	=> __( 'Slider Design 21', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-22'	=> __( 'Slider Design 22', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-23'	=> __( 'Slider Design 23', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-24'	=> __( 'Slider Design 24', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-25'	=> __( 'Slider Design 25', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-26'	=> __( 'Slider Design 26', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-27'	=> __( 'Slider Design 27', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-28'	=> __( 'Slider Design 28', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-29'	=> __( 'Slider Design 29', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-30'	=> __( 'Slider Design 30', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose design.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Content', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'show_content',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show content.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Read More', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'show_read_more',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Display read more.', 'wp-slick-slider-and-image-carousel' )
									),
									array(
										'type' 			=> 'text',
										'heading' 		=> __( 'Read More Text', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'read_more_text',
										'value' 		=> __('Read More' , 'wp-slick-slider-and-image-carousel'),
										'desc' 			=> __( 'Enter read more text.', 'wp-slick-slider-and-image-carousel' ),
										'refresh_time' 	=> 1000,
										'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
															),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Link Behaviour', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'link_target',
										'value' 	=> array(
															'self'	=> __( 'Same Window', 'wp-slick-slider-and-image-carousel' ),
															'blank'	=> __( 'New Window', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose link bahaviour.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Slider Image Height', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'sliderheight',
										'value' 	=> '',
										'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 250. Leave empty for default height.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type'		=> 'dropdown',
										'heading'	=> __( 'Image Fit', 'wp-slick-slider-and-image-carousel' ),
										'name'		=> 'image_fit',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Fill the post image in a whole container.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type'		=> 'text',
										'heading'	=> __( 'Image Size', 'wp-slick-slider-and-image-carousel'),
										'name'		=> 'image_size',
										'value' 	=> 'full',
										'desc' 		=> __( 'Choose WordPress registered image size. e.g', 'wp-slick-slider-and-image-carousel' ).' thumbnail, medium, large, full.',
									),
									array(
										'type' 			=> 'text',
										'heading' 		=> __( 'Extra Class', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'extra_class',
										'value' 		=> '',
										'refresh_time'	=> 1000,
										'desc' 			=> __( 'Enter extra CSS class for design customization.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
								),
			),
			
			//Slider Fields
			'slider' => array(
					'title'		=> __('Slider Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    => array(
									// Slider Setting
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Navigation Dots', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'dots',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show pagination dots.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Dots Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'dots_design',
										'value' 	=> array(
															'design-1'	=> __( 'Dots Design 1', 'wp-slick-slider-and-image-carousel' ),
															'design-2'	=> __( 'Dots Design 2', 'wp-slick-slider-and-image-carousel' ),
															'design-3'	=> __( 'Dots Design 3', 'wp-slick-slider-and-image-carousel' ),
															'design-4'	=> __( 'Dots Design 4', 'wp-slick-slider-and-image-carousel' ),
															'design-5'	=> __( 'Dots Design 5', 'wp-slick-slider-and-image-carousel' ),
															'design-6'	=> __( 'Dots Design 6', 'wp-slick-slider-and-image-carousel' ),
															'design-7'	=> __( 'Dots Design 7', 'wp-slick-slider-and-image-carousel' ),
															'design-8'	=> __( 'Dots Design 8', 'wp-slick-slider-and-image-carousel' ),
															'design-9'	=> __( 'Dots Design 9', 'wp-slick-slider-and-image-carousel' ),
															'design-10'	=> __( 'Dots Design 10', 'wp-slick-slider-and-image-carousel' ),
															'design-11'	=> __( 'Dots Design 11', 'wp-slick-slider-and-image-carousel' ),
															'design-12'	=> __( 'Dots Design 12', 'wp-slick-slider-and-image-carousel' ),
															),
										'desc' 		=> __( 'Choose dots design.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
																'element' 	=> 'dots',
																'value' 	=> array( 'true' ),
															),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Arrows', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'arrows',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show prev - next arrows.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Arrows Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'arrow_design',
										'value' 	=> array(
															'design-1'	=> __( 'Arrows Design 1', 'wp-slick-slider-and-image-carousel' ),
															'design-2'	=> __( 'Arrows Design 2', 'wp-slick-slider-and-image-carousel' ),
															'design-3'	=> __( 'Arrows Design 3', 'wp-slick-slider-and-image-carousel' ),
															'design-4'	=> __( 'Arrows Design 4', 'wp-slick-slider-and-image-carousel' ),
															'design-5'	=> __( 'Arrows Design 5', 'wp-slick-slider-and-image-carousel' ),
															'design-6'	=> __( 'Arrows Design 6', 'wp-slick-slider-and-image-carousel' ),
															'design-7'	=> __( 'Arrows Design 7', 'wp-slick-slider-and-image-carousel' ),
															'design-8'	=> __( 'Arrows Design 8', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose arrows design.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'arrows',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Autoplay', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'autoplay',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Enable autoplay.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Autoplay Interval', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'autoplay_interval',
										'value' 	=> 3000,
										'desc' 		=> __( 'Enter autoplay speed.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Speed', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'speed',
										'value' 	=> 600,
										'desc' 		=> __( 'Enter slider speed.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Fade Effect', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'fade',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'default'	=> 'false',
										'desc' 		=> __( 'Enable fade effect instead of slide effect.', 'wp-slick-slider-and-image-carousel' ),
										
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Loop', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'loop',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Enable infinite loop for continuous sliding.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Slider Navigation Columns', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'slider_nav_column',
										'value' 	=> 5,
										'desc' 		=> __( 'Enter slider navigation columns. Only applicable to Design 4,5,6.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'design',
															'value' 	=> array( 'prodesign-4', 'prodesign-5', 'prodesign-6' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Pause On Hover', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'hover_pause',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'dependency' 	=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
																),
										'desc' 		=> __( 'Pause slider autoplay on hover.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type'		=> 'dropdown',
										'heading'	=> __( 'Pause On Focus', 'wp-slick-slider-and-image-carousel' ),
										'name'		=> 'focus_pause',
										'value'		=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'default'	=> 'false',
										'dependency' 	=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
															),
										'desc'		=> __( 'Pause slider autoplay when slider element is focused.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type'		=> 'dropdown',
										'heading'	=> __( 'Slider Lazyload', 'wp-slick-slider-and-image-carousel' ),
										'name'		=> 'lazyload',
										'value'		=> array(
															''				=> __( 'Select Lazyload', 'wp-slick-slider-and-image-carousel' ),
															'ondemand'		=> __( 'Ondemand', 'wp-slick-slider-and-image-carousel' ),
															'progressive'	=> __( 'Progressive', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc'		=> __( 'Select option to use lazy loading in slider.', 'wp-slick-slider-and-image-carousel' ),
									),
								)
			),
			
			// Query Fields
			'query' => array(
					'title'		=> __('Query Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    => array(
									// Query Settings
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Total items', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'limit',
										'value' 	=> 15,
										'min'		=> -1,
										'desc' 		=> __( 'Enter number of slides to be displayed. Enter -1 to display all.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Post Order By', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'orderby',
										'value' 	=> array(
															'date'			=> __( 'Post Date', 'wp-slick-slider-and-image-carousel' ),
															'ID'			=> __( 'Post ID', 'wp-slick-slider-and-image-carousel' ),
															'author'		=> __( 'Post Author', 'wp-slick-slider-and-image-carousel' ),
															'title'			=> __( 'Post Title', 'wp-slick-slider-and-image-carousel' ),
															'modified'		=> __( 'Post Modified Date', 'wp-slick-slider-and-image-carousel' ),
															'rand'			=> __( 'Random', 'wp-slick-slider-and-image-carousel' ),
															'menu_order'	=> __( 'Menu Order', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Select order type.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Post Order', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'order',
										'value' 	=> array(
															'desc'	=> __( 'Descending', 'wp-slick-slider-and-image-carousel' ),
															'asc'	=> __( 'Ascending', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Select sorting order.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Display Specific Category', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'category',
										'value' 	=> '',
										'desc' 		=> __( 'Enter category id to display categories wise.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Include Category Children', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'include_cat_child',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'If you are using parent category then whether to display child category team member or not.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Exclude Category', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'exclude_cat',
										'value' 	=> '',
										'desc' 		=> __( 'Exclude post category. Works only if `Category` field is empty.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Display Specific Post', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'posts',
										'value' 	=> '',
										'desc' 		=> __('Enter id of the post which you want to display.', 'wp-slick-slider-and-image-carousel') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Exclude Post', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'exclude_post',
										'value' 	=> '',
										'desc' 		=> __('Enter id of the post which you do not want to display.', 'wp-slick-slider-and-image-carousel') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Query Offset', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'query_offset',
										'value' 	=> '',
										'desc' 		=> __( 'Exclude number of posts from starting.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
								)
			),
	);
	return $fields;
}
/**
 * Generate 'slick_carousel_slider' shortcode fields for preview
 * 
 * @package WP Slick Slider And Image Carousel Pro
 * @since 1.3.3
 */
function slick_carousel_slider_shortcode_fields( $shortcode ) {

	$fields = array(
			// General fields
			'general' => array(
					'title'     => __('General Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    =>  array(
									// General settings
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'design',
										'value' 	=> array(
															'prodesign-1'	=> __( 'Carousel Design 1', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-2'	=> __( 'Carousel Design 2', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-3'	=> __( 'Carousel Design 3', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-4'	=> __( 'Carousel Design 4', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-5'	=> __( 'Carousel Design 5', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-6'	=> __( 'Carousel Design 6', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-7'	=> __( 'Carousel Design 7', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-8'	=> __( 'Carousel Design 8', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-9'	=> __( 'Carousel Design 9', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-10'	=> __( 'Carousel Design 10', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-11'	=> __( 'Carousel Design 11', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-12'	=> __( 'Carousel Design 12', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-13'	=> __( 'Carousel Design 13', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-14'	=> __( 'Carousel Design 14', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-15'	=> __( 'Carousel Design 15', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-16'	=> __( 'Carousel Design 16', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-17'	=> __( 'Carousel Design 17', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-18'	=> __( 'Carousel Design 18', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-19'	=> __( 'Carousel Design 19', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-20'	=> __( 'Carousel Design 20', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-21'	=> __( 'Carousel Design 21', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-22'	=> __( 'Carousel Design 22', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-23'	=> __( 'Carousel Design 23', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-24'	=> __( 'Carousel Design 24', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-25'	=> __( 'Carousel Design 25', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-26'	=> __( 'Carousel Design 26', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-27'	=> __( 'Carousel Design 27', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-28'	=> __( 'Carousel Design 28', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-29'	=> __( 'Carousel Design 29', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-30'	=> __( 'Carousel Design 30', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose design.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Content', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'show_content',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Display content.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Read More', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'show_read_more',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Display read more.', 'wp-slick-slider-and-image-carousel' )
									),
									array(
										'type' 			=> 'text',
										'heading' 		=> __( 'Read More Text', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'read_more_text',
										'value' 		=> __( 'Read More', 'wp-slick-slider-and-image-carousel' ),
										'desc' 			=> __( 'Enter read more text.', 'wp-slick-slider-and-image-carousel' ),
										'refresh_time' 	=> 1000,
										'dependency'	=> array(
															'element' 	=> 'show_read_more',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Link Behaviour', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'link_target',
										'value' 	=> array(
															'self'	=> __( 'Same Window', 'wp-slick-slider-and-image-carousel' ),
															'blank'	=> __( 'New Window', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose link bahaviour.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Slider Image Height', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'sliderheight',
										'value' 	=> '',
										'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 250. Leave empty for default height.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Image Fit', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'image_fit',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Fill the post image in a whole container.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Image Size', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'image_size',
										'value' 	=> 'large',
										'desc' 		=> __( 'Choose WordPress registered image size. e.g', 'wp-slick-slider-and-image-carousel' ).' thumbnail, medium, large, full.',
									),
									array(
										'type' 			=> 'text',
										'heading' 		=> __( 'Extra Class', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'extra_class',
										'value' 		=> '',
										'refresh_time'	=> 1000,
										'desc'			=> __( 'Enter extra CSS class for design customization.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
								)
			),
			
			//Slider Fields
			'slider' => array(
					'title'		=> __('Slider Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    => array(
									// Slider Setting
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Navigation Dots', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'dots',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show pagination dots.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Dots Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'dots_design',
										'value' 	=> array(
															'design-1'	=> __( 'Dots Design 1', 'wp-slick-slider-and-image-carousel' ),
															'design-2'	=> __( 'Dots Design 2', 'wp-slick-slider-and-image-carousel' ),
															'design-3'	=> __( 'Dots Design 3', 'wp-slick-slider-and-image-carousel' ),
															'design-4'	=> __( 'Dots Design 4', 'wp-slick-slider-and-image-carousel' ),
															'design-5'	=> __( 'Dots Design 5', 'wp-slick-slider-and-image-carousel' ),
															'design-6'	=> __( 'Dots Design 6', 'wp-slick-slider-and-image-carousel' ),
															'design-7'	=> __( 'Dots Design 7', 'wp-slick-slider-and-image-carousel' ),
															'design-8'	=> __( 'Dots Design 8', 'wp-slick-slider-and-image-carousel' ),
															'design-9'	=> __( 'Dots Design 9', 'wp-slick-slider-and-image-carousel' ),
															'design-10'	=> __( 'Dots Design 10', 'wp-slick-slider-and-image-carousel' ),
															'design-11'	=> __( 'Dots Design 11', 'wp-slick-slider-and-image-carousel' ),
															'design-12'	=> __( 'Dots Design 12', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose dots design.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
																'element' 	=> 'dots',
																'value' 	=> array( 'true' ),
															),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Arrows', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'arrows',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show prev - next arrows.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Arrows Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'arrow_design',
										'value' 	=> array(
															'design-1'	=> __( 'Arrows Design 1', 'wp-slick-slider-and-image-carousel' ),
															'design-2'	=> __( 'Arrows Design 2', 'wp-slick-slider-and-image-carousel' ),
															'design-3'	=> __( 'Arrows Design 3', 'wp-slick-slider-and-image-carousel' ),
															'design-4'	=> __( 'Arrows Design 4', 'wp-slick-slider-and-image-carousel' ),
															'design-5'	=> __( 'Arrows Design 5', 'wp-slick-slider-and-image-carousel' ),
															'design-6'	=> __( 'Arrows Design 6', 'wp-slick-slider-and-image-carousel' ),
															'design-7'	=> __( 'Arrows Design 7', 'wp-slick-slider-and-image-carousel' ),
															'design-8'	=> __( 'Arrows Design 8', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose arrows design.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
																'element' 	=> 'arrows',
																'value' 	=> array( 'true' ),
															),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Slide To Show', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'slidestoshow',
										'value' 	=> 3,
										'desc' 		=> __( 'Enter number for Slide to show at a time.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Slide To Scroll', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'slidestoscroll',
										'value' 	=> 1,
										'desc' 		=> __( 'Enter number to scroll slider at a time.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Autoplay', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'autoplay',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Enable autoplay.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Autoplay Interval', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'autoplay_interval',
										'value' 	=> 3000,
										'desc' 		=> __( 'Enter autoplay speed.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Speed', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'speed',
										'value' 	=> 600,
										'desc' 		=> __( 'Enter slide speed.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Centermode', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'centermode',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'default'	=> 'false',
										'desc' 		=> __( 'Enable centered view with partial prev/next slides. Use with odd numbered `Slides to Scroll` and `Slider Column` counts.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Center Padding Slider', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'center_padding',
										'value' 	=> 0,
										'desc' 		=> __( 'You can set Center Padding in slider.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'centermode',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Loop', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'loop',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Enable infinite loop for continuous sliding.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Pause On Hover', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'hover_pause',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'dependency' 	=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
																),
										'desc' 		=> __( 'Pause slider autoplay on hover.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Pause On Focus', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'focus_pause',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'default'	=> 'false',
										'dependency' 	=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
															),
										'desc' 		=> __( 'Pause slider autoplay when slider element is focused.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type'		=> 'dropdown',
										'heading'	=> __( 'Slider Lazyload', 'wp-slick-slider-and-image-carousel' ),
										'name'		=> 'lazyload',
										'value'		=> array(
															''				=> __( 'Select Lazyload', 'wp-slick-slider-and-image-carousel' ),
															'ondemand'		=> __( 'Ondemand', 'wp-slick-slider-and-image-carousel' ),
															'progressive'	=> __( 'Progressive', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc'		=> __( 'Select option to use lazy loading in slider.', 'wp-slick-slider-and-image-carousel' ),
									),
								)
			),
			
			// Query Fields
			'query' => array(
					'title'		=> __('Query Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    => array(
									// Query Settings
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Total items', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'limit',
										'value' 	=> 15,
										'min'		=> -1,
										'desc' 		=> __( 'Enter number slides to be displayed. Enter -1 to display all.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Post Order By', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'orderby',
										'value' 	=> array(
															'date'		=> __( 'Post Date', 'wp-slick-slider-and-image-carousel' ) 	,
															'ID'		=> __( 'Post ID', 'wp-slick-slider-and-image-carousel' ) 		,
															'author'	=> __( 'Post Author', 'wp-slick-slider-and-image-carousel' ) 	,
															'title'		=> __( 'Post Title', 'wp-slick-slider-and-image-carousel' ) 	,
															'modified'	=> __( 'Post Modified Date', 'wp-slick-slider-and-image-carousel' ),
															'rand'		=> __( 'Random', 'wp-slick-slider-and-image-carousel' ) 		,
															'menu_order'=> __( 'Menu Order', 'wp-slick-slider-and-image-carousel' ) 	,
														),
										'desc' 		=> __( 'Select order type.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Post Order', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'order',
										'value' 	=> array(
															'desc'	=> __( 'Descending', 'wp-slick-slider-and-image-carousel' ),
															'asc'	=> __( 'Ascending', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Select sorting order.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Display Specific Category', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'category',
										'value' 	=> '',
										'desc' 		=> __( 'Enter category id to display categories wise.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Include Category Children', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'include_cat_child',
										'value' 	=> array(
																'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
																'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
																),
										'desc' 		=> __( 'If you are using parent category then whether to display child category team member or not.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Exclude Category', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'exclude_cat',
										'value' 	=> '',
										'desc' 		=> __( 'Exclude post category. Works only if `Category` field is empty.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Display Specific Post', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'posts',
										'value' 	=> '',
										'desc' 		=> __('Enter id of the post which you want to display.', 'wp-slick-slider-and-image-carousel') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Exclude Post', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'exclude_post',
										'value' 	=> '',
										'desc' 		=> __('Enter id of the post which you do not want to display.', 'wp-slick-slider-and-image-carousel') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Query Offset', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'query_offset',
										'value' 	=> '',
										'desc' 		=> __( 'Exclude number of posts from starting.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
								)
			),
	);
	return $fields;
}
/**
 * Generate 'slick_variable_slider' shortcode fields for preview
 * 
 * @package WP Slick Slider And Image Carousel Pro
 * @since 1.3.3
 */
function slick_variable_slider_shortcode_fields( $shortcode ) {

	$fields = array(
			// General fields
			'general' => array(
					'title'     => __('General Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    =>  array(
									// General settings
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'design',
										'value' 	=> array(
															'prodesign-1'	=> __( 'Variable Slider Design 1', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-2'	=> __( 'Variable Slider Design 2', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-3'	=> __( 'Variable Slider Design 3', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-4'	=> __( 'Variable Slider Design 4', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-5'	=> __( 'Variable Slider Design 5', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-6'	=> __( 'Variable Slider Design 6', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-7'	=> __( 'Variable Slider Design 7', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-8'	=> __( 'Variable Slider Design 8', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-9'	=> __( 'Variable Slider Design 9', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-10'	=> __( 'Variable Slider Design 10', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-11'	=> __( 'Variable Slider Design 11', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-12'	=> __( 'Variable Slider Design 12', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-13'	=> __( 'Variable Slider Design 13', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-14'	=> __( 'Variable Slider Design 14', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-15'	=> __( 'Variable Slider Design 15', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-16'	=> __( 'Variable Slider Design 16', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-17'	=> __( 'Variable Slider Design 17', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-18'	=> __( 'Variable Slider Design 18', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-19'	=> __( 'Variable Slider Design 19', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-20'	=> __( 'Variable Slider Design 20', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-21'	=> __( 'Variable Slider Design 21', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-22'	=> __( 'Variable Slider Design 22', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-23'	=> __( 'Variable Slider Design 23', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-24'	=> __( 'Variable Slider Design 24', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-25'	=> __( 'Variable Slider Design 25', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-26'	=> __( 'Variable Slider Design 26', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-27'	=> __( 'Variable Slider Design 27', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-28'	=> __( 'Variable Slider Design 28', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-29'	=> __( 'Variable Slider Design 29', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-30'	=> __( 'Variable Slider Design 30', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-31'	=> __( 'Variable Slider Design 31', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-32'	=> __( 'Variable Slider Design 32', 'wp-slick-slider-and-image-carousel' ),
															'prodesign-33'	=> __( 'Variable Slider Design 33', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose design.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Content', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'show_content',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Display content.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Show Read More', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'show_read_more',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Display read more.', 'wp-slick-slider-and-image-carousel' )
									),
									array(
										'type' 			=> 'text',
										'heading' 		=> __( 'Read More Text', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'read_more_text',
										'value' 		=> __('Read More', 'wp-slick-slider-and-image-carousel'),
										'desc' 			=> __( 'Enter read more text.', 'wp-slick-slider-and-image-carousel' ),
										'refresh_time' 	=> 1000,
										'dependency'	=> array(
															'element' 	=> 'show_read_more',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Link Behaviour', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'link_target',
										'value' 	=> array(
															'self'	=> __( 'Same Window', 'wp-slick-slider-and-image-carousel' ),
															'blank'	=> __( 'New Window', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose link bahaviour.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Slider Image Height', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'sliderheight',
										'value' 	=> '',
										'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 250. Leave empty for default height.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Image Fit', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'image_fit',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Fill the post image in a whole container.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Image Size', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'image_size',
										'value' 	=> 'full',
										'desc' 		=> __( 'Choose WordPress registered image size. e.g', 'wp-slick-slider-and-image-carousel' ).' thumbnail, medium, large, full.',
									),
									array(
										'type' 			=> 'text',
										'heading' 		=> __( 'Extra Class', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'extra_class',
										'value' 		=> '',
										'refresh_time' 	=> 1000,
										'desc' 			=> __( 'Enter extra CSS class for design customization.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),	
								)
			),
			
			// slider Fields
			'slider' => array(
					'title'		=> __('Slider Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    => array(
									// Slide Settings
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Navigation Dots', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'dots',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show slider pagination dots.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Dots Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'dots_design',
										'value' 	=> array(
															'design-1'	=> __( 'Dots Design 1', 'wp-slick-slider-and-image-carousel' ),
															'design-2'	=> __( 'Dots Design 2', 'wp-slick-slider-and-image-carousel' ),
															'design-3'	=> __( 'Dots Design 3', 'wp-slick-slider-and-image-carousel' ),
															'design-4'	=> __( 'Dots Design 4', 'wp-slick-slider-and-image-carousel' ),
															'design-5'	=> __( 'Dots Design 5', 'wp-slick-slider-and-image-carousel' ),
															'design-6'	=> __( 'Dots Design 6', 'wp-slick-slider-and-image-carousel' ),
															'design-7'	=> __( 'Dots Design 7', 'wp-slick-slider-and-image-carousel' ),
															'design-8'	=> __( 'Dots Design 8', 'wp-slick-slider-and-image-carousel' ),
															'design-9'	=> __( 'Dots Design 9', 'wp-slick-slider-and-image-carousel' ),
															'design-10'	=> __( 'Dots Design 10', 'wp-slick-slider-and-image-carousel' ),
															'design-11'	=> __( 'Dots Design 11', 'wp-slick-slider-and-image-carousel' ),
															'design-12'	=> __( 'Dots Design 12', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose dots design.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'dots',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Arrows', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'arrows',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Show Prev - Next arrows.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Arrows Design', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'arrow_design',
										'value' 	=> array(
															'design-1'	=> __( 'Arrows Design 1', 'wp-slick-slider-and-image-carousel' ),
															'design-2'	=> __( 'Arrows Design 2', 'wp-slick-slider-and-image-carousel' ),
															'design-3'	=> __( 'Arrows Design 3', 'wp-slick-slider-and-image-carousel' ),
															'design-4'	=> __( 'Arrows Design 4', 'wp-slick-slider-and-image-carousel' ),
															'design-5'	=> __( 'Arrows Design 5', 'wp-slick-slider-and-image-carousel' ),
															'design-6'	=> __( 'Arrows Design 6', 'wp-slick-slider-and-image-carousel' ),
															'design-7'	=> __( 'Arrows Design 7', 'wp-slick-slider-and-image-carousel' ),
															'design-8'	=> __( 'Arrows Design 8', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Choose arrows design.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
																'element' 	=> 'arrows',
																'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Autoplay', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'autoplay',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Enable autoplay.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Autoplay Interval', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'autoplay_interval',
										'value' 	=> 3000,
										'desc' 		=> __( 'Enter autoplay speed.', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
														),
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Speed', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'speed',
										'value' 	=> 600,
										'desc' 		=> __( 'Enter slide speed.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Slider Variable Width', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'var_width',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'default'	=> 'false',
										'desc' 		=> __( 'Enable slider variable width.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Center Slide Width', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'center_width',
										'value' 	=> '70%',
										'desc' 		=> __( 'Enter center slide width. Leave empty for default width. e.g 70% or 500px', 'wp-slick-slider-and-image-carousel' ),
										'dependency'=> array(
															'element' 	=> 'var_width',
															'value' 	=> array( 'false' ),
														),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Loop', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'loop',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Enable infinite loop for continuous sliding.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 			=> 'dropdown',
										'heading' 		=> __( 'Pause On Hover', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'hover_pause',
										'value' 		=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'dependency' 	=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
																),
										'desc' 			=> __( 'Pause slider autoplay on hover.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 			=> 'dropdown',
										'heading' 		=> __( 'Pause On Focus', 'wp-slick-slider-and-image-carousel' ),
										'name' 			=> 'focus_pause',
										'value' 		=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ),
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'default'		=> 'false',
										'dependency' 	=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
															),
										'desc' 			=> __( 'Pause slider autoplay when slider element is focused.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type'		=> 'dropdown',
										'heading'	=> __( 'Slider Lazyload', 'wp-slick-slider-and-image-carousel' ),
										'name'		=> 'lazyload',
										'value'		=> array(
															''				=> __( 'Select Lazyload', 'wp-slick-slider-and-image-carousel' ),
															'ondemand'		=> __( 'Ondemand', 'wp-slick-slider-and-image-carousel' ),
															'progressive'	=> __( 'Progressive', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc'		=> __( 'Select option to use lazy loading in slider.', 'wp-slick-slider-and-image-carousel' ),
									),
								)
			),
			// Query Fields
			'query' => array(
					'title'		=> __('Query Parameters', 'wp-slick-slider-and-image-carousel'),
					'params'    => array(
									// Query Setting
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Total items', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'limit',
										'value' 	=> 15,
										'min'		=> -1,
										'desc' 		=> __( 'Enter number to be displayed. Enter -1 to display all.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Post Order By', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'orderby',
										'value' 	=> array(
															'date'		=> __( 'Post Date', 'wp-slick-slider-and-image-carousel' ) 	,
															'ID'		=> __( 'Post ID', 'wp-slick-slider-and-image-carousel' ) 		,
															'author'	=> __( 'Post Author', 'wp-slick-slider-and-image-carousel' ) 	,
															'title'		=> __( 'Post Title', 'wp-slick-slider-and-image-carousel' ) 	,
															'modified'	=> __( 'Post Modified Date', 'wp-slick-slider-and-image-carousel' ),
															'rand'		=> __( 'Random', 'wp-slick-slider-and-image-carousel' ) 		,
															'menu_order'=> __( 'Menu Order', 'wp-slick-slider-and-image-carousel' ) 	,
														),
										'desc' 		=> __( 'Select order type.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Post Order', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'order',
										'value' 	=> array(
															'desc'	=> __( 'Descending', 'wp-slick-slider-and-image-carousel' ),
															'asc'	=> __( 'Ascending', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'Select sorting order.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Display Specific Category', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'category',
										'value' 	=> '',
										'desc' 		=> __( 'Enter category id to display categories wise.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'dropdown',
										'heading' 	=> __( 'Include Category Children', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'include_cat_child',
										'value' 	=> array(
															'true'	=> __( 'True', 'wp-slick-slider-and-image-carousel' ) ,
															'false'	=> __( 'False', 'wp-slick-slider-and-image-carousel' ),
														),
										'desc' 		=> __( 'If you are using parent category then whether to display child category team member or not.', 'wp-slick-slider-and-image-carousel' ),
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Exclude Category', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'exclude_cat',
										'value' 	=> '',
										'desc' 		=> __( 'Exclude post category. Works only if `Category` field is empty.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Display Specific Post', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'posts',
										'value' 	=> '',
										'desc' 		=> __('Enter id of the post which you want to display.', 'wp-slick-slider-and-image-carousel') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'text',
										'heading' 	=> __( 'Exclude Post', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'exclude_post',
										'value' 	=> '',
										'desc' 		=> __('Enter id of the post which you do not want to display.', 'wp-slick-slider-and-image-carousel') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
									array(
										'type' 		=> 'number',
										'heading' 	=> __( 'Query Offset', 'wp-slick-slider-and-image-carousel' ),
										'name' 		=> 'query_offset',
										'value' 	=> '',
										'desc' 		=> __( 'Exclude number of posts from starting.', 'wp-slick-slider-and-image-carousel' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'wp-slick-slider-and-image-carousel').'"> [?]</label>',
									),
								)
			),
	);
	return $fields;
}