<?php


class Iof_Utilities_Reports {

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

    public function add_delivery_report_menu() {
        add_menu_page('Delivery Report', 'Delivery Report', 'read', 'delivery-reports', array($this, 'display_delivery_reports'), 'dashicons-clipboard', 8);
    }

    public function add_refund_report_menu() {
        add_menu_page('Refund Report', 'Refund Report', 'read', 'refund-reports', array($this, 'display_refund_reports'), 'dashicons-clipboard', 9);
    }

     public function add_order_delivery_report_menu() {
        add_menu_page('Delivery Kitchen Report', 'Delivery Kitchen Report', 'read', 'order-reports', array($this, 'display_order_delivery_reports'), 'dashicons-clipboard', 8);
    }

    public function display_refund_reports() {
        $refunds = self::get_all_refund_reports(date('Y-m-d'), date('Y-m-d'), $storeName= null);
        ob_start();
        include __DIR__ . '/../admin/partials/refund_reports/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    public function display_delivery_reports() {
        $shipping_methods = self::get_order_delivery_by_date(date('Y-m-d'), $storeName = null);
        ob_start();
        include __DIR__ . '/../admin/partials/delivery_reports/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    public function display_order_delivery_reports() {
        $shipping_methods = self::get_order_delivery_report_by_date(date('Y-m-d'), $storeName = null);
        ob_start();
        include __DIR__ . '/../admin/partials/order_reports/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    public function pull_delivery_report() {
        
        if(isset($_POST['date'])) {
            $date = sanitize_text_field($_POST['date']);
            $storeName = sanitize_text_field($_POST['storeName']);
            if(!empty($date)) {
                $arr = self::get_order_delivery_by_date($date,$storeName);
                ob_start();
                include __DIR__ . '/../admin/partials/delivery_reports/refresh.php';
                $result = ob_get_clean();
                return wp_send_json(array('display' => $result), 200);
            }
        }

        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

    public function pull_refund_report() {
        if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
            $from_date = sanitize_text_field($_POST['from_date']);
            $to_date = sanitize_text_field($_POST['to_date']);
            $storeName = sanitize_text_field($_POST['storeName']);
            if(!empty($from_date) && !empty($to_date)) {
                if(strtotime($from_date) <= strtotime($to_date)) {
                    $refunds = self::get_all_refund_reports($from_date, $to_date, $storeName);
                    ob_start();
                    include __DIR__ . '/../admin/partials/refund_reports/refresh.php';
                    $result = ob_get_clean();

                    return wp_send_json(array('display' => $result), 200);
                }
            }
        }

        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

     public function pull_order_delivery_report() {
        
        if(isset($_POST['date'])) {

            $date = sanitize_text_field($_POST['date']);
            $storeName = sanitize_text_field($_POST['storeName']);
            if(!empty($date)) {
                $arr = self::get_order_delivery_report_by_date($date,$storeName);
                ob_start();
                include __DIR__ . '/../admin/partials/order_reports/refresh.php';
                $result = ob_get_clean();
                return wp_send_json(array('display' => $result), 200);
            }
        }

        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

    public static function get_all_refund_reports($from, $to, $storeName=null) {
        $results = array();
        global $wpdb ;
      
        $query_args = array(
            'fields'         => 'id=>parent',
            'post_type'      => 'shop_order_refund',
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'date_query' => array(
                array(
                    'after'     => $from,
                    'before'    => $to,
                    'inclusive' => true,
                )
            ),
            
        );

        $refunds = get_posts( $query_args );
        
        $i = 0;
        foreach($refunds as $refund_id => $order_id) {
            $getStoreName = get_post_meta($order_id,'orderFrom',true);
            if($storeName == $getStoreName){
                if($order_id!=1209){
                    $refund = new WC_Order_Refund($refund_id);
                       
                    $order = new WC_Order($order_id);
         
                    $time_created = $order->get_date_modified();


                    $results[$i]['order_id'] = $order_id;
                    $results[$i]['order_date'] = !empty($time_created) ? date('M d, Y h:i:s A', strtotime($time_created)) : 'N/A';
                   
                    $results[$i]['billing_name'] = $order->get_billing_first_name().', '.$order->get_billing_last_name();
                    $results[$i]['billing_address'] = $order->get_billing_first_name().', '.$order->get_billing_last_name(). '<br>' .
                                                      $order->get_billing_address_1(). ' ' . $order->get_billing_address_2(). '<br>' .
                                                      $order->get_billing_city() . ', ' . $order->get_billing_state() . ' ' .
                                                      $order->get_billing_postcode();

                    $results[$i]['billing_phone'] = $order->get_billing_phone();
            
                    $results[$i]['items_ordered'] = '';
                    $results[$i]['grand_total'] = $order->get_total();
                    $results[$i]['refunded_amount'] = $refund->get_amount();
                    $results[$i]['reason'] = $refund->get_reason(); 
                   
                    $i++;
                }
            }
            
            if($storeName == ""){
                if($order_id!=1209){
                    $refund = new WC_Order_Refund($refund_id);
                       
                    $order = new WC_Order($order_id);
         
                    $time_created = $order->get_date_modified();


                    $results[$i]['order_id'] = $order_id;
                    $results[$i]['order_date'] = !empty($time_created) ? date('M d, Y h:i:s A', strtotime($time_created)) : 'N/A';
                   
                    $results[$i]['billing_name'] = $order->get_billing_first_name().', '.$order->get_billing_last_name();
                    $results[$i]['billing_address'] = $order->get_billing_first_name().', '.$order->get_billing_last_name(). '<br>' .
                                                      $order->get_billing_address_1(). ' ' . $order->get_billing_address_2(). '<br>' .
                                                      $order->get_billing_city() . ', ' . $order->get_billing_state() . ' ' .
                                                      $order->get_billing_postcode();

                    $results[$i]['billing_phone'] = $order->get_billing_phone();
            
                    $results[$i]['items_ordered'] = '';
                    $results[$i]['grand_total'] = $order->get_total();
                    $results[$i]['refunded_amount'] = $refund->get_amount();
                    $results[$i]['reason'] = $refund->get_reason(); 
                   
                    $i++;
                }

            }

            

        }

        return $results;
    }

    public static function get_order_delivery_by_date($date = null, $storeName = null) {
        global $wpdb ; 
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'shop_order',
            'post_status' => 'wc-processing',
            'orderby' => 'title',


        );
        $delivery_dt=array();

        $arr_new=array();

        $post_status=array('trash','wc-pending','wc-cancelled');

    
        $start_date_from = $date ; 
        //$date = '2020-07-23' ; 
        /* echo "SELECT * FROM ".$wpdb->prefix."woocommerce_order_itemmeta LEFT JOIN ".$wpdb->prefix."woocommerce_order_items on ".$wpdb->prefix."woocommerce_order_itemmeta.order_item_id= ".$wpdb->prefix."woocommerce_order_items.order_item_id WHERE (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '_iof_delivery_date' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("Y-m-d", strtotime($date))."') OR (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '%Delivery date%' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("F d, Y", strtotime($date))."')" ; 
        die; */
        $delivery_dt_arr = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."woocommerce_order_itemmeta LEFT JOIN ".$wpdb->prefix."woocommerce_order_items on ".$wpdb->prefix."woocommerce_order_itemmeta.order_item_id= ".$wpdb->prefix."woocommerce_order_items.order_item_id WHERE (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '_iof_delivery_date' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("Y-m-d", strtotime($date))."') OR (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '%Delivery date%' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("F d, Y", strtotime($date))."') ");
                
        
        



        foreach($delivery_dt_arr as $element) {

            $getStoreName = get_post_meta($element->order_id,'orderFrom',true);
            if($storeName == $getStoreName){
                array_push($element->counter);
                $hash = $element->order_id;
                $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                $delivery_dt[$hash] = $element;   
            }

            if($storeName == $getStoreName){
                array_push($element->counter);
                $hash = $element->order_id;
                $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                $delivery_dt[$hash] = $element;   
            }

            if($storeName == ''){
                array_push($element->counter);
                $hash = $element->order_id;
                $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                $delivery_dt[$hash] = $element;
            }        


            
        }
            
        $delivery_dt = array_values($delivery_dt);
        if(!empty($delivery_dt)){
            foreach($delivery_dt as $dt){
              

                $ship_method=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_item_type ='shipping' and order_id= ".$dt->order_id, ARRAY_A);

                          /* $item_name = $wpdb->get_row("SELECT ".$wpdb->prefix."woocommerce_order_items.order_item_name FROM ".$wpdb->prefix."woocommerce_order_items LEFT JOIN ".$wpdb->prefix."woocommerce_order_itemmeta ON ".$wpdb->prefix."woocommerce_order_items.order_item_id=".$wpdb->prefix."woocommerce_order_itemmeta.order_item_id WHERE ".$wpdb->prefix."woocommerce_order_items.order_item_type ='line_item' and ".$wpdb->prefix."woocommerce_order_items.order_id= ".$dt->order_id." AND ((".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '_iof_delivery_date%' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("Y-m-d", strtotime($start_date_from))."') OR (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '%Delivery date%' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("F  d, Y", strtotime($start_date_from))."'))", ARRAY_A); */

                $cal=$wpdb->get_row("select ID, post_status from ".$wpdb->prefix."posts where ID=".$dt->order_id);

                if(!empty($dt->order_id) && !in_array($cal->post_status, $post_status, true)){

                        $order = new WC_Order($dt->order_id);

                
                        /* echo $order->get_shipping_address() ;  
                        die;
                         */
                        
                        $shipaddress=$wpdb->get_results("select * from ".$wpdb->prefix."postmeta where ( meta_key='_shipping_first_name' OR   meta_key='_shipping_last_name' OR  meta_key='_shipping_address_1' OR meta_key='_shipping_address_2' OR meta_key='_shipping_city' OR  meta_key='_shipping_state' OR  meta_key='_shipping_postcode' ) AND post_id=".$dt->order_id);

                        $shippingaddre = '';
                        if(!empty($shipaddress)){
                            foreach($shipaddress as $shipadd){
                                $shippingaddre .=  $shipadd->meta_value.' '; 
                                
                            }
                            
                        }
                        
                         $order_id = trim(str_replace('#', '', $order->get_order_number()));

                        $rec_phone=get_post_meta($dt->order_id,'_shipping_phone',true);
                        if(empty($rec_phone))
                        $rec_phone=$order->billing_phone;

                        $merge_notes = self::get_order_coment_notes($dt->order_id);
                        

                        $meal_size=wc_get_order_item_meta( $dt->order_item_id, 'meal-size', true );

                        $order_link= '<a href="'.home_url().'/wp-admin/post.php?post='.$dt->order_id.'&action=edit">'."#".$order_id.'</a>';


                        $my_counter = $dt->counter;


                        if(!in_array($ship_method['order_item_name'], $arr_new, true) ){
                            echo  $mydata;
                           array_push($arr_new,$ship_method['order_item_name']);
                           $arr[$ship_method['order_item_name']]=array('oid'=>array($order_link), 'ship'=>$ship_method['order_item_name'], "item_name" => array($dt->order_item_name), 'ship_address'=>array($shippingaddre),'meal_size' => array($meal_size), 'phone' => array($rec_phone),'order_comment'=> array($merge_notes), 'counter'=>array($my_counter) );
                        
                        }else{
                 
                                    $ts=$arr[$ship_method['order_item_name']]['oid'];

                                    array_push($ts,$order_link);

                                    $arr[$ship_method['order_item_name']]['oid']=$ts;

                                    

                                    $itname=$arr[$ship_method['order_item_name']]['item_name'];

                                    array_push($itname,$dt->order_item_name);

                                    $arr[$ship_method['order_item_name']]['item_name']=$itname;

                                    

                                    $msize=$arr[$ship_method['order_item_name']]['meal_size'];

                                    array_push($msize,$meal_size);

                                    $arr[$ship_method['order_item_name']]['meal_size']=$msize;

                                    


                                    $shipadd=$arr[$ship_method['order_item_name']]['ship_address'];

                                    array_push($shipadd,$shippingaddre);

                                    $arr[$ship_method['order_item_name']]['ship_address']=$shipadd;

                                    

                                    $phone=$arr[$ship_method['order_item_name']]['phone'];

                                    array_push($phone,$rec_phone);

                                    $arr[$ship_method['order_item_name']]['phone']=$phone;

                                    

                                    $ord_comment=$arr[$ship_method['order_item_name']]['order_comment'];

                                    array_push($ord_comment,$merge_notes);

                                    $arr[$ship_method['order_item_name']]['order_comment']=$ord_comment;



                                    $order_counter=$arr[$ship_method['order_item_name']]['counter'];

                                    array_push($order_counter,$my_counter);

                                    $arr[$ship_method['order_item_name']]['counter']=$order_counter;

                            }

                }
            }

        }

         $arr= self::msort($arr, array('ship'));
    
       /* echo "<pre>";
        print_r($arr);
        echo "</pre>";*/
        //die; 
        return  $arr ;
        /*

        $orders      = new WP_Query( $args );
        $results = array();

        while ( $orders->have_posts() ) {
        
            $orders->the_post($orders->post->ID);
            $order = wc_get_order($orders->post->ID);
            $items = $order->get_items();
            foreach ($items as $key => $item) {
                $delivery_date = wc_get_order_item_meta($key, '_iof_delivery_date', true);
                if($delivery_date && $delivery_date == $date) {
                    if(isset($order->iof_recipient_parent_order)) {
                        $parent_id = get_post_meta($order->get_id(), '_iof_recipient_parent_order', true);
                        $parent_order = wc_get_order($parent_id);
                    }
                    $shipping_method = isset($parent_order) ? $parent_order->get_shipping_method() : $order->get_shipping_method();
                    $results[$shipping_method][] =
                        array(
                            'id' => $order->get_id(),
                            'shipping_address' => $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2().
                                                  ' ' . $order->get_shipping_city() . ' ' . $order->get_shipping_state() . ' ' .
                                                  $order->get_shipping_postcode(),
                            'phone' => $order->get_billing_phone(),
                            'order_comments' => $order->get_customer_note(),
                            'delivery_date' => $delivery_date
                        );
                    break;
                }
            }
        }
        wp_reset_query();
        */
    }


