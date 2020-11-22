<?php
/**
 * Blocks Initializer
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function wp_wpsisac_pro_register_guten_block() {

	// Some Variables
	$shrt_gen_link = add_query_arg( array( 'post_type' => WPSISAC_PRO_POST_TYPE, 'page' => 'wpsisac-shrt-mapper' ), admin_url('edit.php') );

	// Block Editor Script
	wp_register_script( 'wp-wpsisac-block-js', WPSISAC_PRO_URL.'assets/js/blocks.build.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ), WPSISAC_PRO_VERSION, true );
	wp_localize_script( 'wp-wpsisac-block-js', 'Wp_Wpsisac_Block', array(
																	'shrt_gen_link' 			=> $shrt_gen_link,
																	'carousel_shrt_gen_link'	=> add_query_arg( array( 'shortcode' => 'slick-carousel-slider' ), $shrt_gen_link ),
																	'variable_shrt_gen_link'	=> add_query_arg( array( 'shortcode' => 'slick-variable-slider' ), $shrt_gen_link ),
																));

	// Register block and explicit define the attributes for slick slider
	register_block_type( 'wp-wpsisac-pro/slick-slider', array(
		'attributes' => array(
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'prodesign-1',
						),
			'show_content' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_read_more' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'read_more_text' => array(
							'type'		=> 'string',
							'default'	=> 'Read More',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'sliderheight' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'image_fit' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'large',
						),
			'dots' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'dots_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'arrows' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'arrow_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'autoplay_interval' => array(
							'type'		=> 'number',
							'default'	=> 3000,
						),
			'speed' => array(
							'type'		=> 'number',
							'default'	=> 600,
						),
			'fade' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'loop' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'slider_nav_column' => array(
							'type'		=> 'number',
							'default'	=> 5,
						),
			'hover_pause' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'focus_pause' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 15,
						),
			'orderby' => array(
							'type'		=> 'string',
							'default'	=> 'date',
						),
			'order' => array(
							'type'		=> 'string',
							'default'	=> 'DESC',
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'include_cat_child' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'exclude_cat' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'posts' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'exclude_post' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'query_offset' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpsisac_pro_slick_slider',
	));

	//Register block and explicitly define the attributes for carousel slider
	register_block_type( 'wp-wpsisac-pro/slick-carousel-slider', array(
		'attributes' => array(
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'prodesign-1',
						),
			'show_content' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_read_more' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'read_more_text' => array(
							'type'		=> 'string',
							'default'	=> 'Read More',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'sliderheight' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'image_fit' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'large',
						),
			'dots' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'dots_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'arrows' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'arrow_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'slidestoshow' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'slidestoscroll' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'autoplay_interval' => array(
							'type'		=> 'number',
							'default'	=> 3000,
						),
			'speed' => array(
							'type'		=> 'number',
							'default'	=> 600,
						),
			'centermode' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'center_padding' => array(
							'type'		=> 'number',
							'default'	=> 0,
						),
			'loop' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'hover_pause' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'focus_pause' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 15,
						),
			'orderby' => array(
							'type'		=> 'string',
							'default'	=> 'date',
						),
			'order' => array(
							'type'		=> 'string',
							'default'	=> 'DESC',
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'include_cat_child' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'exclude_cat' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'posts' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'exclude_post' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'query_offset' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpsisac_pro_carousel_slider',
	));

	//Register block, and explicitly define the attributes for variable slider
	register_block_type( 'wp-wpsisac-pro/slick-variable-slider', array(
		'attributes' => array(
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'prodesign-1',
						),
			'show_content' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'show_read_more' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'read_more_text' => array(
							'type'		=> 'string',
							'default'	=> 'Read More',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'sliderheight' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'image_fit' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'full',
						),
			'dots' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'dots_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'arrows' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'arrow_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'autoplay_interval' => array(
							'type'		=> 'number',
							'default'	=> 3000,
						),
			'speed' => array(
							'type'		=> 'number',
							'default'	=> 600,
						),
			'var_width' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'center_width' => array(
							'type'		=> 'string',
							'default'	=> '70%',
						),
			'loop' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'hover_pause' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'focus_pause' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 15,
						),
			'orderby' => array(
							'type'		=> 'string',
							'default'	=> 'date',
						),
			'order' => array(
							'type'		=> 'string',
							'default'	=> 'DESC',
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'include_cat_child' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'exclude_cat' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'posts' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'exclude_post' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'query_offset' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpsisac_pro_variable_slider',
	));

	// Adding langauge translation file
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'wp-wpsisac-block-js', 'wp-slick-slider-and-image-carousel', WPSISAC_PRO_DIR . '/languages' );
	}

}
add_action( 'init', 'wp_wpsisac_pro_register_guten_block' );

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.5
 */
function wp_wpsisac_pro_block_assets() {	
}
add_action( 'enqueue_block_assets', 'wp_wpsisac_pro_block_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.5
 */
function wp_wpsisac_pro_editor_assets() {

	// Block Editor CSS
	if( ! wp_style_is( 'wpos-guten-block-css', 'registered' ) ) {
		wp_register_style( 'wpos-guten-block-css', WPSISAC_PRO_URL.'assets/css/blocks.editor.build.css', array( 'wp-edit-blocks' ), WPSISAC_PRO_VERSION );
	}

	// Block Editor Script
	wp_enqueue_style( 'wpos-guten-block-css' );
	wp_enqueue_script( 'wp-wpsisac-block-js' );

}
add_action( 'enqueue_block_editor_assets', 'wp_wpsisac_pro_editor_assets' );

/**
 * Adds an extra category to the block inserter
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.5
 */
function wp_wpsisac_pro_add_block_category( $categories ) {

	$guten_cats = wp_list_pluck( $categories, 'slug' );

	if( ! in_array( 'wpos_guten_block', $guten_cats ) ) {
		$categories[] = array(
							'slug'	=> 'wpos_guten_block',
							'title'	=> __('WPOS Blocks', 'wp-slick-slider-and-image-carousel'),
							'icon'	=> null,
						);
	}

	return $categories;
}
add_filter( 'block_categories', 'wp_wpsisac_pro_add_block_category' );