<?php


require_once plugin_dir_path( dirname( __FILE__ ) ) . '/includes/class-iof-utilities-blockout-dates.php';

class Iof_Utilities_Recipient_Choices {

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

    /**
     * Create the recipient choice coupon if the cart contains some.
     *
     * @param int   $order_id
     * @param object    $posted
     */
    public function create_recipient_choice_coupon($order_id) {
        if($this->has_recipient_choice($order_id)) {
            $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
            $coupon_code = $this->create_coupon_code();
            update_post_meta($order_id, '_iof_rc_expire', $oneYearOn);
            update_post_meta($order_id, '_iof_recipient_choice', strtoupper($coupon_code));
            update_post_meta($order_id, '_iof_recipient_choice_fulfilled', 'no');
        }
    }

    /**
     * Adds recipient phone and email field to checkout page.
     *
     * @param $fields
     *
     * @return mixed
     */
    public function add_recipient_phone_email($fields) {

        $required = true;
        $cart     = WC()->cart->get_cart();

        foreach ( $cart as $cart_item ) {
            if ( has_term( 'recipients-choice', 'product_cat', $cart_item['product_id'] ) ) {
                $required = true;
            }
        }

        $fields['shipping']['shipping_phone'] = array(
            'label'     => __('Phone', 'woocommerce'),
            'placeholder'   => _x('Recipient Phone Number', 'placeholder', 'woocommerce'),
            'required'  => $required,
            'class'     => array('form-row-wide'),
            'clear'     => true
        );

        $fields['shipping']['shipping_email'] = array(
            'label'     => __('Email', 'woocommerce'),
            'type'      => 'email',
            'placeholder'   => _x('Recipient Email', 'placeholder', 'woocommerce'),
            'required'  => '',
            'class'     => array('form-row-wide'),
            'clear'     => true
        );

        return $fields;
    }

    /**
     * Display the note card message on the public checkout page.
     *
     * @param $fields array       The fields on the checkout page.
     *
     * @return array
     */
    public function add_recipient_note_card_message( $fields ) {
        $fields['shipping']['shipping_note_card_message'] = array(
            'label'       => __( 'Note Card Message', 'woocommerce' ),
            'placeholder' => _x( 'Let us know what you would like your note card to say.', 'placeholder', 'woocommerce' ),
            'type' => 'textarea',
            'required'    => false,
            'class'       => array( 'form-row-wide' ),
            'clear'       => true,
            'maxlength'       => 255,
        );

        return $fields;
    }

    /**
     * Display recipient phone and email to admin order page.
     *
     * @param $fields
     *
     * @return array
     */
    public function display_recipient_phone_email($fields) {

       $fields['phone'] = array(
           'label' => __( 'Recipient Phone', 'woocommerce' ),
           'show'  => true,
       );

        $fields['email'] = array(
            'label' => __( 'Recipient Email', 'woocommerce' ),
            'show'  => true,
        );

        return $fields;
    }

    /**
     * Display note card message on admin order page.
     *
     * @param $fields
     *
     * @return mixed
     */
    public function display_recipient_note_card_message( $fields ) {
        $fields['note_card_message'] = array(
            'label' => __( 'Note Card Message', 'woocommerce' ),
            'show'  => true,
        );

        return $fields;
    }


    /**
     * Add recipient choice email notification to woocommerce settings.
     * @param $email_classes
     *
     * @return mixed
     */
    public function add_recipient_choice_email_class($email_classes) {
        // include our custom email class
        require ( 'class-wc-recipient-choice-email.php' );
        // add the email class to the list of email classes that WooCommerce loads
        $email_classes['WC_Recipient_Choice_Email'] = new WC_Recipient_Choice_Email();
        return $email_classes;
    }

    /**
     * Display recipient choice redeem form
     *
     * @return string
     */
    public function display_recipient_redeem_form() {
        session_start();
        if($_GET['rc']){
            $rc = $_GET['rc'];
        }else{
           $rc = $_SESSION['pop_recipient_code'];
        }
        $html = '
            <div class="row" id="recipient_code_container">
                <div class="col-md-6 offset-md-3">
                    <form id="recipient_code_form" class="text-center">
                        <div class="form-group">
                            <label for="recipient_code">Recipient Choice Code</label>
                            <input type="text" class="form-control" id="recipient_code" autocomplete="off" placeholder="Enter or Paste your Recipient Code here." value="'.$rc.'">
                        </div>
                        <p id="recipient_message" style="display: none;"><small></small></p>
                        <button type="submit" class="btn btn-lg btn-pop rcBtnClick">Redeem!</button>
                    </form>
                </div>
            </div>
        ';

        if($_GET['rc'] || $_SESSION['pop_recipient_code']){
            ?>
             <script type="text/javascript">
                jQuery(function ($) {
                    jQuery('.rcBtnClick').trigger('click');
                    jQuery("#recipient_code").prop('disabled', true);
                });
            </script>
            <?php 

        }else{
             ?>
             <script type="text/javascript">
                jQuery(function ($) {
                    jQuery('.rcBtnClick').on('click', function(){
                        jQuery("#recipient_code").prop('disabled', true);
                    });
                });
            </script>
            <?php 

        }

        return $html;
    }

