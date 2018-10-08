<?php

namespace TSC\ManagedMissions\Admin;

class Options {

	const OPT_GROUP = 'tsc_managed_missions';

	const OPT_NAME = 'tscmm_options';

	public $fields = array(
		'api_call_type',
		'api_key',
		'api_query_params',
	);

	protected $_options_page_hook;

	/**
	 * The Options Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'addOptionsPage' ) );
		add_action( 'admin_init',  array( $this, 'registerOptions' ) );

		$this->options = wp_parse_args( get_option( self::OPT_NAME ), array(
			'api_call_type'    => $this->getDefaultOptions( 'api_call_type' ),
			'api_key'          => $this->getDefaultOptions( 'api_key' ),
			'api_query_params' => $this->getDefaultOptions( 'api_query_params' ),
		) );
	}

	/**
	 * Method that adds a options page.
	 */
	public function addOptionsPage() {

		$this->_options_page_hook = add_options_page(
			'Managed Missions Options',
			'Managed Missions',
			'manage_options',
			self::OPT_GROUP,
			array( $this, 'renderOptionsPage' )
		);
	}

	/**
	 * Method that renders a options page.
	 */
	public function renderOptionsPage() {
		tscmm_get_template( 'Admin/Options/options-page', array(
			'fields'  => self::OPT_GROUP,
			'options' => $this->_options_page_hook,
		) );
	}

	/**
	 * Method that registers options.
	 */
	public function registerOptions() {
		add_settings_section(
			self::OPT_GROUP,
			'Managed Missions Options',
			array( $this, 'renderOptionsSection' ),
			$this->_options_page_hook
		);

		register_setting(
			self::OPT_GROUP,
			self::OPT_NAME,
			array( $this, 'saveOptions' )
		);

		add_settings_field(
			'tscmm_api_call_type',
			__( 'API Call Type', 'managed-missions' ),
			array( $this, 'apiCallTypeField' ),
			$this->_options_page_hook,
			self::OPT_GROUP
		);

		add_settings_field(
			'tscmm_api_key',
			__( 'API Key', 'managed-missions' ),
			array( $this, 'apiKeyField' ),
			$this->_options_page_hook,
			self::OPT_GROUP
		);

		add_settings_field(
			'tscmm_api_query_params',
			__( 'API Query Params', 'managed-missions' ),
			array( $this, 'apiQueryParamsField' ),
			$this->_options_page_hook,
			self::OPT_GROUP
		);
	}

	/**
	 * Method that renders the API Call Type field.
	 */
	public function apiCallTypeField() {
		tscmm_get_template( 'Admin/Options/input-field', array(
			'field'   => self::OPT_NAME . '[api_call_type]',
			'type'    => 'text',
			'value'   => $this->options['api_call_type'],
			'desc'    => 'Select the type of call you would like to make.',
			'example' => '',
		) );
	}

	/**
	 * Method that renders the API Key field.
	 */
	public function apiKeyField() {
		tscmm_get_template( 'Admin/Options/input-field', array(
			'field'   => self::OPT_NAME . '[api_key]',
			'type'    => 'text',
			'value'   => $this->options['api_key'],
			'desc'    => 'Enter the API Key provided by Managed Missions.',
			'example' => '#########-####-####-####-############',
		) );
	}

	/**
	 * Method that renders the API Query Params field.
	 */
public function apiQueryParamsField() {
		tscmm_get_template( 'Admin/Options/input-field', array(
			'field'   => self::OPT_NAME . '[api_query_params]',
			'type'    => 'text',
			'value'   => $this->options['api_query_params'],
			'desc'    => 'Enter the query params.',
			'example' => '',
		) );
	}

	/**
	 * Method that renders the options section.
	 */
	public function renderOptionsSection() {
		?>
		<p><?php esc_html_e( 'Enter the associated options into each of the fields below.', 'managed-missions' ) ?></p>
		<?php
	}

	/**
	 * Method that returns the defaults for the options.
	 *
	 * @param string $key the option to return a default for.
	 * @return string the default of the option.
	 */
	public function getDefaultOptions( $key ) {

		if ( empty( $key ) ) {
			return null;
		}

		switch ( $key ) {
			case 'api_call_type':
				return '';
				break;
			case 'api_key':
				return '';
				break;
			case 'api_query_params':
				return '';
				break;
			default:
				return null;
				break;
		}
	}

	/**
	 * Method that save the options.
	 *
	 * @param array $options the options to save.
	 * @return array the saved options.
	 */
	public function saveOptions( $options ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$saved = [];

		foreach ( $options as $name => $option ) {
			if ( in_array( $name, $this->fields ) ) {
				switch ( $name ) {
					case 'api_call_type':
						if ( empty( $option ) ) {
							$option = $this->getDefaultOptions( 'api_call_type' );
						}
						break;
					case 'api_key':
						if ( empty( $option ) ) {
							$option = $this->getDefaultOptions( 'api_key' );
						}
						break;
					case 'api_query_params':
						if ( empty( $option ) ) {
							$option = $this->getDefaultOptions( 'api_query_params' );
						}
						break;
					default:
						break;
				}
				$saved[ $name ] = trim( $option );
			}
		}

		return $saved;
	}
}
