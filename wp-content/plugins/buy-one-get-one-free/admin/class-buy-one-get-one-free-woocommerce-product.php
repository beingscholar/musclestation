<?php

class Buy_One_Get_One_Free_Woocommerce_Product{

    public function __construct( ) {
		add_action( 'woocommerce_product_data_tabs', array($this,'productTab') );
		/** Adding order preparation days */
		add_action( 'woocommerce_product_data_panels', array($this,'order_preparation_days') );
		add_action( 'woocommerce_process_product_meta', array($this,'order_preparation_days_save') );
    }

    function productTab($tabs){
        $tabs['pisol_bogo'] = array(
            'label'    => 'BOGO',
            'target'   => 'pisol_bogo',
            'priority' => 21,
            'class' => 'hide_if_grouped hide_if_external'
        );
        return $tabs;
    }
    
    function order_preparation_days() {
		echo '<div id="pisol_bogo" class="panel woocommerce_options_panel hidden">';
		woocommerce_wp_checkbox( array(
            'label' => __("Enable BOGO"), 
            'id' => 'pisol_enable_bogo', 
            'name' => 'pisol_enable_bogo', 
            'description' => __("Enable BOGO for this product")
          ) );
          echo '<div id="pisol-bogo-extra">';
          echo '<div id="pisol-promotion">';
          echo '<div class="pisol-alert">'.__('Buy PRO version of BOGO plugin to access more advanced features.','buy-one-get-one-free-woocommerce').'</div>';
          echo '<a class="" href="'.PI_BOGO_BUY_URL.'" target="_blank">';
           new pisol_promotion('pisol_bogo_installation_date');
          echo '</a>';
          echo '</div>';
          echo '<div class="free-version">';
          woocommerce_wp_text_input( array(
            'label' => __("Quantity to buy",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_product_quantity', 
            'name' => 'pisol_product_quantity', 
            'type' => 'number', 
            'default'=> 1,
            'placeholder'=>1,
            'custom_attributes' => array(
              'step' => '1',
              'min' => '1',
            ),
            'description' => __("Quantity to buy to qualify for free product",'buy-one-get-one-free-woocommerce')
          ) );
          woocommerce_wp_text_input( array(
            'label' => __("Quantity of product given free",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_free_product_quantity', 
            'name' => 'pisol_free_product_quantity', 
            'type' => 'number',
            'default'=> 1, 
            'placeholder'=>1,
            'custom_attributes' => array(
              'step' => '1',
              'min' => '1',
            ),
            'description' => __("How much quantity of the product will be given free",'buy-one-get-one-free-woocommerce')
          ) );
          woocommerce_wp_text_input( array(
            'label' => __("Free Product",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_free_product_id', 
            'name' => 'pisol_free_product_id', 
            'type' => 'number',
            'custom_attributes' => array(
              'step' => '1',
            ),
            'description' => __("Product id of the product that will be offered as free product, if left empty same product will be offered for free",'buy-one-get-one-free-woocommerce')
          ) );
          woocommerce_wp_text_input( array(
            'label' => __("Message shown when offer has started",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_free_product_msg', 
            'name' => 'pisol_free_product_msg', 
            'type' => 'text',
            'description' => __("Message shown on the product page, use this short codes, [buy_quantity] => quantity of product you have to buy, [free_quantity]=> quantity that you will get free, [free_name] => Free product title, [free_price] => free product original price, [end_date_time]=> offer end date and time, [start_date_time] => offer start date and time",'buy-one-get-one-free-woocommerce')
          ) );
          
          woocommerce_wp_text_input( array(
            'label' => __("Offer start date and time",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_bogo_start_time', 
            'name' => 'pisol_bogo_start_time', 
            'type' => 'text',
            'class' => 'pisol_date_time_picker',
            'description' => __("Date and time when the offer will become active, leave blank if you want it to start right away",'buy-one-get-one-free-woocommerce'),
            'custom_attributes' => array('readonly' => 'readonly')
          ) );
      
          woocommerce_wp_text_input( array(
            'label' => __("Message shown before the order start",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_free_product_before_offer_msg', 
            'name' => 'pisol_free_product_before_offer_msg', 
            'type' => 'text',
            'description' => __("Message shown on the product page before the offer start time, use this short codes, [buy_quantity] => quantity of product you have to buy, [free_quantity]=> quantity that you will get free, [free_name] => Free product title, [free_price] => free product original price, [end_date_time]=> offer end date and time, [start_date_time] => offer start date and time",'buy-one-get-one-free-woocommerce')
          ) );
      
          woocommerce_wp_text_input( array(
            'label' => __("Offer end date and time",'buy-one-get-one-free-woocommerce'), 
            'id' => 'pisol_bogo_end_time', 
            'name' => 'pisol_bogo_end_time', 
            'type' => 'text',
            'class' => 'pisol_date_time_picker',
            'description' => __("Date and time when the offer will become inactive, leave blank if you want it to last for ever",'buy-one-get-one-free-woocommerce'),
            'custom_attributes' => array('readonly' => 'readonly')
          ) );
          echo '</div>';
          echo '</div>';
		echo '</div>';
    }
    
    function order_preparation_days_save( $post_id ) {
        $product = wc_get_product( $post_id );
        $value = isset($_POST['pisol_enable_bogo']) ? 'yes' : 'no';
        $product->update_meta_data( 'pisol_enable_bogo', sanitize_text_field( $value ) );
        $product->save();
   }
    
}

new Buy_One_Get_One_Free_Woocommerce_Product();