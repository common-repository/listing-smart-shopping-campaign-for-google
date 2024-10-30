<?php
$home_url = get_home_url();
require CED_WGEI_DIRPATH . 'admin/lib/listing-and-smart-shopping-campaign-for-google-lib.php';
$google_shopping_lib_object = new Google_Shopping_Lib();
// $google_shopping_get_connected_acount = $google_shopping_lib_object->google_shopping_get_connected_acount();
// $all_gmc_accounts                     = $google_shopping_lib_object->google_shopping_get_connected_merechant_acount();
$get_all_step_data          = $google_shopping_lib_object->google_shopping_get_connected_googleads_acount( 'from_dash' );
$google_supported_currency  = $google_shopping_lib_object->google_shopping_get_google_supported_currency();
$google_supported_timezones = file( CED_WGEI_DIRPATH . 'admin/timezones.txt' );
$merchant_details           = get_option( 'ced_save_merchant_details', true );
$connected_gmail            = isset( $get_all_step_data['connected_gmail'] ) ? $get_all_step_data['connected_gmail'] : '';
$google_gmc                 = isset( $get_all_step_data['connected_gmc_account'] ) ? $get_all_step_data['connected_gmc_account'] : '';
$google_ads                 = isset( $get_all_step_data['connected_gads_account'] ) ? $get_all_step_data['connected_gads_account'] : '';
$all_gmc_accounts           = isset( $get_all_step_data['active_all_Gmcs_accounts'] ) ? $get_all_step_data['active_all_Gmcs_accounts'] : '';
$google_ads_account_details = isset( $get_all_step_data['active_all_Gads_accounts'] ) ? $get_all_step_data['active_all_Gads_accounts'] : '';

foreach ( $all_gmc_accounts as $all_gmc_accounts_key => $all_gmc_accounts_val ) {
	if ( $all_gmc_accounts_val['merchantId'] == $google_gmc ) {
		$google_gmc = array(
			'name'        => $all_gmc_accounts_val['accountName'],
			'merchant_id' => $all_gmc_accounts_val['merchantId'],
		);
	}
}

foreach ( $google_ads_account_details as $google_ads_account_details_key => $google_ads_account_details_val ) {
	if ( $google_ads_account_details_val['customer_id'] == $google_ads ) {
		$google_ads = array(
			'name'       => $google_ads_account_details_val['account_name'],
			'account_id' => $google_ads_account_details_val['customer_id'],
		);
	}
}
$ads_details = get_option( 'ced_save_ads_details', true );


/*config content*/
require_once ABSPATH . 'wp-admin/includes/translation-install.php';
$wc_countries          = new WC_Countries();
$woo_countries         = $wc_countries->get_countries();
$woo_languages         = wp_get_available_translations();
$currency_code_options = get_woocommerce_currencies();
$woo_store_categories  = get_terms( 'product_cat' );
foreach ( $currency_code_options as $code => $name ) {
	$currency_code_options[ $code ] = $name . ' (' . get_woocommerce_currency_symbol( $code ) . ')';
}
$woo_currencies = $currency_code_options;
$age_group      = array(
	'New Born (Upto 3 months old' => 'New Born (Upto 3 months old',
	'Infant (3 to 12 months)'     => 'Infant (3 to 12 months',
	'Toddler (1-5 years)'         => 'Toddler (1-5 years)',
	'Kids (5-13 years)'           => 'Kids (5-13 years)',
	'Adults'                      => 'Adults',
);
$gender         = array(
	'Male'   => 'Male',
	'Female' => 'Female',
	'Other'  => 'Other',
);
// $ced_configuration_details = get_option( 'ced_configuration_details', true );


