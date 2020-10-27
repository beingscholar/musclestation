<?php

/**
 * Class Hustle_Module_Model
 *
 * @property Hustle_Module_Decorator $decorated
 */

class Hustle_Module_Model extends Hustle_Model {

	/**
	 * @var $_provider_details object
	 */
	private $_provider_details;

	public static function instance() {
		return new self();
	}

	/**
	 * Get the sub-types for embedded modules.
	 *
	 * @since the beggining of time
	 * @since 4.0 "after_content" changed to "inline"
	 *
	 * @return array
	 */
	public static function get_embedded_types( $with_titles = false ) {
		if ( ! $with_titles ) {
			return array( 'inline', 'widget', 'shortcode' );
		} else {
			return array(
				'inline'    => __( 'Inline', 'hustle' ),
				'widget'    => __( 'Widget', 'hustle' ),
				'shortcode' => __( 'Shortcode', 'hustle' ),
			);
		}
	}

	/**
	 * Get the sub-types for this module.
	 *
	 * @since 4.0
	 *
	 * @return array
	 */
	public function get_sub_types( $with_titles = false ) {
		if ( self::EMBEDDED_MODULE === $this->module_type ) {
			return self::get_embedded_types( $with_titles );
		} elseif ( self::SOCIAL_SHARING_MODULE === $this->module_type ) {
			return Hustle_SShare_Model::get_sshare_types( $with_titles );
		}

		return array();
	}

	/**
	 * Get the possible module types.
	 *
	 * @since 4.0
	 *
	 * @return array
	 */
	public static function get_module_types() {
		return array( self::POPUP_MODULE, self::SLIDEIN_MODULE, self::EMBEDDED_MODULE, self::SOCIAL_SHARING_MODULE );
	}

	/**
	 * Decorates current model
	 *
	 * @return Hustle_Module_Decorator
	 */
	public function get_decorated() {

		if ( ! $this->_decorator ) {
			if ( self::SOCIAL_SHARING_MODULE !== $this->module_type ) {
				$this->_decorator = new Hustle_Decorator_Non_Sshare( $this );
			} else {
				$this->_decorator = new Hustle_Decorator_Sshare( $this );
			}
		}

		return $this->_decorator;
	}

	/**
	 * Content Model based upon module type.
	 *
	 * @return Class
	 */
	public function get_content() {
		$data = $this->get_settings_meta( self::KEY_CONTENT, '{}', true );
		// If redirect url is set then esc it.
		if ( isset( $data['redirect_url'] ) ) {
			$data['redirect_url'] = esc_url( $data['redirect_url'] );
		}

		return new Hustle_Meta_Base_Content( $data, $this );
	}

	/**
	 * Get the content of the data stored under 'emails' meta.
	 *
	 * @since 4.0
	 *
	 * @return Hustle_Popup_Emails
	 */
	public function get_emails() {
		$data = $this->get_settings_meta( self::KEY_EMAILS, '{}', true );

		return new Hustle_Meta_Base_Emails( $data, $this );
	}

	/**
	 * Get the module's settings for the given provider.
	 *
	 * @since 4.0
	 *
	 * @param string $slug
	 * @param bool   $get_cached
	 * @return array
	 */
	public function get_provider_settings( $slug, $get_cached = true ) {
		return $this->get_settings_meta( $slug . self::KEY_PROVIDER, '{}', true, $get_cached );
	}

	/**
	 * Save the module's settings for the given provider.
	 *
	 * @since 4.0
	 *
	 * @param string $slug
	 * @param array  $data
	 * @return array
	 */
	public function set_provider_settings( $slug, $data ) {
		return $this->update_meta( $slug . self::KEY_PROVIDER, $data );
	}

	/**
	 * Get the all-integrations module's settings.
	 * This is not each provider's settings. Instead, these are per module settings
	 * that are applied to all the active providers of this module.
	 *
	 * @since 4.0
	 *
	 * @return array
	 */
	public function get_integrations_settings() {
		$stored = $this->get_settings_meta( self::KEY_INTEGRATIONS_SETTINGS, '{}', true );
		return new Hustle_Meta_Base_Integrations( $stored, $this );
	}

