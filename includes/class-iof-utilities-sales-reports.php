<?php


class Iof_Utilities_salesReport {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }


    public function add_sales_report_menu() {
       add_menu_page('RC/GC Sales Report', 'RC/GC Sales Report', 'read', 'sales-report', array($this, 'display_sales_report'), 'dashicons-clipboard', 9);
    }

    public function add_old_gc_summery_menu() {
       add_menu_page('GC Summary', 'GC Summary', 'read', 'old-summary', array($this, 'display_old_summery_report'), 'dashicons-clipboard', 9);
    }


    public function display_old_summery_report() {
        $refunds = self::get_all_old_summery_report(date('Y-m-d'), date('Y-m-d'));
        ob_start();
        include __DIR__ . '/../admin/partials/sales_report/summery.php';
        $result = ob_get_clean();
        echo $result;
    }





     public function display_sales_report() {
        $refunds = self::get_all_sales_report(date('Y-m-d'), date('Y-m-d'), $storeName= null, $storeCoupon=null);
        ob_start();
        include __DIR__ . '/../admin/partials/sales_report/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    
   
     public function pull_sales_report() {
        
         if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
            $from_date = sanitize_text_field(date("Y-m-d", strtotime($_POST['from_date'])));
            $to_date = sanitize_text_field(date("Y-m-d", strtotime($_POST['to_date'])));
            $storeName = sanitize_text_field($_POST['storeName']);
            $storeCoupon = sanitize_text_field($_POST['storeCoupon']);
            if(!empty($from_date) && !empty($to_date)) {
                if(strtotime($from_date) <= strtotime($to_date)) {
                    $refunds = self::get_all_sales_report($from_date, $to_date, $storeName,$storeCoupon);
                    ob_start();
                    include __DIR__ . '/../admin/partials/sales_report/refresh.php';
                    $result = ob_get_clean();

                    return wp_send_json(array('display' => $result), 200);
                }
            }
        }

        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }


     public static function get_all_sales_report($from, $to, $storeName=null, $storeCoupon=null) {
        $results = array();
        global $wpdb ;
/*        $filterCoupon = "";
        $filterStore = "";
       
        $storeCoupon = 'rc';*/
         /*$from = '2019-01-28';
        $to = '2019-01-30';*/

        if($storeCoupon == ''){
            if($storeName == ''){
                $filterCoupon = "(pm.meta_key LIKE 'is_gift' OR pm.meta_key LIKE '_iof_recipient_choice' AND ( pm.meta_key = 'orderFrom' AND ( pm.meta_value='FL' OR pm.meta_value='GA') ) ) ";
            }
            if($storeName == 'GA'){
                $filterCoupon = "(pm.meta_key LIKE '_iof_recipient_choice'  AND (pm.meta_key = 'orderFrom' AND pm.meta_value='GA' ) ) ";
            }
            if($storeName == 'FL'){
                $filterCoupon = "(pm.meta_key LIKE '_iof_recipient_choice'  AND (pm.meta_key = 'orderFrom' AND pm.meta_value='FL' ) ) ";
            }

            $filterCoupon = "(pm.meta_key LIKE 'is_gift' OR pm.meta_key LIKE '_iof_recipient_choice' ) ";

        }
        
        if($storeCoupon == 'RC'){
            if($storeName == 'GA'){
                $filterCoupon = "(pm.meta_key LIKE '_iof_recipient_choice'  AND (pm.meta_key = 'orderFrom' AND pm.meta_value='GA' ) ) ";
            }
            if($storeName == 'FL'){
                $filterCoupon = "(pm.meta_key LIKE '_iof_recipient_choice'  AND (pm.meta_key = 'orderFrom' AND pm.meta_value='FL' ) ) ";
            }

            $filterCoupon = "(pm.meta_key LIKE '_iof_recipient_choice' )";
        }
        if($storeCoupon == 'GC'){
            if($storeName == 'GA'){
                $filterCoupon = "(pm.meta_key LIKE 'is_gift' AND (pm.meta_key = 'orderFrom' AND pm.meta_value='GA' ) ) ";
            }
            if($storeName == 'FL'){
                $filterCoupon = "(pm.meta_key LIKE 'is_gift' AND (pm.meta_key = 'orderFrom' AND pm.meta_value='FL' ) ) ";
            }
            $filterCoupon = "(pm.meta_key LIKE 'is_gift' )";
        }



         $sales_report_arr = $wpdb->get_results(" SELECT p.ID FROM " . $wpdb->prefix."posts as p 
            INNER JOIN ".$wpdb->prefix."postmeta as pm on (p.ID = pm.post_id) 
            WHERE p.post_type = 'shop_order' 
            AND (p.post_date >= '".$from."' AND p.post_date <= '".$to."')
            AND ".$filterCoupon." 
            GROUP BY p.ID 
            ORDER BY p.post_date DESC 
        ");

        $sum_purchase_value = array();
        $sum_current_value = array();
        $sum_total_meal_count = array();
        $sum_remaining_meal_count = array();
        $sum_redeem_value = array();
        $sum_remaining_value = array();
        foreach($sales_report_arr as  $order) {
                $orderFrom = get_post_meta($order->ID,'orderFrom',true);  
                if($orderFrom == $storeName){
                    $order = new WC_Order($order->ID);
         
                    $time_created = $order->order_date;
                      
                    if(get_post_meta($order->ID,'_iof_recipient_choice',true)){
                        $total_meal_count_arr = array();
                        foreach ( $order->get_items() as $item_id => $item ) {
                        	if($item->get_meta( 'iof_number_of_deliveries', true )){
                        		$total_meal_count_arr[] = $item->get_meta( 'iof_number_of_deliveries', true );	
                        	}
                        	if($item->get_meta( '_iof_delivery_date', true )){
                        		$total_meal_count_arr[] = count($item->get_meta( '_iof_delivery_date', true ));	
                        	}
                        }

                        $total_meal_count = array_sum($total_meal_count_arr);
                        $coupon_code= get_post_meta($order->ID,'_iof_recipient_choice',true); 
                        $purchase_value = $order->get_total();   
                        $remaining_meal_count = 0;
                        $child_order = array();
                        $redeem_value = "0.00";
                        $remaining_value = $order->get_total(); 
                        if(get_post_meta($order->ID, '_iof_recipient_child_order',true)){
                        	$get_child_order_arr = explode(',', get_post_meta($order->ID, '_iof_recipient_child_order',true));

                        	if(count($get_child_order_arr) > 1){
                        		foreach ($get_child_order_arr as $child_order_id) {
	                        		$child_orders = wc_get_order($child_order_id);
		                        	if(!empty($child_orders)){
		                        		
		                        		$child_delivery_date = array();
			                            foreach ( $child_orders->get_items() as $child_id => $child_order ) {
			                                $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
			                            }
			                            $child_order = implode('<BR>', $child_delivery_date);

			                            $remaining_meal_count = $total_meal_count - count($child_delivery_date);
			                        
		                            	$per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


		                            	if($remaining_meal_count >= 1){
		                            		if($remaining_meal_count != 0){
		                            			$total_redeem_meal = $total_meal_count - $remaining_meal_count;
		                            			$redeem_value =  $per_meal_price * $total_redeem_meal ;	
		                            			$remaining_value =  $order->get_total() - $redeem_value ;
		                            		}else{
		                            			$redeem_value = $per_meal_price * $remaining_meal_count ;	
		                            			$remaining_value = "0.00";
		                            		}
		                            		
		                            	}else{
			                        		$redeem_value = $order->get_total() ;
			                        		$remaining_value = "0.00";
		                            	}
		                                
		                        	}
	                        	}	
                        	}else{
                        		$child_orders = wc_get_order($get_child_order_arr[0]);
	                        	if(!empty($child_orders)){
	                        		
	                        		$child_delivery_date = array();
		                            foreach ( $child_orders->get_items() as $child_id => $child_order ) {
		                                $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
		                            }
		                            $child_order = implode('<BR>', $child_delivery_date);

		                            $remaining_meal_count = $total_meal_count - count($child_delivery_date);
		                        
	                            	$per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


	                            	if($remaining_meal_count >= 1){
	                            		if($remaining_meal_count != 0){
	                            			$total_redeem_meal = $total_meal_count - $remaining_meal_count;
	                            			$redeem_value =  $per_meal_price * $total_redeem_meal ;	
	                            			$remaining_value =  $order->get_total() - $redeem_value ;
	                            		}else{
	                            			$redeem_value = $per_meal_price * $remaining_meal_count ;	
	                            			$remaining_value = "0.00";
	                            		}
	                            		
	                            	}else{
		                        		$redeem_value = $order->get_total() ;
		                        		$remaining_value = "0.00";
	                            	}
	                                
	                        	}

                        	}

                        	
                    	}
                    	 if($redeem_value == '0.00' ){
                    	 	$remaining_meal_count = $total_meal_count;
                    	 }
                    }
                    if(get_post_meta($order->ID,'coupon_sender_name',true)){
                        $coupon_sender_name = get_post_meta($order->ID,'coupon_sender_name',true);    
                        $getGC = get_post_meta($order->ID,'sc_coupon_receiver_details',true);
                        $coupon_code= $getGC[0]['code'];

                        $c = new WC_Coupon($coupon_code);
                        $purchase_value = $order->get_total(); 
                                 
                        $usage_count = $c->usage_count;    
                        $current_value = number_format($c->amount,2);                     
                        
                        if($current_value != 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else if($current_value == 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else{
                            $redeem_value = "";
                        }

                         if($order->get_total() === "0.00" || $order->get_total() === 0.00){
                        	$purchase_value = $current_value;	
                        }
                        if($coupon_code === ""){
                            $current_value = $purchase_value;
                        }

                        
                    }
                    

                    if($redeem_value === 'inf' || $redeem_value === 'nan'){
                        $redeem_value = 0;
                    }
                    $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                    $sum_current_value[] = ($current_value)?$current_value:0;
                    $sum_total_meal_count[] = ($total_meal_count)?$total_meal_count:0;
                    $sum_remaining_meal_count[] = ($remaining_meal_count > 0)?$remaining_meal_count:0;
                    $sum_redeem_value[] = ($redeem_value)?$redeem_value:0;
                    $sum_remaining_value[] = ($remaining_value)?$remaining_value:0;

                }

                if($storeName == ""){
                    $order = new WC_Order($order->ID);
         
                    $time_created = $order->order_date;
                      
                    if(get_post_meta($order->ID,'_iof_recipient_choice',true)){
                        $total_meal_count_arr = array();
                        foreach ( $order->get_items() as $item_id => $item ) {
                            if($item->get_meta( 'iof_number_of_deliveries', true )){
                                $total_meal_count_arr[] = $item->get_meta( 'iof_number_of_deliveries', true );  
                            }
                            if($item->get_meta( '_iof_delivery_date', true )){
                                $total_meal_count_arr[] = count($item->get_meta( '_iof_delivery_date', true )); 
                            }
                        }

                        $total_meal_count = array_sum($total_meal_count_arr);
                        $coupon_code= get_post_meta($order->ID,'_iof_recipient_choice',true); 
                        $purchase_value = $order->get_total();   
                        $remaining_meal_count = 0;
                        $child_order = array();
                        $redeem_value = "0.00";
                        $remaining_value = $order->get_total(); 
                        if(get_post_meta($order->ID, '_iof_recipient_child_order',true)){
                            $get_child_order_arr = explode(',', get_post_meta($order->ID, '_iof_recipient_child_order',true));

                            if(count($get_child_order_arr) > 1){
                                foreach ($get_child_order_arr as $child_order_id) {
                                    $child_orders = wc_get_order($child_order_id);
                                    if(!empty($child_orders)){
                                        
                                        $child_delivery_date = array();
                                        foreach ( $child_orders->get_items() as $child_id => $child_order ) {
                                            $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
                                        }
                                        $child_order = implode('<BR>', $child_delivery_date);

                                        $remaining_meal_count = $total_meal_count - count($child_delivery_date);
                                    
                                        $per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


                                        if($remaining_meal_count >= 1){
                                            if($remaining_meal_count != 0){
                                                $total_redeem_meal = $total_meal_count - $remaining_meal_count;
                                                $redeem_value =  $per_meal_price * $total_redeem_meal ; 
                                                $remaining_value =  $order->get_total() - $redeem_value ;
                                            }else{
                                                $redeem_value = $per_meal_price * $remaining_meal_count ;   
                                                $remaining_value = "0.00";
                                            }
                                            
                                        }else{
                                            $redeem_value = $order->get_total() ;
                                            $remaining_value = "0.00";
                                        }
                                        
                                    }
                                }   
                            }else{
                                $child_orders = wc_get_order($get_child_order_arr[0]);
                                if(!empty($child_orders)){
                                    
                                    $child_delivery_date = array();
                                    foreach ( $child_orders->get_items() as $child_id => $child_order ) {
                                        $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
                                    }
                                    $child_order = implode('<BR>', $child_delivery_date);

                                    $remaining_meal_count = $total_meal_count - count($child_delivery_date);
                                
                                    $per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


                                    if($remaining_meal_count >= 1){
                                        if($remaining_meal_count != 0){
                                            $total_redeem_meal = $total_meal_count - $remaining_meal_count;
                                            $redeem_value =  $per_meal_price * $total_redeem_meal ; 
                                            $remaining_value =  $order->get_total() - $redeem_value ;
                                        }else{
                                            $redeem_value = $per_meal_price * $remaining_meal_count ;   
                                            $remaining_value = "0.00";
                                        }
                                        
                                    }else{
                                        $redeem_value = $order->get_total() ;
                                        $remaining_value = "0.00";
                                    }
                                    
                                }

                            }

                            
                        }
                         if($redeem_value == '0.00' ){
                    	 	$remaining_meal_count = $total_meal_count;
                    	 }
                    }
                    if(get_post_meta($order->ID,'coupon_sender_name',true)){
                        $coupon_sender_name = get_post_meta($order->ID,'coupon_sender_name',true);    
                        $getGC = get_post_meta($order->ID,'sc_coupon_receiver_details',true);
                        $coupon_code= $getGC[0]['code'];

                        $c = new WC_Coupon($coupon_code);
                        $purchase_value = $order->get_total(); 
                                 
                        $usage_count = $c->usage_count;    
                        $current_value = number_format($c->amount,2);                     
                        
                        if($current_value != 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else if($current_value == 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else{
                            $redeem_value = "";
                        }

                         if($order->get_total() === "0.00" || $order->get_total() === 0.00){
                            $purchase_value = $current_value;   
                        }

                         if($coupon_code === ""){
                            $current_value = $purchase_value;
                        }

                    }
                    

                    if($redeem_value === 'inf' || $redeem_value === 'nan'){
                        $redeem_value = 0;
                    }
                    $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                    $sum_current_value[] = ($current_value)?$current_value:0;
                    $sum_total_meal_count[] = ($total_meal_count)?$total_meal_count:0;
                    $sum_remaining_meal_count[] = ($remaining_meal_count > 0)?$remaining_meal_count:0;
                    $sum_redeem_value[] = ($redeem_value)?$redeem_value:0;
                    $sum_remaining_value[] = ($remaining_value)?$remaining_value:0;

                }

              
        }


        $i = 0;
        foreach($sales_report_arr as  $order) {
				$orderFrom = get_post_meta($order->ID,'orderFrom',true);  
                if($orderFrom == $storeName){
                    $order = new WC_Order($order->ID);
                    $time_created = $order->order_date;
                    if(get_post_meta($order->ID,'_iof_recipient_choice',true)){
                        $total_meal_count_arr = array();
                        foreach ( $order->get_items() as $item_id => $item ) {
                        	if($item->get_meta( 'iof_number_of_deliveries', true )){
                        		$total_meal_count_arr[] = $item->get_meta( 'iof_number_of_deliveries', true );	
                        	}
                        	if($item->get_meta( '_iof_delivery_date', true )){
                        		$total_meal_count_arr[] = count($item->get_meta( '_iof_delivery_date', true ));	
                        	}
                        }

                        $total_meal_count = array_sum($total_meal_count_arr);
                        $coupon_code= get_post_meta($order->ID,'_iof_recipient_choice',true); 
                        $purchase_value = $order->get_total();   

                        $remaining_meal_count = 0;
                        $child_order = array();
                        $redeem_value = "0.00";
                        $remaining_value = $order->get_total();   

                        if(get_post_meta($order->ID, '_iof_recipient_child_order',true)){
                        	$get_child_order_arr = explode(',', get_post_meta($order->ID, '_iof_recipient_child_order',true));

                        	if(count($get_child_order_arr) > 1){
                        		foreach ($get_child_order_arr as $child_order_id) {
	                        		$child_orders = wc_get_order($child_order_id);
		                        	if(!empty($child_orders)){
		                        		
		                        		$child_delivery_date = array();
			                            foreach ( $child_orders->get_items() as $child_id => $child_order ) {
			                                $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
			                            }
			                            $child_order = implode('<BR>', $child_delivery_date);

			                            $remaining_meal_count = $total_meal_count - count($child_delivery_date);
			                        
		                            	$per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


		                            	if($remaining_meal_count >= 1){
		                            		if($remaining_meal_count != 0){
		                            			$total_redeem_meal = $total_meal_count - $remaining_meal_count;
		                            			$redeem_value =  $per_meal_price * $total_redeem_meal ;	
		                            			$remaining_value =  $order->get_total() - $redeem_value ;
		                            		}else{
		                            			$redeem_value = $per_meal_price * $remaining_meal_count ;	
		                            			$remaining_value = "0.00";
		                            		}
		                            		
		                            	}else{
			                        		$redeem_value = $order->get_total() ;
			                        		$remaining_value = "0.00";
		                            	}
		                                
		                        	}
	                        	}	
                        	}else{

                        		$child_orders = wc_get_order($get_child_order_arr[0]);
	                        	if(!empty($child_orders)){
	                        		
	                        		$child_delivery_date = array();
		                            foreach ( $child_orders->get_items() as $child_id => $child_order ) {
		                                $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
		                            }
		                            $child_order = implode('<BR>', $child_delivery_date);

		                            $remaining_meal_count = $total_meal_count - count($child_delivery_date);
		                        
	                            	$per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


	                            	if($remaining_meal_count >= 1){
	                            		if($remaining_meal_count != 0){
	                            			$total_redeem_meal = $total_meal_count - $remaining_meal_count;
	                            			$redeem_value =  $per_meal_price * $total_redeem_meal ;	
	                            			$remaining_value = $order->get_total() - $redeem_value ;
	                            		}else{
	                            			$redeem_value = $per_meal_price * $remaining_meal_count ;	
	                            			$remaining_value = "0.00";
	                            		}
	                            	}else{
		                        		$redeem_value = $order->get_total() ;
		                        		$remaining_value = "0.00";
	                            	}
	                                
	                        	}

                        	}
                        }

                    	 if($redeem_value == '0.00' ){
                    	 	$remaining_meal_count = $total_meal_count;
                    	 }
                    	
                    }




                    if(get_post_meta($order->ID,'coupon_sender_name',true)){
                        $coupon_sender_name = get_post_meta($order->ID,'coupon_sender_name',true);    
                        $getGC = get_post_meta($order->ID,'sc_coupon_receiver_details',true);
                        $coupon_code= $getGC[0]['code'];

                        $c = new WC_Coupon($coupon_code);
                        $purchase_value = $order->get_total(); 
                                 
                        $usage_count = $c->usage_count;    
                        $current_value = number_format($c->amount,2);                                     
                        
                        if($current_value != 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else if($current_value == 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else{
                            $redeem_value = "";
                        }
                        if($order->get_total() === "0.00" || $order->get_total() === 0.00){
                        	$purchase_value = $current_value;	
                        }

                        if($coupon_code === ""){
                            $current_value = $purchase_value;
                        }
                    }
                    

                    if($redeem_value === 'inf' || $redeem_value === 'nan'){
                        $redeem_value = 0;
                    }
                    $results[$i]['order_id'] = $order->ID;
                    $results[$i]['order_date'] = !empty($time_created) ? date('M d, Y', strtotime($time_created)) : 'N/A';
                    $results[$i]['coupon_code'] = $coupon_code;
                    $results[$i]['purchase_value'] = $purchase_value;
                    $results[$i]['current_value'] = $current_value;
                    $results[$i]['usage_count'] = $usage_count;
                    $results[$i]['total_meal_count'] = ($total_meal_count)?$total_meal_count:0;
                    $results[$i]['remaining_meal_count'] = ($remaining_meal_count > 0)?$remaining_meal_count:0;
                       $results[$i]['child_order'] = ($child_order)?$child_order:"";
                    $results[$i]['redeem_value'] = ($redeem_value)?$redeem_value:0;
                    $results[$i]['remaining_value'] = ($remaining_value)?$remaining_value:0;
                           $results[$i]['sum_purchase_value'] = array_sum($sum_purchase_value);
                    $results[$i]['sum_current_value'] = array_sum($sum_current_value);
                    $results[$i]['sum_total_meal_count'] = array_sum($sum_total_meal_count);
                    $results[$i]['sum_remaining_meal_count'] = array_sum($sum_remaining_meal_count);
                    $results[$i]['sum_redeem_value'] = array_sum($sum_redeem_value);
                    $results[$i]['sum_remaining_value'] = array_sum($sum_remaining_value);

                    $i++;


                }

                if($storeName == ""){
                    $order = new WC_Order($order->ID);
                    $time_created = $order->order_date;
                    if(get_post_meta($order->ID,'_iof_recipient_choice',true)){
                        $total_meal_count_arr = array();
                        foreach ( $order->get_items() as $item_id => $item ) {
                            if($item->get_meta( 'iof_number_of_deliveries', true )){
                                $total_meal_count_arr[] = $item->get_meta( 'iof_number_of_deliveries', true );  
                            }
                            if($item->get_meta( '_iof_delivery_date', true )){
                                $total_meal_count_arr[] = count($item->get_meta( '_iof_delivery_date', true )); 
                            }
                        }

                        $total_meal_count = array_sum($total_meal_count_arr);
                        $coupon_code= get_post_meta($order->ID,'_iof_recipient_choice',true); 
                        $purchase_value = $order->get_total();   

                        $remaining_meal_count = 0;
                        $child_order = array();
                        $redeem_value = "0.00";
                        $remaining_value = $order->get_total();   

                        if(get_post_meta($order->ID, '_iof_recipient_child_order',true)){
                            $get_child_order_arr = explode(',', get_post_meta($order->ID, '_iof_recipient_child_order',true));

                            if(count($get_child_order_arr) > 1){
                                foreach ($get_child_order_arr as $child_order_id) {
                                    $child_orders = wc_get_order($child_order_id);
                                    if(!empty($child_orders)){
                                        
                                        $child_delivery_date = array();
                                        foreach ( $child_orders->get_items() as $child_id => $child_order ) {
                                            $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
                                        }
                                        $child_order = implode('<BR>', $child_delivery_date);

                                        $remaining_meal_count = $total_meal_count - count($child_delivery_date);
                                    
                                        $per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


                                        if($remaining_meal_count >= 1){
                                            if($remaining_meal_count != 0){
                                                $total_redeem_meal = $total_meal_count - $remaining_meal_count;
                                                $redeem_value =  $per_meal_price * $total_redeem_meal ; 
                                                $remaining_value =  $order->get_total() - $redeem_value ;
                                            }else{
                                                $redeem_value = $per_meal_price * $remaining_meal_count ;   
                                                $remaining_value = "0.00";
                                            }
                                            
                                        }else{
                                            $redeem_value = $order->get_total() ;
                                            $remaining_value = "0.00";
                                        }
                                        
                                    }
                                }   
                            }else{

                                $child_orders = wc_get_order($get_child_order_arr[0]);
                                if(!empty($child_orders)){
                                    
                                    $child_delivery_date = array();
                                    foreach ( $child_orders->get_items() as $child_id => $child_order ) {
                                        $child_delivery_date[] = $child_order->get_meta( '_iof_delivery_date', true );
                                    }
                                    $child_order = implode('<BR>', $child_delivery_date);

                                    $remaining_meal_count = $total_meal_count - count($child_delivery_date);
                                
                                    $per_meal_price = number_format( ($order->get_total() / $total_meal_count) , 2 );


                                    if($remaining_meal_count >= 1){
                                        if($remaining_meal_count != 0){
                                            $total_redeem_meal = $total_meal_count - $remaining_meal_count;
                                            $redeem_value =  $per_meal_price * $total_redeem_meal ; 
                                            $remaining_value = $order->get_total() - $redeem_value ;
                                        }else{
                                            $redeem_value = $per_meal_price * $remaining_meal_count ;   
                                            $remaining_value = "0.00";
                                        }
                                    }else{
                                        $redeem_value = $order->get_total() ;
                                        $remaining_value = "0.00";
                                    }
                                    
                                }

                            }
                        }

                         if($redeem_value == '0.00' ){
                    	 	$remaining_meal_count = $total_meal_count;
                    	 }
                         
                        
                    }




                    if(get_post_meta($order->ID,'coupon_sender_name',true)){
                        $coupon_sender_name = get_post_meta($order->ID,'coupon_sender_name',true);    
                        $getGC = get_post_meta($order->ID,'sc_coupon_receiver_details',true);
                        $coupon_code= $getGC[0]['code'];

                        $c = new WC_Coupon($coupon_code);
                        $purchase_value = $order->get_total(); 
                                 
                        $usage_count = $c->usage_count;    
                        $current_value = number_format($c->amount,2);                                     
                        
                        if($current_value != 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else if($current_value == 0 && $usage_count != 0){
                            $redeem_value = number_format(($purchase_value - $current_value),2) ;
                        }else{
                            $redeem_value = "";
                        }
                        if($order->get_total() === "0.00" || $order->get_total() === 0.00){
                            $purchase_value = $current_value;   
                        }

                         if($coupon_code === ""){
                            $current_value = $purchase_value;
                        }

                    }
                    

                    if($redeem_value === 'inf' || $redeem_value === 'nan'){
                        $redeem_value = 0;
                    }
                    $results[$i]['order_id'] = $order->ID;
                    $results[$i]['order_date'] = !empty($time_created) ? date('M d, Y', strtotime($time_created)) : 'N/A';
                    $results[$i]['coupon_code'] = $coupon_code;
                    $results[$i]['purchase_value'] = $purchase_value;
                    $results[$i]['current_value'] = $current_value;
                    $results[$i]['usage_count'] = $usage_count;
                    $results[$i]['total_meal_count'] = ($total_meal_count)?$total_meal_count:0;
                    $results[$i]['remaining_meal_count'] = ($remaining_meal_count > 0)?$remaining_meal_count:0;
                       $results[$i]['child_order'] = ($child_order)?$child_order:"";
                    $results[$i]['redeem_value'] = ($redeem_value)?$redeem_value:0;
                    $results[$i]['remaining_value'] = ($remaining_value)?$remaining_value:0;
                           $results[$i]['sum_purchase_value'] = array_sum($sum_purchase_value);
                    $results[$i]['sum_current_value'] = array_sum($sum_current_value);
                    $results[$i]['sum_total_meal_count'] = array_sum($sum_total_meal_count);
                    $results[$i]['sum_remaining_meal_count'] = array_sum($sum_remaining_meal_count);
                    $results[$i]['sum_redeem_value'] = array_sum($sum_redeem_value);
                    $results[$i]['sum_remaining_value'] = array_sum($sum_remaining_value);

                    $i++;


                }

               
        }

      //  dd($results);

        return $results;
    }




    // get Old GC Summery Reports

     public static function get_all_old_summery_report() {
        $results = array();
        global $wpdb ;
       
    
         $sales_report_arr = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix."gc_old_order_summery");
   
        foreach($sales_report_arr as  $value) {

                    $results[$i]['month'] = $value->month;
                    $results[$i]['year'] = $value->year;
                    $results[$i]['purchase_value'] = '$'.$value->amount;
      

                    $i++;


              
                    
        }

       // dd($results);

        return $results;
    }



    
}
