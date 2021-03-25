<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * @wordpress-plugin
 * Plugin Name:       iof-utilities
 * Version:           1.0.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iof-utilities
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iof-utilities-activator.php
 */
function activate_iof_utilities() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iof-utilities-activator.php';
	Iof_Utilities_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iof-utilities-deactivator.php
 */
function deactivate_iof_utilities() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iof-utilities-deactivator.php';
	Iof_Utilities_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iof_utilities' );
register_deactivation_hook( __FILE__, 'deactivate_iof_utilities' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path( __FILE__ ) . 'includes/class-iof-utilities.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iof_utilities() {

	$plugin = new Iof_Utilities();
	$plugin->run();

}
run_iof_utilities();

/**
 * Useful for calling IoF class methods in other locations (ie: template files) when necessary.
 * To use, create a protected static variable in Iof_Utilities and assign a class instance (ie: sides, dates) to that variable.
 * Then you can do things like IOF()->dates->get_dates();
 *
 * @return Iof_Utilities
 */
function iof() {
	return Iof_Utilities::instance();
}

// Global for backwards compatibility.
$GLOBALS['iof'] = iof();
