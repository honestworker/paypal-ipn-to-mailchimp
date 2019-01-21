<?php
use \DrewM\MailChimp\MailChimp;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://amintaibouta.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Paypal_Ipn_To_Mailchimp
 * @subpackage Paypal_Ipn_To_Mailchimp/public
 * @author     Amin T. <amin@amintaibouta.com>
 */
class Paypal_Ipn_To_Mailchimp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Paypal_Ipn_To_Mailchimp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paypal_Ipn_To_Mailchimp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/paypal-ipn-to-mailchimp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Paypal_Ipn_To_Mailchimp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paypal_Ipn_To_Mailchimp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/paypal-ipn-to-mailchimp-public.js', array( 'jquery' ), $this->version, false );

	}

	public function paypal_ipn_callback() {		
		if (isset($_REQUEST['paypal-ipn-callback'])) {
			$ipn = new PaypalIPN();
			//$verified = $ipn->verifyIPN();
			file_put_contents(plugin_dir_path(__FILE__)."/../paypal-ipn-transaction.log", date('Y-m-d H:i:s').":".serialize($_REQUEST));

		        /*
		         * Process IPN
		         * A list of variables is available here:
		         * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
		         */
		        $mailChimp = new MailChimp('3319d6f9b1c25fcae308c2390b641db8-us12');
		        
			$list_id = '82791d0058';

		       $result = $mailChimp->post("lists/$list_id/members", [
		            'email_address' => $_POST['payer_email'],
		            'merge_fields' => ['FNAME'=> $_POST['first_name'],
						'LNAME'=> $_POST['last_name'],
						'KSSTREET'=> $_POST['address_street'],
						'KSCITY'=> $_POST['address_city'],
						'KSPOSTCODE'=> $_POST['address_zip'],
						'KSCOUNTRY'=> $_POST['address_country'],
						'KSCOUNTY'=> $_POST['address_state']
					],
				    'interests' => ['834321a796' => true],
		            'status'        => 'subscribed',
		        ]);
				
				file_put_contents(plugin_dir_path(__FILE__)."/../paypal-ipn-mailchimp.log", date('Y-m-d H:i:s').":".serialize($result));
				
		    // Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
		    header("HTTP/1.1 200 OK");
			die;
		}
	}
}
