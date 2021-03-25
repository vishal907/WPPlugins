<?php

class Iof_Utilities_allQuickBookReport {

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


    public function add_all_quickbooks_report_menu() {
       add_menu_page('Corporate Sales Report', 'Corporate Sales Report', 'read', 'all-corporate-report', array($this, 'display_all_quickbook_report'), 'dashicons-clipboard', 9);
    }

     public function display_all_quickbook_report() {
        $refunds = self::get_all_quickbooks_report(date('Y-m-d'), date('Y-m-d'), $storeName= null, $onlyForCorporate=1);
        ob_start();
        include __DIR__ . '/../admin/partials/quickbook_report/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    
   
     public function pull_all_quickbooks_report() {
        
         if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
            $from_date = sanitize_text_field(date("Y-m-d", strtotime($_POST['from_date'])));
            $to_date = sanitize_text_field(date("Y-m-d", strtotime($_POST['to_date'])));
            $storeName = sanitize_text_field($_POST['storeName']);
            $onlyForCorporate = sanitize_text_field($_POST['onlyForCorporate']);

            if(!empty($from_date) && !empty($to_date)) {
                if(strtotime($from_date) <= strtotime($to_date)) {
                    $refunds = self::get_all_quickbooks_report($from_date, $to_date, $storeName,$onlyForCorporate);
                    $emailFilterList = array();

                   /* $emailHtml = "<select name='emailFilter[]'' id='multiple' class='emilFilterSelectBox' multiple>";

                    foreach ($refunds as $value) {
                        if($value['billing_email']){
                            $emailHtml .= '<option value="'.$value['billing_email'].'">'.$value['billing_email'].'</option>';    
                        }
                    }
                    
                    $emailHtml .= "</select>";*/
                        $emailHtml = "";
                    ob_start();
                    include __DIR__ . '/../admin/partials/quickbook_report/refresh.php';
                    $result = ob_get_clean();

                    return wp_send_json(array('display' => $result, 'emailFilterCommaseprated'=>$emailHtml), 200);
                }
            }
        }

        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }


