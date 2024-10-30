<?php
// preparnig menu
require CED_WGEI_DIRPATH . 'admin/lib/listing-and-smart-shopping-campaign-for-google-lib.php';
$gAds_menus_array                             = array();
$gAds_menus_array['Accounts']                 = array(
	'content'    => 'gads-account',
	'icon_image' => CED_WGEI_URL . 'admin/images/user.png',
	'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-account',
);
$gAds_menus_array['Performance Max Campaign'] = array(
	'content'    => 'gads-campaigns',
	'icon_image' => CED_WGEI_URL . 'admin/images/growth.png',
	'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-campaigns',
);
$gAds_menus_array['Conversions']              = array(
	'content'    => 'gads-conversions',
	'icon_image' => CED_WGEI_URL . 'admin/images/conversion-rate.png',
	'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-conversions',
);
$gAds_menus_array['Reporting']                = array(
	'content'    => 'gads-reporting',
	'icon_image' => CED_WGEI_URL . 'admin/images/report.png',
	'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-reporting',
);
$gads_tab_content                             = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'gads-account';
$conversion_created_status                    = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';


$google_shopping_lib_object = new Google_Shopping_Lib();
$get_all_step_data          = $google_shopping_lib_object->google_shopping_get_connected_googleads_acount_data_only( 'from_dash' );
$google_supported_currency  = $google_shopping_lib_object->google_shopping_get_google_supported_currency();
$google_supported_timezones = file( CED_WGEI_DIRPATH . 'admin/timezones.txt' );
$merchant_details           = get_option( 'ced_save_merchant_details', true );
$connected_gmail            = isset( $get_all_step_data['connected_gmail'] ) ? $get_all_step_data['connected_gmail'] : '';
$google_gmc                 = isset( $get_all_step_data['connected_gmc_account'] ) ? $get_all_step_data['connected_gmc_account'] : '';
$google_ads                 = isset( $get_all_step_data['connected_gads_account'] ) ? $get_all_step_data['connected_gads_account'] : '';
$all_gmc_accounts           = isset( $get_all_step_data['active_all_Gmcs_accounts'] ) ? $get_all_step_data['active_all_Gmcs_accounts'] : '';
$google_ads_account_details = isset( $get_all_step_data['active_all_Gads_accounts'] ) ? $get_all_step_data['active_all_Gads_accounts'] : '';
$ads_account_id             = ! empty( $google_ads ) ? $google_ads : 'Google Ads not connected.';
$ads_id                     = ! empty( $google_ads ) ? $google_ads : '';
update_option( 'connected_google_ads_id', $ads_id );
$compare_token = get_transient( 'time_during_create_google_token' );
if ( '' == $compare_token ) {
	regenerate_expired_token_for_google_shopping_intigration();
}

