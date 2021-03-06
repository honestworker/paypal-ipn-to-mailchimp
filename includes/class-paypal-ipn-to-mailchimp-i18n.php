<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://amintaibouta.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/includes
 * @author     Amin T. <amin@amintaibouta.com>
 */
class Paypal_Ipn_To_Mailchimp_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'paypal-ipn-to-mailchimp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
