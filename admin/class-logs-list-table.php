<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WPPitm_Logs_List_Table extends WP_List_Table {

	public static function define_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'email' => __( 'Email', 'pitm-log' ),
			'error_title' => __( 'Error Title', 'pitm-log' ),
			'buyer_id' => __( 'Buyer ID', 'pitm-log' ),
			'first_name' => __( 'First Name', 'pitm-log' ),
			'last_name' => __( 'Last Name', 'pitm-log' ),
			'payment_status' => __( 'Payment Status', 'pitm-log' ),
			'mailchimp_status' => __( 'MailChimp Status', 'pitm-log' ),
			'date' => __( 'Date', 'pitm-log' ),
			'status' => __( 'Status', 'pitm-log' ),
		);
		
		return $columns;
	}

	function __construct() {
		parent::__construct( array(
			'singular' => 'id',
			'plural' => 'ids',
			'ajax' => false,
		) );
	}

	protected function get_views() {
		$all_count = WPPitm_Log::get_all_count();
		$success_count = WPPitm_Log::get_success_count();
		$fail_count = WPPitm_Log::get_fail_count();
		$trash_count = WPPitm_Log::get_trash_count();

		$view =  __("<a href='?page=wppitm_logs'>All(" . $all_count . ")</a>",'pitm-log');
		$views['all'] = $view;
		$view =  __("<a href='?page=wppitm_logs&mailchimp_status=SUCCESS'>Mailchimp Success(" . $success_count . ")</a>",'my-plugin-slug');
		$views['succsss'] = $view;
		$view =  __("<a href='?page=wppitm_logs&mailchimp_status=FAIL'>Mailchimp Fail(" . $fail_count . ")</a>",'my-plugin-slug');
		$views['fail'] = $view;
		$view =   __("<a href='?page=wppitm_logs&status=TRASH'>Trashed(" . $trash_count . ")</a>",'my-plugin-slug');
		$views['trashed'] = $view;
		return $views;
	}

	public function initial() {
		return empty( $this->id );
	}

	function get_bulk_actions() {
		$actions = array(
			'resend'    => 'Resend',
			'trash'     => 'Move to Trash'
		);
		if ( ! empty( $_REQUEST['status'] ) ) {
			if ( $_REQUEST['status'] = "TRASH" ) {
				$actions = array(
					'restore'     => 'Restore',
					'delete'    => 'Delete Permanently',
				);
			}
		}
		return $actions;
	}

	function prepare_items() {
		$current_screen = get_current_screen();
		$per_page = $this->get_items_per_page( 'wppitm_logs_per_page' );
		
		$this->_column_headers = $this->get_column_info();
		
		$args = array(
			'logs_per_page' => $per_page,
			'orderby' => 'date',
			'order' => 'DESC',
			'offset' => ( $this->get_pagenum() - 1 ) * $per_page,
		);
		
		if ( ! empty( $_REQUEST['s'] ) ) {
			$args['s'] = $_REQUEST['s'];
		}
		
		if ( ! empty( $_REQUEST['orderby'] ) ) {
			if ( 'email' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'email';
			} elseif ( 'buyer_id' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'buyer_id';
			} elseif ( 'error_title' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'error_title';
			} elseif ( 'first_name' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'first_name';
			} elseif ( 'last_name' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'last_name';
			} elseif ( 'payment_status' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'payment_status';
			} elseif ( 'mailchimp_status' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'mailchimp_status';
			} elseif ( 'date' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'date';
			} elseif ( 'status' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'status';
			}
		}

		if ( ! empty( $_REQUEST['mailchimp_status'] ) ) {
			$args['mailchimp_status'] = $_REQUEST['mailchimp_status'];
		}

		if ( ! empty( $_REQUEST['status'] ) ) {
			$args['status'] = $_REQUEST['status'];
		}
		
		if ( ! empty( $_REQUEST['order'] ) ) {
			if ( 'asc' == strtolower( $_REQUEST['order'] ) ) {
				$args['order'] = 'ASC';
			} elseif ( 'desc' == strtolower( $_REQUEST['order'] ) ) {
				$args['order'] = 'DESC';
			}
		}
		
		$this->items = WPPitm_Log::find( $args );
		
		$total_items = WPPitm_Log::count();
		$total_pages = ceil( $total_items / $per_page );
		
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => $total_pages,
			'per_page' => $per_page,
		));
	}

	function get_columns() {
		return get_column_headers( get_current_screen() );
	}

	function get_sortable_columns() {
		$columns = array(
			'email' => array( 'email', true ),
			'error_title' => array( 'error_title', true ),
			'buyer_id' => array( 'buyer_id', true ),
			'first_name' => array( 'first_name', true ),
			'last_name' => array( 'last_name', true ),
			'payment_status' => array( 'payment_status', true ),
			'mailchimp_status' => array( 'mailchimp_status', true ),
			'date' => array( 'date', true ),
			'status' => array( 'status', true ),
		);
		
		return $columns;
	}

	function column_default( $item, $column_name ) {
		$output = $item->prop($column_name);
		return $output;
	}

	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['plural'],
			$item->prop('id') );
	}

	function column_email( $item ) {
		$url = admin_url( 'admin.php?page=wppitm_logs&id=' . absint( $item->prop('id') ) );
		$view_link = add_query_arg( array( 'action' => 'view' ), $url );

		$output = sprintf(
			'<a class="row-title" href="%1$s" title="%2$s">%3$s</a>',
			esc_url( $view_link ),
			/* translators: %s: title of form */
			esc_attr( sprintf( __( 'View &#8220;%s&#8221;', 'wppitm-log' ),
				$item->prop('email') ) ),
			esc_html( $item->prop('email') )
		);

		$output = sprintf( '<strong>%s</strong>', $output );

		//$delete_link = wp_nonce_url( add_query_arg( array( 'action' => 'delete' ), $url ), 'wppitm-delete-log_' . absint( $item->prop('id') ) );
		//$actions = array( 'delete' => sprintf( '<a href="%1$s">%2$s</a>', esc_url( $delete_link ), esc_html( __( 'Delete', 'wppitm-log' ) ) ) );
		
		//$output .= $this->row_actions( $actions );

		return $output;
	}
}