    /**
     * Verify the recipient code.
     *
     * @return mixed
     */
    public function verify_recipient_code() {
        if(isset($_POST['recipient_code']) && !empty($_POST['recipient_code'])) {
            $recipient_code = sanitize_text_field($_POST['recipient_code']);

            $result = substr($recipient_code, 0, 2);

            $orders = $this->get_associated_orders($recipient_code);

            if(count($orders)) {
                $order_id = $orders[0]['id'];
                $rc_expire_date = "";
                if($this->has_recipient_choice($order_id)) {
                    $object = wc_get_order($order_id);
                    $today_date = strtotime(date("Y-m-d"));
                    if($object->iof_rc_expire){
                        $rc_expire_date = strtotime($object->iof_rc_expire);
                    }
                    
                    if(isset($object->iof_recipient_choice_fulfilled) && $object->iof_recipient_choice_fulfilled == 'no') {
                        $first_name = get_post_meta($order_id, '_shipping_first_name', true);
                       // $first_name = get_user_meta( $user_id, 'first_name', true );

                        $iof_rc_expire_text = "";
                        if(get_post_meta($order_id,'_iof_rc_expire',true)){
                            $_iof_rc_expire = get_post_meta($order_id,'_iof_rc_expire',true);
                            $iof_rc_expire_text = '<small style="font-size: 12px; font-style: italic;">Your Recipient Choice code expires on '.date("F j, Y",strtotime($_iof_rc_expire)).'</small>'.$iof_rc_expire_text;
                        }


                        $msg = 'Congrats '.$first_name.'! You have entered a valid Recipient Choice code. '.$iof_rc_expire_text;

                        if($rc_expire_date != ""){
                            if(isset($object->iof_rc_expire) && strtotime($object->iof_rc_expire) >= $today_date) {
                                    return wp_send_json(array(
                                        'status' => $msg,
                                        'data' => $this->prepare_tabs_for_selection($this->get_order_details($order_id))
                                    ), 200);
                                }else{
                                    return wp_send_json(array('error' => 'Sorry, this Recipient\'s Choice Code has expired!.'), 422);
                                }
                        }else{
                             return wp_send_json(array(
                                'status' => $msg,
                                'data' => $this->prepare_tabs_for_selection($this->get_order_details($order_id))
                            ), 200);
                        }
                       
                    } else {
                        return wp_send_json(array('error' => 'Sorry, this Recipient\'s Choice Code has already been redeemed for all meals.'), 422);
                    }
                }
            }
            
            if($result == 'RC'){
                return wp_send_json(array('error' => 'RC code entered that is not an existing or valid code anywhere in our system!'), 422);
            }else{
                $chech_GC_Code  = $this->checkValidateGCCode(sanitize_text_field($recipient_code));
                if($chech_GC_Code == '1' || $chech_GC_Code == 1){
                    $msg = "You have entered what appears to be a Gift Certificate Code.  If your code begins with the letters \"RC\" please try entering it again here.  If not, please try using your code in the <a href='/cart/'>Gift Certificate Section of your cart<a> when you are ready to checkout."; 
                    return wp_send_json(array('error' => $msg), 422);
                }else{
                    return wp_send_json(array('error' => 'RC code entered that is not an existing or valid code anywhere in our system!'), 422);    
                }
            }
        }
        return wp_send_json(array('error' => 'Recipient Choice Code is required.'), 422);
    }
    /**
     * add to my rc wallet
     *
     * @return mixed
     */
    public function add_to_rc_wallet(){

         if(isset($_POST['recipient_code']) && !empty($_POST['recipient_code'])) {
            $recipient_code = sanitize_text_field($_POST['recipient_code']);

            $result = substr($recipient_code, 0, 2);

            $orders = $this->get_associated_orders($recipient_code);

            if(count($orders)) {
                $order_id = $orders[0]['id'];
                if($this->has_recipient_choice($order_id)) {
                    $object = wc_get_order($order_id);
                    if(isset($object->iof_recipient_choice_fulfilled) && $object->iof_recipient_choice_fulfilled == 'no') {
                        return wp_send_json(array(
                            'status' => 'Recipient Choice added to your account.',
                            'data' => $this->get_wallet_details($order_id,$recipient_code)
                        ), 200);
                    } else {
                        return wp_send_json(array('error' => 'This Recipient\'s Choice Code has already been redeemed.'), 422);
                    }
                }
            }else{
              return wp_send_json(array('error' => 'Invalid code entered. Please try again'), 422);
            }
        }
       
       
    }

    private function get_wallet_details($order_id,$recipient_code){
        global $wpdb;
        $userid = get_current_user_id();
        $wp_rc_wallets = $wpdb->prefix."rc_wallets";


        $order = wc_get_order( $order_id );
        $items = $order->get_items();
        $count = 0;
        foreach($items as $key => $item) {
            if(!empty($item['product_id'])){
                $product_id = $item['product_id'];
            }else{
                global $wpdb;
                $postid = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_title = "'.$item['name'].'" AND post_type = "product_variation" ' );
                $product_id = $postid[0]->ID;
            }
            if(has_term('recipients-choice', 'product_cat', $product_id)) {
                $count += $item['qty'] * wc_get_order_item_meta($key, 'iof_number_of_deliveries', true); //2 stands 
       
            }
        }


        $mylink = $wpdb->get_results( "SELECT * FROM $wp_rc_wallets WHERE rc_shortcode = '".$recipient_code."' and user_id = ".$userid." ");
        if($mylink == null){
            $wpdb->query("INSERT INTO $wp_rc_wallets (user_id, rc_shortcode, order_id, rc_purchase_id, total_orders) VALUES ('$userid', '$recipient_code', '$order_id', '', '$count' )");

            return '<div class="row alert alert-success myWalletMsg" style="margin-top:21px" role="alert"><div class="col text-left">Recipient Choice added to your account. </div></div>';
            
        }else{
            return '<div class="row alert alert-danger myWalletMsg" style="margin-top:21px" role="alert"><div class="col text-left">Recipient Choice code already added to your account.  Please check <a href="'.site_url().'/myaccount/recipient-choice/" >Your Account</a>.</div></div>';
        }
        
    }


