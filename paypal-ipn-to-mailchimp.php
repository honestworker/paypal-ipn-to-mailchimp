<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://amintaibouta.com
 * @since             1.0.0
 * @package           Paypal_Ipn_To_Mailchimp
 *
 * @wordpress-plugin
 * Plugin Name:       Paypal IPN to mailchimp
 * Plugin URI:        http://amintaibouta.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Amin T
 * Author URI:        http://amintaibouta.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       paypal-ipn-to-mailchimp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paypal-ipn-to-mailchimp-activator.php
 */
function activate_paypal_ipn_to_mailchimp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-ipn-to-mailchimp-activator.php';
	Paypal_Ipn_To_Mailchimp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-paypal-ipn-to-mailchimp-deactivator.php
 */
function deactivate_paypal_ipn_to_mailchimp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-ipn-to-mailchimp-deactivator.php';
	Paypal_Ipn_To_Mailchimp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_paypal_ipn_to_mailchimp' );
register_deactivation_hook( __FILE__, 'deactivate_paypal_ipn_to_mailchimp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-paypal-ipn-to-mailchimp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_paypal_ipn_to_mailchimp() {
	$plugin = new Paypal_Ipn_To_Mailchimp();
	$plugin->run();
}

require_once plugin_dir_path( __FILE__ ) . 'includes/paypal-ipn.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mailchimp.php';
run_paypal_ipn_to_mailchimp();

?>