$ced_google_user_login_data = get_option( 'ced_google_user_login_data' );
if ( ! empty( $ced_google_user_login_data ) && is_array( $ced_google_user_login_data ) ) {

	$user_id               = $ced_google_user_login_data['user_id'];
	$user_token            = $ced_google_user_login_data['data']['token'];
	$parameters            = array();
	$parameters['user_id'] = $user_id;
	$header                = array(
		'Content-Type'  => 'application/x-www-form-urlencoded',
		'Authorization' => 'Bearer ' . $user_token,
	);
	// $apiUrl                = 'https://dev-express.sellernext.com/frontend/app/getStepData';
	$apiUrl               = 'https://express.sellernext.com/user/getDetails';
	$user_details_content = wp_remote_post(
		$apiUrl,
		array(
			'body'        => $parameters,
			'headers'     => $header,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'timeout'     => 120,
		)
	);
}
if ( isset( $user_details_content['body'] ) ) {
	$user_response = json_decode( $user_details_content['body'], true );
	$user_response = $user_response['data'];
}
?>
<div class="ced__Main">
	<div class="ced-Layout__Primary-Secondary ced-Layout">
		<div class="ced-Layout__Primary">
			<div class="ced-card ced-card--plain">
				<div class="ced-card__Body">
					<div class="ced__cardContent">
						<div class="ced-pageHeader ">
							<div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
								<div class="ced-flex__item">
									<h3 class="ced__Heading">
										<h3 class="ced__Heading">Accounts</h3>
									</h3>
								</div>

							</div>
						</div>
						<!---cardcontent-->
						<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
							<div class="ced-flex__item">
								<div class="mt-30">
									<div class="ced-card  ">
										<div class="ced-card__Body">
											<div class="ced__cardContent">
												<div class="ced-flex ced-flex--wrap">
													<!-- account setting -->
													<div class="ced-log-table">
														<div class="ced__Subheading"> <h3>Google Account </h3></div>
														<div class="ced-box-data ced_google_shopping_google_re_connect_create_google_account">
															<div class="ced-box-data-pc"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/g-logo.png' ); ?>"></div> 

															<?php
																// print_r($user_response);
															?>
															<div class="ced-box-para"> 
																<h4><b>Account Connected Successfully </b></h4>
																<p>Your shop is <strong><?php echo esc_html_e( get_bloginfo( 'name' ) ); ?></strong> and your Google account is <strong><?php esc_html_e( $connected_gmail ); ?></strong> </p>
															</div>
														</div>
														<div class="ced_google_shopping_google_re_connect_create_google_account_content">

															<div class="ced_gogole_signin_wrapper ced-inline-wrap">

																<div class="ced-validation">
																	<input type="checkbox" class="ced-checkbox ced_acceptTerm_checkbox"><span class="ced-accept">Accept Terms & Conditions </span>
																	<span class="ced-policy"><a target="_blank" href="https://apps.cedcommerce.com/express/app/show/policy">Read Policy </a></span>

																</div>
																<div class="ced-g-sign-in-button">
																	<div class="content-wrapper" id="ced_signinwithgoogle_createuser_dash" data-store="<?php echo esc_html_e( $home_url ); ?>" data-email="<?php esc_html_e( get_option( 'admin_email' ) ); ?>" data-framework="woocommerce" data-storename="<?php echo esc_html_e( get_bloginfo( 'name' ) ); ?>">
																		<div class="logo-wrapper">
																			<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/g-logo.png' ); ?>">
																		</div>
																		<span class="text-container">
																			<span>Sign in with Google</span>
																		</span>
																	</div>

																</div>
																<span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
															</div>

														</div>
														<div class="ced-box-button ced-right-btn ced_btn_google_re_connect_account" data-hide_attr="ced_google_shopping_google_re_connect_create_google_account", data-show_attr="ced_google_shopping_google_re_connect_create_google_account_content">
															<a href="">Change Account</a>
														</div>
													</div>

													<!-- GMC Setting -->
													<div class="ced-log-table">
														<div class="ced__Subheading"> <h3>Google Merchant Account </h3></div>
														<div class="ced-box-data ced_google_shopping_google_re_connect_merchant_account">
															<div class="ced-box-data-pc"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/g-logo.png' ); ?>"></div> 
															<div class="ced-box-para"> 
																<?php
																if ( empty( $google_gmc ) ) {
																	?>
																	<h4><b>Google Merchant Connected</b></h4>
																	<p> please connect your GMC account. </p>
																	<?php
																} else {
																	?>
																	<h4><b>Google Merchant Not Connected</b></h4>
																	<p>Your Google Merchant Center name is <b><?php esc_html_e( $google_gmc['name'] ); ?></b> and your Google Merchant ID is <b><?php esc_html_e( $google_gmc['merchant_id'] ); ?></b></p>
																	<?php
																}
																?>
															</div>
														</div>
														<div class="ced_google_shopping_google_re_connect_merchant_account_content">
															<div class="ced_google_dash_gmc_wrapper">
																<div class="ced-icon-text">
																	<select class="ced-select-merchant" id="ced_selected_gmc_account" name="">
																		<option class="ced-opt" value="" selected>Select Google Merchant Center Account</option>
																		<?php
																		if ( ! empty( $all_gmc_accounts ) ) {
																			foreach ( $all_gmc_accounts as $key => $gmcdetail ) {
																				if ( $merchant_details['merchant_id'] == $gmcdetail['merchantId'] ) {
																					$selected = 'selected';
																				} else {
																					$selected = '';
																				}
																				printf( '<option class="ced_gmc_option"' . esc_attr( $selected ) . ' value="' . esc_attr( $gmcdetail['merchantId'] ) . '"><h5>' . esc_attr( $gmcdetail['accountName'] ) . '</h5> <p><span>' . esc_attr( $gmcdetail['merchantId'] ) . '</span></p> </option>' );
																			}
																		}
																		?>
																	</select>



																	<div class="ced_non_select_error ced_show_error_nonselecet_gmc">
																		<span class="ced_error_icon">
																			<img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">Select Account to proceed
																		</span>
																	</div>
																</div>

																<div class="ced-button-combo ced-right-btn">
																	<div class="ced-button-create">
																		<a href="#create_account">Create New Account</a>
																	</div>
																	<div class="ced-button-save" id="ced_dash_connect_gmc_account">
																		<a href="">Connect Account</a>
																	</div>
																	<span class="ced_google_loader"><img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>">
																	</span>
																</div>
															</div>


														</div>
														<div class="ced-box-button ced_btn_google_re_connect_account ced_btn_google_re_connect_merchant_account" data-hide_attr="ced_google_shopping_google_re_connect_merchant_account", data-show_attr="ced_google_shopping_google_re_connect_merchant_account_content">
															<a href="">Change Account</a>
														</div>
													</div>

													<!-- Gads Setting -->
													<div class="ced-log-table">
														<div class="ced__Subheading"> <h3>Google Ads Account </h3></div>
														<div class="ced-box-data ced_google_shopping_google_re_connect_gAds_account">
															<div class="ced-box-data-pc"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/check.png' ); ?>"></div> 
															<div class="ced-box-para"> 
																<?php
																if ( empty( $google_ads ) ) {
																	?>
																	<h4><b>Google Ads Not Connected</b></h4>
																	<p> please connect your GMC account. </p>
																	<?php
																} else {
																	?>
																	<p>Your Google Ads Account name is <b><?php esc_html_e( isset( $google_ads['name'] ) ? $google_ads['name'] : '' ); ?></b> and your Google Ads Customer ID is <b><?php esc_html_e( isset( $google_ads['account_id'] ) ? $google_ads['account_id'] : '' ); ?></b>from your connected gmail.</p>
																	<?php
																}
																?>
																
															</div>
														</div>
														<div class="ced_google_shopping_google_re_connect_gAds_account_content">
															<div class="ced_google_ads_refresh_warpper">
																<select class="ced-select-merchant" id="ced_selected_ads_account" name="">
																	<option class="ced-opt" value=""  selected>Select Google Ads Account</option>
																	<?php
																	foreach ( $google_ads_account_details as $key => $ads ) {
																		if ( $ads_details['account_id'] == $ads['customer_id'] ) {
																			$selected = 'selected';
																		} else {
																			$selected = '';
																		}
																		printf( '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $ads['customer_id'] ) . '">' . esc_attr( $ads['account_name'] . ' - ' . $ads['customer_id'] ) . '</option>' );
																	}
																	?>
																</select>
																<p class="google_connector_refresh_icon"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/refresh.png' ); ?>">
																</div>
																<div class="ced_non_select_error ced_show_error_nonselecet_ads"><span class="ced_error_icon">
																	<img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>"> Select Account to proceed
																</span></div>
																

																<div class="ced_goole_error_notices ced_error_during_set_ads_account"></div>

																<div class="ced-button-combo ced-right-btn">
																	<div class="ced-button-create">
																		<a href="#create_ads_account">Create New Account</a>
																	</div>
																	<div class="ced-button-save" id="ced_dash_connect_ads_account">
																		<span class="ced_span">Connect Account</span>
																	</div>
																	<span class="ced_google_loader"><img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
																</div>
															</div>


															<div class="ced-box-button ced_btn_google_re_connect_account ced_btn_google_re_connect_gAds_account"  data-hide_attr="ced_google_shopping_google_re_connect_gAds_account", data-show_attr="ced_google_shopping_google_re_connect_gAds_account_content">
																<a href="">Change Account</a>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end-->

					</div>
				</div>
			</div>
			<div class="ced-Layout__Secondary">
				<div class="ced-card ced-card--plain ">
					<div class="ced-card__Body">
						<div class="ced__cardContent">
							<div class="ced-card  ">
								<div class="ced-card__Body">
									<div class="ced__cardContent">

										<div class="ced-card ced-card--hover ced-card-new">
											<div class="ced-card__Body">
												<div class="ced__cardContent">
													<div class="ced-flex--wrap">
														<h3><b>USER ID</b></h3>
														<div class="ced-tooltip"><p><?php esc_html_e( isset( $user_response['id'] ) ? $user_response['id'] : 'Not Available' ); ?></p>
															<span class="ced-tooltiptext">This User id is for further used</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="ced-card ced-card--hover ced-card-new">
											<div class="ced-card__Body">
												<div class="ced__cardContent">
													<div class="ced-flex--wrap">
														<h3><b>USERNAME</b></h3>
														<p><?php esc_html_e( isset( $user_response['username'] ) ? $user_response['username'] : 'Not Available' ); ?></p>
													</div>
												</div>
											</div>
										</div>
										<div class="ced-card ced-card--hover ced-card-new">
											<div class="ced-card__Body">
												<div class="ced__cardContent">
													<div class="ced-flex--wrap">
														<h3><b>SKYPE ID</b></h3>
														<p><?php esc_html_e( isset( $user_response['skype_id'] ) ? $user_response['skype_id'] : 'Not Available' ); ?></p>
													</div>
												</div>
											</div>
										</div>
										<div class="ced-card ced-card--hover ced-card-new">
											<div class="ced-card__Body">
												<div class="ced__cardContent">
													<div class="ced-flex--wrap">
														<h3><b>FULL NAME</b></h3>
														<p><?php esc_html_e( isset( $user_response['full_name'] ) ? $user_response['full_name'] : 'Not Available' ); ?></p>
													</div>
												</div>
											</div>
										</div>
										<div class="ced-card ced-card--hover ced-card-new">
											<div class="ced-card__Body">
												<div class="ced__cardContent">
													<div class="ced-flex--wrap">
														<h3><b>Mobile</b></h3>
														<h3><b><?php esc_html_e( isset( $user_response['mobile'] ) ? $user_response['mobile'] : 'Not Available' ); ?></b></h3>
														<p>+91</p>
													</div>
												</div>
											</div>
										</div>
										<div class="ced-card ced-card--hover ced-card-new">
											<div class="ced-card__Body">
												<div class="ced__cardContent">
													<div class="ced-flex--wrap">
														<h3><b>PHONE</b></h3>
														<p><?php esc_html_e( isset( $user_response['phone'] ) ? $user_response['phone'] : 'Not Available' ); ?></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-------popup merchant---->
		<div id="create_account" class="overlay">
			<div class="popup">
				<div class="popup-head"><h2>New Google Merchant Account</h2>
					<a class="close" href="#">&times;</a></div>
					<div class="content">
						<label>Account Name</label>
						<input type="text" class="ced-account-textbox" id="ced-google-merachant-accountname" name="" placeholder="Enter new account name">
						<div class="ced-form">
							<input type="checkbox"  name="" class=" ced_acceptTerm_checkbox_createGMCaccount">Accept Terms & Conditions <a href="" class="ced-popup-read-policy"> Read Policy </a>
						</div>
						<div class="ced_non_select_error ced_show_error_nonselecet_gmc_create_account"><span class="ced_error_icon">
							<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">This conformation is compulsory
						</span></div>
					</div>
					<div class="ced_goole_error_notices ced_error_during_creation_merchant_account"></div>
					<div class="ced-popup-footer">
						<div class="ced-cancel">
							<button>Cancel</button></div>
							<div class="ced-account-btn" id="ced_dash_Save_And_CreateGMCAccount" data-user_id="suerid"><button>
							Create Account</button>
						</div>  
						<span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
					</div>
				</div>
			</div>
			<!-------popup create_ads_account---->

			<div id="create_ads_account" class="overlay">
				<div class="popup">
					<div class="popup-head"><h2>New Ads Account </h2>
						<a class="close" href="#">&times;</a></div>
						<div class="ced_ads_creation_warpper">
							<div class="content">
								<label>Account Name</label>
								<input type="text" class="ced-account-textbox"  id = "cedGoogleAccountName" name="" placeholder="Enter new account name">
								<div class="">
									<p>Time Zone</p>
									<select class="ced-account-selt" name="" id="cedSelectGoogleSupportedTimezone">
										<?php
										foreach ( $google_supported_timezones as $key => $timezone ) {
											echo '<option value="' . esc_attr( $timezone ) . '">' . esc_attr( $timezone ) . '</option>';
										}
										?>
									</select>
								</div>
								<div class="">
									<p>Currency</p>
									<select class="ced-account-selt" name="" id="cedSelectGoogleAccountCurrency">
										<?php
										foreach ( $google_supported_currency as $key => $currency ) {
											echo '<option value="' . esc_attr( $key ) . '">' . esc_attr( $currency ) . '</option>';
										}
										?>
									</select>

								</div>
								<div class="ced-form">
									<input type="checkbox" name="" class="ced_acceptTerm_checkbox_createGoogleAdsAccount">Accept Terms & Conditions <a href="" class="ced-popup-read-policy">Read Policy</a>
								</div>
								<div class="ced_non_select_error ced_show_error_nonselecet_ads_create_account"><span class="ced_error_icon">
									<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">This conformation is compulsory
								</span></div>
							</div>
							<div class="ced_goole_error_notices ced_error_during_creation_adsaccount"></div>
							<div class="ced-popup-footer">
								<div class="ced-cancel"><button>Cancel </button></div>
								<div class="ced-account-btn" id="ced_dash_Save_And_CreateGoogleAdsAccount"><button>
								Create Account</button>
							</div>
							<span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
						</div>
					</div>


				</div>
			</div>
