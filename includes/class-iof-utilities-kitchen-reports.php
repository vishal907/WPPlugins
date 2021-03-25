<?php

class Iof_Utilities_Kitchen_Reports {

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

    public function add_kitchen_reports_menu() {
        add_menu_page('Kitchen Reports', 'Kitchen Reports', 'read', 'kitchen-reports', array($this, 'display_kitchen_reports'), 'dashicons-tickets', 6);
    }

    public function display_kitchen_reports() {
        //$orders = $this->get_orders_for('2017-11-14');
        ob_start();
        include __DIR__ . '/../admin/partials/kitchen_reports/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    private function get_orders_for($date) {

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'shop_order',
            'post_status' => 'wc-processing',
            'orderby' => 'title',
        );

        $orders      = new WP_Query( $args );
        $results = array();

        while ( $orders->have_posts() ) {
            $orders->the_post();
            $order_id = $orders->post->ID;
            $order = wc_get_order($order_id);
            $items = $order->get_items();
            $items_arr = array();
            foreach($items as $key => $item) {
                $tmp = array();
                $item_delivery_date = wc_get_order_item_meta($key, '_iof_delivery_date', true);
                
                $side = wc_get_order_item_meta($key, 'side', true);
                $vegetable = wc_get_order_item_meta($key, 'vegetable', true);
                $salad = wc_get_order_item_meta($key, 'salad', true);
                $bread = wc_get_order_item_meta($key, 'bread', true);
                $dessert = wc_get_order_item_meta($key, 'dessert', true);

                $product_id = isset($item['variation_id']) ? $item['variation_id'] : $item['product_id'];
                $product = wc_get_product($product_id);
                if($item_delivery_date === $date && !has_term('recipients-choice', 'product_cat', $product_id)) {
                    $tmp['name'] = $product->get_formatted_name();
                    $tmp['quantity'] = $item['qty'];
                    if($side) {
                        $tmp['side'] = $side;
                    }
                    if($vegetable) {
                        $tmp['vegetable'] = $vegetable;
                    }
                    if($salad) {
                        $tmp['salad'] = $salad;
                    }
                    if($bread) {
                        $tmp['bread'] = $bread;
                    }
                    if($dessert) {
                        $tmp['dessert'] = $dessert;
                    }
                }
                if(count($tmp)) {
                    $items_arr[] = $tmp;
                }
            }
            if(count($items_arr)) {
                array_push(
                    $results,
                    array(
                        'items' => $items_arr,
                        'id' => $order_id
                    )
                );
            }
        }
        wp_reset_query();
        
        return $results;
    }
}
