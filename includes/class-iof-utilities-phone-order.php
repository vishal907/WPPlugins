<?php


class Iof_Utilities_Phone_Order {

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

    public function add_phone_order_link($wp_admin_bar) {
        $args = array(
            'id' => 'iof_phone_order',
            'title' => 'Phone Order',
            'href' => '/wp-admin/post-new.php?post_type=shop_order',
            'meta' => array(
                'class' => 'iof_phone_order',
                'title' => 'Phone Order'
            )
        );
        $wp_admin_bar->add_node($args);
    }

    public function process_search_results() {
        if(isset($_POST['data']) && !empty($_POST['data'])) {
            $results = $_POST['data'];
            $html = "";
            $i=0;
            foreach($results as $key => $value) {
                $i++;
                $_pf = new WC_Product_Factory();
                $_product = $_pf->get_product($key);
                if($_product->is_type('variable')) {
                    $variations   = $_product->get_available_variations();
                    $html .= '<div class="thumbnail" style="cursor: pointer; max-width:150px; min-height:233px; display:inline-block; margin:10px;
                    vertical-align:top; position:relative;">';
                    $html .= '<div style="width: 150px; overflow:hidden;">' . $_product->get_image() . '</div>';
                    $html .= '<div class="caption">';

                    $html .= '<p><select id="iof-phone-order-variations_'. $_product->get_id() .'">';
                    foreach ($variations as $variation) {
                        $tmp = wc_get_product($variation['variation_id']);
                        $formatted_name = $tmp->get_formatted_name();
                        $html .= '<option value="' . $variation['variation_id'] . '">' . $formatted_name . '</option>';
                    }
                    $html .= '</select></p>';

                    $html .= '<div class="checkbox checkbox-success">';
                    $html .= '<input type="button" class="button iof-add-product button-primary" data-product_has_variations="1" data-product_id="' .
                             $_product->get_id() . '" name="save" value="Add" style="width:100%;">';
                    $html .= '</div>';
                    $html .= '<p>' . $_product->get_name() . '</p>';
                    $html .= '</div>';
                    $html .= '</div>';
                } elseif($_product->is_type('simple')) {
                    $html .= '<div class="thumbnail" style="cursor: pointer; max-width:150px; min-height:233px; display:inline-block; margin:10px;
                    vertical-align:top; position:relative;">';
                    $html .= '<div style="width: 150px; overflow:hidden;">' . $_product->get_image() . '</div>';
                    $html .= '<div class="caption">';

                    $html .= '<div class="checkbox checkbox-success">';
                    $html .= '<input type="button" class="button iof-add-product button-primary" data-product_has_variations data-product_id="' .
                             $_product->get_id() . '" name="save" value="Add" style="width:100%;">';
                    $html .= '</div>';
                    $html .= '<p>' . $_product->get_name() . '</p>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
                if($i == 16) {
                    break;
                }
            }
            die($html);
        }
        die('No products found!');
    }

    public function custom_phone_order_box($object) {
        $categories = get_terms('product_cat');
        $grouped_categories = $this->group_categories($categories);
        $products = isset($grouped_categories[0]['parent']->slug) ? $this->get_products($grouped_categories[0]['parent']->slug, 14) : $this->get_products();
        $current_page = get_current_screen();
        $order = new WC_Order($object->ID);
        if( ($current_page->id == 'shop_order')) {
            ?>
            <div class="iof-product_data panel-wrap">
                <select name="iof-product-cat" id="iof-product-cat" style="vertical-align: top;">
                    <?php foreach ($grouped_categories as $group) { ?>
                        <option value="<?= $group['parent']->slug ?>"><?php echo $group['parent']->name; ?></option>
                        <?php foreach ($group['children'] as $category) { ?>
                            <option value="<?= $category->slug ?>">&nbsp;&nbsp;&nbsp;<?php echo $category->name . ' (' . $category->count . ')'; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <input type="text" placeholder="Search All Product..." name="iof_product_search" id="iof_product_search">
                <div class="container" id="iof-phone-order-container" style="padding:20px;">
                    <?php $n = 0;
                    foreach ($products as $product) {
                        $n++; ?>
                        <div class="thumbnail" style="cursor: pointer; max-width:150px; min-height:233px; display:inline-block; margin:10px;
                    vertical-align:top; position:relative;">
                            <?php
                            $_pf          = new WC_Product_Factory();
                            $_product     = $_pf->get_product($product['id']);
                            $has_children = false;
                            $variations   = array();
                            if ($_product->has_child()) {
                                $has_children = true;
                                $variations   = $_product->get_available_variations();
                            }
                            ?>
                            <?php echo $product["image"]; ?>
                            <div class="caption">
                                <?php if ($has_children) { ?>
                                    <p>
                                        <select id="iof-phone-order-variations_<?= $product['id'] ?>">
                                            <?php foreach ($variations as $variation) {
                                                $tmp            = wc_get_product($variation['variation_id']);
                                                $formatted_name = $tmp->get_formatted_name();
                                                ?>
                                                <option value="<?= $variation['variation_id'] ?>"><?php echo $formatted_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </p>
                                <?php } ?>
                                <div class="checkbox checkbox-success">
                                    <input type="button" class="button iof-add-product button-primary" data-product_has_variations="<?= $has_children ?>"
                                           data-product_id="<?= $product['id'] ?>" name="save" value="Add" style="width:100%;">
                                </div>
                                <p><?php echo $product["title"]; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        } else {
            echo '<h5>You can only add products while the order status is pending payment.</h5>';
        }
    }

    public function pull_products_by_category() {
        if(isset($_POST['cat_slug']) && !empty($_POST['cat_slug'])) {
            $slug = $_POST['cat_slug'];
            $products = $this->get_products($slug);
            $html = "";
            foreach($products as $product) {
                $_pf = new WC_Product_Factory();
                $_product = $_pf->get_product($product['id']);
                $has_children = false;
                $variations = array();
                if($_product->has_child()) {
                    $has_children = true;
                    $variations = $_product->get_available_variations();
                }

                $html .= '<div class="thumbnail" style="cursor: pointer; max-width:150px; min-height:233px; display:inline-block; margin:10px;
                    vertical-align:top; position:relative;">';
                $html .= $product['image'];
                $html .= '<div class="caption">';
                if($has_children) {
                    $html .= '<p><select id="iof-phone-order-variations_'.$product['id'].'">';
                    foreach ($variations as $variation) {
                        $tmp = wc_get_product($variation['variation_id']);
                        $formatted_name = $tmp->get_formatted_name();
                        $html .= '<option value="' . $variation['variation_id'] . '">' . $formatted_name . '</option>';
                    }
                    $html .= '</select></p>';
                }
                $html .= '<div class="checkbox checkbox-success">';
                $html .= '<input type="button" class="button iof-add-product button-primary" data-product_has_variations="'.$has_children.'" data-product_id="' .
                         $product['id'] . '" name="save" value="Add" style="width:100%;">';
                $html .= '</div>';
                $html .= '<p>' . $product['title'] . '</p>';
                $html .= '</div>';
                $html .= '</div>';
            }
            die($html);
        }
        die('No slug provided!');
    }

    private function group_categories($categories = array()) {
        $result = array();
        $tmp_categories = $categories;
        foreach($categories as $category) {
            if(!$category->parent) {
                $tmp = array();
                $tmp['parent'] = $category;
                foreach($tmp_categories as $tmp_category) {
                    if($tmp_category->parent == $category->term_id) {
                        $tmp['children'][] = $tmp_category;
                    }
                }
                $result[] = $tmp;
            }
        }
        return $result;
    }

    private function get_products( $category = 'standard-meals', $limit = -1) {

        $args = array(
            'posts_per_page' => $limit,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category
                )
            ),
            'post_type' => 'product',
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $products      = new WP_Query( $args );
        $products_data = array();

        while ( $products->have_posts() ) {
            $products->the_post();
            array_push(
                $products_data,
                array(
                    'id' => $products->post->ID,
                    'slug'  => $products->post->post_name,
                    'link'  => get_permalink(),
                    'image' => get_the_post_thumbnail( $products->post->ID, 'thumbnail' ),
                    'title' => get_the_title()
                )
            );
        }
        wp_reset_query();

        return $products_data;
    }
}
