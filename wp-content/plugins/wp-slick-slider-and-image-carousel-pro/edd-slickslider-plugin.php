<?php
/**
 * Updater Functions
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// License page URL
if( !defined( 'WPSISAC_PRO_LICENSE_URL' ) ) {
	define( 'WPSISAC_PRO_LICENSE_URL', add_query_arg(array( 'post_type' => WPSISAC_PRO_POST_TYPE, 'page' => 'slickspro-license'), admin_url('edit.php')) );
}

/**
 * Updater Menu Function
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_license_menu() {

	// Getting license status to show notification
	$status 		= get_option( 'edd_slickspro_license_status' );
	$notification 	= ( $status !== 'valid' ) ? ' <span class="update-plugins count-1"><span class="plugin-count" aria-hidden="true">1</span></span>' : '';

	add_submenu_page( 'edit.php?post_type='.WPSISAC_PRO_POST_TYPE, __('WP Slick Slider Plugin License', 'wp-slick-slider-and-image-carousel'), __('Plugin License', 'wp-slick-slider-and-image-carousel').$notification, 'manage_options', 'slickspro-license', 'wpsisac_pro_license_page' );
}
add_action('admin_menu', 'wpsisac_pro_license_menu', 20);

/**
 * Plugin license form HTML
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_license_page() {
	$license 		= get_option( 'edd_slickspro_license_key' );
	$status 		= get_option( 'edd_slickspro_license_status' );
	$license_info 	= get_option( 'edd_slickspro_license_info' );
?>
	<div class="wrap">
		<h2><?php _e('WP Slick Slider and Image Carousel Pro - License Options', 'wp-slick-slider-and-image-carousel'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('edd_slickspro_license'); ?>

			<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) { ?>
				<div class="updated notice is-dismissible" id="message">
					<p><?php _e('Your changes saved successfully.', 'wp-slick-slider-and-image-carousel'); ?></p>
				</div>
			<?php } elseif ( isset($_GET['sl_activation']) && $_GET['sl_activation'] == 'false' && !empty($_GET['message']) ) { ?>
				<div class="error" id="message">
					<p><?php echo urldecode($_GET['message']); ?></p>
				</div>
			<?php }

			if( $status !== false && $status == 'valid' ) { ?>
				<div class="updated notice notice-success" id="message">
					<p><?php _e('Plugin license activated successfully', 'wp-slick-slider-and-image-carousel'); ?></p>
				</div>
			<?php } elseif( !isset($_GET['sl_activation']) ) { ?>
				<div class="error notice notice-error" id="message">
					<p><?php _e('Please activate plugin license to get automatic update of plugin.', 'wp-slick-slider-and-image-carousel'); ?></p>
				</div>
			<?php } ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<label for="edd_slickspro_license_key"><?php _e('License Key', 'wp-slick-slider-and-image-carousel'); ?></label>
						</th>
						<td>
							<input id="edd_slickspro_license_key" name="edd_slickspro_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" /><br/>
							<span class="description"><?php _e('Enter plugin license key.', 'wp-slick-slider-and-image-carousel'); ?></span>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php wp_nonce_field( 'edd_slickspro_nonce', 'edd_slickspro_nonce' ); ?>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<input type="submit" class="button-secondary" name="edd_license_deactivate_slickspro" value="<?php _e('Deactivate License'); ?>"/>
									<span style="color: green; display: inline-block; margin: 4px 0px 0px;"><i class="dashicons dashicons-yes"></i><?php _e('Active'); ?></span>
								<?php } else { ?>
									<input type="submit" class="button-secondary" name="edd_license_activate_slickspro" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>

					<?php if( $status !== false && $status == 'valid' && !empty($license_info) ) { ?>
					<tr>
						<th valign="top">License Information</th>
						<td style="font-weight: 600; line-height: 25px;">
							License Limit : <?php echo (isset($license_info->license_limit) && $license_info->license_limit == 0) ? 'Unlimited' : $license_info->license_limit.' Sites'; ?> <br/>
							Active Site(s) : <?php echo isset($license_info->site_count) ? $license_info->site_count : 'N/A'; ?> <br/>
							Activations Left Site(s) : <?php echo isset($license_info->activations_left) ? ucfirst($license_info->activations_left) : 'N/A'; ?> <br/>
							Valid Upto : <?php echo (isset($license_info->expires) && $license_info->expires == 'lifetime') ? 'Lifetime' : date('d M, Y', strtotime($license_info->expires)); ?> <label style="vertical-align:top;" title="On purchase of any product 1 Year of Updates, 1 Year of Expert Support 24/7. After 1 Year, use without renewal OR renew manually at 50% of the price for further updates and support.">[?]</label>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>
			
			<div class="wpo-activate-step">
				<hr/>
				<h2><?php _e('Steps to Activate the License', 'wp-slick-slider-and-image-carousel'); ?></h2>
				<ol>
					<li><?php _e("Enter your license key into 'License Key' field and press 'Save Changes' button.", "wp-slick-slider-and-image-carousel"); ?></li>
					<li><?php _e("After save changes you can see an another button named 'Activate License'.", "wp-slick-slider-and-image-carousel"); ?></li>
					<li><?php _e("Press 'Activate License'. If your key is valid then you can see green 'Active' text.", "wp-slick-slider-and-image-carousel"); ?></li>
					<li><?php _e("That's it. Now you can get auto update of this plugin.", "wp-slick-slider-and-image-carousel"); ?></li>
				</ol>
				<h4 style="color:#dc3232;"><?php _e('Note: If you do not activate the license then you will not get automatic update of this plugin any more.', 'wp-slick-slider-and-image-carousel'); ?></h4>
				<h4><?php _e('You will receive license key within your product purchase email. If you do not have license key then you can get it from your', 'wp-slick-slider-and-image-carousel'); ?> <a href="https://www.wponlinesupport.com/my-account/" target="_blank"><?php _e('Account Page', 'wp-slick-slider-and-image-carousel'); ?></a>.</h4>
				<h4><?php _e('Note : If your license key has expired, please renew your license from', 'blog-designer-for-post-and-widget'); ?> <a href="https://www.wponlinesupport.com/my-account/" target="_blank"><?php _e('Account Page', 'wp-slick-slider-and-image-carousel'); ?></a>.</h4>
			</div><!-- end .wpo-activate-step -->
		</form>
	</div><!-- end .wrap -->
<?php
}

/**
 * Register plugin license settings
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_register_license_option() {
	register_setting('edd_slickspro_license', 'edd_slickspro_license_key', 'wpsisac_pro_sanitize_license' );
}
add_action('admin_init', 'wpsisac_pro_register_license_option');

/**
 * Validate plugin license options
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_sanitize_license( $new ) {
	$old = get_option( 'edd_slickspro_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'edd_slickspro_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/**
 * Activate plugin license
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate_slickspro'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_slickspro_nonce', 'edd_slickspro_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_slickspro_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( WPSISAC_PRO_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( WPSISAC_PRO_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'wp-slick-slider-and-image-carousel' );
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {

				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							__( 'Your license key expired on %s.', 'wp-slick-slider-and-image-carousel' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'revoked' :

						$message = __( 'Your license key has been disabled.', 'wp-slick-slider-and-image-carousel' );
						break;

					case 'missing' :

						$message = __( 'Plugin license is invalid. Please be sure you have entered right plugin license key.', 'wp-slick-slider-and-image-carousel' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.', 'wp-slick-slider-and-image-carousel' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'wp-slick-slider-and-image-carousel' ), WPSISAC_PRO_ITEM_NAME );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.', 'wp-slick-slider-and-image-carousel' );
						break;

					default :

						$message = __( 'An error occurred, please try again.', 'wp-slick-slider-and-image-carousel' );
						break;
				}
			}
		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), WPSISAC_PRO_LICENSE_URL );
			wp_redirect( $redirect );
			exit();
		}

		// $license_data->license will be either "valid" or "invalid"
		update_option( 'edd_slickspro_license_status', $license_data->license );
		if(isset($license_data->license)) {
			update_option( 'edd_slickspro_license_info', $license_data );
		}

		wp_redirect( WPSISAC_PRO_LICENSE_URL );
		exit();
	}
}
add_action('admin_init', 'wpsisac_pro_activate_license');

/**
 * Deactivate plugin license
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_deactivate_plugin_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate_slickspro'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_slickspro_nonce', 'edd_slickspro_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_slickspro_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( WPSISAC_PRO_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( WPSISAC_PRO_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'wp-slick-slider-and-image-carousel' );
			}

			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), WPSISAC_PRO_LICENSE_URL );

			wp_redirect( $redirect );
			exit();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'edd_slickspro_license_status' );
		}

		wp_redirect( WPSISAC_PRO_LICENSE_URL );
		exit();
	}
}
add_action('admin_init', 'wpsisac_pro_deactivate_plugin_license');

/**
 * Displays message inline on plugin row that the license key is missing
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_plugin_row_license_missing( $plugin_data, $version_info ) {

	$license 		= get_option( 'edd_slickspro_license_info' );
	$license_status = get_option( 'edd_slickspro_license_status' );

	if( ( !is_object($license) || $license_status !== 'valid' ) ) {
		echo '&nbsp;<strong><a href="' . esc_url( WPSISAC_PRO_LICENSE_URL ) . '">' . __( 'Enter valid license key for automatic updates.', 'wp-slick-slider-and-image-carousel' ) . '</a></strong>';
	}
}

// Missing license key message
add_action( 'in_plugin_update_message-' . WPSISAC_PRO_PLUGIN_BASENAME, 'wpsisac_pro_plugin_row_license_missing', 10, 2 );

/**
 * Function to add extra plugins link
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.0.0
 */
function wpsisac_pro_plugin_action_links( $links ) {
	
	$links['license'] = '<a href="' . esc_url(WPSISAC_PRO_LICENSE_URL) . '" title="' . esc_attr( __( 'Activate Plugin License', 'wp-slick-slider-and-image-carousel' ) ) . '">' . __( 'License', 'wp-slick-slider-and-image-carousel' ) . '</a>';
	
	return $links;
}
add_filter( 'plugin_action_links_' . WPSISAC_PRO_PLUGIN_BASENAME, 'wpsisac_pro_plugin_action_links' );