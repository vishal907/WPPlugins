<?php

class Iof_Utilities_Admin {

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
		file_put_contents( __DIR__ . "/css/combined/iof-admin.css", $combined_file );
		// only the line below should be in production
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/combined/iof-admin.css', array(), 0.52, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// TODO: don't use this JS 'compiler' in production OR cache and don't compile every page load
		// TODO: for production, you can simply copy over the combined JS file
		// $options = array(
		// 	"ssl" => array(
		// 		"verify_peer"      => false,
		// 		"verify_peer_name" => false
		// 	)
		// );

		// $files         = glob( __DIR__ . '/js/*.js' );
		// $start         = substr( file_get_contents( plugin_dir_url( __FILE__ ) . '../util/js/start.js', false, stream_context_create( $options ) ), 2 );
		// $end           = substr( file_get_contents( plugin_dir_url( __FILE__ ) . '../util/js/end.js', false, stream_context_create( $options ) ), 2 );
		// $combined_file = $start;
		// foreach ( $files as $file ) {
		// 	$combined_file .= file_get_contents( $file, false, stream_context_create( $options ) );
		// }
		// $combined_file .= $end;
		// file_put_contents( __DIR__ . "/js/combined/iof-admin.js", $combined_file );
		// only the line below should be in production
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/combined/iof-admin.js', array( 'jquery' ), 0.33, false );
	}

	/**
	 * Add the coupon quick search to the wp admin toolbar.
	 *
	 * @return array
	 */
	private static function get_coupon_search_form_args() {
		$args = array(
			'id'     => 'iof_admin_bar_form_coupon',
			'parent' => 'iof-search-forms',
			'title'  => '<form method="get" action="' . get_site_url() . '/wp-admin/edit.php?post_type=shop_coupon" >
							<p class="search-box">
								<label class="screen-reader-text" for="post-search-input">Search Coupons:</label>
								<input id="post-search-input" class="iof-admin-search-txt" type="search" value="" name="s"/>
								<input id="search-submit" class="button iof-admin-search-btn" type="submit" value="Search Coupons"/>
							</p>
							<input class="post_status_page" type="hidden" value="all" name="post_status"/>
							<input class="post_type_page" type="hidden" value="shop_coupon" name="post_type"/>
							<input id="_wpnonce" type="hidden" value="b28f527de9" name="_wpnonce"/>
							 ' . wp_nonce_field() . '  
						</form>'
		);

		return $args;
	}

	/**
	 * Add the user quick search to the wp admin toolbar.
	 *
	 * @return array
	 */
	private static function get_user_search_form_args( ) {
		$args = array(
			'id'     => 'iof_admin_bar_form_user',
			'parent' => 'iof-search-forms',
			'title'  => '<form method="get" action="' . get_site_url() . '/wp-admin/users.php" >
							<p class="search-box">
								<label class="screen-reader-text" for="user-search-input">Search Users:</label>
								<input id="user-search-input" class="iof-admin-search-txt" type="search" value="" name="s"/>
								<input id="search-submit" class="button iof-admin-search-btn" type="submit" value="Search Users"/>
							</p>
							<input id="_wpnonce" type="hidden" value="2497b18ef3" name="_wpnonce"/>
 							' . wp_nonce_field() . '  
						</form>'
		);

		return $args;
	}

	/**
	 * Add the order quick search to the wp admin toolbar.
	 *
	 * @return array
	 */
	private static function get_order_search_form_args() {
		$args = array(
			'id'     => 'iof_admin_bar_form_order',
			'parent' => 'iof-search-forms',
			'title'  => '<form method="get" action="' . get_site_url() . '/wp-admin/edit.php" id="posts-filter">
							<p class="search-box">
								<label for="post-search-input" class="screen-reader-text">Search Orders:</label>
								<input type="search" value="" class="iof-admin-search-txt" name="s" id="post-search-input" vk_1a488="subscribed">
								<input type="submit" value="Search Orders" class="button iof-admin-search-btn" id="search-submit"></p>
							<input type="hidden" value="all" class="post_status_page" name="post_status">
							<input type="hidden" value="shop_order" class="post_type_page" name="post_type">
							 ' . wp_nonce_field() . '  
						</form>'
		);

		return $args;
	}

	/**
	 * Add the quick search top bar for orders, coupons, and users.
	 *
	 * @param $wp_admin_bar
	 */
	public function add_admin_topbar_search_forms( $wp_admin_bar ) {
		$form_group = array(
			'id'     => 'iof-search-forms',
			'parent' => 'top-secondary',
			'group'  => true
		);

		$mobile_link = array(
			'id'    => 'iof-search-forms-mobile',
			'title' => 'Search'
		);

		$user_args   = self::get_user_search_form_args();
		$order_args  = self::get_order_search_form_args();
		$coupon_args = self::get_coupon_search_form_args();

		$wp_admin_bar->add_node( $mobile_link );
		$wp_admin_bar->add_node( $form_group );
		$wp_admin_bar->add_node( $user_args );
		$wp_admin_bar->add_node( $order_args );
		$wp_admin_bar->add_node( $coupon_args );
	}

	/**
	 * Remove items from the admin side menu bar. Removes items for non admins.
	 */
	public function restrict_admin_menu_items() {
		if ( current_user_can( 'sales_tax' ) ) {
			global $submenu, $menu, $pagenow;

			    remove_menu_page('index.php');

			remove_menu_page( 'edit.php' );                             // posts
			remove_menu_page( 'upload.php' );                           // media
			remove_menu_page( 'edit.php?post_type=product' );              // pages
			remove_menu_page( 'edit-tags.php?taxonomy=category' );              // pages
			remove_menu_page( 'edit-tags.php?taxonomy=post_tag' );              // pages
			remove_menu_page( 'edit-tags.php?taxonomy=category' );              // pages

			remove_menu_page( 'delivery_method_report' );                        // pizzaro
			remove_menu_page( 'block-out-dates' );
			remove_menu_page( 'kitchen_report' );
			remove_menu_page( 'delivery-reports' );
			remove_menu_page( 'order-reports' );
			remove_menu_page( 'refund-reports' );
			remove_menu_page( 'sales-report' );
			remove_menu_page( 'all-sales-report' );
			remove_menu_page( 'old-summary' );
			remove_menu_page( 'rc-settings' );
			remove_menu_page( 'note-cards' );
			remove_menu_page( 'packing-slips' );
			remove_menu_page( 'wc-admin' );
			remove_menu_page( 'vc-general' );
			remove_menu_page( 'wp-mail-smtp' );
			remove_menu_page( 'Manage-calender' );
			remove_menu_page( 'heateor-sss-options' );
			remove_menu_page( 'sbi-welcome-new' );
			remove_menu_page( 'sb-instagram-feed' );
			
			remove_menu_page( 'order-post-types-nutritionals' );

			remove_menu_page( 'import.php' );                             // posts
			remove_menu_page( 'edit-comments.php' );                    // comments
				remove_menu_page( 'plugins.php' );                          // plugins
			remove_menu_page( 'tools.php' );                            // tools
			remove_menu_page( 'options-general.php' );                  // settings
			remove_menu_page( 'edit.php?post_type=acf-field-group' );   // advanced custom fields

			remove_menu_page( 'woocommerce' );
			 remove_menu_page( 'order-post-types-shop_order' ); // WOOCOMMERCE
    		remove_menu_page( 'order-post-types-shop_coupons' ); // WOOCOMMERCE


			remove_menu_page( 'edit.php?post_type=nutritionals' );              // pages
			remove_menu_page( 'order-post-types-nutritionals' );              // pages
			remove_menu_page( 'profile.php' );              // pages


		 	unset($menu[56]); 
		 	unset($menu['62.32']);
			unset($menu[58]); 



		}
		if ( ! current_user_can( 'administrator' ) ) {
			remove_menu_page( 'theme_options' );                        // pizzaro
			remove_menu_page( 'edit.php' );                             // posts
			remove_menu_page( 'upload.php' );                           // media
			remove_menu_page( 'edit.php?post_type=page' );              // pages
			remove_menu_page( 'edit-comments.php' );                    // comments
			remove_menu_page( 'edit.php?post_type=static_block' );      // static content
			remove_menu_page( 'wpcf7' );                                // contact
			remove_menu_page( 'plugins.php' );                          // plugins
			remove_menu_page( 'tools.php' );                            // tools
			remove_menu_page( 'options-general.php' );                  // settings
			remove_menu_page( 'edit.php?post_type=acf-field-group' );   // advanced custom fields
			remove_menu_page( 'edit.php?post_type=kc-section' );        // king composer
			remove_menu_page( 'revslider' );                            // slider revolution
			remove_menu_page( 'sucuriscan' );                           // sucuri
			remove_menu_page( 'envato-market' );                        // envato market
		}
	}

	/**
	 * Remove items from the admin top bar. Removes for all users.
	 *
	 * @param $wp_admin_bar
	 */
	public function remove_admin_topbar_items( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_node( 'comments' );
		$wp_admin_bar->remove_node( 'archive' );
		$wp_admin_bar->remove_node( 'new-content' );
		$wp_admin_bar->remove_node( 'wpseo-menu' );
		$wp_admin_bar->remove_node( 'view-site' );
		$wp_admin_bar->remove_node( 'view-store' );
		$wp_admin_bar->remove_node( 'theme_options' );
		$wp_admin_bar->remove_node( 'updates' );
		$wp_admin_bar->remove_node( 'search' );
		$wp_admin_bar->remove_node( 'revslider' );
		$wp_admin_bar->remove_node( 'customize' );

		if ( ! current_user_can( 'administrator') ) {
			$wp_admin_bar->remove_node( 'edit' );
		}


		if ( current_user_can( 'sales_tax') ) {
			?>
			<script type="text/javascript">
				jQuery( document ).ready(function() {
				    jQuery('#wp-admin-bar-iof-search-forms').css('display','none');
				    jQuery('.update-nag.notice.notice-warning.inline').css('display','none');
				});
			</script>
			<?php 
		}
	}
}
