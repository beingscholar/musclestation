<?php
/**
 * Shortcode Mapper Class
 *
 * Handles shortocde preview functionality
 *
 * @package WP Slick Slider and Image Carousel Pro
 * @since 1.3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpsisac_Pro_Shortcode_Mapper {

	function __construct() {
	}

	/**
	 * Render Fields HTML
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render( $args = array() ) {

		if ( !empty($args) ) {

			$temp_dependency = array();

			// HTML start
			echo '<div id="wpsisac-cust-accordion" class="wpsisac-cust-accordion">';

			foreach ($args as $key => $value) {

				$section_title 	= isset( $value['title'] ) 		? $value['title'] 			: '';
				$section_params	= !empty( $value['params'] )	? (array) $value['params'] 	: '';

				if( ! $section_params ) {
					continue;
				}

				echo '<div class="wpsisac-accordion-header">'.$section_title.'</div>';
				echo '<div class="wpsisac-accordion-cnt">';

				foreach ($value['params'] as $param_key => $param_val) {

					// If field name is not there then return
					if( empty($param_val['name']) ) {
						continue;
					}

					$param_val['allow_empty'] 	= !empty($param_val['allow_empty'])	? 1		: 0;
					$param_val['heading'] 		= !empty($param_val['heading'])	? $param_val['heading']		: '';
					$param_val['name']  		= !empty($param_val['name'])	? $param_val['name']		: '';
					$param_val['value'] 		= !empty($param_val['value']) 	? $param_val['value']		: '';
					$param_val['desc']  		= !empty($param_val['desc']) 	? $param_val['desc']		: '';
					$param_val['id']    		= !empty($param_val['id'])		? $param_val['id']			: 'wpsisac-'.$param_val['name'];
					$param_val['class'] 		= !empty($param_val['class']) 	? 'wpsisac-'.$param_val['name'].' '.$param_val['class'] : 'wpsisac-'.$param_val['name'];
					$param_val['refresh_time']  = !empty($param_val['refresh_time']) 	? $param_val['refresh_time'] : '';

					// Dependency
					if( !empty($param_val['dependency']) && $param_val['dependency']['element'] ) {

						if( isset($param_val['dependency']['value_not_equal_to']) ) {
							$temp_dependency[ $param_val['dependency']['element'] ]['hide'][ $param_val['name'] ] 	= (array)$param_val['dependency']['value_not_equal_to'];
						} else {
							$temp_dependency[ $param_val['dependency']['element'] ]['show'][ $param_val['name'] ] 	= (array)$param_val['dependency']['value'];
						}
					}

					echo '<div class="wpsisac-customizer-row" data-type="'.$param_val['type'].'">';
						$this->render_field_label( $param_val );

						if( !empty( $param_val['type'] ) && (method_exists( $this, 'render_field_'.$param_val['type'] )) ) {
							call_user_func( array($this, 'render_field_'.$param_val['type']), $param_val );
						} else {
							call_user_func( array($this, 'render_field_text'), $param_val );
						}

						$this->render_field_desc( $param_val );
					echo '</div><!-- end .wpsisac-customizer-row -->';
				}
				echo '</div><!-- end .wpsisac-accordion-cnt -->';
			}
			echo '</div><!-- end .wpsisac-cust-accordion -->';

			// Dependency Value
			if( $temp_dependency ) {
				echo '<div class="wpsisac-cust-conf wpsisac-cust-dependency" data-dependency="'.htmlspecialchars( json_encode( $temp_dependency ) ).'"></div>';
			}
		} else {
			echo '<p>Sorry, No Shortcode Parameter Found.</p>';
		}
	}

	/**
	 * Render Field Label
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_label( $args ) {
?>

		<?php if( $args['heading'] ) { ?>
		<label class="wpsisac-customizer-lbl" for="<?php echo $args['id']; ?>"><?php echo $args['heading']; ?></label>
		<?php } ?>

<?php }

	/**
	 * Render Field Description
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_desc( $args ) {
?>

		<?php if( $args['desc'] ) { ?>
		<span class="description"><?php echo $args['desc']; ?></span>
		<?php } ?>

<?php }

	/**
	 * Render Text Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_text( $args ) {
		$refresh_time 	= ( $args['refresh_time'] ) ? "data-timeout='{$args['refresh_time']}'" 	: '';
		$allow_empty 	= ( $args['allow_empty'] ) 	? "data-empty='{$args['allow_empty']}'"		: '';
?>

		<input type="text" id="<?php echo $args['id']; ?>" class="<?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" value="<?php echo $args['value']; ?>" data-default="<?php echo wpsisac_pro_esc_attr( $args['value'] ); ?>" <?php echo $allow_empty.' '.$refresh_time; ?> />

<?php }

	/**
	 * Render Number Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_number( $args ) {

		$refresh_time 	= ( $args['refresh_time'] ) ? "data-timeout='{$args['refresh_time']}'" 	: '';
		$min    		= !empty($args['min'])	? $args['min'] 	: 0;
		$max 			= !empty($args['max'])	? $args['max'] 	: '';
		$step  			= !empty($args['step'])	? $args['step'] : '';
?>		
		<input type="number" id="<?php echo $args['id']; ?>" class="<?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" value="<?php echo $args['value']; ?>" step="<?php echo $step; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" data-default="<?php echo wpsisac_pro_esc_attr( $args['value'] ); ?>" <?php echo $refresh_time; ?> />

<?php }

	/**
	 * Render Select Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_dropdown( $args ) {

		$refresh_time 	= ( $args['refresh_time'] ) ? "data-timeout='{$args['refresh_time']}'" 	: '';
		$default 		= !empty($args['default']) 	? (array)$args['default'] 	: array();
		$args['value'] 	= !empty($args['value']) 	? (array)$args['value'] 	: array();

		if( empty($default) ) {
			$default[] = key( $args['value'] );
		}
?>

		<select id="<?php echo $args['id']; ?>" class="<?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" <?php echo (!empty( $args['multi'] )) ? 'multiple' : ''; ?> data-default="<?php echo wpsisac_pro_esc_attr( implode(',', $default) ); ?>" <?php echo $refresh_time; ?>>
			<?php if( $args['value'] && is_array($args['value']) ) {
				foreach ($args['value'] as $select_key => $select_value) { ?>

					<option <?php echo (in_array($select_key, $default)) ? 'selected' : ''; ?> value="<?php echo $select_key; ?>"><?php echo $select_value; ?></option>

			<?php } } ?>
		</select>

<?php }

	/**
	 * Render Radio Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_radio( $args ) {

		$default 		= !empty($args['default']) 	? $args['default'] 		: '';
		$args['value'] 	= !empty($args['value']) 	? (array)$args['value'] : '';

		if( $args['value'] && is_array($args['value']) ) {
			foreach ($args['value'] as $select_key => $select_value) { ?>
				<label class="wpsisac-cust-field-lbl wpsisac-cust-radio-lbl" for="<?php echo $args['id'].'-'.$select_key; ?>">
					<input type="radio" id="<?php echo $args['id'].'-'.$select_key; ?>" class="<?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" value="<?php echo $select_key; ?>" <?php echo ($select_key == $default)? 'checked' : '' ; ?> />
					<span><?php echo $select_value; ?></span>
				</label>
		<?php } }
	}

	/**
	 * Render Checkbox Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_checkbox( $args ) {

		$default 		= !empty($args['default']) 	? (array)$args['default'] 	: array();
		$args['value'] 	= !empty($args['value']) 	? (array)$args['value'] 	: '';

		if( $args['value'] && is_array($args['value']) ) {
			foreach ($args['value'] as $select_key => $select_value) { ?>
				<label class="wpsisac-cust-field-lbl wpsisac-cust-checkbox-lbl" for="<?php echo $args['id'].'-'.$select_key; ?>">
					<input type="checkbox" id="<?php echo $args['id'].'-'.$select_key; ?>" class="<?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" value="<?php echo $select_key; ?>" <?php echo (in_array($select_key, $default)) ? 'checked' : ''; ?> />
					<span><?php echo $select_value; ?></span>
				</label>
		<?php } }
	}

	/**
	 * Render Textarea Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_textarea( $args ) {
		$refresh_time = ( $args['refresh_time'] ) ? "data-timeout='{$args['refresh_time']}'" 	: '';
?>

		<textarea id="<?php echo $args['id']; ?>" class="<?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" <?php echo $refresh_time; ?>><?php echo $args['value']; ?></textarea>

<?php		
	}

	/**
	 * Render Text Field
	 * 
	 * @package WP Slick Slider and Image Carousel Pro
	 * @since 1.3.3
	 */
	function render_field_colorpicker( $args ) { ?>

		<input type="text" id="<?php echo $args['id']; ?>" class="wpsisac-cust-color-box <?php echo $args['class']; ?>" name="<?php echo $args['name']; ?>" value="<?php echo $args['value']; ?>" data-default="<?php echo wpsisac_pro_esc_attr( $args['value'] ); ?>" />

<?php }
}