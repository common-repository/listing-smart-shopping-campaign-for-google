<?php

require CED_WGEI_DIRPATH . 'admin/lib/listing-and-smart-shopping-campaign-for-google-lib.php';
$google_shopping_lib_object = new Google_Shopping_Lib();
$google_ads_account_details = $google_shopping_lib_object->google_shopping_get_connected_googleads_acount();
$google_supported_currency  = $google_shopping_lib_object->google_shopping_get_google_supported_currency();

$connected_gmail = $google_shopping_lib_object->google_shopping_get_connected_acount();

$google_action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
$ads_details   = get_option( 'ced_google_another_account_data', true );
$ads_details   = get_option( 'ced_save_ads_details', true );
if ( isset( $ads_details['account_id'] ) && ! empty( $ads_details['account_id'] ) ) {
	update_option( 'connected_google_ads_id', $ads_details['account_id'] );
}

$connected_gmail     = get_option( 'ced_google_connected_gmail' );
$connected_ads_gmail = get_option( 'ced_google_connected_ads_gmail' );

$google_supported_timezones = file( CED_WGEI_DIRPATH . 'admin/timezones.txt' );

if ( empty( $ads_details ) || ( ! empty( $ads_details ) && ! is_array( $ads_details ) ) || 'changeads' == $google_action ) {
	?>

  <div class="ced_add_google_Adds" style="display:block">
   <div class="ced-google-wrap" >
	 <h3>Connect Google Ads Account</h3>
	 <p>Sign up with Google Ads to start reaching new customers with online ads tailored to your business goals and budget. </p>

	 <div class="ced-google-credit">

	   <div class="ced-google-credit-img"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/gift.png' ); ?>"></div>
	   <div class="ced-google-credit-text">
		 <h3>$500 USD Added Credit </h3>
		 <p>Get added credit of $500 USD to your Google Ads account on spending $500 USD within 60 days. <a href="https://support.cedcommerce.com/" target="_blank">Contact for details</a></p>
	   </div>
	 </div>


	 <div class="ced-succes-alert-wrapper">
	  <div class="ced-succes-alert-message">

	   <p><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/Full-new.png' ); ?>"><b>Account G-mail : </b><?php esc_html_e( $connected_gmail ); ?></p>
	 </div>
		<?php if ( ! empty( $connected_ads_gmail ) ) { ?>
	  <div class="ced-succes-alert-message">

	   <p><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/Full-new.png' ); ?>"><b>Google Ads G-mail : </b><?php esc_html_e( $connected_ads_gmail ); ?></p>
	 </div>
	<?php } ?>
	 <div class="ced-icon-text">
	  <h3>Connect Existing Account !</h3>
	<div class="ced_google_ads_refresh_warpper">
	  <select class="ced-select-merchant" id="ced_selected_ads_account" name="">
		<option class="ced-opt" value=""  selected>Select Google Merchant Center Account</option>
		<?php
		foreach ( $google_ads_account_details as $key => $ads ) {
			$ads_account_data  = isset( $ads_details['account_id'] ) ? $ads_details['account_id'] : array();
			$ads_customer_data = isset( $ads['customer_id'] ) ? $ads['customer_id'] : '';
			if ( $ads_account_data == $ads_customer_data ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $ads['customer_id'] ) . '">' . esc_attr( $ads['account_name'] . ' - ' . $ads['customer_id'] ) . '</option>';
		}
		?>
	  </select>
	 <p class="google_connector_refresh_icon"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/refresh.png' ); ?>">
	 </div>
		  <div class="ced_non_select_error ced_show_error_nonselecet_ads"><span class="ced_error_icon">
	  <img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>"> Select Account to proceed
	</span></div>
	</div>
  </div>
</div>
<div class="ced_goole_error_notices ced_error_during_set_ads_account"></div>
<div class="ced-google-butn">
 <div class="ced-button-combo">
  <div class="ced-button-skip-ads ced-button-create" id="ced_skip_google_connect_ads_account">
	<a  href="#" class="ced_span">Skip this Step</a>
  </div>

  <div class="ced-button-create">
	  <a href="#create_account_with_another_gmail">Connect Account from another Gmail</a>
  </div>
	<div class="ced-button-create">
	<a href="#create_ads_account">Create New Account</a>
  </div>
  <div class="ced-button-save" id="ced_connect_ads_account">
	<span class="ced_span">Connect Account</span>
  </div>
	 <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
</div>
<p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
</p>
<p class="ced-footer-text">A CedCommerce Inc Product</p>
</div>
</div>
	<?php
} elseif ( is_array( $ads_details ) && ! empty( $ads_details ) ) {
	?>
  <div class="ced_after_successAddedAdds" style="display:block">
   <div class="ced-google-wrap" >

	<h3>Connect Google Ads Account</h3>
	<p>Sign up with Google Ads to start reaching new customers with online ads tailored to your business goals and budget.</p>
	<p><strong>CedCommerce is the official Google Premier Partner. Businesses new to Google Advertising will be eligible for $500 USD ad credits to their Google Ads account once they spend $500 USD within 60 days through our Suite for Google Shopping Feed App.</strong></p>

	<p><i>Note: Business location determines ad credit amount. <a href="https://support.cedcommerce.com/" target="_blank" class="ced-contact-ads">Contact for details</a></i></p>
	<div class="ced-succes-alert-wrapper">
	 <div class="ced-succes-alert-message">
	  <p><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/Full-new.png' ); ?>"><?php esc_html_e( $connected_gmail ); ?></p>
	</div>

	<div class="ced-no-account">
	  <div class="ced-no-account-icon"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/primaryfill.png' ); ?>"></div>
	  <div class="ced-no-account-text">
		<h3>Google Ads Account Created</h3>
		<p> Your Google Ads account name is <b><?php esc_html_e( isset( $ads_details['name'] ) ? $ads_details['name'] : '' ); ?></b> and your Google Ads Customer ID is <b><?php esc_html_e( isset( $ads_details['account_id'] ) ? $ads_details['account_id'] : '' ); ?></b>.<br>
		  <a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=ads-setting&action=changeads&step=3' ); ?>" class="ced-account-ads-created">Change Account</a></p>
		</div>
	  </div>


	</div>
  </div>
  <div class="ced-google-butn">
	<div class="ced-button-combo">
	  <div class="ced-button-save ced_google_next_page_redirector">
	   <a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=configuration&step=4' ); ?>">Next</a>
		 <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
	 </div>
   </div>
   <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
   </p>
   <p class="ced-footer-text">A CedCommerce Inc Product</p>
 </div>
</div>
	<?php
}
?>
<!-------popup---->
<div id="create_ads_account" class="ced_google_shopping_popup overlay">
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
			<input type="checkbox" name="" class="ced_acceptTerm_checkbox_createGoogleAdsAccount">Accept Terms & Conditions <a target="_blank" href="https://apps.cedcommerce.com/express/app/show/policy" class="ced-popup-read-policy">Read Policy</a>
		  </div>
			  <div class="ced_non_select_error ced_show_error_nonselecet_ads_create_account"><span class="ced_error_icon">
	  <img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">This conformation is compulsory
	</span></div>
		</div>
		<div class="ced_goole_error_notices ced_error_during_creation_adsaccount"></div>
		<div class="ced-popup-footer">
		  <div class="ced-cancel"><button>Cancel </button></div>
		  <div class="ced-account-btn" id="ced_Save_And_CreateGoogleAdsAccount"><button>
			  Create Account</button>
		  </div>
			<span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
		</div>
	  </div>


	</div>
  </div>

  <!-------popup for connect other g mial account---->
