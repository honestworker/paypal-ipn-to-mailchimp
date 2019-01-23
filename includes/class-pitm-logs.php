<?php

class WPPitm_Log {
    const table_name = 'pitm_logs';
    
	private static $found_items = 0;
    private static $current = null;
    
	private $id;
	private $email;
	private $first_name;
    private $last_name;
    private $street;
    private $city;
    private $state;
    private $zip;
    private $country;
    private $buyer_id;
    private $shipping;
    private $shipping_discount;
    private $shipping_method;
    private $fee;
    private $insurance;
    private $payment_type;
    private $payment_status;

    private $mailchimp_status;

    private $mailchimp_id;

    private $error_type;
    private $error_title;
    private $error_message;

    private $status;
    private $date;

	public static function count() {
		return self::$found_items;
    }

	public static function get_current() {
		return self::$current;
    }
        
	private function __construct( $log = null ) {
		if ($log) {    
            $this->id = $log->id;
            $this->email = $log->email;
            $this->first_name = $log->first_name;
            $this->last_name = $log->last_name;
            $this->street = $log->street;
            $this->city = $log->city;
            $this->state = $log->state;
            $this->zip = $log->zip;
            $this->country = $log->country;
            $this->buyer_id = $log->buyer_id;
            $this->shipping = $log->shipping;
            $this->shipping_discount = $log->shipping_discount;
            $this->shipping_method = $log->shipping_method;
            $this->fee = $log->fee;
            $this->insurance = $log->insurance;
            $this->payment_type = $log->payment_type;
            $this->payment_status = $log->payment_status;
            
            $this->mailchimp_status = $log->mailchimp_status;

            $this->mailchimp_id = $log->mailchimp_id;

            $this->error_type = $log->error_type;
            $this->error_title = $log->error_title;
            $this->error_message = $log->error_message;

            $this->status = $log->status;
            $this->date = $log->date;
        }
    }
    
	public function initial() {
		return empty( $this->id );
    }
    
    public function prop( $name ) {
        if (isset($this->$name) ) {
            return $this->$name;
        }
        return NULL;
    }
    
	public static function find( $args = '' ) {
        global $wpdb;

        $table_name = $wpdb->prefix . self::table_name;
        $query = "SELECT * FROM $table_name";
        $where_query = "";
        if (isset($args['s'])) {
            $where_query = " WHERE (";
            $where_query .= " email LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR first_name LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR last_name LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR street LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR city LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR state LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR zip LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR country LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR buyer_id LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR shipping LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR shipping_discount LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR shipping_method LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR fee LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR insurance LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR payment_type LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR payment_status LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR mailchimp_id LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR mailchimp_status LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR error_type LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR error_title LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR error_message LIKE '%" . $args['s'] . "%'";
            $where_query .= " OR date LIKE '%" . $args['s'] . "%')";
        }

        if (isset($args['mailchimp_status'])) {
            if (!$where_query) {
                $where_query .= " WHERE ";
            } else {
                $where_query .= " AND ";
            }
            
            $where_query .= " mailchimp_status = '" . $args['mailchimp_status']  . "'";
        }

        if (isset($args['status'])) {
            if (!$where_query) {
                $where_query .= " WHERE ";
            } else {
                $where_query .= " AND ";
            }
            $where_query .= " status = '" . $args['status']  . "'";
        }

        $query .= $where_query;

        if (isset($args['orderby']) && $args['order']) {
            $query .= " ORDER BY " . $args['orderby'] . " " . $args['order'];
        }

        $logs = $wpdb->get_results( $query );
        self::$found_items = $wpdb->num_rows;
        
        if (isset($args['logs_per_page'])) {
            $query .= " LIMIT " . $args['logs_per_page'];
        }

        if (isset($args['offset'])) {
            $query .= " OFFSET " . $args['offset'];
        }        

        $logs = $wpdb->get_results( $query );
        
		$objs = array();
		foreach ( (array) $logs as $log ) {
			$objs[] = new self( $log );
		}
		
		return $objs;
    }
    
	public static function get_instance( $id ) {
        global $wpdb;

        $table_name = $wpdb->prefix . self::table_name;
        $query = "SELECT * FROM $table_name WHERE id=" . $id;
        $logs = (array)$wpdb->get_results( $query );

		foreach ( (array) $logs as $log ) {
            return self::$current = new self( $log );
		}
    }

	public static function update_data( $id, $field, $value ) {
        global $wpdb;
        
        $wpdb->update( $wpdb->prefix . self::table_name, array( $field => $value ), array( 'id' => $id ) );
    }

	public static function restore_data( $id ) {
        global $wpdb;
        
        $wpdb->update( $wpdb->prefix . self::table_name, array( 'status' => 'PUBLISH' ), array( 'id' => $id ) );
    }

	public static function delete_data( $id ) {
        global $wpdb;
        
        $wpdb->delete( $wpdb->prefix . self::table_name, array( 'id' => $id ) );
    }

    public static function get_all_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::table_name;
        $query = "SELECT * FROM $table_name";

        $logs = $wpdb->get_results( $query );
        return $wpdb->num_rows;
    }

    public static function get_success_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::table_name;
        $query = "SELECT * FROM $table_name";
        $query .= " WHERE `mailchimp_status` = 'SUCCESS' AND `status` = 'PUBLISH'";

        $logs = $wpdb->get_results( $query );
        return $wpdb->num_rows;
    }

    public static function get_fail_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::table_name;
        $query = "SELECT * FROM $table_name";
        $query .= " WHERE `mailchimp_status` = 'FAIL' AND `status` = 'PUBLISH'";

        $logs = $wpdb->get_results( $query );
        return $wpdb->num_rows;
    }

    public static function get_trash_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::table_name;
        $query = "SELECT * FROM $table_name";
        $query .= " WHERE `status` = 'TRASH'";

        $logs = $wpdb->get_results( $query );
        return $wpdb->num_rows;
    }
}