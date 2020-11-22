<?php
/**
 * Template for WP Slick Slider and Image Carousel Pro - prodesign-20
 *
 * This template can be overridden by copying it to yourtheme/wp-slick-slider-and-image-carousel-pro/carousel/prodesign-20.php
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @version 1.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpsisac-slick-image-slide">
	<div class="wpsisac-slide-wrap">
	<a class="wpsisac-link-overlay" href="<?php echo esc_url($read_more_url); ?>" target="<?php echo $link_target; ?>"></a>
		<div class="wpsisac-img-wrap" <?php echo $slider_height_css; ?>>
			<?php if( $slider_img ) { ?>
				<img class="wpsisac-slider-img" src="<?php if( empty($lazyload) ) { echo esc_url($slider_img); } ?>" alt="<?php the_title_attribute(); ?>" <?php if( $lazyload ) { ?>data-lazy="<?php echo esc_url($slider_img); ?>" <?php } ?> />
			<?php } ?>
		</div>

		<div class="wpsisac-slider-content">
			<div class="wpsisac-show-hide-content">
				<?php if($slick_post_title) { ?>
					<h2 class="wpsisac-slide-title"><a class="link-border"><?php echo $slick_post_title; ?></a></h2>
				<?php }
				if($show_content) { ?>
						<div class="wpsisac-slider-short-content"><?php the_content(); ?></div>
				<?php }
				if( !empty($read_more_url) && $show_read_more) { ?>
					<div class="wpsisac-readmore"><a href="<?php echo esc_url($read_more_url); ?>" class="wpsisac-slider-readmore" target="<?php echo $link_target; ?>"><?php esc_html_e( $read_more_text ); ?></a></div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>