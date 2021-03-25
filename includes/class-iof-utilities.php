<?php


class Iof_Utilities {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Iof_Utilities_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The single instance of the class.
	 *
	 * @var     Iof_Utilities
	 */
	protected static $_instance;

	/**
	 * Reference to the dates class.
	 *
	 * @var Iof_Utilities_Delivery_Dates
	 */
	public $dates;

	/**
	 * Reference to the public class.
	 *
	 * @var Iof_Utilities_Public
	 */
	public $public;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_VERSION' ) ) {
			$this->version = PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'iof-utilities';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Main IoF Instance.
	 *
	 * Ensures only one instance of IoF is loaded or can be loaded.
	 *
	 * @return Iof_Utilities - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Iof_Utilities_Loader. Orchestrates the hooks of the plugin.
	 * - Iof_Utilities_i18n. Defines internationalization functionality.
	 * - Iof_Utilities_Admin. Defines all hooks for the admin area.
	 * - Iof_Utilities_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-iof-utilities-admin.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-sides.php';

        /**
         * The class responsible for the phone order box.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-phone-order.php';

		/**
		 * The class responsible for defining all actions that occur for delivery dates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-delivery-dates.php';

        /**
         * The class responsible for defining all actions that occur for recipient choices.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-recipient-choices.php';

        /**
         * The class responsible for defining all actions that occur for block-out dates.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-blockout-dates.php';

        /**
         * The class responsible for defining all actions that occur for delivery report.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-reports.php';

        /**
         * The class responsible for defining all actions that occur for note cards.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-note-cards.php';

          /**
         * The class responsible for defining all actions that occur for package slips.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-sales-reports.php'; 

        /**
         * The class responsible for defining all actions that occur for package slips.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-all-sales-reports.php';

         /**
         * The class responsible for defining all actions that occur for package slips.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-package-slips.php';

         /**
         * The class responsible for defining all actions that occur for Redevelopement Kitchen Reports.
         */
        //require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-redevelop-kr.php';