	public function get_design() {
		$stored = $this->get_settings_meta( self::KEY_DESIGN, '{}', true );
		return new Hustle_Meta_Base_Design( $stored, $this );
	}

	/**
	 * Get the stored settings for the "Display" tab.
	 * Used for Embedded.
	 *
	 * @since 4.0
	 *
	 * @return Hustle_Embedded_Display
	 */
	public function get_display() {
		return new Hustle_Meta_Base_Display( $this->get_settings_meta( self::KEY_DISPLAY_OPTIONS, '{}', true ), $this );
	}

	/**
	 * Get the stored settings for the "Visibility" tab.
	 *
	 * @since 4.0
	 *
	 * @return Hustle_Popup_Visibility
	 */
	public function get_visibility() {
		return new Hustle_Meta_Base_Visibility( $this->get_settings_meta( self::KEY_VISIBILITY, '{}', true ), $this );
	}

	/**
	 * Used when populating data with "get".
	 */
	public function get_settings() {
		$saved = $this->get_settings_meta( self::KEY_SETTINGS, '{}', true );

		// The default value for 'triggers' was an empty string in old versions.
		// This will bring php errors if it persists.
		// Let's remove that troubling value and let the module grab the new defaults.
		if ( isset( $saved['triggers'] ) && empty( $saved['triggers'] ) ) {
			unset( $saved['triggers'] );
		}

		if ( self::POPUP_MODULE === $this->module_type ) {
			return new Hustle_Popup_Settings( $saved, $this );

		} elseif ( self::EMBEDDED_MODULE === $this->module_type ) {
			return new Hustle_Meta_Base_Settings( $saved, $this );

		} elseif ( self::SLIDEIN_MODULE === $this->module_type ) {
			return new Hustle_Slidein_Settings( $saved, $this );
		}

		return false;
	}

	/**
	 * Get the stored schedule flags
	 *
	 * @since 4.2.0
	 * @return array
	 */
	public function get_schedule_flags() {
		$default = array(
			'is_currently_scheduled' => '1',
			'check_schedule_at'      => 1,
		);

		return $this->get_settings_meta( 'schedule_flags', $default, true );
	}

	/**
	 * Set the schedule flags.
	 *
	 * @since 4.2.0
	 * @param array $flags
	 * @return void
	 */
	public function set_schedule_flags( $flags ) {
		$this->update_meta( 'schedule_flags', $flags );
	}

	public function get_shortcode_id() {
		return $this->id;
	}

	public function get_custom_field( $key, $value ) {
		$custom_fields = $this->get_content()->__get( 'form_elements' );

		if ( is_array( $custom_fields ) ) {
			foreach ( $custom_fields as $field ) {
				if ( isset( $field[ $key ] ) && $value === $field[ $key ] ) {
					return $field;
				}
			}
		}
	}

	/**
	 * Get wizard page for this module type.
	 *
	 * @since 4.0
	 * @return string
	 */
	public function get_wizard_page() {
		return Hustle_Module_Admin::get_wizard_page_by_module_type( $this->module_type );
	}

	/**
	 * Get the listing page for this module type.
	 *
	 * @since 4.0
	 * @return string
	 */
	public function get_listing_page() {
		return Hustle_Module_Admin::get_listing_page_by_module_type( $this->module_type );
	}

	/**
	 * Get the module's data. Used to display it.
	 *
	 * @since 3.0.7
	 *
	 * @param bool is_preview
	 * @return array
	 */
	public function get_module_data_to_display() {

		if ( 'social_sharing' === $this->module_type ) {
			$data = $this->get_data();

		} else {
			$settings = array( 'settings' => $this->get_settings()->to_array() );
			$data     = array_merge( $settings, $this->get_data() );

		}

		return $data;
	}

