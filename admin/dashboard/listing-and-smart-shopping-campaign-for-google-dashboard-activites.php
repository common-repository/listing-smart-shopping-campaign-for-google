<?php
$content_limit                                     = 50;
$activities_tab_content                            = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : '';
$ced_google_shopping_product_automate_setting_data = get_option( 'ced_google_shopping_product_automate_setting_data', true );
$enable_product_syncing                            = isset( $ced_google_shopping_product_automate_setting_data['product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['product_sync'] : '';
$enable_existing_product_syncing                   = isset( $ced_google_shopping_product_automate_setting_data['existing_product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['existing_product_sync'] : '';
if ( empty( $activities_tab_content ) ) {
	$activities_heading    = '<h3>Recent Activities </h3>';
	$view_all_button_class = 'ced_page_of_all_view';
	$content_limit         = 5;
}
global $wpdb;
$prefix                                  = $wpdb->prefix;
$table_name                              = $prefix . 'google_shopping_product_upload_status';
$ced_googleshopping_update_products_data = $wpdb->get_results( $wpdb->prepare( "SELECT * from {$wpdb->prefix}google_shopping_product_upload_status ORDER BY `id` DESC LIMIT %d", $content_limit ), 'ARRAY_A' );
$ced_total_activities_count              = 0;
$view_all_button_class                   = '';
$activities_heading                      = '<div class="ced-box-data-all ced-card--hover ced-all-activity">
<div class="ced-box-data-pc">
<img class="ced-activity-all-img" src="' . esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ) . '">
</div>
<div class="ced-box-para">
<h4>
<b>Last ' . count( $ced_googleshopping_update_products_data ) . ' activities</b>
</h4>
</div>
</div>';
?>
<div class="ced__Main">
	<div class="ced-Layout__Primary-Secondary ced-Layout">
		<div class="">
			<div class="ced-card ced-card--plain ">
				<div class="ced-card__Body">
					<div class="ced__cardContent">
						<div class="ced-pageHeader ">
							<div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
								<div class="ced-flex__item">
									<h3 class="ced__Heading">
										<h3 class="ced__Heading">Activities</h3>
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
													<div class="ced-log-table">
														<div class="ced__Subheading">
															<?php print_r( $activities_heading ); ?>
														</div>
														<?php
							// $ced_googleshopping_update_products_data = '';
														if ( ! empty( $ced_googleshopping_update_products_data ) ) {
															foreach ( $ced_googleshopping_update_products_data as $ced_googleshopping_update_products_data_key => $ced_googleshopping_update_products_data_val ) {
																$ced_total_activities_count            = ++$ced_total_activities_count;
																$updated_time                          = $ced_googleshopping_update_products_data_val['feed_time'];
																$feed_data                             = json_decode( $ced_googleshopping_update_products_data_val['feed_data'], 1 );
																$count_of_successfully_updated_product = 0;
																$count_of_failed_updated_product       = 0;
																$error_detils_html                     = '<div class="ced_details_view_products_error">';
																foreach ( $feed_data as $feed_data_key => $feed_data_value ) {
																	$woo_product_id    = isset( $feed_data_value['batchId'] ) ? $feed_data_value['batchId'] : '';
																	$_parent_product   = wc_get_product( $woo_product_id );
																	$parent_product_id = $_parent_product->get_parent_id();
																	if ( ! empty( $parent_product_id ) ) {
																		$woo_product_id = $parent_product_id;
																	}
																	$google_product_id = isset( $feed_data_value['product']['id'] ) ? $feed_data_value['product']['id'] : '';
																	if ( ! empty( $google_product_id ) ) {
																		++$count_of_successfully_updated_product;
																	} else {
																		$error_detils_html .= '<div class="ced_error_barch_id">Product ID - ' . esc_attr( $woo_product_id ) . '</div>';
																		$error_detils_html .= ' <div class="ced_error_reason"> Reason - ' . esc_attr( isset( $feed_data_value['errors']['message'] ) ? $feed_data_value['errors']['message'] : '' ) . '</div>';
																		++$count_of_failed_updated_product;
																	}
																}
																$error_detils_html .= '</div>';
																$err_class              = ( null != $count_of_failed_updated_product > 1 ) ? '-error' : '';
																$img_src                = ( null != $count_of_failed_updated_product > 1 ) ? CED_WGEI_URL . 'admin/images/warning.png' : CED_WGEI_URL . 'admin/images/check-new.png';
																?>

																<div class="ced-box-data<?php esc_attr_e( $err_class ); ?> ced-card--hover ">
																	<div class="ced-box-data-pc">
																		<img src="<?php esc_attr_e( $img_src ); ?>">
																	</div>
																	<div class="ced-box-para">
																		<h4>
																			<?php esc_html_e( $count_of_successfully_updated_product ); ?> Product(s) are successfully updated, <?php esc_html_e( $count_of_failed_updated_product ); ?> Product(s) failed during processing.
																		</h4>
																		<?php
																		if ( $count_of_failed_updated_product > 0 ) {
																			?>
																			<div class="ced_view_products_error">View Errors - </div>
																			<?php
																			print_r( $error_detils_html );
																		}
																		?>
																		<p class="ced-dat-tym"><?php esc_html_e( $updated_time ); ?></p>
																	</div>
																</div>
																<?php

									/*
									if($ced_total_activities_count == 4) {
									break;
								}*/
															}
														} else {
															?>
							<div class="ced-box-data-alt ced-card--hover">                     
								<div class="ced-box-data-pc">
									<img class="ced-activity-all-img" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
								</div>
								<div class="ced-box-para">
									<h4>
										<b>No any activity here to show -- </b>
									</h4>
								</div>
							</div>
							<?php
														}
														?>
						<div class="ced-box-button <?php esc_attr_e( $view_all_button_class ); ?>">
							<a href="<?php esc_html_e( admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-activities&tab=view_all' ); ?>">View All Activities</a>
						</div>
					</div>
					<!-- ending of Recent Activities - -->
					<!-- Starting of currently running status  -->
					<div class="ced-log-table">
						<div class="ced__Subheading">
							<h3>Currently Running Processes </h3>
						</div>
						<!-- <div class="ced-box-data-alt ced-card--hover"> -->
							<?php
							if ( ( 'off' == $enable_product_syncing || empty( $enable_product_syncing ) ) && ( 'off' == $enable_existing_product_syncing ) || empty( $enable_existing_product_syncing ) ) {
								?>
								<div class="ced-box-data-alt ced-card--hover">                     
									<div class="ced-box-data-pc">
										<img class="ced-activity-all-img" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
									</div>
									<div class="ced-box-para">
										<h4>
											<b>No Processes Running Currently</b>
										</h4>
									</div>
								</div>
								<?php
							} if ( 'on' == $enable_product_syncing ) {
								?>
								<div class="ced-box-data-alt ced-card--hover">
									<div class="ced-box-data-pc">
										<img class="ced-activity-all-img" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
									</div>
									<div class="ced-box-para">
										<h4>
											<b>Product Syncing is Enable here to upload the new products on GMC.</b>
										</h4>
									</div>
								</div>
								<?php
							} if ('on' == $enable_existing_product_syncing) {
								?>
								<div class="ced-box-data-alt ced-card--hover">
									<div class="ced-box-data-pc">
										<img class="ced-activity-all-img" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
									</div>
									<div class="ced-box-para">
										<h4>
											<b>Product Syncing is Enable here to upload the Existing products on GMC.</b>
										</h4>
									</div>
								</div>
								<?php
							}

							?>
						</div>
					</div>
				</div>
				<!---start all view part--->
				<!---end--->
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!--end-->
<!---start all view part--->
</div>
</div>
</div>
</div>
</div>
<!-- </div> -->
