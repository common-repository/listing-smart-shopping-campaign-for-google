<?php
$current_page_action  = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
$current_profile_name = isset( $_GET['profile_name'] ) ? sanitize_text_field( $_GET['profile_name'] ) : '';
// $current_profile_name = isset($_GET['profile_name'])? $_GET['profile_name'] : '';
?>
<div class="ced__Main">
	<div class=" ced-Layout">
		<div class="">
			<div class="ced-card ced-card--plain ">
				<div class="ced-card__Body">
					<?php
					if ( '' == $current_page_action && '' == $current_profile_name ) {
						$woo_store_categories = get_terms( 'product_cat' );
						$profileData          = get_option( 'ced_google_shopping_profiles' );
						?>
						<!---cardcontent-->
						<div class="ced__cardContent">
							<div class="ced-pageHeader">
								<div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
									<div class="ced-flex__item">
										<h3 class="ced__Heading">
											<h3 class="ced__Heading">Custom profiles</h3>
										</h3>
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
														<div class="ced-log-table">
															<div class="ced-box-data-alt">
																<div class="ced-box-data-pc">
																	<img class="ced-activity-all-img" src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
																</div>
																<div class="ced-box-para-alt">
																	<h3>
																		<b>About</b>
																	</h3>
																	<p>You can create your Custom Profiles from here. When you create a new profile, you will have an option to filter products which you want to keep in this Profile and you can choose different settings for them. </p>
																</div>
																<div class="ced_create_google_shopping"><a href="<?php esc_html_e( admin_url() . '/admin.php?page=ced_google&section=dashboard&content=dash-profile&action=profile_creation' ); ?>"><button class="ced-create-continue">Create Profile</button></a></div>

															</div>
														</div>
													</div>
													<!---start all view part--->
													<div class="ced-flex ced-flex--wrap">
														<div class="ced-log-table">
															<div class="">
																<div class="ced-account-wrap">
																	<div class="ced-table-data-wrap" style="overflow: auto;">
																		<table class="ced-marchant-table-data">
																			<?php

																			if ( ! empty( $profileData ) ) {
																				$profileData = json_decode( $profileData, 1 );

																				?>
																				<tbody>
																					<tr class="ced-table-head">
																						<td>Actions</td>
																						<td>Name</td>
																						<td>Query</td>
																						<!-- <td>Product Count</td> -->
																					</tr>
																					<?php
																					foreach ( $profileData as $profileData_key => $profileData_val ) {
																						?>
																						<tr class="ced-data-content">
																							<td class="ced-actions-icons">
																								<p>
																									<a href="#" class="ced_gs_delete_profile" data-profile_name="<?php esc_attr_e( $profileData_key ); ?>">
																										<img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/trash.png' ); ?>">
																									</a>
																								</p>
																								<p>
																									<a href="<?php esc_html_e( admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-profile&action=view_profile&profile_name=' . $profileData_key . '' ); ?>"  class="ced_gs_view_profile" data-profile_name="<?php esc_html_e( $profileData_key ); ?>">
																										<img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/eye.png' ); ?>">
																									</a>
																								</p>
																								<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
																							</td>
																							<td>
																								<p><?php esc_html_e( $profileData_key ); ?></p>
																							</td>
																							<td>
																								<p>
																									<div class="ced_profile_slected_category_view_wrapper">
																										<?php
																										$selected_category = isset( $profileData_val['ced_gs_profile_selected_category'] ) ? $profileData_val['ced_gs_profile_selected_category'] : '';
																										if ( ! empty( $selected_category ) ) {
																											foreach ( $woo_store_categories as $key => $value ) {
																												if ( in_array( $value->term_id, $selected_category ) ) {
																													?>
																													<div class="ced_profile_slected_category_view"><?php esc_html_e( strtoupper( $value->name ) ); ?></div>  
																													<?php
																												}
																											}
																										}
																										?>
																									</p>
																								</td>
											  <!-- <td>
												<p>
												  <a href="">Get Count</a>
												</p>
											</td> -->
										</tr>
																						<?php
																					}
																			} else {
																				?>
									<div class="ced-box-para">
										<h3>
											<b>No Profiles</b>
										</h3>
										<p>You can create your Custom Profiles from here. When you create a new profile, you will have an option to filter products which you want to keep in this Profile and you can choose different settings for them. </p>
									</div>

																				<?php
																			}
																			?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!---end--->
</div>
</div>
</div>
</div>
</div>
</div>
<!--end-->

						<?php

					} if ( 'profile_creation' == $current_page_action && empty( $current_profile_name ) ) {
						?>
	<div class="ced__cardContent">
		<div class="ced-pageHeader ">
			<div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
				<div class="ced-flex__item">
					<h3 class="ced__Heading">
						<h3 class="ced__Heading">Profile Details</h3>
					</h3>
				</div>
			</div>
		</div>
<!--          <div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
		  <div class="ced-flex__item">
			<div class="mt-30">
			   <div class="">
			  <div class="ced-card  ">
				<div class="ced-card__Body">
					<div class="ced__cardContent"> -->
						<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100">
							<div class="ced-flex__item">
								<div class="ced-profile-view">
									<div class="ced-card  ">
										<div class="ced-card__Body">
											<div class="ced__cardContent">
												<div class="ced-flex ced-flex--wrap">
													<div class="ced-log-table">
														<div class="ced-box-data-alt">
															<div class="ced-box-data-pc">
																<img class="ced-activity-all-img" src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
															</div>
															<div class="ced-box-para">
																<h3>
																	<b>General Info</b>
																</h3>
																<p>Import your Woocommerce products to the app before creating a profile. To import products from Woocommerce , go to <a href="">Products Section.</a>
																</p>
															</div>
														</div>
														<div class="ced-form-wrap">
															<h2>Profile Name</h2>
															<input type="text" name="" class="ced-form-data ced_google_shopping_profile_name">
															<p>required*</p>
														</div>
														<div class="ced_profile_creation_error"></div>
														<div class="ced-btn-right ced_create_and_save_profile">
															<button class="ced-create-continue">Save and Next</button>
															<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>        
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


						<?php
					} if ( 'profile_creation' == $current_page_action && '' !== $current_profile_name ) {
						require_once ABSPATH . 'wp-admin/includes/translation-install.php';
						$wc_countries          = new WC_Countries();
						$woo_countries         = $wc_countries->get_countries();
						$currency_code_options = get_woocommerce_currencies();
						$woo_store_categories  = get_terms( 'product_cat' );
						$updated_category      = get_option( 'ced_google_shopping_mapped_categories', '' );
						$updated_category      = json_decode( $updated_category, 1 );
						foreach ( $woo_store_categories as $woo_store_categories_key => $woo_store_categories_val ) {
							if ( ! empty( $updated_category ) && in_array( $woo_store_categories_val->term_id, $updated_category ) ) {
								unset( $woo_store_categories[ $woo_store_categories_key ] );
							}
						}
						foreach ( $currency_code_options as $code => $name ) {
							$currency_code_options[ $code ] = $name . ' (' . get_woocommerce_currency_symbol( $code ) . ')';
						}
						$google_supported_langaue  = file( CED_WGEI_DIRPATH . 'admin/language-codes_json.json' );
						$woo_languages             = ( json_decode( $google_supported_langaue[0], 1 ) );
						$woo_currencies            = $currency_code_options;
						$age_group                 = array(
							'newborn' => 'New Born (Upto 3 months old)',
							'infant'  => 'Infant (3 to 12 months',
							'toddler' => 'Toddler (1-5 years)',
							'kids'    => 'Kids (5-13 years)',
							'adult'   => 'Adults',
						);
						$gender                    = array(
							'Male'   => 'Male',
							'Female' => 'Female',
							'Unisex' => 'Unisex',
						);
						$google_supported_taxonomy = file( CED_WGEI_DIRPATH . 'admin/taxonomy.txt' );
						$current_profile_name      = isset( $_GET['profile_name'] ) ? sanitize_text_field( $_GET['profile_name'] ) : '';
						$ced_configuration_details = get_option( 'ced_configuration_details', true );
						$attributes                = wc_get_attribute_taxonomies();
						$attrOptions               = array();
						$addedMetaKeys             = get_option( 'CedUmbProfileSelectedMetaKeys', false );
						$selectDropdownHTML        = '';

						global $wpdb;
						$results = $wpdb->get_results( "SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta", 'ARRAY_A' );
						foreach ( $results as $key => $meta_key ) {
							$post_meta_keys[] = $meta_key['meta_key'];
						}



						if ( $addedMetaKeys && count( $addedMetaKeys ) > 0 ) {
							foreach ( $addedMetaKeys as $metaKey ) {
								$attrOptions[ $metaKey ] = $metaKey;
							}
						}
						if ( ! empty( $attributes ) ) {
							foreach ( $attributes as $attributesObject ) {
								$attrOptions[ 'umb_pattr_' . $attributesObject->attribute_name ] = $attributesObject->attribute_label;
							}
						}
						?>

					<div class="ced__cardContent">
						<div class="ced-pageHeader ">
							<div class="ced-flex  ced-flex--distribute-spaceBetween ced-flex--spacing-loose   ced-flex--wrap">
								<div class="ced-flex__item">
									<h3 class="ced__Heading">
										<h3 class="ced__Heading">Fill Configuration And Filter Products</h3>
									</h3>
								</div>
							</div>
						</div>
						<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100 ced-filter-alt">
							<div class="ced-flex__item">
								<div class="ced-card">
									<div class="ced-card__Body">
										<div class="ced__cardContent">
											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input type="hidden" name="" class="ced_gs_profile_name" value="<?php esc_html_e( $current_profile_name ); ?>">
															<input id="ced-tab-10" type="checkbox" checked>
															<label for="ced-tab-10" class="ced-box-shw">Basic configuration (Required)</label>
															<div class="content ced">
																<div class="ced-create-action-wrap">
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">Target Country</h3>
																		<select class="ced-setting-select ced_gs_profile_country ced_profile_data_required" id="ced_gs_profile_country">
																			<option value="">Select Target Country </option>
																			<?php
																			$selected_country = isset( $ced_configuration_details['ced_selected_config_country'] ) ? $ced_configuration_details['ced_selected_config_country'] : '';
																			foreach ( $woo_countries as $key => $countries ) {
																				$selected = '';
																				if ( ! empty( $selected_country ) && $key == $selected_country ) {
																					$selected = 'selected';
																				}
																				echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
																			}
																			?>
																		</select>
																	</div>
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">Content Language</h3>
																		<select class="ced-setting-select ced_gs_profile_language ced_profile_data_required" id="ced_gs_profile_language">
																			<option value="">Select Content Language </option>
																			<?php
																			$selected_lang = isset( $ced_configuration_details['ced_selected_config_language'] ) ? $ced_configuration_details['ced_selected_config_language'] : '';
																			foreach ( $woo_languages as $key => $language ) {
																				$selected = '';
																				if ( ! empty( $selected_lang ) && $language['Language code'] == $selected_lang ) {
																					$selected = 'selected';
																				}
																				echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $language['Language code'] ) . '"><p><span>' . esc_attr( $language['Language name'] ) . '</span></p> </option>';
																			}
																			?>
																		</select>
																	</div>
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">Currency</h3>
																		<select class="ced-setting-select ced_gs_profile_currency ced_profile_data_required" id="ced_gs_profile_currency">
																			<option value="">Select Currency </option>
																			<?php
																			$selected_currency = isset( $ced_configuration_details['ced_selected_config_currency'] ) ? $ced_configuration_details['ced_selected_config_currency'] : '';
																			foreach ( $woo_currencies as $key => $currencies ) {
																				$selected = '';
																				if ( ! empty( $selected_currency ) && $key == $selected_currency ) {
																					$selected = 'selected';
																				}
																				echo '<option ' . esc_attr( $selected ) . '  value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';

																			}
																			?>
																		</select>
																	</div>
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">Included Destination</h3>
																		<div class="ced-unlist-items">
																			<select multiple class="ced-setting-select ced_profile_data_required ced_gs_profile_include_destination" id="ced_selected_include_destination">
																				<!-- <option value="" disabled selected hidden>Select Include Destination</option> -->
																				<?php
																				$destination          = array(
																					'Surfaces across Google' => 'Surfaces across Google',
																					'Shopping'    => 'Shopping',
																					'Display Ads' => 'Display Ads',
																					'Shopping Actions' => 'Shopping Actions',
																				);
																				$incliude_destinaiton = isset( $ced_configuration_details['ced_selected_include_destination'] ) ? $ced_configuration_details['ced_selected_include_destination'] : '';
																				foreach ( $destination as $key => $destination ) {

																					if ( is_array( $incliude_destinaiton ) && in_array( $key, $incliude_destinaiton ) ) {
																						echo '<option selected value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $destination ) . '</span></p> </option>';
																					} else {
																						echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $destination ) . '</span></p> </option>';

																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="ced-create-action-wrap">
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">Brand Mapping </h3>
																		<div class="ced-unlist-items">
																			<div class="ced_brand_mpn_textbox">
																				<input type="text" name="ced_google_shopping_brand" id="ced_google_shopping_brand" class="ced-setting-select" value="<?php esc_html_e( isset( $ced_configuration_details['ced_selected_brand_input_filed_value'] ) ? $ced_configuration_details['ced_selected_brand_input_filed_value'] : '' ); ?>">
																			</div>

																				<?php
																				$fieldID             = 'google_brand';
																				$selectId            = $fieldID . '_attibuteMeta';
																				$selectDropdownHTML  = '';
																				$selectDropdownHTML .= '<select class="ced-setting-select" id="' . $selectId . '" name="' . $selectId . '">';
																				$selectDropdownHTML .= '<option value="null"> -- select -- </option>';
																				if ( is_array( $attrOptions ) ) {
																					$selectDropdownHTML .= '<optgroup label="Global Attributes">';
																					foreach ( $attrOptions as $attrKey => $attrName ) :
																						$selected     = '';
																						$selected_val = isset( $ced_configuration_details['ced_selected_brand_dropdown_value'] ) ? $ced_configuration_details['ced_selected_brand_dropdown_value'] : '';
																						if ( ! empty( $selected_val ) && $attrKey == $selected_val ) {
																							$selected = 'selected';
																						}
																						$selectDropdownHTML .= '<option ' . $selected . ' value="' . $attrKey . '">' . $attrName . '</option>';
																					endforeach;
																				}

																				if ( ! empty( $post_meta_keys ) ) {
																					$post_meta_keys      = array_unique( $post_meta_keys );
																					$selectDropdownHTML .= '<optgroup label="Custom Fields">';
																					foreach ( $post_meta_keys as $key => $p_meta_key ) {
																						$selected     = '';
																						$selected_val = isset( $ced_configuration_details['ced_selected_brand_dropdown_value'] ) ? $ced_configuration_details['ced_selected_brand_dropdown_value'] : '';
																						if ( ! empty( $selected_val ) && $p_meta_key == $selected_val ) {
																							$selected = 'selected';
																						}
																						$selectDropdownHTML .= '<option ' . $selected . ' value="' . $p_meta_key . '">' . $p_meta_key . '</option>';
																					}
																				}
																				$selectDropdownHTML .= '</select>';
																				print_r( $selectDropdownHTML );
																				?>
																		</div>
																	</div>	
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">MPN Mapping</h3>
																		<div class="ced-unlist-items">
																				<?php
																				$fieldID             = 'google_mpn';
																				$selectId            = $fieldID . '_attibuteMeta';
																				$selectDropdownHTML  = '';
																				$selectDropdownHTML .= '<select class="ced-setting-select" id="' . $selectId . '" name="' . $selectId . '">';
																				$selectDropdownHTML .= '<option value="null"> -- select -- </option>';
																				if ( is_array( $attrOptions ) && ! empty( $attrOptions ) ) {
																					$selectDropdownHTML .= '<optgroup label="Global Attributes">';
																					foreach ( $attrOptions as $attrKey => $attrName ) :
																						$selected     = '';
																						$selected_val = isset( $ced_configuration_details['ced_selected_mpn_dropdown_value'] ) ? $ced_configuration_details['ced_selected_mpn_dropdown_value'] : '';
																						if ( ! empty( $selected_val ) && $attrKey == $selected_val ) {
																							$selected = 'selected';
																						} else {
																							$selected = '';
																						}
																						$selectDropdownHTML .= '<option ' . $selected . ' value="' . $attrKey . '">' . $attrName . '</option>';
																					endforeach;
																				}

																				if ( ! empty( $post_meta_keys ) ) {
																					$post_meta_keys      = array_unique( $post_meta_keys );
																					$selectDropdownHTML .= '<optgroup label="Custom Fields">';
																					foreach ( $post_meta_keys as $key => $p_meta_key ) {
																						$selected     = '';
																						$selected_val = isset( $ced_configuration_details['ced_selected_mpn_dropdown_value'] ) ? $ced_configuration_details['ced_selected_mpn_dropdown_value'] : '';
																						if ( ! empty( $selected_val ) && $p_meta_key == $selected_val ) {
																							$selected = 'selected';
																						} else {
																							$selected = '';
																						}
																						$selectDropdownHTML .= '<option ' . $selected . ' value="' . $p_meta_key . '">' . $p_meta_key . '</option>';
																					}
																				}
																				$selectDropdownHTML .= '</select>';
																				print_r( $selectDropdownHTML );
																				?>
																		</div>
																	</div>																
																	<div class="ced-wrap-quater">
																		<h3 class="ced-quater-title">GTIN Mapping</h3>
																		<div class="ced-unlist-items">
																				<?php
																				$fieldID             = 'google_gtin';
																				$selectId            = $fieldID . '_attibuteMeta';
																				$selectDropdownHTML  = '';
																				$selectDropdownHTML .= '<select class="ced-setting-select" id="' . $selectId . '" name="' . $selectId . '">';
																				$selectDropdownHTML .= '<option value="null"> -- select -- </option>';
																				if ( is_array( $attrOptions ) && ! empty( $attrOptions ) ) {
																					$selectDropdownHTML .= '<optgroup label="Global Attributes">';
																					foreach ( $attrOptions as $attrKey => $attrName ) :
																						$selected     = '';
																						$selected_val = isset( $ced_configuration_details['ced_selected_gtin_dropdown_value'] ) ? $ced_configuration_details['ced_selected_gtin_dropdown_value'] : '';
																						if ( ! empty( $selected_val ) && $attrKey == $selected_val ) {
																							$selected = 'selected';
																						} else {
																							$selected = '';
																						}
																						$selectDropdownHTML .= '<option ' . $selected . ' value="' . $attrKey . '">' . $attrName . '</option>';
																					endforeach;
																				}

																				if ( ! empty( $post_meta_keys ) ) {
																					$post_meta_keys      = array_unique( $post_meta_keys );
																					$selectDropdownHTML .= '<optgroup label="Custom Fields">';
																					foreach ( $post_meta_keys as $key => $p_meta_key ) {
																						$selected     = '';
																						$selected_val = isset( $ced_configuration_details['ced_selected_gtin_dropdown_value'] ) ? $ced_configuration_details['ced_selected_gtin_dropdown_value'] : '';
																						if ( ! empty( $selected_val ) && $p_meta_key == $selected_val ) {
																							$selected = 'selected';
																						} else {
																							$selected = '';
																						}
																						$selectDropdownHTML .= '<option ' . $selected . ' value="' . $p_meta_key . '">' . $p_meta_key . '</option>';
																					}
																				}
																				$selectDropdownHTML .= '</select>';
																				print_r( $selectDropdownHTML );
																				?>
																		</div>
																	</div>
																	<div class="ced-wrap-quater"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input id="ced-tab-11" type="checkbox" checked>
															<label for="ced-tab-11" class="ced-box-shw">Filter Products (Required)</label>
															<div class="content">
																<div class="">
																	<div class="ced-view-wrapper">
																		<div class="">
																			<div class="ced-box-data-alt">
																				<div class="ced-box-data-pc">
																					<img class="ced-activity-all-img" src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
																				</div>
																				<div class="ced-box-para">
																					<h3>
																						<b>Note</b>
																					</h3>
																					<p>Select Products Categories from here - </p>
																					
																				</div>
																			</div>
																		</div>
																		<div class="">
																			<div class="ced-data-performance-wrap">
																				<select class="ced-data-selt ced_cat_select select2 ced_profile_data_required ced_gs_profile_selected_category" id="ced_gs_profile_selected_category" name="_ced_cat_select" multiple='multiple'>
																					<?php
																					foreach ( $woo_store_categories as $key => $value ) {
																						?>

																						<option value="<?php esc_html_e( $value->term_id ); ?>"><?php esc_html_e( strtoupper( $value->name ) ); ?></option>   
																						<?php

																					}
																					?>
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
											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input id="ced-tab-12" type="checkbox" checked>
															<label for="ced-tab-12" class="ced-box-shw">Categorywise configuration (Required)</label>
															<div class="content">
																<div class="ced-create-action-wrap">
																	<div class="ced-create-action-part-one">
																		<p>Age Group</p>
																		<select class="ced-setting-select ced_profile_data_required ced_gs_profile_agegroup" id="ced_gs_profile_agegroup">
																			<option value="" disabled selected hidden>Select Age Group </option>
																				<?php
																				$selected_age_group = isset( $ced_configuration_details['ced_selected_config_agegroup'] ) ? $ced_configuration_details['ced_selected_config_agegroup'] : '';
																				foreach ( $age_group as $key => $age_group ) {
																					$selected = '';
																					if ( ! empty( $selected_age_group ) && $key == $selected_age_group ) {
																						$selected = 'selected';
																					}
																					echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
																				}
																				?>
																		</select>
																	</div>
																	<div class="ced-create-action-part-one">
																		<p>Gender</p>
																		<select class="ced-setting-select ced_profile_data_required ced_gs_profile_gender" id="ced_gs_profile_gender">
																			<option value="">Select Gender </option>
																				<?php
																				$selected_gender = isset( $ced_configuration_details['ced_selected_config_gender'] ) ? $ced_configuration_details['ced_selected_config_gender'] : '';
																				foreach ( $gender as $key => $gender ) {
																					$selected = '';
																					if ( ! empty( $selected_gender ) && $key == $selected_gender ) {
																						$selected = 'selected';
																					}
																					echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
																				}
																				?>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input id="ced-tab-13" type="checkbox">
															<label for="ced-tab-13" class="ced-box-shw">Product configuration (Optional)</label>
															<div class="content">
																<div class="ced-create-action-wrap">
																	<div class="ced-data-half">
																		<p>Promotions</p>
																		<select id="ced_gs_profile_promition_val" class="ced_google_shopping_profile_promition ced_gs_profile_promition_val"><option value="" disabled="">Select Promotions</option><option value="false">Disable</option><option value="true">Enable</option></select>
																	</div>
																	<div class="ced-data-half">
																		<p>Item Group Id</p>
																		<select class="ced-select-wrap ced_gs_profile_itemGroupId_val">
																			<option value="" disabled="">Select Item Group Id</option><option value="set">Send</option><option value="unset">Do Not Send</option>
																		</select>
																	</div>
																	<div class="ced-data-half">
																		<p>Adult</p>
																		<select class="ced-select-wrap ced_gs_profile_isAdult_val">
																			<option value="" disabled="">Select Adult</option><option value="yes">Yes</option><option value="no">No</option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input id="ced-tab-14" type="checkbox">
															<label for="ced-tab-14" class="ced-box-shw">Inventory configuration (Optional)</label>
															<div class="content">
																<div class="ced-create-action-wrap">
																	<div class="ced-create-action-part-one">
																		<p>Fixed Inventory</p>
																		<input type="text" name="ced_gs_fixed_inventory" class="ced_gs_profile_fixed_inv_val" name="ced_gs_fixed_inventory">
																	</div>
																	<div class="ced-create-action-part-one">
																		<p>Threshold Inventory</p>
																		<input type="text" name="ced_gs_fixed_inventory" class="ced_gs_profile_threshold_inv_val" name="ced_gs_fixed_threshold">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input id="ced-tab-15" type="checkbox">
															<label for="ced-tab-15" class="ced-box-shw">Google Category (Optional)</label>
															<div class="content">
																<div class="ced-table-data-wrap">
																	<div class="ced-update-map-wrap">
																		<div class="ced-alt-wrap">
																			<div class="">
																				<div class="ced-box-data-alt">
																					<div class="ced-box-data-pc">
																						<img class="ced-activity-all-img" src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
																					</div>
																					<div class="ced-box-para">
																						<h3>
																							<b>Selected Google category</b>
																						</h3>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="ced-update-map-wrap">
																		<div class="ced-alt-wrap">
																			<select class="ced-select-wrap ced_gs_profile_google_taxonomy_val">
																				<option value="">Select Google Category</option>
																				<?php
																				// print_r($google_supported_taxonomy);
																				foreach ( $google_supported_taxonomy as $google_supported_taxonomy_key => $google_supported_taxonomy_val ) {
																					echo '<option value="' . esc_attr( $google_supported_taxonomy_val ) . '"><p><span>' . esc_attr( $google_supported_taxonomy_val ) . '</span></p> </option>';
																				}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="ced-flex ced-flex--wrap">
												<div class="ced-account-id-wrap ced-space-alt">
													<div class="ced-accordian">
														<div class="ced-tab">
															<input id="ced-tab-16" type="checkbox">
															<label for="ced-tab-16" class="ced-box-shw">Markup configuration (Optional)</label>
															<div class="content">
																<div class="ced-dat-alt">
																	<div class="ced-view-wrapper">
																		<div class="">
																			<div class="ced-box-data-alt">
																				<div class="ced-box-data-pc">
																					<img class="ced-activity-all-img" src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
																				</div>
																				<div class="ced-box-para">
																					<h3>
																						<b>Markup Feature</b>
																					</h3>
																					<ol>
																						<li>You can use this feature if you want to send different price of product to Google, than what you have in Woocommerce,</li>
																						<li>Select flow of Markup (Increase or Decrease price). Then select type by which you want to change, i.e., by Fixed price or by percentage. Then in value enter the value by which you want to change the price</li>
																						<li> If you do not want to change the price then make no changes in Markup Settings. For example: <ul>
																							<li>If you set - Markup Flow - Increase Price, Markup Type - Fixed, Markup Value - 10 Then if in Woocommerce your product price is 10$, then on Google it will be 20$.</li>
																							<li>If you set - Markup Flow - Increase Price, Markup Type - Percentage, Markup Value - 10 Then if in Woocommerce your product price is 10$, then on Google it will be 11$.</li>
																						</ul>
																					</li>
																				</ol>
																			</div>
																		</div>
																	</div>
																	<div class="ced-data-performance-wrap">
																		<div class="ced-data-half">
																			<h2>Markup Flow</h2>
																			<select name="" class="ced-form-data ced_gs_profile_repricer_flow_val">
																				<option value="">Select Markup Flow</option><option value="increment">Increase Price</option><option value="decrement">Decrease Price</option>
																			</select>
																		</div>
																		<div class="ced-data-half">
																			<h2>Markup Type</h2>
																			<select name="" class="ced-form-data ced_gs_profile_repricer_type_val">
																				<option value="">Select Markup Type</option><option value="fixed">Fixed</option><option value="percentage">Percentage</option>
																			</select>
																		</div>
																		<div class="ced-data-half">
																			<h2>Markup Value</h2>

																			<input type="text" name="" class="ced_gs_profile_repricer_val">

																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="ced-btn-right ced_gs_proffile_create_and_save">
											<button class="ced-create-continue">Save Profile </button>
											<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>                                                    
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
						<?php
					}  if ( 'view_profile' == $current_page_action && '' != $current_profile_name ) {
						// data that comes from db
						$profileData                                   = get_option( 'ced_google_shopping_profiles' );
						$profileData                                   = json_decode( $profileData, 1 );
						$current_profile_details                       = $profileData[ $current_profile_name ];
						$ced_current_gs_profile_country                = isset( $current_profile_details['ced_gs_profile_country'] ) ? $current_profile_details['ced_gs_profile_country'] : '';
						$ced_current_gs_profile_language               = isset( $current_profile_details['ced_gs_profile_language'] ) ? $current_profile_details['ced_gs_profile_language'] : '';
						$ced_current_gs_profile_currency               = isset( $current_profile_details['ced_gs_profile_currency'] ) ? $current_profile_details['ced_gs_profile_currency'] : '';
						$ced_current_gs_profile_include_destination    = isset( $current_profile_details['ced_gs_profile_include_destination'] ) ? $current_profile_details['ced_gs_profile_include_destination'] : '';
						$ced_current_gs_profile_selected_category      = isset( $current_profile_details['ced_gs_profile_selected_category'] ) ? $current_profile_details['ced_gs_profile_selected_category'] : '';
						$ced_current_gs_profile_agegroup               = isset( $current_profile_details['ced_gs_profile_agegroup'] ) ? $current_profile_details['ced_gs_profile_agegroup'] : '';
						$ced_current_gs_profile_gender                 = isset( $current_profile_details['ced_gs_profile_gender'] ) ? $current_profile_details['ced_gs_profile_gender'] : '';
						$ced_current_google_shopping_profile_promition = isset( $current_profile_details['ced_google_shopping_profile_promition'] ) ? $current_profile_details['ced_google_shopping_profile_promition'] : '';
						$ced_current_gs_profile_itemGroupId_val        = isset( $current_profile_details['ced_gs_profile_itemGroupId_val'] ) ? $current_profile_details['ced_gs_profile_itemGroupId_val'] : '';
						$ced_current_gs_profile_isAdult_val            = isset( $current_profile_details['ced_gs_profile_isAdult_val'] ) ? $current_profile_details['ced_gs_profile_isAdult_val'] : '';
						$ced_current_gs_profile_fixed_inv_val          = isset( $current_profile_details['ced_gs_profile_fixed_inv_val'] ) ? $current_profile_details['ced_gs_profile_fixed_inv_val'] : '';
						$ced_current_gs_profile_threshold_inv_val      = isset( $current_profile_details['ced_gs_profile_threshold_inv_val'] ) ? $current_profile_details['ced_gs_profile_threshold_inv_val'] : '';
						$ced_current_gs_profile_google_taxonomy_val    = isset( $current_profile_details['ced_gs_profile_google_taxonomy_val'] ) ? $current_profile_details['ced_gs_profile_google_taxonomy_val'] : '';
						$ced_current_gs_profile_repricer_flow_val      = isset( $current_profile_details['ced_gs_profile_repricer_flow_val'] ) ? $current_profile_details['ced_gs_profile_repricer_flow_val'] : '';
						$ced_current_gs_profile_repricer_type_val      = isset( $current_profile_details['ced_gs_profile_repricer_type_val'] ) ? $current_profile_details['ced_gs_profile_repricer_type_val'] : '';
						$ced_current_gs_profile_repricer_val           = isset( $current_profile_details['ced_gs_profile_repricer_val'] ) ? $current_profile_details['ced_gs_profile_repricer_val'] : '';
						$ced_gs_selected_brand_dropdown_value          = isset( $current_profile_details['ced_gs_selected_brand_dropdown_value'] ) ? $current_profile_details['ced_gs_selected_brand_dropdown_value'] : '';
						$ced_gs_selected_brand_input_filed_value       = isset( $current_profile_details['ced_gs_selected_brand_input_filed_value'] ) ? $current_profile_details['ced_gs_selected_brand_input_filed_value'] : '';
						$ced_gs_selected_mpn_dropdown_value            = isset( $current_profile_details['ced_gs_selected_mpn_dropdown_value'] ) ? $current_profile_details['ced_gs_selected_mpn_dropdown_value'] : '';
						$ced_gs_selected_gtin_dropdown_value           = isset( $current_profile_details['ced_gs_selected_gtin_dropdown_value'] ) ? $current_profile_details['ced_gs_selected_gtin_dropdown_value'] : '';

						// data required during creating profile
						require_once ABSPATH . 'wp-admin/includes/translation-install.php';
						$wc_countries          = new WC_Countries();
						$woo_countries         = $wc_countries->get_countries();
						$currency_code_options = get_woocommerce_currencies();
						$woo_store_categories  = get_terms( 'product_cat' );
						$updated_category      = get_option( 'ced_google_shopping_mapped_categories', '' );
						$updated_category      = json_decode( $updated_category, 1 );
						/*
						foreach($woo_store_categories as $woo_store_categories_key => $woo_store_categories_val) {
						 if ( in_array( $woo_store_categories_val->term_id, $updated_category ) ) {
						  unset($woo_store_categories[$woo_store_categories_key]);
						 }
						}*/
						foreach ( $currency_code_options as $code => $name ) {
							$currency_code_options[ $code ] = $name . ' (' . get_woocommerce_currency_symbol( $code ) . ')';
						}
						$google_supported_langaue  = file( CED_WGEI_DIRPATH . 'admin/language-codes_json.json' );
						$woo_languages             = ( json_decode( $google_supported_langaue[0], 1 ) );
						$woo_currencies            = $currency_code_options;
						$age_group                 = array(
							'newborn' => 'New Born (Upto 3 months old)',
							'infant'  => 'Infant (3 to 12 months',
							'toddler' => 'Toddler (1-5 years)',
							'kids'    => 'Kids (5-13 years)',
							'adult'   => 'Adults',
						);
						$gender                    = array(
							'Male'   => 'Male',
							'Female' => 'Female',
							'Unisex' => 'Unisex',
						);
						$google_supported_taxonomy = file( CED_WGEI_DIRPATH . 'admin/taxonomy.txt' );
						$google_supported_taxonomy = file( CED_WGEI_DIRPATH . 'admin/taxonomy.txt' );
						$current_profile_name      = isset( $_GET['profile_name'] ) ? sanitize_text_field( $_GET['profile_name'] ) : '';
						$ced_configuration_details = get_option( 'ced_configuration_details', true );
						$attributes                = wc_get_attribute_taxonomies();
						$attrOptions               = array();
						$addedMetaKeys             = get_option( 'CedUmbProfileSelectedMetaKeys', false );
						$selectDropdownHTML        = '';

						global $wpdb;
						$results = $wpdb->get_results( "SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta", 'ARRAY_A' );
						foreach ( $results as $key => $meta_key ) {
							$post_meta_keys[] = $meta_key['meta_key'];
						}



						if ( $addedMetaKeys && count( $addedMetaKeys ) > 0 ) {
							foreach ( $addedMetaKeys as $metaKey ) {
								$attrOptions[ $metaKey ] = $metaKey;
							}
						}
						if ( ! empty( $attributes ) ) {
							foreach ( $attributes as $attributesObject ) {
								$attrOptions[ 'umb_pattr_' . $attributesObject->attribute_name ] = $attributesObject->attribute_label;
							}
						}


						?>
						<!---start all view part--->
						<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100 ced_gs_dashboard_view_profile">
							<div class="ced-flex__item">
								<div class="">
									<div class="ced-card  ">
										<div class="ced-card__Body">
											<div class="ced__cardContent">
												<div class="ced-flex ced-flex--wrap">
													<div class="">
														<div class="">
															<div class="ced-account-wrap">
																<h3>PRODUCTS DETAILS</h3>
																<div class="ced-form-wrap">
																	<h2>Name</h2>
																	<input type="text" disabled name="" class="ced-form-data ced_gs_profile_name" value="<?php esc_html_e( empty( $current_profile_name ) ? '' : $current_profile_name ); ?>">
																</div>
																<div class="ced-form-wrap">
																	<h2>Filter Query</h2>
																	<div class="ced-query-edit-wrap">
																		<select disabled class="ced-data-selt ced_cat_select select2 ced_profile_data_required ced_gs_profile_selected_category" id="ced_cat_select" name="_ced_cat_select" multiple='multiple'>
																			<?php

																			foreach ( $woo_store_categories as $key => $value ) {
																				if ( in_array( $value->term_id, $ced_current_gs_profile_selected_category ) ) {
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
																		<button class="ced-create-continue ced_gs_profiled_edit_woo_taxonomy">Edit</button>
																	</div>
																</div>
																<div class="ced-form-wrap ced-update-map-wrap">
																	<div class="ced-data-half">
																		<h3 class="ced-quater-title">Brand Mapping </h3>
																		<div class="ced-unlist-items">
																			<div class="ced_brand_mpn_textbox">
																				<input type="text" name="ced_google_shopping_brand" id="ced_google_shopping_brand" value="<?php esc_html_e( empty( $ced_gs_selected_brand_input_filed_value ) ? $ced_configuration_details['ced_selected_brand_input_filed_value'] : $ced_gs_selected_brand_input_filed_value ); ?>">
																			</div>

																			<?php
																			$fieldID             = 'google_brand';
																			$selectId            = $fieldID . '_attibuteMeta';
																			$selectDropdownHTML  = '';
																			$selectDropdownHTML .= '<select id="' . $selectId . '" name="' . $selectId . '">';
																			$selectDropdownHTML .= '<option value="null"> -- select -- </option>';
																			if ( is_array( $attrOptions ) ) {
																				$selectDropdownHTML .= '<optgroup label="Global Attributes">';
																				foreach ( $attrOptions as $attrKey => $attrName ) :
																					$selected = '';
																					if ( empty( $ced_gs_selected_brand_dropdown_value ) ) {
																						$selected_val = isset( $ced_configuration_details['ced_selected_brand_dropdown_value'] ) ? $ced_configuration_details['ced_selected_brand_dropdown_value'] : '';
																					} else {
																						$selected_val = $ced_gs_selected_brand_dropdown_value;
																					}
																					if ( ! empty( $selected_val ) && $attrKey == $selected_val ) {
																						$selected = 'selected';
																					}
																					$selectDropdownHTML .= '<option ' . $selected . ' value="' . $attrKey . '">' . $attrName . '</option>';
																				endforeach;
																			}

																			if ( ! empty( $post_meta_keys ) ) {
																				$post_meta_keys      = array_unique( $post_meta_keys );
																				$selectDropdownHTML .= '<optgroup label="Custom Fields">';
																				foreach ( $post_meta_keys as $key => $p_meta_key ) {
																					$selected = '';
																					if ( empty( $ced_gs_selected_brand_dropdown_value ) ) {
																						$selected_val = isset( $ced_configuration_details['ced_selected_brand_dropdown_value'] ) ? $ced_configuration_details['ced_selected_brand_dropdown_value'] : '';
																					} else {
																						$selected_val = $ced_gs_selected_brand_dropdown_value;
																					}
																					if ( ! empty( $selected_val ) && $p_meta_key == $selected_val ) {
																						$selected = 'selected';
																					}
																					$selectDropdownHTML .= '<option ' . $selected . ' value="' . $p_meta_key . '">' . $p_meta_key . '</option>';
																				}
																			}
																			$selectDropdownHTML .= '</select>';
																			print_r( $selectDropdownHTML );
																			?>
																		</div>
																	</div>	
																	<div class="ced-data-half">
																		<h3 class="ced-quater-title">MPN Mapping</h3>
																		<div class="ced-unlist-items">
																			<?php
																			$fieldID             = 'google_mpn';
																			$selectId            = $fieldID . '_attibuteMeta';
																			$selectDropdownHTML  = '';
																			$selectDropdownHTML .= '<select id="' . $selectId . '" name="' . $selectId . '">';
																			$selectDropdownHTML .= '<option value="null"> -- select -- </option>';
																			if ( is_array( $attrOptions ) && ! empty( $attrOptions ) ) {
																				$selectDropdownHTML .= '<optgroup label="Global Attributes">';
																				foreach ( $attrOptions as $attrKey => $attrName ) :
																					$selected = '';
																					if ( empty( $ced_gs_selected_mpn_dropdown_value ) ) {
																						$selected_val = isset( $ced_configuration_details['ced_selected_mpn_dropdown_value'] ) ? $ced_configuration_details['ced_selected_mpn_dropdown_value'] : '';
																					} else {
																						$selected_val = $ced_gs_selected_mpn_dropdown_value;
																					}
																					if ( ! empty( $selected_val ) && $attrKey == $selected_val ) {
																						$selected = 'selected';
																					} else {
																						$selected = '';
																					}
																					$selectDropdownHTML .= '<option ' . $selected . ' value="' . $attrKey . '">' . $attrName . '</option>';
																				endforeach;
																			}

																			if ( ! empty( $post_meta_keys ) ) {
																				$post_meta_keys      = array_unique( $post_meta_keys );
																				$selectDropdownHTML .= '<optgroup label="Custom Fields">';
																				foreach ( $post_meta_keys as $key => $p_meta_key ) {
																					$selected = '';
																					if ( empty( $ced_gs_selected_mpn_dropdown_value ) ) {
																						$selected_val = isset( $ced_configuration_details['ced_selected_mpn_dropdown_value'] ) ? $ced_configuration_details['ced_selected_mpn_dropdown_value'] : '';
																					} else {
																						$selected_val = $ced_gs_selected_mpn_dropdown_value;
																					}
																					if ( ! empty( $selected_val ) && $p_meta_key == $selected_val ) {
																						$selected = 'selected';
																					} else {
																						$selected = '';
																					}
																					$selectDropdownHTML .= '<option ' . $selected . ' value="' . $p_meta_key . '">' . $p_meta_key . '</option>';
																				}
																			}
																			$selectDropdownHTML .= '</select>';
																			print_r( $selectDropdownHTML );
																			?>
																		</div>
																	</div>																
																	<div class="ced-data-half">
																		<h3 class="ced-quater-title">GTIN Mapping</h3>
																		<div class="ced-unlist-items">
																			<?php
																			$fieldID             = 'google_gtin';
																			$selectId            = $fieldID . '_attibuteMeta';
																			$selectDropdownHTML  = '';
																			$selectDropdownHTML .= '<select id="' . $selectId . '" name="' . $selectId . '">';
																			$selectDropdownHTML .= '<option value="null"> -- select -- </option>';
																			if ( is_array( $attrOptions ) && ! empty( $attrOptions ) ) {
																				$selectDropdownHTML .= '<optgroup label="Global Attributes">';
																				foreach ( $attrOptions as $attrKey => $attrName ) :
																					$selected = '';
																					if ( empty( $ced_gs_selected_gtin_dropdown_value ) ) {
																						$selected_val = isset( $ced_configuration_details['ced_selected_gtin_dropdown_value'] ) ? $ced_configuration_details['ced_selected_gtin_dropdown_value'] : '';
																					} else {
																						$selected_val = $ced_gs_selected_gtin_dropdown_value;
																					}
																					if ( ! empty( $selected_val ) && $attrKey == $selected_val ) {
																						$selected = 'selected';
																					} else {
																						$selected = '';
																					}
																					$selectDropdownHTML .= '<option ' . $selected . ' value="' . $attrKey . '">' . $attrName . '</option>';
																				endforeach;
																			}

																			if ( ! empty( $post_meta_keys ) ) {
																				$post_meta_keys      = array_unique( $post_meta_keys );
																				$selectDropdownHTML .= '<optgroup label="Custom Fields">';
																				foreach ( $post_meta_keys as $key => $p_meta_key ) {
																					$selected = '';
																					if ( empty( $ced_gs_selected_gtin_dropdown_value ) ) {
																						$selected_val = isset( $ced_configuration_details['ced_selected_gtin_dropdown_value'] ) ? $ced_configuration_details['ced_selected_gtin_dropdown_value'] : '';
																					} else {
																						$selected_val = $ced_gs_selected_gtin_dropdown_value;
																					}
																					if ( ! empty( $selected_val ) && $p_meta_key == $selected_val ) {
																						$selected = 'selected';
																					} else {
																						$selected = '';
																					}
																					$selectDropdownHTML .= '<option ' . $selected . ' value="' . $p_meta_key . '">' . $p_meta_key . '</option>';
																				}
																			}
																			$selectDropdownHTML .= '</select>';
																			print_r( $selectDropdownHTML );
																			?>
																		</div>
																	</div>
																</div>
															</div>
															<!---onclick open edit section-->
															
														</div>
														<div class="">
															<div class="ced-account-wrap">
																<h3>GOOGLE CATEGORY</h3>
																<div class="ced-table-data-wrap">
																	<div class="ced-update-map-wrap">
																		<div class="ced-alt-wrap">
																			<div class="">
																				<div class="ced-box-data-alt">
																					<div class="ced-box-data-pc">
																						<img class="ced-activity-all-img" src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/exclamation.png' ); ?>">
																					</div>
																					<div class="ced-box-para">
																						<h3>
																							<b>Google Category</b>
																						</h3>
																						<p><?php esc_attr_e( $ced_current_gs_profile_google_taxonomy_val ); ?></p>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="ced-update-map-wrap">
																		<div class="ced-alt-wrap">
																			<select class="ced-select-wrap ced_gs_profile_google_taxonomy_val" disabled>
																				<option value="">Select Google Category</option>
																				<?php

																				foreach ( $google_supported_taxonomy as $google_supported_taxonomy_key => $google_supported_taxonomy_val ) {
																					if ( $google_supported_taxonomy_val == $ced_current_gs_profile_google_taxonomy_val ) {
																						echo '<option selected value="' . esc_attr( $google_supported_taxonomy_val ) . '"><p><span>' . esc_attr( $google_supported_taxonomy_val ) . '</span></p> </option>';
																					} else {

																						echo '<option value="' . esc_attr( $google_supported_taxonomy_val ) . '"><p><span>' . esc_attr( $google_supported_taxonomy_val ) . '</span></p> </option>';
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="ced-btn-right">
																		<button class="ced-create-continue ced_gs_profiled_edit_google_taxonomy">Edit</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="">
															<div class="ced-account-wrap">
																<h3>GOOGLE CONFIGURATIONS</h3>
																<div class="content">
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-create-action-part-one">
																				<h2>Target Country</h2>
																				<select class="ced-setting-select ced_gs_profile_country ced_profile_data_required" id="ced_gs_profile_country">
																					<option value="">Select Target Country </option>
																					<?php
																					foreach ( $woo_countries as $key => $countries ) {
																						if ( ! empty( $ced_current_gs_profile_country ) && $key == $ced_current_gs_profile_country ) {
																							echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
																						} else {
																							echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
																						}
																					}
																					?>
																				</select>
																				<p>Product listings target country</p>
																			</div>
																			<div class="ced-create-action-part-one">
																				<h2>Content Language</h2>
																				<select class="ced-setting-select ced_gs_profile_language ced_profile_data_required" id="ced_selected_config_language">
																					<option value="">Select Content Language </option>
																					<?php
																					foreach ( $woo_languages as $key => $language ) {
																						if ( ! empty( $ced_current_gs_profile_language ) && $language['Language code'] == $ced_current_gs_profile_language ) {

																							echo '<option value="' . esc_attr( $language['Language code'] ) . '" selected><p><span>' . esc_attr( $language['Language name'] ) . '</span></p> </option>';
																						} else {

																							echo '<option value="' . esc_attr( $language['Language code'] ) . '"><p><span>' . esc_attr( $language['Language name'] ) . '</span></p> </option>';
																						}
																					}
																					?>
																				</select>
																				<p>Language of your products data</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-alt-wrap">
																				<h2>Currency</h2>
																				<select class="ced-setting-select  ced_gs_profile_currency ced_profile_data_required">
																					<option value="">Select Currency </option>
																					<?php
																					foreach ( $woo_currencies as $key => $currencies ) {

																						if ( ! empty( $ced_current_gs_profile_currency ) && $key == $ced_current_gs_profile_currency ) {

																							echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';
																						} else {

																							echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';
																						}
																					}
																					?>
																				</select>
																				<p>Currency of your products price</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-create-action-part-one">
																				<h2>Included Destination</h2>
																				<p>Destinations where you want to show your products</p>
																			</div>
																			<div class="ced-create-action-part-one">
																				<div class="ced-unlist-items">
																					<select disabled multiple class="ced-setting-select ced_profile_data_required ced_gs_profile_include_destination" id="ced_selected_include_destination">
																						<!-- <option value="" disabled selected hidden>Select Include Destination</option> -->
																						<?php
																						$destination          = array(
																							'Surfaces across Google' => 'Surfaces across Google',
																							'Shopping'    => 'Shopping',
																							'Display Ads' => 'Display Ads',
																							'Shopping Actions' => 'Shopping Actions',
																						);
																						$incliude_destinaiton = isset( $ced_configuration_details['ced_selected_include_destination'] ) ? $ced_configuration_details['ced_selected_include_destination'] : '';
																						foreach ( $destination as $key => $destination ) {

																							if ( is_array( $incliude_destinaiton ) && in_array( $key, $incliude_destinaiton ) ) {
																								echo '<option selected value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $destination ) . '</span></p> </option>';
																							} else {
																								echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $destination ) . '</span></p> </option>';

																							}
																						}
																						?>
																					</select>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-create-action-part-one">
																				<h2>Markup Flow</h2>
																						<?php
																						$repricier_flow = array(
																							'increment' => 'Increase Price',
																							'decrement' => 'Decrease Price',
																						);
																						?>
																				<select class="ced-setting-select ced_gs_profile_repricer_flow_val">
																					<option value="" disabled>Select Markup Flow</option>
																							<?php
																							foreach ( $repricier_flow as $key => $repricier_flow ) {
																								if ( ! empty( $ced_current_gs_profile_repricer_flow_val ) && $key == $ced_current_gs_profile_repricer_flow_val ) {

																									echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $repricier_flow ) . '</span></p> </option>';
																								} else {

																									echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $repricier_flow ) . '</span></p> </option>';
																								}
																							}
																							?>
																				</select>
																				<p>Increase or Decrease price of products</p>
																			</div>
																			<div class="ced-create-action-part-one">
																				<h2>Markup Type</h2>
																						<?php
																						$repricier_type = array(
																							'fixed'      => 'Fixed',
																							'percentage' => 'Percentage',
																						);
																						?>
																				<select class="ced-setting-select ced_gs_profile_repricer_type_val">
																					<option value="" disabled>Select Markup Type </option>
																							<?php
																							foreach ( $repricier_type as $key => $repricier_type ) {
																								if ( ! empty( $ced_current_gs_profile_repricer_type_val ) && $key == $ced_current_gs_profile_repricer_type_val ) {

																									echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $repricier_type ) . '</span></p> </option>';
																								} else {

																									echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $repricier_type ) . '</span></p> </option>';
																								}
																							}
																							?>
																				</select>
																				<p>Change in price would be by Fixed value or by percentage</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-alt-wrap">
																				<h2>Markup Value</h2>
																				<input type="text" name="" value="<?php esc_html_e( empty( $ced_current_gs_profile_repricer_val ) ? '' : $ced_current_gs_profile_repricer_val ); ?>" class="ced_gs_profile_repricer_val">
																				<p>Value or percentage by which you want to change price</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-create-action-part-one">
																				<h2>Fixed Inventory</h2>
																				<input type="text" name="ced_gs_fixed_inventory" class="ced_gs_profile_fixed_inv_val" name="ced_gs_fixed_inventory" value="<?php esc_html_e( empty( $ced_current_gs_profile_fixed_inv_val ) ? '' : $ced_current_gs_profile_fixed_inv_val ); ?>">

																				<p>Send a fixed inventory for your products to Google. If you set this field then Woocommerce inventory is ignored. If you leave it zero then, Woocommerce inventory is passed to Google.</p>
																			</div>
																			<div class="ced-create-action-part-one">
																				<h2>Threshold Inventory</h2>
																				<input type="text" name="ced_gs_fixed_inventory" class="ced_gs_profile_threshold_inv_val" name="ced_gs_fixed_threshold" value="<?php esc_html_e( empty( $ced_current_gs_profile_threshold_inv_val ) ? '' : $ced_current_gs_profile_threshold_inv_val ); ?>">

																				<p>Inventory will go 0 if it's less than or equal to threshold inventory</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-create-action-part-one">
																				<h2>Age Group</h2>
																				<select class="ced-setting-select ced_selected_config_agegroup" id="ced_selected_config_agegroup">
																					<option value="" disabled>Select Age Group </option>
																					<?php
																					foreach ( $age_group as $key => $age_group ) {
																						if ( ! empty( $ced_current_gs_profile_agegroup ) && $key == $ced_current_gs_profile_agegroup ) {
																							echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
																						} else {

																							echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
																						}
																					}
																					?>
																				</select>
																				<p>The age group for which your product is intended</p>
																			</div>
																			<div class="ced-create-action-part-one">
																				<h2>Gender</h2>
																				<select class="ced-setting-select" id="ced_selected_config_gender">
																					<option value="" disabled>Select Gender </option>
																					<?php
																					foreach ( $gender as $key => $gender ) {
																						if ( ! empty( $ced_current_gs_profile_gender ) && $key == $ced_current_gs_profile_gender ) {

																							echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
																						} else {

																							echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
																						}
																					}
																					?>
																				</select>
																				<p>The gender for which your product is intended</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-alt-wrap">
																				<h2>Promotions</h2>
																						<?php
																						$promotions = array(
																							'false' => 'Disable',
																							'true'  => 'Enable',
																						);
																						?>
																				<select class="ced-setting-select ced_gs_profile_promition_val">
																					<option disabled value="">Select Promotion </option>
																							<?php
																							foreach ( $promotions as $key => $promotions ) {
																								if ( ! empty( $ced_current_google_shopping_profile_promition ) && $key == $ced_current_google_shopping_profile_promition ) {

																									echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $promotions ) . '</span></p> </option>';
																								} else {

																									echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $promotions ) . '</span></p> </option>';
																								}
																							}
																							?>
																				</select>
																				<p>Enable/Disbale promotions for specific products on merchant center if any .</p>
																			</div>

																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-alt-wrap">
																				<h2>Item Group Id</h2>
																						<?php
																						$groupId = array(
																							'set'   => 'Send',
																							'unset' => 'Do Not Send',
																						);
																						?>
																				<select class="ced-setting-select ced_gs_profile_itemGroupId_val">
																					<option disabled value="">Select Item Group Id </option>
																							<?php
																							foreach ( $groupId as $key => $groupId ) {
																								if ( ! empty( $ced_current_gs_profile_itemGroupId_val ) && $key == $ced_current_gs_profile_itemGroupId_val ) {

																									echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $groupId ) . '</span></p> </option>';
																								} else {

																									echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $groupId ) . '</span></p> </option>';
																								}
																							}
																							?>
																				</select>
																				<p>Use the item group ID attribute to group product variants in your product data</p>
																			</div>
																		</div>
																	</div>
																	<div class="ced-form-wrap">
																		<div class="ced-create-action-wrap">
																			<div class="ced-alt-wrap">
																				<h2>Adult</h2>
																						<?php
																						$IsAdult = array(
																							'yes' => 'Yes',
																							'no'  => 'No',
																						);
																						?>
																				<select class="ced-setting-select ced_gs_profile_isAdult_val">
																					<option disabled value="">Select Adult </option>
																							<?php
																							foreach ( $IsAdult as $key => $IsAdult ) {
																								if ( ! empty( $ced_current_gs_profile_isAdult_val ) && $key == $ced_current_gs_profile_isAdult_val ) {

																									echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $IsAdult ) . '</span></p> </option>';
																								} else {

																									echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $IsAdult ) . '</span></p> </option>';
																								}
																							}
																							?>
																				</select>
																				<p>Is Product Adult</p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="ced_re_update_the_existing_profile">
													<button class="ced-create-continue">Save Profile</button>
												</div>
												<!---end--->
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
<!-- </div>
</div>
</div>
-->

<!-------popup---->
<div id="ced_create_custom_profile" class="overlay">
	<div class="popup">
		<div class="popup-head"><h2>Profile Creation - </h2>
			<a class="close" href="#">&times;</a></div>
			<div class="content">

				<div class="ced_create_custom_profile_content_info">
					General Info
					Import your Woocommerce products to the app before creating a profile. To import products from Woocommerce , go to Products Section.
				</div>

				<div class="ced_create_custom_profile_fields">
					<span>Profile Name</span>
					<input type="text" name="" class="ced_google_shopping_profile_name">
				</div>

				<div class="ced_profile_creation_error"></div>

			</div>

			<div class="ced-popup-footer">
				<div class="ced-btn-update ced_create_and_save_profile"><a href="<?php esc_html_e( admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-profile&tab=profile_creation' ); ?>">Create Profile</a></div>
				<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>
			</div>
		</div>
	</div>
