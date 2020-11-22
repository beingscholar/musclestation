<?php
/**
 * Template for WP Slick Slider and Image Carousel Pro -nav-design-4.php
 *
 * This template can be overridden by copying it to yourtheme/wp-slick-slider-and-image-carousel-pro/slider/nav/nav-design.php
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @version 1.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $post; ?>

<div class="wpsisac-slider-nav-<?php echo $unique; ?> wpsisac-slider-nav <?php echo $design; ?> <?php echo $extra_class; ?>">
	<?php while ( $query->have_posts() ) : $query->the_post();
		$slider_nav_img = wpsisac_pro_get_post_featured_image( $post->ID, 'medium', true );
		$nav_cls 		= ( ! $slider_nav_img ) ? 'wpsisac-nav-no-img' : '';
	?>
		<div class="slick-image-nav <?php echo $nav_cls; ?>">
			<?php if( $slider_nav_img ) { ?>
			<img class="wpsisac-slider-nav-img" src="<?php if( empty($lazyload) ) { echo esc_url($slider_nav_img); } ?>" alt="<?php the_title_attribute(); ?>" <?php if($lazyload) { ?>data-lazy="<?php echo esc_url($slider_nav_img); ?>" <?php } ?> />
			<?php } ?>
		</div>
	<?php endwhile; ?>
</div>