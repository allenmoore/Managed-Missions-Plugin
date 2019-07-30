<?php
/**
 * Plugin Name: Managed Missions
 * Plugin URI:  https://allenmoore.co
 * Description: A plugin integrating the Managed Missions API into WordPress.
 * Version:     1.0.0
 * Author:      Allen Moore
 * Author URI:  https://allenmoore.co
 * Text Domain: am-managed-missions
 * Domain Path: /languages
 * License:     MIT
 */

namespace AM\ManagedMissions;

use AM\ManagedMissions\Plugin;

// Useful global constants
define( 'AMMM_VERSION', '1.0.0' );
define( 'AMMM_PLUGIN'    , __DIR__ . '/am-managed-missions.php' );
define( 'AMMM_URL', plugin_dir_url( __FILE__ ) );
define( 'AMMM_PATH', dirname( __FILE__ ) . '/' );
define( 'AMMM_INC', AMMM_PATH . 'includes/' );

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
	do_action( 'ammm_loaded', $plugin );
}
add_action( 'after_setup_theme', 'AM\ManagedMissions\initialize', 20 );

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
register_activation_hook( __FILE__, 'AM\ManagedMissions\activate' );
