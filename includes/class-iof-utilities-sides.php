<?php


class Iof_Utilities_Sides {

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
     * Adds the Sides panel tab on product page under Product Data.
     */
    public function add_product_sides_panel_tab() {
        if ( $this->is_meal() ) {
            include_once( __DIR__ . '/../admin/partials/product/tabs/sides-tab.php' );
        }
    }

    /**
     * Adds the Sides panel data on product page under Product Data.
     */
    public function add_product_sides_panel_data() {
        // these vars are used in the view
        
        $product_id   = get_the_ID();
        $isGlutenFree = $this->isGlutenFree( $product_id );
        $isDeluxe     = $this->isDeluxe( $product_id );

        //$available_sides    = $this->get_sides( 'standard-sides', $isGlutenFree );
        $available_breads   = $this->get_sides( 'bread', $isGlutenFree );
        $available_desserts = $this->get_sides( 'dessert', $isGlutenFree );
        if ( $isDeluxe ) {
            $available_sides    = $this->get_sides( 'deluxe-sides');
            $available_salads     = $this->get_sides( 'deluxe-salads' );
            $available_vegetables = $this->get_sides( 'deluxe-vegetables' );
        } else {
            $available_sides    = $this->get_sides( 'standard-sides');
            $available_salads     = $this->get_sides( 'standard-salads' );
            $available_vegetables = $this->get_sides( 'vegetables' );
        }

        $default_side           = $this->get_default( $product_id, 'default_side' );
        $default_side_id        = $this->get_default( $product_id, 'default_side_id' );
        $default_side_lock      = $this->get_default( $product_id, 'default_side_lock' );
        $default_vegetable      = $this->get_default( $product_id, 'default_vegetable' );
        $default_vegetable_id   = $this->get_default( $product_id, 'default_vegetable_id' );
        $default_vegetable_lock = $this->get_default( $product_id, 'default_vegetable_lock' );
        $default_salad          = $this->get_default( $product_id, 'default_salad' );
        $default_salad_id       = $this->get_default( $product_id, 'default_salad_id' );
        $default_salad_lock     = $this->get_default( $product_id, 'default_salad_lock' );
        $default_bread          = $this->get_default( $product_id, 'default_bread' );
        $default_bread_id       = $this->get_default( $product_id, 'default_bread_id' );
        $default_bread_lock     = $this->get_default( $product_id, 'default_bread_lock' );
        $default_dessert        = $this->get_default( $product_id, 'default_dessert' );
        $default_dessert_id     = $this->get_default( $product_id, 'default_dessert_id' );
        $default_dessert_lock   = $this->get_default( $product_id, 'default_dessert_lock' );

        include_once(  __DIR__ . '/../admin/partials/product/tabs/sides-panel.php' );
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
     * Avoid a group of product in return.
     * @param array $category
     *
     * @return array
     */
    private function get_sides_not_in($category = array('standard-sides'), $not_categories) {
        $sides      = new WP_Query( array( 'post_type' => 'product', 'product_cat__in' => $category ) );
        $sides_data = array();

        while ( $sides->have_posts() ) {
            $sides->the_post();
            array_push(
                $sides_data,
                array(
                    'slug'  => $sides->post->post_name,
                    'link'  => get_permalink(),
                    'image' => get_the_post_thumbnail( $sides->post->ID, 'thumbnail' ),
                    'title' => get_the_title()
                )
            );
        }
        wp_reset_query();

        return $sides_data;
    }

    /**
     * Gets the default side meta data for a product.
     *
     * @param $id int         The product id.
     * @param $key string     The meta_key value.
     *
     * @return string         The meta_value value.
     */
    public function get_default( $id, $key ) {
        $side_item = get_post_meta( $id, $key, true );
        return $side_item;
    }

    /**
     * Save product sides meta via AJAX and Update.
     *
     * @param $product_id int       Set if on Update.
     */
    public function save_product_sides_meta( $product_id = null ) {
        if ( empty( $product_id ) ) {
            $product_id = wc_clean( $_POST["product_id"] );
        }

        if ( $this->is_meal( $product_id ) ) {
            $side_id     = wc_clean( $_POST["default_side"] );
            $side_locked = wc_clean( $_POST["default_side_lock"] );
            $side_name   = ( $side_id != 0 ) ? wc_get_product( $side_id )->get_title() : 'None';

            $vegetable_id     = wc_clean( $_POST["default_vegetable"] );
            $vegetable_locked = wc_clean( $_POST["default_vegetable_lock"] );
            $vegetable_name   = ( $vegetable_id != 0 ) ? wc_get_product( $vegetable_id )->get_title() : 'None';

            $salad_id     = wc_clean( $_POST["default_salad"] );
            $salad_locked = wc_clean( $_POST["default_salad_lock"] );
            $salad_name   = ( $salad_id != 0 ) ? wc_get_product( $salad_id )->get_title() : 'None';

            $bread_id     = wc_clean( $_POST["default_bread"] );
            $bread_locked = wc_clean( $_POST["default_bread_lock"] );
            $bread_name   = ( $bread_id != 0 ) ? wc_get_product( $bread_id )->get_title() : 'None';

            $dessert_id     = wc_clean( $_POST["default_dessert"] );
            $dessert_locked = wc_clean( $_POST["default_dessert_lock"] );
            $dessert_name   = ( $dessert_id != 0 ) ? wc_get_product( $dessert_id )->get_title() : 'None';

            update_post_meta( $product_id, 'default_side', $side_name );
            update_post_meta( $product_id, 'default_side_id', $side_id );
            update_post_meta( $product_id, 'default_side_lock', $side_locked );
            update_post_meta( $product_id, 'default_vegetable', $vegetable_name );
            update_post_meta( $product_id, 'default_vegetable_id', $vegetable_id );
            update_post_meta( $product_id, 'default_vegetable_lock', $vegetable_locked );
            update_post_meta( $product_id, 'default_salad', $salad_name );
            update_post_meta( $product_id, 'default_salad_id', $salad_id );
            update_post_meta( $product_id, 'default_salad_lock', $salad_locked );
            update_post_meta( $product_id, 'default_bread', $bread_name );
            update_post_meta( $product_id, 'default_bread_id', $bread_id );
            update_post_meta( $product_id, 'default_bread_lock', $bread_locked );
            update_post_meta( $product_id, 'default_dessert', $dessert_name );
            update_post_meta( $product_id, 'default_dessert_id', $dessert_id );
            update_post_meta( $product_id, 'default_dessert_lock', $dessert_locked );
        }

        if ( ! empty( $_POST["product_id"] ) ) {
            die( "complete" );
        }
    }

    /**
     * Update product sides meta on product page.
     *
     * TODO: how is this different than save_products_side_meta? can't they be used for the same thing from different hooks?
     *
     * @param $product_id
     */
    public function update_product_sides( $product_id ) {
        if ( $this->is_meal( $product_id )  && ! empty( $side_id ) ) {
            $side_id     = wc_clean( $_POST["default_side"] );
            $side_locked = wc_clean( $_POST["default_side_lock"] );
            $side_name   = wc_get_product( $side_id )->get_title();

            $vegetable_id     = wc_clean( $_POST["default_vegetable"] );
            $vegetable_locked = wc_clean( $_POST["default_vegetable_lock"] );
            $vegetable_name   = wc_get_product( $vegetable_id )->get_title();

            $salad_id     = wc_clean( $_POST["default_salad"] );
            $salad_locked = wc_clean( $_POST["default_salad_lock"] );
            $salad_name   = wc_get_product( $salad_id )->get_title();

            $bread_id     = wc_clean( $_POST["default_bread"] );
            $bread_locked = wc_clean( $_POST["default_bread_lock"] );
            $bread_name   = wc_get_product( $bread_id )->get_title();

            $dessert_id     = wc_clean( $_POST["default_dessert"] );
            $dessert_locked = wc_clean( $_POST["default_dessert_lock"] );
            $dessert_name   = wc_get_product( $dessert_id )->get_title();

            if ( ! empty( $side_id ) ) {
                $side_locked = ( strtolower($side_locked) == 'on' ) ? 'ON' : 'OFF';
                update_post_meta( $product_id, 'default_side', $side_name );
                update_post_meta( $product_id, 'default_side_id', $side_id );
                update_post_meta( $product_id, 'default_side_lock', $side_locked );
            }

            if ( ! empty( $vegetable_id ) ) {
                $vegetable_locked = ( strtolower($vegetable_locked) == 'on' ) ? 'ON' : 'OFF';
                update_post_meta( $product_id, 'default_vegetable', $vegetable_name );
                update_post_meta( $product_id, 'default_vegetable_id', $vegetable_id );
                update_post_meta( $product_id, 'default_vegetable_lock', $vegetable_locked );
            }

            if ( ! empty( $salad_id ) ) {
                $salad_locked = ( strtolower($salad_locked) == 'on' ) ? 'ON' : 'OFF';
                update_post_meta( $product_id, 'default_salad', $salad_name );
                update_post_meta( $product_id, 'default_salad_id', $salad_id );
                update_post_meta( $product_id, 'default_salad_lock', $salad_locked );
            }

            if ( ! empty( $bread_id ) ) {
                $bread_locked = ( strtolower($bread_locked) == 'on' ) ? 'ON' : 'OFF';
                update_post_meta( $product_id, 'default_bread', $bread_name );
                update_post_meta( $product_id, 'default_bread_id', $bread_id );
                update_post_meta( $product_id, 'default_bread_lock', $bread_locked );
            }

            if ( ! empty( $dessert_name ) ) {
                $dessert_locked = ( strtolower($dessert_locked) == 'on' ) ? 'ON' : 'OFF';
                update_post_meta( $product_id, 'default_dessert', $dessert_name );
                update_post_meta( $product_id, 'default_dessert_id', $dessert_id );
                update_post_meta( $product_id, 'default_dessert_lock', $dessert_locked );
            }
        }
    }

    /**
     * Checks if a product is a Complete Meal.
     *
     * @param $post_id int
     * @return bool
     */
    public function is_meal( $post_id = null ) {
        $id = $post_id ? $post_id :get_the_ID();
        $terms = get_the_terms( $id, 'product_cat' );
        $slugs = array();
        if(isset($terms) && is_array($terms)) {
            foreach ($terms as $term) {
                array_push($slugs, $term->slug);
            }
            if(in_array('recipients-choice', $slugs)) {
                return false;
            }
            if (in_array('complete-meals', $slugs) || in_array('deluxe-meals', $slugs) || in_array('gluten-free-meals', $slugs) ||
                in_array('deluxe-gf-meals', $slugs) || in_array('standard-gf-meals', $slugs) || in_array('premium-meals', $slugs) ||
                in_array('standard-meals', $slugs) || in_array('vegan-meals', $slugs) || in_array('vegetarian-meals', $slugs)) {
                return true;
            }
        }
        return false;
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
     * Adds the global sides lock button.
     *
     * @param $settings
     * @param $current_section
     *
     * @return mixed
     */
    public function add_global_sides_lock($settings, $current_section) {
        // Checking if the current section is what we want.
        if($current_section == 'wcsides') {
            $sides_settings = array();

            //Add Title to the settings tab.
            $sides_settings[] = array(
                'name' => __('WC Sides Settings', 'text-domain'),
                'type' => 'title',
                'desc' => __('The following options are to configure WC Sides', 'text-domain'),
                'id' => 'wcslider'
            );

            //Add global lock checkbox.
            $sides_settings[] = array(
                'name' => __('Lock all sides on all meals.', 'text-domain'),
                'desc_tip' => __('This will automatically locks all sides on all meals. User will not be able to change default sides.', 'text-domain'),
                'id' => 'wcsides_global_lock',
                'type' => 'checkbox',
                'css' => 'min-width:300px;',
                'desc' => __('Lock all sides ', 'text-domain'),
            );


            $sides_settings[] = array(
                'type' => 'sectionend',
                'id' => 'wcsides'
            );

            return $sides_settings;
        } else {
            return $settings;
        }
    }

    /**
     * Add sides configuration section on WC settings.
     *
     * @param $sections
     *
     * @return mixed
     */
    public function add_wc_sides_section($sections) {

        $sections['wcsides'] = __('Sides', 'text-domain');
        return $sections;

    }


    /**
     * Edit Order Item to display editable sides.
     *
     * @param $item_id
     * @param $item
     * @param $product
     *
     * @return void
     */
    public function edit_sides_on_order($item_id, $item, $product) {
        $item_metas = $item->get_formatted_meta_data();
        if(!is_null($product) && $product->post_type == 'product_variation') {
            if($this->is_meal($item['product_id'])) {
                $isGlutenFree         = $this->isGlutenFree($item['product_id']);
                $isDeluxe             = $this->isDeluxe($item['product_id']);
                $available_sides      = $this->get_sides('standard-sides', $isGlutenFree);
                $available_breads     = $this->get_sides('bread', $isGlutenFree);
                $available_desserts   = $this->get_sides('dessert', $isGlutenFree);
                $available_vegetables = $this->get_sides('vegetables');
                if ($isDeluxe) {
                    $available_sides    = $this->get_sides( 'deluxe-sides');
                    $available_salads = $this->get_sides('deluxe-salads');
                    $available_vegetables = $this->get_sides('deluxe-vegetables');
                } else {
                    $available_salads = $this->get_sides('standard-salads');
                }
                $product_default_sides = $this->getProductDefaultSides($item);

                $AllSideOptionsArray = array_merge($available_sides,$available_vegetables,$available_salads, $available_breads, $available_desserts);

                if (count($item_metas)) {
                    $new_html = "<table cellspacing='0' class='display_meta edit_sides_form_{$item_id}' style='display:none;'>";
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'side');
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'vegetable');
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'salad');
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'bread');
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'dessert');
                    $new_html .= "</table>";

                    echo "<h4>Sides <span class='edit_item_sides'><a href='#' class='edit_sides_link' data-id='{$item_id}'>Edit</a></span></h4>" . $new_html;  //<span class='edit_item_sides'><a href='#' class='edit_sides_link' data-id='{$item_id}'>Edit</a></span>

                    return;
                } else {
                    $new_html = "<table cellspacing='0' class='display_meta edit_sides_form_{$item_id}'>";
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'side', true);
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'vegetable', true);
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'salad', true);
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'bread', true);
                    $new_html .= $this->edit_sides_select($AllSideOptionsArray, $item_metas, $product_default_sides, $item_id, 'dessert', true);
                    $new_html .= "</table>";

                    echo "<h4>Sides</h4>" . $new_html;

                    return;
                }
            }
        }
    }

    /**
     * Add default sides as inserted to new order.
     *
     * @param $item_id
     * @param $item
     * @param $order_id
     */
    public function add_default_sides_to_item($item_id, $item, $order_id) {
        $product_default_sides = $this->getProductDefaultSides($item);
        $product_id = $item['product_id'];
        $order = new WC_Order($order_id);
        $product = new WC_Product($product_id);
        if(isset($item['variation_id']) && $item['variation_id'] != 0) {
            $variation_id = $item['variation_id'];
            $variation = new WC_Product_Variation($variation_id);
            if($this->is_meal($variation_id)) {
                $order->add_order_note('Added order item "' . $variation->get_formatted_name() . '"', 0, true);
            }
        } else {
            if($this->is_meal($product_id)) {
                $order->add_order_note('Added order item "' . $product->get_formatted_name() . '"', 0, true);
            }
        }

        if($this->is_meal($product_id)) {
            foreach ($product_default_sides as $key => $value) {
                if ( ! empty($value) && strcmp($value, 'none') != 0) {
                    if ( ! wc_get_order_item_meta($item_id, $key)) {
                        wc_add_order_item_meta($item_id, $key, $value);
                    }
                }
            }
        }
        return;
    }

    public function log_deleted_order_item($item_id) {

        $order_item = new WC_Order_Item_Product($item_id);
        $product_id = $order_item->get_product_id();
        $product = new WC_Product($product_id);
        $order = $order_item->get_order();
        if($variation_id = $order_item->get_variation_id()) {
            $variation = new WC_Product_Variation($variation_id);
            $order->add_order_note('Removed order item "' . $variation->get_formatted_name() . '"', 0, true);
        } else {
            $order->add_order_note('Removed order item "' . $product->get_formatted_name() .'"', 0, true);
        }
        return;
    }

    /**
     * Get the right select format for each side.
     * @param $options
     * @param $metas
     * @param $defaults
     * @param $item_id
     * @param $label
     * @param $isCreated
     *
     * @return string
     */
    private function edit_sides_select($options, $metas, $defaults, $item_id, $label, $isCreated = false) {
        $html        = "<tr>";
        $formatted_label = ucfirst($label);
        
        $html        .= "<td><label class='wc-item-meta-label'><b>{$formatted_label}</b></label></td>";
        $html        .= "<td><select class='create_sides_select' style='width:100%;' data-label='{$label}' data-id='{$item_id}'>";

        $html .= "<option value='none' >None</option>";
        foreach ($options as $side) {
            $selected = ( $this->hasMetaValue($metas, $label, $side['title']) || $this->useProductDefault($defaults, $isCreated, $label, $side['title']) ) ? 'selected' : '';
            $html .= "<option value='{$side['title']}' {$selected}>{$side['title']}</option>";
        }
        $html .= "</select></td>";
        $html .= "</tr>";
        return $html;
    }

 
    private function useProductDefault($defaults, $isCreated, $label, $value) {
        if($isCreated) {
            if((!empty($defaults[$label]) && strcmp($defaults[$label],$value) == 0)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the current side has a selected value.
     * @param $metas
     * @param $key
     * @param $value
     *
     * @return bool
     */
    private function hasMetaValue($metas, $key, $value) {
        foreach($metas as $meta_id => $meta) {
            $meta_value           = $meta->value;
            $meta_key           = $meta->key;
            if(strcmp($meta_value, $value) == 0 && strcmp($meta_key, $key) == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the parent product default sides.
     * @param $item
     *
     * @return array
     */
    private function getProductDefaultSides($item) {
        $product_id = $item['product_id'];
        $default_sides = array();
        $default_sides['side'] = get_post_meta($product_id, 'default_side',true);
        $default_sides['vegetable'] = get_post_meta($product_id, 'default_vegetable',true);
        $default_sides['salad'] = get_post_meta($product_id, 'default_salad',true);
        $default_sides['bread'] = get_post_meta($product_id, 'default_bread',true);
        $default_sides['dessert'] = get_post_meta($product_id, 'default_dessert',true);
        return $default_sides;
    }

    /**
     * Displays the sides button and modal on the products page.
     * TODO: consider putting data for modal in an AJAX call when "Pick your sides" is clicked
     */
    public function display_sides_modal() {
        $product_id = get_the_ID();
        $is_side    = false;
        $terms      = get_the_terms( $product_id, 'product_cat' );
        
        if(is_array($terms)) {
            foreach ($terms as $term) {
                if (in_array($term->slug, array(
                    'a-la-carte',
                    'standard-sides',
                    'vegetables',
                    'dessert',
                    'deluxe-entree',
                    'bread',
                    'salads',
                    'standard-entrees',
                    'vegetarian-entrees'
                ))) {
                    $is_side = true;
                }
            }


            if ( ! $is_side) {
                // these vars are used in the view
                $isGlutenFree = $this->isGlutenFree($product_id);
                $isDeluxe     = $this->isDeluxe($product_id);

                //$available_sides    = $this->get_sides('standard-sides', $isGlutenFree);
                $available_breads   = $this->get_sides('bread', $isGlutenFree);
                $available_desserts = $this->get_sides('dessert', $isGlutenFree);
                if ($isDeluxe) {
                    $available_sides    = $this->get_sides('deluxe-sides');
                    $available_salads     = $this->get_sides('deluxe-salads');
                    $available_vegetables = $this->get_sides('deluxe-vegetables');
                } else {
                    $available_sides    = $this->get_sides('standard-sides');
                    $available_salads     = $this->get_sides('standard-salads');
                    $available_vegetables = $this->get_sides('vegetables');
                }

                $global_lock            = get_option('wcsides_global_lock');
                $default_side           = $this->get_default($product_id, 'default_side');
                $default_side_id        = $this->get_default( $product_id, 'default_side_id' );
                $default_side_lock      = $this->get_default($product_id, 'default_side_lock');
                $default_vegetable      = $this->get_default($product_id, 'default_vegetable');
                $default_vegetable_id   = $this->get_default( $product_id, 'default_vegetable_id' );
                $default_vegetable_lock = $this->get_default($product_id, 'default_vegetable_lock');
                $default_salad          = $this->get_default($product_id, 'default_salad');
                $default_salad_id       = $this->get_default( $product_id, 'default_salad_id' );
                $default_salad_lock     = $this->get_default($product_id, 'default_salad_lock');
                $default_bread          = $this->get_default($product_id, 'default_bread');
                $default_bread_id       = $this->get_default( $product_id, 'default_bread_id' );
                $default_bread_lock     = $this->get_default($product_id, 'default_bread_lock');
                $default_dessert        = $this->get_default($product_id, 'default_dessert');
                $default_dessert_id     = $this->get_default( $product_id, 'default_dessert_id' );
                $default_dessert_lock   = $this->get_default($product_id, 'default_dessert_lock');
                // this line could break other plugins that reference this filter, still need a return...
                include_once(__DIR__ . '/../public/partials/products/sides-section.php');
            }
        }
    }

    /**
     * Add the side items to the cart.
     *
     * @param $cart_item_data
     * @param $product_id
     * @param $variation_id
     *
     * @return mixed
     */
    public function add_sides_to_cart( $cart_item_data, $product_id, $variation_id ) {
        
        if ( ! empty( $_POST['side'] ) ) {
            $cart_item_data['side']    = wc_clean( $_POST['side'] );
            $cart_item_data['side_id'] = wc_clean( $_POST['side-id'] );
        }

        if ( ! empty( $_POST['vegetable'] ) ) {
            $cart_item_data['vegetable']    = wc_clean( $_POST['vegetable'] );
            $cart_item_data['vegetable_id'] = wc_clean( $_POST['vegetable-id'] );
        }

        if ( ! empty( $_POST['salad'] ) ) {
            $cart_item_data['salad']    = wc_clean( $_POST['salad'] );
            $cart_item_data['salad_id'] = wc_clean( $_POST['salad-id'] );
        }

        if ( ! empty( $_POST['bread'] || !empty($_POST['bread-radio']) ) ) {

            $cart_item_data['bread']    = (wc_clean( $_POST['bread'] )) ? wc_clean( $_POST['bread'] ) :  wc_clean( $_POST['bread-radio'] );
            $cart_item_data['bread_id'] = (wc_clean( $_POST['bread-id'] )) ? wc_clean( $_POST['bread-id'] ) : wc_clean( $_POST['bread-id-choice'] );
        }

        if ( ! empty( $_POST['dessert'] || !empty($_POST['dessert-radio']) )  ) {
            $cart_item_data['dessert']    = (wc_clean( $_POST['dessert'] ))?wc_clean( $_POST['dessert'] ) : wc_clean( $_POST['dessert-radio'] );
            $cart_item_data['dessert_id'] = (wc_clean( $_POST['dessert-id'] )) ? wc_clean( $_POST['dessert-id'] ) : wc_clean( $_POST['dessert-id-choice'] );
        }

        return $cart_item_data;
    }

    /**
     * Display the sides in the cart page.
     *
     * @param $product_name
     * @param $cart_item
     * @param $cart_item_key
     *
     * @return mixed
     */
    public function display_sides_in_cart( $product_name, $cart_item, $cart_item_key ) {
        if ( empty( $cart_item['side'] ) &&
             empty( $cart_item['salad'] ) &&
             empty( $cart_item['bread'] ) &&
             empty( $cart_item['dessert'] ) &&
             empty($cart_item['number_of_deliveries'])) {
            return $product_name;
        } else {
            ob_start();
            include __DIR__ . '/../public/partials/cart/product_name.php';
            include __DIR__ . '/../public/partials/cart/sides.php';
            $result = ob_get_clean();
            return $result;
        }
    }

    /**
     * Saves the data to the order when it is processed.
     *
     * @param $item
     * @param $cart_item_key
     * @param $values
     * @param $order
     */
    public function add_sides_to_order_items( $item, $cart_item_key, $values, $order ) {
        if ( ! empty( $values['side'] ) ) {
            $item->add_meta_data( __( 'side' ), $values['side'] );
        }

        if ( ! empty( $values['vegetable'] ) ) {
            $item->add_meta_data( __( 'vegetable' ), $values['vegetable'] );
        }

        if ( ! empty( $values['salad'] ) ) {
            $item->add_meta_data( __( 'salad' ), $values['salad'] );
        }

        if ( ! empty( $values['bread'] ) ) {
            $item->add_meta_data( __( 'bread' ), $values['bread'] );
        }

        if ( ! empty( $values['dessert'] ) ) {
            $item->add_meta_data( __( 'dessert' ), $values['dessert'] );
        }
    }
}
