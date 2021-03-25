<?php


class Iof_Utilities_rcExpire {

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

    public function add_rc_expire_menu() {
       add_menu_page('RC Settings', 'RC Settings', 'read', 'rc-settings', array($this, 'display_rc_settings'), 'dashicons-clipboard', 9);
    }

    public function display_rc_settings() {
    	//$shipping_methods = self::get_order_delivery_by_date(date('Y-m-d'), $storeName= null);
    	ob_start();
        include __DIR__ . '/../admin/partials/rc_settings/index.php';
        $result = ob_get_clean();
        echo $result;
    }


      public function search_rc_code_event() {
        if(isset($_POST['rc_title']) ) {
            $rc_title = $_POST['rc_title'];
            if(!empty($rc_title) ) {
                global $wpdb;
                $total_tax_get = $wpdb->get_results( "SELECT *  FROM `wp_postmeta` WHERE `meta_value` LIKE '".$rc_title."'" );
                $post_id = $total_tax_get[0]->post_id;
                if($post_id){
                    $_iof_rc_expire = get_post_meta($total_tax_get[0]->post_id,'_iof_rc_expire',true);
                    if(get_post_meta($total_tax_get[0]->post_id, '_iof_email_notification', true)){
                        $email_noti = get_post_meta($total_tax_get[0]->post_id, '_iof_email_notification', true);
                    }else{
                        $email_noti ="on";
                    }

                    $redeemed = get_post_meta($total_tax_get[0]->post_id,'_iof_recipient_choice_fulfilled',true);
                    $my_arr = array(
                        'code' => $rc_title,
                        'expire_date' => $_iof_rc_expire,
                        'order_id' => $post_id,
                        'rc_status' => $redeemed,
                        'email_noti' => $email_noti,
                    );
                    return wp_send_json(array('success' => json_encode($my_arr) ), 200);
                }else{
                     return wp_send_json(array('error' => 'RC code not found.  Please check the code and try again.'), 422);
                }
                

                
            }
        }
        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

     public function change_rc_redeemed_status() {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $email_noti = $_POST['email_noti'];
            $date = $_POST['expire_date'];


            if(empty($date) || empty($email_noti) || empty($status) || empty($id)){
                return wp_send_json(array('error' => 'Something went wrong!'), 422);
            }
            if(is_numeric($id)) {
               
                update_post_meta($id, '_iof_recipient_choice_fulfilled', $status);
                if(get_post_meta($id, '_iof_email_notification', $email_noti)){
                    update_post_meta($id, '_iof_email_notification', $email_noti);
                }else{
                    add_post_meta($id, '_iof_email_notification', $email_noti);
                }
                update_post_meta($id, '_iof_rc_expire', $date);
               
                return wp_send_json(array('success' => 'RC Redeemed Status Changed!' ), 200);
              
            }
        }
        return wp_send_json(array('error' => 'Something went wrong!'), 422);
    }

    


}
