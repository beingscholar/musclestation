<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Action to add menu
add_action('admin_menu', 'wpsisac_pro_register_design_page');

/**
 * Register plugin design page in admin menu
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.9
 */
function wpsisac_pro_register_design_page() {
	add_submenu_page( 'edit.php?post_type='.WPSISAC_PRO_POST_TYPE, __('Getting Started - WP Slick Slider and Image Carousel Pro', 'wp-slick-slider-and-image-carousel'), __('Getting Started', 'wp-slick-slider-and-image-carousel'), 'edit_posts', 'wpsisacm-designs', 'wpsisac_pro_designs_page' );
}

/**
 * Function to display plugin design HTML
 * 
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.9
 */
function wpsisac_pro_designs_page() {

	$wpos_feed_tabs = wpsisac_pro_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? $_GET['tab'] : 'how-it-work';
?>

	<div class="wrap wpsisacm-wrap">

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($wpos_feed_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array( 'post_type' => WPSISAC_PRO_POST_TYPE, 'page' => 'wpsisacm-designs', 'tab' => $tab_key), admin_url('edit.php') );
			?>

			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo esc_url($tab_link); ?>"><?php echo $tab_name; ?></a>

			<?php } ?>
		</h2>

		<div class="wpsisacm-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'how-it-work' ) {
				wpsisac_pro_howitwork_page();
			}
		?>
		</div><!-- end .wpsisacm-tab-cnt-wrp -->

	</div><!-- end .wpsisacm-wrap -->

<?php
}

/**
 * Function to get plugin feed tabs
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.9
 */
function wpsisac_pro_help_tabs() {
	$wpos_feed_tabs = array(
						'how-it-work' 	=> array(
													'name' => __('How It Works', 'wp-slick-slider-and-image-carousel'),
												),
						);
	return $wpos_feed_tabs;
}

/**
 * Function to get 'How It Works' HTML
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.9
 */
function wpsisac_pro_howitwork_page() {
	$shrt_mapper = add_query_arg( array( 'post_type' => WPSISAC_PRO_POST_TYPE, 'page' => 'wpsisac-shrt-mapper' ), admin_url('edit.php') );
?>
	<style type="text/css">
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.wpsisacm-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.wpsisacm-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!--How it workd HTML -->
			<div id="post-body-content">
				<div class="meta-box-sortables">
					<div class="postbox">

						<h3 class="hndle">
							<span><?php _e( 'How It Works - Display and Shortcode', 'wp-slick-slider-and-image-carousel' ); ?></span>
						</h3>

						<div class="inside">
							<table class="form-table">
								<tbody>
									<tr>
										<th>
											<label><?php _e('Getting Started', 'wp-slick-slider-and-image-carousel'); ?></label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1. Go to "Slick Slider Pro --> Add Slide tab".', 'wp-slick-slider-and-image-carousel'); ?></li>
												<li><?php _e('Step-2. Add image title, description and images as a featured image', 'wp-slick-slider-and-image-carousel'); ?></li>
												<li><?php _e('Step-3. Repeat this process for number of slides you want.', 'wp-slick-slider-and-image-carousel'); ?></li>
												<li><?php _e('Step-4. To display multiple slider, you can use category shortcode under "Slick Slider Pro --> Slider Category"', 'wp-slick-slider-and-image-carousel'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('How Shortcode Works', 'wp-slick-slider-and-image-carousel'); ?></label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1. Create a page like Slider OR add the shortcode in any page.', 'wp-slick-slider-and-image-carousel'); ?></li>
												<li><?php _e('Step-2. Put below shortcode as per your need.', 'wp-slick-slider-and-image-carousel'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('All Shortcodes', 'wp-slick-slider-and-image-carousel'); ?></label>
										</th>
										<td>
											<span class="wpsisacm-shortcode-preview">[slick-slider]</span> – <?php _e('Slick Slider', 'wp-slick-slider-and-image-carousel'); ?> <br />
											<span class="wpsisacm-shortcode-preview">[slick-carousel-slider]</span> – <?php _e('Slick Carousel Slider', 'wp-slick-slider-and-image-carousel'); ?> <br />
											<span class="wpsisacm-shortcode-preview">[slick-variable-slider]</span> – <?php _e('Slick Variable Slider', 'wp-slick-slider-and-image-carousel'); ?> <br />
											<br/><br/>
											<div><a class="button button-primary wpsisac-shrt-map-btn" href="<?php echo esc_url( $shrt_mapper ); ?>"><?php _e('Try Our Shortcode Builder!!', 'wp-slick-slider-and-image-carousel'); ?></a></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- .inside -->
					</div><!-- #general -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-body-content -->

			<!--Upgrad to Pro HTML -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e('Need Support?', 'wp-slick-slider-and-image-carousel'); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Check plugin document for shortcode parameters and demo for designs.', 'wp-slick-slider-and-image-carousel'); ?></p>
							<a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://docs.wponlinesupport.com/wp-slick-slider-and-image-carousel-pro/?utm_source=slick_slider_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Documentation', 'wp-slick-slider-and-image-carousel'); ?></a>
							<p><a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://demo.wponlinesupport.com/prodemo/pro-wp-slick-slider-and-carousel-demo/?utm_source=slick_slider_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Demo for Designs', 'wp-slick-slider-and-image-carousel'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e('Need PRO Support?', 'wp-slick-slider-and-image-carousel'); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Hire our experts for any WordPress task.', 'wp-slick-slider-and-image-carousel'); ?></p>
							<p><a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://www.wponlinesupport.com/wordpress-support/?utm_source=slick_slider_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Know More', 'wp-slick-slider-and-image-carousel'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e( 'Help to improve this plugin!', 'wp-slick-slider-and-image-carousel' ); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Enjoyed this plugin? You can help by rate this plugin', 'wp-slick-slider-and-image-carousel'); ?> <a href="<?php echo esc_url('https://www.wponlinesupport.com/your-review/?utm_source=slick_slider_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('5 stars!', 'wp-slick-slider-and-image-carousel'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-container-1 -->

		</div><!-- #post-body -->
	</div><!-- #poststuff -->
<?php }