<?php
/**
 * Template for WP Slick Slider and Image Carousel Pro -Loop Start
 *
 * This template can be overridden by copying it to yourtheme/wp-slick-slider-and-image-carousel-pro/slider/loop-start.php
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @version 1.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpsisac-slider-wrp wpsisac-clearfix <?php echo $extra_class; ?>" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>">
	<div id="wpsisac-pro-slick-slider-<?php echo $unique; ?>" class="wpsisac-slick wpsisac-slick-slider wpsisac-clearfix <?php echo $css_clr; ?>" <?php echo $slider_as_nav_for; ?>>