    /**
     * Process recipient choice from customer.
     *
     * @return mixed
     */
     public function complete_recipient_choice() {
        if(isset($_POST['recipient_code']) && !empty($_POST['recipient_code'])) {
            global $wpdb;
            $userid = get_current_user_id();
            $wp_rc_wallets = $wpdb->prefix."rc_wallets";

            $recipient_code = sanitize_text_field($_POST['recipient_code']);
            $myQtyArr = sanitize_text_field($_POST['myQtyArr']);
            $totalNumArr = sanitize_text_field($_POST['totalNumArr']);
            $customer_note = isset($_POST['customer_note']) ? sanitize_text_field($_POST['customer_note']) : '';
            $orders = $this->get_associated_orders($recipient_code);
            $order_items = array();
            $result = substr($recipient_code, 0, 2);   
            if(count($orders)) {
                $order_id = $orders[0]['id'];

                $Rcorder = wc_get_order( $order_id );
                $Rcitems = $Rcorder->get_items();
                $count = 0;
                foreach($Rcitems as $key => $rcitem) {
                    if(!empty($rcitem['product_id'])){
                        $rcproduct_id = $rcitem['product_id'];
                    }else{
                        global $wpdb;
                        $postid = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_title = "'.$rcitem['name'].'" AND post_type = "product_variation" ' );
                        $rcproduct_id = $postid[0]->ID;
                    }
                    if(has_term('recipients-choice', 'product_cat', $rcproduct_id)) {
                        $count += $rcitem['qty'] * wc_get_order_item_meta($key, 'iof_number_of_deliveries', true); //2 stands 
                    }
                }

                if($this->has_recipient_choice($order_id)) {
                    $object = wc_get_order($order_id);
                    if(isset($object->iof_recipient_choice_fulfilled) && $object->iof_recipient_choice_fulfilled == 'no') {
                        $recipient_choice = $_POST['recipient_choice'];
                        if($recipient_choice && is_array($recipient_choice) && count($recipient_choice) != 0) {
                            if( $this->has_correct_rc_ids($order_id, $recipient_choice)) {
                                foreach($recipient_choice as $rc_id => $deliveries) {
                                    foreach($deliveries as $delivery_date => $items) {
                                        foreach($items as $item_id => $properties) {
                                            if(is_numeric($properties['qty'])) {
                                                $order_items[] = array(
                                                    'product_id'    => $item_id,
                                                    'qty'           => $properties['qty'],
                                                    'side'          => isset($properties['_Side']) ? $properties['_Side'] : '',
                                                    'vegetable'     => isset($properties['_Vegetable']) ? $properties['_Vegetable'] : '',
                                                    'salad'         => isset($properties['_Salad']) ? $properties['_Salad'] : '',
                                                    'bread'         => isset($properties['_Bread']) ? $properties['_Bread'] : '',
                                                    'dessert'       => isset($properties['_Dessert']) ? $properties['_Dessert'] : '',
                                                    'delivery_date' => $delivery_date,
                                                    'shipping'      => $shiping_method
                                                );
                                            }
                                        }
                                    }
                                }

                                $address = array(
                                    'first_name' => $object->get_shipping_first_name(),
                                    'last_name' => $object->get_shipping_last_name(),
                                    'email' => $object->shipping_email,
                                    'phone' => $object->shipping_phone,
                                    'address_1' => $object->get_shipping_address_1(),
                                    'address_2' => $object->get_shipping_address_2(),
                                    'city' => $object->get_shipping_city(),
                                    'state' => $object->get_shipping_state(),
                                    'postcode' => $object->get_shipping_postcode(),
                                    'country' => $object->get_shipping_country()
                                );
                                if(count($order_items)) {
                                    $order = new WC_Order();
                                    $order_item_ids = array();
                                    try {
                                        foreach ($order_items as $item) {
                                            $pro_var = wc_get_product($item['product_id']);
                                            if ($pro_var) {
                                                $order_item_ids[]  = $order->add_product($pro_var, $item['qty'], array(
                                                    'subtotal' => 0,
                                                    'total' => 0
                                                ));
                                            }
                                        }

                                        $order->set_address($address, 'billing');
                                        $order->set_address($address, 'shipping');


                                        /**
                                         * Adding shipping method to order. Fix problem when admin can't see which method user used
                                         * $object - Parent order. We are got it above
                                         * $order - New order
                                        **/ 
                                        $shipping_method_title = '';
                                        $shipping_method_id = '';
                                        $shipping_method_total = '';
                                        $shipping_method_taxes = '';
                                        foreach( $object->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
                                            $shipping_method_title     = $shipping_item_obj->get_name();
                                            $shipping_method_id        = $shipping_item_obj->get_method_id();
                                            $shipping_method_total     = $shipping_item_obj->get_total();
                                            $shipping_method_taxes     = $shipping_item_obj->get_taxes();
                                        }
                                        $item = new WC_Order_Item_Shipping();
                                        $item->set_props(array(
                                            'method_title' => $shipping_method_title,
                                            'method_id' => $shipping_method_id,
                                            'total' => 0,
                                            'taxes' => $shipping_method_taxes
                                        ));
                                        $order->add_item($item);
                                        $order->save();

                                        update_post_meta( $order->get_id(), '_shipping_phone', $object->shipping_phone);
                                        update_post_meta( $order->get_id(), '_shipping_email', $object->shipping_email);
                                        
                                        $order->set_customer_note($customer_note);
                                        $order->calculate_shipping();
                                        $order->calculate_totals();
                                        $order->calculate_taxes();
                                        $this->update_order_items_meta($order_item_ids, $order_items);
                                        // custom code for add total order redeem
                                        $items_iof_order = $object->get_items();
                                        $explodeMyQtyArr = explode(',', $myQtyArr);
                                        $explodetotalNumArr = explode(',', $totalNumArr);
                                        
                                        $counter=0;
                                        //This loop for only Wallet
                                        foreach ( $items_iof_order as $order_item_id => $item_order ) {
                                            if($result == 'RC'){
                                                $iof_redeem_orders = $item_order->get_meta( 'iof_redeem_orders', true );
                                            }else{
                                                $iof_redeem_orders = $item_order->get_meta( 'iof_number_of_deliveries', true );
                                            }
                                            $walletTotalOrder[] = $iof_redeem_orders;
                                        }
                                        $dataOFWallteOrder = array_sum($walletTotalOrder);

                                        foreach ( $items_iof_order as $order_item_id => $item_order ) {
                                             if($result == 'RC'){
                                                $iof_redeem_orders = $item_order->get_meta( 'iof_redeem_orders', true );
                                            }else{
                                                $iof_redeem_orders = $item_order->get_meta( 'iof_number_of_deliveries', true );
                                            }
                                            $totalOrders[] = $dataOFWallteOrder - $explodeMyQtyArr[$counter];
                                            if($iof_redeem_orders != '0' || $iof_redeem_orders != 0){
                                                $total_redeem = $iof_redeem_orders - $explodeMyQtyArr[$counter];
                                                wc_update_order_item_meta($order_item_id, 'iof_redeem_orders', $total_redeem);
                                                //Adjust Wallets
                                                if(!empty($userid) || $userid != '' ){
                                                    $mylink = $wpdb->get_results( "SELECT * FROM $wp_rc_wallets WHERE rc_shortcode = '".$recipient_code."' and user_id = ".$userid." ");
                                                     if($mylink != null || !empty($mylink)){
                                                        $remainingQty = $dataOFWallteOrder - $explodeMyQtyArr[$counter];
                                                        $wpdb->query("UPDATE $wp_rc_wallets SET total_orders='$remainingQty' WHERE user_id='$userid' AND rc_shortcode = '$recipient_code' ");
                                                     }
                                                }
                                                $counter++;    
                                            }

                                        }


                                        $myTotalRedeemOrder = array_sum($totalOrders);
                                        if($myTotalRedeemOrder == "0" || $myTotalRedeemOrder == 0){
                                            update_post_meta($order_id, '_iof_recipient_choice_fulfilled', 'yes');
                                            if(get_post_meta($order_id, '_iof_email_notification', true)){
                                                update_post_meta($order_id, '_iof_email_notification', 'off');
                                            }else{
                                                add_post_meta($order_id, '_iof_email_notification', 'off');
                                            }        
                                        }

                                        $explodeMyQtyArrTotal = array_sum($explodeMyQtyArr);
                                        if($explodetotalNumArr[0] == $explodeMyQtyArrTotal){
                                           update_post_meta($order_id, '_iof_recipient_choice_fulfilled', 'yes');
                                           if(get_post_meta($order_id, '_iof_email_notification', true)){
                                                update_post_meta($order_id, '_iof_email_notification', 'off');
                                            }else{
                                                add_post_meta($order_id, '_iof_email_notification', 'off');
                                            }          
                                        }
                                        
                                        $check_post = get_post_meta($order_id, '_iof_recipient_child_order',true);
                                        $getOrderNotes = get_post_meta($order_id, '_shipping_note_card_message',true);

                                        if(!empty($check_post)){
                                            $join_arry= array($check_post);
                                            array_push($join_arry,$order->get_id());
                                            $str = implode(',', $join_arry);
                                            update_post_meta($order_id, '_iof_recipient_child_order', $str);    
                                        }else{
                                            update_post_meta($order_id, '_iof_recipient_child_order', $order->get_id());     
                                        }

                                        update_post_meta($order->get_id(), '_shipping_note_card_message', $getOrderNotes);

                                        //update_post_meta($order_id, '_iof_recipient_child_order', $order->get_id());   

                                        update_post_meta($order->get_id(), '_iof_recipient_parent_order', $order_id);
                                        $order->update_status('processing');


                                        $getPurchaserEmail = get_post_meta($order_id,'_billing_email',true);
                                        if($getPurchaserEmail){
                                            $ReceiverUser = get_post_meta($order_id,'_billing_email',true);

                                            $ReceiverFName = get_post_meta($order_id,'_shipping_first_name',true);
                                            $ReceiverLName = get_post_meta($order_id,'_shipping_last_name',true);
                                            $ReceiverName = $ReceiverFName.' '.$ReceiverLName;

                                            $SenderFName = get_post_meta($order_id,'_billing_first_name',true);
                                            $SenderLName = get_post_meta($order_id,'_billing_last_name',true);
                                            $SenderName = $SenderFName.' '.$SenderLName;

                                            $order_post = get_post( $order_id );
                                            $parent_post_date =  strtotime($order_post->post_date);

                                            global $woocommerce;
                                            $mailer = $woocommerce->mailer();

                                            $user_info = get_userdata($user_id);
                                            $user_email = $getPurchaserEmail;
                                            $user_message  = '<p>Congratulations, '.$SenderName.'!</p>';
                                            $user_message .= '<p>Regarding your order #'.$order_id.' on '.date('j F Y',$parent_post_date).'</p>';
                                            $user_message .= '<p>'.$ReceiverName.' has redeemed your Recipient Choice gift successfully today.</p>';
                                            $user_message .= '<p>Thank you for using Instead of flowers.</p>';
                                            ob_start();
                                            wc_get_template( 'emails/email-header.php', array( 'email_heading' => 'Recipient Choice Redeemed!' ) );
                                            echo  $user_message ;
                                            wc_get_template( 'emails/email-footer.php' );
                                            $message = ob_get_clean();
                                            $subject = 'RC Redeemed by '.$ReceiverName;
                                            // Debug wp_die($user_email);
                                            $mailer->send( $user_email, $subject, $message);

                                        }

                                        $delivery_date_arr = array();
                                        foreach ($order_items as $item) {
                                            $delivery_date_arr[] = $item['delivery_date'];
                                        }
                                        $get_delivery_date = implode(', ', $delivery_date_arr);

                                        $orderFrom = get_post_meta($order_id,'orderFrom', true);
                                        if($orderFrom == 'FL'){
                                            $Location = '1100 94th Ave N St. Petersburg, FL 33702 USA';
                                        }else{
                                            $Location = '1331 Marietta Blvd NW, Atlanta, GA 30318';
                                        }

                                        return wp_send_json(array('success' => 'Your order has been placed.','orderid' => $order->get_id(),'shipping_method_id' => $shipping_method_id, 'get_delivery_date' => $get_delivery_date, 'location' => $Location ), 200);
                                    } catch(Exception $e) {
                                        return wp_send_json(array('error' => $e->getMessage()), 422);
                                    }
                                     

                                     
                                }

                                return wp_send_json(array('error' => 'Could not fetch order items'), 422);
                            }
                        }
                        return wp_send_json(array('error' => 'Bad Request Format.'), 422);
                    }
                    return wp_send_json(array('error' => 'This Recipient\'s Choice Code has already been redeemed.'), 422);
                }
            }
            return wp_send_json(array('error' => 'Reservation missing.'), 422);
        }
        return wp_send_json(array('error' => 'Recipient Code missing.'), 422);
    }

