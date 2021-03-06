<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://amintaibouta.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/includes
 * @author     Amin T. <amin@amintaibouta.com>
 */
class Paypal_Ipn_To_Mailchimp_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'pitm_logs';

		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}
}
