<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://heatdigital.com/chatfuel
 * @since             1.0.0
 * @package           Chatfuel
 *
 * @wordpress-plugin
 * Plugin Name:       HEAT Chatfuel Integration
 * Plugin URI:        http://heatdigital.com/chatfuel
 * Description:       Connect your website with Chatfuel Chatbot in the blink of an eye with powerful JSON API data from posts or products.
 * Version:           1.0.0
 * Author:            TaiCV
 * Author URI:        taicv.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chatfuel
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
define( 'CHATFUEL_PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-chatfuel-activator.php
 */
function activate_chatfuel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chatfuel-activator.php';
	Chatfuel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-chatfuel-deactivator.php
 */
function deactivate_chatfuel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chatfuel-deactivator.php';
	Chatfuel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_chatfuel' );
register_deactivation_hook( __FILE__, 'deactivate_chatfuel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-chatfuel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_chatfuel() {

	$plugin = new Chatfuel();
	$plugin->run();

}
run_chatfuel();