	/**
	 * Get the form fields of this module, if any.
	 *
	 * @since 4.0
	 *
	 * @return null|array
	 */
	public function get_form_fields() {

		if ( 'social_sharing' === $this->module_type || 'informational' === $this->module_mode ) {
			return null;
		}

		$emails_data = empty( $this->emails ) ? $this->get_emails()->to_array() : (array) $this->emails;
		/**
		 * Edit module fields
		 *
		 * @since 4.1.1
		 * @param string $form_elements Current module fields.
		 */
		$form_fields = apply_filters( 'hustle_form_elements', $emails_data['form_elements'] );

		return $form_fields;

	}

	/**
	 * Create a new module of the provided mode and type.
	 *
	 * @since 4.0
	 *
	 * @param array $data Must contain the Module's 'mode', 'name' and 'type.
	 * @return int|false Module ID if successfully saved. False otherwise.
	 */
	public function create_new( $data ) {

		// Verify it's a valid module type.
		if ( ! in_array( $data['module_type'], array( self::POPUP_MODULE, self::SLIDEIN_MODULE, self::EMBEDDED_MODULE ), true ) ) {
			return false;
		}

		// Abort if the mode isn't set.
		if ( ! in_array( $data['module_mode'], array( 'optin', 'informational' ), true ) ) {
			return false;
		}

		// Save to modules table.
		$this->module_name = sanitize_text_field( $data['module_name'] );
		$this->module_type = $data['module_type'];
		$this->active      = 0;
		$this->module_mode = $data['module_mode'];
		$this->save();

		// Save the new module's meta.
		$this->store_new_module_meta( $data );

		// Activate providers.
		$this->activate_providers( $data );

		return $this->id;
	}

	/**
	 * Store the defaults meta when creating a new module.
	 *
	 * @since 4.0.0
	 *
	 * @param array $data Data to store.
	 */
	private function store_new_module_meta( $data ) {
		$def_content  = apply_filters( 'hustle_module_get_' . self::KEY_CONTENT . '_defaults', $this->get_content()->to_array(), $this, $data );
		$content_data = empty( $data['content'] ) ? $def_content : array_merge( $def_content, $data['content'] );

		$def_emails  = apply_filters( 'hustle_module_get_' . self::KEY_EMAILS . '_defaults', $this->get_emails()->to_array(), $this, $data );
		$emails_data = empty( $data['emails'] ) ? $def_emails : array_merge( $def_emails, $data['emails'] );

		$def_design  = apply_filters( 'hustle_module_get_' . self::KEY_DESIGN . '_defaults', $this->get_design()->to_array(), $this, $data );
		$design_data = empty( $data['design'] ) ? $def_design : array_merge( $def_design, $data['design'] );

		$def_integrations_settings  = apply_filters( 'hustle_module_get_' . self::KEY_INTEGRATIONS_SETTINGS . '_defaults', $this->get_integrations_settings()->to_array(), $this, $data );
		$integrations_settings_data = empty( $data['integrations_settings'] ) ? $def_integrations_settings : array_merge( $def_integrations_settings, $data['integrations_settings'] );

		$def_settings  = apply_filters( 'hustle_module_get_' . self::KEY_SETTINGS . '_defaults', $this->get_settings()->to_array(), $this, $data );
		$settings_data = empty( $data['settings'] ) ? $def_settings : array_merge( $def_settings, $data['settings'] );

		// Visibility settings.
		$def_visibility  = apply_filters( 'hustle_module_get_' . self::KEY_VISIBILITY . '_defaults', $this->get_visibility()->to_array(), $this, $data );
		$visibility_data = empty( $data['visibility'] ) ? $def_visibility : array_merge( $def_visibility, $data['visibility'] );

		// Save to meta table.
		$this->update_meta( self::KEY_CONTENT, $content_data );
		$this->update_meta( self::KEY_EMAILS, $emails_data );
		$this->update_meta( self::KEY_INTEGRATIONS_SETTINGS, $integrations_settings_data );
		$this->update_meta( self::KEY_DESIGN, $design_data );
		$this->update_meta( self::KEY_SETTINGS, $settings_data );
		$this->update_meta( self::KEY_VISIBILITY, $visibility_data );

		// Embedded only. Display options.
		if ( self::EMBEDDED_MODULE === $this->module_type ) {
			$def_display  = apply_filters( 'hustle_module_get_' . self::KEY_DISPLAY_OPTIONS . '_defaults', $this->get_display()->to_array(), $this, $data );
			$display_data = empty( $data['display'] ) ? $def_display : array_merge( $def_display, $data['display'] );

			$this->update_meta( self::KEY_DISPLAY_OPTIONS, $display_data );
		}
	}

