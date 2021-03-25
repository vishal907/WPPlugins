<?php


class Iof_Utilities_rdKRReport {

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

    public function add_re_develop_kitchen_report_menu() {
        add_menu_page('Re Devlop KR', 'Re Devlop KR', 'read', 're-kr-reports', array($this, 'display_kr_delivery_reports'), 'dashicons-clipboard', 8);
    }

    public function display_kr_delivery_reports() {
        $shipping_methods = self::get_order_delivery_by_date(date('Y-m-d'), $storeName = null);
        ob_start();
        include __DIR__ . '/../admin/partials/redevlope_kr/index.php';
        $result = ob_get_clean();
        echo $result;
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