         /**
		 * The class responsible for defining all actions that occur in the admoin-facing
		 * RC Expire Setting of the admin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-rc-expire.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-iof-utilities-public.php';


		/**
         * The class responsible for defining all actions that occur for quickbook.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iof-utilities-all-quickbook-reports.php';




		$this->loader = new Iof_Utilities_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Iof_Utilities_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Iof_Utilities_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Iof_Utilities_Admin( $this->get_plugin_name(), $this->get_version() );
        $plugin_sides = new Iof_Utilities_Sides( $this->get_plugin_name(), $this->get_version() );
        $plugin_phone_order = new Iof_Utilities_Phone_Order( $this->get_plugin_name(), $this->get_version() );
        $plugin_recipient_choices  = new Iof_Utilities_Recipient_Choices( $this->get_plugin_name(), $this->get_version() );
        $plugin_block_out_dates = new Iof_Utilities_Blockout_Dates( $this->get_plugin_name(), $this->get_version() );
        $plugin_reports = new Iof_Utilities_Reports($this->get_plugin_name(), $this->get_version());
        $plugin_cards = new Iof_Utilities_NoteCards($this->get_plugin_name(), $this->get_version());
        $plugin_slips = new Iof_Utilities_packageSlips($this->get_plugin_name(), $this->get_version());
        $plugin_sales_report = new Iof_Utilities_salesReport($this->get_plugin_name(), $this->get_version());
        $plugin_rc_expire = new Iof_Utilities_rcExpire($this->get_plugin_name(), $this->get_version());
        $plugin_all_sales_report = new Iof_Utilities_allSalesReport($this->get_plugin_name(), $this->get_version());

        $plugin_all_quickbook_report = new Iof_Utilities_allQuickBookReport($this->get_plugin_name(), $this->get_version());
        
        //$plugin_re_develop_kitchen_report = new Iof_Utilities_rdKRReport($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'add_admin_topbar_search_forms', 9999 );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'remove_admin_topbar_items', 999 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'restrict_admin_menu_items', 999 );

		$this->loader->add_action( 'woocommerce_product_write_panel_tabs', $plugin_sides, 'add_product_sides_panel_tab' );
		$this->loader->add_action( 'woocommerce_product_data_panels', $plugin_sides, 'add_product_sides_panel_data' );
		$this->loader->add_action( 'wp_ajax_save_product_sides_meta', $plugin_sides, 'save_product_sides_meta' );
//		$this->loader->add_action( 'woocommerce_process_product_meta_simple', $plugin_sides, 'save_product_sides_meta' );
//		$this->loader->add_action( 'woocommerce_process_product_meta_variable', $plugin_sides, 'save_product_sides_meta' );
//		$this->loader->add_action( 'woocommerce_process_product_meta_grouped', $plugin_sides, 'save_product_sides_meta' );
//		$this->loader->add_action( 'woocommerce_process_product_meta_external', $plugin_sides, 'save_product_sides_meta' );

		$this->loader->add_filter( 'woocommerce_get_sections_products', $plugin_sides, 'add_wc_sides_section');
		$this->loader->add_filter( 'woocommerce_get_settings_products', $plugin_sides, 'add_global_sides_lock', 10, 2);

		$this->loader->add_action( 'woocommerce_before_order_itemmeta', $plugin_sides, 'edit_sides_on_order', 10, 3);
        $this->loader->add_action( 'woocommerce_new_order_item', $plugin_sides, 'add_default_sides_to_item', 10, 3);
        $this->loader->add_action( 'woocommerce_before_delete_order_item', $plugin_sides, 'log_deleted_order_item', 10, 1);

//        $this->loader->add_action( 'save_post', $plugin_sides, 'update_product_sides' );

        $this->loader->add_meta_box('iof-phone-order', $plugin_phone_order, 'custom_phone_order_box', 'shop_order', 'normal', 'low', 'Product');
        $this->loader->add_action( 'wp_ajax_phone_order_product_by_cat', $plugin_phone_order, 'pull_products_by_category' );
        $this->loader->add_action( 'wp_ajax_iof_process_phone_order_search', $plugin_phone_order, 'process_search_results' );
//        $this->loader->add_action( 'admin_bar_menu', $plugin_phone_order, 'add_phone_order_link', 999 );

        $this->loader->add_filter( 'woocommerce_email_classes', $plugin_recipient_choices, 'add_recipient_choice_email_class', 10, 1);
        $this->loader->add_action( 'woocommerce_admin_order_data_after_order_details', $plugin_recipient_choices, 'add_links_to_parent', 10, 1);

        $this->loader->add_action( 'admin_menu', $plugin_block_out_dates, 'add_block_out_menu' );
        $this->loader->add_action( 'wp_ajax_add_special_date_block_out', $plugin_block_out_dates, 'add_specific_date' );
        $this->loader->add_action( 'wp_ajax_add_special_event_block_out', $plugin_block_out_dates, 'add_specific_event' );
        $this->loader->add_action( 'wp_ajax_save_next_day_cut_off', $plugin_block_out_dates, 'save_next_day_cut_off' );
        $this->loader->add_action( 'wp_ajax_save_week_days_disabled', $plugin_block_out_dates, 'save_week_days_disabled' );
        $this->loader->add_action( 'wp_ajax_remove_date_from_disabled', $plugin_block_out_dates, 'remove_date_from_disabled' );
        $this->loader->add_action( 'wp_ajax_remove_event_from_disabled', $plugin_block_out_dates, 'remove_event_from_disabled' );

        $this->loader->add_action( 'admin_menu', $plugin_reports, 'add_delivery_report_menu' );
        $this->loader->add_action( 'admin_menu', $plugin_reports, 'add_refund_report_menu' );
        $this->loader->add_action( 'wp_ajax_pull_delivery_report', $plugin_reports, 'pull_delivery_report' );
        $this->loader->add_action( 'wp_ajax_pull_refund_report', $plugin_reports, 'pull_refund_report' );

        $this->loader->add_action( 'admin_menu', $plugin_reports, 'add_order_delivery_report_menu' );
        $this->loader->add_action( 'wp_ajax_pull_order_delivery_report', $plugin_reports, 'pull_order_delivery_report' );

        $this->loader->add_action( 'admin_menu', $plugin_cards, 'add_note_cards_menu' );
        $this->loader->add_action( 'wp_ajax_pull_note_cards', $plugin_cards, 'pull_note_cards' );


        $this->loader->add_action( 'admin_menu', $plugin_slips, 'add_package_slips_menu' );
        $this->loader->add_action( 'wp_ajax_pull_package_slips', $plugin_slips, 'pull_package_slips' );


        $this->loader->add_action( 'admin_menu', $plugin_reports, 'add_kitchen_report_menu' );
        $this->loader->add_action( 'wp_ajax_pull_kitchen_report', $plugin_reports, 'pull_kitchen_report' );

        $this->loader->add_action( 'admin_menu', $plugin_sales_report, 'add_sales_report_menu' );
        $this->loader->add_action( 'wp_ajax_pull_sales_report', $plugin_sales_report, 'pull_sales_report' );

		$this->loader->add_action( 'admin_menu', $plugin_all_sales_report, 'add_all_sales_report_menu' );
        $this->loader->add_action( 'wp_ajax_pull_all_sales_report', $plugin_all_sales_report, 'pull_all_sales_report' );

        $this->loader->add_action( 'admin_menu', $plugin_sales_report, 'add_old_gc_summery_menu' );
        $this->loader->add_action( 'wp_ajax_pull_old_summery_report', $plugin_sales_report, 'pull_old_summery_report' );


       /* $this->loader->add_action( 'admin_menu', $plugin_re_develop_kitchen_report, 'add_re_develop_kitchen_report_menu' );
        $this->loader->add_action( 'wp_ajax_re_develop_ull_kitchen_report', $plugin_re_develop_kitchen_report, 're_develop_pull_kitchen_report' );*/

        
        $this->loader->add_action( 'admin_menu', $plugin_rc_expire, 'add_rc_expire_menu' );
        $this->loader->add_action( 'wp_ajax_search_rc_code_event', $plugin_rc_expire, 'search_rc_code_event' );
        $this->loader->add_action( 'wp_ajax_change_rc_redeemed_status', $plugin_rc_expire, 'change_rc_redeemed_status' );



