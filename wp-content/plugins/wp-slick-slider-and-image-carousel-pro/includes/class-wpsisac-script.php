<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpsisac_Pro_Script {

	function __construct() {

		// Action to add style and script in backend
		add_action( 'admin_enqueue_scripts', array($this, 'wpsisac_pro_admin_style_script') );

		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'wpsisac_pro_front_style') );

		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'wpsisac_pro_front_script') );

		// Action to add custom css in head
		add_action( 'wp_head', array($this, 'wpsisac_pro_add_custom_css'), 20 );
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_admin_style_script( $hook ) {

		global $typenow, $wp_version, $wp_query, $post_type;

		$new_ui = $wp_version >= '3.5' ? '1' : '0'; // Check wordpress version for older scripts

		// If page is plugin setting page then enqueue script
		if( $typenow == WPSISAC_PRO_POST_TYPE ) {

			// Registring admin script
			wp_register_style( 'wpsisac-pro-admin-style', WPSISAC_PRO_URL.'assets/css/wpsisac-pro-admin.css', array(), WPSISAC_PRO_VERSION );
			wp_enqueue_style( 'wpsisac-pro-admin-style' );

			// Registring admin script
			wp_register_script( 'wpsisac-pro-ordering', WPSISAC_PRO_URL . 'assets/js/wpsisac-pro-ordering.js', array( 'jquery-ui-sortable' ), WPSISAC_PRO_VERSION, true );

			wp_register_script( 'wpsisac-pro-admin-script', WPSISAC_PRO_URL.'assets/js/wpsisac-pro-admin.js', array('jquery'), WPSISAC_PRO_VERSION, true );
			wp_localize_script( 'wpsisac-pro-admin-script', 'WpsisacProAdmin', array(
																	'new_ui' =>	$new_ui
																));

			wp_register_script( 'wpsisac-shortcode-mapper', WPSISAC_PRO_URL.'assets/js/wpsisac-shrt-mapper.min.js', array('jquery'), WPSISAC_PRO_VERSION, true );
			wp_localize_script( 'wpsisac-shortcode-mapper', 'Wpsisac_Shrt_Mapper', array(
																	'shortocde_err' => __("Sorry, Something happened wrong. Kindly please be sure that you have choosen relevant shortocde from the dropdown.", 'wp-slick-slider-and-image-carousel'),
															));
		
			// Slider sorting - only when sorting by menu order on the blog listing page
			if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
				wp_enqueue_script( 'wpsisac-pro-ordering' );
			}
		
			// If page is plugin setting page then enqueue script
			if( $hook == WPSISAC_PRO_POST_TYPE . '_page_wpsisac-pro-settings' ) {
				wp_enqueue_script( 'wpsisac-pro-admin-script' );
				wp_enqueue_media(); // For media uploader
			}

			// Shortcode Builder
			if( $hook == WPSISAC_PRO_POST_TYPE . '_page_wpsisac-shrt-mapper' ) {
				wp_enqueue_script('shortcode');
				wp_enqueue_script('jquery-ui-accordion');
				wp_enqueue_script('wpsisac-shortcode-mapper');
			}
		}
	}

	/**
	 * Function to add style at front side
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.0.0
	 */
	function wpsisac_pro_front_style() {

		// Registring and enqueing slick slider css
		if( ! wp_style_is( 'wpos-slick-style', 'registered' ) ) {
			wp_register_style( 'wpos-slick-style', WPSISAC_PRO_URL.'assets/css/slick.css', array(), WPSISAC_PRO_VERSION );
		}

		// Registring and enqueing public css
		wp_register_style( 'wpsisac-pro-public-style', WPSISAC_PRO_URL.'assets/css/wpsisac-pro-public.min.css', array(), WPSISAC_PRO_VERSION );
		wp_enqueue_style( 'wpsisac-pro-public-style' );

		wp_enqueue_style( 'wpos-slick-style' );
	}

	/**
	 * Function to add script at front side
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.0.0
	 */
	function wpsisac_pro_front_script() {

		// Registring slick slider script
		if( ! wp_script_is( 'wpos-slick-jquery', 'registered' ) ) {
			wp_register_script( 'wpos-slick-jquery', WPSISAC_PRO_URL.'assets/js/slick.min.js', array('jquery'), WPSISAC_PRO_VERSION, true );
		}

		// Registring and enqueing public script
		wp_register_script( 'wpsisac-pro-public-script', WPSISAC_PRO_URL.'assets/js/wpsisac-pro-public.min.js', array('jquery'), WPSISAC_PRO_VERSION, true );
		wp_localize_script( 'wpsisac-pro-public-script', 'Wpsisac_Pro', array(
																		'is_mobile' => (wp_is_mobile()) ? 1 : 0,
																		'is_rtl' 	=> (is_rtl()) 		? 1 : 0
																	));
	}

	/**
	 * Add custom css to head
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_add_custom_css() {

		$custom_css = wpsisac_pro_get_option('custom_css');

		if( !empty($custom_css) ) {
			$css  = '<style type="text/css">' . "\n";
			$css .= $custom_css;
			$css .= "\n" . '</style>' . "\n";

			echo $css;
		}
	}
}

$wpsisac_pro_script = new Wpsisac_Pro_Script();