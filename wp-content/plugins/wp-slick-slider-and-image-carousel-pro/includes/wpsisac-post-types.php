<?php
/**
 * Register Post type functionality
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to register post type
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_register_post_type() {

	$wpsisac_pro_post_lbls = apply_filters( 'wpsisac_pro_post_labels', array(
								'name'					=> __( 'Slick Slider', 'wp-slick-slider-and-image-carousel' ),
								'singular_name'			=> __( 'Slick Slider', 'wp-slick-slider-and-image-carousel' ),
								'all_items'				=> __( 'All Slides', 'wp-slick-slider-and-image-carousel' ),
								'add_new'				=> __( 'Add Slide', 'wp-slick-slider-and-image-carousel' ),
								'add_new_item'			=> __( 'Add New slide', 'wp-slick-slider-and-image-carousel' ),
								'edit_item'				=> __( 'Edit Slick Slider', 'wp-slick-slider-and-image-carousel' ),
								'new_item'				=> __( 'New Slick Slider', 'wp-slick-slider-and-image-carousel' ),
								'view_item'				=> __( 'View Slick Slider', 'wp-slick-slider-and-image-carousel' ),
								'search_items'			=> __( 'Search Slide', 'wp-slick-slider-and-image-carousel' ),
								'not_found'				=> __( 'No Slick Slider Items found', 'wp-slick-slider-and-image-carousel' ),
								'not_found_in_trash'	=> __( 'No Slick Slider Items found in Trash', 'wp-slick-slider-and-image-carousel' ),
								'parent_item_colon'		=> '',
								'menu_name'				=> __( 'Slick Slider Pro', 'wp-slick-slider-and-image-carousel' ),
								'featured_image'		=> __( 'Slide Image', 'wp-slick-slider-and-image-carousel' ),
								'set_featured_image'	=> __( 'Set slide image', 'wp-slick-slider-and-image-carousel' ),
								'remove_featured_image'	=> __( 'Remove slide image', 'wp-slick-slider-and-image-carousel' ),
								'use_featured_image'	=> __( 'Use as slide image', 'wp-slick-slider-and-image-carousel' ),
							));

	$wpsisac_pro_slider_args = array(
		'labels'				=> $wpsisac_pro_post_lbls,
		'public'				=> false,
		'show_ui'				=> true,
		'query_var'				=> false,
		'rewrite'				=> false,
		'capability_type'		=> 'post',
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-slides',
		'supports'				=> apply_filters('wpsisac_pro_post_supports', array('title', 'editor', 'thumbnail', 'page-attributes', 'publicize')),
	);
	
	// Register slick slider post type
	register_post_type( WPSISAC_PRO_POST_TYPE, apply_filters( 'wpsisac_pro_registered_post_type_args', $wpsisac_pro_slider_args ) );
}

// Action to register plugin post type
add_action('init', 'wpsisac_pro_register_post_type');

/**
 * Function to register taxonomy
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_register_taxonomies() {

	$wpsisac_pro_cat_lbls = apply_filters('wpsisac_pro_cat_labels', array(
		'name'				=> __( 'Category', 'wp-slick-slider-and-image-carousel' ),
		'singular_name'		=> __( 'Category', 'wp-slick-slider-and-image-carousel' ),
		'search_items'		=> __( 'Search Category', 'wp-slick-slider-and-image-carousel' ),
		'all_items'			=> __( 'All Category', 'wp-slick-slider-and-image-carousel' ),
		'parent_item'		=> __( 'Parent Category', 'wp-slick-slider-and-image-carousel' ),
		'parent_item_colon' => __( 'Parent Category:', 'wp-slick-slider-and-image-carousel' ),
		'edit_item'			=> __( 'Edit Category', 'wp-slick-slider-and-image-carousel' ),
		'update_item'		=> __( 'Update Category', 'wp-slick-slider-and-image-carousel' ),
		'add_new_item'		=> __( 'Add New Category', 'wp-slick-slider-and-image-carousel' ),
		'new_item_name'		=> __( 'New Category Name', 'wp-slick-slider-and-image-carousel' ),
		'menu_name'			=> __( 'Category', 'wp-slick-slider-and-image-carousel' ),
	));

	$wpsisac_pro_cat_args = array(
		'public'			=> false,
		'hierarchical'		=> true,
		'labels'			=> $wpsisac_pro_cat_lbls,
		'show_ui'			=> true,
		'show_admin_column' => true,
		'query_var'			=> true,
		'rewrite'			=> false,
	);
	
	// Register slick slider category
	register_taxonomy( WPSISAC_PRO_CAT, array( WPSISAC_PRO_POST_TYPE ), apply_filters('wpsisac_pro_registered_cat_args', $wpsisac_pro_cat_args) );
}

// Action to register plugin taxonomies
add_action( 'init', 'wpsisac_pro_register_taxonomies');

/**
 * Function to update post message for team showcase
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_post_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages[WPSISAC_PRO_POST_TYPE] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __( 'Slider updated.', 'wp-slick-slider-and-image-carousel' ) ),
		2 => __( 'Custom field updated.', 'wp-slick-slider-and-image-carousel' ),
		3 => __( 'Custom field deleted.', 'wp-slick-slider-and-image-carousel' ),
		4 => __( 'Slider updated.', 'wp-slick-slider-and-image-carousel' ),
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Slider restored to revision from %s', 'wp-slick-slider-and-image-carousel' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __( 'Slider published.', 'wp-slick-slider-and-image-carousel' ) ),
		7 => __( 'Slider saved.', 'wp-slick-slider-and-image-carousel' ),
		8 => sprintf( __( 'Slider submitted.', 'wp-slick-slider-and-image-carousel' ) ),
		9 => sprintf( __( 'Slider scheduled for: <strong>%1$s</strong>.', 'wp-slick-slider-and-image-carousel' ), date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ) ),
		10 => sprintf( __( 'Slider draft updated.', 'wp-slick-slider-and-image-carousel' ) ),
	);

	return $messages;
}

// Filter to update slider post message
add_filter( 'post_updated_messages', 'wpsisac_pro_post_updated_messages' );