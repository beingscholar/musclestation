<div style="width: 850px; margin: 0 auto;">
<div style="text-align: center; margin-bottom: 20px;"><img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/muscle-station-logo-1.png" alt="Logo" width="200" /></div>
<img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/12/THANKYOU-3-scaled.jpg" alt="Banner" style="max-width: 100%; display: block;" />
<p style="color: #000; font-weight: bold; font-size: 24px; text-align: center; margin-top: 15px;">Welcome to the Muscle Station</p>

<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
 ?>

<?php /* translators: %s: Customer billing full name */ ?>
<p><?php printf( esc_html__( 'You’ve received the following order from %s:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */?>

<table style="
        width: 100%;
        margin-top: 30px;
        text-align: left;
        border: none;
        table-layout: fixed;
        border-collapse: collapse;
      ">
      <tbody><tr>
        <td>
          <p style="color: #000; font-size: 16px; margin-top: 0">
            <strong>Muscle Station</strong>
          </p>
          <p style="color: #000; margin-top: 3px; font-size: 16px">
            Australia Victoria 3029
          </p>
          <p style="color: #000; margin-top: 3px; font-size: 16px">
            <a href="mailto: info@musclestation.com.au" style="color: #000000; text-decoration: none">info@musclestation.com.au</a>
          </p>
          <p style="color: #000; margin-top: 3px; font-size: 16px">
            <a href="https://musclestation.com.au/" target="_blank" style="color: #000000; text-decoration: none">www.musclestation.com.au</a>
          </p>
        </td>
        <td style="text-align: right">
          <a href="https://www.facebook.com/musclestationsupplement" target="_blank" style="text-decoration: none; display: inline-block">
            <img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/fb-contact.png" alt="Social" width="40" height="40">
          </a>

          <a href="https://www.instagram.com/musclestationsupplements/" target="_blank" style="
              text-decoration: none;
              display: inline-block;
              margin-left: 10px;
            ">
            <img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/ig-logo.png" alt="Social" width="40" height="40">
          </a>

          <a href="https://www.youtube.com/channel/UCE9Lgjv8Jw1tO6C-Vu1Qt7w" target="_blank" style="
              text-decoration: none;
              display: inline-block;
              margin-left: 10px;
            ">
            <img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/yt.png" alt="Social" width="40" height="40">
          </a>
        </td>
      </tr>
    </tbody></table>

</div>


