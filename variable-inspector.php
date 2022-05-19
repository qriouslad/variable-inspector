<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bowo.io
 * @since             1.0.0
 * @package           Variable_Inspector
 *
 * @wordpress-plugin
 * Plugin Name:       Variable Inspector
 * Plugin URI:        https://wordpress.org/plugins/variable-inspector/
 * Description:       Easily dump and centrally inspect your PHP variables for convenient debugging.
 * Version:           1.3.1
 * Author:            Bowo
 * Author URI:        https://bowo.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       variable-inspector
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VARIABLE_INSPECTOR_VERSION', '1.3.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-variable-inspector-activator.php
 */
function activate_variable_inspector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-variable-inspector-activator.php';
	Variable_Inspector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-variable-inspector-deactivator.php
 */
function deactivate_variable_inspector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-variable-inspector-deactivator.php';
	Variable_Inspector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_variable_inspector' );
register_deactivation_hook( __FILE__, 'deactivate_variable_inspector' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-variable-inspector.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_variable_inspector() {

	$plugin = new Variable_Inspector();
	$plugin->run();

}
run_variable_inspector();
