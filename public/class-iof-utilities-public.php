<?php


class Iof_Utilities_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// TODO: don't use this CSS 'compiler' in production OR cache and don't compile every page load
		// TODO: for production, you can simply copy over the combined CSS file
		$options = array(
			"ssl" => array(
				"verify_peer"      => false,
				"verify_peer_name" => false
			)
		);

		$files         = glob( __DIR__ . '/css/*.css' );
		$combined_file = '';
		foreach ( $files as $file ) {
			$combined_file .= file_get_contents( $file, false, stream_context_create( $options ) );
		}
		file_put_contents( __DIR__ . "/css/combined/iof-public.css", $combined_file );
		// only the line below should be in production
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/combined/iof-public.css', array(), time(), 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// TODO: don't use this JS 'compiler' in production OR cache and don't compile every page load
		// TODO: for production, you can simply copy over the combined JS file
		$options = array(
			"ssl" => array(
				"verify_peer"      => false,
				"verify_peer_name" => false
			)
		);

		$files         = glob( __DIR__ . '/js/*.js' );

		$combined_file = "(function($){'use strict';$(function(){";
		foreach ( $files as $file ) {
			$combined_file .= file_get_contents( $file, false, stream_context_create( $options ) );
		}
		$combined_file .= "});})( jQuery );";
		file_put_contents( __DIR__ . "/js/combined/iof-public.js", $combined_file );

		
		// only the line below should be in production
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/combined/iof-public.js', array( 'jquery' ), time(), false );


	}

	/**
	 * Register this in the loader if you ever need AJAX on the public side.
	 */
	public function localize_scripts() {
		wp_localize_script( $this->plugin_name, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function change_order_status($order_id) {
	    $order = wc_get_order($order_id);
	    $order->update_status('on-hold');
    }

	/**
	 * Display custom product images on product listing (shop) pages.
	 */
    public function display_product_image() {
		$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	    include( __DIR__ . '/partials/products/product-image.php' );
    }

	/**
	 * Modify the additional info tab to be the Heating Instructions tab.
	 *
	 * @param array $tab        The original tab.
	 *
	 * @return array            The modified tab.
	 */
    public function heating_instructions_tab( &$tab ) {
		$tab['title'] = 'Nutritional and Heating Information';
    }

	/**
	 * Shows the lowest price for a product on the product listings page.
	 */
    public function adjust_product_price() {
	    $product_id = get_the_ID();
	    $product    = wc_get_product( $product_id );
	    $price      = number_format( $product->get_price(), 2 );
	    include( __DIR__ . '/partials/products/price.php' );
    }

	/**
	 * Bootstrap footer.
	 */
    public function iof_footer_menu() {
    	//include __DIR__ . '/partials/footer/menu.php';
    }
}