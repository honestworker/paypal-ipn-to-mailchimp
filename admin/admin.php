<?php

function wppitm_current_params($name) {
	if ( isset( $_REQUEST[$name] ) && -1 != $_REQUEST[$name] ) {
		return $_REQUEST[$name];
	}

	return false;
}

add_action('admin_menu', 'fgb_admin_menu');
function fgb_admin_menu() {
	global $_wp_last_object_menu;

	$_wp_last_object_menu++;
	
	$edit = add_menu_page( __( 'Paypal IPN to Mailchimp Logs', 'wppitm-log' ),  __( 'Paypal IPN to Mailchimp', 'wppitm-log' ), true, 'wppitm_logs', 'wppitm_admin_management_page', 'dashicons-megaphone', $_wp_last_object_menu);
	add_action( 'load-' . $edit, 'wppitm_load_logs_admin' );
}

function wppitm_load_logs_admin() {
	global $plugin_page;

	$action = wppitm_current_params('action');

	if ( $action == 'resend' ) {
		$ids = wppitm_current_params('ids');

		if ( ! class_exists( 'Paypal_Ipn_To_Mailchimp_Public' ) ) {
			require_once plugin_dir_path( __FILE__ ) . '../public/class-paypal-ipn-to-mailchimp-public.php';
		}

		if ($ids) {
			foreach ($ids as $id) {
				$data = WPPitm_Log::get_data( $id );
				Paypal_Ipn_To_Mailchimp_Public::resendMailchimp($data);
			}
		}
	} else if ( $action == "trash" ) {
		$ids = wppitm_current_params('ids');
		if ($ids) {
			foreach ($ids as $id) {
				WPPitm_Log::update_data( $id, 'status', 'TRASH' );
			}
		}
	} else if ( $action == "restore" ) {
		$ids = wppitm_current_params('ids');
		if ($ids) {
			foreach ($ids as $id) {
				WPPitm_Log::restore_data( $id );
			}
		}
		$redirect_to = "?page=wppitm_logs";
        wp_safe_redirect( $redirect_to );
		exit();
	} else if ( $action == "delete" ) {
		$ids = wppitm_current_params('ids');
		if ($ids) {
			foreach ($ids as $id) {
				WPPitm_Log::delete_data( $id );
			}
		}
		$redirect_to = "?page=wppitm_logs";
        wp_safe_redirect( $redirect_to );
		exit();
	}

	$_GET['id'] = isset( $_GET['id'] ) ? $_GET['id'] : '';

	$log = null;

	if ( ! empty( $_GET['id'] ) ) {
		$log = WPPitm_Log::get_instance( $_GET['id'] );
	}

	if ( ! class_exists( 'WPPitm_Logs_List_Table' ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/class-logs-list-table.php';
	}
	
	$current_screen = get_current_screen();
	add_filter( 'manage_' . $current_screen->id . '_columns', array( 'WPPitm_Logs_List_Table', 'define_columns' ) );
	
    add_filter( 'views_' . $current_screen->id . '_columns', array( 'WPPitm_Logs_List_Table', 'define_views' ) );

    add_screen_option( 'per_page', array(
        'default' => 10,
        'option' => 'wppitm_logs_per_page',
    ));
}

function wppitm_admin_management_page() {
	if ( $log = wppitm_get_current_log() ) {
		$log_id = $log->initial() ? -1 : $log->prop('id');
		require_once plugin_dir_path( __FILE__ ) . '/view-log.php';
		return;
	}

	$list_table = new WPPitm_Logs_List_Table();
	$list_table->prepare_items();
	?>
	<div class="wrap">
	
	<h1 class="wp-heading-inline"><?php
		echo esc_html( __( 'Paypal IPN To Mailchimp Logs', 'wppitm-log' ) );
	?></h1>
	
	<?php	
		if ( ! empty( $_REQUEST['s'] ) ) {
			echo sprintf( '<span class="subtitle">'
				/* translators: %s: search keywords */
				. __( 'Search results for &#8220;%s&#8221;', 'wppitm-log' ) . '</span>', esc_html( $_REQUEST['s'] ) );
		}
	?>
	
	<hr class="wp-header-end">
	
	<?php $list_table->views(); ?>
	
	<form method="get" action="">
		<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
		<?php $list_table->search_box( __( 'Search Logs', 'wppitm-log' ), 'wppitm-log' ); ?>
		<?php $list_table->display(); ?>
	</form>
	
	</div>
	<?php
}