<div id="create_account_with_another_gmail" class="ced_google_shopping_popup overlay">
  <div class="popup">
	<div class="popup-head"><h2> Connect with Other G mail Account</h2>
	  <a class="close" href="#">&times;</a></div>
	  <div class="ced_ads_creation_warpper">
		<div class="content">
		<div class="ced-google-wrapper">
			<h3>Connect Google Account</h3>
			<p>Start your Google Shopping and Buy on Google Journey. Connect or Create a new google account below. This connection is required to allow the app to work as a bridge in between Google Merchant Center and your Shopify store. </p>
		</div>

	 <div class="ced_goole_error_notices ced_error_during_creating_account"></div>

			<div class="ced-validation">
				<input type="checkbox" class="ced-checkbox ced_acceptTerm_checkbox"><span class="ced-accept">Accept Terms & Conditions </span>
				<span class="ced-policy"><a target="_blank" href="https://apps.cedcommerce.com/express/app/show/policy">Read Policy </a></span>
			</div>

			<div class="ced_non_select_error ced_signinwithgoogle_acceptTerm_alert">
				<span class="ced_error_icon">
				<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">This conformation is compulsory 
				</span>
			</div>

				<div class="ced_gogole_signin_wrapper">
				<div class="ced-g-sign-in-button">
					<div class="content-wrapper" id="ced_connect_another_gmail_account_for_google_ads_account" data-store="<?php esc_html_e( $home_url ); ?>" data-email="<?php esc_html_e( get_option( 'admin_email' ) ); ?>" data-framework="woocommerce" data-storename="<?php esc_html_e( get_bloginfo( 'name' ) ); ?>">
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
		<!-- <div class="ced_goole_error_notices ced_error_during_creation_adsaccount"></div> -->
		<div class="ced-popup-footer">
		  <div class="ced-cancel"><button>Cancel </button></div>
		</div>
	  </div>


	</div>
  </div>
