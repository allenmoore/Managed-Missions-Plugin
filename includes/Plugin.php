<?php

namespace AM\ManagedMissions;

use AM\ManagedMissions\Admin\Options as AdminOptions;
use AM\ManagedMissions\Modules\APIs\ManagedMissions\MissionTripsList;

class Plugin {

	/**
	 * Property representing the Options class.
	 *
	 * @var \AM\ManagedMissions\Admin\Options
	 */
	public $options;

	/**
	 * Property representing the MissionTripsList class.
	 *
	 * @var \AM\ManagedMissions\Modules\APIs\ManagedMissions\MissionTripsList
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
			'ammm-admin-css',
			plugins_url( "dist/css/style{$min}.css", AMMM_PLUGIN ),
			null,
			AMMM_VERSION
		);
	}

	/**
	 * Method that initializes the plugin and fires an action other plugins can hook into.
	 */
	public function init() {
		do_action( 'am_managed_missions' );
	}

	/**
	 * Method that sets up the text domain.
	 */
	public function i18n() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'am-managed-missions' );
		load_textdomain( 'am-managed-missions', WP_LANG_DIR . '/am-managed-missions/am-managed-missions-' . $locale . '.mo' );
		load_plugin_textdomain( 'am-managed-missions', false, plugin_basename( AMMM_PATH ) . '/languages/' );
	}
}