		$this->loader->add_action( 'admin_menu', $plugin_all_quickbook_report, 'add_all_quickbooks_report_menu' );
        $this->loader->add_action( 'wp_ajax_pull_all_quickbooks_report', $plugin_all_quickbook_report, 'pull_all_quickbooks_report' );
     //   $this->loader->add_action( 'wp_ajax_get_quickbooks_based_on_select_filter', $plugin_all_quickbook_report, 'get_quickbooks_based_on_select_filter' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Iof_Utilities_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_sides  = new Iof_Utilities_Sides( $this->get_plugin_name(), $this->get_version() );
		$plugin_dates  = new Iof_Utilities_Delivery_Dates( $this->get_plugin_name(), $this->get_version() );
        $plugin_recipient_choices  = new Iof_Utilities_Recipient_Choices( $this->get_plugin_name(), $this->get_version() );
        $this->dates = $plugin_dates;
        $this->public = $plugin_public;

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'localize_scripts' );
        $this->loader->add_action( 'woocommerce_thankyou_cod', $plugin_public, 'change_order_status', 10, 1 );
        $this->loader->add_action( 'woocommerce_after_shop_loop_item_title', $plugin_public, 'adjust_product_price' );
/*        $this->loader->add_action( 'pizzaro_footer_v3', $plugin_public, 'iof_footer_menu', 30 );*/


		$this->loader->add_action( 'woocommerce_before_single_variation', $plugin_sides, 'display_sides_modal' );

		
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_sides, 'add_sides_to_cart', 10, 3 );
		$this->loader->add_filter( 'woocommerce_cart_item_name', $plugin_sides, 'display_sides_in_cart', 10, 3 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_sides, 'add_sides_to_order_items', 10, 4 );
