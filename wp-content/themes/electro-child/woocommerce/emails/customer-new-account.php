<div style="text-align: center; margin-bottom: 20px;"><img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/muscle-station-logo-1.png" alt="Logo" width="200" /></div>
<table style="background-color: #e31e31; width: 100%; border: none; table-layout: fixed; border-collapse: collapse;">
    <tr>
        <td style="width: 25%;"><a href="#" style="display: block; text-align: center; color: #ffffff; font-size: 14px; font-weight: 600; line-height: 42px; text-decoration: none;">CATEGORIES</a></td>
        <td style="width: 25%;"><a href="#" style="display: block; text-align: center; border-left: 1px solid #c6362d; color: #ffffff; font-size: 14px; font-weight: 600; line-height: 42px; text-decoration: none;">BOGO</a></td>
        <td style="width: 25%;"><a href="#" style="display: block; text-align: center; border-left: 1px solid #c6362d; font-size: 14px; font-weight: 600; color: #ffffff; line-height: 42px; text-decoration: none;">NEW</a></td>
        <td style="width: 25%;"><a href="#" style="display: block; font-size: 14px; font-weight: 600; text-align: center; color: #ffffff; border-left: 1px solid #c6362d; line-height: 42px; text-decoration: none;">FIND STORE</a></td>
    </tr>
</table>
<img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/bogos-deal-1-1024x258.jpg" alt="Banner" style="max-width: 100%; display: block;" />
<p style="color: #000; font-weight: bold; font-size: 24px; text-align: center; margin-top: 15px;">Welcome to the Muscle Station</p>

<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>
<?php /* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */ ?>
<p><?php printf( esc_html__( 'Thanks for creating an account on %1$s. Your username is %2$s. You can access your account area to view orders, change your password, and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
	<?php /* translators: %s: Auto generated password */ ?>
	<p><?php printf( esc_html__( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>
<?php endif; ?>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
?>

<p style="color: #000; font-size: 16px; text-align: center; margin-top: 5px;">Enjoy your 10% off on your next order, simply use the below code at checkout to recieve your discount.</p>
<p style="text-align: center; margin: 50px 0;"><span style="background: #fff; margin: 0; padding: 13px 20px 10px; border: 3px dashed #e31e31; border-radius: 5px; font-size: 24px; display: inline-block;">MUSCLE10%OFF</span></p>
<p style="color: #000; text-align: center; font-size: 16px;">You must have an account and be logged in to use this offer, This code is not valid in conjuction with any other offer, excludes all protien bar, snacks & drinks.</p>
<p style="color: #000; text-align: center; font-size: 16px; margin-top: 30px;"><strong>Muscle Station</strong></p>
<p style="color: #000; text-align: center; margin-top: 3px; font-size: 16px;">Australia Victoria 3029</p>
<p style="color: #000; text-align: center; margin-top: 3px; font-size: 16px;"><a href="mailto: info@musclestation.com.au" style="color: #000000; text-decoration: none;">info@musclestation.com.au</a></p>
<p style="color: #000; text-align: center; margin-top: 3px; font-size: 16px;"><a href="https://musclestation.com.au/" target="_blank" style="color: #000000; text-decoration: none;">www.musclestation.com.au</a></p>
<table style="margin-top: 15px; width: 100%; border: none; table-layout: fixed; text-align: center; border-collapse: collapse;">
    <tr>
        <td>
            <a href="https://www.facebook.com/musclestationsupplement" target="_blank" style="text-decoration: none;">
                <img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/fb-contact.png" alt="Social" width="40" height="40" />
            </a>
            <a href="https://www.instagram.com/musclestationsupplements/" target="_blank" style="text-decoration: none; margin-left: 10px;">
                <img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/ig-logo.png" alt="Social" width="40" height="40" />
            </a>
            <a href="https://www.youtube.com/channel/UCE9Lgjv8Jw1tO6C-Vu1Qt7w" target="_blank" style="text-decoration: none; margin-left: 10px;">
                <img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/yt.png" alt="Social" width="40" height="40" />
            </a>
        </td>
    </tr>
</table>