    /**
     * Adds link between parent and child order.
     *
     * @param $order
     */
    public function add_links_to_parent($order) {

        if(isset($order->iof_recipient_choice)) {
            
            $recipient_code = get_post_meta($order->get_id(), '_iof_recipient_choice', true);
            $is_redeemed = get_post_meta($order->get_id(), '_iof_recipient_choice_fulfilled', true);
            $iof_rc_expire = get_post_meta($order->get_id(), '_iof_rc_expire', true);
            if(empty($iof_rc_expire) || $iof_rc_expire == NULL ){
                $iof_rc_expire="";
            }else{
              $iof_rc_expire= '<label> Expires On : <i>('.date('F j, Y', strtotime($iof_rc_expire)).')</i></label>' ;
            }
            $status = ($is_redeemed == 'yes') ? 'Redeemed!' : 'Pending!';
             echo '<p class="form-field form-field-wide"><label>Recipient Code: <i>('.$status.')</i></label><h3>'.$recipient_code.'</h3> '.$iof_rc_expire.'</p>';
        }

        if(isset($order->iof_recipient_parent_order)) {
            $parent_id = get_post_meta($order->get_id(), '_iof_recipient_parent_order', true);
            $url = '/wp-admin/post.php?post='.$parent_id.'&action=edit';
            if(!empty($parent_id)){
                echo '<a href="'.$url.'" target="_blank">&larr; View parent order</a>';
            }
        }

        if(isset($order->iof_recipient_child_order)) {
            $child_id = get_post_meta($order->get_id(), '_iof_recipient_child_order', true);
            $url = '/wp-admin/post.php?post='.$child_id.'&action=edit';
            if(!empty($child_id)){
                echo '<a href="'.$url.'" target="_blank">View child order &rarr;</a>';
            }
        }
    }

    /**
     * Display the number of deliveries select.
     */
    public function display_number_of_deliveries() {
        $product_id = get_the_ID();
        if(has_term('recipients-choice', 'product_cat', $product_id)) { ?>
            <div class="row customRCProduct">
                <div class="col-lg-12">
                    <label>Number of Deliveries</label>
                    <span class="text-success">Your item cost will be multiplied by the number of deliveries.</span>
                    <select class="form-control" name="number_of_deliveries">
                        <option value="1">1 Delivery</option>
                        <option value="2">2 Deliveries</option>
                        <option value="3">3 Deliveries</option>
                        <option value="4">4 Deliveries</option>
                        <option value="5">5 Deliveries</option>
                    </select>
                </div>
            </div>
        <?php }
    }

    /**
     * Save number of deliveries into the order item.
     *
     * @param $item
     * @param $cart_item_key
     * @param $values
     * @param $order
     */
    public function save_number_deliveries_to_order( $item, $cart_item_key, $values, $order ) {
        if ( ! empty( $values['number_of_deliveries'] ) ) {
            $item->add_meta_data( __( 'iof_number_of_deliveries' ), $values['number_of_deliveries'] );
            $item->add_meta_data( __( 'iof_redeem_orders' ), $values['number_of_deliveries'] );
            
            for($i=1;$i <= $values['number_of_deliveries'];$i++){
                $item->add_meta_data( __( 'Delivery date '.$i ), 'rc'.$i );
                $item->add_meta_data( __( 'd_dates' ), '1970-01-01' );
            }
        } 
    }


    /**
     * Saves number of deliveries into the cart.
     *
     * @param $cart_item_data
     * @param $product_id
     * @param $variation_id
     *
     * @return mixed
     */
    public function add_number_deliveries_to_cart($cart_item_data, $product_id, $variation_id) {
        if(isset($product_id)) {
            if(has_term('recipients-choice', 'product_cat', $product_id)) {
                if ( ! empty( $_POST['number_of_deliveries'] ) ) {
                    $cart_item_data['number_of_deliveries'] = wc_clean( $_POST['number_of_deliveries'] );
                }
            }
        }
        return $cart_item_data;
    }

