<?php
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
	$apiUrl                = 'https://express.sellernext.com/google/app/getAccountDetails';
	$account_info          = wp_remote_post(
		$apiUrl,
		array(
			'body'        => $parameters,
			'headers'     => $header,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'timeout'     => 120,
		)
	);
	if ( isset( $account_info['body'] ) ) {
		$account_info_response = json_decode( $account_info['body'], true );
		$account_info_response = $account_info_response['Data'];
	}
	$apiUrl            = 'https://express.sellernext.com/google/app/isWebSiteVerified';
	$isWebSiteVerified = wp_remote_post(
		$apiUrl,
		array(
			'body'        => $parameters,
			'headers'     => $header,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'timeout'     => 120,
		)
	);
	if ( isset( $isWebSiteVerified['body'] ) ) {
		$isWebSiteVerified_response = json_decode( $isWebSiteVerified['body'], true );
		$isWebSiteVerified_response = $isWebSiteVerified_response['message'];
	}
}
?>
<div class="ced__Main">
  <div class=" ced-Layout">
	<div class="">
	  <div class="ced-card ced-card--plain ">
		<div class="ced-card__Body">
		  <div class="ced__cardContent">
			<div class="ced-pageHeader ">
			  <div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
				<div class="ced-flex__item">
				  <h3 class="ced__Heading">
					<h3 class="ced__Heading">Account Info</h3>
				  </h3>
				</div>
			  </div>
			</div>
			<!---cardcontent-->
			<?php
			// print_r($isWebSiteVerified_response);
			?>
			<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100 ced-filter-alt">
			  <div class="ced-flex__item">
				<div class="">
				  <div class="ced-card">
					<div class="ced-card__Body">
					  <div class="ced__cardContent">
						<div class="ced-flex ced-flex--wrap">
						  <div class="ced-log-table">
							<div class="">
							  <div class="ced-accordian">
								<div class="ced-tab">
								  <input id="ced-tab-1" type="checkbox" checked>
								  <label for="ced-tab-1">Business Information</label>
								  <div class="content">
									<div class="ced-account-info-wrap">
									  <div class="ced-title"><?php esc_attr_e( isset( $account_info_response['name'] ) ? $account_info_response['name'] : '' ); ?> <span class="ced-user-btn"><?php esc_attr_e( isset( $account_info_response['id'] ) ? $account_info_response['id'] : '' ); ?></span>
									  </div>
									  <div class="ced-account-info-img">
										
									  </div>
									</div>
									<div class="ced-create-action-wrap">
									  <div class="ced-create-action-part-one">
										<div class="ced-info-data">
										  <div class="ced-info-data-view">
											<h3>Website Information</h3>
											<p>
											  <b>Website Url </b> :  <?php esc_attr_e( isset( $account_info_response['websiteUrl'] ) ? $account_info_response['websiteUrl'] : '' ); ?>
											</p>
										  </div>
										  <div class="ced-line-break"></div>
										  <div class="ced-info-data-view">
											<p>
											  <b>Status </b>: <a href="">Help Video</a>
											</p>
											<p>
											  <?php
												$saved_caliam_and_verify_site_tag = get_option( 'ced_google_shopping_claim_and_verify_token' );
												if ( 'Store is not verified!' == $isWebSiteVerified_response && empty( $saved_caliam_and_verify_site_tag ) ) {
													$html  = '<span class="ced-warning-badge">UnClaimed and Unverified</span>';
													$html .= '<button class="ced-btn-verify ced_gs_gmc_verify_and_claim" data-websiteurl=' . esc_attr( isset( $account_info_response['websiteUrl'] ) ? $account_info_response['websiteUrl'] : '' ) . '>Verify and Claim</button>';
												} else {
													$html  = '<span class="ced-warning-badge">Claimed and Verified</span>';
													$html .= '<button class="ced-btn-verify ced_gs_gmc_verify_and_claim" data-websiteurl=' . esc_attr( isset( $account_info_response['websiteUrl'] ) ? $account_info_response['websiteUrl'] : '' ) . '>Re-Verify</button>';

													$html .= '<div class="ced_reverified">Your Site is claimed and Verfied.</div>';
												}
												print_r( $html );
												?>
											  <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
											</p>
										  </div>
										  <div class="ced-line-break"></div>
										  <div class="ced-info-data-view">
											<p>
											  <b>Adult Content </b>: False
											</p>
										  </div>
										</div>
										<div class="ced-info-data">
										  <h3>Customer Service Information</h3>
										  <p>No Data Found !</p>
										</div>
									  </div>
									  <div class="ced-create-action-part-one">
										<div class="ced-info-data">
										  <h3>Business Information</h3>
										  <div class="">
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
																<h3><b>Phone Number</b></h3>
																<div class="ced-tooltip"><p><?php esc_html_e( isset( $account_info_response['businessInformation']['phoneNumber'] ) ? $account_info_response['businessInformation']['phoneNumber'] : 'Not Available' ); ?></p>
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
																<h3><b>User-Email</b></h3>
																<p><?php esc_html_e( isset( $account_info_response['emailAddress'] ) ? $account_info_response['emailAddress'] : 'Not Available' ); ?></p>
															  </div>
															</div>
														  </div>
														</div>
														<div class="ced-card ced-card--hover ced-card-new">
														  <div class="ced-card__Body">
															<div class="ced__cardContent">
															  <div class="ced-flex--wrap">
																<h3><b>Address </b></h3>
																<p><?php esc_html_e( isset( $account_info_response['businessInformation']['address']['country'] ) ? $account_info_response['businessInformation']['address']['country'] : 'Not Available' ); ?></p>
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
  </div>
</div>
