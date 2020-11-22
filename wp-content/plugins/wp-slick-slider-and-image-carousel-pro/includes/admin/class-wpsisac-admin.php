<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpsisac_Pro_Admin {

	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'wpsisac_pro_post_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'wpsisac_pro_save_metabox_value') );

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'wpsisac_pro_register_menu') );

		// Action to register plugin settings
		add_action ( 'admin_init', array($this, 'wpsisac_pro_admin_processes') );

		// Action to add category filter dropdown
		add_action( 'restrict_manage_posts', array($this, 'wpsisac_pro_add_post_filters'), 50 );

		// Filter to add row data
		add_filter( 'post_row_actions', array($this, 'wpsisac_pro_add_post_row_data'), 10, 2 );

		// Filter to add row action in category table
		add_filter( WPSISAC_PRO_CAT.'_row_actions', array($this, 'wpsisac_pro_add_tax_row_data'), 10, 2 );

		// Action to add custom column to Slider listing
		add_filter( 'manage_'.WPSISAC_PRO_POST_TYPE.'_posts_columns', array($this, 'wpsisac_pro_posts_columns') );

		// Action to add custom column data to Slider listing
		add_action('manage_'.WPSISAC_PRO_POST_TYPE.'_posts_custom_column', array($this, 'wpsisac_pro_post_columns_data'), 10, 2);

		// Action to add sorting link at Slider listing page
		add_filter( 'views_edit-'.WPSISAC_PRO_POST_TYPE, array($this, 'wpsisac_pro_sorting_link') );

		// Action to add `Save Order` button
		add_action( 'restrict_manage_posts', array($this, 'wpsisac_pro_restrict_manage_posts') );

		// Ajax call to update option
		add_action( 'wp_ajax_wpsisac_pro_update_post_order', array($this, 'wpsisac_pro_update_post_order'));
		add_action( 'wp_ajax_nopriv_wpsisac_pro_update_post_order',array( $this, 'wpsisac_pro_update_post_order'));

		// Filter to add plugin links
		add_filter( 'plugin_row_meta', array( $this, 'wpsisac_pro_plugin_row_meta' ), 10, 2 );

		// Shortocde Preview
		add_action( 'current_screen', array($this, 'wpsisac_generate_preview_screen') );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_post_sett_metabox() {
		add_meta_box( 'wpsisac-pro-post-sett', __( 'WP Slick Slider and Image Carousel Pro - Settings', 'wp-responsive-recent-post-slider' ), array($this, 'wpsisac_pro_post_sett_mb_content'), WPSISAC_PRO_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_post_sett_mb_content() {
		include_once( WPSISAC_PRO_DIR .'/includes/admin/metabox/wpsisac-post-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_save_metabox_value( $post_id ) {

		global $post_type;

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )					// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
		|| ( $post_type !=  WPSISAC_PRO_POST_TYPE ) )							// Check if current post type is supported.
		{
		return $post_id;
		}

		$prefix = WPSISAC_PRO_META_PREFIX; // Taking metabox prefix

		// Taking variables
		$read_more_link = isset($_POST[$prefix.'more_link']) ? wpsisac_pro_clean_url( $_POST[$prefix.'more_link'] ) : '';

		update_post_meta($post_id, 'wpsisac_slide_link', $read_more_link);
	}

	/**
	 * Function register setings
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_admin_processes() {

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'wpsisac-pro-plugin-notice' ) {
			set_transient( 'wpsisac_pro_install_notice', true, 604800 );
		}

		register_setting( 'wpsisac_pro_plugin_options', 'wpsisac_pro_options', array($this, 'wpsisac_pro_validate_options') );
	}

	/**
	 * Validate Settings Options
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_validate_options( $input ) {

		$input['default_img'] 	= isset($input['default_img']) 	? wpsisac_pro_clean_url( $input['default_img'] ) 	: '';
		$input['custom_css'] 	= isset($input['custom_css']) 	? sanitize_textarea_field( $input['custom_css'] ) 	: '';

		return $input;
	}

	/**
	 * Function to register admin menus
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_register_menu() {
		// Shortocde Mapper
		add_submenu_page( 'edit.php?post_type='.WPSISAC_PRO_POST_TYPE, __('Shortcode Builder - WP Slick Slider and Image Carousel Pro', 'wp-slick-slider-and-image-carousel'), __('Shortcode Builder', 'wp-slick-slider-and-image-carousel'), 'edit_posts', 'wpsisac-shrt-mapper', array($this, 'wpsisac_shortcode_mapper_page') );

		//Settings Page
		add_submenu_page( 'edit.php?post_type='.WPSISAC_PRO_POST_TYPE, __('Settings - WP Slick Slider and Image Carousel Pro', 'wp-slick-slider-and-image-carousel'), __('Settings', 'wp-slick-slider-and-image-carousel'), 'manage_options', 'wpsisac-pro-settings', array($this, 'wpsisac_pro_settings_page') );

		// Shortocde Preview
		add_submenu_page( null, __('Shortcode Preview', 'wp-slick-slider-and-image-carousel'), __('Shortcode Preview', 'wp-slick-slider-and-image-carousel'), 'edit_posts', 'wpsisac-preview', array($this, 'wpsisac_shortcode_preview_page') );
	}

	/**
	 * Function to handle plugin shoercode preview
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function wpsisac_shortcode_mapper_page() {
		include_once( WPSISAC_PRO_DIR . '/includes/admin/shortcode-mapper/wpsisac-shortcode-mapper.php' );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_settings_page() {
		include_once( WPSISAC_PRO_DIR . '/includes/admin/settings/wpsisac-settings.php' );
	}

	/**
	 * Function to handle plugin shoercode preview
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function wpsisac_shortcode_preview_page() {
	}

	/**
	 * Add category dropdown to Slider listing page
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_add_post_filters() {

		global $typenow;

		if( $typenow == WPSISAC_PRO_POST_TYPE ) {

			$wpsisac_pro_cat = isset($_GET[WPSISAC_PRO_CAT]) ? $_GET[WPSISAC_PRO_CAT] : '';

			$dropdown_options = apply_filters('wpsisac_pro_cat_filter_args', array(
					'show_option_none'  => __('All Categories', 'wp-slick-slider-and-image-carousel'),
					'option_none_value' => '',
					'hide_empty' 		=> 1,
					'hierarchical' 		=> 1,
					'show_count' 		=> 0,
					'orderby' 			=> 'name',
					'name'				=> WPSISAC_PRO_CAT,
					'taxonomy'			=> WPSISAC_PRO_CAT,
					'selected' 			=> $wpsisac_pro_cat,
					'value_field'		=> 'slug',
				));
			wp_dropdown_categories( $dropdown_options );
		}
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.1
	 */
	function wpsisac_pro_add_post_row_data( $actions, $post ) {

		if( $post->post_type == WPSISAC_PRO_POST_TYPE ) {
			return array_merge( array( 'wpos_id' => 'ID: ' . $post->ID ), $actions );
		}

		return $actions;
	}

	/**
	 * Function to add category row action
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.0
	 */
	function wpsisac_pro_add_tax_row_data( $actions, $tag ) {
		return array_merge( array( 'wpos_id' => 'ID: ' . $tag->term_id ), $actions );
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_posts_columns( $columns ){

		$new_columns['wpsisac_pro_image'] 	= __( 'Image', 'wp-slick-slider-and-image-carousel' );
		$new_columns['wpsisac_pro_order'] 	= __('Order', 'wp-slick-slider-and-image-carousel');

		$columns = wpsisac_pro_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_post_columns_data( $column, $post_id ) {

		global $wp_query , $post;

		switch ($column) {
			case 'wpsisac_pro_image':

				echo get_the_post_thumbnail( $post_id, array(50, 50), array('class' => 'wpsisac-slide-img') );
				break;

			case 'wpsisac_pro_order':

				$post_menu_order = isset($post->menu_order) ? $post->menu_order : '';

				echo $post_menu_order;
				if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
					echo "<input type='hidden' value='{$post_id}' name='wpsisac_pro_post[]' class='wpsisac-post-order' id='wpsisac-post-order-{$post_id}' />";
				}
				break;
		}
	}

	/**
	 * Add 'Sort Slides' link at Slider listing page
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_sorting_link( $views ) {

		global $post_type, $wp_query;

		$class            = ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 'current' : '';
		$query_string     = remove_query_arg(array( 'orderby', 'order' ));
		$query_string     = add_query_arg( 'orderby', urlencode('menu_order title'), $query_string );
		$query_string     = add_query_arg( 'order', urlencode('ASC'), $query_string );
		$views['byorder'] = '<a href="' . esc_url( $query_string ) . '" class="' . esc_attr( $class ) . '">' . __( 'Sort Slides', 'wp-slick-slider-and-image-carousel' ) . '</a>';

		return $views;
	}

	/**
	 * Add Save button to Slider listing page
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_restrict_manage_posts() {

		global $typenow, $wp_query;

		if( $typenow == WPSISAC_PRO_POST_TYPE && isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'menu_order title' ) {

			$html  = '';
			$html .= "<span class='spinner wpsisac-spinner'></span>";
			$html .= "<input type='button' name='wpsisac_pro_save_order' class='button button-secondary right wpsisac-save-order' id='wpsisac-save-order' value='".__('Save Sort Order', 'wp-slick-slider-and-image-carousel')."' />";
			echo $html;
		}
	}

	/**
	 * Update Slider order
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.2.5
	 */
	function wpsisac_pro_update_post_order() {

		// Taking some defaults
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= __('Sorry, Something happened wrong.', 'wp-slick-slider-and-image-carousel');

		if( !empty($_POST['form_data']) ) {

			$form_data 			= parse_str($_POST['form_data'], $output_arr);
			$wpsisac_pro_posts 	= !empty($output_arr['wpsisac_pro_post']) ? $output_arr['wpsisac_pro_post'] : '';

			if( !empty($wpsisac_pro_posts) ) {

				$post_menu_order = 0;

				// Loop od ids
				foreach ($wpsisac_pro_posts as $wpsisac_pro_post_key => $wpsisac_pro_post) {

					// Update post order
					$update_post = array(
						'ID'           => $wpsisac_pro_post,
						'menu_order'   => $post_menu_order,
					);

					// Update the post into the database
					wp_update_post( $update_post );

					$post_menu_order++;
				}

				$result['success'] 	= 1;
				$result['msg'] 		= __('Slides order saved successfully.', 'wp-slick-slider-and-image-carousel');
			}
		}

		echo json_encode($result);
		exit;
	}

	/**
	 * Function to unique number value
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.0.0
	 */
	function wpsisac_pro_plugin_row_meta( $links, $file ) {

		if ( $file == WPSISAC_PRO_PLUGIN_BASENAME ) {

			$row_meta = array(
				'docs'    => '<a href="' . esc_url('http://docs.wponlinesupport.com/wp-slick-slider-and-image-carousel-pro/?utm_source=slick_slider_pro&utm_medium=plugin_list&utm_campaign=plugin_quick_link') . '" title="' . esc_attr( __( 'View Documentation', 'wp-slick-slider-and-image-carousel' ) ) . '" target="_blank">' . __( 'Docs', 'wp-slick-slider-and-image-carousel' ) . '</a>',
				'support' => '<a href="' . esc_url('https://www.wponlinesupport.com/wordpress-support/?utm_source=slick_slider_pro&utm_medium=plugin_list&utm_campaign=plugin_quick_link') . '" title="' . esc_attr( __( 'Premium Support - For any Customization', 'wp-slick-slider-and-image-carousel' ) ) . '" target="_blank">' . __( 'Premium Support', 'wp-slick-slider-and-image-carousel' ) . '</a>',
			);
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}

	/**
	 * Function to handle plugin shoercode preview
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function wpsisac_generate_preview_screen( $screen ) {
		if( $screen->id == 'admin_page_wpsisac-preview' ) {
			include_once( WPSISAC_PRO_DIR . '/includes/admin/shortcode-mapper/shortcode-preview.php' );
			exit;
		}
	}
}

$wpsisac_pro_admin = new Wpsisac_Pro_Admin();