    /**
     * Adjust the recipient choice cost on cart based on number of deliveries.
     *
     * @param $cart_object
     */
    public function adjust_rc_price_totals($cart_object) {
        if ( ! empty( $cart_object ) ) {
            foreach ( $cart_object->get_cart() as $key => $value ) {
                if(! empty( $value['number_of_deliveries'] )) {
                    $deliveries = (int) $value['number_of_deliveries'];
                    $product_id = ( isset($value['variation_id']) && !empty($value['variation_id']) ) ? $value['variation_id'] : $value['product_id'];
                    $product = wc_get_product($product_id);
                    $initial_cost = $product->get_price();
                    $value['data']->set_price( $deliveries * $initial_cost);
                }
            }
        }
    }

    /**
     * Adjust cart total for shipping cost and taxes.
     *
     * @param $cart_object
     */
    public function adjust_rc_cart_totals($cart_object) {
        if ( ! empty( $cart_object ) ) {
            $subtotal = 0;
            $tax = 0;
            $rc_deliveries = 0;
            $is_rc = false;

            $produts_in_cart = count($cart_object->get_cart());

            foreach ( $cart_object->get_cart() as $key => $value ) {

                if(! empty( $value['number_of_deliveries'] )) {

                    $is_rc = true;
                    $deliveries = (int) $value['number_of_deliveries'];
                    $rc_deliveries += $deliveries;

                    $product = wc_get_product($value['data']->get_id());
                    $initial_cost = $product->get_price();
                    $qty = $value['quantity'];

                    $item_tax = $value['line_tax'];
                    $tax      += $item_tax;
                    $subtotal += $deliveries * $initial_cost * $qty;

                    $categories = array();
                    $terms = wp_get_post_terms( $value['product_id'], 'product_cat' );
                    foreach ( $terms as $term ){
                        $categories[] = $term->slug;
                    }

                    if ( in_array( 'kids-meals', $categories ) ) {
                        $rc_deliveries = $rc_deliveries - $deliveries;
                    }

                    if ( in_array( 'kidsmealnocost', $categories ) ) {
                        $rc_deliveries = $rc_deliveries - $deliveries;
                    }

                }
            }

            if($is_rc) {
                $shipping_charge     = $cart_object->get_shipping_total();
                $sup_shipping_charge = $rc_deliveries * $shipping_charge;

                $shipping_tax     = $cart_object->get_shipping_tax();
                $sup_shipping_tax = $rc_deliveries * $shipping_tax;
                $shipping = $sup_shipping_charge;
              

                 $discount = 0;
                if($cart_object->get_applied_coupons()){
                    $coupons = $cart_object->coupon_discount_totals;
                    $discount = array_sum($coupons);
                }

                $get_tax_totals = $cart_object->get_taxes_total();

                $tax      += $sup_shipping_tax;

                $cart_object->set_shipping_total($shipping);

                $cart_object->set_subtotal( $subtotal );
                $final_amount = $subtotal + $shipping + WC()->cart->get_taxes_total() - $discount;
                if($final_amount < 0){
                  $final_amount = 0;  
                }
                $cart_object->set_total( $final_amount );
                // echo 'Subtotal: ' . $subtotal . '<br/>';
    //             echo 'Shipping: ' . $shipping . '<br/>';
    //             echo 'Tax: ' . $tax . '<br/>';

            }
        }
    }

    /**
     * Exclude recipient choice and other category on cart.
     *
     * @return null
     */
    public function exclude_other_items_from_cart() {

        global $woocommerce;
        $cart_contents    =  $woocommerce->cart->get_cart( );
        $cart_item_keys   =  array_keys ( $cart_contents );
        $cart_item_count  =  count ( $cart_item_keys );

        // Do nothing if the cart is empty
        // Do nothing if the cart only has one item
        if ( ! $cart_contents || $cart_item_count == 1 ) {
            return null;
        }

        // Multiple Items in cart
        $first_item                    =  $cart_item_keys[0];
        $first_item_id                 =  $cart_contents[$first_item]['product_id'];
        $first_item_top_category       =  has_term('recipients-choice', 'product_cat', $first_item_id) ? 'rc' : 'op';

        // Now we check each subsequent items top-level parent category
        foreach ( $cart_item_keys as $key ) {
            if ( $key  ==  $first_item ) {
                continue;
            } else {
                $product_id            =  $cart_contents[$key]['product_id'];
                $product_top_category  =  has_term('recipients-choice', 'product_cat', $product_id) ? 'rc' : 'op';

                if ( $product_top_category  !=  $first_item_top_category ) {
                    $woocommerce->cart->set_quantity ( $key, 0, true );
                    $mismatched_categories  =  1;
                } elseif ($product_top_category  ==  $first_item_top_category && $product_top_category == 'rc') {
                    return null;
                }
            }
        }

        // we really only want to display this message once for anyone, including those that have carts already pre-filled
        if ( isset ( $mismatched_categories ) ) {
            echo '<p class="woocommerce-error" id="iof-rc-wc-error">Sorry, Recipient Choice cannot be ordered with other items.<br />To order a Recipient Choice please empty your cart first.</p>';
        }
    }

    /**
     * Update order items
     *
     * @param array $ids
     * @param array $items
     */
    private function update_order_items_meta($ids = array(), $items = array()) {
        for($i = 0; $i < count($items); $i++) {
            wc_update_order_item_meta($ids[$i], __('side'), $items[$i]['side']);
            wc_update_order_item_meta($ids[$i], __('vegetable'), $items[$i]['vegetable']);
            wc_update_order_item_meta($ids[$i], __('salad'), $items[$i]['salad']);
            wc_update_order_item_meta($ids[$i], __('bread'), $items[$i]['bread']);
            wc_update_order_item_meta($ids[$i], __('dessert'), $items[$i]['dessert']);
            wc_update_order_item_meta($ids[$i], __('_iof_delivery_date'), $items[$i]['delivery_date']);
            wc_update_order_item_meta($ids[$i], __('shipping'), $items[$i]['shipping']);
        }
    }

