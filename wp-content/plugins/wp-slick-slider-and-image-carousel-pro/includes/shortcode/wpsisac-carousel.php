<?php/** * 'slick-carousel-slider' Shortcode *  * @package WP Slick Slider and Image Carousel Pro * @since 1.0.0 */if ( ! defined( 'ABSPATH' ) ) {	exit; // Exit if accessed directly}function wpsisac_pro_carousel_slider( $atts, $content = null ) {	// Shortcode Parameter	$atts = shortcode_atts(array(		'limit' 				=> 15,		'category' 				=> '',		'include_cat_child'		=> 'true',		'design' 				=> 'prodesign-1',		'image_fit' 			=> 'true',		'image_size' 			=> 'large',		'show_content' 			=> 'true',		'slidestoshow' 			=> 3,		'loop'					=> 'true',		'slidestoscroll' 		=> 1,		'dots' 					=> 'true',		'arrows' 				=> 'true',		'autoplay' 				=> 'true',		'autoplay_interval' 	=> 3000,		'speed' 				=> 600,		'centermode' 			=> 'false',		'center_padding' 		=> 0,		'hover_pause'			=> 'true',		'focus_pause'			=> 'false',		'show_read_more'		=> 'true',		'read_more_text'		=> __('Read More', 'wp-slick-slider-and-image-carousel'),		'sliderheight' 			=> '',		'rtl'					=> '',		'link_target'			=> 'self',		'order'					=> 'DESC',		'orderby'				=> 'date',		'exclude_cat'			=> array(),		'exclude_post' 			=> array(),		'posts'					=> array(),		'arrow_design' 			=> 'design-1', /* Design 1 to 8 */		'dots_design' 			=> 'design-1', /* Design 1 to 12 */		'query_offset'			=> '',		'lazyload'          	=> '',		'extra_class'			=> '',		'className'				=> '',		'align'					=> '',	), $atts, 'slick-carousel-slider');	$shortcode_designs 			= wpsisac_pro_carousel_designs();	$atts['limit']				= wpsisac_pro_clean_number( $atts['limit'], 15, 'number' );	$atts['slidestoshow']		= wpsisac_pro_clean_number( $atts['slidestoshow'], 3 );	$atts['slidestoscroll']		= wpsisac_pro_clean_number( $atts['slidestoscroll'], 1 );	$atts['autoplay_interval']	= wpsisac_pro_clean_number( $atts['autoplay_interval'], 3000 );	$atts['speed']				= wpsisac_pro_clean_number( $atts['speed'], 600 );	$atts['center_padding']		= wpsisac_pro_clean_number( $atts['center_padding'], 0 );	$atts['sliderheight']		= wpsisac_pro_clean_number( $atts['sliderheight'], '' );	$atts['query_offset']		= wpsisac_pro_clean_number( $atts['query_offset'], '' );	$atts['category'] 			= ( !empty( $atts['category'] ) ) 			? explode( ',', $atts['category'] ) 			: '';	$atts['include_cat_child']	= ( $atts['include_cat_child'] == 'false' ) ? false 										: true;	$atts['design'] 			= ( $atts['design'] && ( array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ) ) ? trim($atts['design']) : 'prodesign-1';	$atts['image_size'] 		= !empty( $atts['image_size'] ) 			? $atts['image_size'] 							: 'large';	$atts['image_fit']			= ( $atts['image_fit'] == 'false' )			? 0                                     		: 1;	$atts['loop'] 				= ( $atts['loop'] == 'false' ) 				? 'false' 										: 'true';	$atts['dots'] 				= ( $atts['dots'] == 'false' ) 				? 'false' 										: 'true';	$atts['arrows'] 			= ( $atts['arrows'] == 'false' ) 			? 'false' 										: 'true';	$atts['autoplay'] 			= ( $atts['autoplay'] == 'false' ) 			? 'false' 										: 'true';	$atts['centermode'] 		= ( $atts['centermode'] == 'true' ) 		? 'true' 										: 'false';	$atts['hover_pause'] 		= ( $atts['hover_pause'] == 'false' ) 		? 'false' 										: 'true';	$atts['focus_pause'] 		= ( $atts['focus_pause'] == 'true' ) 		? 'true' 										: 'false';	$atts['show_content'] 		= ( $atts['show_content'] == 'true' ) 		? 1 											: 0;	$atts['show_read_more'] 	= ( $atts['show_read_more'] == 'true' ) 	? true 											: false;	$atts['read_more_text'] 	= !empty( $atts['read_more_text'] ) 		? $atts['read_more_text'] 						: __('Read More', 'wp-slick-slider-and-image-carousel');	$atts['link_target'] 		= ( $atts['link_target'] == 'blank' ) 		? '_blank' 										: '_self';	$atts['order']				= ( strtolower( $atts['order'] ) == 'asc' ) ? 'ASC' 										: 'DESC';	$atts['orderby']			= !empty( $atts['orderby'] ) 				? $atts['orderby'] 								: 'date';	$atts['exclude_cat']		= !empty( $atts['exclude_cat'] )			? explode( ',', $atts['exclude_cat'] ) 			: array();	$atts['exclude_post']		= !empty( $atts['exclude_post'] )			? explode( ',', $atts['exclude_post'] ) 		: array();	$atts['posts']				= !empty( $atts['posts'] )					? explode( ',', $atts['posts'] ) 				: array();	$atts['slider_height_css'] 	= ( !empty( $atts['sliderheight'] ) )		? "style='height:{$atts['sliderheight']}px;'" 	: '';	$atts['arrow_design']		= ( !empty( $atts['arrow_design'] ) )		? $atts['arrow_design'] 						: 'design-1';	$atts['dots_design']		= ( !empty( $atts['dots_design'] ) )		? $atts['dots_design'] 							: 'design-1';	$atts['lazyload'] 			= ( $atts['lazyload'] == 'ondemand' || $atts['lazyload'] == 'progressive' ) ? wpsisac_pro_clean( $atts['lazyload'] ) : '';	$atts['align']				= ( !empty( $atts['align'] ) )					? 'align'.$atts['align']						: '';	$atts['extra_class']		= $atts['extra_class'] .' '. $atts['align'] .' '. $atts['className'];	$atts['extra_class']		= wpsisac_sanitize_html_classes( $atts['extra_class'] );	extract( $atts );	// For RTL	if( empty( $rtl ) && is_rtl() ) {		$rtl = 'true';	} elseif ( $rtl == 'true' ) {		$rtl = 'true';	} else {		$rtl = 'false';	}	// Enqueus required script	wp_enqueue_script( 'wpos-slick-jquery' );	wp_enqueue_script( 'wpsisac-pro-public-script' );	// Taking some global	global $post;	// Taking some variables	$atts['count'] 		= 1;	$atts['unique']		= wpsisac_pro_get_unique();	// Main Class Variable	$atts['css_clr']  = "wpsisac-{$design}";	$atts['css_clr']  .= " wpsisac-arrow-{$arrow_design}";	$atts['css_clr']  .= " wpsisac-dots-{$dots_design}";	$atts['css_clr']	.= ( $image_fit ) 	? ' wpsisac-image-fit'	: '';	// WP Query Parameters	$args = array ( 		'post_type'				=> WPSISAC_PRO_POST_TYPE,		'post_status' 			=> array( 'publish' ),		'orderby'				=> $orderby, 		'order'					=> $order,		'posts_per_page' 		=> $limit,		'post__not_in'			=> $exclude_post,		'post__in'				=> $posts,		'offset'				=> $query_offset,		'ignore_sticky_posts'	=> true,	);	// Category Parameter	if( $category != "" ) {		$args['tax_query'] = array(									array(											'taxonomy' 			=> WPSISAC_PRO_CAT,											'field' 			=> 'term_id',											'terms' 			=> $category,											'include_children'	=> $include_cat_child,										));	} else if( !empty($exclude_cat) ) {		$args['tax_query'] = array(									array(										'taxonomy' 			=> WPSISAC_PRO_CAT,										'field' 			=> 'term_id',										'terms' 			=> $exclude_cat,										'operator'			=> 'NOT IN',										'include_children'	=> $include_cat_child,										));	}	// WP Query Parameters	$query = new WP_Query( $args );	$post_count = $query->post_count;	// Slidertoshow and Centermode Condition	$slidestoshow 		= (!empty($slidestoshow) && $slidestoshow <= $post_count) ? $slidestoshow : $post_count;	$centermode			= ($centermode == 'true' && $slidestoshow % 2 != 0 && $slidestoshow != $post_count) ? 'true' : 'false';	$atts['css_clr'] 	.= ( $centermode == 'true' ) ? ' wpsisac-center-mode'	: '';	// Slider configuration	$atts['slider_conf'] = compact( 'dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed', 'design', 'rtl', 'loop', 'slidestoshow', 'center_padding', 'slidestoscroll', 'centermode', 'hover_pause', 'focus_pause', 'lazyload' );	ob_start();	// If post is there	if ( $query->have_posts() ) :		wpsisac_get_template( 'carousel/loop-start.php', $atts ); // loop start		while ( $query->have_posts() ) : $query->the_post();			$atts['slider_img'] 		= wpsisac_pro_get_post_featured_image( $post->ID, $image_size, true );			$atts['read_more_url'] 		= get_post_meta( $post->ID, 'wpsisac_slide_link', true );			$atts['slick_post_title']	= get_the_title();			wpsisac_get_template( "carousel/{$design}.php", $atts ); // design file 			$atts['count']++;		endwhile;		wpsisac_get_template( 'carousel/loop-end.php', $atts ); // loop end	endif; // end have_post()	wp_reset_postdata(); // Reset WP Query	$content .= ob_get_clean();	return $content;}// 'slick-carousel-slider' shortcodeadd_shortcode('slick-carousel-slider', 'wpsisac_pro_carousel_slider');