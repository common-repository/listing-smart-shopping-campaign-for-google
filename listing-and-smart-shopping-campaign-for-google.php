<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cedcommerce.com
 * @since             1.0.0
 * @package           Listing_And_Smart_Shopping_Campaign_For_Google
 *
 * @wordpress-plugin
 * Plugin Name:       Listing And Smart Shopping Campaign For Google
 * Plugin URI:        https://cedcommerce.com
 * Description:       Seamlessly integrate your WooCommerce store to Google Merchant center for easy listing creation with Listing And Smart Shopping Campaign For Google.
 * Version:           1.0.4
 * Author:            CedCommerce
 * Author URI:        https://cedcommerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       listing-and-smart-shopping-campaign-for-google
 * Domain Path:       /languages
 *
 * WC requires at least: 3.0
 * WC tested up to: 6.3.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LISTING_AND_SMART_SHOPPING_CAMPAIGN_FOR_GOOGLE_VERSION', '1.0.4' );
define( 'CED_WGEI_LOG_DIRECTORY', wp_upload_dir()['basedir'] . '/ced_wgei_log_directory' );
define( 'CED_WGEI_VERSION', '1.0.4' );
define( 'CED_WGEI_PREFIX', 'ced_wgei' );
define( 'CED_WGEI_DIRPATH', plugin_dir_path( __FILE__ ) );
define( 'CED_WGEI_URL', plugin_dir_url( __FILE__ ) );
define( 'CED_WGEI_ABSPATH', untrailingslashit( plugin_dir_path( dirname( __FILE__ ) ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-listing-and-smart-shopping-campaign-for-google-activator.php
 */
function activate_google_shopping_integration_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-listing-and-smart-shopping-campaign-for-google-activator.php';
	Google_Shopping_Integration_For_Woocommerce_Activator::activate();
	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-listing-and-smart-shopping-campaign-for-google-deactivator.php
 */
function deactivate_google_shopping_integration_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-listing-and-smart-shopping-campaign-for-google-deactivator.php';
	Google_Shopping_Integration_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_google_shopping_integration_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_google_shopping_integration_for_woocommerce' );
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-listing-and-smart-shopping-campaign-for-google.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-listing-and-smart-shopping-campaign-for-google-token-regenerate.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_google_shopping_integration_for_woocommerce() {

	$plugin = new Listing_And_Smart_Shopping_Campaign_For_Google();
	$plugin->run();

}
run_google_shopping_integration_for_woocommerce();
