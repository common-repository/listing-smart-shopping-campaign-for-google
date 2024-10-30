<?php
require CED_WGEI_DIRPATH . 'admin/lib/listing-and-smart-shopping-campaign-for-google-lib.php';
$google_shopping_lib_object = new Google_Shopping_Lib();
$google_ads_account_details = $google_shopping_lib_object->google_shopping_get_connected_googleads_acount();
$all_gmc_accounts           = $google_shopping_lib_object->google_shopping_get_connected_merechant_acount();
$google_supported_currency  = $google_shopping_lib_object->google_shopping_get_google_supported_currency();
$google_supported_timezones = file( CED_WGEI_DIRPATH . 'admin/timezones.txt' );
$merchant_details           = get_option( 'ced_save_merchant_details', true );

$google_gmc    = get_option( 'ced_save_merchant_details' );
$google_ads    = get_option( 'ced_save_ads_details' );
$google_config = get_option( 'ced_configuration_details' );


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
$woo_currencies            = $currency_code_options;
$age_group                 = array(
	'New Born (Upto 3 months old' => 'New Born (Upto 3 months old',
	'Infant (3 to 12 months)'     => 'Infant (3 to 12 months',
	'Toddler (1-5 years)'         => 'Toddler (1-5 years)',
	'Kids (5-13 years)'           => 'Kids (5-13 years)',
	'Adults'                      => 'Adults',
);
$gender                    = array(
	'Male'   => 'Male',
	'Female' => 'Female',
	'Other'  => 'Other',
);
$ced_configuration_details = get_option( 'ced_configuration_details', true );
/*close config content */
?>
<div class="ced__Main">
   <div class="ced-pageHeader ">
	  <div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
		 <div class="ced-flex__item">
			<h3 class="ced__Heading">Settings</h3>
		 </div>
	  </div>
   </div>
   <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	  <div class="ced-flex__item">
		 <div class="mt-30">
			<div class="ced-card  ">
			   <div class="ced-card__Body">
				  <div class="ced__cardContent">
					 <h3 class="ced__Subheading"> Connected mail account </h3>
					 <div class="ced-flex ced-flex--wrap">
						<div class="ced-connected-head">
						   <div class="">
						   <h4>Your shop is <b><strong><?php echo esc_html_e( get_bloginfo( 'name' ) ); ?></strong></b> and your Google account is <strong><?php echo esc_html_e( get_option( 'ced_google_connected_gmail' ) ); ?></strong></h4>
						</div>
						<div class="ced-flex__item">
						   <img class="ced-dash-setting-edit" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/edit_icon.png' ); ?>">
						   </div>

						</div>
						<!--listing tabuler format-->

<!-- gogole metrchant setting section  -->

						<div class="ced-log-table ced_dash_merhcant_wrapper">
						   <div class="ced_data_editicon_wrapper">
							  <div class="ced_dash_setting_merchant_data">
								 <h3>Connected Google Merchant Account</h3>
								 <p>Your Google Merchant center name:  <b><?php esc_html_e( $google_gmc['name'] ); ?></b></p>
								 <p>Google Merchant ID: <b><?php esc_html_e( $google_gmc['merchant_id'] ); ?></b></p>
							  </div>
							  <div class="ced-flex__item ced_dash_edit_enable_disable_button" data-need_to_hide="ced_dash_setting_merchant_data" data-need_to_show="ced_dash_setting_merchant_edit">
								 <img class="ced-dash-setting-edit" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/edit_icon.png' ); ?>">
							  </div>
						   </div>
						   <div class="ced_dash_setting_merchant_edit">
							  <h3>GMC Acccount</h3>
							  <div class="ced_google_dash_gmc_wrapper">
								 <div class="ced-icon-text">
								   <h3>Connect Existing Account !</h3>



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
												esc_attr_e( '<option class="ced_gmc_option"' . $selected . ' value="' . esc_attr( $gmcdetail['merchantId'] ) . '"><h5>' . esc_attr( $gmcdetail['accountName'] ) . '</h5> <p><span>' . esc_attr( $gmcdetail['merchantId'] ) . '</span></p> </option>' );
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

								 <div class="ced-button-combo">
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
						</div>

