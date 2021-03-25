<?php



class Iof_Utilities_NoteCards {

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

    public function add_note_cards_menu() {
       add_menu_page('Note Cards', 'Note Cards', 'read', 'note-cards', array($this, 'display_note_cards'), 'dashicons-clipboard', 9);
    }

    public function display_note_cards() {
    	$shipping_methods = self::get_order_delivery_by_date(date('Y-m-d'), $storeName= null);
    	ob_start();
        include __DIR__ . '/../admin/partials/note_cards/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    public static function get_order_delivery_by_date($date = null, $storeName= null) {
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
        /* echo "SELECT * FROM ".$wpdb->prefix."woocommerce_order_itemmeta LEFT JOIN ".$wpdb->prefix."woocommerce_order_items on ".$wpdb->prefix."woocommerce_order_itemmeta.order_item_id= ".$wpdb->prefix."woocommerce_order_items.order_item_id WHERE (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '_iof_delivery_date' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("Y-m-d", strtotime($date))."') OR (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '%Delivery date%' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("F d, Y", strtotime($date))."')" ; 
        die; */


        $delivery_dt_arr = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."woocommerce_order_itemmeta LEFT JOIN ".$wpdb->prefix."woocommerce_order_items on ".$wpdb->prefix."woocommerce_order_itemmeta.order_item_id= ".$wpdb->prefix."woocommerce_order_items.order_item_id WHERE (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '_iof_delivery_date' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("Y-m-d", strtotime($date))."') OR (".$wpdb->prefix."woocommerce_order_itemmeta.meta_key LIKE '%Delivery date%' AND ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '".date("F d, Y", strtotime($date))."') ORDER BY wp_woocommerce_order_items.order_id DESC ");
                
        foreach($delivery_dt_arr as $element) {
            $getStoreName = get_post_meta($element->order_id,'orderFrom',true);
            if($storeName == $getStoreName){
                array_push($element->counter);
                $hash = $element->order_id;
                $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                $delivery_dt[$hash] = $element;
                $order_ids_arr[] = $hash;   
            }

            if($storeName == $getStoreName){
                array_push($element->counter);
                $hash = $element->order_id;
                $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                $delivery_dt[$hash] = $element;
                $order_ids_arr[] = $hash;   
            }

            if($storeName == ''){
                array_push($element->counter);
                $hash = $element->order_id;
                $element->counter = array_count_values(array_column($delivery_dt_arr, 'order_id'))[$hash]; // outputs: 2
                $delivery_dt[$hash] = $element;
                $order_ids_arr[] = $hash;
            }            
            
        }

        

        $order_ids_arr = array_unique($order_ids_arr);
        $order_ids = implode('x', $order_ids_arr);
            
        $delivery_dt = array_values($delivery_dt);
        if(!empty($delivery_dt)){
            foreach($delivery_dt as $dt){
              

                $ship_method=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_item_type ='shipping' and order_id= ".$dt->order_id, ARRAY_A);

                     

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


                        $content_notes = get_post_meta($dt->order_id,'_shipping_note_card_message',true);
                        $merge_notes = preg_replace( "/\\\+'/", "'", $content_notes );

                                            

                        $meal_size=wc_get_order_item_meta( $dt->order_item_id, 'meal-size', true );

                        $order_link= '<a href="'.home_url().'/wp-admin/post.php?post='.$dt->order_id.'&action=edit">'."#".$order_id.'</a>';


                        $my_counter = $dt->counter;


                        if(!in_array($ship_method['order_item_name'], $arr_new, true) ){
                           
                           if(!empty($merge_notes)) {
                                echo  $mydata;
                                array_push($arr_new,$ship_method['order_item_name']);
                               $arr[$ship_method['order_item_name']]=array('oid'=>array($order_link), 'ship'=>$ship_method['order_item_name'], 'order_comment'=> array($merge_notes),'order_ids' => $order_ids );
                           }

                        
                        }else{
                            if(!empty($merge_notes)) {
                 
                                    $ts=$arr[$ship_method['order_item_name']]['oid'];

                                    array_push($ts,$order_link);

                                    $arr[$ship_method['order_item_name']]['oid']=$ts;
                                    

                                    $ord_comment=$arr[$ship_method['order_item_name']]['order_comment'];

                                    array_push($ord_comment,$merge_notes);

                                    $arr[$ship_method['order_item_name']]['order_comment']=$ord_comment;

                                     $ts=$arr[$ship_method['order_item_name']]['order_ids'];

                                    array_push($ts,$order_ids);

                                    $arr[$ship_method['order_item_name']]['order_ids']=$ts;
                                    
                                }


                             

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

     public function pull_note_cards() {
        
        if(isset($_POST['date'])) {
            $date = sanitize_text_field($_POST['date']);
            $storeName = sanitize_text_field($_POST['storeName']);
            if(!empty($date)) {
                $arr = self::get_order_delivery_by_date($date,$storeName);
                ob_start();
                include __DIR__ . '/../admin/partials/note_cards/refresh.php';
                $result = ob_get_clean();
                return wp_send_json(array('display' => $result), 200);
            }
        }

        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

 


}
