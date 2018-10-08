<?php
/**
 * Plugin Name: Managed Missions
 * Plugin URI:  https://summitrdu.com
 * Description: A plugin integrating the Managed Missions API into WordPress.
 * Version:     1.0.0
 * Author:      Allen Moore
 * Author URI:  https://summitrdu.com
 * Text Domain: managed-missions
 * Domain Path: /languages
 * License:     MIT
 */

namespace TSC\ManagedMissions;

use TSC\ManagedMissions\Plugin;

// Useful global constants
define( 'TSCMM_VERSION', '1.0.0' );
define( 'TSCMM_PLUGIN'    , __DIR__ . '/managed-missions.php' );
define( 'TSCMM_URL', plugin_dir_url( __FILE__ ) );
define( 'TSCMM_PATH', dirname( __FILE__ ) . '/' );
define( 'TSCMM_INC', TSCMM_PATH . 'includes/' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Function to initialize the plugin.
 */
function initialize() {
	$plugin = new Plugin();

	/**
	 * Allow other plugins to hook in and extend the plugin class
	 *
	 * @param Plugin $plugin
	 */
	do_action( 'tscmm_loaded', $plugin );
}
add_action( 'after_setup_theme', 'TSC\ManagedMissions\initialize', 20 );

/**
 * Function to run at plugin activation.
 *
 * @author Allen Moore
 *
 * @return void
 */
function activate() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'TSC\ManagedMissions\activate' );
