<?php
/**
 * WP Slick Slider and Image Carousel Pro Shortcode Mapper Page
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$registered_shortcodes 	= wpsisac_registered_shortcodes();
$preview_shortcode 		= !empty($_GET['shortcode']) ? $_GET['shortcode'] : apply_filters('wpsisac_default_shortcode_preview', 'slick-slider' );
$preview_url 			= add_query_arg( array( 'page' => 'wpsisac-preview', 'shortcode' => $preview_shortcode), admin_url('admin.php') );
$shrt_generator_url 	= add_query_arg( array('post_type' => WPSISAC_PRO_POST_TYPE, 'page' => 'wpsisac-shrt-mapper'), admin_url('edit.php') );

// Instantiate the shortcode mapper
if( !class_exists( 'Wpsisac_Pro_Shortcode_Mapper' ) ) {
	include_once( WPSISAC_PRO_DIR . '/includes/admin/shortcode-mapper/class-wpsisac-shortcode-mapper.php' );
}

$shortcode_fields 	= array();
$shortcode_sanitize = str_replace('-', '_', $preview_shortcode);
?>
<div class="wrap wpsisac-customizer-settings">

	<h2><?php _e( 'WP Slick Slider and Image Carousel Pro - Shortcode Builder', 'wp-slick-slider-and-image-carousel' ); ?></h2>

	<?php
	// If invalid shortocde is passed then simply return
	if( !empty($_GET['shortcode']) && !isset( $registered_shortcodes[ $_GET['shortcode'] ] ) ) {
		echo '<div id="message" class="error notice">
				<p><strong>'.__('Sorry, Something happened wrong.', 'wp-slick-slider-and-image-carousel').'</strong></p>
			 </div>';
		return;
	}
	?>

	<div class="wpsisac-customizer-toolbar">
		<?php if( !empty( $registered_shortcodes ) ) { ?>
			<select class="wpsisac-cust-shrt-switcher" id="wpsisac-cust-shrt-switcher">
				<option value=""><?php _e('-- Choose Shortcode --', 'wp-slick-slider-and-image-carousel'); ?></option>
				<?php foreach ($registered_shortcodes as $shrt_key => $shrt_val) {

					if( empty($shrt_key) ) {
						continue;
					}

					$shrt_val 		= !empty($shrt_val) ? $shrt_val : $shrt_key;
					$shortcode_url 	= add_query_arg( array('shortcode' => $shrt_key), $shrt_generator_url );
				?>
				<option value="<?php echo $shrt_key; ?>" <?php selected( $preview_shortcode, $shrt_key); ?> data-url="<?php echo esc_url( $shortcode_url ); ?>"><?php echo $shrt_val; ?></option>
				<?php } ?>
			</select>
		<?php } ?>
		<span class="wpsisac-cust-shrt-generate-help wpsisac-tooltip" title="<?php _e("The Shortcode Mapper allows you to preview plugin shortcode. You can choose your desired shortcode from the dropdown and check various parameters from left panel. \n\nYou can paste shortocde to below and press Generate button to preview so each and every time you do not have to choose each parameters!!!", 'wp-slick-slider-and-image-carousel'); ?>"><i class="dashicons dashicons-editor-help"></i></span>
	</div><!-- end .wpsisac-customizer-toolbar -->

	<div class="wpsisac-customizer wpsisac-clearfix" data-shortcode="<?php echo $preview_shortcode; ?>">
		<div class="wpsisac-customizer-control wpsisac-clearfix">
			<div class="wpsisac-customizer-heading"><?php _e('Shortcode Parameters', 'wp-slick-slider-and-image-carousel'); ?></div>
			<?php
				if ( function_exists( $shortcode_sanitize.'_shortcode_fields' ) ) {
					$shortcode_fields = call_user_func( $shortcode_sanitize.'_shortcode_fields', $preview_shortcode );
				}
				$shortcode_fields = apply_filters('wpsisac_shortcode_mapper_fields', $shortcode_fields, $preview_shortcode );

				$shortcode_mapper = new Wpsisac_Pro_Shortcode_Mapper();
				$shortcode_mapper->render( $shortcode_fields );
			?>
		</div>

		<div class="wpsisac-customizer-preview wpsisac-clearfix">
			<div class="wpsisac-customizer-shrt-wrp">
				<div class="wpsisac-customizer-heading"><?php _e('Shortcode', 'wp-slick-slider-and-image-carousel'); ?> 
					<div class="wpsisac-customizer-shrt-tool">
						<button type="button" class="button button-primary button-small wpsisac-cust-shrt-generate"><?php _e('Generate', 'wp-slick-slider-and-image-carousel') ?></button>
						<i title="<?php _e('Full Preview Mode', 'wp-slick-slider-and-image-carousel'); ?>" class="wpsisac-tooltip wpsisac-cust-dwp dashicons dashicons-editor-expand"></i>
					</div>
				</div>
				<form action="<?php echo esc_url($preview_url); ?>" method="post" class="wpsisac-customizer-shrt-form" id="wpsisac-customizer-shrt-form" target="wpsisac_customizer_preview_frame">
					<textarea name="wpsisac_customizer_shrt" class="wpsisac-customizer-shrt" id="wpsisac-customizer-shrt" placeholder="<?php _e('Copy or Paste Shortcode', 'wp-slick-slider-and-image-carousel'); ?>"></textarea>
				</form>
			</div>
			<div class="wpsisac-customizer-heading"><?php _e('Preview Window', 'wp-slick-slider-and-image-carousel'); ?> <span class="wpsisac-cust-heading-info wpsisac-tooltip" title="<?php _e('Preview will be displayed according to responsive layout mode. You can check with `Full Preview` mode for better visualization.', 'wp-slick-slider-and-image-carousel'); ?>">[?]</span></div>
			<div class="wpsisac-customizer-window">
				<iframe class="wpsisac-customizer-preview-frame" name="wpsisac_customizer_preview_frame" src="<?php echo esc_url($preview_url); ?>" scrolling="auto" frameborder="0"></iframe>
				<div class="wpsisac-customizer-loader"></div>
				<div class="wpsisac-customizer-error"><?php _e('Sorry, Something happened wrong.', 'wp-slick-slider-and-image-carousel'); ?></div>
			</div>
		</div>
	</div><!-- wpsisac-customizer -->

	<br/>
	<div class="wpsisac-cust-footer-note"><span class="description"><?php _e('Note: Preview will be displayed according to responsive layout mode. Live preview may display differently when added to your page based on inheritance from some styles.', 'wp-slick-slider-and-image-carousel'); ?></span></div>

</div><!-- end .wrap -->