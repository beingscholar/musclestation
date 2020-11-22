<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.2.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix = WPSISAC_PRO_META_PREFIX; // Metabox prefix

// Getting saved values
$read_more_link = get_post_meta( $post->ID, 'wpsisac_slide_link', true );
?>

<table class="form-table wpsisac-post-sett-table">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="wpsisac-more-link"><?php _e('Read More Link', 'wp-slick-slider-and-image-carousel'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo esc_url($read_more_link); ?>" class="large-text wpsisac-more-link" id="wpsisac-more-link" name="<?php echo $prefix; ?>more_link" /><br/>
				<span class="description"><?php _e('Enter read more link. eg. https://www.wponlinesupport.com', 'wp-slick-slider-and-image-carousel'); ?></span>
			</td>
		</tr>
	</tbody>
</table><!-- end .wtwp-tstmnl-table -->