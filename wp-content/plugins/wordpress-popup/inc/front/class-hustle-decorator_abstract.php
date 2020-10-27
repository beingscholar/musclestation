<?php

/**
 * Class Hustle_Decorator_Abstract
 */
abstract class Hustle_Decorator_Abstract {

	protected $module;

	/**
	 * Instance of the design meta handler of the module.
	 *
	 * @since 4.3.0
	 * @var Hustle_Meta_Base_Design
	 */
	protected $design_meta;

	protected $design;

	/**
	 * Whether the request is for preview.
	 *
	 * @since 4.3.0
	 * @var bool
	 */
	protected $is_preview;

	protected $bp_desktop;
	protected $bp_mobile;

	/**
	 * Gets the string with the module's styles.
	 * The meat of the class.
	 *
	 * @since 4.3.0
	 * @return string
	 */
	abstract protected function get_styles();

	public function __construct( Hustle_Module_Model $module ) {
		$this->module = $module;

		$this->design_meta = $module->get_design();

		$general_settings  = Hustle_Settings_Admin::get_general_settings();
		$mobile_breakpoint = $general_settings['mobile_breakpoint'];

		$this->bp_mobile  = ! empty( $mobile_breakpoint ) && is_int( $mobile_breakpoint ) ? $mobile_breakpoint : 782;
		$this->bp_desktop = $this->bp_mobile + 1;
	}

	public function get_module_styles( $module_type, $is_preview = false ) {

		$this->design = ! $is_preview ? $this->design_meta->to_array() : (array) $this->module->design;

		$this->is_preview = $is_preview;

		$styles = $this->get_styles();

		return $styles;
	}
}