     public static function get_all_quickbooks_report($from, $to, $storeName=null, $onlyForCorporate) {
        $results = array();
        global $wpdb ;
        /*$from = '2020-07-01';
        $to = '2020-07-31';*/

        $sales_report_arr = $wpdb->get_results(" SELECT GROUP_CONCAT(wp_postmeta.post_id) as order_id, wp_postmeta.meta_value as billing_email FROM " . $wpdb->prefix."postmeta LEFT JOIN " . $wpdb->prefix."posts on wp_posts.ID = wp_postmeta.post_id  WHERE wp_postmeta.meta_key = '_billing_email' 
            AND wp_posts.post_type='shop_order' 
            AND (wp_posts.post_date >= '".$from."' AND wp_posts.post_date <= '".$to."')
            GROUP BY wp_postmeta.meta_value 
        ");
        //SELECT GROUP_CONCAT(wp_postmeta.post_id) as order_id, wp_postmeta.meta_value FROM wp_postmeta LEFT JOIN wp_posts on wp_posts.ID = wp_postmeta.post_id WHERE wp_postmeta.meta_key = '_billing_email' AND wp_posts.post_type='shop_order' AND wp_posts.post_date BETWEEN '2021-02-16' AND '2021-02-26' GROUP BY wp_postmeta.meta_value DESC
        $res = array();
      
        $sum_purchase_value = [];
        $sum_refund_value = [];

        foreach($sales_report_arr as $key => $order) {
            $orderList = explode(',', $order->order_id);
            $orderFrom = get_post_meta($orderList[0],'orderFrom',true); 
           
            if($orderFrom == $storeName){
                if($onlyForCorporate == "1"){
                    $company_order = new WC_Order($orderList[0]);
                    $cmp_name    = $company_order->get_billing_company();
                    $checkDomainEmail = self::checkDomainEmail($order->billing_email,$cmp_name); 

                    if($checkDomainEmail == 'false'){
                        $purchase_value_arr = array();
                        foreach ($orderList as $individual_order) {
                            $getOrder = wc_get_order($individual_order);
                            if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                                $purchase_value_arr[] = $getOrder->get_total();   
                            }else{}  
                        }
                        $purchase_value = array_sum($purchase_value_arr);
                        if($purchase_value != 0 && !empty($purchase_value)){
                            $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                            $sum_refund_value[] = count($orderList);
                        }
                    }
                }else{
                    $purchase_value_arr = array();
                    foreach ($orderList as $individual_order) {
                        $getOrder = new WC_Order($individual_order);
                        $purchase_value_arr[] = $getOrder->get_total();   
                    }
                    $purchase_value = array_sum($purchase_value_arr);
                    if($purchase_value != 0 && !empty($purchase_value)){
                        $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                        $sum_refund_value[] = count($orderList);
                    }
                }
                
            }


            if($storeName == ""){
               if($onlyForCorporate == "1"){ 
                    $company_order = new WC_Order($orderList[0]);
                    $cmp_name    = $company_order->get_billing_company();
                    $checkDomainEmail = self::checkDomainEmail($order->billing_email,$cmp_name); 
                   if($checkDomainEmail == 'false'){
                       $purchase_value_arr = array();
                        foreach ($orderList as $individual_order) {
                            $getOrder = wc_get_order($individual_order);
                            if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                                $purchase_value_arr[] = $getOrder->get_total();   
                            }else{}  
                        }
                        $purchase_value = array_sum($purchase_value_arr);
                        if($purchase_value != 0 && !empty($purchase_value)){
                            $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                            $sum_refund_value[] = count($orderList);
                        }
                    }
                }else{
                    $purchase_value_arr = array();
                    foreach ($orderList as $individual_order) {
                        $getOrder = wc_get_order($individual_order);
                        if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                            $purchase_value_arr[] = $getOrder->get_total();   
                        }else{}  
                    }
                    $purchase_value = array_sum($purchase_value_arr);
                    if($purchase_value != 0 && !empty($purchase_value)){
                        $sum_purchase_value[] = ($purchase_value)?$purchase_value:0;
                        $sum_refund_value[] = count($orderList);
                    }
                }
            }
        }


        foreach($sales_report_arr as $key => $order) {

            $orderList = explode(',', $order->order_id);
            $orderFrom = get_post_meta($orderList[0],'orderFrom',true); 

            if($orderFrom == $storeName){
                if($onlyForCorporate == "1"){ 
                    $company_order = new WC_Order($orderList[0]);
                    $cmp_name    = $company_order->get_billing_company();
                    $checkDomainEmail = self::checkDomainEmail($order->billing_email,$cmp_name); 
                    if($checkDomainEmail == 'false'){
                        $purchase_value_arr = array();
                        foreach ($orderList as $individual_order) {
                            $getOrder = wc_get_order($individual_order);
                            if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                                $purchase_value_arr[] = $getOrder->get_total();   
                            }else{}  
                        }
                        $purchase_value = array_sum($purchase_value_arr);
                        if($purchase_value != 0 && !empty($purchase_value)){

                            $order_new = new WC_Order($orderList[0]);
                            $billing_first_name = $order_new->get_billing_first_name();
                            $billing_last_name  = $order_new->get_billing_last_name();
                            $billing_company    = $order_new->get_billing_company();
                            
                            $results[$order->billing_email]['billing_first_name'] = $billing_first_name;
                            $results[$order->billing_email]['billing_last_name'] = $billing_last_name;
                            $results[$order->billing_email]['billing_company'] = $billing_company;
                            $results[$order->billing_email]['purchase_value'] = $purchase_value;
                            $results[$order->billing_email]['billing_email'] = $order->billing_email;
                            $results[$order->billing_email]['order_count'] = count($orderList);
                            $results[$order->billing_email]['sum_purchase_value'] = array_sum($sum_purchase_value);
                            $results[$order->billing_email]['sum_refund_value'] = array_sum($sum_refund_value);
                        }
                    }
                }else{

                    $purchase_value_arr = array();
                    foreach ($orderList as $individual_order) {
                        $getOrder = wc_get_order($individual_order);
                        if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                            $purchase_value_arr[] = $getOrder->get_total();   
                        }else{}  
                    }
                    $purchase_value = array_sum($purchase_value_arr);
                    if($purchase_value != 0 && !empty($purchase_value)){

                        $order_new = new WC_Order($orderList[0]);
                        $billing_first_name = $order_new->get_billing_first_name();
                        $billing_last_name  = $order_new->get_billing_last_name();
                        $billing_company    = $order_new->get_billing_company();
                        
                        $results[$order->billing_email]['billing_first_name'] = $billing_first_name;
                        $results[$order->billing_email]['billing_last_name'] = $billing_last_name;
                        $results[$order->billing_email]['billing_company'] = $billing_company;
                        $results[$order->billing_email]['purchase_value'] = $purchase_value;
                        $results[$order->billing_email]['billing_email'] = $order->billing_email;
                        $results[$order->billing_email]['order_count'] = count($orderList);
                        $results[$order->billing_email]['sum_purchase_value'] = array_sum($sum_purchase_value);
                        $results[$order->billing_email]['sum_refund_value'] = array_sum($sum_refund_value);
                    }
                }
            }
            if($storeName == ""){
                if($onlyForCorporate == "1"){ 
                    $company_order = new WC_Order($orderList[0]);
                    $cmp_name    = $company_order->get_billing_company();
                    $checkDomainEmail = self::checkDomainEmail($order->billing_email,$cmp_name); 

                    if($checkDomainEmail == 'false'){
                        $purchase_value_arr = array();
                        foreach ($orderList as $individual_order) {
                            $getOrder = wc_get_order($individual_order);
                            if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                                $purchase_value_arr[] = $getOrder->get_total();   
                            }else{}  
                        }
                        $purchase_value = array_sum($purchase_value_arr);
                        if($purchase_value != 0 && !empty($purchase_value)){
                            $order_new = new WC_Order($orderList[0]);
                            $billing_first_name = $order_new->get_billing_first_name();
                            $billing_last_name  = $order_new->get_billing_last_name();
                            $billing_company    = $order_new->get_billing_company();
                            
                            $results[$order->billing_email]['billing_first_name'] = $billing_first_name;
                            $results[$order->billing_email]['billing_last_name'] = $billing_last_name;
                            $results[$order->billing_email]['billing_company'] = $billing_company;
                            $results[$order->billing_email]['billing_email'] = $order->billing_email;
                            $results[$order->billing_email]['order_count'] = count($orderList);
                            $results[$order->billing_email]['purchase_value'] = $purchase_value;
                            $results[$order->billing_email]['sum_purchase_value'] = array_sum($sum_purchase_value);
                            $results[$order->billing_email]['sum_refund_value'] = array_sum($sum_refund_value);
                        }
                    }
                }else{
                    $purchase_value_arr = array();
                    foreach ($orderList as $individual_order) {
                        $getOrder = wc_get_order($individual_order);
                        if(!empty($getOrder) && $individual_order == $getOrder->get_id()){
                            $purchase_value_arr[] = $getOrder->get_total();   
                        }else{}  
                    }
                    $purchase_value = array_sum($purchase_value_arr);
                    if($purchase_value != 0 && !empty($purchase_value)){
                        $order_new = new WC_Order($orderList[0]);
                        $billing_first_name = $order_new->get_billing_first_name();
                        $billing_last_name  = $order_new->get_billing_last_name();
                        $billing_company    = $order_new->get_billing_company();
                        
                        $results[$order->billing_email]['billing_first_name'] = $billing_first_name;
                        $results[$order->billing_email]['billing_last_name'] = $billing_last_name;
                        $results[$order->billing_email]['billing_company'] = $billing_company;
                        $results[$order->billing_email]['billing_email'] = $order->billing_email;
                        $results[$order->billing_email]['order_count'] = count($orderList);
                        $results[$order->billing_email]['purchase_value'] = $purchase_value;
                        $results[$order->billing_email]['sum_purchase_value'] = array_sum($sum_purchase_value);
                        $results[$order->billing_email]['sum_refund_value'] = array_sum($sum_refund_value);
                    }
                }
            }

        }

        //$results = array();
        return $results;
    }

     public static function checkDomainEmail($email, $company_name) {

        $domain_array = array('gmail.com','yahoo.com','hotmail.com','msn.com','att.net','aol.com','juno.com','comcast.net','bellsouth.net','me.com','icloud.com','carriageprop.com','verizon.net');

        $curEmail = explode('@', $email);
        if(in_array(strtolower($curEmail[1]), $domain_array)){
            if(!empty($company_name) && $company_name != ""){
                return 'false'; 
            }else{
                return 'true'; 
            }
            
        }else{
            return 'false'; 
        }
        

     }


}