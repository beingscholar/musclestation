<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Electro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div id="sidebar" class="sidebar" role="complementary">
<?php
	if ( is_active_sidebar( 'shop-sidebar-widgets' ) ) {

        if ( is_product() && apply_filters( 'electro_enable_single_product_sidebar', false ) ) {
            $sidebar_id = 'single-product-sidebar-widgets';
        } else {
            $sidebar_id = 'shop-sidebar-widgets';
        }
        if($sidebar_id === 'single-product-sidebar-widgets') {
?>

  <div class="feature-wrapper bottom-border">
    <!-- <div class="box-brand">
      <a class="fade-on-hover" href="https://musclestation.com.au/brandDetails/25" title="Click to see more Brands from PRO SUPPS" style="opacity: 1;">
      <img alt="PRO SUPPS" src="https://musclestation.com.au/public/upload/1591196995999_100.jpg">
      </a>
    </div> -->

    <?php 
      $brands = wp_get_post_terms(get_the_ID(), 'pwb-brand');
      if (!is_wp_error($brands)) {

        if (sizeof($brands) > 0) {
  
          $show_as = get_option('wc_pwb_admin_tab_brands_in_single');
  
          if ($show_as != 'no') {
  
            do_action('pwb_before_single_product_brands', $brands);
  
            echo '<div class="pwb-single-product-brands pwb-clearfix">';
  
            if ($show_as == 'brand_link') {
              $before_brands_links = '<span class="pwb-text-before-brands-links">';
              $before_brands_links .= apply_filters('pwb_text_before_brands_links', esc_html__('Brands', 'perfect-woocommerce-brands'));
              $before_brands_links .= ':</span>';
              echo apply_filters('pwb_html_before_brands_links', $before_brands_links);
            }
  
            foreach ($brands as $brand) {
              $brand_link = get_term_link($brand->term_id, 'pwb-brand');
              $attachment_id = get_term_meta($brand->term_id, 'pwb_brand_image', 1);
              $brand_banner = get_term_meta($brand->term_id, 'pwb_brand_banner', true);
              $image_size = 'thumbnail';
              $image_size_selected = get_option('wc_pwb_admin_tab_brand_logo_size', 'thumbnail');
              if ($image_size_selected != false) {
                $image_size = $image_size_selected;
              }
  
              // $attachment_html = wp_get_attachment_image($attachment_id, $image_size);
              $attachment_html = wp_get_attachment_image($brand_banner, 'full', false);
  
              if (!empty($attachment_html) && $show_as == 'brand_image' || !empty($attachment_html) && !$show_as) {
                echo '<a href="' . $brand_link . '" title="' . $brand->name . '">' . $attachment_html . '</a>';
                // echo wp_get_attachment_image($brand_banner, 'full', false);
              } else {
                echo '<a href="' . $brand_link . '" title="' . esc_html__('View brand', 'perfect-woocommerce-brands') . '">' . $brand->name . '</a>';
              }
            }
            echo '</div>';
  
            do_action('pwb_after_single_product_brands', $brands);
          }
        }
      }
    ?>
  </div>
  <ul class="delivery-product">
    <li>
      <img alt="" src="https://musclestation.com.au/public/frontendAssets/skin/frontend/ultimo/nwh/images/newdesign/need-help.png">
      <div class="std">
        <h3>Need help?</h3>
        <span>Call <strong><a href="tel:0414209565">0414209565</a></strong> <br>or <a href="/contact/">Email Us</a></span>
      </div>
    </li>
    <li>
      <img alt="" src="https://musclestation.com.au/public/frontendAssets/skin/frontend/ultimo/nwh/images/watch1.png">
      <div class="std">
        <h3>SAME DAY DISPATCH ORDER BEFORE 3PM AEST Guarantee</h3>
        <!-- <span>Found a better price? We'll beat it! <a href="/best-price-guarantee.html">More Info</a></span> -->
      </div>
		</li>
		<li>
      <img alt="" src="/wp-content/uploads/2020/11/muscle-station-100-.png">
      <div class="std">
        <h3>RETAIL PRICE MATCH GUARANTEED</h3>
        <!-- <span>Guaranteed</span> -->
      </div>
    </li>
  </ul>
  <div class="gift_bg">
    <div class="free_gift">
      <div class="gif-img">
        <img src="https://musclestation.com.au/public/frontendAssets/skin/frontend/ultimo/nwh/images/newdesign/transportation.png">
      </div>
      <div class="gif-message">
        <h2 class="ampromo-so-close" style="color:white;">YOU'VE ALMOST EARNED A FREE SHIPPING!
        </h2>
			</div>
			<div class="wrap">
			<?php 
				$cart_total  = WC()->cart->total;
				$cart_remaining  = 199 - WC()->cart->total;
				if($cart_remaining > 0) { 
				?>
					<span>Add another <strong>$<?php echo $cart_remaining; ?></strong> to your cart to receive your <i>FREE SHIPPING.</i></span>
					<em>Spend over <strong>$199</strong> and recieve a free Shipping!</em>
				<?php } else { ?>
					<em>YOU'VE EARNED A FREE SHIPPING!</em>
				<?php } ?>
			</div>
    </div>
  </div>

<?php
        } else {
            dynamic_sidebar( $sidebar_id );
        }

	} else {

		do_action( 'electro_default_shop_sidebar_widgets' );
	}
?>
</div><!-- /.sidebar-shop -->