/*		$this->loader->add_action( 'woocommerce_after_cart', $plugin_dates, 'display_zip_code_modal' );
*/
		$this->loader->add_action( 'wp_ajax_save_zip_code', $plugin_dates, 'save_zip_code' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_zip_code', $plugin_dates, 'save_zip_code' );

		$this->loader->add_action( 'wp_ajax_save_checkout_zip_code', $plugin_dates, 'save_checkout_zip_code' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_checkout_zip_code', $plugin_dates, 'save_checkout_zip_code' );

        $this->loader->add_action( 'wp_ajax_get_all_disabled_dates', $plugin_dates, 'get_all_disabled_dates' );
        $this->loader->add_action( 'wp_ajax_nopriv_get_all_disabled_dates', $plugin_dates, 'get_all_disabled_dates' );

		$this->loader->add_filter( 'woocommerce_update_cart_action_cart_updated', $plugin_dates, 'save_delivery_dates', 10, 1 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_dates, 'add_dates_to_order_items', 10, 4 );

        $this->loader->add_action( 'woocommerce_after_calculate_totals', $plugin_dates, 'adjust_cart_totals', 10, 1 );
		/*$this->loader->add_action( 'woocommerce_after_calculate_totals', $plugin_dates, 'adjust_cart_discount', 20, 1 );*/
        $this->loader->add_action( 'woocommerce_cart_calculate_fees', $plugin_dates, 'additional_shipping', 20, 2 );

        $this->loader->add_filter( 'woocommerce_cart_get_cart_contents_taxes', $plugin_dates, 'adjust_cart_taxes', 10, 1 );
		//$this->loader->add_filter( 'woocommerce_cart_get_shipping_taxes', $plugin_dates, 'adjust_cart_shipping_taxes', 10, 1 );
		$this->loader->add_action( 'woocommerce_review_order_after_shipping', $plugin_dates, 'checkout_display_delivery_dates' );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_dates, 'separate_and_single_same_cart_items', 10, 2 );
		$this->loader->add_filter( 'woocommerce_is_sold_individually', $plugin_dates, 'return_true' );

        $this->loader->add_action( 'woocommerce_checkout_order_processed', $plugin_recipient_choices, 'create_recipient_choice_coupon', 10, 1);
        $this->loader->add_filter( 'woocommerce_admin_shipping_fields', $plugin_recipient_choices, 'display_recipient_phone_email', 10, 1);
		$this->loader->add_filter( 'woocommerce_admin_shipping_fields', $plugin_recipient_choices, 'display_recipient_note_card_message', 10, 1 );
        $this->loader->add_filter( 'woocommerce_checkout_fields', $plugin_recipient_choices, 'add_recipient_phone_email', 10, 1);
		$this->loader->add_filter( 'woocommerce_checkout_fields', $plugin_recipient_choices, 'add_recipient_note_card_message', 20, 1 );

        //Recipient Choice Redeem Process Form
        $this->loader->add_shortcode('redeem_recipient_choice', $plugin_recipient_choices, 'display_recipient_redeem_form');
        $this->loader->add_action( 'wp_ajax_verify_recipient_code', $plugin_recipient_choices, 'verify_recipient_code' );
        $this->loader->add_action( 'wp_ajax_nopriv_verify_recipient_code', $plugin_recipient_choices, 'verify_recipient_code' );
        $this->loader->add_action( 'wp_ajax_complete_recipient_choice', $plugin_recipient_choices, 'complete_recipient_choice' );
        $this->loader->add_action( 'wp_ajax_nopriv_complete_recipient_choice', $plugin_recipient_choices, 'complete_recipient_choice' );
        $this->loader->add_action( 'woocommerce_before_single_variation', $plugin_recipient_choices, 'display_number_of_deliveries' );

        $this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_recipient_choices, 'add_number_deliveries_to_cart', 10, 3 );
        $this->loader->add_action( 'woocommerce_before_calculate_totals', $plugin_recipient_choices, 'adjust_rc_price_totals', 10, 1 );
        $this->loader->add_action( 'woocommerce_after_calculate_totals', $plugin_recipient_choices, 'adjust_rc_cart_totals', 10, 1 );

        $this->loader->add_filter( 'woocommerce_before_cart', $plugin_recipient_choices, 'exclude_other_items_from_cart');
        $this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_recipient_choices, 'save_number_deliveries_to_order', 10, 4 );

        $this->loader->add_action( 'woocommerce_after_shop_loop_item_title', $plugin_public, 'display_product_image', 10 );
        
        $this->loader->add_action( 'wp_ajax_add_to_rc_wallet', $plugin_recipient_choices, 'add_to_rc_wallet' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Iof_Utilities_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
