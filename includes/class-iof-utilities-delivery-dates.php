<?php


require_once plugin_dir_path( dirname( __FILE__ ) ) . '/includes/class-iof-utilities-blockout-dates.php';

class Iof_Utilities_Delivery_Dates {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Displays a prompt modal for customers to enter their zip code.
	 */
	public function display_zip_code_modal() {
		$zip = WC()->customer->get_shipping_postcode();

		$product_id = 1372;
		$in_cart = false;

		foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];

			if( $product_id == $_product->id ) {
				$in_cart = true;
			}
		}

		if ( empty( $zip ) && WC()->cart->get_cart_contents_count() != 0 && ! $in_cart ) {
			
			include_once( __DIR__ . '/../public/partials/cart/modals/zip-code.php' );
		}
	}

	/**
	 * Get all the disabled dates, as well as the next available dates, and the max date.
	 *
	 * @return mixed
	 */
	public function get_all_disabled_dates() {

		global $wpdb;
		$shipping_zip = WC()->customer->get_shipping_postcode();

		$cart = WC()->cart->get_cart();
	     if (!empty($cart)) {
	         foreach ( $cart as $cart_item_key => $cart_item )
	            $output[] = $cart_item_key ;
	     }


		// $shipping_zip = wc_clean( $_POST["zip"] );

		// if ( is_numeric( $zip ) ) {
		// 	WC()->customer->set_shipping_postcode( $shipping_zip );
		// } else {
		// 	$shipping_zip = WC()->customer->get_shipping_postcode();
		// }

		date_default_timezone_set( 'America/New_York' );

		$all_blocked_dates = array();
		$week_disabled     = array();
		$available_dates   = array();
		$max_date          = date( "Y-m-d", strtotime( "+4 week" ) );
		$min_date          = date( "Y-m-d" );
		
		$max_date_msg      = 'Sorry, you can only have a maximum of 5 delivery dates for all combined products.';

		$cart_page_id   = get_option( 'woocommerce_cart_page_id' );
		if(count($output) > 1){
			if(count($output) == 2 ){
				$max_deliveries_count = 10;
			}else if(count($output) == 3 ){
				$max_deliveries_count = 15;
			}else if(count($output) == 4 ){
				$max_deliveries_count = 20;
			}else if(count($output) == 5 ){
				$max_deliveries_count = 25;
			}else if(count($output) == 6 ){
				$max_deliveries_count = 30;
			}else if(count($output) == 7 ){
				$max_deliveries_count = 35;
			}else if(count($output) == 8 ){
				$max_deliveries_count = 40;
			}else if(count($output) == 9 ){
				$max_deliveries_count = 45;
			}
			$max_deliveries = (get_field( 'max_deliveries', $cart_page_id ))?get_field( 'max_deliveries', $cart_page_id ) : $max_deliveries_count;
		}else{
			$max_deliveries = (get_field( 'max_deliveries', $cart_page_id ))?get_field( 'max_deliveries', $cart_page_id ) : 5;	
		}

	
		

		$deliveries     = self::get_cart_and_page_dates();
		$num_deliveries = count( $deliveries );
		if ( $num_deliveries <= $max_deliveries ) {
			if ( empty( $shipping_zip ) ) {
				$delivery_type = 'courier';
			} else {
				$shipping_method = $wpdb->get_results( "SELECT DISTINCT(method_id) FROM {$wpdb->prefix}woocommerce_shipping_zone_methods as m JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as z ON m.zone_id = z.zone_id WHERE z.location_code = {$shipping_zip}" );
				$delivery_type   = ( ! empty( $shipping_method ) ) ? 'courier' : 'outsourced';
			}
			

			$all_blocked_dates = Iof_Utilities_Blockout_Dates::get_blocked_dates( $delivery_type );
			$week_disabled     = Iof_Utilities_Blockout_Dates::get_days_disabled( $delivery_type );
			$available_dates   = self::get_next_available_dates( $all_blocked_dates, $week_disabled );
			$min_date          = self::get_min_delivery_date( $delivery_type, $all_blocked_dates, $week_disabled );
			$selected_dates    = self::get_all_selected_dates( $min_date );
			$max_date_msg      = '';
		}


		return wp_send_json( array(
			'disabled_dates'     => $all_blocked_dates,
			'disabled_week_days' => $week_disabled,
			'max_date'           => $max_date,
			'min_date'           => $min_date,
			'available_dates'    => $available_dates,
			'max_date_msg'       => $max_date_msg,
			'selected_dates'     => $selected_dates,
			'zip'                => ($shipping_zip)?$shipping_zip:""
		), 200 );
	}

	/**
	 * Save a customer's zip code on AJAX.
	 */
	public function save_zip_code() {
		$zip = wc_clean( $_POST["zip"] );
		if(!empty($zip)){
			if ( is_numeric( $zip ) ) {
				WC()->shipping()->reset_shipping();

				WC()->customer->set_shipping_postcode( $zip );
				WC()->customer->set_calculated_shipping( true );
				WC()->customer->save();

			}
	
		}else{
			$zip = "";
		}
		
		echo $zip;
		wp_die();
	}


		/**
	 * Save a customer's zip code on AJAX.
	 */
	public function save_checkout_zip_code() {

		$zip = wc_clean( $_POST["zip"] );
		$state_name = wc_clean( $_POST["state_name"] );
		$city_name = wc_clean( $_POST["city_name"] );

		if(!empty($zip)){
			if ( is_numeric( $zip ) ) {
				
				WC()->shipping()->reset_shipping();
				WC()->customer->set_shipping_postcode( $zip );
				$Customer_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false&key=AIzaSyBc0-fXQI_zhOFD3fBeo_zuykD63FTfXgA";
				$result_string = file_get_contents($Customer_url);
				$Cusresult = json_decode($result_string, true);
		        $address_components =   $Cusresult['results'][0]['address_components'];
    
    
			    $aaa = $Cusresult['results'][0]['formatted_address'];
			    $bbb = explode(',', $aaa);

			    $city_name =   $bbb[0];
			    $state_names = explode(' ', $bbb[1]);
			    $state_name = $state_names[1];

			    $address['country']  = 'US';
				$address['state']    = $state_name;
				$address['postcode'] = $zip;
				$address['city']     = $city_name;
				$address = apply_filters( 'woocommerce_cart_calculate_shipping_address', $address );

				
				if ( $address['country'] ) {
					if ( ! WC()->customer->get_billing_first_name() ) {
						WC()->customer->set_billing_location( $address['country'], $address['state'], $address['postcode'], $address['city'] );
					}
					WC()->customer->set_shipping_location( $address['country'], $address['state'], $address['postcode'], $address['city'] );
				} else {
					WC()->customer->set_billing_address_to_base();
					WC()->customer->set_shipping_address_to_base();
				}

				WC()->customer->set_calculated_shipping( true );
				WC()->customer->save();
				WC()->cart->calculate_shipping();
				WC()->cart->calculate_totals();
				unset( WC()->session->refresh_totals, WC()->session->reload_checkout );
				
				wc_add_notice( __( 'Shipping costs updated.', 'woocommerce' ), 'notice' );
				do_action( 'woocommerce_calculated_shipping' );
			}
		}else{
			$zip = "";
			$city_name = $city_name;
			$state_name = $state_name;
		}

		$delivery_dates_arr = array();
		foreach( WC()->cart->get_cart() as $cart_item ){
	        $delivery_dates_arr[] = $cart_item['delivery_dates'];
	    }


		foreach ( WC()->cart->get_shipping_packages() as $package_id => $package ) {
  	        // Check if a shipping for the current package exist
  	        if ( WC()->session->__isset( 'shipping_for_package_'.$package_id ) ) {
  	            // Loop through shipping rates for the current package
  	            foreach ( WC()->session->get( 'shipping_for_package_'.$package_id )['rates'] as $shipping_rate_id => $shipping_rate ) {
  	                $method_id   = $shipping_rate->get_method_id(); 
  	            }

  	        }
  	    }



  	    $added = false;
  	    if($method_id == 'ups'){
  	    	foreach ($delivery_dates_arr as $delivery_list) {
  	    		foreach ($delivery_list as $date) {
  	    			$datecheck = date('D',strtotime($date));
	  	    			$added=true;

 	    		}

  	    	}
  	    }

		$delivery_dates = $added;
		session_start();
		$_SESSION['cartSessionCheckout'] = 1;

		$my_array = array(
			'city_name' => $city_name,
			'state_name' => $state_name,
			'zip' => $zip,
			'delivery_dates' => $delivery_dates,
		);
		echo json_encode($my_array) ;
		wp_die();
	}





	/**
	 * Save the delivery dates to the cart on the cart page.
	 *
	 * @param $cart_updated
	 *
	 * @return mixed
	 */
	public function save_delivery_dates( $cart_updated ) {

		if ( isset( $_POST['delivery-dates'] ) && ! empty( $_POST['delivery-dates'] ) ) {
			$delivery_dates = wc_clean( $_POST['delivery-dates'] );
			$cart = WC()->cart->get_cart();
			
			foreach ( $cart as $item_key => $item ) {

				if ( ! empty( $delivery_dates[ $item_key ] ) ) {
					$all_deliveries                      = self::format_dates_for_storage( array_unique( $delivery_dates[ $item_key ] ) );
					$cart[ $item_key ]['delivery_dates'] = $all_deliveries;
				}

			}

			WC()->cart->set_cart_contents( $cart );

			if ( $cart_updated === true ) {
				//WC()->session->set( 'cart', WC()->cart->get_cart_for_session() );
			}
		}

		return $cart_updated;
	}

	/**
	 * Helper function to format dates before storing in cart / DB.
	 *
	 * @param array $dates      The dates in human readable format.
	 *
	 * @return array            The dates as they should be stored.
	 */
	private function format_dates_for_storage( $dates ) {
		$formatted_dates = array();
		foreach ( $dates as $date ) {
			$formatted_date    = date( 'Y-m-d', strtotime( $date ) );
			if ( strtotime( $formatted_date ) > strtotime( date('Y-m-d') ) ) {
				$formatted_dates[] = date( 'Y-m-d', strtotime( $date ) );
			}
		}
		
		return $formatted_dates;
	}

	/**
	 * Helper function to format dates before storing in cart / DB.
	 *
	 * @param array $dates      The dates as they are stored.
	 *
	 * @return array            The dates in human readable form.
	 */
	public function format_dates_for_display( $dates ) {
		$formatted_dates = array();
		foreach ( $dates as $date ) {
			$formatted_dates[] = date( 'l, M jS Y', strtotime( $date ) );
		}

		return $formatted_dates;
	}

	/**
	 * Save the delivery dates to an order when it is processed at checkout.
	 *
	 * @param $item
	 * @param $cart_item_key
	 * @param $values
	 * @param $order
	 */
	public function add_dates_to_order_items( $item, $cart_item_key, $values, $order ) {
		$delivery_dates = self::get_items_delivery_dates();
		foreach ( $delivery_dates as $key => $dates ) {
			if ( $key == $cart_item_key ) {
				foreach ( $dates as $index => $date ) {
					$item->add_meta_data( __( "_iof_delivery_date" ), $date );
				}
			}
		}
	}


	/**
	 * Adjust the cart total and subtotal with delivery dates.
	 *
	 * @param $cart_object
	 */
	public function adjust_cart_totals( $cart_object ) {
		
		if ( ! empty( $cart_object ) ) {
			global $wpdb;
			$tax      = 0;
			$subtotal = 0;

			foreach ( $cart_object->get_cart() as $cart_item_key => $cart_item ) {
				$deliveries  = ( ! empty( $cart_item['delivery_dates'] ) ) ? count( $cart_item['delivery_dates'] ) : 1;

				// Get one meal price
				$price =  $cart_item['data']->get_price(); /*get_post_meta($cart_item['product_id'] , '_price', true);*/

				// Get total meal price * number of deliveries
				$item_total = $deliveries * $price;

				// Add total price of meal to cart subtotal
				$subtotal   += $item_total;

				$item_tax = $deliveries * $cart_item['line_tax'];
				$tax      += $item_tax;

				// Add number of deliviries to quantity
				$cart_object->set_quantity( $cart_item_key, $deliveries, false );
			}


			$shipping_charge  = $cart_object->get_shipping_total();

			$shipping_taxes   = array( $cart_object->get_shipping_tax() );

			$shipping_taxes   = self::adjust_cart_shipping_taxes( $shipping_taxes );

			$shipping_tax     = $shipping_taxes[0];
			$total_deliveries = 1;
			$shipping_zip = wc_clean( WC()->customer->get_shipping_postcode() );

			if ( empty( $shipping_zip ) ) {
				$delivery_type = 'courier';
			} else {
				$shipping_method = $wpdb->get_results( "SELECT DISTINCT(method_id) FROM {$wpdb->prefix}woocommerce_shipping_zone_methods as m JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as z ON m.zone_id = z.zone_id WHERE z.location_code = {$shipping_zip};" );
				$delivery_type   = ( ! empty( $shipping_method ) ) ? 'courier' : 'outsourced';
			}

			if ( ! empty( $delivery_type ) ) {
				$total_deliveries = ( $delivery_type == 'courier' ) ? count( self::get_cart_delivery_dates() ) : $total_deliveries;
				//$total_deliveries = count( self::get_cart_delivery_dates() );
			}




			$shipping = $total_deliveries * $shipping_charge;

			//$cart_object->set_shipping_total( $shipping );

			$tax      += $shipping_tax;


			$cart_object->set_subtotal( $subtotal );
			//Extra Code for UPS Normal meal
	
			$discount = 0;
			if($cart_object->get_applied_coupons()){
				$coupons = $cart_object->coupon_discount_totals;
				$discount = array_sum($coupons);
			}

			foreach ( WC()->cart->get_shipping_packages() as $package_id => $package ) {
			    // Check if a shipping for the current package exist
			    if ( WC()->session->__isset( 'shipping_for_package_'.$package_id ) ) {
			        // Loop through shipping rates for the current package
			        foreach ( WC()->session->get( 'shipping_for_package_'.$package_id )['rates'] as $shipping_rate_id => $shipping_rate ) {
			            $method_id   = $shipping_rate->get_method_id(); // The shipping method slug
			        }
			    }
			}
			if($method_id == 'ups'){
				$tax = WC()->cart->get_taxes_total();
			}

			$cart_object->set_total( $subtotal + $shipping + $tax - $discount);
		}
	}

	public function adjust_cart_discount( $cart_object ){
			$coupons = $cart_object->get_applied_coupons();

			foreach ( $coupons as $key => $value) {
				$coupon = new WC_Coupon( $value );
				$coupon_amount += $coupon->get_amount();
			}

			$cart_object->set_discount_total( $coupon_amount );

			$cart_total = $cart_object->get_totals();
			$new_price = $cart_total["total"] - $coupon_amount;

			if ( $new_price < 0 ) {
				$new_price = 0;
			}

			$cart_object->set_total( $new_price );

	}


	public function additional_shipping( $cart_object ){

		$total_deliveries = count( self::get_cart_delivery_dates() );
		$shipping_charge  = $cart_object->get_shipping_total();

		$shipping_zip = wc_clean( WC()->customer->get_shipping_postcode() );
		global $wpdb;

		if ( empty( $shipping_zip ) ) {
			$delivery_type = 'courier';
		} else {
			$shipping_method = $wpdb->get_results( "SELECT DISTINCT(method_id) FROM {$wpdb->prefix}woocommerce_shipping_zone_methods as m JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as z ON m.zone_id = z.zone_id WHERE z.location_code = {$shipping_zip};"  );
			$delivery_type   = ( ! empty( $shipping_method ) ) ? 'courier' : 'outsourced';
		}

		if( $total_deliveries > 1 && $delivery_type == 'courier' ){
			$cart_object->add_fee( 'Additional Shipping', $shipping_charge * ( $total_deliveries - 1 ), $taxable = true, $tax_class = '' );
		}

	}


	/**
	 * Adjust the cart taxes with delivery dates.
	 *
	 * @param $tax_totals
	 *
	 * @return mixed
	 */
	public function adjust_cart_taxes( $tax_totals ) {

		$tax  = 0;
		$cart = WC()->cart->get_cart();
			$custom_item_tax = 0;
		$number_of_deliveries = array();

		if ( ! empty( $cart ) ) {
			$tax = 0;

			foreach ( $cart as $cart_item ) {
				if($cart_item['delivery_dates']){
					$deliveries  = ( ! empty( $cart_item['delivery_dates'] ) ) ? count( $cart_item['delivery_dates'] ) : 1;	
					$item_tax = $deliveries * $cart_item['line_tax'];
					
				}
				if($cart_item['number_of_deliveries']){
					$number_of_deliveries[]  = ( ! empty( $cart_item['number_of_deliveries'] ) ) ? $cart_item['number_of_deliveries'] : 1;	

					$shipping_total = WC()->cart->get_shipping_total();
					$subtotal_cart = $cart_item['line_subtotal'];
					
					$myzipcode = WC()->customer->get_shipping_postcode();
					global $wpdb,$woocommerce;
					if($myzipcode){
						$total_tax_get = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}woocommerce_tax_rate_locations as loc JOIN {$wpdb->prefix}woocommerce_tax_rates as rat ON loc.tax_rate_id = rat.tax_rate_id WHERE loc.location_code = {$myzipcode};" );
				       
						$tax_cal = $shipping_total;

						$custom_item_tax =  number_format( ($tax_cal * $total_tax_get[0]->tax_rate)/100, 2);
					}
				}
				
				$tax      += $item_tax;
			}
		}
		// For Normal
		if ( $tax > 0 ) {
			foreach( $tax_totals as $key => $value ) {
				$tax_totals[ $key ] = $tax;
			}
		}
		// For RC
		if($custom_item_tax > 0){
			foreach( $tax_totals as $key => $value ) {
				$already_apply = ($custom_item_tax / array_sum($number_of_deliveries));
				$tax_totals[ $key ] = $custom_item_tax + $value - $already_apply;	
				
			}	
		}

		return $tax_totals;
	}

	/**
	 * Adjust shipping tax based on number of deliveries in cart.
	 *
	 * @param $shipping_taxes
	 *
	 * @return int
	 */
	public function adjust_cart_shipping_taxes( $shipping_taxes ) {
		$total_deliveries = count( self::get_cart_delivery_dates() );
		if ( ! empty( $shipping_taxes ) && $total_deliveries > 0 ) {
			foreach( $shipping_taxes as $key => $tax ) {
				$shipping_taxes[ $key ] *= $total_deliveries;
			}
		}


		return $shipping_taxes;
	}

	/**
	 * Helper function to get all delivery dates associated with the cart items (sessions object, not the page).
	 *
	 * @return array        format: [ $item_key1 => [ $date1, $date2... ], $item_key2... ]
	 */
	private static function get_items_delivery_dates() {
		
		$dates = array();
		$cart  = WC()->cart->get_cart();
		foreach ( $cart as $item_key => $item ) {
			if ( ! empty( $item['delivery_dates'] ) ) {
				$dates[ $item_key ] = $item['delivery_dates'];
			}
		}

		return $dates;
	}

	/**
	 * Helper function to get exact deliveries for cart that are stored, removes duplicates from separate order items.
	 *
	 * @return array
	 */
	public static function get_cart_delivery_dates() {

		$all_deliveries = array();
		$delivery_dates = self::get_items_delivery_dates();

		foreach ( $delivery_dates as $item_key => $dates ) {
			foreach ( $dates as $date ) {
				$all_deliveries[] = $date;
			}
		}

		$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

		$chosen_shipping = $chosen_methods[0];

		$chosen_shipping = explode( ':', $chosen_shipping );

		if ( ! empty( $all_deliveries ) ) {
			if( 'fedex' == $chosen_shipping[0] ){
				$all_deliveries = self::format_dates_for_storage(  $all_deliveries );
			} else {
				$all_deliveries = self::format_dates_for_storage( array_unique( $all_deliveries ) );
			}
		}

		
		
		return $all_deliveries;
	}

	/**
	 * Helper function to get all the selected dates on the cart page. Filters out any dates that are before the minimum date.
	 *
	 * @param string $min_date      The minimum date to use.
	 *
	 * @return array                All the selected dates, filtered by the minimum date.
	 */
	private static function get_all_selected_dates( $min_date ) {
		$selected_dates = array();

		if ( isset( $_POST['selected_dates'] ) && ! empty( $_POST['selected_dates'] ) ) {
			$selected_dates = wc_clean( $_POST['selected_dates'] );

			foreach ( $selected_dates as $key => $item_selected_dates ) {
				foreach ($item_selected_dates as $index => $date ) {
					if ( strtotime( $date ) < strtotime( $min_date ) ) {
						$selected_dates[ $key ][ $index ] = $min_date;
					}
					$selected_dates[ $key ][ $index ] = date( "Y-m-d", strtotime( $selected_dates[ $key ][ $index ] ) );
				}
			}
		}

		return $selected_dates;
	}

	/**
	 * Gets the selected dates from the cart session object as well as any dates selected from the cart page that are not yet saved in the cart session object.
	 *
	 * @return array
	 */
	private static function get_cart_and_page_dates() {
		self::set_dates_to_post_array();
		self::save_delivery_dates( true );
		$stored_dates    = self::get_cart_delivery_dates();

		if ( isset( $_POST['selected_dates'] ) && ! empty( $_POST['selected_dates'] )  ) {
			$new_dates     = wc_clean( $_POST['selected_dates'] );
			$all_new_dates = array();

			$_POST['delivery-dates'] = $new_dates;

			foreach ( $new_dates as $order_item_row ) {
				foreach ( $order_item_row as $date ) {
					$all_new_dates[] = date( 'Y-m-d', strtotime( $date ) );
				}
			}

			$stored_dates = array_merge( $all_new_dates, $stored_dates );
		}

		$stored_dates = array_unique( $stored_dates );

		return $stored_dates;
	}

	/**
	 * Set any dates not yet stored to the PHP POST var. Case when a new item is added and no delivery dates are stored yet.
	 *
	 * @return array
	 */
	private function set_dates_to_post_array() {
		$not_stored_dates = array();

		if ( isset( $_POST['all_data'] ) && ! empty( $_POST['all_data'] ) ) {
			$_data = array();
			$data  = $_POST['all_data'];
			parse_str( $data, $_data );

			foreach ( $_data as $index => $items ) {
				if ( $index != 'delivery-dates' ) {
					continue;
				}

				foreach ( $items as $key => $dates ) {
					foreach ( $dates as $date ) {
						$not_stored_dates[ $key ][] = date( 'Y-m-d', strtotime( $date ) );
					}
				}
			}

			$_POST['delivery-dates'] = $not_stored_dates;
		}
	}

	/**
	 * Get a single delivery date. Used when an item is added to the cart.
	 *
	 * @return array        The next available date, in an array.
	 */
	public function get_single_available_date() {
		global $wpdb;
		date_default_timezone_set( 'America/New_York' );
		$date            = array( array( date( 'Y-m-d' ) ) );
		$shipping_zip    = WC()->customer->get_shipping_postcode();

		if ( empty( $shipping_zip ) ) {
			$delivery_type = 'outsourced';
		} else {
			$shipping_method = $wpdb->get_results( "SELECT DISTINCT(method_id) FROM {$wpdb->prefix}woocommerce_shipping_zone_methods as m JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as z ON m.zone_id = z.zone_id WHERE z.location_code = {$shipping_zip};" );
			$delivery_type   = ( ! empty( $shipping_method ) ) ? 'courier' : 'outsourced';
		}


		$blocked_dates = Iof_Utilities_Blockout_Dates::get_blocked_dates( $delivery_type );
		$week_disabled     = Iof_Utilities_Blockout_Dates::get_days_disabled( $delivery_type );
		$available_date    = self::get_next_available_dates( $blocked_dates, $week_disabled, $date );

		$min_date          = self::get_min_delivery_date( $delivery_type, $all_blocked_dates, $week_disabled );

		if ( ! empty( $min_date ) ) {
			$selected_dates    = array( $min_date );
			$all_blocked_dates = Iof_Utilities_Blockout_Dates::get_four_weeks_block_out_dates( $selected_dates, $blocked_dates, $week_disabled, false );

			foreach ( $selected_dates as $key => $order_item_row ) {

				foreach ( $all_blocked_dates[ $key ] as $block_out_date ) {

					if ( $min_date != $block_out_date ) {
						continue;
					}

					$min_date = date( 'Y-m-d', strtotime( $min_date . ' +1 day' ) );
				}
			}
		}

		return array( $min_date );
	}

	/**
	 * Helper function to get the minimum delivery date.
	 *
	 * @param string $delivery_type            Courier or outsourced (FedEx).
	 * @param array $blocked_dates             Holidays, as dates.
	 * @param array $blocked_week_days         Weekends, as integers.
	 *
	 * @return false|string                    The minimum delivery date.
	 */
	private static function get_min_delivery_date( $delivery_type, $blocked_dates, $blocked_week_days ) {
		$min_date = ( $delivery_type == 'courier' ) ? date("Y-m-d", strtotime( "+1 day" ) ) : date( "Y-m-d", strtotime( "+2 days" ) );

		if ( $delivery_type != 'courier' ) {
			date_default_timezone_set( 'America/New_York' );
        	$current_hour = date('G');

			if ( $current_hour >= 15 ) {
            	$min_date = date( "Y-m-d", strtotime( "+3 days" ) );
	        } else {
	            $min_date = date( "Y-m-d", strtotime( "+2 days" ) );
	        }
		}

		if ( ( isset( $_POST['selected_dates'] ) && ! empty( $_POST['selected_dates'] ) ) || ! empty( $date ) ) {
			$selected_dates    = ( ! empty( $date ) ) ? $date : wc_clean( $_POST['selected_dates'] );
			$all_blocked_dates = Iof_Utilities_Blockout_Dates::get_four_weeks_block_out_dates( $selected_dates, $blocked_dates, $blocked_week_days, false );

			foreach ( $selected_dates as $key => $order_item_row ) {

				foreach ( $all_blocked_dates[ $key ] as $block_out_date ) {

					if ( $min_date != $block_out_date ) {
						continue;
					}

					$min_date = date( 'Y-m-d', strtotime( $min_date . ' +1 day' ) );
				}
			}
		}

		return $min_date;
	}

	/**
	 * Helper function to get the next available shipping date(s).
	 *
	 * @param array $blocked_dates          All dates not available. Holidays.
	 * @param array $blocked_week_days      All weekdays not available. Weekends.
	 * @param array $date                   A single date, used when adding a new item to cart.
	 *
	 * @return array                        The next available dates, per cart item.
	 */
	private static function get_next_available_dates( $blocked_dates, $blocked_week_days, $date = array() ) {
		
		$available_dates = array();
		if ( ( isset( $_POST['selected_dates'] ) && ! empty( $_POST['selected_dates'] ) ) || ! empty( $date ) ) {
			$available_dates   = array();
			$selected_dates    = ( ! empty( $date ) ) ? $date : wc_clean( $_POST['selected_dates'] );
			$all_blocked_dates = Iof_Utilities_Blockout_Dates::get_four_weeks_block_out_dates( $selected_dates, $blocked_dates, $blocked_week_days );

			foreach ( $selected_dates as $key => $order_item_row ) {
				$min_selected_date = date( 'Y-m-d', strtotime('+1 day') );
				$next_date         = $min_selected_date;

				foreach ( $all_blocked_dates[ $key ] as $index => $block_out_date ) {

					if ( $next_date != $block_out_date ) {
						$available_dates[ $key ] = $next_date;
						continue;
					}

					$next_date = date( 'Y-m-d', strtotime( $next_date . ' +1 day') );
				}
			}
		}

		return $available_dates;
	}

	/**
	 * Display delivery dates on checkout page review order template.
	 */
	public static function checkout_display_delivery_dates() {
		
		if ( defined( 'DOING_AJAX' ) ) {
			$dates     = array();
			$raw_dates = self::get_cart_delivery_dates();

			foreach ( $raw_dates as $date ) {
				$dates[] = date( 'D, M jS Y', strtotime( $date ) );
			}

			include_once( __DIR__ . '/../public/partials/checkout/delivery-dates.php' );
		}
	}

	/**
	 * Separates identical products as single items (rows) when added to the cart.
	 *
	 * @param mixed $cart_item_data       The cart item data.
	 * @param int   $product_id           The product id of an item.
	 *
	 * @return mixed                The cart item data.
	 */
	public function separate_and_single_same_cart_items( $cart_item_data, $product_id ) {
		$unique_cart_item_key = uniqid();
		$cart_item_data['unique_key'] = $unique_cart_item_key;
		return $cart_item_data;
	}

	/**
	 * Get wild. Return true. Used to force all items to be sold individually.
	 */
	public function return_true() {

		return true;
	}
}

