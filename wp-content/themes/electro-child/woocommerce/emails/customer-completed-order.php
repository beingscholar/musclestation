<div style="width: 850px; margin: 0 auto;">
<div style="text-align: center; margin-bottom: 20px;">
<a href="https://musclestation.com.au/"><img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/muscle-station-logo-1.png" alt="Logo" width="200" /></a>
</div>
<a href="https://musclestation.com.au/">
<img src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/12/order-delivered-scaled.jpg" alt="Banner" style="max-width: 100%; display: block;" />
</a>
<p style="color: #000; font-weight: bold; font-size: 24px; text-align: center; margin-top: 15px;">Welcome to the Muscle Station</p>


<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
<p><?php esc_html_e( 'We have finished processing your order.', 'woocommerce' ); ?></p>
<p>The Great News is Your Order has been Successful Delivered</p>
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

?>
<div style="padding: 20px; background-color: #e31e31; margin-top: 30px; color: #fff;">
      <p
      style="color: #fff; text-align: center; margin: 0; font-size: 26px;"
      >
      <strong>Muscle Station</strong>
    </p>
    <p
      style="color: #fff; text-align: center; margin-top: 15px; margin-bottom: 0; font-size: 16px"
    >
      Australia Victoria 3029
    </p>
    <p
      style="color: #fff; text-align: center; margin-top: 3px; margin-bottom: 0; font-size: 16px"
    >
      <a
        href="mailto: info@musclestation.com.au"
        style="color: #fff; text-decoration: none"
        >info@musclestation.com.au</a
      >
    </p>
    <p
      style="color: #000; text-align: center; margin-top: 3px; margin-bottom: 0; font-size: 16px"
    >
      <a
        href="https://musclestation.com.au/"
        target="_blank"
        style="color: #fff; text-decoration: none"
        >www.musclestation.com.au</a
      >
    </p>

    <table
      style="
        margin-top: 15px;
        width: 100%;
        border: none;
        table-layout: fixed;
        text-align: center;
        border-collapse: collapse;
      "
    >
      <tr>
        <td>
          <a
            href="https://www.facebook.com/musclestationsupplement"
            target="_blank"
            style="text-decoration: none"
          >
            <img
              src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/fb-contact.png"
              alt="Social"
              width="40"
              height="40"
              style="background: #fff; border: 1px solid #fff; border-radius: 50%;"
            />
          </a>

          <a
            href="https://www.instagram.com/musclestationsupplements/"
            target="_blank"
            style="text-decoration: none; margin-left: 10px"
          >
            <img
              src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/ig-logo.png"
              alt="Social"
              width="40"
              style="background: #fff; border: 1px solid #fff; border-radius: 50%;"
              height="40"
            />
          </a>

          <a
            href="https://www.youtube.com/channel/UCE9Lgjv8Jw1tO6C-Vu1Qt7w"
            target="_blank"
            style="text-decoration: none; margin-left: 10px"
          >
            <img
              src="http://muscles.xxploreautomotive.in/wp-content/uploads/2020/11/yt.png"
              alt="Social"
              width="40"
              style="background: #fff; border: 1px solid #fff; border-radius: 50%;"
              height="40"
            />
          </a>
        </td>
      </tr>
    </table>
    </div>

</div>

