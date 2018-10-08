<?php

namespace TSC\ManagedMissions;

use TSC\ManagedMissions\Admin\Options as AdminOptions;
use TSC\ManagedMissions\Modules\APIs\ManagedMissions\MissionTripsList;

class Plugin {

	/**
	 * Property representing the Options class.
	 *
	 * @var \TSC\ManagedMissions\Admin\Options
	 */
	public $options;

	/**
	 * Property representing the MissionTripsList class.
	 *
	 * @var \TSC\ManagedMissions\Modules\APIs\ManagedMissions\MissionTripsList
	 */
	public $mtList;

	/**
	 * The Plugin Constructor
	 */
	public function __construct() {

		$this->options = new AdminOptions();
		$this->mtList = new MissionTripsList();

		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Method to enqueue admin CSS styles.
	 */
	public function enqueueAdminStyles() {
		$min = defined( 'SCRIPT_DEBUG' ) && filter_var( SCRIPT_DEBUG, FILTER_VALIDATE_BOOLEAN ) ? '' : '.min';

		wp_enqueue_style(
			'tscmm-admin-css',
			plugins_url( "dist/css/style{$min}.css", TSCMM_PLUGIN ),
			null,
			TSCMM_VERSION
		);
	}

	/**
	 * Method that initializes the plugin and fires an action other plugins can hook into.
	 */
	public function init() {
		do_action( 'tsc_managed_missions' );
	}

	/**
	 * Method that sets up the text domain.
	 */
	public function i18n() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'managed-missions' );
		load_textdomain( 'managed-missions', WP_LANG_DIR . '/managed-missions/managed-missions-' . $locale . '.mo' );
		load_plugin_textdomain( 'managed-missions', false, plugin_basename( TSCMM_PATH ) . '/languages/' );
	}
}
