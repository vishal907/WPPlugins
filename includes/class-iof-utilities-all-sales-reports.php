<?php


class Iof_Utilities_allSalesReport {

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


    public function add_all_sales_report_menu() {
       add_menu_page('ALL Sales Report', 'All Sales Report', 'read', 'all-sales-report', array($this, 'display_all_sales_report'), 'dashicons-clipboard', 9);
    }

     public function display_all_sales_report() {
        $refunds = self::get_all_sales_report(date('Y-m-d'), date('Y-m-d'), $storeName= null, $storeCoupon=null);
        ob_start();
        include __DIR__ . '/../admin/partials/all_sales_report/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    
   
     public function pull_all_sales_report() {
        
         if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
            $from_date = sanitize_text_field(date("Y-m-d", strtotime($_POST['from_date'])));
            $to_date = sanitize_text_field(date("Y-m-d", strtotime($_POST['to_date'])));
            $storeName = sanitize_text_field($_POST['storeName']);
            $storeCoupon = sanitize_text_field($_POST['storeCoupon']);
            if(!empty($from_date) && !empty($to_date)) {
                if(strtotime($from_date) <= strtotime($to_date)) {
                    $refunds = self::get_all_sales_report($from_date, $to_date, $storeName,$storeCoupon);
                    ob_start();
                    include __DIR__ . '/../admin/partials/all_sales_report/refresh.php';
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
        $to = date('Y-m-d', strtotime("+1 day", strtotime($to)) ); 
        $time = "AND (p.post_date >= '".$from."' AND p.post_date <= '".$to."')";
        

        $sales_report_arr = $wpdb->get_results(" SELECT p.ID FROM " . $wpdb->prefix."posts as p 
            INNER JOIN ".$wpdb->prefix."postmeta as pm on (p.ID = pm.post_id) 
            WHERE p.post_type = 'shop_order' 
            ".$time."
            GROUP BY p.ID 
            ORDER BY p.post_date DESC 
        ");

        $i = 0;

       
        $sum_purchase_value = [];
        $sum_refund_value = [];

         foreach($sales_report_arr as  $order) {

            $order = new WC_Order($order->ID);

            $orderFrom = get_post_meta($order->ID,'orderFrom',true); 
            if($orderFrom == $storeName){
                $order = new WC_Order($order->ID);
                $refundAmount = $order->get_total_refunded();
                $time_created = $order->order_date;
               
                $purchase_value = $order->get_total();   
               

                $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                $sum_refund_value[] = ($refundAmount)?$refundAmount:0;
            }


            if($storeName == ""){
                $order = new WC_Order($order->ID);
                
                $time_created = $order->order_date;

                $refundAmount = $order->get_total_refunded();

                $purchase_value = $order->get_total();
         
            
                $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                $sum_refund_value[] = ($refundAmount)?$refundAmount:0;
            }
        }

        foreach($sales_report_arr as  $order) {

            $order = new WC_Order($order->ID);

            $orderFrom = get_post_meta($order->ID,'orderFrom',true); 

            if($orderFrom == $storeName){
                $order = new WC_Order($order->ID);
                $refundAmount = $order->get_total_refunded();

                $time_created = $order->order_date;
                  
                $purchase_value = $order->get_total();
                
                $results[$i]['order_id'] = $order->ID;
                $results[$i]['order_date'] = !empty($time_created) ? date('M d, Y', strtotime($time_created)) : 'N/A';
                $results[$i]['purchase_value'] = $purchase_value;
                $results[$i]['refund_value'] = $refundAmount;
                $results[$i]['sum_purchase_value'] = array_sum($sum_purchase_value);
                $results[$i]['sum_refund_value'] = array_sum($sum_refund_value);
                $i++;
            }


            if($storeName == ""){
                $order_new = new WC_Order($order->ID);
                
                $time_created = $order_new->order_date;

                $refundAmount = $order_new->get_total_refunded();
                
                $purchase_value = $order_new->get_total();
            
                
                
                $results[$i]['order_id'] = $order_new->ID;
                $results[$i]['order_date'] = !empty($time_created) ? date('M d, Y', strtotime($time_created)) : 'N/A';
                $results[$i]['purchase_value'] = $purchase_value;
                $results[$i]['refund_value'] = $refundAmount;
                $results[$i]['sum_purchase_value'] = array_sum($sum_purchase_value);
                $results[$i]['sum_refund_value'] = array_sum($sum_refund_value);
                $i++;
            }
        }
        return $results;
    }

  

}