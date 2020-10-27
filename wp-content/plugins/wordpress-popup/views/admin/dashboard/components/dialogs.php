<?php
/**
 * Dashboard dialog modals.
 *
 * @package Hustle
 * @since 4.3
 */

// This is false if the flag isn't set. Which means it either was previous to 4.2, or this is a fresh install.
$previous_installed_version = Hustle_Migration::get_previous_installed_version();

// DIALOG: On Upgrade (release highlights).
if ( $this->admin->should_show_highlight_modal( $has_modules, $need_migrate ) ) {
	$this->render( 'admin/dashboard/dialogs/release-highlight' );
}

// DIALOG: On Boarding (Welcome).
$get_show_welcome      = filter_input( INPUT_GET, 'show-welcome', FILTER_VALIDATE_BOOLEAN );
$was_welcome_dismissed = Hustle_Notifications::was_notification_dismissed( Hustle_Dashboard_Admin::WELCOME_MODAL_NAME );

if ( ( ! $previous_installed_version && ! $was_welcome_dismissed && ! $has_modules ) || $get_show_welcome ) {
	$user     = wp_get_current_user();
	$username = ! empty( $user->user_firstname ) ? $user->user_firstname : $user->user_login;
	$this->render( 'admin/dashboard/dialogs/fresh-install', array( 'username' => $username ) );
}

// DIALOG: Visibility behavior updated.
$review_conditions        = filter_input( INPUT_GET, 'review-conditions', FILTER_VALIDATE_BOOLEAN );
$migrated_40              = Hustle_Migration::is_migrated( 'hustle_40_migrated' );
$was_visibility_dismissed = Hustle_Notifications::was_notification_dismissed( '41_visibility_behavior_update' );

if ( $review_conditions && $migrated_40 && ! $was_visibility_dismissed ) {
	$version     = Opt_In_Utils::_is_free() ? '7.1' : '4.1';
	$support_url = Opt_In_Utils::_is_free() ? 'https://wordpress.org/support/plugin/wordpress-popup/' : 'https://premium.wpmudev.org/hub/support/#wpmud-chat-pre-survey-modal';

	$this->render(
		'admin/dashboard/dialogs/review-conditions',
		array(
			'version'     => $version,
			'support_url' => $support_url,
		)
	);
}

// DIALOG: On Boarding (Migrate).
$was_migrate_dismissed = Hustle_Notifications::was_notification_dismissed( Hustle_Dashboard_Admin::MIGRATE_MODAL_NAME );
$show_migrate          = filter_input( INPUT_GET, 'show-migrate', FILTER_VALIDATE_BOOLEAN );
if ( ( $need_migrate && ! $was_migrate_dismissed ) || $show_migrate ) {
	$user     = wp_get_current_user();
	$username = ! empty( $user->user_firstname ) ? $user->user_firstname : $user->user_login;
	$this->render( 'admin/dashboard/dialogs/migrate-data', array( 'username' => $username ) );
}

// DIALOG: Delete.
$this->render( 'admin/commons/sui-listing/dialogs/delete-module' );

// DIALOG: Dissmiss migrate tracking notice modal confirmation.
if ( Hustle_Notifications::is_show_migrate_tracking_notice() ) {
	$this->render( 'admin/dialogs/migrate-dismiss-confirmation' );
}
