<?php
require CED_WGEI_DIRPATH . 'admin/lib/listing-and-smart-shopping-campaign-for-google-lib.php';
$google_shopping_lib_object = new Google_Shopping_Lib();
$all_gmc_accounts           = $google_shopping_lib_object->google_shopping_get_connected_merechant_acount();
$google_action              = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
$goolge_section             = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';
$google_status              = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '';
$merchant_details           = get_option( 'ced_save_merchant_details', true );
$connected_gmail            = get_option( 'ced_google_connected_gmail' );
if ( empty( $merchant_details ) || 'changegmc' == $google_action ) {
	?>
  <div class="ced_connect_google_merchant_account">
   <div class="ced-google-wrap" >
	<h3>Connect Google Merchant Center</h3>
	<p>Start your Google Shopping and Buy on Google Journey. Connect or Create a new Google account below. This connection is </p>
	<div class="ced-succes-alert-wrapper">
	 <div class="ced-succes-alert-message">
	  <p><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/Full-new.png' ); ?>"><?php echo esc_html_e( get_option( 'ced_google_connected_gmail' ) ); ?></p>
	</div>
	<div class="ced-icon-text">
	 <h3>Connect Existing Account !</h3>
	 <select class="ced-select-merchant" id="ced_selected_gmc_account" name="">
	   <option class="ced-opt" value="" selected>Select Google Merchant Center Account</option>
	   <?php
		if ( ! empty( $all_gmc_accounts ) ) {
			foreach ( $all_gmc_accounts as $key => $gmcdetail ) {
				$merchant_details_data = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : array();
				$gmcdetail_data        = isset( $gmcdetail['merchantId'] ) ? $gmcdetail['merchantId'] : array();
				if ( $merchant_details_data == $gmcdetail_data ) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				echo '<option class="ced_gmc_option"' . esc_attr( $selected ) . ' value="' . esc_attr( $gmcdetail['merchantId'] ) . '"><h5>' . esc_attr( $gmcdetail['accountName'] ) . '</h5> <p><span>' . esc_attr( $gmcdetail['merchantId'] ) . '</span></p> </option>';
			}
		}
		?>
	</select>

	
  </div>
</div>
</div>
<div class="ced_non_select_error ced_show_error_nonselecet_gmc"><span class="ced_error_icon">
	  <img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/error_icon.png' ); ?>">Select Account to proceed
	</span></div>
 <div class="ced_goole_error_notices ced_error_during_set_gmc_account"></div>
<div class="ced-google-butn">
	<div class="ced-button-combo">
	
   <div class="ced-button-save" id="ced_connect_gmc_account">
	<a href="">Connect Account</a>
  </div>
	  <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
</div>
<!-- <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/google-shopping-integration-for-woocommerce/" target="_blank">Help Manual.</a>
</p> -->
<p class="ced-footer-text"> </p>
</div>
</div>

	<?php
} else {
	?>
  <div class="ced_finished_google_merchant_account">
	<div class="ced-google-wrap" >

	  <h3>Connect Google Merchant Center</h3>
	  <p>You have authenticated your Google account successfully. Please choose your Google Merchant Center ID which you would like to use for Google shopping.</p>
	  

	  <div class="ced-succes-alert-wrapper">
	   <div class="ced-succes-alert-message">

		<p><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/Full-new.png' ); ?>"><?php echo esc_html_e( get_bloginfo( 'name' ) ); ?></p>
	  </div>

		 <div class="ced-no-account">
		  <div class="ced-account-added secessfully-wrapper">
			<div class="ced-account-conneceted-wrap">
				<div class="ced-account-wrap-sucess">
					<div class="ced-link-account-wrap">
						<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/wired-flat-1103-confetti.gif' ); ?>">
					</div>
					<div class="ced-account-wrap-sucesss">
					<h3>Google Merchant Created</h3>
		  <p> Your Google Merchant center name is <b><?php esc_html_e( $merchant_details['name'] ); ?></b> and your Google Merchant ID is <b><?php esc_html_e( $merchant_details['merchant_id'] ); ?></b>.<br> 
			<b><a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=merchant-center&action=changegmc&step=2' ); ?>">Change Account</a></b></p>
					</div>
				</div>
			</div>
		</div>
	</div>

		  <div class="ced-enable-account">
			<h3>Enable Programs</h3>
			<p>Please make sure to enable the required programs in your Google Merchant Center before submitting feed, so Google can start their review process accordingly. You must at least enable Shopping Ads Program, otherwise submitted feed is of no meaning because Google will never review it.</p>
			
		  </div>
		 
		</div>
	  </div>
	  <div class="ced-google-butn">
		<div class="ced-button-combo">
		  <div class="ced-button-save ced_google_next_page_redirector">
		   <a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=ads-setting&step=3' ); ?>">Next</a>
		   <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
		 </div>
	   </div>
	   <!-- <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/google-shopping-integration-for-woocommerce/" target="_blank">Help Manual.</a>
	   </p> -->
	   <p class="ced-footer-text"> </p>	
	 </div>
   </div>
	<?php
}
?>