	/**
	 * Creates and store the nonce used to validate email unsubscriptions.
	 *
	 * @since 3.0.5
	 * @param string $email Email to be unsubscribed.
	 * @param array  $lists_id IDs of the modules to which it will be unsubscribed.
	 * @return boolean
	 */
	public function create_unsubscribe_nonce( $email, array $lists_id ) {
		// Since we're supporting php 5.2, random_bytes or other strong rng are not available. So using this instead.
		$nonce = hash_hmac( 'md5', $email, wp_rand() . time() );

		$data = get_option( self::KEY_UNSUBSCRIBE_NONCES, array() );

		// If the email already created a nonce and didn't use it, replace its data.
		$data[ $email ] = array(
			'nonce'        => $nonce,
			'lists_id'     => $lists_id,
			'date_created' => time(),
		);

		$updated = update_option( self::KEY_UNSUBSCRIBE_NONCES, $data );
		if ( $updated ) {
			return $nonce;
		} else {
			return false;
		}
	}

	/**
	 * Does the actual email unsubscription.
	 *
	 * @since 3.0.5
	 * @param string $email Email to be unsubscribed.
	 * @param string $nonce Nonce associated with the email for the unsubscription.
	 * @return boolean
	 */
	public function unsubscribe_email( $email, $nonce ) {
		$data = get_option( self::KEY_UNSUBSCRIBE_NONCES, false );
		if ( ! $data ) {
			return false;
		}
		if ( ! isset( $data[ $email ] ) || ! isset( $data[ $email ]['nonce'] ) || ! isset( $data[ $email ]['lists_id'] ) ) {
			return false;
		}
		$email_data = $data[ $email ];
		if ( ! hash_equals( (string) $email_data['nonce'], $nonce ) ) {
			return false;
		}
		// Nonce expired. Remove it. Currently giving 1 day of life span.
		if ( ( time() - (int) $email_data['date_created'] ) > DAY_IN_SECONDS ) {
			unset( $data[ $email ] );
			update_option( self::KEY_UNSUBSCRIBE_NONCES, $data );
			return false;
		}

		// Proceed to unsubscribe
		foreach ( $email_data['lists_id'] as $id ) {
			$unsubscribed = $this->remove_local_subscription_by_email_and_module_id( $email, $id );
		}

		// The email was unsubscribed and the nonce was used. Remove it from the saved list.
		unset( $data[ $email ] );
		update_option( self::KEY_UNSUBSCRIBE_NONCES, $data );

		return true;

	}

	/**
	 * Duplicate a module.
	 *
	 * @since 3.0.5
	 * @since 4.0 moved from Hustle_Popup_Admin_Ajax to here. New settings added.
	 *
	 * @return bool
	 */
	public function duplicate_module() {

		if ( ! $this->id ) {
			return false;
		}

		// TODO: make use of the sshare model to extend this instead.
		if ( self::SOCIAL_SHARING_MODULE !== $this->module_type ) {

			$data = array(
				'content'                       => $this->get_content()->to_array(),
				'emails'                        => $this->get_emails()->to_array(),
				'design'                        => $this->get_design()->to_array(),
				'settings'                      => $this->get_settings()->to_array(),
				'visibility'                    => $this->get_visibility()->to_array(),
				self::KEY_INTEGRATIONS_SETTINGS => $this->get_integrations_settings()->to_array(),
			);

			if ( self::EMBEDDED_MODULE === $this->module_type ) {
				$data['display'] = $this->get_display()->to_array();
			}

			// Pass integrations.
			if ( 'optin' === $this->module_mode ) {
				$integrations = array();
				$providers    = Hustle_Providers::get_instance()->get_providers();
				foreach ( $providers as $slug => $provider ) {
					$provider_data = $this->get_provider_settings( $slug, false );
					// if ( 'local_list' !== $slug && $provider_data && $provider->is_connected()
					if ( $provider_data && $provider->is_connected()
							&& $provider->is_form_connected( $this->module_id ) ) {
						$integrations[ $slug ] = $provider_data;
					}
				}

				$data['integrations'] = $integrations;
			}
		} else {
			$data = array(
				'content'    => $this->get_content()->to_array(),
				'display'    => $this->get_display()->to_array(),
				'design'     => $this->get_design()->to_array(),
				'visibility' => $this->get_visibility()->to_array(),
			);
		}

		unset( $this->id );

		// rename
		$this->module_name .= __( ' (copy)', 'hustle' );

		// Turn status off.
		$this->active = 0;

		// Save.
		$result = $this->save();

		if ( $result && ! is_wp_error( $result ) ) {

			$this->update_module( $data );

			return true;
		}

		return false;
	}

