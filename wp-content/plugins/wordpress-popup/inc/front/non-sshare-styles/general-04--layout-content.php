<?php
/**
 * Layout content settings.
 *
 * @package Hustle
 * @since 4.3.0
 */

// phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect

$component = '.hustle-layout .hustle-layout-content';

// SETTINGS: Padding.
$padding_top    = ( '' !== $advanced['layout_content_padding_top'] ) ? $advanced['layout_content_padding_top'] . $advanced['layout_content_padding_unit'] : '0';
$padding_right  = ( '' !== $advanced['layout_content_padding_right'] ) ? $advanced['layout_content_padding_right'] . $advanced['layout_content_padding_unit'] : '0';
$padding_bottom = ( '' !== $advanced['layout_content_padding_bottom'] ) ? $advanced['layout_content_padding_bottom'] . $advanced['layout_content_padding_unit'] : '0';
$padding_left   = ( '' !== $advanced['layout_content_padding_left'] ) ? $advanced['layout_content_padding_left'] . $advanced['layout_content_padding_unit'] : '0';

$padding = $padding_top . ' ' . $padding_right . ' ' . $padding_bottom . ' ' . $padding_left;

$mobile_padding_top    = ( '' !== $advanced['layout_content_padding_top_mobile'] ) ? $advanced['layout_content_padding_top_mobile'] . $advanced['layout_content_padding_unit_mobile'] : $padding_top;
$mobile_padding_right  = ( '' !== $advanced['layout_content_padding_right_mobile'] ) ? $advanced['layout_content_padding_right_mobile'] . $advanced['layout_content_padding_unit_mobile'] : $padding_right;
$mobile_padding_bottom = ( '' !== $advanced['layout_content_padding_bottom_mobile'] ) ? $advanced['layout_content_padding_bottom_mobile'] . $advanced['layout_content_padding_unit_mobile'] : $padding_bottom;
$mobile_padding_left   = ( '' !== $advanced['layout_content_padding_left_mobile'] ) ? $advanced['layout_content_padding_left_mobile'] . $advanced['layout_content_padding_unit_mobile'] : $padding_left;

$mobile_padding = $mobile_padding_top . ' ' . $mobile_padding_right . ' ' . $mobile_padding_bottom . ' ' . $mobile_padding_left;
$mobile_padding = ( ! $is_mobile_enabled || ( $is_mobile_enabled && $default_advanced ) ) ? $padding : $mobile_padding;

// SETTINGS: Border.
$border_top    = ( '' !== $advanced['layout_content_border_top'] ) ? $advanced['layout_content_border_top'] . $advanced['layout_content_border_unit'] : '0';
$border_right  = ( '' !== $advanced['layout_content_border_right'] ) ? $advanced['layout_content_border_right'] . $advanced['layout_content_border_unit'] : '0';
$border_bottom = ( '' !== $advanced['layout_content_border_bottom'] ) ? $advanced['layout_content_border_bottom'] . $advanced['layout_content_border_unit'] : '0';
$border_left   = ( '' !== $advanced['layout_content_border_left'] ) ? $advanced['layout_content_border_left'] . $advanced['layout_content_border_unit'] : '0';

$border_width = $border_top . ' ' . $border_right . ' ' . $border_bottom . ' ' . $border_left;
$border_style = $advanced['layout_content_border_type'];
$border_color = $colors['layout_content_border'];

$mobile_border_top    = ( '' !== $advanced['layout_content_border_top_mobile'] ) ? $advanced['layout_content_border_top_mobile'] . $advanced['layout_content_border_unit_mobile'] : $border_top;
$mobile_border_right  = ( '' !== $advanced['layout_content_border_right_mobile'] ) ? $advanced['layout_content_border_right_mobile'] . $advanced['layout_content_border_unit_mobile'] : $border_right;
$mobile_border_bottom = ( '' !== $advanced['layout_content_border_bottom_mobile'] ) ? $advanced['layout_content_border_bottom_mobile'] . $advanced['layout_content_border_unit_mobile'] : $border_bottom;
$mobile_border_left   = ( '' !== $advanced['layout_content_border_left_mobile'] ) ? $advanced['layout_content_border_left_mobile'] . $advanced['layout_content_border_unit_mobile'] : $border_left;

$mobile_border_width = ( ! $is_mobile_enabled || ( $is_mobile_enabled && $default_advanced ) ) ? $padding : $mobile_border_top . ' ' . $mobile_border_right . ' ' . $mobile_border_bottom . ' ' . $mobile_border_left;
$mobile_border_style = ( ! $is_mobile_enabled || ( $is_mobile_enabled && $default_advanced ) ) ? $border_style : $advanced['layout_content_border_type_mobile'];

// SETTINGS: Colors.
$background_color = $colors['layout_content_bg'];

// ==================================================
// Mobile styles.
$style     .= ' ';
$style     .= $prefix_mobile . $component . ' {';
	$style .= 'padding: ' . $mobile_padding . ';';
	$style .= 'border-width: ' . $mobile_border_width . ';';
	$style .= 'border-style: ' . $mobile_border_style . ';';
	$style .= ( ! $is_vanilla ) ? 'border-color: ' . $border_color . ';' : '';
	$style .= ( ! $is_vanilla ) ? 'background-color: ' . $background_color . ';' : '';
$style     .= '}';

// Desktop styles.
if ( $is_mobile_enabled ) {
	$style         .= $breakpoint . ' {';
		$style     .= $prefix_desktop . $component . ' {';
			$style .= 'padding: ' . $padding . ';';
			$style .= 'border-width: ' . $border_width . ';';
			$style .= 'border-style: ' . $border_style . ';';
		$style     .= '}';
	$style         .= '}';
}
