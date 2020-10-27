<?php
/**
 * Ad-block trigger settings.
 *
 * @package Hustle
 * @since 4.3.0
 */

?>
<div class="sui-form-field">

	<label for="hustle-trigger-adblock" class="sui-toggle">
		<input type="checkbox"
			id="hustle-trigger-adblock"
			name="trigger_on_adblock"
			data-attribute="triggers.on_adblock"
			aria-labelledby="hustle-trigger-adblock-label"
			aria-describedby="hustle-trigger-adblock-description"
			<?php checked( $triggers['on_adblock'], '1' ); ?>
		/>
		<span class="sui-toggle-slider" aria-hidden="true"></span>

		<span id="hustle-trigger-adblock-label" class="sui-toggle-label"><?php esc_html_e( 'Trigger when adblock is detected', 'hustle' ); ?></span>

		<?php /* translators: module type in small caps and in singular */ ?>
		<span id="hustle-trigger-adblock-description" class="sui-description" style="margin-top: 0;"><?php printf( esc_html__( 'Enabling this will trigger the %s everytime an AdBlock is detected in your visitor’s browser.', 'hustle' ), esc_html( $smallcaps_singular ) ); ?></span>
	</label>

</div>