<!-- ending google merhcant settign section  -->

<!-- gogole ads setting section -->



						<div class="ced-log-table ced_dash_googleads_wrapper">
						   <div class="ced_data_editicon_wrapper">
							  <div class="ced_dash_setting_googleads_data">
								 <h3>Connected Google Ads Account</h3>
								 <p>Your Google Ads account name:  <b><?php esc_html_e( isset( $google_ads['name'] ) ? $google_ads['name'] : '' ); ?></b></p>
								 <p>Google Ads Customer ID: <?php esc_html_e( isset( $google_ads['account_id'] ) ? $google_ads['account_id'] : '' ); ?></p>
							  </div>
							   <div class="ced-flex__item ced_dash_edit_enable_disable_button" data-need_to_hide="ced_dash_setting_googleads_data" data-need_to_show="ced_dash_setting_googleads_edit">
								 <img class="ced-dash-setting-edit" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/edit_icon.png' ); ?>">
							  </div>
						   </div>
						   <div class="ced_dash_setting_googleads_edit">
							 




								 <div class="ced-icon-text">
									  <h3>Connect Existing Account !</h3>
									 <div class="ced_google_ads_refresh_warpper">
									  <select class="ced-select-merchant" id="ced_selected_ads_account" name="">
									   <option class="ced-opt" value=""  selected>Select Google Merchant Center Account</option>
									   <?php
										foreach ( $google_ads_account_details as $key => $ads ) {
											if ( $ads_details['account_id'] == $ads['customer_id'] ) {
												$selected = 'selected';
											} else {
												$selected = '';
											}
											esc_html_e( '<option ' . $selected . ' value="' . esc_attr( $ads['customer_id'] ) . '">' . esc_attr( $ads['account_name'] . ' - ' . $ads['customer_id'] ) . '</option>' );
										}
										?>
									  </select>
									  <p class="google_connector_refresh_icon"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/refresh.png' ); ?>">
									  </div>
										 <div class="ced_non_select_error ced_show_error_nonselecet_ads"><span class="ced_error_icon">
									  <img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>"> Select Account to proceed
									</span></div>
								 </div>

								 <div class="ced_goole_error_notices ced_error_during_set_ads_account"></div>

								 <div class="ced-button-combo">
									<div class="ced-button-create">
									   <a href="#create_ads_account">Create New Account</a>
									</div>
									<div class="ced-button-save" id="ced_dash_connect_ads_account">
									   <span class="ced_span">Connect Account</span>
									</div>
									<span class="ced_google_loader"><img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
								 </div>
							  </div>
						   </div>

<!-- ending google ads setting section  -->

