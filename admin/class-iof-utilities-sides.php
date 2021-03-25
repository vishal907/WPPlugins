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
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iof-utilities-admin.css', array(), 11, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iof-utilities-admin.js', array( 'jquery' ), 36, false );
    }

    // TODO: start breaking these functions into separate classes, perhaps Iof_Product_Helper to start

    /**
     * Adds the Sides panel tab on product page under Product Data.
     */
    public function add_product_sides_panel_tab() {
        if ( $this->is_meal() ) {
            include_once( 'partials/product/tabs/sides-tab.php' );
        }
    }

    /**
     * Adds the Sides panel data on product page under Product Data.
     */
    public function add_product_sides_panel_data() {
        // these vars are used in the view
        $product_id         = get_the_ID();
        $available_sides    = $this->get_sides();
        $available_salads   = $this->get_sides( 'salads' );
        $available_breads   = $this->get_sides( 'bread' );
        $available_desserts = $this->get_sides( 'dessert' );
        $default_side_1     = $this->get_default( $product_id, 'default_side_1' );
        $default_side_1_lock     = $this->get_default( $product_id, 'default_side_1_lock' );
        $default_side_2     = $this->get_default( $product_id, 'default_side_2' );
        $default_side_2_lock     = $this->get_default( $product_id, 'default_side_2_lock' );
        $default_salad      = $this->get_default( $product_id, 'default_salad' );
        $default_salad_lock     = $this->get_default( $product_id, 'default_salad_lock' );
        $default_bread      = $this->get_default( $product_id, 'default_bread' );
        $default_bread_lock     = $this->get_default( $product_id, 'default_bread_lock' );
        $default_dessert    = $this->get_default( $product_id, 'default_dessert' );
        $default_dessert_lock     = $this->get_default( $product_id, 'default_dessert_lock' );
        include_once( 'partials/product/tabs/sides-panel.php' );
    }

    /**
     * Gets the side items for selection.
     * TODO: this is the same as the public function
     * @param $category string      The woocommerce product category to filter by.
     *
     * @return array
     */
    private function get_sides( $category = 'standard-sides' ) {
        $sides      = new WP_Query( array( 'post_type' => 'product', 'product_cat' => $category ) );
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
            $side1   = wc_clean( $_POST["default_side_1"] );
            $side1_locked   = wc_clean( $_POST["default_side_1_lock"] );

            $side2   = wc_clean( $_POST["default_side_2"] );
            $side2_locked   = wc_clean( $_POST["default_side_2_lock"] );

            $salad   = wc_clean( $_POST["default_salad"] );
            $salad_locked   = wc_clean( $_POST["default_salad_lock"] );

            $bread   = wc_clean( $_POST["default_bread"] );
            $bread_locked   = wc_clean( $_POST["default_bread_lock"] );

            $dessert = wc_clean( $_POST["default_dessert"] );
            $dessert_locked = wc_clean( $_POST["default_dessert_lock"] );

            update_post_meta( $product_id, 'default_side_1', $side1 );
            update_post_meta( $product_id, 'default_side_1_lock', $side1_locked );
            update_post_meta( $product_id, 'default_side_2', $side2 );
            update_post_meta( $product_id, 'default_side_2_lock', $side2_locked );
            update_post_meta( $product_id, 'default_salad', $salad );
            update_post_meta( $product_id, 'default_salad_lock', $salad_locked );
            update_post_meta( $product_id, 'default_bread', $bread );
            update_post_meta( $product_id, 'default_bread_lock', $bread_locked );
            update_post_meta( $product_id, 'default_dessert', $dessert );
            update_post_meta( $product_id, 'default_dessert_lock', $dessert_locked );
        }

        if ( ! empty( $_POST["product_id"] ) ) {
            die( "complete" );
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
            if (in_array('complete-meals', $slugs)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Adds the global sides lock button.
     * @param $settings
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
     * @param $sections
     */
    public function add_wc_sides_section($sections) {

        $sections['wcsides'] = __('Sides', 'text-domain');
        return $sections;

    }

    /**
     * Edit Order Item to display editable sides.
     * @param $html
     * @param $items
     * @param $args
     */
    public function edit_sides_on_order($item_id, $item, $product) {
        $item_metas = $item->get_formatted_meta_data();
        if(isset($product->post_type) && $product->post_type == 'product_variation') {
            if (count($item_metas)) {
                $new_html = "<table cellspacing='0' class='display_meta edit_sides_form_{$item_id}' style='display:none;'>";
                $available_sides = $this->get_sides();
                $available_salads   = $this->get_sides( 'salads' );
                $available_breads   = $this->get_sides( 'bread' );
                $available_desserts = $this->get_sides( 'dessert' );
                foreach ($item_metas as $meta_id => $meta) {
                    $new_html        .= "<tr>";
                    $key             = $meta->display_key;
                    $value           = $meta->value;
                    $new_html        .= "<td><label class='wc-item-meta-label'>" . $key . "</label></td>";
                    $new_html        .= "<td><select class='edit_sides_select' style='width:100%;' data-label='{$key}'>";
                    if ($key == 'side-one' || $key == 'side-two') {
                        foreach ($available_sides as $side) {
                            $selected = ($side['title'] == $value) ? 'selected' : '';
                            $new_html .= "<option value='{$side['title']}' {$selected}>{$side['title']}</option>";
                        }
                    } elseif($key == 'salad') {
                        foreach ($available_salads as $side) {
                            $selected = ($side['title'] == $value) ? 'selected' : '';
                            $new_html .= "<option value='{$side['title']}' {$selected}>{$side['title']}</option>";
                        }
                    } elseif($key == 'bread') {
                        foreach ($available_breads as $side) {
                            $selected = ($side['title'] == $value) ? 'selected' : '';
                            $new_html .= "<option value='{$side['title']}' {$selected}>{$side['title']}</option>";
                        }
                    } elseif($key == 'dessert') {
                        foreach ($available_desserts as $side) {
                            $selected = ($side['title'] == $value) ? 'selected' : '';
                            $new_html .= "<option value='{$side['title']}' {$selected}>{$side['title']}</option>";
                        }
                    }
                    $new_html .= "</select></td>";
                    $new_html .= "</tr>";
                }
                $new_html .= "</table>";

                echo "<h4>Sides <span class='edit_item_sides'><a href='#' class='edit_sides_link' data-id='{$item_id}'>Edit</a></span></h4>" . $new_html;
                return;
            } else {
                return;
            }
        }
    }
}