?>
<div class="ced__Main">
   <div class="ced-pageHeader ">
	  <div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
		 <div class="ced-flex__item">
			<h3 class="ced__Heading">Google Ads</h3>
		 </div>
	  </div>
   </div>
   <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	  <div class="ced-flex__item">
		 <div class="mt-30">
			<div class="ced-card  ">
			   <div class="ced-card__Body">
				  <div class="ced__cardContent">
					 <div class="ced-flex ced-flex--wrap">
						<?php
						$dash_menus = $gAds_menus_array;
						$html       = '';
						foreach ( $dash_menus as $dash_menus_key => $dash_menus_value ) {
							$active_class = '';
							if ( $gads_tab_content == $dash_menus_value['content'] ) {
								$active_class = 'ced_active_gads_tabs';
							}
							$html .= '<a class="ced_dash-gads_menus ' . $active_class . '" href="' . $dash_menus_value['url'] . '">';
							$html .= '<button class="ced-tablink ' . $active_class . '">';
							$html .= '<p>';
							$html .= '<img class="ced-tablink-img" src="' . $dash_menus_value['icon_image'] . '">';
							$html .= '</p>';
							$html .= $dash_menus_key;
							$html .= '</button></a>';
						}
						print_r( $html );
						?>
							  



						<div class="ced-user-id-wrap">
						   <h3 class="ced-user-btn"><?php esc_attr_e( $ads_account_id ); ?></h3>
						</div>


						<!-- account section -->
						<?php
						if ( 'gads-account' == $gads_tab_content ) {
							if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
								$user_token_data           = get_option( 'ced_google_user_login_data', true );
								$user_token                = $user_token_data['data']['token'];
								$user_id                   = $user_token_data['user_id'];
								$parameters                = array();
								$parameters['customer_id'] = $ads_id;
								$header                    = array(
									'Content-Type'  => 'application/x-www-form-urlencoded',
									'Authorization' => 'Bearer ' . $user_token,
								);
								// ---------------------------------------------------
								// Api call for get all the connecetd GMC accounts ---
								// ---------------------------------------------------
								$apiUrl        = 'https://express.sellernext.com/gfront/main/getMerchantAccountLinks';
								$api_response  = wp_remote_post(
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
								$connected_gmc = json_decode( $api_response['body'], true );
								// print_r($connected_gmc);
								// die('fdgd');
								$error_if_googleads_not_connected = isset( $connected_gmc['message'] ) ? $connected_gmc['message'] : '';
							}
							?>
						   <div id="accounts" class="ced-tabcontent">
							 <div class="ced-account-wrap">
							  <div class="ced-accordin">
								 <div class="ced-tab">
								  <input id="ced-tab-1" type="checkbox" checked>
								  <label for="ced-tab-1">Linked Merchant Center Accounts</label>
								  <div class="content">
									<?php
									if ( ! empty( $error_if_googleads_not_connected ) ) {
										// print_r($connected_gmc);
										$html  = '<div class="ced_gmc_not_connected_wrapper"><div class="ced_dash_gmc_heading">Link Google Merchant Center to Google Ads?</div>';
										$html .= "<div class='ced_dash_gmc_info'>To link your Merchant Center account, send a request from Merchant Center. Once you approve the incoming request, information will be shared between accounts.
                                       You'll be able to use product data from Merchant Center to create campaigns. Also, specific Google Ads statistics, like clicks, will be shown in the Merchant Center.
                                       </div>";
										$html .= "<div class='ced-gmc-butn-wrap'><button class='ced-btn-update'><a href='#add_gmc_ads_ids'>Add Account</a></button></div>";
										 print_r( $html );
									} else {
										// print_r($connected_gmc);
										?>
									   <table class="ced-marchant-table-data">
										 <tr class="ced-table-head">
											<td class="ced_gmc_td">Account Id</td>
											<td class="ced_gmc_td">Status</td>
											<td class="ced_gmc_td">Action</td>
										 </tr>
										 <tr>
										  <td class="ced_gmc_td"><h3 class="ced-user-btn"><?php esc_attr_e( $connected_gmc['data'][0]['serviceLinkId'] ); ?></h3></td>
										  <td class="ced_gmc_td"><p><?php esc_attr_e( $connected_gmc['data'][0]['linkStatus'] ); ?></p></td>

										  <?php
											if ( 'PENDING' == $connected_gmc['data'][0]['linkStatus'] ) {
												?>
											 <td class="ced-links-wrap ced_gmc_td"><p id="ced_dash_gmc_approve" data-linkid="<?php esc_attr_e( $connected_gmc['data'][0]['serviceLinkId'] ); ?>">Approve</p>
												<p id="ced_dash_gmc_unlink" data-linkid="<?php esc_attr_e( $connected_gmc['data'][0]['serviceLinkId'] ); ?>">Reject</p>
												<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
												<?php
											} else {
												?>
												<td><p id="ced_dash_gmc_unlink" data-linkid="<?php esc_attr_e( $connected_gmc['data'][0]['serviceLinkId'] ); ?>">UNLINK</p>
												<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
												<?php } ?>

											 </td>
										  </tr>
									   </table>
									<?php } ?>
								 </div>
							  </div>
						   </div>
						</div>
					 </div>
				  <?php } ?>
				  <!-- closing accounts -->









				  <!-- opening campaign -->
				  <?php
					if ( 'gads-campaigns' == $gads_tab_content ) {

						if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
							$user_token_data           = get_option( 'ced_google_user_login_data', true );
							$user_token                = $user_token_data['data']['token'];
							$user_id                   = $user_token_data['user_id'];
							$parameters                = array();
							$parameters['customer_id'] = $ads_id;
							$header                    = array(
								'Content-Type'  => 'application/x-www-form-urlencoded',
								'Authorization' => 'Bearer ' . $user_token,
							);
							// -----------------------------------------------------
							// Api call for get the all created campaign -----------
							// -----------------------------------------------------
							$apiUrl                         = 'https://express.sellernext.com/gfront/main/getCampaigns';
							$api_response                   = wp_remote_post(
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
							$get_all_campaign_details       = json_decode( $api_response['body'], true );
							$error_get_all_campaign_details = isset( $get_all_campaign_details['message'] ) ? $get_all_campaign_details['message'] : '';
						}
						?>
					 <div id="campaigns" class="ced-tabcontent">
					   <div class="ced-account-wrap">
						<div class="ced-accordin">

						   <div class="ced-tab">
							<input id="ced-tab-2" type="checkbox" checked>
							<label for="ced-tab-2">CREATE PERFORMANCE MAX CAMPAIGN</label>
							<div class="content">
							  <div class="ced-form-wrap">
								<h2>Campaign name</h2>
								<input id="ced_compaign_name" type="text" name="" class="ced-form-data">
							 </div>
							 <div class="ced-form-wrap">
							  <div class="ced-create-action-wrap">
								 <div class="ced-create-action-part-one">
									<h2>Budget</h2>
									<p class="ced-subtext">Enter the average you want to spend each day</p>
									<input type="number" id="ced_compaign_budget" name="budget" min="0" max="5" class="ced-form-data">

								 </div>
								 <div class="ced-create-action-part-one">
									<p>For the month, you won't pay more than your daily budget times the average number of days in a month. Some days you might spend less than your daily budget, and on others you might spend up to twice as much.</p>

								 </div>
							  </div>


						   </div>
						   <div class="ced-form-wrap">
							  <div class="ced-create-action-wrap">
								 <div class="ced-create-action-part-one">
								   <h2>Location</h2>
								</div>
								<div class="ced-create-action-part-one">
								 <p><strong>Set Target Location</strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
								 <p><input type="radio" class="ced-cam-radio ced_compaign_location" id="ced_select_another_location" name="ced_compaign_location">Enter another location</p>
							  <div class="form-group" id="googleSelectCampaignCity">
								 <input type="text" class="form-control" placeholder="Enter City Name" id="campaignSelectCity"/>

							  </div>
								 <p><input type="radio" value="All" class="ced-cam-radio ced_compaign_location" id="selectAllLocations" name="ced_compaign_location">All countries and territories</p>
								 <p><input type="radio" value="India" class="ced-cam-radio ced_compaign_location" id="selectIndia" name="ced_compaign_location">India</p>
							  </div>
						   </div>

						</div>
						<div class="ced-form-wrap">
						  <h2>ADVANCE OPTIONS</h2>
						  <div class="ced-data-performance-wrap">
							 <div class="ced-data-half">
								<p>Start Date</p>
								<input id="ced_dash_campaign_start_date" type="date" class="ced-data-camp-input" name="">
							 </div>
							 <div class="ced-data-half">
								<p>End Date</p>
								<input id="ced_dash_campaign_end_date" type="date" class="ced-data-camp-input" name="">
							 </div>
							 <div class="ced-data-half">
								<p>Select ROAS</p>
								<select id="ced_dash_campaign_roas_amount" class="ced-data-camp-input">
								   <option value="" disabled="">Please Select ROAS, min: 3.5, max: 10</option><option value="3.5">3.5</option><option value="4.0">4.0</option><option value="4.5">4.5</option><option value="5.0">5.0</option><option value="5.5">5.5</option><option value="6.0">6.0</option><option value="6.5">6.5</option><option value="7.0">7.0</option><option value="7.5">7.5</option><option value="8.0">8.0</option><option value="8.5">8.5</option><option value="9.0">9.0</option><option value="9.5">9.5</option><option value="10.0">10.0</option>
								</select>
							 </div>
						  </div>
					   </div> 
					   <div class="ced-buttons">
						<button class="ced-btn-cancel" id="ced_cancel_pmax_campaign">Cancel</button>
						<button class="ced-button-max" id="ced_create_pmax_campaign">Create Performance Max Campagin</button>
						<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
						<div class="ced_show_response_messages"></div>
						<div class="ced_error_during_creating_compaign"></div>
					 </div> 
				  </div>
			   </div>
			</div>

		 </div>
		 <div class="ced-account-wrap">
		   <h3>Performance Max Campaigns</h3>
		   <div class="ced-table-data-wrap" style="overflow: auto;">
						<?php
						if ( ! empty( $error_get_all_campaign_details ) ) {
							esc_attr_e( $error_get_all_campaign_details );
						} else {
							if ( ! empty( $get_all_campaign_details ) ) {
								?>
				  <table class="ced-marchant-table-data">
					<tr class="ced-table-head">
					   <td>Name</td>
					   <td>Budget</td>
					   <td>Campaign Type</td>
					   <td>Action</td>
					   <td>Status</td>
					   </tr>
								<?php
								$all_campaign_details = $get_all_campaign_details['data']['rows'];
								// print_r($all_campaign_details);
								foreach ( $all_campaign_details as $get_all_campaign_details_key => $all_campaign_details_val ) {
									$campaign_name      = $all_campaign_details_val['Name'];
									$campaign_id        = $all_campaign_details_val['Id'];
									$campaign_budget    = $all_campaign_details_val['Budget']['Amount'];
									$campaign_budget_id = $all_campaign_details_val['Budget']['Id'];
									$campaign_type      = $all_campaign_details_val['AdvertisingChannelType'];
									$campaign_status    = $all_campaign_details_val['Status'];
									$status_checked     = '';
									if ( 'ENABLED' == $campaign_status ) {
										$status_checked = 'checked';
									}
									?>
						<tr class="ced-data-content">
						  <td><p><?php esc_attr_e( $campaign_name ); ?></p></td>
						  <td><p>INR <?php esc_attr_e( $campaign_budget ); ?></p></td>
						  <td><p><?php esc_attr_e( $campaign_type ); ?></p></td>
						  <td><a href="#edit_campaigns" id="ced_edit_campaign" data-budgetId="<?php esc_attr_e( $campaign_budget_id ); ?>" data-campaign_id="<?php esc_attr_e( $campaign_id ); ?>" data-campaign_name="<?php esc_attr_e( $campaign_name ); ?>" data-campaign_budget="<?php esc_attr_e( $campaign_budget ); ?>"><img class="ced-map-edit" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/pencil.png' ); ?>"></a></td>
						  <td class="ced_campaign_td_status">
						   <label class="ced-switch">
							 <input class="ced_set_campaign_status" data-campaign_id="<?php esc_attr_e( $campaign_id ); ?>" type="checkbox" <?php esc_attr_e( $status_checked ); ?>>
							 <span class="ced-slider round"></span>
						  </label>
						  <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
					   </td>
					</tr>
									<?php
								}
								print_r( '</table>' );
							}
						}
						?>
		</div>
	 </div>
	</table>
  </div></div></div>
<?php } ?>
<!-- closing campaign -->