    public function get_order_coment_notes($order_id){
        $merge_notes = "";
        $order_comment=get_post_meta($order_id,'order_comment',true);
        $getPostDate = get_post( $order_id );
        $customer_note = $getPostDate->post_excerpt;

        if(!empty($order_comment) && !empty($customer_note)){
            $merge_notes = '<strong>Order Note</strong>: '.$order_comment.'<BR> <strong>Customer Note</strong>: '.$customer_note;
        }else if(!empty($order_comment) && empty($customer_note)){
            if($order_comment)
            $merge_notes = '<strong>Order Note</strong>: '.$order_comment;
        }else{
            if($customer_note)
            $merge_notes = '<strong>Customer Note</strong>: '.$customer_note;
        }

        return $merge_notes;
    }

    
    function msort($array, $key, $sort_flags = SORT_REGULAR) {

        if (is_array($array) && count($array) > 0) {

            if (!empty($key)) {

                $mapping = array();

                foreach ($array as $k => $v) {

                    $sort_key = '';

                    if (!is_array($key)) {

                        $sort_key = $v[$key];

                    } else {

                        // @TODO This should be fixed, now it will be sorted as string

                        foreach ($key as $key_key) {

                            $sort_key .= $v[$key_key];

                        }

                        $sort_flags = SORT_STRING;

                    }

                    $mapping[$k] = $sort_key;

                }

                asort($mapping, $sort_flags);

                $sorted = array();

                foreach ($mapping as $k => $v) {

                    $sorted[] = $array[$k];

                }

                return $sorted;

            }

        }

        return $array;

    }

    // KITCHEN REPORT
    /**
     * Add daily report admin menu page
     *
     * @since    1.0.0
     * @return   void
     */
    public function add_kitchen_report_menu() {
        add_menu_page( 'Kitchen Report', 'Kitchen Report', 'read', 'kitchen_report', array( $this, 'display_kitchen_report' ), 'dashicons-clipboard', 7 );
    }
    