<!-- start google config section  -->

						<div class="ced-log-table ced_dash_configsetting_wrapper">
						   <div class="ced_data_editicon_wrapper">
							  <div class="ced_dash_setting_configsetting_data">
								 <h3>Configuration Setting Data</h3>
								 <h4><b>General::</b></h4>
								 <p>Target Country - <span><?php esc_html_e( isset( $google_config['ced_selected_config_country'] ) ? $google_config['ced_selected_config_country'] : '' ); ?></span></p>
								 <p>Content Language -  <span><?php esc_html_e( isset( $google_config['ced_selected_config_language'] ) ? $google_config['ced_selected_config_language'] : '' ); ?></span></p>
								 <p>Currency - <span> <?php esc_html_e( isset( $google_config['ced_selected_config_currency'] ) ? $google_config['ced_selected_config_currency'] : '' ); ?></span></p>
								 <p>Gender - <span><?php esc_html_e( isset( $google_config['ced_selected_config_gender'] ) ? $google_config['ced_selected_config_gender'] : '' ); ?></span></p>
								 <p>Age Group - <span><?php esc_html_e( isset( $google_config['ced_selected_config_agegroup'] ) ? $google_config['ced_selected_config_agegroup'] : '' ); ?> </span></p>
								 <h4><b>Product::</b></h4>
								 <p></p>
								 <?php
									$selected_category = isset( $google_config['ced_products_needs_to_submit'] ) ? $google_config['ced_products_needs_to_submit'] : array();
									?>
								 <p>Selected Category - <span><?php print_r( $selected_category ); ?> </span></p>
								 <p>Variation Type - <span><?php esc_html_e( isset( $google_config['ced_product_variation_preference'] ) ? $google_config['ced_product_variation_preference'] : '' ); ?> </span></p>

							  </div>
							  
							  <div class="ced-flex__item ced_dash_edit_enable_disable_button" data-need_to_hide="ced_dash_setting_configsetting_data" data-need_to_show="ced_dash_setting_configsetting_edit">
								 <img class="ced-dash-setting-edit" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/edit_icon.png' ); ?>">
							  </div>
						   </div>
						   <div class="ced_dash_setting_configsetting_edit">
							


	   <div class="ced-accordian">

		<div class="ced-tab">
			<input id="ced-tab-1" type="checkbox">
			<label for="ced-tab-1">General</label>
			<div class="content">
				<div class="ced-data">
					<div class="ced-left">
						<p >Target Country <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
						<p>
							<select class="ced-setting-select" id="ced_selected_config_country">
								<option value="">Select Target Country </option>
								<?php
								foreach ( $woo_countries as $key => $countries ) {
									if ( $key == $ced_configuration_details['ced_selected_config_country'] ) {
										 echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
									} else {
										echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
									}
								}
								?>
							</select>
						</p></div>
						<div class="ced-right">
							<p>Content Language <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
							<p>
								<select class="ced-setting-select" id="ced_selected_config_language">
									<option value="">Select Content Language </option>
									<?php
									foreach ( $woo_languages as $key => $language ) {
										if ( $key == $ced_configuration_details['ced_selected_config_language'] ) {

											echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $language['english_name'] ) . '</span></p> </option>';
										} else {

											echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $language['english_name'] ) . '</span></p> </option>';
										}
									}
									?>
								</select>
							</p></div>
						</div>
						<div class="ced-data">
							<div class="ced-left">
								<p>Currency <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
								<p>
									<select class="ced-setting-select" id="ced_selected_config_currency">
										<option value="">Select Currency </option>
										<?php
										foreach ( $woo_currencies as $key => $currencies ) {
											if ( $key == $ced_configuration_details['ced_selected_config_currency'] ) {

												echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';
											} else {

												echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';
											}
										}
										?>
									</select>
								</p></div>
								<div class="ced-right">
									<p>Gender <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
									<p>
										<select class="ced-setting-select" id="ced_selected_config_gender">
											<option value="">Select Gender </option>
											<?php
											foreach ( $gender as $key => $gender ) {
												if ( $key == $ced_configuration_details['ced_selected_config_gender'] ) {

													echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
												} else {

													echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
												}
											}
											?>
										</select>
									</p></div>
								</div> 
								<div class="ced-data">
									<div class="ced-left">
										<p>Age Group <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
										<p><select class="ced-setting-select" id="ced_selected_config_agegroup">
											<option value="" disabled selected hidden>Select Age Group </option>
											<?php
											foreach ( $age_group as $key => $age_group ) {
												if ( $key == $ced_configuration_details['ced_selected_config_agegroup'] ) {

													echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
												} else {

													echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
												}
											}
											?>
										</select></p>
									</div>
								</div> 
							</div>
						</div>

						<div class="ced-tab">
							<input id="ced-tab-2" type="checkbox">
							<label for="ced-tab-2">Product</label>
							<div class="content">
								<div class="ced-data">
									<div class="ced-left">
										<p><strong>Products which needs to be submitted in Feed?</strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
										<input type="radio" class="ced_google_product_needs_to_submit" name="ced_google_product_needs_to_submit" value="All Products">
										<span>All Products</span><br>
										<input type="radio" class="ced_google_product_needs_to_submit" name="ced_google_product_needs_to_submit" value="Products from a collection" checked>
										<span>Products from a collection</span><br>
										<div class="ced-optn-selt">
										   <?php
											$selected_category = $ced_configuration_details['ced_products_needs_to_submit'];

											// print_r($selected_category);
											?>

											<select class="ced-data-selt ced_cat_select select2" id="ced_cat_select" name="_ced_cat_select" multiple='multiple'>
											<?php
											foreach ( $woo_store_categories as $key => $value ) {
												if ( in_array( $value->term_id, $selected_category ) ) {
													?>
													<option value="<?php esc_html_e( $value->term_id ); ?>" selected><?php esc_html_e( strtoupper( $value->name ) ); ?></option>  
													<?php
												} else {
													?>
													<option value="<?php esc_html_e( $value->term_id ); ?>"><?php esc_html_e( strtoupper( $value->name ) ); ?></option>   
													<?php
												}
											}
											?>
											</select>
											</div>
										</div>
										<div class="ced-right">
											<p><strong>Variant Submission Preference</strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
											<input type="radio" class="ced_google_product_variation_preference" name="ced_google_product_variation_preference" value="All Variants">
											<span>All Variants</span><br>
											<input type="radio" class="ced_google_product_variation_preference" name="ced_google_product_variation_preference" value="First Variants Only">
											<span>First Variants Only</span><br>
										</div>
									</div>
								</div>
							</div>

						</div>

				  
						<div class="ced-button-combo">
							<div class="ced-button-save" id="ced_dash_save_account_config_content">
							  <span class="ced_span">Submit</span>
							   
						  </div>
					 <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
				  </div>
					</div>
			   </div>