	/**
	 * Updates the metas specific for Non Social Sharing modules.
	 *
	 * @since 4.3.0
	 * @param array $data Data to save.
	 * @return void
	 */
	protected function update_module_metas( $data ) {
		// Meta used in all module types.
		if ( isset( $data['content'] ) ) {
			$this->update_meta( self::KEY_CONTENT, $data['content'] );
		}
		// Meta used in all module types.
		if ( isset( $data['visibility'] ) ) {
			$this->update_meta( self::KEY_VISIBILITY, $data['visibility'] );
		}

		// Design tab.
		if ( isset( $data['design'] ) ) {
			$saved_design = $this->get_design()->to_array();
			$new_design   = array_merge( $saved_design, $data['design'] );

			$this->update_meta( self::KEY_DESIGN, $new_design );
		}

		// Emails tab.
		if ( isset( $data['emails'] ) ) {
			$emails = $data['emails'];
			if ( isset( $emails['form_elements'] ) ) {
				$emails['form_elements'] = $this->sanitize_form_elements( $emails['form_elements'] );
			}
			$this->update_meta( self::KEY_EMAILS, $emails );
		}

		// Settings tab.
		if ( isset( $data['settings'] ) ) {
			// Clear flags to skip cached schedule values.
			$this->set_schedule_flags( array() );
			$this->update_meta( self::KEY_SETTINGS, $data['settings'] );
		}

		// Integrations tab.
		if ( isset( $data['integrations_settings'] ) ) {
			$this->update_meta( self::KEY_INTEGRATIONS_SETTINGS, $data['integrations_settings'] );
		}

		// Embedded only meta.
		if ( self::EMBEDDED_MODULE === $this->module_type && isset( $data['display'] ) ) {
			$this->update_meta( self::KEY_DISPLAY_OPTIONS, $data['display'] );
		}

		// Activate integrations if provided.
		if ( isset( $data['integrations'] ) ) {
			$this->activate_providers( $data );
		}
	}

	/**
	 * Sanitize/Replace the module's data.
	 *
	 * @param array $data Data to sanitize.
	 * @return array Sanitized data.
	 */
	public function sanitize_module( $data ) {
		$design_obj         = $this->get_design();
		$default_options    = $design_obj->get_defaults();
		$saved_options      = $design_obj->to_array();
		$new_options        = ! empty( $data['design'] ) ? $data['design'] : array();
		$typography_options = $design_obj->get_typography_defaults( 'desktop' );

		// Check is `Border, Spacing and Shadow` enabled for desktop.
		$spacing_on = $this->get_newest_value( 'customize_border_shadow_spacing', $new_options, $saved_options );
		// Check is `Typography` enabled for desktop.
		$typography_on = $this->get_newest_value( 'customize_typography', $new_options, $saved_options );

		foreach ( $new_options as $option_name => $value ) {
			if ( $spacing_on ) {
				$data = $this->replace_empty_spacing_numbers( $data, $option_name, $value, $default_options );
			}
			if ( $typography_on ) {
				$data = $this->replace_empty_typography_numbers( $data, $option_name, $value, $default_options, $typography_options );
			}
		}

		return $data;
	}

