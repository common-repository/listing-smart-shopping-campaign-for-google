<?php
$home_url = get_home_url();
require CED_WGEI_DIRPATH . 'admin/lib/listing-and-smart-shopping-campaign-for-google-lib.php';
$google_shopping_lib_object = new Google_Shopping_Lib();
$connected_gmail            = $google_shopping_lib_object->google_shopping_get_connected_acount();
$google_action              = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
$google_section             = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';
$google_status              = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '';
$ced_google_account_data    = get_option( 'ced_google_account_data' );
if ( empty( $ced_google_account_data ) || 'resetaccount' == $google_action ) {
	?>
	<div class="ced_google_acount_before_register" style="display:block">
		<div class="ced-google-wrap">
			<h3>Connect Google Account</h3>
			<p>Start your Google Shopping and Buy on Google Journey. Connect or Create a new google account below. This connection is required to allow the app to work as a bridge in between Google Merchant Center and your Shopify store. </p>
		</div>

		<div class="ced-succes-message-wrap ced-error-message-wrap" style="display:none">
		 <div class="ced-error-icon">
			 <img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/primaryfill.png' ); ?>">
		 </div>
		 <div class="ced-icon-text">
			 <h3>Some Erorr During Creating Account!</h3>
			 <p class="ced_ConnectGoogleApi_error"></p>
		 </div>
	 </div>
	 <div class="ced_goole_error_notices ced_error_during_creating_account"></div>


	 <div class="ced-google-butn">
		<div class="ced-validation">
			<input type="checkbox" class="ced-checkbox ced_acceptTerm_checkbox"><span class="ced-accept">Accept Terms & Conditions </span>
			<span class="ced-policy"><a target="_blank" href="https://apps.cedcommerce.com/express/app/show/policy">Read Policy </a></span>

		</div>

		<div class="ced_non_select_error ced_signinwithgoogle_acceptTerm_alert">
			<span class="ced_error_icon">
				<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">This conformation is compulsory 
			</span></div>

			<div class="ced_gogole_signin_wrapper">
				<div class="ced-g-sign-in-button">
					<div class="content-wrapper" id="ced_signinwithgoogle_createuser" data-store="<?php echo esc_html_e( $home_url ); ?>" data-email="<?php esc_html_e( get_option( 'admin_email' ) ); ?>" data-framework="woocommerce" data-storename="<?php echo esc_html_e( get_bloginfo( 'name' ) ); ?>">
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
			<p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
			</p>
			<p class="ced-footer-text">A CedCommerce Inc Product</p>
		</div>
	</div>


	<?php
} else {
	?>

	<!-- conditional after succes signign  -->
	<div class="ced_google_acount_after_register">
		<div class="ced-google-wrap">
			<h3>Connect Google Account</h3>
			<p>Start your Google Shopping and Buy on Google Journey. Connect or Create a new google account below. This connection is required to allow the app to work as a bridge in between Google Merchant Center and your Shopify store. </p>

			<div class="ced-succes-message-wrap">
			 <div class="ced-succes-icon">

				 <img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/primaryfill.png' ); ?>">
			 </div>
			 <div class="ced-icon-text">
				 <h3>Account Connected Successfully !</h3>
				 <p>Your shop is <strong><?php echo esc_html_e( get_bloginfo( 'name' ) ); ?></strong> and your Google account is <strong><?php esc_html_e( get_option( 'ced_google_connected_gmail' ) ); ?></strong> </p>
				 <p><span class="ced-change-account"><a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=accounting-setting&action=resetaccount&step=1' ); ?>">Change Account</a></span>

				 </p>
			 </div>
		 </div>
	 </div>
	 <div class="ced-google-butn">
		<div class="ced-validation">
			<input type="checkbox" checked class="ced-checkbox ced_acceptTerm_checkbox_connectGoogleAccount"><span class="ced-accept">Accept Terms & Conditions </span>
			<span class="ced-policy"><a target="_blank" href="https://apps.cedcommerce.com/express/app/show/policy">Read Policy </a></span>
		</div>
		<div class="ced_non_select_error ced_SaveAndConnectGoogleAccount_acceptTerm_alert">
			<span class="ced_error_icon">
				<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">This conformation is compulsory 
			</span></div>
			<div class="ced-button-save" id="ced_Save_And_ConnectGogoleAccount">
			 <a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=merchant-center&step=2' ); ?>">Next</a>
			<span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
		 </div>
		 <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
		 </p>
		 <p class="ced-footer-text">A CedCommerce Inc Product</p>
	 </div>
 </div>
 <!-- ending -->
	<?php
}
?>
