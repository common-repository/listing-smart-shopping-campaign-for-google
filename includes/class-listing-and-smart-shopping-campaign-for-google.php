<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cedcommerce.com
 * @since      1.0.0
 *
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/includes
 */
class Listing_And_Smart_Shopping_Campaign_For_Google {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0

	 * @var      Google_Shopping_Integration_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0

	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0

	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
		if ( defined( 'Listing_And_Smart_Shopping_Campaign_For_Google_VERSION' ) ) {
			$this->version = Listing_And_Smart_Shopping_Campaign_For_Google_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'listing-and-smart-shopping-campaign-for-google';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Google_Shopping_Integration_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Google_Shopping_Integration_For_Woocommerce_I18n. Defines internationalization functionality.
	 * - Google_Shopping_Integration_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Google_Shopping_Integration_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-listing-and-smart-shopping-campaign-for-google-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-listing-and-smart-shopping-campaign-for-google-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-listing-and-smart-shopping-campaign-for-google-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		

		$this->loader = new Google_Shopping_Integration_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Google_Shopping_Integration_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {

		$plugin_i18n = new Google_Shopping_Integration_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Google_Shopping_Integration_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ced_google_add_menus', 22 );
		$this->loader->add_filter( 'ced_add_marketplace_menus_array', $plugin_admin, 'ced_google_add_marketplace_menus_to_array', 13 );
		$this->loader->add_action( 'wp_ajax_ced_google_create_user', $plugin_admin, 'ced_google_create_user' );
		$this->loader->add_action( 'wp_ajax_ced_google_get_user_token', $plugin_admin, 'ced_google_get_user_token' );
		$this->loader->add_action( 'wp_ajax_ced_google_authorisation', $plugin_admin, 'ced_google_authorisation' );
		$this->loader->add_action( 'wp_ajax_ced_Save_And_CreateGMCAccount', $plugin_admin, 'ced_Save_And_CreateGMCAccount' );
		$this->loader->add_action( 'wp_ajax_ced_Save_And_CreateGoogleAdsAccount', $plugin_admin, 'ced_Save_And_CreateGoogleAdsAccount' );
		$this->loader->add_action( 'wp_ajax_ced_connect_gmc_account', $plugin_admin, 'ced_connect_gmc_account' );
		$this->loader->add_action( 'wp_ajax_ced_connect_ads_account', $plugin_admin, 'ced_connect_ads_account' );
		$this->loader->add_action( 'wp_ajax_ced_save_account_config_content', $plugin_admin, 'ced_save_account_config_content' );
		$this->loader->add_action( 'wp_ajax_ced_save_and_create_compaign', $plugin_admin, 'ced_save_and_create_compaign' );
		$this->loader->add_action( 'wp_ajax_ced_google_shopping_list_per_page', $plugin_admin, 'ced_google_shopping_list_per_page' );
		$this->loader->add_action( 'wp_ajax_ced_good_shopping_process_bulk_action', $plugin_admin, 'ced_good_shopping_process_bulk_action' );
		$this->loader->add_action( 'wp_ajax_ced_connect_another_gmail_account_for_gads', $plugin_admin, 'ced_connect_another_gmail_account_for_gads' );
		$this->loader->add_action( 'wp_ajax_ced_skip_connect_ads_account', $plugin_admin, 'ced_skip_connect_ads_account' );
		$this->loader->add_action( 'wp_ajax_ced_google_reset_connected_account', $plugin_admin, 'ced_google_reset_connected_account' );
		$this->loader->add_action( 'wp_ajax_ced_google_onboarding_skip', $plugin_admin, 'ced_google_onboarding_skip' );
		$this->loader->add_action( 'wp_ajax_ced_google_save_product_automate_setting', $plugin_admin, 'ced_google_save_product_automate_setting' );

		$this->loader->add_filter( 'cron_schedules', $plugin_admin, 'ced_google_shopping_cron_schedules' );
		$this->loader->add_filter( 'ced_google_shopping_auto_product_syncing', $plugin_admin, 'ced_google_shopping_auto_product_syncing' );
		$this->loader->add_filter( 'wp_ajax_ced_google_shopping_auto_product_syncing', $plugin_admin, 'ced_google_shopping_auto_product_syncing' );
		$this->loader->add_filter( 'wp_ajax_nopriv_ced_google_shopping_auto_product_syncing', $plugin_admin, 'ced_google_shopping_auto_product_syncing' );

		$this->loader->add_filter( 'ced_google_shopping_auto_existing_product_syncing', $plugin_admin, 'ced_google_shopping_auto_existing_product_syncing' );
		$this->loader->add_filter( 'wp_ajax_ced_google_shopping_auto_existing_product_syncing', $plugin_admin, 'ced_google_shopping_auto_existing_product_syncing' );
		$this->loader->add_filter( 'wp_ajax_nopriv_ced_google_shopping_auto_existing_product_syncing', $plugin_admin, 'ced_google_shopping_auto_existing_product_syncing' );
		$this->loader->add_action( 'wp_ajax_ced_dash_gmc_unlink', $plugin_admin, 'ced_dash_gmc_unlink' );
		$this->loader->add_action( 'wp_ajax_ced_dash_get_campaign_location', $plugin_admin, 'ced_dash_get_campaign_location' );
		$this->loader->add_action( 'wp_ajax_ced_update_gmax_campaign', $plugin_admin, 'ced_update_gmax_campaign' );
		$this->loader->add_action( 'wp_ajax_ced_update_gmax_campaign_status', $plugin_admin, 'ced_update_gmax_campaign_status' );
		$this->loader->add_action( 'wp_ajax_ced_ads_gids_after_remove_gmc_acnt', $plugin_admin, 'ced_ads_gids_after_remove_gmc_acnt' );
		$this->loader->add_action( 'wp_ajax_ced_google_create_conversion', $plugin_admin, 'ced_google_create_conversion' );
		$this->loader->add_action( 'wp_ajax_ced_show_created_conversion_popup', $plugin_admin, 'ced_show_created_conversion_popup' );
		$this->loader->add_action( 'wp_ajax_ced_auto_create_conversion_and_upload_tag', $plugin_admin, 'ced_auto_create_conversion_and_upload_tag' );
		$this->loader->add_action( 'wp_ajax_ced_google_shopping_get_Ads_reports', $plugin_admin, 'ced_google_shopping_get_Ads_reports' );
		$this->loader->add_action( 'wp_head', $plugin_admin, 'ced_insert_google_conversion_global_site_tag' );
		$this->loader->add_action( 'wp_ajax_ced_create_and_save_profile', $plugin_admin, 'ced_create_and_save_profile' );
		$this->loader->add_action( 'wp_ajax_ced_gs_proffile_create_and_save', $plugin_admin, 'ced_gs_proffile_create_and_save' );
		$this->loader->add_action( 'wp_ajax_ced_delete_existing_profile', $plugin_admin, 'ced_delete_existing_profile' );
		$this->loader->add_action( 'wp_ajax_ced_save_google_product_id_view', $plugin_admin, 'ced_save_google_product_id_view' );
		$this->loader->add_action( 'wp_ajax_ced_save_global_config_contents', $plugin_admin, 'ced_save_global_config_contents' );
		$this->loader->add_action( 'wp_ajax_ced_gs_gmc_verify_and_claim', $plugin_admin, 'ced_gs_gmc_verify_and_claim' );
		$this->loader->add_action( 'updated_post_meta', $plugin_admin, 'ced_google_shopping_stock_update_after_post_meta', 10, 4 );
		$this->loader->add_filter( 'ced_google_shopping_enable_instant_product_syncing', $plugin_admin, 'ced_google_sync_product_while_update_post_meta' );
		$this->loader->add_action( 'wp_ajax_ced_google_sync_product_while_update_post_meta', $plugin_admin, 'ced_google_sync_product_while_update_post_meta' );
		$this->loader->add_action( 'wp_ajax_nopriv_ced_google_sync_product_while_update_post_meta', $plugin_admin, 'ced_google_sync_product_while_update_post_meta' );
		$this->loader->add_action( 'before_delete_post', $plugin_admin, 'ced_delete_product_from_gmc_while_deleting_from_woo', 10, 4 );
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
	 * @return    Google_Shopping_Integration_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
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