	/**
	 * Validates the module's data.
	 *
	 * @since 4.0.3
	 *
	 * @param array $data Data to validate.
	 * @return array
	 */
	public function validate_module( $data ) {
		$errors = array();

		// Name validation.
		if ( empty( sanitize_text_field( $data['module']['module_name'] ) ) ) {
			$errors['error']['name_error'] = __( 'This field is required', 'hustle' );

			return $errors;
		}

		return true;
	}

	/**
	 * Get newest value.
	 *
	 * @param string $option_name Option name.
	 * @param array  $new_options New options.
	 * @param array  $saved_options Old options.
	 * @return bool
	 */
	private function get_newest_value( $option_name, $new_options, $saved_options ) {
		if ( isset( $new_options[ $option_name ] ) ) {
			$value = $new_options[ $option_name ];
		} elseif ( isset( $saved_options[ $option_name ] ) ) {
			$value = $saved_options[ $option_name ];
		} else {
			$value = '';
		}

		return $value;
	}

	/**
	 * Check if it's spacing option and value isn't set
	 *
	 * @param string $key Option name.
	 * @param string $value Option value.
	 * @return bool
	 */
	private function is_empty_spacing_number( $key, $value ) {
		$needles = array( '_margin_', '_padding_', '_shadow_', '_radius_', '_border_' );
		return $this->similar_in_array( $key, $needles ) && '' === $value;
	}

	/**
	 * Check if it's typography option and value isn't set
	 *
	 * @param string $key Option name.
	 * @param string $value Option value.
	 * @param array  $typography_options Typography options.
	 * @return bool
	 */
	private function is_empty_typography_number( $key, $value, $typography_options ) {
		return '' === $value && isset( $typography_options[ $key ] )
				&& ( is_float( $typography_options[ $key ] ) || is_int( $typography_options[ $key ] ) );
	}

	/**
	 * If it's an empty number option from Destop section - replace it to relevant default value.
	 *
	 * @param string $data Data for sanitize.
	 * @param string $option_name Option name.
	 * @param string $option_value Option value.
	 * @param array  $default_options Default options.
	 * @return string
	 */
	private function replace_empty_spacing_numbers( $data, $option_name, $option_value, $default_options ) {
		if ( $this->is_empty_spacing_number( $option_name, $option_value ) && '_mobile' !== substr( $option_name, -7 ) ) {
			$data['design'][ $option_name ] = isset( $default_options[ $option_name ] ) ? $default_options[ $option_name ] : 0;
		}

		return $data;
	}

	/**
	 * If it's an empty number option from Typography section - replace it to relevant default value.
	 *
	 * @param string $data Data for sanitize.
	 * @param string $option_name Option name.
	 * @param string $option_value Option value.
	 * @param array  $default_options Default options.
	 * @param array  $typography_options Typography options.
	 * @return string
	 */
	private function replace_empty_typography_numbers( $data, $option_name, $option_value, $default_options, $typography_options ) {
		if ( $this->is_empty_typography_number( $option_name, $option_value, $typography_options ) && '_mobile' !== substr( $option_name, -7 ) ) {
			$data['design'][ $option_name ] = isset( $default_options[ $option_name ] ) ? $default_options[ $option_name ] : 0;
		}

		return $data;
	}

