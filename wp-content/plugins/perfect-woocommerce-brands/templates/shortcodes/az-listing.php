<?php

/**
 * The template for displaying the a-z Listing
 * @version 1.0.1
 */

defined('ABSPATH') or die('No script kiddies please!');
?>

<?php if (!empty($grouped_brands)) : ?>

  <div class="pwb-az-listing">

    <div class="pwb-az-listing-header">

      <ul class="pwb-clearfix">

        <?php foreach ($grouped_brands as $letter => $brand_group) : ?>
          <li><a href="#<?php echo esc_attr($letter); ?>"><?php echo esc_html($letter); ?></a></li>
        <?php endforeach; ?>

      </ul>

    </div>

    <div class="pwb-az-listing-content">

      <?php foreach ($grouped_brands as $letter => $brand_group) : ?>

        <div id="<?php echo esc_attr($letter); ?>" class="pwb-az-listing-row pwb-clearfix">
          <p class="pwb-az-listing-title"><?php echo esc_attr($letter); ?></p>
          <div class="pwb-az-listing-row-in">

            <?php foreach ($brand_group as $brand) : 
              $brand_banner = get_term_meta($brand['brand_term']->term_id, 'pwb_brand_banner', true);
              $attachment_html = wp_get_attachment_image($brand_banner, 'full', false);
              ?>

              <div class="pwb-az-listing-col">
                <a href="<?php echo get_term_link($brand['brand_term']->term_id); ?>">
                  <?php 
                  echo $attachment_html;
                  // esc_html($brand['brand_term']->name); 
                  ?>
                  
                </a>
              </div>

            <?php endforeach; ?>

          </div>
        </div>

      <?php endforeach; ?>

    </div>

  </div>

<?php endif; ?>