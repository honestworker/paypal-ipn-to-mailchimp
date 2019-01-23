<?php

/**
 * Fired during plugin activation
 *
 * @link       http://amintaibouta.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/includes
 * @author     Amin T. <amin@amintaibouta.com>
 */
class Paypal_Ipn_To_Mailchimp_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Create the custom datatable for this plugin
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'pitm_logs';

		$query = "CREATE TABLE $table_name (
			id mediumint(11) NOT NULL AUTO_INCREMENT,
			email varchar(255) NOT NULL,
			first_name varchar(255) NOT NULL,
			last_name varchar(255),
			street varchar(255),
			city varchar(255),
			state varchar(255),
			zip varchar(255),
			country varchar(255),
			buyer_id varchar(255),
			shipping decimal(10,2),
			shipping_discount decimal(10,2),
			shipping_method varchar(255),
			fee decimal(10,2),
			insurance decimal(10,2),
			payment_type varchar(255),
			payment_status varchar(255),
			mailchimp_id varchar(255),
			mailchimp_status varchar(255) NOT NULL,
			error_type varchar(255),
			error_title varchar(255),
			error_message varchar(1023),
			status varchar(255) NOT NULL,
			date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		$wpdb->query($query);
	}
}