<!-- opening conversion -->
<?php
$conversion_tab_content = isset( $_GET['tab_content'] ) ? sanitize_text_field( $_GET['tab_content'] ) : '';
if ( 'gads-conversions' == $gads_tab_content ) {
	if ( 'conversion_content' != $conversion_tab_content ) {
		if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
			$user_token_data           = get_option( 'ced_google_user_login_data', true );
			$user_token                = $user_token_data['data']['token'];
			$user_id                   = $user_token_data['user_id'];
			$parameters                = array();
			$parameters['customer_id'] = $ads_id;
			$parameters['count']       = 20;
			$parameters['start_index'] = 0;
			$header                    = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			// -----------------------------------------------------
			// Api call for get the all created campaign -----------
			// -----------------------------------------------------
			$apiUrl             = 'https://express.sellernext.com/gfront/main/getConversions';
			$api_response       = wp_remote_post(
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
			$get_all_conversion = json_decode( $api_response['body'], true );
			$all_conversions    = isset( $get_all_conversion['data']['rows'] ) ? $get_all_conversion['data']['rows'] : '';
			$api_status         = isset( $get_all_conversion['success'] ) ? $get_all_conversion['success'] : '';
		}
		 // $error_get_all_campaign_details = isset($get_all_campaign_details['message'])?$get_all_campaign_details['message'] :'';
		?>
	  <div id="conversions" class="ced-tabcontent">
	   <div class="ced-account-wrap">
		 <?php
			if ( 1 != $api_status ) {
				?>
			<div class="ced-no-conversion-wrap">
			 <h3>No Conversion found</h3>
			 <p>An ad group contains one or more ads that share similar targets.</p>
			 <a href="<?php esc_attr_e( admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-conversions&tab_content=conversion_content' ); ?>"><button class="ced-no-coversion-btn">Create Conversions</button></a>
		  </div>
				<?php
			} else {
				?>
		  <div class="ced-no-conversion-wrap">
			 <!--view part--->
			 <div class="ced-conversion-buttons-wrap">
			  <div class="ced-conversion">
			   <h3>Conversion</h3>
			</div>

			<div class="ced-conversions-btn-combo">
			   <button class="ced-create-continue"><a href="#ced_auto_create_conversion">Auto Create Conversion & Upload Tag</a></button>
			   <button class="ced-no-coversion-btn"><a href="<?php esc_attr_e( admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-conversions&tab_content=conversion_content' ); ?>"> Create Specific Conversion</a></button>
			   <a href=""><img src=""></a>
			</div>
		 </div>
		 <div class="ced-table-data-wrap" style="overflow: auto;">
		  <table class="ced-marchant-table-data">
			 <tr class="ced-table-head">
				<td>Action / View</td>
				<td>Conversion Name</td>
				<td>Category</td>
				<td>Conversion Window</td>
				<td>Counting Type </td>
			 </tr>
				   <?php
					foreach ( $all_conversions as $all_conversions_key => $all_conversions_val ) {
						$html  = '<tr class="ced-data-content">';
						$html .= '<td><p><a href="#ced_show_created_conversion_data_popup" class="ced_show_created_conversion_popup" data-conversionId=' . $all_conversions_val['Id'] . '><img class="ced-img-edit" src="' . esc_attr( CED_WGEI_URL . 'admin/images/eye.png' ) . '"></a></p></td>';
						$html .= '<td><p>' . $all_conversions_val['Name'] . '</p></td>';
						$html .= '<td><p class="ced-badge ced_badge_bg_' . $all_conversions_val['Category'] . '">' . $all_conversions_val['Category'] . '</p></td>';
						$html .= '<td><p>' . $all_conversions_val['CtcLookbackWindow'] . '</p></td>';
						$html .= '<td><p>' . $all_conversions_val['CountingType'] . '</p></td>';
						$html .= '</tr>';
						print_r( $html );
					}
					?>
		  </table>
	   </div>

	   <!--view part end-->
	</div>



				<?php
			}
	} else {
		?>
	  <div id="conversions" class="ced-tabcontent">
	   <div class="ced-account-wrap">
   <!---else part-->
   <div class="ced-no-conversion-wrap ced_google_shopping_create_conversion_fields">
	<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	  <div class="ced-flex__item">

		 <div class="ced-card">
			<div class="ced-card__Body">

			   <div class="ced__cardContent">
				 <h3 class="ced-heading-right">Create a Action</h3>
				 <div class="ced-flex ced-flex--wrap">
				  <div class="ced-account-id-wrap ">
					 <div class="ced-create-action-wrap ced-align">
						<div class="ced-create-action-part-one">Conversion name</div>
						<div class="ced-create-action-part-one">
						   <input type="text" class="ced-form-data" name="ced_google_conversion_action_name" id="ced_google_conversion_name">
						</div>
					 </div>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
   </div>
</div>
<div class="">
   <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	  <div class="ced-flex__item">
		 <div class="ced-card">
			<div class="ced-card__Body">
			   <div class="ced__cardContent">
				  <div class="ced-flex ced-flex--wrap">
					 <div class="ced-account-id-wrap">

					  <div class="ced-accordin">
						<div class="ced-tab">
						  <input id="ced-tab-3" type="checkbox" checked>
						  <label for="ced-tab-3" class="ced-box-shw">Category</label>
						  <div class="content">
						   <div class="ced-create-action-wrap">
							  <div class="ced-create-action-part-one">Select the action that you'd like to track</div>
							  <div class="ced-create-action-part-one">
								 <div class="ced-unlist-items">
								  <p><input type="radio" name="ced_google_conversion_cat_action_track" class="ced-radio ced_google_conversion_cat_action_track" value ="PURCHASE">Purchase</p>    
								  <p><input type="radio" name="ced_google_conversion_cat_action_track"  class="ced-radio  ced_google_conversion_cat_action_track" value ="CONTACT">Lead</p>
								  <p><input type="radio" name="ced_google_conversion_cat_action_track" class="ced-radio ced_google_conversion_cat_action_track" value ="PAGE_VIEW">Page view</p>
								  <p><input type="radio" name="ced_google_conversion_cat_action_track"  class="ced-radi ced_google_conversion_cat_action_track"  value ="SIGNUP">Sign up</p>
								  <p><input type="radio" name="ced_google_conversion_cat_action_track" class="ced-radio ced_google_conversion_cat_action_track"  value ="ADD_TO_CART">Add to cart</p>
								  <p><input type="radio" name="ced_google_conversion_cat_action_track"  class="ced-radi ced_google_conversion_cat_action_track" value ="STORE_VISIT">Store Visit</p>
								  <p><input type="radio" name="ced_google_conversion_cat_action_track" class="ced-radio ced_google_conversion_cat_action_track" checked value ="PBDEFAULT" >Other</p>
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
</div>
</div>
<div class="">
  <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	 <div class="ced-flex__item">
		<div class="ced-card">
		   <div class="ced-card__Body">
			  <div class="ced__cardContent">
				 <div class="ced-flex ced-flex--wrap">
					<div class="ced-account-id-wrap">
					   <div class="ced-accordin">
						  <div class="ced-tab">
							<input id="ced-tab-4" type="checkbox" checked>
							<label for="ced-tab-4" class="ced-box-shw">Count</label>
							<div class="content">
							 <div class="ced-create-action-wrap">
								<div class="ced-create-action-part-one">Select the action that you'd like to track</div>
								<div class="ced-create-action-part-one">
								   <div class="ced-unlist-items">
									  <p><input type="radio" name="count_aciton" class="ced-radio ced_google_conversion_action_count" value="MANY_PER_CLICK">Every</p>
									  <p class="ced-sub-para">Recommended for purchases because every purchase is valuable.</p>
									  <p><input type="radio" name="count_aciton" class="ced-radio ced_google_conversion_action_count" checked value="ONE_PER_CLICK">One</p>
									  <p class="ced-sub-para">Recommended for leads, sign-ups and other conversions because only the first interaction is valuable.</p>

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
</div>
</div>
<div class="">
  <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	 <div class="ced-flex__item">
		<div class="ced-card">
		   <div class="ced-card__Body">
			  <div class="ced__cardContent">
				 <div class="ced-flex ced-flex--wrap">
					<div class="ced-account-id-wrap">
					   <div class="ced-accordin">
						  <div class="ced-tab">
							<input id="ced-tab-5" type="checkbox" checked>
							<label for="ced-tab-5" class="ced-box-shw">CONVERSION WINDOW</label>
							<div class="content">
							 <div class="ced-create-action-wrap">
								<div class="ced-create-action-part-one">Conversions can happen days after a person interacts with your ad. Select the maximum time after an ad interaction that you want to count conversions</div>
								<div class="ced-create-action-part-one">
								   <div class="ced-form-data">
									  <select class="ced-select-data ced_google_throug_cnvrsn_windw_after_day">
									   <option value="CUSTOM">Custom</option><option value="90">90 Days</option><option value="60">60 Days</option><option value="45">45 Days</option><option value="30" selected >30 Days</option><option value="28">4 Weeks</option><option value="21">3 Weeks</option><option value="14">2 Weeks</option><option value="7">1 Weeks</option>
									</select>
									<div class="ced_google_throug_cnvrsn_windw_after_day_inp_wrap">
									   <input type="text" class="ced-form-data ced_google_throug_cnvrsn_windw_after_day_inp_val" name="" placeholder="Days">
									   <span>Enter in a whole number b/w 1 - 90 Days.</span>
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
</div>
</div>
</div>
<div class="">
   <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	  <div class="ced-flex__item">
		 <div class="ced-card">
			<div class="ced-card__Body">
			   <div class="ced__cardContent">
				  <div class="ced-flex ced-flex--wrap">
					 <div class="ced-account-id-wrap">
						<div class="ced-accordin">
						   <div class="ced-tab">
							 <input id="ced-tab-6" type="checkbox" checked>
							 <label for="ced-tab-6" class="ced-box-shw">VIEW-THROUGH CONVERSION WINDOW</label>
							 <div class="content">
							  <div class="ced-create-action-wrap">
								 <div class="ced-create-action-part-one">Select the maximum time after a person views your ad that you want to count view-through conversions</div>
								 <div class="ced-create-action-part-one">
								   <div class="ced-form-data">
									<select class="ced-select-data ced_google_cnvrsn_view_throug_cnvrsn_windw">
									   <option value="CUSTOM">Custom</option><option value="30" selected>30 Days</option><option value="28">4 Weeks</option><option value="21">3 Weeks</option><option value="14">2 Weeks</option><option value="7">1 Week</option><option value="3">3 Days</option><option value="1">1 Day</option>
									</select>
									<div class="ced_google_cnvrsn_view_throug_cnvrsn_windw_inp_wrap">
									   <input type="text" class="ced-form-data ced_google_cnvrsn_view_throug_cnvrsn_windw_inp_wrap_val" name="" placeholder="Days">
									   <span>Enter in a whole number b/w 1 - 30 Days.</span>
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
</div>
</div>
</div>
<div class="">
 <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	<div class="ced-flex__item">
	   <div class="ced-card">
		  <div class="ced-card__Body">
			 <div class="ced__cardContent">
				<div class="ced-flex ced-flex--wrap">
				   <div class="ced-account-id-wrap">
					  <div class="ced-accordin">
						 <div class="ced-tab">
						   <input id="ced-tab-7" type="checkbox" checked>
						   <label for="ced-tab-7" class="ced-box-shw">ATTRIBUTION MODEL</label>
						   <div class="content">
							<div class="ced-create-action-wrap">
							   <div class="ced-create-action-part-one">Select an attribution model for your Search Network and Shopping conversions</div>
							   <div class="ced-create-action-part-one">
								  <div class="ced-form-data">
									 <select class="ced-select-data ced_google_conversion_attribute_model">
									   <option value="GOOGLE_SEARCH_ATTRIBUTION_DATA_DRIVEN">Data Driven</option><option value="GOOGLE_ADS_LAST_CLICK" selected>Last Click</option><option value="GOOGLE_SEARCH_ATTRIBUTION_FIRST_CLICK">First click</option><option value="GOOGLE_SEARCH_ATTRIBUTION_LINEAR">Linear</option><option value="GOOGLE_SEARCH_ATTRIBUTION_TIME_DECAY">Time Decay</option><option value="GOOGLE_SEARCH_ATTRIBUTION_POSITION_BASED">Position Based</option>
									</select>
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
</div>
</div>
<div class="">
 <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
	<button class="ced-create-continue ced_google_create_conversion">Create and Continue</button>
	<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
 </div>
 
</div>
</div>
<!-- start section afer submitteed the conversion  -->
<div class="ced-no-conversion-wrap ced_google_shopping_conversion_created_section">
   <!--create specific section-->
   <h3 class="ced-conversion-title">You've created a conversion action. Now, set up the tag to add to your website.</h3>
   <div class="ced-created-conversion-section">
	<div class="ced-create-action-part-one">
	  <div class="ced-action-wrap">
		 <h3>Install Tag Yourself</h3>
		 <p>Instruction - To set up conversion tracking for yuyu, you must have the global site tag and an event snippet in the code your page uses. To add the tag and snippet, select the framework your page uses and follow the instructions.</p>

		 <h3>Global site tag</h3>
		 <p>The global site tag adds visitors to your basic remarketing lists and sets new cookies on your domain, which will store information about the ad click that brought a user to your website. You must install this tag on every page of your website.
			<br><br>
			Copy the tag below and paste it in between the <head> </head> tags of every page of your website. You only need to install the global site tag once per account, even if you're tracking multiple actions.</p>

			<div class="ced-text-copy">
			 <textarea class="ced_google_shopping_conversion_global_site_tag" resize cols="10" disabled></textarea>
		  </div>
		  <div class="ced-btn-wrap">
		   <button class="ced-create-continue ced_google_shopping_conversion_global_site_tag_copied">Copy To clipboard</button>
		</div>

		<div class="ced-line-break"></div>

		<h3>Event Snippet</h3>
		<p>The event snippet works with the global site tag to track actions that should be counted as conversions. Choose whether to track conversions on a page load or click.
		 <br><br>
		 Copy the snippet below and paste it in between the <head> </head> tags of the page(s) that you'd like to track, right after the global site tag.</p>

		 <div class="ced-text-copy">

		  <textarea class="ced_google_shopping_conversion_event_site_tag" resize cols="10" disabled></textarea>
	   </div>
	   <div class="ced-btn-wrap">
		<button class="ced-create-continue ced_google_shopping_conversion_event_site_tag_copied">Copy To clipboard</button>
	 </div>


  </div>
  <div class="ced-btn-wrap">
	 <button class="ced-create-continue ced_google_shopping_continue_after_create_conversion">Continue</button>
  </div>
</div>
<div class="ced-create-action-part-one">
   <div class="ced-action-wrap">
	  <h3>Automatic setup global site tag</h3>
	  <p>Introduction - In this section we automatically upload the Global site tag to your Shopify store but you have to upload the Event snippet manually.</p>
	  <div class="ced-btn-wrap">
		<button class="ced-create-continue ced_auto_upload_google_global_site_tag">Upload global site tag to website</button>
	 </div>
  </div>
</div>
</div>

<!--end here-->
</div>

<div class="ced-no-conversion-wrap ced_google_shopping_conversion_created_section_message">
   <!--continue section-->
   <div class="ced-created-continue-section">
	<h3>Whats Next</h3>
	<div class="ced-action-wrap ced-continue">
	 <h3>You've set up your yuyu conversion action</h3>
	 <h3>Next Steps:</h3>
	 <ul>
	   <li>For conversion tracking to work, you'll need to add the global site tag and event snippet to your website.</li>
	   <li>To make sure that your tag is working, check the tracking status on the 'Conversion actions' page. It might take a few hours to verify that the tag is on your website.</li>
	   <li>You can also use the Google Tag Assistant plugin for Chrome to make sure that your tag is working.</li>
	   <li>If your servers redirect ad clicks, verify that the Google Click ID (GCLID) URL parameter is passed to your landing page.</li>
	   <li>You can edit the settings for this conversion action at any time.</li>
	</ul>
	<div class="ced-btn-wrap">
	 <a href="<?php esc_attr_e( admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads&tab=gads-conversions' ); ?>"><button class="ced-create-continue">Done</button></a>
  </div>

</div>


</div>

<!--end here-->
</div>
<!-- ending section afer submitted the conversion -->
		<?php
	}
	?>
<!--end-->
</div>
</div>
</div>
	<?php
}

