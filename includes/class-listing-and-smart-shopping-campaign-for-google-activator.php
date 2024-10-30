<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcommerce.com
 * @since      1.0.0
 *
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/includes
 */
class Google_Shopping_Integration_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::google_shopping_create_tables();
	}

	private static function google_shopping_create_tables() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$prefix                        = $wpdb->prefix;
		$google_shopping_upload_status =
		"CREATE TABLE {$prefix}google_shopping_product_upload_status (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        feed_data LONGTEXT NOT NULL,
        feed_time VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
        );";
		dbDelta( $google_shopping_upload_status );
	}

}
