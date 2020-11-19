<?php
/**
 * electro engine room
 *
 * @package electro
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */


/**
 * Add a custom product data tab
 */
/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'PRODUCCT DESCRIPTION' );		// Rename the description tab
	

	return $tabs;

}
/**
 * Remove product data tabs
 */
/**
 * @snippet       Add to Cart Quantity drop-down - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
function woocommerce_quantity_input( $args = array(), $product = null, $echo = true ) {
  
   if ( is_null( $product ) ) {
      $product = $GLOBALS['product'];
   }
 
   $defaults = array(
      'input_id' => uniqid( 'quantity_' ),
      'input_name' => 'quantity',
      'input_value' => '1',
      'classes' => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text' ), $product ),
      'max_value' => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
      'min_value' => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
      'step' => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
      'pattern' => apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
      'inputmode' => apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
      'product_name' => $product ? $product->get_title() : '',
   );
 
   $args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );
  
   // Apply sanity to min/max args - min cannot be lower than 0.
   $args['min_value'] = max( $args['min_value'], 0 );
   // Note: change 20 to whatever you like
   $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : 30;
 
   // Max cannot be lower than min if defined.
   if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
      $args['max_value'] = $args['min_value'];
   }
  
   $options = '';
    
   for ( $count = $args['min_value']; $count <= $args['max_value']; $count = $count + $args['step'] ) {
 
      // Cart item quantity defined?
      if ( '' !== $args['input_value'] && $args['input_value'] >= 1 && $count == $args['input_value'] ) {
        $selected = 'selected';      
      } else $selected = '';
 
      $options .= '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
 
   }
     
   $string = '<div class="quantity"><span>Quantity</span><select name="' . $args['input_name'] . '">' . $options . '</select></div>';
 
   if ( $echo ) {
      echo $string;
   } else {
      return $string;
   }
  
}

//Remove Price Range
add_filter('woocommerce_variable_sale_price_html', 'detect_variation_price_format', 10, 2);
add_filter('woocommerce_variable_price_html', 'detect_variation_price_format', 10, 2);
function detect_variation_price_format($price, $product) {

   // Main Price
   $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
   /* echo '<pre>';
   print_r($prices[0]);
   echo '</pre>'; */
   if ($prices[0] !== $prices[1] && is_product()) {
      $price = $prices[0] !== $prices[1] ? sprintf(__('', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
   }
    // Main Price
    /* $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
    if ($prices[0] !== $prices[1]) {
        $price = $prices[0] !== $prices[1] ? sprintf(__('', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
    } */
    // Sale Price
    $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
    sort($prices);
    $saleprice = $prices[0] !== $prices[1] ? sprintf(__('', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
    if ($price !== $saleprice) {
        $price = '<ins>' . $price . '</ins>';
    }
    return $price;
}
//Move Variations price above variations to have the same template even if variations prices are the same
remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
add_action('woocommerce_before_variations_form', 'woocommerce_single_variation', 10);

function bd_rrp_sale_price_html( $price, $product ) {
   if ( $product->is_on_sale() && $price) {
      $has_sale_text = array(
         '<ins>' => '<span class="from-price">From: </span> ',
         '<del>' => '<br/><span class="rrp-price">RRP: </span>'
      );
      $return_string = str_replace(array_keys( $has_sale_text ), array_values( $has_sale_text ), $price);
   } else {
      $return_string = 'RRP: ' . $price;
   }
   return $return_string;
}
add_filter( 'woocommerce_get_price_html', 'bd_rrp_sale_price_html', 100, 2 );