<?php
$merchant_details      = get_option( 'ced_save_merchant_details', true );
$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';
global $wpdb;
$active_products_on_google_meta_key                = 'ced_product_updated_on_google_' . $connected_merchant_id;
$active_products_on_google                         = $wpdb->get_row( $wpdb->prepare( "SELECT COUNT(*) AS THE_COUNT FROM $wpdb->postmeta WHERE `meta_key` = %s", $active_products_on_google_meta_key ) );
$active_products_on_google                         = $active_products_on_google->THE_COUNT;
$count_all_products                                = wp_count_posts( 'product' )->publish;
$non_active_products_on_google                     = (int) $count_all_products - (int) $active_products_on_google;
$instock_count                                     = $wpdb->get_var(
	"
SELECT COUNT(p.ID)
FROM {$wpdb->prefix}posts as p
INNER JOIN {$wpdb->prefix}postmeta as pm ON p.ID = pm.post_id
WHERE p.post_type = 'product'
AND p.post_status = 'publish'
AND pm.meta_key = '_stock_status'
AND pm.meta_value = 'instock'
"
);
$out_of_stock_count                                = $wpdb->get_var(
	"
   SELECT COUNT(p.ID)
   FROM {$wpdb->prefix}posts as p
   INNER JOIN {$wpdb->prefix}postmeta as pm ON p.ID = pm.post_id
   WHERE p.post_type = 'product'
   AND p.post_status = 'publish'
   AND pm.meta_key = '_stock_status'
   AND pm.meta_value = 'outofstock'
"
);
$google_dash_current_user                          = wp_get_current_user();
$ced_google_shopping_product_automate_setting_data = get_option( 'ced_google_shopping_product_automate_setting_data', true );
$enable_product_syncing                            = isset( $ced_google_shopping_product_automate_setting_data['product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['product_sync'] : '';
$enable_existing_product_syncing                   = isset( $ced_google_shopping_product_automate_setting_data['existing_product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['existing_product_sync'] : '';
// print_r($ced_google_shopping_product_automate_setting_data);
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
									<div class="ced_google_heading_and_reset_wrapper">
										<h3 class="ced__Heading">
											<h3 class="ced__Heading">Welcome, <?php print_r( $google_dash_current_user->user_login ); ?></h3>
										</h3>
									</div>
							  </div>

							  
						   </div>
						</div>
						<div class="ced-flex   ced-flex--spacing-loose   ced-flex--wrap ced-flex--D25 ced-flex--T25 ced-flex--M50">
						   <div class="ced-flex__item">
							  <div style="position: relative;">
								 <div class="ced-card  card-quad">
									<div class="ced-card__Body">
									   <div class="ced__cardContent">
										  <h3 class="ced__Subheading"> Active Products </h3>
										  <div class="mt-10">

											 <h3 class="ced__Heading "><?php esc_html_e( $active_products_on_google ); ?></h3>
										  </div>
										 
									   </div>
									</div>
								 </div>
							  </div>
						   </div>
						   <div class="ced-flex__item">
							  <div style="position: relative;">
								 <div class="ced-card  card-quad">
									<div class="ced-card__Body">
									   <div class="ced__cardContent">
										  <h3 class="ced__text--neutral  ced__text--light"></h3>
										  <h3 class="ced__Subheading">Non Active Products</h3>
										  <div class="mt-10">
											 <h3 class="ced__Heading"><?php esc_html_e( $non_active_products_on_google ); ?></h3>
										  </div>
									   </div>
									</div>
								 </div>
							  </div>
						   </div>
						   <div class="ced-flex__item">
							  <div style="position: relative;">
								 <div class="ced-card  card-quad">
									<div class="ced-card__Body">
									   <div class="ced__cardContent">
										  <h3 class="ced__Subheading">Stock</h3>
										  <div class="mt-10">
											 <h3 class="ced__Heading"><?php esc_html_e( $instock_count ); ?></h3>
										  </div>
									   </div>
									</div>
								 </div>
							  </div>
						   </div>
						 <div class="ced-flex__item">
							  <div style="position: relative;">
								 <div class="ced-card  card-quad">
									<div class="ced-card__Body">
									   <div class="ced__cardContent">
										  <h3 class="ced__Subheading">Out of Stock</h3>
										  <div class="mt-10">
											 <h3 class="ced__Heading"><?php esc_html_e( $out_of_stock_count ); ?></h3>
										  </div>
									   </div>
									</div>
								 </div>
							  </div>
						   </div>
						</div>

						<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
						   <div class="ced-flex__item">
							  <div class="mt-30">
								 <div class="ced-card  ">
									<div class="ced-card__Body">
									   <div class="ced__cardContent">
										  <h3 class="ced__Subheading">Products</h3>
										  <div class="ced-flex ced-flex--wrap">
											 <div class="ced-flex__item ced-flex__item--M100 ced-flex__item--T75 ced-flex__item--D75">
												<span class="abc-donut">
												   <div class="mt-30  chartheightforcard" style="text-align: center;">
													  <div class="ced-State--Empty">
														 <div class="ced-flex ced-flex--align-center ced-flex--distribute-center ced-flex--spacing-Extraloose ced-flex--vertical  ced-flex--wrap">
															<div class="ced-flex__item">
															   <img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/box.png' ); ?>" style="width:100px;">
															</div>
															
														 </div>
													  </div>
												   </div>
												</span>
											 </div>
											 <div class="ced-flex__item ced-flex__item--M100 ced-flex__item--T25 ced-flex__item--D25">
												<div class="ced-card card-bglinkwater ">
												   <div class="ced-card__Body">
													  <div class="ced__cardContent">
														 <div class="ced-flex    ced-flex--vertical  ced-flex--wrap">
															<div class="ced-flex__item">
															   <div style="height: 60px;"></div>
															</div>
															<div class="ced-flex__item">
															   <h3 class="ced__Heading"><?php esc_html_e( $count_all_products ); ?></h3>
															</div>
															<div class="ced-flex__item">
															   <h3 class="ced__text--neutral">Total Products</h3>
															</div>
															<div class="ced-flex__item">
															   <div class="mt-30"><button class="ced-btn ced-btn--Outlined ced-btnExtraNarrow">
																  <a target="_blank" href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-products' ); ?>"><span class="ced__text">Manage Products</span></a></button></div>
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
						<div class="ced-flex__item ced_reset_button_layout_wrapper">
										<div class="ced_google_heading_and_reset_wrapper">
											<div class="ced_google_reset_connected_account">Reset Setting</div>
											<span class="ced_google_loader"><img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
										</div>
								  </div>
						

					 </div>
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
								 <div class="mt-20 mb-30">
									<div class="ced-flex ced-flex--spacing-Extraloose   ced-flex--wrap">
									   <div class="ced-flex__item">
										  <h3 class="ced__Heading--Medium">Notifications</h3>
									   </div>
									   <!-- <div class="ced-flex__item"><button class="ced-btn ced-btn--Primary    ced-btnExtraNarrow">
										  <a href="notification.html"><span class="ced__text">View All Notifications</span></a>
										  </button></div> -->
									</div>
								 </div>
								 <h3 class="ced__text--neutral  ced__text--light">RECENT ACTIVITIES</h3>
								 <?php
									global $wpdb;
									$prefix                                  = $wpdb->prefix;
									$table_name                              = $prefix . 'google_shopping_product_upload_status';
									$ced_googleshopping_update_products_data = $wpdb->get_results( $wpdb->prepare( "SELECT * from {$wpdb->prefix}google_shopping_product_upload_status ORDER BY `id` DESC LIMIT %d", 7 ), 'ARRAY_A' );
									foreach ( $ced_googleshopping_update_products_data as $ced_googleshopping_update_products_data_key => $ced_googleshopping_update_products_data_val ) {
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
										?>
			<div class="ced-card ced-card--hover ">
				<div class="ced-card__Body">
				   <div class="ced__cardContent">
					  <div class="ced-flex  ced-flex--distribute-center    ced-flex--wrap">
						 <div class="ced-flex__item ced-flex__item--M25 ced-flex__item--T25 "><img class="ced-notify-icon" src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/check-new.png' ); ?>" style="padding-left: 20%;"></div>
						 <div class="ced-flex__item ced-flex__item--M75 ced-flex__item--T75 ced-flex__item--D75">
							<div class="ced-flex ced-flex--vertical  ced-flex--wrap">
							   <div class="ced-flex__item">
								  <h3 class="ced__text"><?php esc_html_e( $count_of_successfully_updated_product ); ?> Product(s) are successfully updated, <?php esc_html_e( $count_of_failed_updated_product ); ?> Product(s) failed during processing.</h3>
							   </div>
										<?php
										if ( $count_of_failed_updated_product > 0 ) {
											?>
								   <div class="ced_view_products_error">View Errors - </div>
											<?php
											print_r( $error_detils_html );
										}
										?>
							   <div class="ced-flex__item">
								  <h3 class="ced__text--small  ced__text--light"><?php esc_html_e( $updated_time ); ?></h3>
							   </div>
							</div>
						 </div>
					  </div>
				   </div>
				</div>
			 </div>
										<?php
									}
									?>
								 
							  </div>
						   </div>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
