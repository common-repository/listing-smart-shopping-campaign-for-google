<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcommerce.com
 * @since      1.0.0
 *
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/admin
 */
class Google_Shopping_Integration_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		// $this->apiUrl      = 'https://dev-express.sellernext.com';
		$this->apiUrl = 'https://express.sellernext.com';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Google_Shopping_Integration_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Google_Shopping_Integration_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';
		if ( 'ced_google' == $page || 'cedcommerce-integrations' == $page ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/listing-and-smart-shopping-campaign-for-google-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'font', 'https://fonts.googleapis.com/css?family=Inter', array(), '1.0.0', 'all' );
			wp_enqueue_style( 'font-dash', 'https://fonts.googleapis.com/css2?family=Montserrat&family=Source+Sans+Pro:wght@300&display=swap', array(), '1.0.0', 'all' );

			wp_enqueue_style( 'uo-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css', array(), '1.0.0', 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Google_Shopping_Integration_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Google_Shopping_Integration_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$ajax_nonce     = wp_create_nonce( 'ced-wgei-ajax-seurity-string' );
		$localize_array = array(
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'        => $ajax_nonce,
			'user_access_token' => ! empty( get_option( 'ced_google_user_login_data' ) ) ? get_option( 'ced_google_user_login_data', true ) : false,
			// 'merchant_id'       => $merchant_id,
		);

		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';
		if ( 'ced_google' == $page ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/listing-and-smart-shopping-campaign-for-google-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'ui-min-js', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array(), '1.0.0', true );
			wp_register_style( 'ced-select-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', '', '1.0.0' );
			wp_enqueue_style( 'ced-select-css' );

			wp_register_script( 'ced-select-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', null, '1.0.0', true );
			wp_enqueue_script( 'ced-select-js' );
		}
		wp_localize_script( $this->plugin_name, 'ced_google_admin_obj', $localize_array );
				// $parameters['on_boarding']    = $on_boarding;
	}
	public function ced_google_add_menus() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['cedcommerce-integrations'] ) ) {
			add_menu_page( __( 'CedCommerce', 'google-shopping-for-woocommerce' ), __( 'CedCommerce', 'google-shopping-for-woocommerce' ), 'manage_woocommerce', 'cedcommerce-integrations', array( $this, 'ced_marketplace_listing_page' ), plugins_url( 'listing-and-smart-shopping-campaign-for-google/admin/images/logo1.png' ), 12 );
			/**
			 * A filter used for create submenu ced_add_marketplace_menus_array.
			 *
			 * A filter used for create submenu.
			 *
			 * @since 1.0.0
			 * @filter ced_add_marketplace_menus_array
			 */
			$menus = apply_filters( 'ced_add_marketplace_menus_array', array() );
			if ( is_array( $menus ) && ! empty( $menus ) ) {
				foreach ( $menus as $key => $value ) {
					add_submenu_page( 'cedcommerce-integrations', $value['name'], $value['name'], 'manage_woocommerce', $value['menu_link'], array( $value['instance'], $value['function'] ) );
				}
			}
		}
	}
	public function ced_marketplace_listing_page() {
		/**
		 * A filter used for create submenu ced_add_marketplace_menus_array.
		 *
		 * A filter used for create submenu.
		 *
		 * @since 1.0.0
		 * @filter ced_add_marketplace_menus_array
		 */
		$activeMarketplaces = apply_filters( 'ced_add_marketplace_menus_array', array() );
		if ( is_array( $activeMarketplaces ) && ! empty( $activeMarketplaces ) ) {
			require CED_WGEI_DIRPATH . 'admin/partials/marketplaces.php';
		}
	}
	public function ced_google_add_marketplace_menus_to_array( $menus = array() ) {
		$menus[] = array(
			'name'            => 'Google',
			'slug'            => 'google-shopping-for-woocommerce',
			'menu_link'       => 'ced_google',
			'instance'        => $this,
			'function'        => 'ced_google_accounts_page',
			'card_image_link' => CED_WGEI_URL . 'admin/images/google-card.png',
		);
		return $menus;
	}
	/*
	*
	*Function for displaying default page
	*
	*
	*/
	public function ced_google_accounts_page() {
		$fileAccounts = CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-admin-display.php';
		if ( file_exists( $fileAccounts ) ) {
			require_once $fileAccounts;
		}
	}


	public function ced_google_create_user() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$response = get_option( 'ced_google_user_token_data', true );
			if ( is_array( $response ) && ! empty( $response ) ) {
				if ( isset( $response['token'] ) ) {

					echo json_encode(
						array(
							'status' => 'success',
							'data'   => $response,
						)
					);
					die;
				} else {
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => 'Failed to fetch user token',
						)
					);
					die;
				}
			}
			$store                   = isset( $_POST['store'] ) ? sanitize_text_field( $_POST['store'] ) : '';
			$email                   = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
			$framework               = isset( $_POST['framework'] ) ? sanitize_text_field( $_POST['framework'] ) : '';
			$parameters              = array();
			$parameters['username']  = $store;
			$parameters['email']     = $email;
			$parameters['framework'] = $framework;
			$apiUrl                  = $this->apiUrl . '/connector/framework/createUser';
			$response                = wp_remote_post(
				$apiUrl,
				array(
					'body'        => $parameters,
					'headers'     => array(
						'Content-Type'  => 'application/x-www-form-urlencoded',
						'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VyX2lkIjoiMSIsInJvbGUiOiJhcHAiLCJpYXQiOjE2NjI1MzM3MzMsImlzcyI6Imh0dHBzOlwvXC9kZXYtZnJvbnRlbmRzLmV4cHJlc3Muc2VsbGVybmV4dC5jb20iLCJhdWQiOiJleGFtcGxlLmNvbSIsIm5iZiI6MTY2MjUzMzczMywib3ByIjoiQ3JlYXRlVXNlciIsInRva2VuX2lkIjoxNjYyNTMzNzMzfQ.lnadhsewU6aXShMbr_vN6lGMS6nnda9NKOlX3_IlMWjUxiHU4ib1a-zaDYe6WtDrbf7KdLlxQFo_BuojzHDSlseFZejkXtqtMJiOoEuGsWgfw32N_tAOIjDmIan4lLr8EHLkFaZ1mi67g0pPI0x32zGPPwCPpFKhS5ijyRFcvqW9TDD2Lz5_cAOi06uL5LJhNW_GW0i4L4vAOZy3y6kKwZW5VlADCFtFGkn-Rzca8Z_PcFR4oxZyDjIqIZmCy6T0XaAPCVwQgyu1wnSXZ0uoO7Xg7U-E8rZ2e3QzVH0zAvR6uqoxnSIkUSGukU4WGsRfQVlgu8c3Hu1v61nW8HIauA',
					),
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
				)
			);
			if ( isset( $response['body'] ) ) {
				$response = json_decode( $response['body'], true );
			} else {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Something went wrong. Please contact support!',
					)
				);
				die;
			}
			if ( isset( $response['token'] ) ) {
				update_option( 'ced_google_user_token_data', $response );
				update_option( 'is_user_created', 'yes' );
				echo json_encode(
					array(
						'status' => 'success',
						'data'   => $response,
					)
				);
				die;
			} else {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => $response['error'],
					)
				);
				die;
			}
		}

	}


	public function ced_google_get_user_token() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$sanitized_array = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
			$user_data       = isset( $sanitized_array['user_data'] ) ? $sanitized_array['user_data'] : false;
			if ( 'false' != $user_data ) {
				$parameters             = array();
				$parameters['username'] = $user_data['username'];
				$parameters['email']    = $user_data['email'];
				$header                 = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_data['token'],
				);
				$apiUrl                 = $this->apiUrl . '/connector/framework/login';

				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'body'        => $parameters,
						'headers'     => $header,
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
					)
				);
				if ( isset( $api_response['body'] ) ) {
					$response = json_decode( $api_response['body'], true );
				} else {
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => 'Something went wrong. Please contact support!',
						)
					);
					die;
				}
				if ( isset( $response['data'] ) ) {
					$time_during_create_google_token = gmdate( 'H:i:s' );
					update_option( 'ced_google_user_login_data', $response );
					update_option( 'time_during_create_google_token', $time_during_create_google_token );
					set_transient( 'time_during_create_google_token', $time_during_create_google_token, 14000 );
					update_option( 'ced_google_user_login_data', $response );
					update_option( 'is_user_logged_in', 'yes' );
					echo json_encode(
						array(
							'status' => 'success',
							'data'   => $response,
						)
					);
					die;
				} else {
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => 'Failed to fetch Google Token. Please contact support!',
						)
					);
					die;
				}
			}
		}
	}

	public function ced_google_authorisation() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$framework             = isset( $_POST['framework'] ) ? sanitize_text_field( $_POST['framework'] ) : '';
			$store                 = isset( $_POST['store'] ) ? sanitize_text_field( $_POST['store'] ) : '';
			$email                 = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
			$user_token            = isset( $_POST['user_token'] ) ? sanitize_text_field( $_POST['user_token'] ) : false;
			$from_dashboard        = isset( $_POST['from_dashboard'] ) ? sanitize_text_field( $_POST['from_dashboard'] ) : '';
			$url_additional_params = '';
			if ( ! empty( $from_dashboard ) ) {
				$url_additional_params = '&on_boarding=false';
			}
			$parameters                 = array();
			$parameters['username']     = $store;
			$parameters['email']        = $email;
			$parameters['framework']    = $framework;
			$parameters['redirect_url'] = admin_url() . '/admin.php?page=ced_google';
			$header                     = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			$apiUrl                     = $this->apiUrl . '/connector/get/installationForm?code=google&framework=woocommerce' . $url_additional_params;
			$api_response               = wp_remote_post(
				$apiUrl,
				array(
					'method'      => 'POST',
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
					'headers'     => $header,
					'body'        => $parameters,
				)
			);
			/*
			print_r($apiUrl);
			die('df');*/
			if ( is_wp_error( $api_response ) ) {
				$error_message = $api_response->get_error_message();
				wp_send_json(
					array(
						'status'  => 'error',
						'message' => $error_message,
					)
				);
			} else {
				$response = json_decode( $api_response['body'], true );
				if ( isset( $response['data'] ) ) {
					set_transient( 'ced_google_token_fetched', true, 14400 );
					update_option( 'ced_google_account_data', $response );
					update_option( 'ced_google_nav_step', '1' );
					if ( empty( $from_dashboard ) ) {
						update_option( 'ced_google_another_account_data', '' );
						update_option( 'ced_google_GMC_account_data', '' );
						update_option( 'ced_google_ads_account_data', '' );
						update_option( 'ced_save_merchant_details', '' );
						update_option( 'ced_save_ads_details', '' );
						update_option( 'ced_save_ads_details', '' );
						update_option( 'ced_configuration_details', '' );
						update_option( 'ced_compaign_details', '' );
					}
						$url = $response['data']['action'] . '&redirect_url=' . admin_url() . '/admin.php?page=ced_google&section=accounting-setting';
						echo esc_url_raw( $url );
					wp_die();
				} else {
					wp_send_json(
						array(
							'status'  => 'error',
							'message' => 'Something went wrong. Please contact support!',
						)
					);
				}
			}
		}
	}

	public function ced_connect_another_gmail_account_for_gads() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$framework   = isset( $_POST['framework'] ) ? sanitize_text_field( $_POST['framework'] ) : '';
			$store       = isset( $_POST['store'] ) ? sanitize_text_field( $_POST['store'] ) : '';
			$email       = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
			$on_boarding = isset( $_POST['on_boarding'] ) ? sanitize_text_field( $_POST['on_boarding'] ) : '';
			if ( ! empty( get_option( 'ced_google_user_login_data', true ) ) ) {
				$user_token_data            = get_option( 'ced_google_user_login_data', true );
				$user_token                 = $user_token_data['data']['token'];
				$parameters                 = array();
				$parameters['username']     = $store;
				$parameters['email']        = $email;
				$parameters['framework']    = $framework;
				$parameters['redirect_url'] = admin_url() . '/admin.php?page=ced_google';
				$header                     = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                     = $this->apiUrl . '/connector/get/installationForm?code=googleads&framework=woocommerce';
				$api_response               = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					wp_send_json(
						array(
							'status'  => 'error',
							'message' => $error_message,
						)
					);
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( isset( $response['data'] ) ) {
						set_transient( 'ced_google_token_fetched', true, 14400 );
						update_option( 'ced_google_another_account_data', $response );
						update_option( 'ced_google_nav_step', '3' );
						$url = $response['data']['action'] . '&redirect_url=' . admin_url() . '/admin.php?page=ced_google&section=ads-setting';
						echo esc_url_raw( $url );
						wp_die();
					} else {
						wp_send_json(
							array(
								'status'  => 'error',
								'message' => 'Something went wrong. Please contact support!',
							)
						);
					}
				}
			}
		}
	}

	public function ced_Save_And_CreateGMCAccount() {

		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$user_id            = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : '';
			$framework          = isset( $_POST['framework'] ) ? sanitize_text_field( $_POST['framework'] ) : '';
			$account_name       = isset( $_POST['account_name'] ) ? sanitize_text_field( $_POST['account_name'] ) : '';
			$term_and_condiiton = isset( $_POST['term_and_condiiton'] ) ? sanitize_text_field( $_POST['term_and_condiiton'] ) : '';
			if ( ! empty( get_option( 'ced_google_user_login_data', true ) ) ) {
				$user_token_data                 = get_option( 'ced_google_user_login_data', true );
				$user_token                      = $user_token_data['data']['token'];
				$parameters                      = array();
				$parameters['userId']            = $user_token_data['user_id'];
				$parameters['name']              = $account_name;
				$parameters['framework']         = $framework;
				$parameters['term_and_conditon'] = $term_and_condiiton;
				$parameters['url']               = 'https://cedcommerce.com';
				$header                          = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                          = $this->apiUrl . '/google/app/createSubAccountGmc';
				$api_response                    = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( isset( $response['merchant_id'] ) ) {
						update_option( 'ced_google_GMC_account_data', $api_response['body'] );
						update_option( 'ced_google_nav_step', '1' );
						/*
						update_option( 'ced_google_ads_account_data', '' );
						update_option('ced_save_merchant_details', '');
						update_option('ced_save_ads_details','');
						update_option('ced_save_ads_details', '');
						update_option('ced_configuration_details','');
						update_option('ced_compaign_details','');*/
						$merchant_id               = $response['merchant_id'];
						$websiteUrl                = $response['websiteUrl'];
						$account_name              = $response['account_name'];
						$parameters                = array();
						$parameters['user_id']     = $user_id;
						$parameters['merchantId']  = $merchant_id;
						$parameters['websiteUrl']  = $websiteUrl;
						$parameters['accountName'] = $account_name;
						$header                    = array(
							'Content-Type'  => 'application/x-www-form-urlencoded',
							'Authorization' => 'Bearer ' . $user_token,
						);
						$apiUrl                    = $this->apiUrl . '/google/app/saveAllGoogleMerchantAccount';
						$api_response              = wp_remote_post(
							$apiUrl,
							array(
								'method'      => 'POST',
								'httpversion' => '1.0',
								'sslverify'   => false,
								'timeout'     => 120,
								'headers'     => $header,
								'body'        => $parameters,
							)
						);
						if ( is_wp_error( $api_response ) ) {
							$error_message = $api_response->get_error_message();
							echo json_encode(
								array(
									'status'  => 'error',
									'message' => $response['message'],
								)
							);
							die;
						} else {
							$response = json_decode( $api_response['body'], true );
							update_option( 'ced_google_nav_step', '2' );
							echo json_encode(
								array(
									'status'       => 'success',
									'message'      => $response['message'] . '. GMC account creatad and saved successfullys.',
									'redirect_url' => admin_url() . '/admin.php?page=ced_google',

								)
							);
							die;
						}
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			} else {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Failed to fetch USER Token',
					)
				);
				die;
			}
		}
	}

	public function ced_Save_And_CreateGoogleAdsAccount() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$account_name        = isset( $_POST['account_name'] ) ? sanitize_text_field( $_POST['account_name'] ) : false;
			$account_email       = get_option( 'ced_google_connected_gmail' );
			$connected_ads_gmail = get_option( 'ced_google_connected_ads_gmail' );
			if ( ! empty( $connected_ads_gmail ) ) {
				$account_email = get_option( 'ced_google_connected_ads_gmail' );
			}
			$google_currency = isset( $_POST['google_currency'] ) ? sanitize_text_field( $_POST['google_currency'] ) : false;
			$google_timezone = isset( $_POST['google_timezone'] ) ? sanitize_text_field( $_POST['google_timezone'] ) : false;
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data        = get_option( 'ced_google_user_login_data', true );
				$user_id                = $user_token_data['user_id'];
				$user_token             = $user_token_data['data']['token'];
				$parameters             = array();
				$parameters['Name']     = $account_name;
				$parameters['email']    = $account_email;
				$parameters['currency'] = $google_currency;
				$parameters['timeZone'] = $google_timezone;

				$header       = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl       = $this->apiUrl . '/gfront/app/createSubAdsAccount';
				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( isset( $response['id'] ) ) {
						$ads_account_details = array(
							'ads_account_id' => $response['id'],
							'name'           => $response['name'],
							'token'          => $response['token'],
						);
						update_option( 'ced_google_ads_account_data', $ads_account_details );
						update_option( 'ced_google_nav_step', '3' );

						/*
						update_option('ced_save_merchant_details', '');
						update_option('ced_save_ads_details','');
						update_option('ced_save_ads_details', '');
						update_option('ced_configuration_details','');
						update_option('ced_compaign_details','');*/

						$parameters                  = array();
						$parameters['user_id']       = $user_id;
						$parameters['customer_id']   = $response['id'];
						$parameters['customer_name'] = $response['name'];
						$header                      = array(
							'Content-Type'  => 'application/x-www-form-urlencoded',
							'Authorization' => 'Bearer ' . $user_token,
						);
						$apiUrl                      = $this->apiUrl . '/gfront/app/saveAllGoogleAdsAccount';
						$api_response                = wp_remote_post(
							$apiUrl,
							array(
								'method'      => 'POST',
								'httpversion' => '1.0',
								'sslverify'   => false,
								'timeout'     => 120,
								'headers'     => $header,
								'body'        => $parameters,
							)
						);
						if ( is_wp_error( $api_response ) ) {
							$error_message = $api_response->get_error_message();
							echo json_encode(
								array(
									'status'  => 'error',
									'message' => $response['message'],
								)
							);
							die;
						} else {
							$response            = json_decode( $api_response['body'], true );
							$ads_account_details = get_option( 'ced_google_ads_account_data', true );
							$html                = '<div class="ced_show_success_msg_after_add_googleads">';
							$html               .= '<div class="ced-no-account">';
							$html               .= '<div class="ced-no-account-icon"><img src="' . CED_WGEI_URL . 'admin/images/primaryfill.png"></div>';
							$html               .= '<div class="ced-no-account-text">';
							$html               .= '<h3>Google Ads Account Created</h3>';
							$html               .= '<p> Your new Google Ads Account <b>' . $ads_account_details['name'] . ' ' . $ads_account_details['ads_account_id'] . '</b> is created and invitation link is send to <b>' . $account_email . '</b>.<br>
                            After Accepting the invitation please setup your billing details in Ads Account.
                            <a target="_blank" href="https://accounts.google.com/AccountChooser?service=mail&continue=https://mail.google.com/mail/" class="ced-account-ads-created">Plaese accept the invitation</a></p>
                            </div>
                            </div>
                            </div>';
							echo json_encode(
								array(
									'status'  => 'success',
									'message' => $response['message'] . '.Please accept the invitation sent to your email to begin creating Smart Shopping Campaigns.',
									'html'    => $html,
								)
							);
							die;
						}
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			} else {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Failed to fetch GMC Token',
					)
				);
				die;
			}
		}
	}

	public function ced_connect_gmc_account() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$selected_gmc_account_value = isset( $_POST['selected_gmc_account_value'] ) ? sanitize_text_field( $_POST['selected_gmc_account_value'] ) : '';
			$selected_gmc_account_text  = isset( $_POST['selected_gmc_account_text'] ) ? sanitize_text_field( $_POST['selected_gmc_account_text'] ) : '';
			$from_dash                  = isset( $_POST['from_dash'] ) ? sanitize_text_field( $_POST['from_dash'] ) : '';
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data           = get_option( 'ced_google_user_login_data', true );
				$user_token                = $user_token_data['data']['token'];
				$user_id                   = $user_token_data['user_id'];
				$parameters                = array();
				$parameters['user_id']     = $user_id;
				$parameters['shop_url']    = get_permalink( wc_get_page_id( 'shop' ) );
				$parameters['merchant_id'] = $selected_gmc_account_value;
				$header                    = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                    = $this->apiUrl . '/gfront/main/setMerchantAds';
				$api_response              = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( 'Expired token' == $response['message'] ) {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die();
					} else {

						/*connecte auto gmc account - starting*/
						$parameters            = array();
						$parameters['user_id'] = $user_id;
						// $parameters['shop_url']    = get_permalink( wc_get_page_id( 'shop' ) );
						$parameters['merchant_id'] = $selected_gmc_account_value;
						$header                    = array(
							'Content-Type'  => 'application/x-www-form-urlencoded',
							'Authorization' => 'Bearer ' . $user_token,
						);
						$apiUrl                    = $this->apiUrl . '/gfront/app/autoLinkGmcWithAds';
						$api_response              = wp_remote_post(
							$apiUrl,
							array(
								'method'      => 'POST',
								'httpversion' => '1.0',
								'sslverify'   => false,
								'timeout'     => 120,
								'headers'     => $header,
								'body'        => $parameters,
							)
						);

						if ( is_wp_error( $api_response ) ) {
							$error_message = $api_response->get_error_message();
							echo json_encode(
								array(
									'status'  => 'error',
									'message' => $response['message'],
								)
							);
							die;
						}
						/*connecte auto gmc account - ending*/

						echo json_encode(
							array(
								'status'       => 'Success',
								'message'      => $response['message'],
								'redirect_url' => admin_url() . '/admin.php?page=ced_google',
							)
						);
						$parameters['name'] = $selected_gmc_account_text;
						update_option( 'ced_save_merchant_details', $parameters );
						if ( empty( $from_dash ) ) {
							update_option( 'ced_google_nav_step', '2' );
							update_option( 'ced_save_ads_details', '' );
							update_option( 'ced_save_ads_details', '' );
							update_option( 'ced_configuration_details', '' );
							update_option( 'ced_compaign_details', '' );
						}
						die;
					}
				}
			} else {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Failed to fetch GMC Token',
					)
				);
				die;
			}
		}

	}
	public function ced_skip_connect_ads_account() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			update_option( 'ced_save_ads_details', 'skipped' );
			update_option( 'ced_google_nav_step', '4' );
			update_option( 'ced_configuration_details', '' );
			update_option( 'ced_compaign_details', '' );
			echo json_encode(
				array(
					'status'       => 'Success',
					'redirect_url' => admin_url() . '/admin.php?page=ced_google',
				)
			);
			wp_die();
		}
	}

	public function ced_google_onboarding_skip() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			update_option( 'ced_compaign_details', 'skipped' );
			update_option( 'ced_google_nav_step', '5' );
			echo json_encode(
				array(
					'status'       => 'Success',
					'redirect_url' => admin_url() . '/admin.php?page=ced_google',
				)
			);
			wp_die();
		}
	}


	public function ced_connect_ads_account() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$selected_ads_account_value = isset( $_POST['selected_ads_account_value'] ) ? sanitize_text_field( $_POST['selected_ads_account_value'] ) : '';
			$selected_ads_account_text  = isset( $_POST['selected_ads_account_text'] ) ? sanitize_text_field( $_POST['selected_ads_account_text'] ) : '';
			$from_dash                  = isset( $_POST['from_dash'] ) ? sanitize_text_field( $_POST['from_dash'] ) : '';
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data          = get_option( 'ced_google_user_login_data', true );
				$user_token               = $user_token_data['data']['token'];
				$user_id                  = $user_token_data['user_id'];
				$parameters               = array();
				$parameters['user_id']    = $user_id;
				$parameters['account_id'] = $selected_ads_account_value;
				$parameters['name']       = $selected_ads_account_text;
				$header                   = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                   = $this->apiUrl . '/gfront/main/setMerchantAds';
				$api_response             = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( 'Expired token' == $response['message'] ) {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die();
					} else {

						echo json_encode(
							array(
								'status'       => 'Success',
								'message'      => $response['message'],
								'redirect_url' => admin_url() . '/admin.php?page=ced_google',
							)
						);
						update_option( 'ced_save_ads_details', $parameters );
						update_option( 'ced_google_nav_step', '3' );
						if ( empty( $from_dash ) ) {
							update_option( 'ced_configuration_details', '' );
							update_option( 'ced_compaign_details', '' );

							die();
						} else {
							$parameters               = array();
							$parameters['user_id']    = $user_id;
							$parameters['account_id'] = $selected_ads_account_value;
							$parameters['name']       = $selected_ads_account_text;
							$header                   = array(
								'Content-Type'  => 'application/x-www-form-urlencoded',
								'Authorization' => 'Bearer ' . $user_token,
							);
							$apiUrl                   = 'https://express.sellernext.com/gfront/app/autoLinkGmcWithAds';
							$api_response             = wp_remote_post(
								$apiUrl,
								array(
									'method'      => 'POST',
									'httpversion' => '1.0',
									'sslverify'   => false,
									'timeout'     => 120,
									'headers'     => $header,
									'body'        => $parameters,
								)
							);
							die();
						}
					}
				}
			} else {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Failed to fetch GMC Token',
					)
				);
				die;
			}
		}

	}

	public function ced_save_account_config_content() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$ced_products_needs_to_submit         = isset( $_POST['products_needs_to_submit'] ) ? sanitize_text_field( $_POST['products_needs_to_submit'] ) : '';
			$ced_product_variation_preference     = isset( $_POST['product_variation_preference'] ) ? sanitize_text_field( $_POST['product_variation_preference'] ) : '';
			$ced_selected_config_language         = isset( $_POST['ced_selected_config_language'] ) ? sanitize_text_field( $_POST['ced_selected_config_language'] ) : '';
			$ced_selected_config_country          = isset( $_POST['ced_selected_config_country'] ) ? sanitize_text_field( $_POST['ced_selected_config_country'] ) : '';
			$ced_selected_config_currency         = isset( $_POST['ced_selected_config_currency'] ) ? sanitize_text_field( $_POST['ced_selected_config_currency'] ) : '';
			$ced_selected_config_gender           = isset( $_POST['ced_selected_config_gender'] ) ? sanitize_text_field( $_POST['ced_selected_config_gender'] ) : '';
			$ced_selected_config_agegroup         = isset( $_POST['ced_selected_config_agegroup'] ) ? sanitize_text_field( $_POST['ced_selected_config_agegroup'] ) : '';
			$post_data                            = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
			$ced_selected_include_destination     = isset( $_POST['ced_selected_include_destination'] ) ? ( $post_data['ced_selected_include_destination'] ) : '';
			$ced_selected_brand_dropdown_value    = isset( $_POST['ced_selected_brand_dropdown_value'] ) ? sanitize_text_field( $_POST['ced_selected_brand_dropdown_value'] ) : '';
			$ced_selected_brand_input_filed_value = isset( $_POST['ced_selected_brand_input_filed_value'] ) ? sanitize_text_field( $_POST['ced_selected_brand_input_filed_value'] ) : '';
			$ced_selected_mpn_dropdown_value      = isset( $_POST['ced_selected_mpn_dropdown_value'] ) ? sanitize_text_field( $_POST['ced_selected_mpn_dropdown_value'] ) : '';
			$ced_selected_gtin_dropdown_value     = isset( $_POST['ced_selected_gtin_dropdown_value'] ) ? sanitize_text_field( $_POST['ced_selected_gtin_dropdown_value'] ) : '';
			$configuration_data                   = array();
			$configuration_data['ced_selected_config_country']          = $ced_selected_config_country;
			$configuration_data['ced_selected_config_language']         = $ced_selected_config_language;
			$configuration_data['ced_selected_config_currency']         = $ced_selected_config_currency;
			$configuration_data['ced_selected_config_gender']           = $ced_selected_config_gender;
			$configuration_data['ced_selected_config_agegroup']         = $ced_selected_config_agegroup;
			$configuration_data['ced_products_needs_to_submit']         = $ced_products_needs_to_submit;
			$configuration_data['ced_product_variation_preference']     = $ced_product_variation_preference;
			$configuration_data['ced_selected_include_destination']     = $ced_selected_include_destination;
			$configuration_data['ced_selected_brand_dropdown_value']    = $ced_selected_brand_dropdown_value;
			$configuration_data['ced_selected_brand_input_filed_value'] = $ced_selected_brand_input_filed_value;
			$configuration_data['ced_selected_mpn_dropdown_value']      = $ced_selected_mpn_dropdown_value;
			$configuration_data['ced_selected_gtin_dropdown_value']     = $ced_selected_gtin_dropdown_value;
			update_option( 'ced_configuration_details', $configuration_data );
			update_option( 'ced_google_nav_step', '4' );
			update_option( 'ced_compaign_details', '' );

			echo json_encode(
				array(
					'status'       => 'success',
					'message'      => 'Configuration Data Saved',
					'redirect_url' => admin_url() . 'admin.php?page=ced_google',

				)
			);
			die;
		}

	}

	public function ced_save_and_create_compaign() {
		$sanitized_array = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
		$check_ajax      = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$merchant_data = ! empty( get_option( 'ced_save_merchant_details' ) ) ? get_option( 'ced_save_merchant_details', true ) : false;
			if ( ! is_array( $merchant_data ) ) {
				$merchant_data = json_decode( $merchant_data, true );

			}
			$merchant_id = ! empty( $merchant_data ) ? $merchant_data['merchant_id'] : false;
			if ( ! $merchant_id ) {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Failed to get Merchant ID',
					)
				);
				die;
			}
			$google_ads_data = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );

			}
			$ads_id = ! empty( $google_ads_data ) ? $google_ads_data : false;
			if ( ! $ads_id ) {
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => 'Failed to get Google Ads ID',
					)
				);
				die;
			}
			$campaign_location_array = isset( $sanitized_array['campaign_location_array'] ) ? $sanitized_array['campaign_location_array'] : false;
			$ced_compaign_budget     = isset( $_POST['ced_compaign_budget'] ) ? sanitize_text_field( $_POST['ced_compaign_budget'] ) : false;
			$compaign_location       = isset( $_POST['compaign_location'] ) ? sanitize_text_field( $_POST['compaign_location'] ) : false;
			if ( 'India' == $compaign_location ) {
				$compaign_location = array( 2356 );
			}
			$ced_compaign_name             = isset( $_POST['ced_compaign_name'] ) ? sanitize_text_field( $_POST['ced_compaign_name'] ) : false;
			$ced_dash_campaign_start_date  = isset( $_POST['ced_dash_campaign_start_date'] ) ? sanitize_text_field( $_POST['ced_dash_campaign_start_date'] ) : false;
			$ced_dash_campaign_end_date    = isset( $_POST['ced_dash_campaign_end_date'] ) ? sanitize_text_field( $_POST['ced_dash_campaign_end_date'] ) : false;
			$ced_dash_campaign_roas_amount = isset( $_POST['ced_dash_campaign_roas_amount'] ) ? sanitize_text_field( $_POST['ced_dash_campaign_roas_amount'] ) : false;
			$compaign_details_saved        = array(
				'campaign_location_array'       => $campaign_location_array,
				'ced_compaign_budget'           => $ced_compaign_budget,
				'compaign_location'             => $compaign_location,
				'ced_compaign_name'             => $ced_compaign_name,
				'ced_dash_campaign_start_date'  => $ced_dash_campaign_start_date,
				'ced_dash_campaign_end_date'    => $ced_dash_campaign_end_date,
				'ced_dash_campaign_roas_amount' => $ced_dash_campaign_roas_amount,
			);
			if ( ! is_array( $campaign_location_array ) && empty( $campaign_location_array ) ) {
				$compaign_location = $compaign_location;
			} else {
				$compaign_location = $campaign_location_array;
			}

			$google_user_data = get_option( 'ced_google_user_login_data', true );
			$parameters       = array(
				'customer_id'       => $ads_id,
				'location_type'     => 'ALL',
				'name'              => $ced_compaign_name,
				'budget'            => array(
					'name'   => 'Standard',
					'amount' => (int) $ced_compaign_budget,
				),
				'location'          => $compaign_location,
				'shopping_settings' => array(
					'sales_country'     => 'US',
					'merchant_id'       => $merchant_id,
					'campaign_priority' => 'low',
					'enable_local'      => false,
				),
				'auto_complete'     => true,
				'user_id'           => $google_user_data['user_id'],
			);
			/*
					  print_r($parameters);
			die('dfgfd');*/
			$header       = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $google_user_data['data']['token'],
			);
			$apiUrl       = $this->apiUrl . '/googleads/main/addSmartCampaign';
			$api_response = wp_remote_post(
				$apiUrl,
				array(
					'method'      => 'POST',
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
					'headers'     => $header,
					'body'        => $parameters,
				)
			);
			if ( is_wp_error( $api_response ) ) {
				$error_message = $api_response->get_error_message();
				echo json_encode(
					array(
						'status'  => 'error',
						'message' => $response['message'],
					)
				);
				die;
			} else {
				$response = json_decode( $api_response['body'], true );
				if ( true == $response['success'] ) {
					$saved_data = array(
						'compaign_details_saved' => $compaign_details_saved,
						'api_response'           => $api_response['body'],
					);
					update_option( 'ced_compaign_details', $saved_data );
					update_option( 'ced_google_nav_step', '5' );
					echo json_encode(
						array(
							'status'       => 'success',
							'message'      => $response['message'],
							'redirect_url' => admin_url() . 'admin.php?page=ced_google',
						)
					);
					die;
				} else {
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				}
			}
		}
	}
	public function ced_google_shopping_list_per_page() {

		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$_per_page = isset( $_POST['per_page'] ) ? sanitize_text_field( $_POST['per_page'] ) : '10';
			update_option( 'ced_google_shopping_list_per_page', $_per_page );
			wp_die( esc_attr( $_per_page ) );
		}
	}


	public function ced_good_shopping_process_bulk_action( $auto_product_data = array() ) {
		$google_shopping_products_ids = isset( $auto_product_data['product_id'] ) ? $auto_product_data['product_id'] : array();
		if ( ! empty( $auto_product_data ) ) {
			$check_ajax = true;
		} else {
			$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		}
		if ( $check_ajax ) {
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$status = 400;
			if ( ! empty( $auto_product_data ) ) {
				$google_shopping_products_ids = isset( $auto_product_data['product_id'] ) ? $auto_product_data['product_id'] : '';
				$operation                    = isset( $auto_product_data['operation'] ) ? $auto_product_data['operation'] : '';
			} else {
				$operation                    = isset( $_POST['operation'] ) ? sanitize_text_field( $_POST['operation'] ) : '';
				$post_data                    = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
				$google_shopping_products_ids = isset( $post_data['google_shopping_products_ids'] ) ? $post_data['google_shopping_products_ids'] : array();
			}

			if ( 'save_Bulk_Product' == $operation ) {
				if ( ! is_array( $google_shopping_products_ids ) || empty( $google_shopping_products_ids ) ) {
					return false;
				}
				$user_token_data  = get_option( 'ced_google_user_login_data', true );
				$user_id          = $user_token_data['user_id'];
				$merchant_details = get_option( 'ced_save_merchant_details', true );

				$product_finalised_data = array();
				$count                  = 10;
				foreach ( $google_shopping_products_ids as $product_id ) {
					$process_mode = 'CREATE';
					$prep_data    = $this->ced_good_shopping_prepare_bulk_data( $product_id, $process_mode, $count );
					if ( 'simple' == $prep_data['type'] && ! empty( $prep_data['data'] ) ) {
						$product_data[] = $prep_data['data'];
					} elseif ( 'variable' == $prep_data['type'] ) {
						foreach ( $prep_data['data'] as $key => $value ) {
							$product_data[] = $value;
						}
					}
					$count++;

				}
				$product_finalised_data = $product_data;
				
				/*print_r( $product_finalised_data );
				die( 'dfgdf' );*/
				if ( ! empty( $product_finalised_data ) ) {
					if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
						$user_token_data            = get_option( 'ced_google_user_login_data', true );
						$user_token                 = $user_token_data['data']['token'];
						$user_id                    = $user_token_data['user_id'];
						$parameters                 = array();
						$parameters['user_id']      = $user_id;
						$parameters['merchant_id']  = $merchant_details['merchant_id'];
						$parameters['product_data'] = ( $product_finalised_data );
						$header                     = array(
							'Authorization' => 'Bearer ' . $user_token,
						);
						$apiUrl                     = $this->apiUrl . '/connector/product/uploadProductsToGMC';
						$api_response               = wp_remote_post(
							$apiUrl,
							array(
								'method'      => 'POST',
								'httpversion' => '1.0',
								'sslverify'   => false,
								'timeout'     => 120,
								'headers'     => $header,
								'body'        => $parameters,
							)
						);
						$data                       = array(
							'api_url'    => $apiUrl,
							'parameters' => $parameters,
							'headers'    => $header,
						);

						$response                   = json_decode( $api_response['body'], true );
						if ( is_wp_error( $api_response ) ) {
							$error_message = $api_response->get_error_message();
							echo json_encode(
								array(
									'status'  => 'error',
									'message' => $response['message'],
								)
							);
							die;
						} else {
							$response = json_decode( $api_response['body'], true );
							/*
							print_r($response);
							die('yuio');*/
							if ( true == $response['success'] ) {
								$product_upload_response = $response;

								$product_response_entries = $product_upload_response['response']['entries'];
								if ( isset( $product_upload_response['response']['entries'] ) ) {
									foreach ( $product_response_entries as $product_response_entries_key => $product_response_entries_values ) {
										$woo_product_id    = isset( $product_response_entries_values['batchId'] ) ? $product_response_entries_values['batchId'] : '';
										$_parent_product   = wc_get_product( $woo_product_id );
										$parent_product_id = $_parent_product->get_parent_id();
										if ( ! empty( $parent_product_id ) ) {
											$woo_product_id = $parent_product_id;
										}
										$google_product_id = isset( $product_response_entries_values['product']['id'] ) ? $product_response_entries_values['product']['id'] : '';
										if ( ! empty( $google_product_id ) ) {
											$merchant_details      = get_option( 'ced_save_merchant_details', true );
											$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';
											update_post_meta( $woo_product_id, 'ced_product_updated_on_google_' . $connected_merchant_id, $google_product_id );
										}
									}
									$google_shopping_product_upload_status              = array();
									$google_shopping_product_upload_status['feed_data'] = json_encode( $product_upload_response['response']['entries'] );
									$google_shopping_product_upload_status['feed_time'] = gmdate( 'l jS \of F Y h:i:s A' );

									global $wpdb;
									$prefix                            = $wpdb->prefix;
									$google_shopping_status_table      = $prefix . 'google_shopping_product_upload_status';
									$google_shopping_product_insert_id = $this->insert_in_db( $google_shopping_product_upload_status, $google_shopping_status_table );

								}
								if ( ! empty( $auto_product_data ) ) {
									$message = array(
										'status'       => 'success',
										'message'      => 'Products imported successfully, please check the status on dashboard notification section.',
										'redirect_url' => admin_url() . 'admin.php?page=ced_google',
									);
									return $message;
								} else {
									echo json_encode(
										array(
											'status'       => 'success',
											'message'      => 'Products imported successfully, please check the status on dashboard notification section.',
											'redirect_url' => admin_url() . 'admin.php?page=ced_google',
										)
									);
									die;
								}
							} else {
								if ( ! empty( $auto_product_data ) ) {
									$message = array(
										'status'  => 'error',
										'message' => $response['message'],
									);
								} else {
									echo json_encode(
										array(
											'status'  => 'error',
											'message' => $response['message'],
										)
									);
									die;
								}
							}
						}
					}
					if ( ! empty( $auto_product_data ) ) {
						return 'Not able to fetch merchnat account';
					} else {
						die;
					}
				}
			} elseif ('delete_from_gmc' == $operation) {
				if ( ! is_array( $google_shopping_products_ids ) || empty( $google_shopping_products_ids ) ) {
					return false;
				}
				$user_token_data  = get_option( 'ced_google_user_login_data', true );
				$user_id          = $user_token_data['user_id'];
				$merchant_details = get_option( 'ced_save_merchant_details', true );
				$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';

				$product_ids_for_unpublished = array();
				foreach ( $google_shopping_products_ids as $product_id ) {
					$unpublished_product_id = get_post_meta($product_id, 'ced_product_updated_on_google_' . $connected_merchant_id, true);
					$product_ids_for_unpublished[] = $unpublished_product_id;
				}
				if ( ! empty( $product_ids_for_unpublished ) ) {
					if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
						$user_token_data            = get_option( 'ced_google_user_login_data', true );
						$user_token                 = $user_token_data['data']['token'];
						$user_id                    = $user_token_data['user_id'];
						$parameters                 = array();
						$parameters['user_id']      = $user_id;
						$parameters['merchant_id']  = $merchant_details['merchant_id'];
						$parameters['product_Id'] = $product_ids_for_unpublished;
						$header                     = array(
							'Authorization' => 'Bearer ' . $user_token,
						);
						// $apiUrl                     = $this->apiUrl . '/connector/product/uploadProductsToGMC';
						$apiUrl                     ='https://express.sellernext.com/google/app/deleteProductFromGoogle';
						$api_response               = wp_remote_post(
							$apiUrl,
							array(
								'method'      => 'POST',
								'httpversion' => '1.0',
								'sslverify'   => false,
								'timeout'     => 120,
								'headers'     => $header,
								'body'        => $parameters,
							)
						);
						$response                   = json_decode( $api_response['body'], true );
						// print_r($response); die('popop');
						if ( is_wp_error( $api_response ) ) {
							$error_message = $api_response->get_error_message();
							echo json_encode(
								array(
									'status'  => 'error',
									'message' => $response['message'],
								)
							);
							die;
						} else {
							$response = json_decode( $api_response['body'], true );
							if ( true == $response['success'] ) {
								foreach ( $google_shopping_products_ids as $product_id ) {
									delete_post_meta($product_id, 'ced_product_updated_on_google_' . $connected_merchant_id);
								}
								echo json_encode(
									array(
										'status'       => 'success',
										'message'      => 'Selected product delete successfully.',
										'redirect_url' => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-products',
									)
								);
								die;
							} else {
								if ( ! empty( $auto_product_data ) ) {
									$message = array(
										'status'  => 'error',
										'message' => $response['message'],
									);
								} else {
									echo json_encode(
										array(
											'status'  => 'error',
											'message' => $response['message'],
										)
									);
									die;
								}
							}
						}
					}
					if ( ! empty( $auto_product_data ) ) {
						return 'Not able to fetch merchnat account';
					} else {
						die;
					}
				}
			}
		}
	}

	public function ced_good_shopping_prepare_bulk_data( $product_id, $process_mode, $count ) {
		if ( empty( $product_id ) ) {
			return;
		}
		$_product     = wc_get_product( $product_id );
		$type         = $_product->get_type();
		$product_data = array();
		if ( 'variable' == $type ) {
			$variations = $_product->get_children();
			if ( is_array( $variations ) && ! empty( $variations ) ) {
				foreach ( $variations as $index => $variation_id ) {
					$vari_pro_data                    = $this->google_product_data_prepration( $variation_id, $count, $product_id );
					$ced_configuration_details        = get_option( 'ced_configuration_details', true );
					$ced_product_variation_preference = isset( $ced_configuration_details['ced_product_variation_preference'] ) ? $ced_configuration_details['ced_product_variation_preference'] : '';
					if ( 'All Variants' == $ced_product_variation_preference ) {
						$vari_product_data[] = $vari_pro_data;
					} else {
						$vari_product_data[] = $vari_pro_data;
						break;

					}
					$count++;
				}
				$prepared_product_data = $vari_product_data;
				return array(
					'data' => $prepared_product_data,
					'type' => 'variable',
				);
			}
		} else {
			$prepared_product_data = $this->google_product_data_prepration( $product_id, $count, '' );
		}

		return array(
			'data' => $prepared_product_data,
			'type' => 'simple',
		);

	}
	public function google_product_data_prepration( $product_id, $count, $variation_parent_id = '' ) {
		$main_id = $product_id;
		if ( ! empty( $variation_parent_id ) ) {
			$main_id = $variation_parent_id;
		}

		$profile_name = $this->ced_google_shopping_get_profile_name( $main_id );
		// target country
		$targetCountry = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_country' );
		if ( empty( $targetCountry ) ) {
			$targetCountry = $this->ced_google_shopping_fetch_default_data( 'ced_selected_config_country' );
		}
		// include destination
		$incliude_destinaiton = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_include_destination' );
		if ( empty( $incliude_destinaiton ) ) {
			$incliude_destinaiton = $this->ced_google_shopping_fetch_default_data( 'ced_selected_include_destination' );
		}
		// language -
		$contentLanguage = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_language' );
		if ( empty( $contentLanguage ) ) {
			$contentLanguage = $this->ced_google_shopping_fetch_default_data( 'ced_selected_config_language' );
		}
		// currency
		$currency = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_currency' );
		if ( empty( $currency ) ) {
			$currency = $this->ced_google_shopping_fetch_default_data( 'ced_selected_config_currency' );
		}
		// age_group
		$ageGroup = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_agegroup' );
		if ( empty( $ageGroup ) ) {
			$ageGroup = $this->ced_google_shopping_fetch_default_data( 'ced_selected_config_agegroup' );
		}
		// gender
		$gender = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_gender' );
		if ( empty( $gender ) ) {
			$gender = $this->ced_google_shopping_fetch_default_data( 'ced_selected_config_gender' );
		}
		// itemGroupId_val need to implimebnt
		$iTemGrouIdCondition = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_itemGroupId_val' );
		if ( empty( $iTemGrouIdCondition ) ) {
			$iTemGrouIdCondition = 'set';
		}
		// isAdult_val
		$iSadult = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_isAdult_val' );
		if ( empty( $iSadult ) ) {
			$iSadult = 'no';
		}
		// fixed_inv_val
		$Fixed_inventory_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_fixed_inv_val' );
		if ( empty( $Fixed_inventory_value ) ) {
			$Fixed_inventory_value = get_post_meta( $product_id, '_stock', true );

		}
		$Threshold_inventory_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_threshold_inv_val' );
		if ( empty( $Threshold_inventory_value ) ) {
			$Threshold_inventory_value = 0;
		}
		if ( $Threshold_inventory_value > 0 ) {
			$Fixed_inventory_value = (int) $Fixed_inventory_value - (int) $Threshold_inventory_value;
			$Fixed_inventory_value = ( $Fixed_inventory_value < 0 ) ? 0 : $Fixed_inventory_value;
		}
		$ced_configuration_details                         = get_option( 'ced_configuration_details', true );
		$google_taxonomy_from_configuration = isset($ced_configuration_details['ced_selected_defualt_google_taxanomoy_value']) ? $ced_configuration_details['ced_selected_defualt_google_taxanomoy_value'] : '';
		if (empty($google_taxonomy_from_configuration)) {
			$google_taxonomy = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_google_taxonomy_val' );
		} else {
			$google_taxonomy = $google_taxonomy_from_configuration;
		}
		if ( empty( $google_taxonomy ) ) {
			$google_taxonomy = '';
		}
		// repricer_flow_val
		$repricer_flow   = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_repricer_flow_val' );
		$repricier_type  = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_repricer_type_val' );
		$repricier_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_profile_repricer_val' );
		$price           = get_post_meta( $product_id, '_price', true );
		if ( $repricier_value ) {
			if ( 'increment' == $repricer_flow && 'fixed' == $repricier_type ) {
				$price = $price + $repricier_value;
			}
			if ( 'increment' == $repricer_flow && 'percentage' == $repricier_type ) {
				$price = $price + ( $price * $repricier_value / 100 );
			}
			if ( 'decrement' == $repricer_flow && 'fixed' == $repricier_type ) {
				$price = $price - $repricier_value;
			}
			if ( 'decrement' == $repricer_flow && 'percentage' == $repricier_type ) {
				$price = $price - ( $price * $repricier_value / 100 );
			}
		}
		$brand_selected_text_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_selected_brand_input_filed_value' );
		if ( empty( $brand_selected_text_value ) ) {
			$brand_selected_text_value = $this->ced_google_shopping_fetch_default_data( 'ced_selected_brand_input_filed_value' );
		}
		$brand_selected_dropdown_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_selected_brand_dropdown_value' );
		if ( empty( $brand_selected_dropdown_value ) ) {
			$brand_selected_dropdown_value = $this->ced_google_shopping_fetch_default_data( 'ced_selected_brand_dropdown_value' );
		}
		$mpn_sleceted_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_selected_mpn_dropdown_value' );
		if ( empty( $mpn_sleceted_value ) ) {
			$mpn_sleceted_value = $this->ced_google_shopping_fetch_default_data( 'ced_selected_mpn_dropdown_value' );
		}
		$gtin_sleceted_value = $this->ced_google_shopping_fetch_data_from_profile( $profile_name, 'ced_gs_selected_gtin_dropdown_value' );
		if ( empty( $gtin_sleceted_value ) ) {
			$gtin_sleceted_value = $this->ced_google_shopping_fetch_default_data( 'ced_selected_gtin_dropdown_value' );
		}
		$product_id_view_saved_setting = get_option( 'ced_google_shopping_product_id_view' );
		if ( 'Woocommerce_{{targetCountry}}_{{ sourceProductId }}_{{ sourceVariantId }}' == $product_id_view_saved_setting ) {
			$variation_parent_id_for_id_and_offer = ! empty( $variation_parent_id ) ? '_' . $variation_parent_id : '';
			$product_and_offer_id                 = 'WooCommerce_' . $targetCountry . '_' . $product_id . '' . $variation_parent_id_for_id_and_offer;
		}
		if ( '{{ sourceVariantId }}' == $product_id_view_saved_setting ) {
			$product_and_offer_id = ! empty( $variation_parent_id ) ? $variation_parent_id : $product_id;
		}
		if ( '{{ sku }}' == $product_id_view_saved_setting ) {
			$sku                  = get_post_meta( $product_id, '_sku', true );
			$product_and_offer_id = $sku;
		}
		if ( empty( $product_id_view_saved_setting ) ) {
			$product_id_view_saved_setting = $product_id;
		}

		$_product     = wc_get_product( $product_id );
		$product_data = $_product->get_data();
		$product_name = $product_data['name'];
		$offer_id     = $product_id;
		$description  = $product_data['description'];
		if ( empty( $description ) ) {
			$description = $product_data['short_description'];
		}
		$description = preg_replace( '/\[.*?\]/', '', $description );
		$weight      = get_post_meta( $product_id, '_weight', 'true' );

		// $stock = get_post_meta( $product_id, '_stock', true );
		$stock = $Fixed_inventory_value;
		if ( empty( $Fixed_inventory_value ) || 0 == $Fixed_inventory_value ) {
			$stock = 0;
		}
		$stock_status = $product_data['stock_status'];
		if ( 'instock' == $stock_status ) {
			$stock_status = 'in_stock';
		} elseif ( 'outofstock' == $stock_status ) {
			$stock_status = 'out_of_stock';
		}
		$image_url_id = $product_data['image_id'];

		$attachment_ids[] = $image_url_id;
		if ( ! empty( $attachment_ids ) ) {
			foreach ( $attachment_ids as $key => $attachment_id ) {
				if ( empty( wp_get_attachment_url( $attachment_id ) ) ) {
					continue;
				}
				$image_url = $this->get_img_data( $attachment_id );
			}
		}
		$config_saved_data = get_option( 'ced_configuration_details', true );
		$destination       = array(
			'Surfaces across Google' => 'Surfaces across Google',
			'Shopping'               => 'Shopping',
			'Display Ads'            => 'Display Ads',
			'Shopping Actions'       => 'Shopping Actions',
		);

		$excluded_destinaiton = array_unique( array_diff( $destination, $incliude_destinaiton ) );
		$excluded_destinaiton = array_values( $excluded_destinaiton );
		if ( strpos( $mpn_sleceted_value, 'umb_pattr_' ) !== false ) {
			$wooAttribute       = explode( 'umb_pattr_', $mpn_sleceted_value );
			$wooAttribute       = end( $wooAttribute );
			$mpn_sleceted_value = $_product->get_attribute( $wooAttribute );
		} else {
			$mpn_sleceted_value = get_post_meta( $product_id, $mpn_sleceted_value, true );
		}
		if ( strpos( $gtin_sleceted_value, 'umb_pattr_' ) !== false ) {
			$wooAttribute        = explode( 'umb_pattr_', $gtin_sleceted_value );
			$wooAttribute        = end( $wooAttribute );
			$gtin_sleceted_value = $_product->get_attribute( $wooAttribute );
		} else {
			$gtin_sleceted_value = get_post_meta( $product_id, $gtin_sleceted_value, true );
		}

		if ( ! empty( $brand_selected_text_value ) ) {
			$brand_value = $brand_selected_text_value;
		} else {
			if ( strpos( $brand_selected_dropdown_value, 'umb_pattr_' ) !== false ) {
				$wooAttribute = explode( 'umb_pattr_', $brand_selected_dropdown_value );
				$wooAttribute = end( $wooAttribute );
				$brand_value  = $_product->get_attribute( $wooAttribute );
			} else {
				$brand_value = get_post_meta( $product_id, $brand_selected_dropdown_value, true );
			}
		}
		$product_link = get_permalink( $product_id );
		$terms        = get_the_terms( $product_id, 'product_cat' );
		foreach ( $terms  as $term ) {
			$product_cat_name[] = $term->name;
		}
		$variation_parent_id_for_id_and_offer     = ! empty( $variation_parent_id ) ? '_' . $variation_parent_id : '';
		$sku                                      = get_post_meta( $product_id, '_sku', true );
		$merchant_details                         = get_option( 'ced_save_merchant_details', true );
		$itemgoupid                               = '';
		$conditon                                 = 'new';
		$channel                                  = 'online';
		$simple_product_data                      = array();
		$simple_product_data['method']            = 'insert';
		$simple_product_data['merchantId']        = $merchant_details['merchant_id'];
		$simple_product_data['batchId']           = $product_id;
		$all_data_related_product                 = array();
		$all_data_related_product['id']           = $product_and_offer_id;
		$all_data_related_product['offerId']      = $product_and_offer_id;
		$all_data_related_product['title']        = $product_name;
		$all_data_related_product['description']  = $description;
		$all_data_related_product['availability'] = $stock_status;
		$all_data_related_product['gtin']         = $gtin_sleceted_value;
		$all_data_related_product['sellOnGoogleQuantity'] = (int) $stock;
		$all_data_related_product['link']                 = $product_link;
		$all_data_related_product['brand']                = $brand_value;
		if ( ! empty( $weight ) ) {
			$all_data_related_product['shippingWeight'] = array(
				'unit'  => 'g',
				'value' => $weight,
			);
		}
		$all_data_related_product['channel']         = 'online';
		$all_data_related_product['condition']       = 'new';
		$all_data_related_product['contentLanguage'] = $contentLanguage;
		$all_data_related_product['customLabel4']    = 'Uploaded By CedCommerce';
		$all_data_related_product['adult']           = $iSadult;
		$all_data_related_product['imageLink']       = ! empty( $image_url ) ? $image_url : '';
		$all_data_related_product['mpn']             = $mpn_sleceted_value;
		if ( ! empty( $variation_parent_id ) && 'set' == $iTemGrouIdCondition ) {
			$itemgroupid = $variation_parent_id;
		} else {
			$itemgroupid = '';
		}
		$all_data_related_product['itemGroupId']           = $itemgroupid;
		$all_data_related_product['targetCountry']         = $targetCountry;
		$all_data_related_product['productTypes']          = $product_cat_name;
		$all_data_related_product['color']                 = '';
		$all_data_related_product['googleProductCategory'] = $google_taxonomy;
		$all_data_related_product['ageGroup']              = $ageGroup;
		$all_data_related_product['gender']                = $gender;
		$all_data_related_product['price']                 = array(
			'currency' => $currency,
			'value'    => $price,
		);
		$all_data_related_product['shippingLabel']         = '';
		$all_data_related_product['includedDestinations']  = $incliude_destinaiton;
		$all_data_related_product['excludedDestinations']  = $excluded_destinaiton;
		$simple_product_data['product']                    = $all_data_related_product;
		return $simple_product_data;

	}

	public function ced_google_shopping_get_profile_name( $id = 0 ) {
		$profile_name = '';
		$term_list    = wp_get_post_terms(
			$id,
			'product_cat',
			array(
				'fields' => 'ids',
			)
		);
		// $cat_id = (int) $term_list[0];
		if ( is_array( $term_list ) ) {
			$mapped_cat = get_option( 'ced_google_shopping_profiles', '' );
			if ( ! empty( $mapped_cat ) ) {
				$mapped_cat = json_decode( $mapped_cat, true );
				foreach ( $term_list as $cat_id ) {
					foreach ( $mapped_cat as $key => $value ) {
						if ( in_array( $cat_id, $mapped_cat[ $key ]['ced_gs_profile_selected_category'] ) ) {
							$profile_name = $key;
							// die($profile_name);
							return $profile_name;
						}
					}
				}
			}
		}
	}


	public function ced_google_shopping_fetch_default_data( $index = '' ) {
		if ( empty( $index ) ) {
			return;
		}
		$config_saved_data = get_option( 'ced_configuration_details', true );
		// return $config_saved_data;
		if ( ! empty( $config_saved_data ) ) {
			$value = $config_saved_data[ $index ];
			return $value;
		}
	}


	public function ced_google_shopping_fetch_data_from_profile( $profile_name = '', $index = '' ) {

		if ( empty( $index ) ) {
			return;
		}

		$profile_data = get_option( 'ced_google_shopping_profiles', '' );
		if ( ! empty( $profile_data ) ) {
			$profile_data = json_decode( $profile_data, true );
			$value        = isset( $profile_data[ $profile_name ][ $index ] ) ? $profile_data[ $profile_name ][ $index ] : '';
			return $value;
		}
	}


	public function get_img_data( $image_url_id ) {
		$woo_products_image = wp_get_attachment_url( $image_url_id );
		// print_r(exif_imagetype($woo_products_image));die;

		if ( ! empty( $woo_products_image ) ) {
			$imgdata                     = file_get_contents( $woo_products_image );
			$mime_type                   = getimagesizefromstring( $imgdata );
			$img_send_data               = base64_encode( $imgdata );
			$image_data_api[0]           = home_url();
			$image_data_api_file['file'] = $woo_products_image;
			return ( $image_data_api_file['file'] );
		}
		return '';
	}
	public function insert_in_db( $details, $tableName ) {
		global $wpdb;
		$wpdb->insert( $tableName, $details );
		$id = $wpdb->insert_id;
		return $id;
	}

	public function ced_google_reset_connected_account() {
		update_option( 'ced_google_user_login_data', '' );
		update_option( 'is_user_logged_in', '' );
		update_option( 'ced_google_account_data', '' );
		update_option( 'ced_google_another_account_data', '' );
		update_option( 'ced_google_GMC_account_data', '' );
		update_option( 'ced_google_ads_account_data', '' );
		update_option( 'ced_save_merchant_details', '' );
		update_option( 'ced_save_ads_details', '' );
		update_option( 'ced_configuration_details', '' );
		update_option( 'ced_compaign_details', '' );
		update_option( 'ced_google_nav_step', '' );
		echo json_encode(
			array(
				'status'       => 'success',
				'redirect_url' => admin_url() . 'admin.php?page=ced_google',
			)
		);
		wp_die();

	}

	public function ced_google_save_product_automate_setting() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$product_sync                  = isset( $_POST['product_sync'] ) ? sanitize_text_field( $_POST['product_sync'] ) : '';
			$existing_product_sync         = isset( $_POST['existing_product_sync'] ) ? sanitize_text_field( $_POST['existing_product_sync'] ) : '';
			$instant_product_sync         = isset( $_POST['instant_product_sync'] ) ? sanitize_text_field( $_POST['instant_product_sync'] ) : '';
			$product_automate_setting_data = array(
				'product_sync'          => $product_sync,
				'existing_product_sync' => $existing_product_sync,
				'instant_product_sync' => $instant_product_sync,
			);

			if ( 'on' == $product_sync ) {
				wp_clear_scheduled_hook( 'ced_google_shopping_auto_product_syncing' );
				update_option( 'ced_google_shopping_auto_product_syncing', $auto_fetch_orders_and_inventory );
				wp_schedule_event( time(), 'ced_google_shopping_10min', 'ced_google_shopping_auto_product_syncing' );
			} else {
				delete_option( 'ced_google_shopping_auto_product_syncing' );
				wp_clear_scheduled_hook( 'ced_google_shopping_auto_product_syncing' );
			}
			if ( 'on' == $existing_product_sync ) {
				wp_clear_scheduled_hook( 'ced_google_shopping_auto_existing_product_syncing' );
				update_option( 'ced_google_shopping_auto_existing_product_syncing', $auto_fetch_orders_and_inventory );
				wp_schedule_event( time(), 'ced_google_shopping_10min', 'ced_google_shopping_auto_existing_product_syncing' );
			} else {
				delete_option( 'ced_google_shopping_auto_existing_product_syncing' );
				wp_clear_scheduled_hook( 'ced_google_shopping_auto_existing_product_syncing' );
			}
			if ( 'on' == $instant_product_sync ) {
				wp_clear_scheduled_hook( 'ced_google_shopping_auto_instant_product_syncing' );
				update_option( 'ced_google_shopping_auto_instant_product_syncing', $auto_fetch_orders_and_inventory );
				wp_schedule_event( time(), 'ced_google_shopping_10min', 'ced_google_shopping_auto_instant_product_syncing' );
			} else {
				delete_option( 'ced_google_shopping_auto_instant_product_syncing' );
				wp_clear_scheduled_hook( 'ced_google_shopping_auto_instant_product_syncing' );
			}
			update_option( 'ced_google_shopping_product_automate_setting_data', $product_automate_setting_data );
			echo json_encode(
				array(
					'status'  => 'success',
					'message' => 'Product Automation Setting Saved',
				)
			);
			wp_die();
		}
	}

	public function ced_google_shopping_cron_schedules( $schedules ) {
		if ( ! isset( $schedules['ced_google_shopping_5min'] ) ) {
			$schedules['ced_google_shopping_5min'] = array(
				'interval' => 5 * 60,
				'display'  => __( 'Once every 5 minutes' ),
			);
		}
		if ( ! isset( $schedules['ced_google_shopping_10min'] ) ) {
			$schedules['ced_google_shopping_10min'] = array(
				'interval' => 10 * 60,
				'display'  => __( 'Once every 10 minutes' ),
			);
		}
		if ( ! isset( $schedules['ced_google_shopping_15min'] ) ) {
			$schedules['ced_google_shopping_15min'] = array(
				'interval' => 15 * 60,
				'display'  => __( 'Once every 15 minutes' ),
			);
		}
		if ( ! isset( $schedules['ced_google_shopping_30min'] ) ) {
			$schedules['ced_google_shopping_30min'] = array(
				'interval' => 30 * 60,
				'display'  => __( 'Once every 30 minutes' ),
			);
		}
		return $schedules;
	}
	/**
	 *  Listing And Smart Shopping Campaign For Google ced_google_shopping_auto_product_syncing.
	 *  wp-admin/admin-ajax.php?action=ced_google_shopping_auto_product_syncing
	 *
	 * @since 1.0.0
	 */
	public function ced_google_shopping_auto_product_syncing() {
		// update_option('ced_google_shopping_chunk_products',array());
		$products_to_sync = get_option( 'ced_google_shopping_chunk_products', array() );
		if ( empty( $products_to_sync ) ) {

			$merchant_details      = get_option( 'ced_save_merchant_details', true );
			$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';
			$meta_key              = 'ced_product_updated_on_google_' . $connected_merchant_id;
			$store_products        = get_posts(
				array(
					'numberposts'  => -1,
					'post_type'    => array( 'product' ),
					'meta_key'     => $meta_key,
					'meta_compare' => 'not exists',
				)
			);
			$store_products        = wp_list_pluck( $store_products, 'ID' );
			$products_to_sync      = array_chunk( $store_products, 10 );
		}
		if ( ! empty( $products_to_sync[0] ) && is_array( $products_to_sync[0] ) && ! empty( $products_to_sync[0] ) ) {
			$auto_product_data  = array(
				'product_id' => $products_to_sync[0],
				'operation'  => 'save_Bulk_Product',
			);
			$get_product_detail = $this->ced_good_shopping_process_bulk_action( $auto_product_data );
			unset( $products_to_sync[0] );
			$products_to_sync = array_values( $products_to_sync );
			update_option( 'ced_google_shopping_chunk_products', $products_to_sync );
		}
	}

	/**
	 *  Listing And Smart Shopping Campaign For Google ced_google_shopping_auto_existing_product_syncing.
	 *  wp-admin/admin-ajax.php?action=ced_google_shopping_auto_existing_product_syncing
	 *
	 * @since 1.0.0
	 */

	public function ced_google_shopping_auto_existing_product_syncing() {
		$products_to_sync = get_option( 'ced_google_shopping_existing_chunk_products', array() );
		if ( empty( $products_to_sync ) ) {

			$merchant_details      = get_option( 'ced_save_merchant_details', true );
			$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';
			$meta_key              = 'ced_product_updated_on_google_' . $connected_merchant_id;
			$store_products        = get_posts(
				array(
					'numberposts'  => -1,
					'post_type'    => array( 'product' ),
					'meta_key'     => $meta_key,
					'meta_value'   => '',
					'meta_compare' => '!=',
				)
			);
			$store_products        = wp_list_pluck( $store_products, 'ID' );
			$products_to_sync      = array_chunk( $store_products, 10 );
		}
		if ( ! empty( $products_to_sync[0] ) && is_array( $products_to_sync[0] ) && ! empty( $products_to_sync[0] ) ) {
			$auto_product_data  = array(
				'product_id' => $products_to_sync[0],
				'operation'  => 'save_Bulk_Product',
			);
			$get_product_detail = $this->ced_good_shopping_process_bulk_action( $auto_product_data );
			unset( $products_to_sync[0] );
			$products_to_sync = array_values( $products_to_sync );
			update_option( 'ced_google_shopping_existing_chunk_products', $products_to_sync );
		}
	}
	/*
	----------------------------------------------------------------------------------------------
	------ this funciton used for link and unlink the gmc account ---------------------- -----------
	-----------------------------------------------------------------------------------------------*/
	public function ced_dash_gmc_unlink() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$current_service_linkid = isset( $_POST['current_service_linkid'] ) ? sanitize_text_field( $_POST['current_service_linkid'] ) : '';
			$operator               = isset( $_POST['operator'] ) ? sanitize_text_field( $_POST['operator'] ) : '';
			$google_ads_data        = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data             = get_option( 'ced_google_user_login_data', true );
				$user_token                  = $user_token_data['data']['token'];
				$user_id                     = $user_token_data['user_id'];
				$parameters                  = array();
				$parameters['customer_id']   = $ads_id;
				$parameters['serviceLinkId'] = $current_service_linkid;
				if ( ! empty( $operator ) ) {
					$parameters['operator'] = 'SET';
				} else {
					$parameters['operator'] = 'REMOVE';
				}
				$parameters['linkStatus'] = 'ACTIVE';

				$header       = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl       = 'https://express.sellernext.com/gfront/main/updateMerchantAccountLink';
				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						echo json_encode(
							array(
								'status'  => 'success',
								'message' => $response['message'],

							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			}
		}
	}
	/*
	----------------------------------------------------------------------------------------------
	------ this funciton used for retrive the campaign location during edit the campaign -----------
	-----------------------------------------------------------------------------------------------*/
	public function ced_dash_get_campaign_location() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$campaign_id     = isset( $_POST['campaign_id'] ) ? sanitize_text_field( $_POST['campaign_id'] ) : '';
			$google_ads_data = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data          = get_option( 'ced_google_user_login_data', true );
				$user_token               = $user_token_data['data']['token'];
				$user_id                  = $user_token_data['user_id'];
				$parameters               = array();
				$parameters['customerId'] = $ads_id;
				$parameters['campaignId'] = $campaign_id;
				$header                   = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                   = 'https://express.sellernext.com/gfront/app/getCampaignLocations';
				$api_response             = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				/*
				print_r($api_response);
				die('cvxc');*/
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						echo json_encode(
							array(
								'status'  => 'success',
								'message' => $response['data'],
							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			}
		}

	}

	/*
	--------------------------------------------------------------------------------------------
	------ this funciton used for eidt and update the campaign status of gmax campaign -----------
	---------------------------------------------------------------------------------------------*/
	public function ced_update_gmax_campaign() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$google_ads_data = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$sanitized_array                = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
			$campaign_location_array        = isset( $sanitized_array['campaign_location_array'] ) ? $sanitized_array['campaign_location_array'] : false;
			$campaign_id_during_edit        = isset( $_POST['campaign_id_during_edit'] ) ? sanitize_text_field( $_POST['campaign_id_during_edit'] ) : '';
			$campaign_budget_id_during_edit = isset( $_POST['campaign_budget_id_during_edit'] ) ? sanitize_text_field( $_POST['campaign_budget_id_during_edit'] ) : '';
			$campaign_submited_name         = isset( $_POST['campaign_submited_name'] ) ? sanitize_text_field( $_POST['campaign_submited_name'] ) : '';
			$campaign_submited_budget       = isset( $_POST['campaign_submited_budget'] ) ? sanitize_text_field( $_POST['campaign_submited_budget'] ) : '';
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data = get_option( 'ced_google_user_login_data', true );
				$user_token      = $user_token_data['data']['token'];
				$user_id         = $user_token_data['user_id'];
				$parameters      = array(
					'customer_id'       => $ads_id,
					'name'              => $campaign_submited_name,
					'budget'            => $campaign_submited_budget,
					'budgetId'          => $campaign_budget_id_during_edit,
					'campaign_id'       => $campaign_id_during_edit,
					'locations'         => $campaign_location_array,
					'status'            => 'Updated',
					'exclude_locations' => array(),
				);
				$header          = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl          = $this->apiUrl . '/gfront/main/updateCampaign';
				$api_response    = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['data'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						$saved_data = array(
							'compaign_details_saved' => $compaign_details_saved,
							'api_response'           => $api_response['body'],
						);
						update_option( 'ced_compaign_details', $saved_data );
						update_option( 'ced_google_nav_step', '5' );
						echo json_encode(
							array(
								'status'       => 'success',
								'message'      => $response['data'],
								'redirect_url' => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-campaigns',
							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			}
		}
	}

	/*
	---------------------------------------------------------------------------------
	------ this funciton used for change the campaign status of gmc account -----------
	---------------------------------------------------------------------------------*/
	public function ced_update_gmax_campaign_status() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$campaign_id     = isset( $_POST['campaign_id'] ) ? sanitize_text_field( $_POST['campaign_id'] ) : '';
			$campaign_status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : '';
			$google_ads_data = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data                 = get_option( 'ced_google_user_login_data', true );
				$user_token                      = $user_token_data['data']['token'];
				$user_id                         = $user_token_data['user_id'];
				$parameters                      = array();
				$parameters['budgetId']          = '';
				$parameters['customer_id']       = $ads_id;
				$parameters['campaign_id']       = $campaign_id;
				$parameters['exclude_locations'] = array();
				$parameters['locations']         = array();
				$parameters['status']            = $campaign_status;

				$header       = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl       = 'https://express.sellernext.com/gfront/main/updateCampaign';
				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				$api_error    = array(
					'header'       => $header,
					'parameters'   => $parameters,
					'api_response' => $api_response,
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						echo json_encode(
							array(
								'status'  => 'success',
								'message' => $response['message'],
							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			}
		}
	}


	/*
	--------------------------------------------------------------------------
	------ this funciton used for re-connect the removed gmc account -----------
	--------------------------------------------------------------------------*/

	public function ced_ads_gids_after_remove_gmc_acnt() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$ced_ads_google_ids = isset( $_POST['ced_ads_google_ids'] ) ? sanitize_text_field( $_POST['ced_ads_google_ids'] ) : '';
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data = get_option( 'ced_google_user_login_data', true );
				$user_token      = $user_token_data['data']['token'];
				$user_id         = $user_token_data['user_id'];
				$parameters      = array();
				$header          = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl          = 'https://express.sellernext.com/google/app/getAccountDetails';
				$api_response    = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['message'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						$alter_merchant_center_data = $response['Data'];
						if ( is_array( $alter_merchant_center_data ) && ! empty( $alter_merchant_center_data ) ) {
							$alter_merchant_center_data['adsLinks'][] = array(
								'adsId'  => $ced_ads_google_ids,
								'status' => 'pending',
							);
							$parameters                               = array();
							$parameters['Data']                       = ( $alter_merchant_center_data );
							$header                                   = array(
								'Content-Type'  => 'application/x-www-form-urlencoded',
								'Authorization' => 'Bearer ' . $user_token,
							);
							$apiUrl                                   = 'https://express.sellernext.com/google/app/alterMerchantCenterDetails';
							$api_response                             = wp_remote_post(
								$apiUrl,
								array(
									'method'      => 'POST',
									'httpversion' => '1.0',
									'sslverify'   => false,
									'timeout'     => 120,
									'headers'     => $header,
									'body'        => $parameters,
								)
							);
							$api_error                                = array(
								'header'       => $header,
								'parameters'   => $parameters,
								'api_response' => $api_response,
							);
							if ( is_wp_error( $api_response ) ) {
								$error_message = $api_response->get_error_message();
								echo json_encode(
									array(
										'status'  => 'error',
										'message' => $response['message'],
									)
								);
								die;
							} else {
								$response = json_decode( $api_response['body'], true );
								if ( true == $response['success'] ) {
									echo json_encode(
										array(
											'status'       => 'success',
											'message'      => $response['message'],
											'redirect_url' => admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-account',
										)
									);
									die;
								} else {
									echo json_encode(
										array(
											'status'  => 'error',
											'message' => $response['message'],
										)
									);
									die;
								}
							}
						}
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['message'],
							)
						);
						die;
					}
				}
			}
		}
	}
	/*
	--------------------------------------------------------------------------
	------ this funciton used for re-connect the removed gmc account -----------
	--------------------------------------------------------------------------*/

	public function ced_google_create_conversion() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$ced_google_conversion_name                        = isset( $_POST['ced_google_conversion_name'] ) ? sanitize_text_field( $_POST['ced_google_conversion_name'] ) : '';
			$ced_google_conversion_action_track_category       = isset( $_POST['ced_google_conversion_action_track_category'] ) ? sanitize_text_field( $_POST['ced_google_conversion_action_track_category'] ) : '';
			$ced_google_conversion_action_track_count          = isset( $_POST['ced_google_conversion_action_track_count'] ) ? sanitize_text_field( $_POST['ced_google_conversion_action_track_count'] ) : '';
			$ced_google_throug_cnvrsn_windw_max_time_after_day = isset( $_POST['ced_google_throug_cnvrsn_windw_max_time_after_day'] ) ? sanitize_text_field( $_POST['ced_google_throug_cnvrsn_windw_max_time_after_day'] ) : '';
			$ced_google_throug_cnvrsn_windw_max_time_view      = isset( $_POST['ced_google_throug_cnvrsn_windw_max_time_view'] ) ? sanitize_text_field( $_POST['ced_google_throug_cnvrsn_windw_max_time_view'] ) : '';
			$ced_google_conversion_attribute_model             = isset( $_POST['ced_google_conversion_attribute_model'] ) ? sanitize_text_field( $_POST['ced_google_conversion_attribute_model'] ) : '';
			$google_ads_data                                   = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data                           = get_option( 'ced_google_user_login_data', true );
				$user_token                                = $user_token_data['data']['token'];
				$user_id                                   = $user_token_data['user_id'];
				$parameters                                = array();
				$parameters['attribution_model_type']      = $ced_google_conversion_attribute_model;
				$parameters['counting_type']               = $ced_google_conversion_action_track_count;
				$parameters['ctc_lookback_window']         = $ced_google_throug_cnvrsn_windw_max_time_after_day;
				$parameters['viewthrough_lookback_window'] = $ced_google_throug_cnvrsn_windw_max_time_view;
				$parameters['customer_id']                 = $ads_id;
				$parameters['name']                        = $ced_google_conversion_name;
				$parameters['tracker_category']            = $ced_google_conversion_action_track_category;

				$header       = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl       = 'https://express.sellernext.com/gfront/main/createConversion';
				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				$api_error    = array(
					'header'       => $header,
					'parameters'   => $parameters,
					'api_response' => $api_response,
				);
					/*
				print_r($api_error);
					die('sdf');*/
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['data'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						echo json_encode(
							array(
								'status'  => 'success',
								'message' => $response['data'],
							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['data'],
							)
						);
						die;
					}
				}
			}
		}
	}

	public function ced_show_created_conversion_popup() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$conversionid    = isset( $_POST['conversionid'] ) ? sanitize_text_field( $_POST['conversionid'] ) : '';
			$globalSiteTag   = isset( $_POST['globalSiteTag'] ) ? sanitize_text_field( $_POST['globalSiteTag'] ) : '';
			$google_ads_data = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data             = get_option( 'ced_google_user_login_data', true );
				$user_token                  = $user_token_data['data']['token'];
				$user_id                     = $user_token_data['user_id'];
				$parameters                  = array();
				$parameters['customer_id']   = $ads_id;
				$parameters['conversion_id'] = $conversionid;
				$header                      = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                      = 'https://express.sellernext.com/gfront/main/getConversionById';
				$api_response                = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['data'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
						if ( 'insertInHeader' == $globalSiteTag ) {
							update_option( 'ced_google_shopping_cnvrsn_global_site_tags', $response['data']['rows'][0]['GoogleGlobalSiteTag'] );
							echo json_encode(
								array(
									'status'       => 'uploaded',
									'redirect_url' => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-conversions',
								)
							);
							die;
						}
						echo json_encode(
							array(
								'status'  => 'success',
								'message' => $response['data'],
							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['data'],
							)
						);
						die;
					}
				}
			}
		}

	}

	public function ced_auto_create_conversion_and_upload_tag() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$ced_google_conversion_name                        = 'CedCommere_purchase_tag';
			$ced_google_conversion_action_track_category       = 'PURCHASE';
			$ced_google_conversion_action_track_count          = 'MANY_PER_CLICK';
			$ced_google_throug_cnvrsn_windw_max_time_after_day = 30;
			$ced_google_throug_cnvrsn_windw_max_time_view      = 30;
			$$ced_google_conversion_attribute_model            = '';
			$google_ads_data                                   = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data                           = get_option( 'ced_google_user_login_data', true );
				$user_token                                = $user_token_data['data']['token'];
				$user_id                                   = $user_token_data['user_id'];
				$parameters                                = array();
				$parameters['without_attribution_model']   = true;
				$parameters['counting_type']               = $ced_google_conversion_action_track_count;
				$parameters['ctc_lookback_window']         = $ced_google_throug_cnvrsn_windw_max_time_after_day;
				$parameters['viewthrough_lookback_window'] = $ced_google_throug_cnvrsn_windw_max_time_view;
				$parameters['customer_id']                 = $ads_id;
				$parameters['name']                        = $ced_google_conversion_name;
				$parameters['tracker_category']            = $ced_google_conversion_action_track_category;

				$header       = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl       = 'https://express.sellernext.com/gfront/main/createConversion';
				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['data'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( true == $response['success'] ) {
							update_option( 'ced_google_shopping_cnvrsn_global_site_tags', $response['data'][0]['GoogleGlobalSiteTag'] );
							echo json_encode(
								array(
									'status'       => 'uploaded',
									'redirect_url' => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-conversions',
								)
							);
							wp_die();
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['data'],
							)
						);
						die;
					}
				}
			}
		}
	}

	public function ced_google_shopping_get_Ads_reports() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$google_ads_data = ! empty( get_option( 'connected_google_ads_id' ) ) ? get_option( 'connected_google_ads_id', true ) : false;
			if ( ! is_array( $google_ads_data ) ) {
				$google_ads_data = json_decode( $google_ads_data, true );
			}
			$ads_id        = ! empty( $google_ads_data ) ? $google_ads_data : false;
			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			$campaign_type       = isset( $_POST['campaign_type'] ) ? sanitize_text_field( $_POST['campaign_type'] ) : '';
			$campaign_date_range = isset( $_POST['campaign_date_range'] ) ? sanitize_text_field( $_POST['campaign_date_range'] ) : '';
			$download_report     = isset( $_POST['download_report'] ) ? sanitize_text_field( $_POST['download_report'] ) : '';
			$campaign_status     = isset( $_POST['campaign_status'] ) ? sanitize_text_field( $_POST['campaign_status'] ) : '';
			if ( 'all' == $campaign_status ) {
				$campaign_status = array( 'ENABLED', 'PAUSED' );
			} else {
				$campaign_status = array( $campaign_status );
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data          = get_option( 'ced_google_user_login_data', true );
				$user_token               = $user_token_data['data']['token'];
				$user_id                  = $user_token_data['user_id'];
				$parameters               = array();
				$parameters['customerId'] = $ads_id;
				$parameters['dateRange']  = $campaign_date_range;
				$parameters['reportType'] = $campaign_type;
				$parameters['status']     = $campaign_status;
				$header                   = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				// ---------------------------------------------------
				// Api call for get default report here  ---
				// ---------------------------------------------------
				$apiUrl       = 'https://express.sellernext.com/gfront/app/getReportFeilds';
				$api_response = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				/*
							  print_r($api_response);
				dei('dfg');
				*/              if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['data'],
						)
					);
					die;
} else {
	$response = json_decode( $api_response['body'], true );
	if ( true == $response['success'] ) {

		if ( ! empty( $download_report ) && 'enabled' == $download_report ) {
			if ( ! empty( $response['data'] ) && is_array( $response['data'] ) ) {

				$wpuploadDir = wp_upload_dir();
				$baseDir     = $wpuploadDir['basedir'];
				$uploadDir   = $baseDir . '/products_listing_sheet';
				$nameTime    = time();
				if ( ! is_dir( $uploadDir ) ) {
					mkdir( $uploadDir, 0777, true );
				}
				$file = fopen( $uploadDir . '/conversion_report.csv', 'w' );
				fprintf( $file, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
				$conversion_report_header = array( 'Campaign Name', 'Campaign Type', 'Campaign Status', 'Clicks', 'Impressions', 'Conversions', 'Conversions Value', 'CTR', 'CPC', 'Cost' );
				fputcsv( $file, $conversion_report_header );
				$reports_fields_prepared_array = $response['data'];
				$report_table_content          = '';
				foreach ( $reports_fields_prepared_array as $reports_fields_prepared_array_key => $reports_fields_prepared_array_val ) {
					$campaign_name                   = $reports_fields_prepared_array_val['Campaign_name'];
					$campaign_type                   = $reports_fields_prepared_array_val['type'];
					$campaign_status                 = $reports_fields_prepared_array_val['status'];
					$campaign_clicks                 = $reports_fields_prepared_array_val['clicks'];
					$campaign_impression             = $reports_fields_prepared_array_val['impressions'];
					$campaign_conversion             = $reports_fields_prepared_array_val['conversion'];
					$campaign_conversions_value      = $reports_fields_prepared_array_val['conversions_value'];
					$campaign_CTR                    = $reports_fields_prepared_array_val['ctr'];
					$campaign_CPC                    = $reports_fields_prepared_array_val['cpc'];
					$campaign_Cost                   = $reports_fields_prepared_array_val['cost'];
					$conversion_report_content_array = array( $campaign_name, $campaign_type, $campaign_status, $campaign_clicks, $campaign_impression, $campaign_conversion, $campaign_conversions_value, $campaign_CTR, $campaign_CPC, $campaign_Cost );
					fputcsv( $file, $conversion_report_content_array );
				}
				fclose( $file );
				
				echo json_encode(
					array(
						'status'     => 'success',
						'table_html' => ( home_url() . '/wp-content/uploads/products_listing_sheet/conversion_report.csv' ),
					)
				);
				die();
			} else {
				echo json_encode(
					array(
						'status'     => 'success',
						'table_html' => '',
					)
				);
				die();
			}
		} elseif ( ! empty( $response['data'] ) && is_array( $response['data'] ) ) {
			$reports_fields_prepared_array = $response['data'];
			$report_table_content          = '';
			foreach ( $reports_fields_prepared_array as $reports_fields_prepared_array_key => $reports_fields_prepared_array_val ) {
				$report_table_content .= '<tr class="ced-data-content">';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['Campaign_name'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['type'] . '</p></td>';
				$report_table_content .= '<td><p class="ced-badge">' . $reports_fields_prepared_array_val['status'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['clicks'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['impressions'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['conversion'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['conversions_value'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['ctr'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['cpc'] . '</p></td>';
				$report_table_content .= '<td><p>' . $reports_fields_prepared_array_val['cost'] . '</p></td>';
				$report_table_content .= '</tr>';
			}
		}
		echo json_encode(
			array(
				'status'     => 'success',
				'table_html' => $report_table_content,
			)
		);
		die;
	} else {
		echo json_encode(
			array(
				'status'  => 'error',
				'message' => $response['data'],
			)
		);
		die;
	}
}
			}
		}
	}

	public function ced_insert_google_conversion_global_site_tag() {
		$saved_conversion_global_site_tag = get_option( 'ced_google_shopping_cnvrsn_global_site_tags', true );
		if ( ! empty( $saved_conversion_global_site_tag ) ) {
			print_r( $saved_conversion_global_site_tag );
		}
		$saved_caliam_and_verify_site_tag = get_option( 'ced_google_shopping_claim_and_verify_token', true );
		if ( ! empty( $saved_caliam_and_verify_site_tag ) ) {
			print_r( $saved_caliam_and_verify_site_tag );
		}
	}

	public function ced_create_and_save_profile() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$profile_name = isset( $_POST['profile_name'] ) ? sanitize_text_field( $_POST['profile_name'] ) : '';
			echo json_encode(
				array(
					'message'      => 'success',
					'redirect_url' => admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-profile&action=profile_creation&profile_name=' . $profile_name . '',
				)
			);
			 wp_die();
		}

	}


	public function ced_gs_proffile_create_and_save() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {

			$profile_name    = isset( $_POST['ced_gs_profile_name'] ) ? sanitize_text_field( $_POST['ced_gs_profile_name'] ) : '';
			$profile_name    = trim( $profile_name );
			$sanitized_array = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

			$profileData = get_option( 'ced_google_shopping_profiles' );
			if ( empty( $profileData ) ) {
				$profileData = array();
			} else {
				 $profileData = json_decode( $profileData, 1 );
			}

			$category_mapped = $sanitized_array['ced_gs_profile_selected_category'];
			/*
			print_r($sanitized_array);
			die('df');*/
			$updated_category = get_option( 'ced_google_shopping_mapped_categories', '' );

			if ( ! empty( $updated_category ) ) {
				 $updated_category = json_decode( $updated_category, 1 );

			} else {
				$updated_category = array();

			}

			$final_cat = array_merge( $updated_category, $category_mapped );
			update_option( 'ced_google_shopping_mapped_categories', json_encode( array_unique( $final_cat ) ) );

			if ( ! empty( $sanitized_array ) ) {

				foreach ( $sanitized_array as $p_key => $p_value ) {
					if ( 'ced_gs_profile_name' == $p_key || 'ajax_nonce' == $p_key || 'action' == $p_key ) {

							 continue;
					}
					if ( empty( $sanitized_array[ $p_key ] ) ) {
						 continue;
					}
					$profileData[ $profile_name ][ $p_key ] = empty( $p_value ) ? '' : $p_value;
				}
			}

			update_option( 'ced_google_shopping_profiles', json_encode( $profileData ), 1 );

		}
		echo json_encode(
			array(
				'message'      => 'success',
				'redirect_url' => admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-profile',
			)
		);
		wp_die();
	}

	public function ced_delete_existing_profile() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$profileData  = get_option( 'ced_google_shopping_profiles' );
			$profile_name = isset( $_POST['profile_name'] ) ? sanitize_text_field( $_POST['profile_name'] ) : '';
			if ( ! empty( $profileData ) ) {
				$profileData = json_decode( $profileData, 1 );
				foreach ( $profileData as $profileData_key => $profileData_val ) {
					if ( $profileData_key == $profile_name ) {
						unset( $profileData[ $profileData_key ] );
					}
				}
			}
			update_option( 'ced_google_shopping_profiles', json_encode( $profileData ), 1 );
			echo json_encode(
				array(
					'message'      => 'success',
					'redirect_url' => admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-profile',
				)
			);
			wp_die();
		}
	}
	public function ced_save_google_product_id_view() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$product_id_view = isset( $_POST['product_id_view'] ) ? sanitize_text_field( $_POST['product_id_view'] ) : '';
			if ( ! empty( $product_id_view ) ) {
				update_option( 'ced_google_shopping_product_id_view', $product_id_view );
				echo json_encode(
					array(
						'message' => 'success',
					)
				);
			}
			wp_die();
		}
	}
	public function ced_save_global_config_contents() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$ced_configuration_details = get_option( 'ced_configuration_details', true );
			if ( ! is_array( $ced_configuration_details ) ) {
				$ced_configuration_details = array();
			};
			/*
			var_dump($ced_configuration_details);
			die('dfd')*/
			$ced_selected_brand_dropdown_value                                 = isset( $_POST['ced_selected_brand_dropdown_value'] ) ? sanitize_text_field( $_POST['ced_selected_brand_dropdown_value'] ) : '';
			$ced_selected_brand_input_filed_value                              = isset( $_POST['ced_selected_brand_input_filed_value'] ) ? sanitize_text_field( $_POST['ced_selected_brand_input_filed_value'] ) : '';
			$ced_selected_mpn_dropdown_value                                   = isset( $_POST['ced_selected_mpn_dropdown_value'] ) ? sanitize_text_field( $_POST['ced_selected_mpn_dropdown_value'] ) : '';
			$ced_selected_gtin_dropdown_value                                  = isset( $_POST['ced_selected_gtin_dropdown_value'] ) ? sanitize_text_field( $_POST['ced_selected_gtin_dropdown_value'] ) : '';
			$ced_selected_defualt_google_taxanomoy_value                                  = isset( $_POST['ced_selected_defualt_google_taxanomoy_value'] ) ? sanitize_text_field( $_POST['ced_selected_defualt_google_taxanomoy_value'] ) : '';
			$ced_configuration_details['ced_selected_brand_dropdown_value']    = $ced_selected_brand_dropdown_value;
			$ced_configuration_details['ced_selected_brand_input_filed_value'] = $ced_selected_brand_input_filed_value;
			$ced_configuration_details['ced_selected_mpn_dropdown_value']      = $ced_selected_mpn_dropdown_value;
			$ced_configuration_details['ced_selected_gtin_dropdown_value']     = $ced_selected_gtin_dropdown_value;
			$ced_configuration_details['ced_selected_defualt_google_taxanomoy_value']     = $ced_selected_defualt_google_taxanomoy_value;
			update_option( 'ced_configuration_details', $ced_configuration_details );
			echo json_encode(
				array(
					'message' => 'success',
				)
				);
				wp_die();
		}
	}
	public function ced_gs_gmc_verify_and_claim() {
		$check_ajax = check_ajax_referer( 'ced-wgei-ajax-seurity-string', 'ajax_nonce' );
		if ( $check_ajax ) {
			$websiteurl = isset( $_POST['websiteurl'] ) ? sanitize_text_field( $_POST['websiteurl'] ) : '';

			$compare_token = get_transient( 'time_during_create_google_token' );
			if ( '' == $compare_token ) {
				regenerate_expired_token_for_google_shopping_intigration();
			}
			if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
				$user_token_data           = get_option( 'ced_google_user_login_data', true );
				$user_token                = $user_token_data['data']['token'];
				$user_id                   = $user_token_data['user_id'];
				$parameters                = array();
				$parameters['user_id']     = $user_id;
				$parameters['website_url'] = $websiteurl;
				$header                    = array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Bearer ' . $user_token,
				);
				$apiUrl                    = 'https://express.sellernext.com/google/app/getMetaVerificationToken';
				$api_response              = wp_remote_post(
					$apiUrl,
					array(
						'method'      => 'POST',
						'httpversion' => '1.0',
						'sslverify'   => false,
						'timeout'     => 120,
						'headers'     => $header,
						'body'        => $parameters,
					)
				);
				if ( is_wp_error( $api_response ) ) {
					$error_message = $api_response->get_error_message();
					echo json_encode(
						array(
							'status'  => 'error',
							'message' => $response['data'],
						)
					);
					die;
				} else {
					$response = json_decode( $api_response['body'], true );
					if ( 1 == $response['success'] ) {
						$token_data = isset( $response['response']['token'] ) ? $response['response']['token'] : '';
						/*
											  echo (json_encode($token_data));
						die('fv');*/
						update_option( 'ced_google_shopping_claim_and_verify_token', $token_data );
						echo json_encode(
							array(
								'status'       => 'success',
								'redirect_url' => admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-verifyandclaim',
							)
						);
						die;
					} else {
						echo json_encode(
							array(
								'status'  => 'error',
								'message' => $response['data'],
							)
						);
						die;
					}
				}
			}
		}
	}

	public function ced_google_shopping_stock_update_after_post_meta( $meta_id, $post_id, $meta_key, $meta_value ) {
		if ( '_stock' == $meta_key || '_price' == $meta_key ) {
			$products_to_sync = get_option( 'ced_google_shopping_update_meta_chunk_product', array() );

			$_product = wc_get_product( $post_id );
			$type     = $_product->get_type();
			if ( 'variable' == $type ) {
				$array_pro_to_push = $_product->get_children();
			} else {

				$array_pro_to_push[] = $post_id;
			}
			if ( ! $products_to_sync ) {
				$pro_array_update = array( $array_pro_to_push );
			} else {

				$products_to_sync[] = $array_pro_to_push;
				$pro_array_update   = $products_to_sync;
			}
			$pro_array_update = array_reverse( $pro_array_update );
			$pro_array_update = array_map( 'unserialize', array_unique( array_map( 'serialize', $pro_array_update ) ) );
			update_option( 'ced_google_shopping_update_meta_chunk_product', $pro_array_update );
		}
	}

	/**
	 *  Google Shopping Integration for WooCommerce ced_google_sync_product_while_update_post_meta.
	 *  wp-admin/admin-ajax.php?action=ced_google_sync_product_while_update_post_meta
	 *
	 * @since 1.0.0
	 */

	public function ced_google_sync_product_while_update_post_meta() {
		$products_to_sync = get_option( 'ced_google_shopping_update_meta_chunk_product', array() );
		if ( ! empty( $products_to_sync[0] ) && is_array( $products_to_sync[0] ) && ! empty( $products_to_sync[0] ) ) {
			$auto_product_data  = array(
				'product_id' => $products_to_sync[0],
				'operation'  => 'save_Bulk_Product',
			);
			$get_product_detail = $this->ced_good_shopping_process_bulk_action( $auto_product_data );
			unset( $products_to_sync[0] );
			$products_to_sync = array_values( $products_to_sync );
			update_option( 'ced_google_shopping_update_meta_chunk_product', $products_to_sync );
		}
	}

	public function ced_delete_product_from_gmc_while_deleting_from_woo($post_id) {
		if (get_post_type($post_id) === 'product') {
			$user_token_data  = get_option( 'ced_google_user_login_data', true );
			$user_id          = $user_token_data['user_id'];
			$merchant_details = get_option( 'ced_save_merchant_details', true );
			$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';
			$unpublished_product_id = get_post_meta($post_id, 'ced_product_updated_on_google_' . $connected_merchant_id, true);
			$product_ids_for_unpublished = array();
			$product_ids_for_unpublished[] = $unpublished_product_id;
			if ( ! empty( $product_ids_for_unpublished ) ) {
				if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
					$user_token_data            = get_option( 'ced_google_user_login_data', true );
					$user_token                 = $user_token_data['data']['token'];
					$user_id                    = $user_token_data['user_id'];
					$parameters                 = array();
					$parameters['user_id']      = $user_id;
					$parameters['merchant_id']  = $merchant_details['merchant_id'];
					$parameters['product_Id'] = $product_ids_for_unpublished;
					$header                     = array(
						'Authorization' => 'Bearer ' . $user_token,
					);
					// $apiUrl                     = $this->apiUrl . '/connector/product/uploadProductsToGMC';
					$apiUrl                     ='https://express.sellernext.com/google/app/deleteProductFromGoogle';
					$api_response               = wp_remote_post(
						$apiUrl,
						array(
							'method'      => 'POST',
							'httpversion' => '1.0',
							'sslverify'   => false,
							'timeout'     => 120,
							'headers'     => $header,
							'body'        => $parameters,
						)
					);
					$data                       = array(
						'api_url'    => $apiUrl,
						'parameters' => $parameters,
						'headers'    => $header,
					);
					// print_r($data);
					/*$response                   = json_decode( $api_response['body'], true );
					print_r($response); die('popop');*/
				}
			}
		}
	}

}
