<?php
/**
 * Plugin generic functions file
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update default settings
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_default_settings() {

	global $wpsisac_pro_options;

	$wpsisac_pro_options = array(
		'default_img' => '',
		'custom_css'  => '',
	);

	$default_options = apply_filters('wpsisac_pro_options_default_values', $wpsisac_pro_options );

	// Update default options
	update_option( 'wpsisac_pro_options', $default_options );

	// Overwrite global variable when option is update
	$wpsisac_pro_options = wpsisac_pro_get_settings();
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_get_settings() {

	$options 	= get_option('wpsisac_pro_options');
	$settings 	= is_array($options)  ? $options : array();

	return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_get_option( $key = '', $default = false ) {
	global $wpsisac_pro_options;

	$value = ! empty( $wpsisac_pro_options[ $key ] ) ? $wpsisac_pro_options[ $key ] : $default;
	$value = apply_filters( 'wpsisac_pro_get_option', $value, $key, $default );

	return apply_filters( 'wpsisac_pro_get_option_' . $key, $value, $key, $default );
}

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_esc_attr($data) {
	return esc_attr( stripslashes($data) );
}

/**
 * Sanitize Multiple HTML class
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.4
 */
function wpsisac_sanitize_html_classes($classes, $sep = " ") {
	$return = "";

	if( $classes && !is_array($classes) ) {
		$classes = explode($sep, $classes);
	}

	if( !empty($classes) ) {
		foreach($classes as $class){
			$return .= sanitize_html_class($class) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Sanitize URL
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0
 */
function wpsisac_pro_clean_url( $url ) {
	return esc_url_raw( trim($url) );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.3.5
 */
function wpsisac_pro_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'wpsisac_pro_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0
 */
function wpsisac_pro_clean_number( $var, $fallback = null, $type = 'int' ) {

	if ( $type == 'number' ) {
		$data = intval( $var );
	} else {
		$data = absint( $var );
	}

	return ( empty($data) && isset($fallback) ) ? $fallback : $data;
}

/**
 * Function to unique number value
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2
 */
function wpsisac_pro_get_unique() {
	static $unique = 0;
	$unique++;

	return $unique;
}

/**
 * Function to add array after specific key
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count 	= count($array);
			$index 			= (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
		}

		$split_arr  = array_splice($array, max(0, $index));
		$array 		= array_merge( $array, $value, $split_arr);
	}

	return $array;
}

/**
 * Function to get post featured image
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_get_post_featured_image( $post_id = '', $size = 'full', $default_img = false ) {
	$size   = !empty($size) ? $size : 'full';
	$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( !empty($image) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	// Getting default image
	if( $default_img && empty($image) ) {
		$image = wpsisac_pro_get_option( 'default_img' );
	}

	return $image;
}

/**
 * Function to get 'Nav slider desidn' shortcode designs
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.5
 */
function wpsisac_pro_slider_nav_designs() {
	return apply_filters('wpsisac_pro_slider_nav_designs', array( 'prodesign-4', 'prodesign-5', 'prodesign-6' ) );
}

/**
 * Function to get `slick-slider` shortcode designs
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_slider_designs() {
	$design_arr = array(
		'prodesign-1'	=> __('Design 1', 'wp-slick-slider-and-image-carousel'),
		'prodesign-2'	=> __('Design 2', 'wp-slick-slider-and-image-carousel'),
		'prodesign-3'	=> __('Design 3', 'wp-slick-slider-and-image-carousel'),
		'prodesign-4'	=> __('Design 4', 'wp-slick-slider-and-image-carousel'),
		'prodesign-5'	=> __('Design 5', 'wp-slick-slider-and-image-carousel'),
		'prodesign-6'	=> __('Design 6', 'wp-slick-slider-and-image-carousel'),
		'prodesign-7'	=> __('Design 7', 'wp-slick-slider-and-image-carousel'),
		'prodesign-8'	=> __('Design 8', 'wp-slick-slider-and-image-carousel'),
		'prodesign-9'	=> __('Design 9', 'wp-slick-slider-and-image-carousel'),
		'prodesign-10'	=> __('Design 10', 'wp-slick-slider-and-image-carousel'),
		'prodesign-11'	=> __('Design 11', 'wp-slick-slider-and-image-carousel'),
		'prodesign-12'	=> __('Design 12', 'wp-slick-slider-and-image-carousel'),
		'prodesign-13'	=> __('Design 13', 'wp-slick-slider-and-image-carousel'),
		'prodesign-14'	=> __('Design 14', 'wp-slick-slider-and-image-carousel'),
		'prodesign-15'	=> __('Design 15', 'wp-slick-slider-and-image-carousel'),
		'prodesign-16'	=> __('Design 16', 'wp-slick-slider-and-image-carousel'),
		'prodesign-17'	=> __('Design 17', 'wp-slick-slider-and-image-carousel'),
		'prodesign-18'	=> __('Design 18', 'wp-slick-slider-and-image-carousel'),
		'prodesign-19'	=> __('Design 19', 'wp-slick-slider-and-image-carousel'),
		'prodesign-20'	=> __('Design 20', 'wp-slick-slider-and-image-carousel'),
		'prodesign-21'	=> __('Design 21', 'wp-slick-slider-and-image-carousel'),
		'prodesign-22'	=> __('Design 22', 'wp-slick-slider-and-image-carousel'),
		'prodesign-23'	=> __('Design 23', 'wp-slick-slider-and-image-carousel'),
		'prodesign-24'	=> __('Design 24', 'wp-slick-slider-and-image-carousel'),
		'prodesign-25'	=> __('Design 25', 'wp-slick-slider-and-image-carousel'),
		'prodesign-26'	=> __('Design 26', 'wp-slick-slider-and-image-carousel'),
		'prodesign-27'	=> __('Design 27', 'wp-slick-slider-and-image-carousel'),
		'prodesign-28'	=> __('Design 28', 'wp-slick-slider-and-image-carousel'),
		'prodesign-29'	=> __('Design 29', 'wp-slick-slider-and-image-carousel'),
		'prodesign-30'	=> __('Design 30', 'wp-slick-slider-and-image-carousel'),
	);
	return apply_filters('wpsisac_pro_slider_designs', $design_arr );
}

/**
 * Function to get `slick-carousel-slider` shortcode designs
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_carousel_designs() {
	$design_arr = array(
		'prodesign-1'	=> __('Design 1', 'wp-slick-slider-and-image-carousel'),
		'prodesign-2'	=> __('Design 2', 'wp-slick-slider-and-image-carousel'),
		'prodesign-3'	=> __('Design 3', 'wp-slick-slider-and-image-carousel'),
		'prodesign-4'	=> __('Design 4', 'wp-slick-slider-and-image-carousel'),
		'prodesign-5'	=> __('Design 5', 'wp-slick-slider-and-image-carousel'),
		'prodesign-6'	=> __('Design 6', 'wp-slick-slider-and-image-carousel'),
		'prodesign-7'	=> __('Design 7', 'wp-slick-slider-and-image-carousel'),
		'prodesign-8'	=> __('Design 8', 'wp-slick-slider-and-image-carousel'),
		'prodesign-9'	=> __('Design 9', 'wp-slick-slider-and-image-carousel'),
		'prodesign-10'	=> __('Design 10', 'wp-slick-slider-and-image-carousel'),
		'prodesign-11'	=> __('Design 11', 'wp-slick-slider-and-image-carousel'),
		'prodesign-12'	=> __('Design 12', 'wp-slick-slider-and-image-carousel'),
		'prodesign-13'	=> __('Design 13', 'wp-slick-slider-and-image-carousel'),
		'prodesign-14'	=> __('Design 14', 'wp-slick-slider-and-image-carousel'),
		'prodesign-15'	=> __('Design 15', 'wp-slick-slider-and-image-carousel'),
		'prodesign-16'	=> __('Design 16', 'wp-slick-slider-and-image-carousel'),
		'prodesign-17'	=> __('Design 17', 'wp-slick-slider-and-image-carousel'),
		'prodesign-18'	=> __('Design 18', 'wp-slick-slider-and-image-carousel'),
		'prodesign-19'	=> __('Design 19', 'wp-slick-slider-and-image-carousel'),
		'prodesign-20'	=> __('Design 20', 'wp-slick-slider-and-image-carousel'),
		'prodesign-21'	=> __('Design 21', 'wp-slick-slider-and-image-carousel'),
		'prodesign-22'	=> __('Design 22', 'wp-slick-slider-and-image-carousel'),
		'prodesign-23'	=> __('Design 23', 'wp-slick-slider-and-image-carousel'),
		'prodesign-24'	=> __('Design 24', 'wp-slick-slider-and-image-carousel'),
		'prodesign-25'	=> __('Design 25', 'wp-slick-slider-and-image-carousel'),
		'prodesign-26'	=> __('Design 26', 'wp-slick-slider-and-image-carousel'),
		'prodesign-27'	=> __('Design 27', 'wp-slick-slider-and-image-carousel'),
		'prodesign-28'	=> __('Design 28', 'wp-slick-slider-and-image-carousel'),
		'prodesign-29'	=> __('Design 29', 'wp-slick-slider-and-image-carousel'),
		'prodesign-30'	=> __('Design 30', 'wp-slick-slider-and-image-carousel'),
	);
	return apply_filters('wpsisac_pro_carousel_designs', $design_arr );
}

/**
 * Function to get `slick-variable-slider` shortcode designs
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */
function wpsisac_pro_variable_designs() {
	$design_arr = array(
		'prodesign-1'	=> __('Design 1', 'wp-slick-slider-and-image-carousel'),
		'prodesign-2'	=> __('Design 2', 'wp-slick-slider-and-image-carousel'),
		'prodesign-3'	=> __('Design 3', 'wp-slick-slider-and-image-carousel'),
		'prodesign-4'	=> __('Design 4', 'wp-slick-slider-and-image-carousel'),
		'prodesign-5'	=> __('Design 5', 'wp-slick-slider-and-image-carousel'),
		'prodesign-6'	=> __('Design 6', 'wp-slick-slider-and-image-carousel'),
		'prodesign-7'	=> __('Design 7', 'wp-slick-slider-and-image-carousel'),
		'prodesign-8'	=> __('Design 8', 'wp-slick-slider-and-image-carousel'),
		'prodesign-9'	=> __('Design 9', 'wp-slick-slider-and-image-carousel'),
		'prodesign-10'	=> __('Design 10', 'wp-slick-slider-and-image-carousel'),
		'prodesign-11'	=> __('Design 11', 'wp-slick-slider-and-image-carousel'),
		'prodesign-12'	=> __('Design 12', 'wp-slick-slider-and-image-carousel'),
		'prodesign-13'	=> __('Design 13', 'wp-slick-slider-and-image-carousel'),
		'prodesign-14'	=> __('Design 14', 'wp-slick-slider-and-image-carousel'),
		'prodesign-15'	=> __('Design 15', 'wp-slick-slider-and-image-carousel'),
		'prodesign-16'	=> __('Design 16', 'wp-slick-slider-and-image-carousel'),
		'prodesign-17'	=> __('Design 17', 'wp-slick-slider-and-image-carousel'),
		'prodesign-18'	=> __('Design 18', 'wp-slick-slider-and-image-carousel'),
		'prodesign-19'	=> __('Design 19', 'wp-slick-slider-and-image-carousel'),
		'prodesign-20'	=> __('Design 20', 'wp-slick-slider-and-image-carousel'),
		'prodesign-21'	=> __('Design 21', 'wp-slick-slider-and-image-carousel'),
		'prodesign-22'	=> __('Design 22', 'wp-slick-slider-and-image-carousel'),
		'prodesign-23'	=> __('Design 23', 'wp-slick-slider-and-image-carousel'),
		'prodesign-24'	=> __('Design 24', 'wp-slick-slider-and-image-carousel'),
		'prodesign-25'	=> __('Design 25', 'wp-slick-slider-and-image-carousel'),
		'prodesign-26'	=> __('Design 26', 'wp-slick-slider-and-image-carousel'),
		'prodesign-27'	=> __('Design 27', 'wp-slick-slider-and-image-carousel'),
		'prodesign-28'	=> __('Design 28', 'wp-slick-slider-and-image-carousel'),
		'prodesign-29'	=> __('Design 29', 'wp-slick-slider-and-image-carousel'),
		'prodesign-30'	=> __('Design 30', 'wp-slick-slider-and-image-carousel'),
		'prodesign-31'	=> __('Design 31', 'wp-slick-slider-and-image-carousel'),
		'prodesign-32'	=> __('Design 32', 'wp-slick-slider-and-image-carousel'),
		'prodesign-33'	=> __('Design 33', 'wp-slick-slider-and-image-carousel'),
	);
	return apply_filters('wpsisac_pro_variable_designs', $design_arr );
}
/**
 * Function to get shortocdes registered in plugin
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.3.3
 */
function wpsisac_registered_shortcodes() {
	$shortcodes = array(
					'slick-slider'			=> __('Slick Slider', 'wp-slick-slider-and-image-carousel'),
					'slick-carousel-slider' => __('Slick Carousel Slider', 'wp-slick-slider-and-image-carousel'),
					'slick-variable-slider' => __('Slick Variable Slider', 'wp-slick-slider-and-image-carousel'),
					);
	return apply_filters('wpsisac_registered_shortcodes', (array)$shortcodes );
}