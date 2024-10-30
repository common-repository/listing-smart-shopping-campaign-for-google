<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://cedcommerce.com
 * @since      1.0.0
 *
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/includes
 */
class Google_Shopping_Integration_For_Woocommerce_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'listing-and-smart-shopping-campaign-for-google',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