    /**
     * Check validity of data transferred from AJAX.
     * @param $order_id
     * @param array $recipient_choices
     *
     * @return bool
     */
    private function has_correct_rc_ids($order_id, $recipient_choices = array()) {
        $order = wc_get_order( $order_id );
        $items = $order->get_items();
        $rc_ids = array();
        $meal_ids = array();

        foreach($items as $key => $item) {
            if(!empty($item['product_id'])){
                $product_id = $item['product_id'];
            }else{
                global $wpdb;
                $postid = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_title = "'.$item['name'].'" AND post_type = "product_variation" ' );
                $product_id = $postid[0]->ID;
            }
            if(has_term('recipients-choice', 'product_cat', $product_id)) {
                $rc_ids[] = $key;
                if(!empty($item['product_id'])){
                     $product_id = ( isset($item['variation_id']) && !empty($item['variation_id']) ) ? $item['variation_id'] : $item['product_id'];
                }else{
                    global $wpdb;
                    $postid = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_title = "'.$item['name'].'" AND post_type = "product_variation" ' );
                    $product_id = $postid[0]->ID;
                }
               
                $product = wc_get_product($product_id);
                 if(!empty($item['product_id'])){

                    if($second_category = $this->get_second_meal_category($item['product_id'])) {
                        $meal_ids = array_merge( $meal_ids, $this->get_all_meals_id_from_category($second_category, $product->get_name()) );
                    }
                }else{
                    if($second_category = $this->get_second_meal_category($product_id)) {
                        $meal_ids = array_merge( $meal_ids, $this->get_all_meals_id_from_category($second_category, $product->get_name()) );
                    }
                }
            }
        }

        foreach($recipient_choices as $key => $data) {
            if(!in_array($key, $rc_ids) || !is_array($data)) {
                return false;
            }

            foreach($data as $date => $items) {
                if(!is_array($items)) {
                    return false;
                }
                foreach($items as $id => $properties) {
                    if ( ! in_array($id, $meal_ids)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Display pick your meals page.
     *
     * @param array $order_details
     *
     * @return string
     */
    private function prepare_tabs_for_selection($order_details = array()) {
        $method = ( isset($order_details['shipping_method']) && $order_details['shipping_method'] == 'courier' ) ? 'courier' : 'outsourced';
        $all_blocked_dates  = Iof_Utilities_Blockout_Dates::get_blocked_dates($method);
        $week_disabled = Iof_Utilities_Blockout_Dates::get_days_disabled($method);
        ob_start();
        include __DIR__ . '/../public/partials/recipient_choices/pick_your_meals.php';
        $result = ob_get_clean();
        return $result;
    }

    /**
     * Get recipient choices details for email.
     *
     * @param $order_id
     *
     * @return array
     */
    private function get_order_details($order_id) {
        global $wpdb;


        $userid = get_current_user_id();
        $wp_rc_wallets = $wpdb->prefix."rc_wallets";

        $order = wc_get_order( $order_id );
        $items = $order->get_items();

        $count = 0;
        $coupon = $order->iof_recipient_choice;
        $note = $order->get_customer_note();
        $recipient_choices = array();
        $meals = array();
        $shipping_method = $order->has_shipping_method('flat_rate') ? 'courier' : 'fedex';

      /*  $shipping_email = get_post_meta($order_id, '_shipping_field_327', true);
        $shipping_phone = get_post_meta($order_id, '_shipping_field_133', true);
*/

        $shipping_address = array(
            'address_1' => $order->get_shipping_address_1(),
            'address_2' => $order->get_shipping_address_2(),
            'city' => $order->get_shipping_city(),
            'state' => $order->get_shipping_state(),
            'zip' => $order->get_shipping_postcode(),
            'phone' => $order->shipping_phone,
            'email' => $order->shipping_email
        );

        // Iterating through order shipping items
        foreach( $order->get_items( 'shipping' ) as $item_id => $item ){
            // Get the data in an unprotected array
            $item_data = $item->get_data();
            $shipping_data_method_id    = $item_data['method_id'];
           
        }


        foreach($items as $key => $item) {
            $product_id = $item['product_id'];    
            if(has_term('recipients-choice', 'product_cat', $product_id)) {
                $iof_redeem_orders = wc_get_order_item_meta($key, 'iof_redeem_orders', true);
                if($iof_redeem_orders != "0" || $iof_redeem_orders != 0){

                    $recipient_code = sanitize_text_field($order->iof_recipient_choice);
                    $result = substr($recipient_code, 0, 2);    


                    $count += $item['qty'] * wc_get_order_item_meta($key, 'iof_number_of_deliveries', true); //2 stands for number of deliveries per recipient choice.
                    
                    $product_id = ( isset($item['variation_id']) && !empty($item['variation_id']) ) ? $item['variation_id'] : $item['product_id'];
                    
                    $product = wc_get_product($product_id);
                    $product_name = $product->get_name();
                    $recipient_choices[$count]['title'] = $product_name;
                    $recipient_choices[$count]['qty'] = $item['qty'];
                    $recipient_choices[$count]['num_deliveries'] = wc_get_order_item_meta($key, 'iof_number_of_deliveries', true); //2 stands for number of deliveries per recipient choice.
                    if($result == 'RC'){
                        $recipient_choices[$count]['iof_redeem_orders'] = wc_get_order_item_meta($key, 'iof_redeem_orders', true); //2 stands for number of deliveries per     
                    }else{
                        $recipient_choices[$count]['iof_redeem_orders'] = wc_get_order_item_meta($key, 'iof_number_of_deliveries', true); //2 stands for number of deliveries per     
                    }
                    $recipient_choices[$count]['id'] = $key;

                    
                    /*if($item['product_id'] == 961){
                        $item['product_id'] = 949;
                    } */   
                    
                    if($second_category = $this->get_second_meal_category($item['product_id'])) {
                        $meals = $this->get_all_meals_from_category($second_category, $product_name);
                    }    
                  

                    $recipient_choices[$count]['meals'] = $meals;

                    if($result == 'RC'){
                        $iof_redeem_orders =  $recipient_choices[$count]['iof_redeem_orders'];    
                    }else{
                        $iof_redeem_orders =  $count;    
                    }

                    $totoal_number_of_deliveries = $count;
                }

                
            }
        }




        if(!empty($userid) || $userid != '' ){
           $mylink = $wpdb->get_results( "SELECT * FROM $wp_rc_wallets WHERE rc_shortcode = '".$coupon."' and user_id = ".$userid." ");
           if(!empty($mylink) || $mylink != null){
                $tot_number_of_deliveries = $mylink[0]->total_orders;   
           }else{
                $tot_number_of_deliveries = $totoal_number_of_deliveries;  
           }
        }else{
             $tot_number_of_deliveries = $totoal_number_of_deliveries;
        }

        return array(
            'total' => $iof_redeem_orders,
            'coupon' => $coupon,
            'note' => $note,
            'totoal_number_of_deliveries' => $tot_number_of_deliveries,
            'shipping_method' => $shipping_method,
            'shipping_address' => $shipping_address,
            'recipient_choices' => $recipient_choices,
            'shipping_data_method_id' => $shipping_data_method_id,
        );
    }





    /**
     * Check if order is a recipient choice.
     *
     * @param $order_id
     *
     * @return bool
     */
    private function has_recipient_choice($order_id) {
        $order = wc_get_order( $order_id );
        if($order) {
            $items = $order->get_items();
            foreach ($items as $item) {
                if(!empty($item['product_id'])){
                    $product_id = $item['product_id'];    
                }else{
                    global $wpdb;
                    $postid = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_title = "'.$item['name'].'" AND post_type = "product_variation" ' );
                    $product_id = $postid[0]->ID;
                }
                if (has_term('recipients-choice', 'product_cat', $product_id)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get recipient choice second meal category.
     *
     * @param $product_id
     *
     * @return bool|string
     */
    private function get_second_meal_category($product_id) {
        $terms   = get_the_terms( $product_id, 'product_cat' );
        if(is_array($terms)) {
            foreach ($terms as $term) {
                if (in_array($term->slug, array('deluxe-meals'))) {
                    return 'deluxe-meals';
                } elseif(in_array($term->slug, array('premium-meals'))) {
                    return 'premium-meals';
                } elseif(in_array($term->slug, array('standard-meals'))) {
                    return 'standard-meals';
                } elseif(in_array($term->slug, array('kidsmealnocost'))) {
                    return 'kids-meals';
                } elseif(in_array($term->slug, array('deluxe-gf-meals'))) {
                    return 'deluxe-gf-meals';
                } elseif(in_array($term->slug, array('standard-gf-meals'))) {
                    return 'standard-gf-meals';
                }
            }
        }
        return false;
    }

    /**
     * Create coupon code to link to the user recipient choice.
     *
     * @return string $coupon_code
     */
    private function create_coupon_code() {
        $coupon_code = 'RC';
        $code = wp_generate_password(10, false);
        $coupon_code .= $code;

        return $coupon_code;
    }

    /**
     * Gets the default side meta data for a product.
     *
     * @param $id int         The product id.
     * @param $key string     The meta_key value.
     *
     * @return string         The meta_value value.
     */
    private function get_default( $id, $key ) {
        $side_item = get_post_meta( $id, $key, true );
        return $side_item;
    }

    /**
     * Get all meals from a category.
     * @param $category
     * @param $choice_name
     *
     * @return array
     */
    private function get_all_meals_from_category($category, $choice_name) {
       $currentdate = date('F');
        //$currentdate = 'February';
            $option_fields = get_fields( 'option' );
            if($currentdate == 'January') {
                if($option_fields['january_month']) :
                    $pro_url = $option_fields['january_month']['product_url'];
                endif;
            }
            if($currentdate == 'February') {
                if($option_fields['february_month']) :
                  $pro_url = $option_fields['february_month']['product_url'];
                endif;
            }
            if($currentdate == 'March') {
                if($option_fields['march_month']) :
                  $pro_url = $option_fields['march_month']['product_url'];
                endif;
            }
            if($currentdate == 'April') {
                if($option_fields['april_month']) :
                  $pro_url = $option_fields['april_month']['product_url'];
                endif;
            }
            if($currentdate == 'May') {
                if($option_fields['may_month']) :
                  $pro_url = $option_fields['may_month']['product_url'];

                endif;
            }
            if($currentdate == 'June') {
                if($option_fields['june_month']) :
                  $pro_url = $option_fields['june_month']['product_url'];
                endif;
            }
            if($currentdate == 'July') {
                if($option_fields['july_month']) :
                  $pro_url = $option_fields['july_month']['product_url'];
                endif;
            }
            if($currentdate == 'August') {
                if($option_fields['august_month']) :
                  $pro_url = $option_fields['august_month']['product_url'];
                endif;
            }
            if($currentdate == 'September') {
                if($option_fields['september_month']) :
                  $pro_url = $option_fields['september_month']['product_url'];
                endif;
            }
            if($currentdate == 'October') {
                if($option_fields['october_month']) :
                  $pro_url = $option_fields['october_month']['product_url'];
                endif;
            }
            if($currentdate == 'November') {
                if($option_fields['november_month']) :
                  $pro_url = $option_fields['november_month']['product_url'];
                endif;
            }
            if($currentdate == 'December') {
                if($option_fields['december_month']) :
                  $pro_url = $option_fields['december_month']['product_url'];
                endif;
            } 


            foreach ($option_fields as $key => $value) {
                if($key == 'january_month' || $key == 'april_month' || $key == 'august_month' || $key == 'december_month' || $key == 'july_month' || $key == 'june_month' || $key == 'march_month' || $key == 'may_month'|| $key == 'november_month'|| $key == 'october_month'|| $key == 'september_month'){
                    if($pro_url != $value['product_url']){
                        $myData[] = $value['product_url'];
                    }
                }
            }


        $args = array(
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array($category)
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'operator' => 'NOT IN',
                    'terms' => 'recipients-choice'
                )
            ),
            'post_type' => 'product',
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $meals      = new WP_Query( $args );
        $results    = array();

        while ( $meals->have_posts() ) {
            $meals->the_post();
            if(in_array( get_permalink( $meals->post->ID ), $myData)){}else{

                $product = wc_get_product($meals->post->ID);
                $meal_id = $meals->post->ID;
                $meal_name = $product->get_name();
                $meal_description = $product->get_short_description();
                $tmp_desc = strip_tags($meal_description);

                $isGlutenFree = $this->isGlutenFree( $meals->post->ID );
                $isDeluxe     = $this->isDeluxe( $meals->post->ID );

               // $available_sides    = $this->get_sides( 'standard-sides', $isGlutenFree );
                $available_breads   = $this->get_sides( 'bread', $isGlutenFree );
                $available_desserts = $this->get_sides( 'dessert', $isGlutenFree );
                if ( $isDeluxe ) {
                    $available_sides    = $this->get_sides( 'deluxe-sides' );
                    $available_salads     = $this->get_sides( 'deluxe-salads' );
                    $available_vegetables = $this->get_sides( 'deluxe-vegetables' );
                } else {
                    $available_sides    = $this->get_sides( 'standard-sides' );
                    $available_salads     = $this->get_sides( 'standard-salads' );
                    $available_vegetables = $this->get_sides( 'vegetables' );
                }


                if($product->has_child()) {
                    $variations = $product->get_available_variations();
                    foreach ($variations as $variation) {
                        $object = wc_get_product($variation['variation_id']);
                        $object_name = $object->get_name();
                        if($this->has_matched_variation($object_name, $choice_name)) {
                            $meal_id = $variation['variation_id'];
                            break;
                        }
                    }
                }

                array_push(
                    $results,
                    array(
                        'slug'  => $meals->post->post_name,
                        'image' => get_the_post_thumbnail( $meals->post->ID, 'thumbnail' ),
                        'sides' => $product->has_child() ? $this->get_default_sides( $meals->post->ID ) : array(),
                        'short_description' => $meal_description,
                        'small_description' => substr($tmp_desc, 0, 50),
                        'title' => $meal_name,
                        'id' => $meal_id,
                        'available_vegetables' => $available_vegetables,
                        'available_sides' => $available_sides,
                        'available_desserts' => $available_desserts,
                        'available_salads' => $available_salads,
                        'available_breads' => $available_breads,
                    )
                );

            }
        }
        wp_reset_query();

        return $results;
    }


     /**
     * Gets the side items for selection.
     *
     * @param $category string      The WooCommerce product category to filter by.
     * @param $isGlutenFree
     *
     * @return array
     */
    private function get_sides( $category = 'standard-sides', $isGlutenFree = false) {
        if($category == 'deluxe-salads') {
            $args = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array($category, 'standard-salads')
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'operator' => 'NOT IN',
                        'terms' => 'gluten-free'
                    )
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'title',
            );
        } elseif($category == 'deluxe-vegetables') {
            $args = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array($category, 'vegetables')
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'operator' => 'NOT IN',
                        'terms' => 'gluten-free'
                    )
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'title',
            );
        }elseif($category == 'deluxe-sides') {
            $args = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array($category, 'standard-sides'),
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'operator' => 'NOT IN',
                        'terms' => 'gluten-free'
                    )
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'title',
            );
        } elseif($isGlutenFree) {
            $args = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $category
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'operator' => 'NOT IN',
                        'terms' => 'no-gluten-free'
                    )
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'title',
            );
        } else {
            $args = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $category
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'operator' => 'NOT IN',
                        'terms' => 'gluten-free'
                    )
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'title',
            );
        }
        $sides      = new WP_Query( $args );
        $sides_data = array();

        while ( $sides->have_posts() ) {
            $sides->the_post();
            array_push(
                $sides_data,
                array(
                    'id'    => $sides->post->ID,
                    'slug'  => $sides->post->post_name,
                    'link'  => get_permalink(),
                    'image' => wp_get_attachment_url( get_post_thumbnail_id($sides->post->ID) ),//get_the_post_thumbnail( $sides->post->ID, 'thumbnail' ),
                    'title' => get_the_title()
                )
            );
        }
        wp_reset_query();

        return $sides_data;
    }


    /**
     * Check if product is gluten free.
     * @param null $product_id
     *
     * @return bool
     */
    private function isGlutenFree($product_id = null) {
        $id = $product_id ? $product_id :get_the_ID();
        $terms = get_the_terms( $id, 'product_cat' );
        $slugs = array();
        if(isset($terms) && is_array($terms)) {
            foreach ($terms as $term) {
                array_push($slugs, $term->slug);
            }
            if (in_array('gluten-free', $slugs) || in_array('gluten-free-meals', $slugs) ||
                in_array('standard-gf-meals', $slugs) || in_array('deluxe-gf-meals', $slugs)) {
                return true;
            }
        }
        return false;
    }

    private function isDeluxe($product_id = null) {
        $id = $product_id ? $product_id :get_the_ID();
        $terms = get_the_terms( $id, 'product_cat' );
        $slugs = array();
        if(isset($terms) && is_array($terms)) {
            foreach ($terms as $term) {
                array_push($slugs, $term->slug);
            }
            if (in_array('deluxe-meals', $slugs) || in_array('deluxe-gf-meals', $slugs) ||
                in_array('deluxe-entree', $slugs) || in_array('premium-meals', $slugs)) {
                return true;
            }
        }
        return false;
    }



    /**
     * Get all meals id from given category.
     *
     * @param $category
     * @param $choice_name
     *
     * @return array
     */
    private function get_all_meals_id_from_category($category, $choice_name) {

        $args = array(
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array($category)
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'operator' => 'NOT IN',
                    'terms' => 'recipients-choice'
                )
            ),
            'post_type' => 'product',
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $meals      = new WP_Query( $args );
        $results    = array();

        while ( $meals->have_posts() ) {

            $meals->the_post();
            $product = wc_get_product($meals->post->ID);
            $meal_id = $meals->post->ID;
            if($product->has_child()) {
                $variations = $product->get_available_variations();
                foreach ($variations as $variation) {
                    $object = wc_get_product($variation['variation_id']);
                    $object_name = $object->get_name();
                    if($this->has_matched_variation($object_name, $choice_name)) {
                        $meal_id = $variation['variation_id'];
                        break;
                    }
                }
            }

            $results[] = $meal_id;
        }
        wp_reset_query();

        return $results;
    }

    /**
     * Get all sides for a meal.
     *
     * @param $product_id
     *
     * @return array
     */
    private function get_default_sides($product_id) {
        return array(
            'Side' => $this->get_default($product_id, 'default_side'),
            'Vegetable' => $this->get_default($product_id, 'default_vegetable'),
            'Salad' => $this->get_default($product_id, 'default_salad'),
            'Bread' => $this->get_default($product_id, 'default_bread'),
            'Dessert' => $this->get_default($product_id, 'default_dessert')
        );
    }

    /**
     * Check if recipient choice size matches with meals size.
     * @param $meal_name
     * @param $choice_name
     *
     * @return bool
     */
    private function has_matched_variation($meal_name, $choice_name) {
        preg_match('/\d+/', $choice_name, $matches);
        $choice_size = 0;
        $meal_size = 0;
        if(isset($matches[0])) {
            $choice_size = $matches[0];
        }

        preg_match('/\d+/', $meal_name, $matches);
        if(isset($matches[0])) {
            $meal_size = $matches[0];
        }

        if($meal_size == $choice_size) {
            return true;
        }

        return false;
    }

    /**
     * Look up order associated to recipient choice code.
     *
     * @param $recipient_code
     *
     * @return array
     */
    private function get_associated_orders($recipient_code) {

        $args = array(
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_iof_recipient_choice',
                    'value' => array( $recipient_code ),
                    'compare' => 'IN'
                )
            ),
            'post_type' => 'shop_order',
            'post_status' => array( 'wc-processing', 'wc-on-hold'),
            'orderby' => 'title',
        );

        $orders      = new WP_Query( $args );
        $results = array();

        while ( $orders->have_posts() ) {
            $orders->the_post();
            array_push(
                $results,
                array(
                    'slug'  => $orders->post->post_name,
                    'title' => get_the_title(),
                    'id' => $orders->post->ID
                )
            );
        }
        wp_reset_query();

        return $results;
    }


     private function checkValidateGCCode($recipient_code) {

        global $wpdb;
        $checkGC =   $wpdb->get_results( "SELECT count(ID) as MyCount FROM $wpdb->posts WHERE post_title = '$recipient_code' ");
        return $checkGC[0]->MyCount;
        
    }



    /**
     * Get recipient product min delivery date
     */
    public function get_rec_min_date( $blocked_dates, $blocked_week_days ){
       
       //return true;

        date_default_timezone_set( 'America/New_York' );
        $current_hour = date('G');

        if ( $current_hour >= 3 ) {
            $min_date = date( "Y-m-d", strtotime( "+3 days" ) );
        } else {
            $min_date = date( "Y-m-d", strtotime( "+2 days" ) );
        }

        $selected_dates    = array( $min_date );
        $delivery_type     = 'outsourced';
        $blocked_dates     = Iof_Utilities_Blockout_Dates::get_blocked_dates( $delivery_type );
        $blocked_week_days = Iof_Utilities_Blockout_Dates::get_days_disabled( $delivery_type );

        $all_blocked_dates = Iof_Utilities_Blockout_Dates::get_four_weeks_block_out_dates( $selected_dates, $blocked_dates, $blocked_week_days, false );

        foreach ( $selected_dates as $key => $order_item_row ) {

            foreach ( $all_blocked_dates[ $key ] as $block_out_date ) {

                if ( $min_date != $block_out_date ) {
                    continue;
                }

                $min_date = date( 'Y-m-d', strtotime( $min_date . ' +1 day' ) );
            }
        }

        return $min_date;
    }

}