<!-- ending google config section  -->



<!-- start google compaign section  -->


						<div class="ced-log-table ced_dash_compaign_wrapper">
						   <div class="ced_data_editicon_wrapper">
							  <div class="ced_dash_setting_compaign_data">
								 <h3>Campaign Setting Data</h3>
								 <p>Campaign Name  <span>XYZ</span></p>
								 <p>Daily Budget <span> xyz</span></p>
								 <p>Target Location <span>India</span></p>
							  </div>
							  
							  <div class="ced-flex__item ced_dash_edit_enable_disable_button" data-need_to_hide="ced_dash_setting_compaign_data" data-need_to_show="ced_dash_setting_compaign_edit">
								 <img class="ced-dash-setting-edit" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/edit_icon.png' ); ?>">
							  </div>
						   </div>
						   <div class="ced_dash_setting_compaign_edit">
							 


							  <div class="ced_google_compaignSetting" style="display:block;">
									 <div class="ced-cam-data">
										 <div class="ced-left">
											 <p><strong>Campaign Name </strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
											 <input type="text" name="" class="ced-cam-textbox" id="ced_compaign_name" placeholder="Set a campaign name">
										 </div>
										 <div class="ced-right">
											 <p><strong>Set a Daily Budget </strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
											 <input type="text" name="" class="ced-cam-textbox" id="ced_compaign_budget" placeholder="Enter Budget Value">
										 </div>
									 </div>
									 <div class="ced-cam-data-alt">
										<p><strong>Set Target Location</strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
										<p><input type="radio" class="ced-cam-radio ced_compaign_location" id="ced_select_another_location" name="ced_compaign_location">Enter another location</p>
										<p><input type="radio" value="All" class="ced-cam-radio ced_compaign_location" id="selectAllLocations" name="ced_compaign_location">All countries and territories</p>
										<p><input type="radio" value="India" class="ced-cam-radio ced_compaign_location" id="selectIndia" name="ced_compaign_location">India</p>
									</div>
									<div class="form-group" id="googleSelectCampaignCity">
									 <input type="text" class="form-control" placeholder="Enter City Name" id="campaignSelectCity"/>
								 </div>

								  <div class="ced_goole_error_notices ced_error_during_creating_compaign"></div>

									 <div class="ced-button-combo"> 
										 <div class="ced-button-create">
										  <a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=onboard' ); ?>">Skip & Finish</a>
									  </div> 
									  <div class="ced-button-save" id="ced_dash_save_and_create_compaign">
										  <a href="">Create Performance Max Campaign</a>
									  </div>
										<span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
									</div>
								 </div>
						   </div>
						</div>
<!-- ending  google compaign section  -->

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