    /**
     * Render kitchen report page
     *
     * @since    1.0.0
     * @return   void
     */
    public function display_kitchen_report() {
        $meals = self::get_kitchen_report( date('Y-m-d', time() ), $storeName = null );
        ob_start();
        include __DIR__ . '/../admin/partials/kitchen_report/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    /**
     * AJAX callbacl tp pull list of products with dilivery at some date
     *
     * @since    1.0.0
     * @param    string     YYYY-MM-DD Delivery date
     * @return   string     HTML with table     
     */
    public function pull_kitchen_report(){

        $date = $_POST['date'];
        $storeName = $_POST['storeName'];
        $meals = self::get_kitchen_report( date( $date ),$storeName );

        ob_start();
        include __DIR__ . '/../admin/partials/kitchen_report/refresh.php';
        $result = ob_get_clean();
        
        wp_send_json_success( $result, $status_code );
    }

    /**
     * Get list of products with dilivery at some date
     *
     * @since    1.0.0
     * @param    string     YYYY-MM-DD Delivery date
     * @return   array      Array with products with delivery at selected date
     */
    public static function get_kitchen_report( $date , $storeName = null) {
        
        global $wpdb;
       // $date = '2020-11-06';
        //$storeName = 'GA';


        if($storeName == 'FL'){
             $commonWhereCondition = "( items2.order_item_name = 'Next Day Air (UPS FL)' OR items2.order_item_name = 'Next Day Air (UPS FL RC)' OR items2.order_item_name = 'Next Day Air (UPS)' )";
            $commonWhereConditionNot = "( items2.order_item_name <> 'Next Day Air (UPS FL)' AND items2.order_item_name <> 'Next Day Air (UPS FL RC)' AND items2.order_item_name <> 'Next Day Air (UPS GA RC)' AND items2.order_item_name <> 'Next Day Air (UPS GA)' AND items2.order_item_name <> 'Next Day Air (UPS)' )";
                     
        }else if($storeName == 'GA'){
            $commonWhereCondition = "( items2.order_item_name = 'Next Day Air (UPS GA)' OR items2.order_item_name = 'Next Day Air (UPS GA RC)' OR items2.order_item_name = 'Next Day Air (UPS)' )";
            $commonWhereConditionNot = "( items2.order_item_name <> 'Next Day Air (UPS GA)' AND items2.order_item_name <> 'Next Day Air (UPS GA RC)' AND items2.order_item_name <> 'Next Day Air (UPS)' )";
        }else{
            $commonWhereCondition = "( items2.order_item_name = 'Next Day Air (UPS FL)' OR items2.order_item_name = 'Next Day Air (UPS GA)' OR items2.order_item_name = 'Next Day Air (UPS FL RC)' OR items2.order_item_name = 'Next Day Air (UPS GA RC)' OR items2.order_item_name = 'Next Day Air (UPS)' )";

            $commonWhereConditionNot = "( items2.order_item_name <> 'Next Day Air (UPS FL)' AND items2.order_item_name <> 'Next Day Air (UPS GA)' AND items2.order_item_name <> 'Next Day Air (UPS FL RC)' AND items2.order_item_name <> 'Next Day Air (UPS GA RC)' AND items2.order_item_name <> 'Next Day Air (UPS)' )";
            
        }
        
        $items = $wpdb->get_results(
            "SELECT meta.order_item_id as order_item_id 
            FROM " . $wpdb->prefix."woocommerce_order_items as items 
            JOIN ".$wpdb->prefix."woocommerce_order_itemmeta as meta on items.order_item_id = meta.order_item_id
            JOIN ".$wpdb->prefix."woocommerce_order_items as items2 on items2.order_id = items.order_id

             WHERE (
                    (
                        ( meta.meta_key = '_iof_delivery_date' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date))."' )
                        OR
                        ( meta.meta_key = '%Delivery date%' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date))."' )
                    )
                    AND
                    ( items2.order_item_type LIKE 'shipping' AND  ".$commonWhereConditionNot."  )
                )
                OR 
            (
                    (
                        ( meta.meta_key = '_iof_delivery_date' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date . '+1 day'))."' )
                        OR
                        ( meta.meta_key = '%Delivery date%' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date . '+1 day'))."' )
                    )
                    AND
                    ( 
                        (items2.order_item_type LIKE 'shipping' AND  ".$commonWhereCondition.")  
                       

                    )
                )
          
            ");

   
        $result = array();

        $orderNotesId = array();
        foreach ( $items as $key => $item ) {
            $order_item = new WC_Order_Item_Product( $item->order_item_id );
            $getPostDate1 = get_post( $order_item->get_order_id());
            if($getPostDate1->post_status != 'wc-cancelled'){

                $get_order_id = $order_item->get_order_id();
                $getStoreName = get_post_meta($get_order_id,'orderFrom',true);
                if($storeName == 'GA' && $getStoreName == 'GA' ){
                     $orderNotesId[] = $order_item->get_order_id();          
                }
                if($storeName == 'FL' && $getStoreName == 'FL' ){
                     $orderNotesId[] = $order_item->get_order_id();          
                }
                if($storeName == '' ){
                     $orderNotesId[] = $order_item->get_order_id();          
                }
            }
            
        }
        
        foreach ( $items as $key => $item ) {
            $order_item = new WC_Order_Item_Product( $item->order_item_id );
            $getPostDate1 = get_post( $order_item->get_order_id() );
            if($getPostDate1->post_status != 'wc-cancelled'){


                $get_order_id = $order_item->get_order_id();

                $getStoreName = get_post_meta($get_order_id,'orderFrom',true);

                
                if($storeName == 'GA' && $getStoreName == 'GA' ){
                    $data = $order_item->get_data();
                    $getPostDate = get_post( $get_order_id );
                    if(!empty($getPostDate->post_excerpt)){
                        $order_comment = '<a href="'.site_url().'/wp-admin/post.php?post='.$get_order_id.'&action=edit" target="_blank">#'.$get_order_id.'</a> '.$getPostDate->post_excerpt."<BR>";        
                    }

                    $product_id = isset($data['variation_id']) ? $data['variation_id'] : $data['product_id'];
                    $variation = new WC_Product( $data['product_id'] );

                    if( !has_term('recipients-choice', 'product_cat', $product_id) ) {
                         $CounterQty = self::get_total_duplicate_product($data['variation_id'], $items, $storeName);
                        $quantity = $data['quantity'];

                        $meal_name = !empty($variation->get_title())?$variation->get_title() : $data['name'];
                         if( wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ){
                            $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) : '' ;
                        }
                        


                        if( $meal_size == 'gourmet-meal-1') {
                            $meal_size = 'gourmet-meal-for-1';
                        }else if($meal_size == 'gourmet-meal-2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'gourmet-meal-3' ){
                            $meal_size = 'gourmet-meal-for-3';
                        }else if($meal_size == 'gourmet-meal-4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'gourmet-meal-5' ){
                            $meal_size = 'gourmet-meal-for-5';
                        }else if($meal_size == 'gourmet-meal-6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'entree-serving-for-2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'entree-serving-for-4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'entree-serving-for-6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Side Serving for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'Side Serving for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Side Serving for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Entree Service for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'SEntree Service for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Entree Service for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Entree Serving for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'SEntree Serving for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Entree Serving for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if( ( $meal_size == '3-pound-cake-slices') || ($meal_size == 'number-rolls-3') || ($meal_size == 'number-brownies-3') || ($meal_size == 'number-bars-3') || ($meal_size == '3 French Bread Rolls')){
                            $meal_size = 'three_small';
                        }else if( ($meal_size == '6-pound-cake-slices') || ($meal_size == 'number-rolls-6') || ($meal_size == 'number-brownies-6') || ($meal_size == 'number-bars-6') || ($meal_size == '6 French Bread Rolls') ){
                            $meal_size = 'six_medium';
                        }else if(($meal_size == '9-pound-cake-slices') || ($meal_size == 'number-rolls-9')  || ($meal_size == 'number-brownies-9') || ($meal_size == 'number-bars-9') || ($meal_size == '9 French Bread Rolls') ){
                            $meal_size = 'nine_large';
                        }else if( ($meal_size == '12-pound-cake-slices') || ($meal_size == 'number-rolls-12') || ($meal_size == 'number-brownies-12') || ($meal_size == 'number-bars-12') || ($meal_size == '12 French Bread Rolls') ){
                            $meal_size = 'twelve_large';
                        }


                        $order_notes = ($order_comment)?$order_comment:"";
                        $item_delivery_date = wc_get_order_item_meta( $item->order_item_id, '_iof_delivery_date', true );
                        $side = wc_get_order_item_meta( $item->order_item_id, 'side', true );
                        $vegetable = wc_get_order_item_meta( $item->order_item_id, 'vegetable', true );
                        $salad = wc_get_order_item_meta( $item->order_item_id, 'salad', true );
                        $bread = wc_get_order_item_meta( $item->order_item_id, 'bread', true );
                        $dessert = wc_get_order_item_meta( $item->order_item_id, 'dessert', true );
                        $ordernotes = 'order_note';

                       /*//old code
                        $result['meal'][$meal_name][$meal_size] = $storeName;

                        $result['meal'][$meal_name][$meal_size] = ( isset($result['meal'][$meal_name][$meal_size]) ) ? $result['meal'][$meal_name][$meal_size] + $CounterQty : $CounterQty;

                        $result['meal'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);  */  

                        $product_cat_id = [];
                        $terms = get_the_terms($data['product_id'], 'product_cat' ); 
                       /* echo "<pre>";
                        print_r($order_item);
                        echo "<pre>";*/
                         foreach ($terms as $key => $value) {
                                $product_cat_id[] = $value->term_id;
                             }
                        
                        //117 Bread , 127,107 starch , 128,120 vegitable , 119,126,106 salad , 136 dessert
                        if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id) || in_array(112, $product_cat_id) || in_array(117, $product_cat_id) || in_array(127, $product_cat_id) || in_array(107, $product_cat_id) || in_array(128, $product_cat_id) || in_array(120, $product_cat_id) || in_array(119, $product_cat_id) || in_array(126, $product_cat_id) || in_array(106, $product_cat_id) || in_array(136, $product_cat_id) )
                            { 
                             
                                 if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id)) {  
                                   
                                    $result['Gluten Free'][$meal_name][$meal_size] = '';
                               
                               
                                    $result['Gluten Free'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                 
                                    $result['Gluten Free'][$meal_name][$meal_size] .= ( isset($result['Gluten Free'][$meal_name][$meal_size]) ) ? $result['Gluten Free'][$meal_name][$meal_size] + $CounterQty : $CounterQty;
                                 }
                                 if (in_array(112, $product_cat_id)) {
                                 	if($data['variation_id'] == 0){
                                        $meal_size = 'gourmet-meal-for-2';
                                    }
                                    $result['kids Meals'][$meal_name][$meal_size] = ( isset($result['kids Meals'][$meal_name][$meal_size]) ) ? $result['kids Meals'][$meal_name][$meal_size] + $quantity : $quantity;
                                    $result['kids Meals'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);   
                                    

                                    
                                 }

                                 //bread section
                                 if (in_array(117, $product_cat_id)) {
                                 	
                                 	$result['bread'][$meal_name][$meal_size] = ( isset($result['bread'][$meal_name][$meal_size]) ) ? $result['bread'][$meal_name][$meal_size] + $quantity : $quantity;
                            		$result['bread'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    

                                 }

                                 //starch section
                                 if (in_array(127, $product_cat_id) || in_array(107, $product_cat_id)) {

                                 	 $result['starch'][$meal_name][$meal_size] = ( isset($result['starch'][$meal_name][$meal_size]) ) ? $result['starch'][$meal_name][$meal_size] + $quantity : $quantity;
                            		 $result['starch'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
    	
                                 }

                                 //vagitable
                                 if (in_array(128, $product_cat_id) || in_array(120, $product_cat_id)) {
                                    if (in_array(127, $product_cat_id) || in_array(107, $product_cat_id)) {}else{
                                        $result['vegetable'][$meal_name][$meal_size] = ( isset($result['vegetable'][$meal_name][$meal_size]) ) ? $result['vegetable'][$meal_name][$meal_size] + $quantity : $quantity;
                                        $result['vegetable'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                                    }
                                 	
                                 	
                                 }
                                 
                                 //salad
                                 if (in_array(119, $product_cat_id) || in_array(126, $product_cat_id) || in_array(106, $product_cat_id) ) {
                                 	
                                 	$result['salad'][$meal_name][$meal_size] = ( isset($result['salad'][$meal_name][$meal_size]) ) ? $result['salad'][$meal_name][$meal_size] + $quantity : $quantity;
                            		$result['salad'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);	
                                 }
                                 
                                 //dessert
                                 if (in_array(136, $product_cat_id)) {
                                 	if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id)) {  }else{
                                        $result['dessert'][$meal_name][$meal_size] = ( isset($result['dessert'][$meal_name][$meal_size]) ) ? $result['dessert'][$meal_name][$meal_size] + $quantity : $quantity;
                                        $result['dessert'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                                    }
                                 	
                                 } 
                            }
                            else
                            { 
                                $result['meal'][$meal_name][$meal_size] = '';
                                
                               
                                $result['meal'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                 
                                $result['meal'][$meal_name][$meal_size] .= ( isset($result['meal'][$meal_name][$meal_size]) ) ? $result['meal'][$meal_name][$meal_size] + $CounterQty : $CounterQty;
                            }

                     
                        if ( $side && 'None' !== $side ) {
                           
                            $result['starch'][$side][$meal_size] = ( isset($result['starch'][$side][$meal_size]) ) ? $result['starch'][$side][$meal_size] + $quantity : $quantity;
                            $result['starch'][$side][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    

                        }
                        
                        if ( $vegetable && 'None' !== $vegetable ) {
                            $result['vegetable'][$vegetable][$meal_size] = ( isset($result['vegetable'][$vegetable][$meal_size]) ) ? $result['vegetable'][$vegetable][$meal_size] + $quantity : $quantity;
                            $result['vegetable'][$vegetable][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                        if ( $salad && 'None' !== $salad ) {
                            $result['salad'][$salad][$meal_size] = ( isset($result['salad'][$salad][$meal_size]) ) ? $result['salad'][$salad][$meal_size] + $quantity : $quantity;
                            $result['salad'][$salad][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                       
                        if ( $dessert && 'None' !== $dessert ) {
                            $result['dessert'][$dessert][$meal_size] = ( isset($result['dessert'][$dessert][$meal_size]) ) ? $result['dessert'][$dessert][$meal_size] + $quantity : $quantity;
                            $result['dessert'][$dessert][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                        if ( $bread && 'None' !== $bread ) {
                            $result['bread'][$bread][$meal_size] = ( isset($result['bread'][$bread][$meal_size]) ) ? $result['bread'][$bread][$meal_size] + $quantity : $quantity;
                            $result['bread'][$bread][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }
                        
                        
                        
                    }
                }

                if($storeName == 'FL' && $getStoreName == 'FL' ){
                    $data = $order_item->get_data();
                    $getPostDate = get_post( $get_order_id );
                    if(!empty($getPostDate->post_excerpt)){
                        $order_comment = '<a href="'.site_url().'/wp-admin/post.php?post='.$get_order_id.'&action=edit" target="_blank">#'.$get_order_id.'</a> '.$getPostDate->post_excerpt."<BR>";        
                    }
                    $product_id = isset($data['variation_id']) ? $data['variation_id'] : $data['product_id'];
                    $variation = new WC_Product( $data['product_id'] );

                    if( !has_term('recipients-choice', 'product_cat', $product_id) ) {
                         $CounterQty = self::get_total_duplicate_product($data['variation_id'], $items, $storeName);
                        $quantity = $data['quantity'];
                        $meal_name = !empty($variation->get_title())?$variation->get_title() : $data['name'];
                         if( wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ){
                            $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) : '' ;
                        }
                        


                        if( $meal_size == 'gourmet-meal-1') {
                            $meal_size = 'gourmet-meal-for-1';
                        }else if($meal_size == 'gourmet-meal-2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'gourmet-meal-3' ){
                            $meal_size = 'gourmet-meal-for-3';
                        }else if($meal_size == 'gourmet-meal-4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'gourmet-meal-5' ){
                            $meal_size = 'gourmet-meal-for-5';
                        }else if($meal_size == 'gourmet-meal-6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'entree-serving-for-2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'entree-serving-for-4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'entree-serving-for-6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Side Serving for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'Side Serving for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Side Serving for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Entree Service for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'SEntree Service for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Entree Service for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Entree Serving for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'SEntree Serving for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Entree Serving for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if( ( $meal_size == '3-pound-cake-slices') || ($meal_size == 'number-rolls-3') || ($meal_size == 'number-brownies-3') || ($meal_size == 'number-bars-3') || ($meal_size == '3 French Bread Rolls')){
                            $meal_size = 'three_small';
                        }else if( ($meal_size == '6-pound-cake-slices') || ($meal_size == 'number-rolls-6') || ($meal_size == 'number-brownies-6') || ($meal_size == 'number-bars-6') || ($meal_size == '6 French Bread Rolls') ){
                            $meal_size = 'six_medium';
                        }else if(($meal_size == '9-pound-cake-slices') || ($meal_size == 'number-rolls-9')  || ($meal_size == 'number-brownies-9') || ($meal_size == 'number-bars-9') || ($meal_size == '9 French Bread Rolls') ){
                            $meal_size = 'nine_large';
                        }else if( ($meal_size == '12-pound-cake-slices') || ($meal_size == 'number-rolls-12') || ($meal_size == 'number-brownies-12') || ($meal_size == 'number-bars-12') || ($meal_size == '12 French Bread Rolls') ){
                            $meal_size = 'twelve_large';
                        }


                        $order_notes = ($order_comment)?$order_comment:"";
                        $item_delivery_date = wc_get_order_item_meta( $item->order_item_id, '_iof_delivery_date', true );
                        $side = wc_get_order_item_meta( $item->order_item_id, 'side', true );
                        $vegetable = wc_get_order_item_meta( $item->order_item_id, 'vegetable', true );
                        $salad = wc_get_order_item_meta( $item->order_item_id, 'salad', true );
                        $bread = wc_get_order_item_meta( $item->order_item_id, 'bread', true );
                        $dessert = wc_get_order_item_meta( $item->order_item_id, 'dessert', true );
                        $ordernotes = 'order_note';
                      /*//old code
                        $result['meal'][$meal_name][$meal_size] = $storeName;

                        $result['meal'][$meal_name][$meal_size] = ( isset($result['meal'][$meal_name][$meal_size]) ) ? $result['meal'][$meal_name][$meal_size] + $CounterQty : $CounterQty;

                        $result['meal'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);*/  
                        

                        
                        $product_cat_id = [];
                        $terms = get_the_terms($data['product_id'], 'product_cat' ); 
                         foreach ($terms as $key => $value) {
                                $product_cat_id[] = $value->term_id;
                             }
                        
                         
                      //117 Bread , 127,107 starch , 128,120 vegitable , 119,126,106 salad , 136 dessert
                        if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id) || in_array(112, $product_cat_id) || in_array(117, $product_cat_id) || in_array(127, $product_cat_id) || in_array(107, $product_cat_id) || in_array(128, $product_cat_id) || in_array(120, $product_cat_id) || in_array(119, $product_cat_id) || in_array(126, $product_cat_id) || in_array(106, $product_cat_id) || in_array(136, $product_cat_id) )
                            { 
                             
                                 if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id)) {  
                                   
                                    $result['Gluten Free'][$meal_name][$meal_size] = '';
                               
                               
                                    $result['Gluten Free'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                 
                                    $result['Gluten Free'][$meal_name][$meal_size] .= ( isset($result['Gluten Free'][$meal_name][$meal_size]) ) ? $result['Gluten Free'][$meal_name][$meal_size] + $CounterQty : $CounterQty;
                                 }
                                 if (in_array(112, $product_cat_id)) {

                                   if($data['variation_id'] == 0){
                                        $meal_size = 'gourmet-meal-for-2';
                                    }
                                    
                                    $result['kids Meals'][$meal_name][$meal_size] = ( isset($result['kids Meals'][$meal_name][$meal_size]) ) ? $result['kids Meals'][$meal_name][$meal_size] + $quantity : $quantity;
                                    $result['kids Meals'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);   
                                    

                                    
                                 }

                                 //bread section
                                 if (in_array(117, $product_cat_id)) {
                                 	
                                 	$result['bread'][$meal_name][$meal_size] = ( isset($result['bread'][$meal_name][$meal_size]) ) ? $result['bread'][$meal_name][$meal_size] + $quantity : $quantity;
                            		$result['bread'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    

                                 }

                                 //starch section
                                 if (in_array(127, $product_cat_id) || in_array(107, $product_cat_id)) {

                                 	 $result['starch'][$meal_name][$meal_size] = ( isset($result['starch'][$meal_name][$meal_size]) ) ? $result['starch'][$meal_name][$meal_size] + $quantity : $quantity;
                            		 $result['starch'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
    	
                                 }

                                 //vagitable
                                 if (in_array(128, $product_cat_id) || in_array(120, $product_cat_id)) {
                                    if (in_array(127, $product_cat_id) || in_array(107, $product_cat_id)) {}else{
                                        $result['vegetable'][$meal_name][$meal_size] = ( isset($result['vegetable'][$meal_name][$meal_size]) ) ? $result['vegetable'][$meal_name][$meal_size] + $quantity : $quantity;
                                        $result['vegetable'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                                    }
                                 	
                                 	
                                 }
                                 
                                 //salad
                                 if (in_array(119, $product_cat_id) || in_array(126, $product_cat_id) || in_array(106, $product_cat_id) ) {
                                 	
                                 	$result['salad'][$meal_name][$meal_size] = ( isset($result['salad'][$meal_name][$meal_size]) ) ? $result['salad'][$meal_name][$meal_size] + $quantity : $quantity;
                            		$result['salad'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);	
                                 }
                                 
                                 //dessert
                                 if (in_array(136, $product_cat_id)) {
                                 	if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id)) {  }else{
                                     	$result['dessert'][$meal_name][$meal_size] = ( isset($result['dessert'][$meal_name][$meal_size]) ) ? $result['dessert'][$meal_name][$meal_size] + $quantity : $quantity;
                                		$result['dessert'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);
                                    }
                                 } 
                            }
                            else
                            { 
                                $result['meal'][$meal_name][$meal_size] = '';
                                
                               
                                $result['meal'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                 
                                $result['meal'][$meal_name][$meal_size] .= ( isset($result['meal'][$meal_name][$meal_size]) ) ? $result['meal'][$meal_name][$meal_size] + $CounterQty : $CounterQty;
                            }

                       
                      

                        if ( $side && 'None' !== $side ) {
                           
                            $result['starch'][$side][$meal_size] = ( isset($result['starch'][$side][$meal_size]) ) ? $result['starch'][$side][$meal_size] + $quantity : $quantity;
                            $result['starch'][$side][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    

                        }
                        
                        if ( $vegetable && 'None' !== $vegetable ) {
                            $result['vegetable'][$vegetable][$meal_size] = ( isset($result['vegetable'][$vegetable][$meal_size]) ) ? $result['vegetable'][$vegetable][$meal_size] + $quantity : $quantity;
                            $result['vegetable'][$vegetable][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                        if ( $salad && 'None' !== $salad ) {

                            $result['salad'][$salad][$meal_size] = ( isset($result['salad'][$salad][$meal_size]) ) ? $result['salad'][$salad][$meal_size] + $quantity : $quantity;
                            $result['salad'][$salad][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                        if ( $dessert && 'None' !== $dessert ) {
                            $result['dessert'][$dessert][$meal_size] = ( isset($result['dessert'][$dessert][$meal_size]) ) ? $result['dessert'][$dessert][$meal_size] + $quantity : $quantity;
                            $result['dessert'][$dessert][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                        if ( $bread && 'None' !== $bread ) {
                            $result['bread'][$bread][$meal_size] = ( isset($result['bread'][$bread][$meal_size]) ) ? $result['bread'][$bread][$meal_size] + $quantity : $quantity;
                            $result['bread'][$bread][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }
                       
                       
                    }
                }

                if($storeName == ""){
                    $data = $order_item->get_data();
                    $getPostDate = get_post( $get_order_id );

                    if(!empty($getPostDate->post_excerpt)){
                        $order_comment = '<a href="'.site_url().'/wp-admin/post.php?post='.$get_order_id.'&action=edit" target="_blank">#'.$get_order_id.'</a> '.$getPostDate->post_excerpt."<BR>";        
                    }

                    $product_id = isset($data['variation_id']) ? $data['variation_id'] : $data['product_id'];
                    $variation = new WC_Product( $data['product_id'] );


                    if( !has_term('recipients-choice', 'product_cat', $product_id) ) {
                        
                        $CounterQty = self::get_total_duplicate_product($data['variation_id'], $items, $storeName= null);
                        
                        $quantity = $data['quantity'];   
                       
                        $meal_name = !empty($variation->get_title())?$variation->get_title() : $data['name'];

                        
                        if( wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ){
                            $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_pound-cake-slices', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-rolls', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-rolls', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-brownies', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-brownies', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_number-of-bars', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'number-of-bars', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'pa_a-la-carte-entree-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-entree-size', true ) : '' ;
                        }else if( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) ){
                             $meal_size = ( wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) ) ? wc_get_order_item_meta( $item->order_item_id, 'a-la-carte-side-size', true ) : '' ;
                        }
                       


                        if( $meal_size == 'gourmet-meal-1') {
                            $meal_size = 'gourmet-meal-for-1';
                        }else if($meal_size == 'gourmet-meal-2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'gourmet-meal-3' ){
                            $meal_size = 'gourmet-meal-for-3';
                        }else if($meal_size == 'gourmet-meal-4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'gourmet-meal-5' ){
                            $meal_size = 'gourmet-meal-for-5';
                        }else if($meal_size == 'gourmet-meal-6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'entree-serving-for-2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'entree-serving-for-4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'entree-serving-for-6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Side Serving for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'Side Serving for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Side Serving for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Entree Service for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'SEntree Service for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Entree Service for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if($meal_size == 'Entree Serving for 2' ){
                            $meal_size = 'gourmet-meal-for-2';
                        }else if($meal_size == 'SEntree Serving for 4' ){
                            $meal_size = 'gourmet-meal-for-4';
                        }else if($meal_size == 'Entree Serving for 6' ){
                            $meal_size = 'gourmet-meal-for-6';
                        }else if( ( $meal_size == '3-pound-cake-slices') || ($meal_size == 'number-rolls-3') || ($meal_size == 'number-brownies-3') || ($meal_size == 'number-bars-3') || ($meal_size == '3 French Bread Rolls') || ($meal_size == '3 Cheesecake Squares') || ($meal_size == '3 Dessert Bars')){
                            $meal_size = 'three_small';
                        }else if( ($meal_size == '6-pound-cake-slices') || ($meal_size == 'number-rolls-6') || ($meal_size == 'number-brownies-6') || ($meal_size == 'number-bars-6') || ($meal_size == '6 French Bread Rolls') || ($meal_size == '6 Cheesecake Squares') || ($meal_size == '6 Dessert Bars')){
                            $meal_size = 'six_medium';
                        }else if(($meal_size == '9-pound-cake-slices') || ($meal_size == 'number-rolls-9')  || ($meal_size == 'number-brownies-9') || ($meal_size == 'number-bars-9') || ($meal_size == '9 French Bread Rolls') || ($meal_size == '9 Cheesecake Squares') || ($meal_size == '9 Dessert Bars')){
                            $meal_size = 'nine_large';
                        }else if( ($meal_size == '12-pound-cake-slices') || ($meal_size == 'number-rolls-12') || ($meal_size == 'number-brownies-12') || ($meal_size == 'number-bars-12') || ($meal_size == '12 French Bread Rolls') || ($meal_size == '12 Cheesecake Squares') || ($meal_size == '12 Dessert Bars')){
                            $meal_size = 'twelve_large';
                        }



                        //$meal_size = wc_get_order_item_meta( $item->order_item_id, 'pa_meal-size', true ) ;    
                      
                        $order_notes = ($order_comment)?$order_comment:"";
                        $item_delivery_date = wc_get_order_item_meta( $item->order_item_id, '_iof_delivery_date', true );
                        $side = wc_get_order_item_meta( $item->order_item_id, 'side', true );
                        $vegetable = wc_get_order_item_meta( $item->order_item_id, 'vegetable', true );
                        $salad = wc_get_order_item_meta( $item->order_item_id, 'salad', true );
                        $bread = wc_get_order_item_meta( $item->order_item_id, 'bread', true );
                        $dessert = wc_get_order_item_meta( $item->order_item_id, 'dessert', true );
                        $ordernotes = 'order_note';
                       
                        
                        //find CategoryId with used of ProductID
                         $product_cat_id = [];
                         $terms = get_the_terms($data['product_id'], 'product_cat' ); 
                         foreach ($terms as $key => $value) {
                                $product_cat_id[] = $value->term_id;
                             }
                        
                
                       //117 Bread , 127,107 starch , 128,120 vegitable , 119,126,106 salad , 136 dessert
                        if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id) || in_array(112, $product_cat_id) || in_array(117, $product_cat_id) || in_array(127, $product_cat_id) || in_array(107, $product_cat_id) || in_array(128, $product_cat_id) || in_array(120, $product_cat_id) || in_array(119, $product_cat_id) || in_array(126, $product_cat_id) || in_array(106, $product_cat_id) || in_array(136, $product_cat_id) )
                            { 
                             
                                 if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id)) {  
                                   
                                    $result['Gluten Free'][$meal_name][$meal_size] = '';
                               
                               
                                    $result['Gluten Free'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                 
                                    $result['Gluten Free'][$meal_name][$meal_size] .= ( isset($result['Gluten Free'][$meal_name][$meal_size]) ) ? $result['Gluten Free'][$meal_name][$meal_size] + $CounterQty : $CounterQty;
                                 }
                                 if (in_array(112, $product_cat_id)) {
                                    if($data['variation_id'] == 0){
                                        $meal_size = 'gourmet-meal-for-2';
                                    }

                                     $result['kids Meals'][$meal_name][$meal_size] = ( isset($result['kids Meals'][$meal_name][$meal_size]) ) ? $result['kids Meals'][$meal_name][$meal_size] + $quantity : $quantity;
                                     $result['kids Meals'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);   
                                    
                                    
                                    

                                    
                                 }

                                 //bread section
                                 if (in_array(117, $product_cat_id)) {
                                 	
                                 	$result['bread'][$meal_name][$meal_size] = ( isset($result['bread'][$meal_name][$meal_size]) ) ? $result['bread'][$meal_name][$meal_size] + $quantity : $quantity;
                            		$result['bread'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    

                                 }

                                 //starch section
                                 if (in_array(127, $product_cat_id) || in_array(107, $product_cat_id)) {

                                 	 $result['starch'][$meal_name][$meal_size] = ( isset($result['starch'][$meal_name][$meal_size]) ) ? $result['starch'][$meal_name][$meal_size] + $quantity : $quantity;
                            		 $result['starch'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
    	
                                 }

                                 //vagitable
                                 if (in_array(128, $product_cat_id) || in_array(120, $product_cat_id)) {
                                    if (in_array(127, $product_cat_id) || in_array(107, $product_cat_id)) {}else{
                                        $result['vegetable'][$meal_name][$meal_size] = ( isset($result['vegetable'][$meal_name][$meal_size]) ) ? $result['vegetable'][$meal_name][$meal_size] + $quantity : $quantity;
                                        $result['vegetable'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                                    }

                                 	
                                 	
                                 }
                                 
                                 //salad
                                 if (in_array(119, $product_cat_id) || in_array(126, $product_cat_id) || in_array(106, $product_cat_id) ) {
                                 	
                                 	$result['salad'][$meal_name][$meal_size] = ( isset($result['salad'][$meal_name][$meal_size]) ) ? $result['salad'][$meal_name][$meal_size] + $quantity : $quantity;
                            		$result['salad'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);	
                                 }
                                 
                                 //dessert
                                 if (in_array(136, $product_cat_id)) {
                                 	if (in_array(123, $product_cat_id) || in_array(109, $product_cat_id)) {  }else{
                                        $result['dessert'][$meal_name][$meal_size] = ( isset($result['dessert'][$meal_name][$meal_size]) ) ? $result['dessert'][$meal_name][$meal_size] + $quantity : $quantity;
                                        $result['dessert'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                                    }
                                 	
                                 } 
                            }
                            else
                            { 
                                $result['meal'][$meal_name][$meal_size] = $storeName;
                                    
                                
                                    
                                $result['meal'][$meal_name][$meal_size] .= ( isset($result['meal'][$meal_name][$meal_size]) ) ? $result['meal'][$meal_name][$meal_size] + $CounterQty : $CounterQty;

                                 $result['meal'][$meal_name][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);  
                            }
                        
                       
                        
                       
                      

                        if ( $side && 'None' !== $side ) {
                            $result['starch'][$side][$meal_size] = ( isset($result['starch'][$side][$meal_size]) ) ? $result['starch'][$side][$meal_size] + $quantity : $quantity;
                            $result['starch'][$side][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);  
                           

                        }
                        
                        if ( $vegetable && 'None' !== $vegetable ) {
                            $result['vegetable'][$vegetable][$meal_size] = ( isset($result['vegetable'][$vegetable][$meal_size]) ) ? $result['vegetable'][$vegetable][$meal_size] + $quantity : $quantity;
                            $result['vegetable'][$vegetable][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                        if ( $salad && 'None' !== $salad ) {
                            $result['salad'][$salad][$meal_size] = ( isset($result['salad'][$salad][$meal_size]) ) ? $result['salad'][$salad][$meal_size] + $quantity : $quantity;
                            $result['salad'][$salad][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }
                     

                        if ( $dessert && 'None' !== $dessert ) {
                            $result['dessert'][$dessert][$meal_size] = ( isset($result['dessert'][$dessert][$meal_size]) ) ? $result['dessert'][$dessert][$meal_size] + $quantity : $quantity;
                            $result['dessert'][$dessert][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }

                         if ( $bread && 'None' !== $bread ) {
                            $result['bread'][$bread][$meal_size] = ( isset($result['bread'][$bread][$meal_size]) ) ? $result['bread'][$bread][$meal_size] + $quantity : $quantity;

                            $result['bread'][$bread][$ordernotes] .= self::getDuplicateOrderNotes($order_item->get_order_id(),$orderNotesId);    
                        }
                      
                        

                           
                        
                       
                      
                    }

                }
            }

        }
        //dd($meal_name1);
        $order = array('meal','Gluten Free' , 'kids Meals' , 'starch', 'vegetable', 'dessert' , 'bread', 'salad' );

        $orderedArray = array();
        foreach ($order as $key) {
            $orderedArray[$key] = $result[$key];
        }

        return $orderedArray;

    }


      public static function getDuplicateOrderNotes($get_order_id,$orderNotesIdArr) {

        foreach ($orderNotesIdArr as $value) {
            if($get_order_id == $value){
                 $getPostDate = get_post( $get_order_id );
                if(!empty($getPostDate->post_excerpt)){
                    //$order_comment = '<a href="'.site_url().'/wp-admin/post.php?post='.$get_order_id.'&action=edit" target="_blank">#'.$get_order_id.'</a> '.$getPostDate->post_excerpt."<BR>";        
                    $order_comment = "";
                }
            }
        }

       
        return $order_comment;
     }


    public static function get_total_duplicate_product($currentVariation, $arrayData, $storeName) {

        

        foreach ( $arrayData as $key => $item ) {
            $order_item = new WC_Order_Item_Product( $item->order_item_id );
            $getPostDate1 = get_post( $order_item->get_order_id() );
            if($getPostDate1->post_status != 'wc-cancelled'){

                $get_order_id = $order_item->get_order_id();
                $getStoreName = get_post_meta($get_order_id,'orderFrom',true);
                if(!empty($storeName)){
                    if($getStoreName == 'GA'  && $storeName == 'GA' ){
                        $data = $order_item->get_data();
                        $variation_ids[] = array(
                            'v_id' => $data['variation_id'],        
                            'qty' => $data['quantity'],        
                        );       
                    }

                    if($getStoreName == 'FL' && $storeName == 'FL'){
                        $data = $order_item->get_data();
                        $variation_ids[] = array(
                            'v_id' => $data['variation_id'],        
                            'qty' => $data['quantity'],        
                        );        
                    }
                    
                }
                if(empty($storeName)){
                    $data = $order_item->get_data();
                    $variation_ids[] = array(
                        'v_id' => $data['variation_id'],        
                        'qty' => $data['quantity'],        
                    );
                }
            }
        }
        
        /*$count_values = array();
        foreach ($variation_ids as $a) {
            $count_values[$a] += 1;   
        }*/

        $count_values = array();
        foreach ($variation_ids as $a) {
             $count_values[$a['v_id']]+=$a['qty'];
        }

        $myQty = array();
        foreach ($count_values as $key1 => $value) {
            if($currentVariation == $key1){
                $myQty = $value;
            }
        }

       
        return $myQty;
    }



     //Get Compare order based on kitchen report and delivery reports
     public static function get_order_delivery_report_by_date($date = null, $storeName = null) {
        global $wpdb ; 
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'shop_order',
            'post_status' => 'wc-processing',
            'orderby' => 'title',


        );
        $delivery_dt=array();

        $arr_new=array();

        $post_status=array('trash','wc-pending','wc-cancelled');

        $start_date_from = $date ; 
      /*  $date = '2020-10-29';
        $storeName = 'FL';*/
         if($storeName == 'FL'){
             $commonWhereCondition = "( items2.order_item_name = 'Next Day Air (UPS FL)' OR items2.order_item_name = 'Next Day Air (UPS FL RC)' OR items2.order_item_name = 'Next Day Air (UPS)' )";
            $commonWhereConditionNot = "( items2.order_item_name <> 'Next Day Air (UPS FL)' AND items2.order_item_name <> 'Next Day Air (UPS FL RC)' AND items2.order_item_name <> 'Next Day Air (UPS GA RC)' AND items2.order_item_name <> 'Next Day Air (UPS GA)' AND items2.order_item_name <> 'Next Day Air (UPS)' )";
                     
        }else if($storeName == 'GA'){
            $commonWhereCondition = "( items2.order_item_name = 'Next Day Air (UPS GA)' OR items2.order_item_name = 'Next Day Air (UPS GA RC)' OR items2.order_item_name = 'Next Day Air (UPS)' )";
            $commonWhereConditionNot = "( items2.order_item_name <> 'Next Day Air (UPS GA)' AND items2.order_item_name <> 'Next Day Air (UPS GA RC)' AND items2.order_item_name <> 'Next Day Air (UPS)' )";
        }else{
            $commonWhereCondition = "( items2.order_item_name = 'Next Day Air (UPS FL)' OR items2.order_item_name = 'Next Day Air (UPS GA)' OR items2.order_item_name = 'Next Day Air (UPS FL RC)' OR items2.order_item_name = 'Next Day Air (UPS GA RC)' OR items2.order_item_name = 'Next Day Air (UPS)' )";

            $commonWhereConditionNot = "( items2.order_item_name <> 'Next Day Air (UPS FL)' AND items2.order_item_name <> 'Next Day Air (UPS GA)' AND items2.order_item_name <> 'Next Day Air (UPS FL RC)' AND items2.order_item_name <> 'Next Day Air (UPS GA RC)' AND items2.order_item_name <> 'Next Day Air (UPS)' )";
            
        }


        $delivery_dt_arr = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix."woocommerce_order_items as items 
            JOIN ".$wpdb->prefix."woocommerce_order_itemmeta as meta on items.order_item_id = meta.order_item_id
            JOIN ".$wpdb->prefix."woocommerce_order_items as items2 on items2.order_id = items.order_id

             WHERE (
                    (
                        ( meta.meta_key = '_iof_delivery_date' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date))."' )
                        OR
                        ( meta.meta_key = '%Delivery date%' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date))."' )
                    )
                    AND
                    ( items2.order_item_type LIKE 'shipping' AND  ".$commonWhereConditionNot."  )
                )
                OR 
            (
                    (
                        ( meta.meta_key = '_iof_delivery_date' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date . '+1 day'))."' )
                        OR
                        ( meta.meta_key = '%Delivery date%' AND meta.meta_value LIKE '".date("Y-m-d", strtotime($date . '+1 day'))."' )
                    )
                    AND
                    ( 
                        (items2.order_item_type LIKE 'shipping' AND  ".$commonWhereCondition.")  
                       

                    )
                )
          
            ");
                
        foreach($delivery_dt_arr as $element) {

              $getStoreName = get_post_meta($element->order_id,'orderFrom',true);
                if($storeName == $getStoreName){
                    array_push($element->counter);
                    $hash = $element->order_id;
                    $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                    $delivery_dt[$hash] = $element;   
                }

                if($storeName == $getStoreName){
                    array_push($element->counter);
                    $hash = $element->order_id;
                    $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                    $delivery_dt[$hash] = $element;   
                }

                if($storeName == ''){
                    array_push($element->counter);
                    $hash = $element->order_id;
                    $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                    $delivery_dt[$hash] = $element;
                }        

        }
            
        $delivery_dt = array_values($delivery_dt);
        if(!empty($delivery_dt)){
            foreach($delivery_dt as $dt){

                $get_product_detail = self::get_current_date_order_products($dt->order_id,$dt->meta_value);
                $product_detais = "";
                foreach ($get_product_detail as $item_meta) {
                          $product_detais .=  '<div class="itemDetails">';
                          $product_detais .= '<ul>';

                          $product_detais .= '<li>Product : '.$item_meta['product_name'].'</li>';
                          if($item_meta['side']){
                            $product_detais .='<li>side : '.$item_meta['side'].'</li>';   
                          }
                          if($item_meta['dessert']){  
                           $product_detais .='<li>dessert : '.$item_meta['dessert'].'</li>';
                          }  
                          if($item_meta['vegetable']){
                             $product_detais .='<li>vegetable : '.$item_meta['vegetable'].'</li>';
                          }
                          if($item_meta['salad']){
                            $product_detais .='<li>salad : '.$item_meta['salad'].'</li>';
                          }

                          if($item_meta['bread']){
                            $product_detais .='<li>bread : '.$item_meta['bread'].'</li>';   
                          }

                          if($item_meta['_iof_delivery_date']){
                            $product_detais .='<li>date : '.$item_meta['_iof_delivery_date'].'</li>';   
                          }
                          $product_detais .= '</ul></div>';
                    
                }

                $ship_method=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_item_type ='shipping' and order_id= ".$dt->order_id, ARRAY_A);

                       
                $cal=$wpdb->get_row("select ID, post_status from ".$wpdb->prefix."posts where ID=".$dt->order_id);

                if(!empty($dt->order_id) && !in_array($cal->post_status, $post_status, true)){

                        $order = new WC_Order($dt->order_id);

                                       
                        $shipaddress=$wpdb->get_results("select * from ".$wpdb->prefix."postmeta where ( meta_key='_shipping_first_name' OR   meta_key='_shipping_last_name' OR  meta_key='_shipping_address_1' OR meta_key='_shipping_address_2' OR meta_key='_shipping_city' OR  meta_key='_shipping_state' OR  meta_key='_shipping_postcode' ) AND post_id=".$dt->order_id);

                        $shippingaddre = '';
                        if(!empty($shipaddress)){
                            foreach($shipaddress as $shipadd){
                                $shippingaddre .=  $shipadd->meta_value.' '; 
                            }
                            
                        }
                        
                         $order_id = trim(str_replace('#', '', $order->get_order_number()));

                       
                        $meal_size=wc_get_order_item_meta( $dt->order_item_id, 'meal-size', true );

                        $order_link= '<a href="'.home_url().'/wp-admin/post.php?post='.$dt->order_id.'&action=edit">'."#".$order_id.'</a>';




                        if(!in_array($ship_method['order_item_name'], $arr_new, true) ){
                            echo  $mydata;
                           array_push($arr_new,$ship_method['order_item_name']);
                           $arr[$ship_method['order_item_name']]=array('oid'=>array($order_link), 'ship'=>$ship_method['order_item_name'], "item_name" => array($dt->order_item_name), 'product_detail'=>array($product_detais),'meal_size' => array($meal_size));
                        
                        }else{
                 
                                    $ts=$arr[$ship_method['order_item_name']]['oid'];

                                    array_push($ts,$order_link);

                                    $arr[$ship_method['order_item_name']]['oid']=$ts;

                                    

                                    $itname=$arr[$ship_method['order_item_name']]['item_name'];

                                    array_push($itname,$dt->order_item_name);

                                    $arr[$ship_method['order_item_name']]['item_name']=$itname;

                                    

                                    $msize=$arr[$ship_method['order_item_name']]['meal_size'];

                                    array_push($msize,$meal_size);

                                    $arr[$ship_method['order_item_name']]['meal_size']=$msize;

                                    


                                    $shipadd=$arr[$ship_method['order_item_name']]['product_detail'];

                                    array_push($shipadd,$product_detais);

                                    $arr[$ship_method['order_item_name']]['product_detail']=$shipadd;

                                    

                            }

                }
            }

        }

         $arr= self::ordermsort($arr, array('ship'));
    
      /*  echo "<pre>";
        print_r($arr);
        echo "</pre>";
        die; */
        return  $arr ;


    }

      function ordermsort($array, $key, $sort_flags = SORT_REGULAR) {

        if (is_array($array) && count($array) > 0) {

            if (!empty($key)) {

                $mapping = array();

                foreach ($array as $k => $v) {

                    $sort_key = '';

                    if (!is_array($key)) {

                        $sort_key = $v[$key];

                    } else {

                        // @TODO This should be fixed, now it will be sorted as string

                        foreach ($key as $key_key) {

                            $sort_key .= $v[$key_key];

                        }

                        $sort_flags = SORT_STRING;

                    }

                    $mapping[$k] = $sort_key;

                }

                asort($mapping, $sort_flags);

                $sorted = array();

                foreach ($mapping as $k => $v) {

                    $sorted[] = $array[$k];

                }

                return $sorted;

            }

        }

        return $array;

    }

    public function get_current_date_order_products($order_id,$date_issue){
        $order = wc_get_order( $order_id );
        $items = $order->get_items();
        $product_det = array();
        $side="";
        $dessert="";
        $vegetable="";
        $salad="";
        $bread="";
        $_iof_delivery_date="";
        foreach ( $items as $item ) {
            $product_name = $item->get_name();
            $side = $item->get_meta( 'side', true );    
            $dessert = $item->get_meta( 'dessert', true );    

            $vegetable = $item->get_meta( 'vegetable', true );

            $salad = $item->get_meta( 'salad', true );
            $bread = $item->get_meta( 'bread', true );
            $_iof_delivery_date = $item->get_meta( '_iof_delivery_date', true );    
            
            if($item->get_meta( '_iof_delivery_date', true ) == $date_issue){
                $product_det[] = array(
                    'product_name' => $product_name,
                    'side'=>($side)?$side:"",
                    'dessert'=>$dessert,
                    'vegetable'=>$vegetable,
                    'salad'=>$salad,
                    'bread'=>$bread,
                    'dessert'=>$dessert,
                    '_iof_delivery_date'=>$_iof_delivery_date,
                );
            }else{}
            
        }


        return $product_det;


    }
    
}