?>
<!-- closing conversion -->







<!-- opening reporting -->
<?php
if ( 'gads-reporting' == $gads_tab_content ) {
	if ( ! empty( get_option( 'ced_google_user_token_data', true ) ) ) {
		$user_token_data          = get_option( 'ced_google_user_login_data', true );
		$user_token               = $user_token_data['data']['token'];
		$user_id                  = $user_token_data['user_id'];
		$parameters               = array();
		$parameters['customerId'] = $ads_id;
		$parameters['dateRange']  = 'LAST_7_DAYS';
		$parameters['reportType'] = 'CAMPAIGN_PERFORMANCE_REPORT';
		$parameters['status']     = array( 'ENABLED', 'PAUSED' );
		$header                   = array(
			'Content-Type'  => 'application/x-www-form-urlencoded',
			'Authorization' => 'Bearer ' . $user_token,
		);
		// ---------------------------------------------------
		// Api call for get default report here  ---
		// ---------------------------------------------------
		$apiUrl               = 'https://express.sellernext.com/gfront/app/getReportFeilds';
		$api_response         = wp_remote_post(
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
		$default_reports      = json_decode( $api_response['body'], true );
		$default_reports_data = isset( $default_reports['data'] ) ? $default_reports['data'] : '';
	}

	?>
   <div id="reporting" class="ced-tabcontent">
	<div class="ced-account-wrap">
	   <h3>Reporting</h3>
	   <div class="ced-report-filter">
		<div class="ced-report-type-filter">
		   <p>Report Type</p>
		   <select class="ced-filter-select ced_google_shopping_get_reports_dropdown_values" id="ced_google_shopping_campaign_type">
			<option value="CAMPAIGN_PERFORMANCE_REPORT" selected>CAMPAIGN PERFORMANCE REPORT</option>
		 </select>
	  </div>
	  <div class="ced-date-range-filter">
		 <p>Report Type</p>
		 <select class="ced-filter-select ced_google_shopping_get_reports_dropdown_values" id="ced_google_shopping_campaign_date_range">
			<option value="TODAY">Today</option><option value="YESTERDAY">Yesterday</option><option value="LAST_7_DAYS" selected>Last 7 days</option><option value="LAST_WEEK">Last week</option><option value="LAST_BUSINESS_WEEK">Last business week</option><option value="THIS_MONTH">This month</option><option value="LAST_MONTH">Last month</option><option value="LAST_14_DAYS">Last 14 days</option><option value="LAST_30_DAYS">Last 30 days</option><option value="THIS_WEEK_SUN_TODAY">This week (Sun - Today)</option><option value="THIS_WEEK_MON_TODAY">This week (Mon - Today)</option><option value="LAST_WEEK_SUN_SAT">Last week (Sun - Sat)</option>
		 </select>
	  </div>
	  <div class="ced-status-filter">
		 <p>Report Type</p>
		 <select class="ced-filter-select ced_google_shopping_get_reports_dropdown_values" id="ced_google_shopping_campaign_status">
		  <option value="all" selected >All</option><option value="ENABLED">Enabled</option><option value="PAUSED">Paused</option>
	   </select>
	</div>
   <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
   <div class="ced_download_google_report">
		  <button class="ced-create-continue" id="ced_download_google_campaign_report">Download Report</button>
	  <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
   </div>

 </div>
 <div class="ced-table-data-wrap" style="overflow: auto;">
	<table class="ced-marchant-table-data">
	   <tr class="ced-table-head">
		  <td>Campaign Name</td>
		  <td>Campaign Type</td>
		  <td>Campaign Status</td>
		  <td>Clicks</td>
		  <td>Impressions </td>
		  <td>Conversions</td>
		  <td>Conversions Value</td>
		  <td>CTR</td>
		  <td>CPC</td>
		  <td>Cost</td>
	   </tr>
	   <tbody class="ced_google_shopping_report_table_content">
	   <?php
		if ( ! empty( $default_reports_data ) ) {
			foreach ( $default_reports_data as $default_reports_data_key => $default_reports_data_val ) {
				$campaign_name              = $default_reports_data_val['Campaign_name'];
				$campaign_type              = $default_reports_data_val['type'];
				$campaign_status            = $default_reports_data_val['status'];
				$campaign_clicks            = $default_reports_data_val['clicks'];
				$campaign_impression        = $default_reports_data_val['impressions'];
				$campaign_conversion        = $default_reports_data_val['conversion'];
				$campaign_conversions_value = $default_reports_data_val['conversions_value'];
				$campaign_CTR               = $default_reports_data_val['ctr'];
				$campaign_CPC               = $default_reports_data_val['cpc'];
				$campaign_Cost              = $default_reports_data_val['cost'];
				$report_data                = '<tr class="ced-data-content">
            <td><p>' . $campaign_name . '</p></td>
            <td><p>' . $campaign_type . '</p></td>
            <td><p class="ced-badge">' . $campaign_status . '</p></td>
            <td><p>' . $campaign_clicks . '</p></td>
            <td><p>' . $campaign_impression . '</p></td>
            <td><p>' . $campaign_conversion . '</p></td>
            <td><p>' . $campaign_conversions_value . '</p></td>
            <td><p>$ ' . $campaign_CTR . '</p></td>
            <td><p>$ ' . $campaign_CPC . '</p></td>
            <td><p>$ ' . $campaign_Cost . '</p></td>
            </tr>';
				print_r( $report_data );
			}
		}
		?>
   </tbody>
   </table>
</div>
</div>
</div>
<!-- closing reporting -->
<?php } ?>




</div>
</div>
</div>
</div>
</div>
</div>







<!-------popup for edit campaign---->
<div id="edit_campaigns" class="overlay">
  <div class="popup">
	<div class="popup-head"><h2>Update Campaign </h2>
	   <a class="close" href="#">&times;</a></div>
	   <div class="content">
		 <label>Name</label>
		 <input type="text" id="ced_compaign_submited_name"class="ced-account-textbox" name="" placeholder="Campaign name">
		 <div class="">
		   <p class="ced-pop-space">Budget</p>
		   <input type="number"  id="ced_compaign_submited_budget" class="ced-account-textbox" placeholder="budget">
		</div>
		<div class="ced-updt-camp">If you want to update Location <div class="ced_dash_update_campaign_edit_location"><a>Click Here</a>
		</div>
		 <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
	 </div> 
	 <div class="ced_dash_update_campaign_edit_location_content">
		<p class="ced-pop-space">Add More Locations / Edit Locations</p>
		<div class="form-group" id="ced_googleSelectCampaignCity_update_campaign">
		 <input type="text" class="form-control" placeholder="Enter City Name" id="campaignSelectCity_update_campaign"/>
	  </div>
	  <div class="ced_compaign_submited_city"></div>
   </div>
</div>
<div class="ced-popup-footer">
   <div class="ced-btn-update ced_update_gmax_campaign"><a href="">Update Campaign</a></div>
   <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
</div>
</div>
</div>

<!-- popup for add gmc again and make it active  -->
<!-------popup---->
<div id="add_gmc_ads_ids" class="overlay">
  <div class="popup">
	<div class="popup-head"><h2>Add Ads Id </h2>
	   <a class="close" href="#">&times;</a></div>
	   <div class="content">
		 <label>Add a new Google Ads Id (Hyphen '-' not required)</label>
		 <input type="text" id="ced_ads_google_ids"class="ced-account-textbox" name="" placeholder="Ads ID">

	  </div>
	  <div class="ced_goole_error_notices ced_error_during_set_ads_account"></div>

	  <div class="ced-popup-footer">
		 <div class="ced-btn-update ced_ads_gids_after_remove_gmc_acnt"><a href="">Add Account</a></div>
		 <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
	  </div>
   </div>
</div>
<!-- popup for show the created conversion details  -->
<!-------popup---->
<div id="ced_show_created_conversion_data_popup" class="overlay">
  <div class="popup">
	<div class="popup-head"><h2>Conversion Detials </h2>
	   <a class="close" href="#">&times;</a></div>
	   <div class="content-alt">

		 <div class="ced_google_shopping_popup_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
		 <div class="ced-no-conversion-wrap ced_google_shopping_conversion_data_visible">

			<!--create specific section-->
			<h3 class="ced-conversion-title">You've created a conversion action. Now, set up the tag to add to your website.</h3>
			<div class="ced-created-conversion-section">
			 <div class="ced-create-action-part-one">
			   <div class="ced-action-wrap">
				  <h3>Install Tag Yourself</h3>
				  <p>Instruction - To set up conversion tracking for yuyu, you must have the global site tag and an event snippet in the code your page uses. To add the tag and snippet, select the framework your page uses and follow the instructions.</p>

				  <h3>Global site tag</h3>
				  <p>The global site tag adds visitors to your basic remarketing lists and sets new cookies on your domain, which will store information about the ad click that brought a user to your website. You must install this tag on every page of your website.
					 <br><br>
					 Copy the tag below and paste it in between the <head> </head> tags of every page of your website. You only need to install the global site tag once per account, even if you're tracking multiple actions.</p>

					 <div class="ced-text-copy">
					   <textarea class="ced_google_shopping_conversion_global_site_tag_popup" resize cols="10" disabled></textarea>
					</div>
					<div class="ced-btn-wrap">
					   <button class="ced-create-continue google_shopping_conversion_global_site_tag_copied">Copy To clipboard</button>
					</div>

					<div class="ced-line-break"></div>

					<h3>Event Snippet</h3>
					<p>The event snippet works with the global site tag to track actions that should be counted as conversions. Choose whether to track conversions on a page load or click.
					 <br><br>
					 Copy the snippet below and paste it in between the <head> </head> tags of the page(s) that you'd like to track, right after the global site tag.</p>

					 <div class="ced-text-copy">

					   <textarea class="ced_google_shopping_conversion_event_site_tag_popup" resize  cols="10"  disabled ></textarea>
					</div>
					<div class="ced-btn-wrap">
					   <button class="ced-create-continue google_shopping_conversion_event_site_tag_copied">Copy To clipboard</button>
					</div>


				 </div>
<!--        <div class="ced-btn-wrap">
		  <button class="ced-create-continue ced_google_shopping_continue_after_create_conversion">Continue</button>
	   </div> -->
	</div>
	<div class="ced-create-action-part-one">
	  <div class="ced-action-wrap">
		 <h3>Automatic setup global site tag</h3>
		 <p>Introduction - In this section we automatically upload the Global site tag to your Shopify store but you have to upload the Event snippet manually.</p>
		 <div class="ced-btn-wrap">
		   <button class="ced-create-continue ced_auto_upload_google_global_site_tag">Upload global site tag to website</button>

		   <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>       </div>
		</div>
	 </div>
  </div>

  <!--end here-->
</div>
</div>
<div class="ced_goole_error_notices ced_error_during_set_ads_account"></div>
</div>
</div>

<!-- popup for show the auto create  conversion  -->
<!-------popup---->
<div id="ced_auto_create_conversion" class="overlay">
  <div class="popup">
	<div class="popup-head"><h2>Automatic Create Conversions & Upload Tags</h2>
	   <a class="close" href="#">&times;</a></div>
	   <div class="content">

		 <div class="ced_auto_create_conversion_content_info">
			By clicking Automatic Create Conversions & Upload Tags, We will add tracking script on your Shopify store and following actions will be tracked in Automatically. 
		 </div>
		 <div class="ced_auto_create_conversion_content_list">
			1) Purchase <br>
			2) Page View <br>
			3) Add To Cart
		 </div>

	  </div>

	  <div class="ced-popup-footer">
		 <div class="ced-btn-update ced_auto_create_conversion_and_upload_tag"><a href="">Create and Upload</a></div>
		 <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
	  </div>
   </div>
</div>
