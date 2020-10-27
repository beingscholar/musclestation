<?php
/**
 * Welcome dialog for fresh installs.
 *
 * @package Hustle
 * @since 4.0.0
 */

$banner_img_1x = self::$plugin_url . 'assets/images/release-highlight-header.png';
$banner_img_2x = self::$plugin_url . 'assets/images/release-highlight-header@2x.png';
?>

<div class="sui-modal sui-modal-md">

	<div
		role="dialog"
		id="hustle-dialog--release-highlight"
		class="sui-modal-content"
		aria-modal="true"
		aria-labelledby="hustle-dialog--release-highlight-title"
		aria-describedby="hustle-dialog--release-highlight-description"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'hustle_dismiss_notification' ) ); ?>"
	>

		<div class="sui-box" style="margin-bottom: 10px;">

			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-right--60  sui-spacing-left--60">

				<button class="sui-button-icon sui-button-float--right hustle-modal-close" style="z-index: 2;" data-modal-close>
					<span class="sui-icon-close sui-md" aria-hidden="true"></span>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Close this dialog window', 'hustle' ); ?></span>
				</button>

				<figure role="banner" class="sui-box-banner" aria-hidden="true">
				<?php echo Opt_In_Utils::render_image_markup( $banner_img_1x, $banner_img_2x, 'sui-image sui-image-center' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</figure>

				<?php /* translators: current user's name */ ?>
				<h3 id="hustle-dialog--release-highlight-title" class="sui-box-title sui-lg"><?php esc_html_e( 'New! Preview Modules Across Devices', 'hustle' ); ?></h3>

				<p id="hustle-dialog--release-highlight-description" class="sui-description">
					<?php esc_html_e( 'Now you can preview your pop-ups, slide-ins, and embeds on both desktop and mobile devices. Just click on the "Preview" button to see how your modules look on desktop and mobile devices without leaving the module editor.', 'hustle' ); ?>
				</p>

			</div>

			<div class="sui-box-footer sui-flatten sui-content-center sui-spacing-bottom--50">

				<button id="hustle-release-highlight-action-button" class="sui-button">
					<?php esc_html_e( 'Got It', 'hustle' ); ?>
				</button>

			</div>

		</div>

		<button class="sui-modal-skip" data-modal-close><?php esc_html_e( "I'll check this later", 'hustle' ); ?></button>

	</div>

</div>
