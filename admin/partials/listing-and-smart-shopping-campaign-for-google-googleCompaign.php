<?php

$compaign_data   = get_option( 'ced_compaign_details', true );
$compaign_budget = '';
$compaign_name   = '';
if ( 'skipped' != $compaign_data && is_array( $compaign_data ) ) {
	$compaign_data              = isset( $compaign_data['compaign_details_saved'] ) ? $compaign_data['compaign_details_saved'] : '';
	$compaign_multiple_location = isset( $compaign_data['campaign_location_array'] ) ? $compaign_data['campaign_location_array'] : '';
	$compaign_location          = isset( $compaign_data['compaign_location'] ) ? $compaign_data['compaign_location'] : '';
	$compaign_name              = isset( $compaign_data['ced_compaign_name'] ) ? $compaign_data['ced_compaign_name'] : '';
	$compaign_budget            = isset( $compaign_data['ced_compaign_budget'] ) ? $compaign_data['ced_compaign_budget'] : '';
	if ( ! empty( $compaign_multiple_location ) ) {
		$compaign_location = implode( ' ,', $compaign_multiple_location );
	}
}
?>
<div class="ced_google_compaignSetting" style="display:block;">
  <div class="ced-google-wrap" >

	<h3>Create Campaign</h3>
	<p>Create a Performance Max Campaign to promote your feed.</p>
	<div class="ced-cam-data">
		<div class="ced-left">
			<p><strong>Campaign Name </strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
			<input type="text" name="" class="ced-cam-textbox" value="<?php esc_html_e( $compaign_name ); ?>"id="ced_compaign_name" placeholder="Set a campaign name">
		</div>
		<div class="ced-right">
			<p><strong>Set a Daily Budget </strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
			<input type="text" name="" class="ced-cam-textbox" value="<?php esc_html_e( $compaign_budget ); ?>" id="ced_compaign_budget" placeholder="Enter Budget Value">
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

</div>
 <div class="ced_goole_error_notices ced_error_during_creating_compaign"></div>
<div class="ced-google-butn">
	<div class="ced-button-combo"> 
		<div class="ced-button-create ced_google_onboarding_skip">
		 <a href="#">Skip & Finish</a>
	 </div> 
	 <div class="ced-button-save" id="ced_save_and_create_compaign">
		 <a href="">Create Performance Max Campaign</a>
	 </div>
		 <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
 </div>
 <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
 </p>
 <p class="ced-footer-text">A CedCommerce Inc Product</p>
</div>
</div>



<div class="ced_google_compaignSetting_completed" style="display:none;">
   <div class="ced-google-wrap" >

	<h3>Create Campaign</h3>
	<p>Create a Performance Max Campaign to promote your feed.</p>
	<div class="ced-no-account">
	  <div class="ced-no-account-icon"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/primaryfill.png' ); ?>"></div>
	  <div class="ced-no-account-text">
		<p><strong>Campaign Created Successfully !</strong></p>
	</div>
	
</div>

</div>
<div class="ced-google-butn">
	<div class="ced-button-combo"> 
		<div class="ced-button-save ">
		 <a href="#">Complete Onboarding</a>
	 </div>
 </div>
 <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
 </p>
 <p class="ced-footer-text">A CedCommerce Inc Product</p>
</div>

</div>