	/**
	 * Checks if a value contains a part of any array item
	 *
	 * @param array  $haystack The value.
	 * @param string $needles The array of pices.
	 * @return boolean
	 */
	private function similar_in_array( $haystack, $needles ) {
		foreach ( $needles as $needle ) {
			if ( false !== strpos( $haystack, $needle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Render the module.
	 *
	 * @since 4.0
	 *
	 * @param string $sub_type
	 * @param string $custom_classes
	 * @param bool   $is_preview
	 * @return string
	 */
	public function display( $sub_type = null, $custom_classes = '', $is_preview = false ) {
		if ( ! $this->id ) {
			return;
		}
		$renderer = $this->get_renderer();
		return $renderer->display( $this, $sub_type, $custom_classes, $is_preview );
	}

	public function get_renderer() {
		return new Hustle_Module_Renderer();
	}

	/**
	 * Return whether the module's sub_type is active.
	 *
	 * @since the beginning of time
	 * @since 4.0 method name changed.
	 *
	 * @param string $type
	 * @return boolean
	 */
	public function is_display_type_active( $type ) {
		$settings = $this->get_display()->to_array();

		if ( isset( $settings[ $type . '_enabled' ] ) && in_array( $settings[ $type . '_enabled' ], array( '1', 1, 'true' ), true ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sanitize the form fields name replacing spaces by underscores.
	 * This way the data is handled properly along hustle.
	 *
	 * @since 4.0
	 * @param string $name
	 * @return string
	 */
	public static function sanitize_form_field_name( $name ) {
		$sanitized_name = apply_filters( 'hustle_sanitize_form_field_name', str_replace( ' ', '_', trim( $name ) ), $name );
		return $sanitized_name;
	}

	public static function sanitize_form_fields_names( $names_to_sanitize, $form_fields ) {

		// Replace the name without changing the array's order.
		$names_array = array_keys( $form_fields );
		foreach ( $names_to_sanitize as $name ) {
			$index                        = array_search( $name, $names_array, true );
			$sanitized_name               = self::sanitize_form_field_name( $name );
			$form_fields[ $name ]['name'] = $sanitized_name;

			$names_array[ $index ] = $sanitized_name;

		}
		$sanitized_fields = array_combine( $names_array, array_values( $form_fields ) );

		return $sanitized_fields;
	}

	public function sanitize_form_elements( $form_elements ) {
		// Sanitize GDPR message
		if ( isset( $form_elements['gdpr']['gdpr_message'] ) ) {
			$allowed_html                          = array(
				'a'      => array(
					'href'   => true,
					'title'  => true,
					'target' => true,
					'alt'    => true,
				),
				'b'      => array(),
				'strong' => array(),
				'i'      => array(),
				'em'     => array(),
				'del'    => array(),
			);
			$form_elements['gdpr']['gdpr_message'] = wp_kses( wp_unslash( $form_elements['gdpr']['gdpr_message'] ), $allowed_html );
		}

		$names_to_sanitize = array();
		foreach ( $form_elements as $name => $field_data ) {
			if ( false !== stripos( $name, ' ' ) ) {
				$names_to_sanitize[] = $name;
			}
		}

		// All good, return the data.
		if ( empty( $names_to_sanitize ) ) {
			return $form_elements;
		}

		$form_elements = self::sanitize_form_fields_names( $names_to_sanitize, $form_elements );

		return $form_elements;
	}

	/**
	 * Update Custom Fields for Sendgrid New Campaigns
	 */
	public function maybe_update_custom_fields() {
		$connected_addons = Hustle_Provider_Utils::get_addons_instance_connected_with_module( $this->module_id );

		foreach ( $connected_addons as $addon ) {

			// Change logic only for sendgrid for now.
			if ( 'sendgrid' !== $addon->get_slug() ) {
				continue;
			}
			$global_multi_id = $addon->selected_global_multi_id;
			$new_campaigns   = $addon->get_setting( 'new_campaigns', '', $global_multi_id );

			// only if it's the New Sendgrid Campaigns.
			if ( 'new_campaigns' !== $new_campaigns ) {
				continue;
			}
			$emails        = $this->get_emails()->to_array();
			$custom_fields = array();

			$api_key = $addon->get_setting( 'api_key', '', $global_multi_id );
			$api     = $addon::api( $api_key, $new_campaigns );

			foreach ( $emails['form_elements'] as $element ) {
				if ( empty( $element['type'] ) || in_array( $element['type'], array( 'submit', 'recaptcha' ), true ) ) {
					continue;
				}
				$custom_fields[] = array(
					'type' => 'text',
					'name' => $element['name'],
				);
			}

			if ( ! empty( $custom_fields ) ) {
				$api->add_custom_fields( $custom_fields );
			}
		}
	}

	/**
	 * Returns the link to the wizard page into the defined tab.
	 *
	 * @since unknown
	 * @since 4.3.0 Moved from Hustle_Module_Decorator to this class.
	 *
	 * @param string $section Slug of the section to go to.
	 * @return string
	 */
	public function get_edit_url( $section = '' ) {
		$url = 'admin.php?page=' . $this->get_wizard_page() . '&id=' . $this->module_id;

		if ( ! empty( $section ) ) {
			$url .= '&section=' . $section;
		}

		return admin_url( $url );
	}

	/**
	 * Gets the selected Google fonts for the active elements in the module.
	 * Used for non-ssharing modules only.
	 *
	 * @since 4.3.0
	 *
	 * @return array
	 */
	public function get_google_fonts() {
		$fonts      = array();
		$is_preview = ! empty( $this->design );

		$design = ! $is_preview ? $this->get_design()->to_array() : (array) $this->design;

		if ( '1' === $design['use_vanilla'] ) {
			return $fonts;
		}

		$content = ! $is_preview ? $this->get_content()->to_array() : (array) $this->content;

		$elements = array(
			'title'                      => '' !== $content['title'],
			'subtitle'                   => '' !== $content['sub_title'],
			'main_content_paragraph'     => '' !== $content['main_content'],
			'main_content_heading_one'   => '' !== $content['main_content'],
			'main_content_heading_two'   => '' !== $content['main_content'],
			'main_content_heading_three' => '' !== $content['main_content'],
			'main_content_heading_four'  => '' !== $content['main_content'],
			'main_content_heading_five'  => '' !== $content['main_content'],
			'main_content_heading_six'   => '' !== $content['main_content'],
			'cta'                        => '0' !== $content['show_cta'],
			'never_see_link'             => '0' !== $content['show_never_see_link'],
		);

		// Only list the font of the elements that are shown, and aren't using a 'custom' font.
		foreach ( $elements as $element_name => $is_shown ) {
			if ( ! $is_shown ) {
				continue;
			}

			$font = $design[ $element_name . '_font_family' ];
			if ( 'custom' !== $font ) {
				$font_weight = $design[ $element_name . '_font_weight' ];
				if ( ! isset( $fonts[ $font ] ) ) {
					$fonts[ $font ] = array();
				}
				if ( ! in_array( $font_weight, $fonts[ $font ], true ) ) {
					$fonts[ $font ][] = $font_weight;
				}
			}
		}

		// We're done here for informational modules.
		if ( self::OPTIN_MODE !== $this->module_mode ) {
			return $fonts;
		}

		$has_mailchimp = ! empty( $this->get_provider_settings( 'mailchimp' ) );

		$emails              = ! $is_preview ? $this->get_emails()->to_array() : (array) $this->emails;
		$form_fields         = $this->get_form_fields();
		$has_success_message = 'show_success' === $emails['after_successful_submission'];

		$elements_optin = array(
			'form_extras'                   => $has_mailchimp,
			'input'                         => true,
			'select'                        => $has_mailchimp,
			'checkbox'                      => $has_mailchimp,
			'dropdown'                      => $has_mailchimp,
			'gdpr'                          => ! empty( $form_fields['gdpr'] ),
			'recaptcha'                     => ! empty( $form_fields['recaptcha'] ),
			'submit_button'                 => true,
			'success_message_paragraph'     => $has_success_message,
			'success_message_heading_one'   => $has_success_message,
			'success_message_heading_two'   => $has_success_message,
			'success_message_heading_three' => $has_success_message,
			'success_message_heading_four'  => $has_success_message,
			'success_message_heading_five'  => $has_success_message,
			'success_message_heading_six'   => $has_success_message,
			'error_message'                 => true,
		);

		foreach ( $elements_optin as $element_name => $is_shown ) {
			if ( ! $is_shown ) {
				continue;
			}

			$font = $design[ $element_name . '_font_family' ];
			if ( 'custom' !== $font ) {
				$font_weight = $design[ $element_name . '_font_weight' ];
				if ( ! isset( $fonts[ $font ] ) ) {
					$fonts[ $font ] = array();
				}
				if ( ! in_array( $font_weight, $fonts[ $font ], true ) ) {
					$fonts[ $font ][] = $font_weight;
				}
			}
		}
		return $fonts;
	}
}
