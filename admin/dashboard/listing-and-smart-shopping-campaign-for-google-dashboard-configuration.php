<?php
$ced_google_shopping_product_automate_setting_data = get_option( 'ced_google_shopping_product_automate_setting_data', true );
$enable_product_syncing                            = isset( $ced_google_shopping_product_automate_setting_data['product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['product_sync'] : '';
$enable_existing_product_syncing                   = isset( $ced_google_shopping_product_automate_setting_data['existing_product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['existing_product_sync'] : '';
$enable_instant_product_syncing                   = isset( $ced_google_shopping_product_automate_setting_data['instant_product_sync'] ) ? $ced_google_shopping_product_automate_setting_data['instant_product_sync'] : '';
$ced_configuration_details                         = get_option( 'ced_configuration_details', true );
$attributes                                        = wc_get_attribute_taxonomies();
$attrOptions                                       = array();
$addedMetaKeys                                     = get_option( 'CedUmbProfileSelectedMetaKeys', false );
$selectDropdownHTML                                = '';
$google_supported_taxonomy = file( CED_WGEI_DIRPATH . 'admin/taxonomy.txt' );

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
										<h3 class="ced__Heading">Configuration</h3>
									</h3>
								</div>
							</div>
						</div>
						<!---cardcontent-->
						<div class="ced-flex ced-flex--wrap ced-flex--D100 ced-flex--T100 ced-flex--M100 ced-filter-alt">
							<div class="ced-flex__item">
								<div class="ced-configuration-wrapper">
									<div class="ced-card  ">
										<div class="ced-card__Body">
											<div class="ced__cardContent">
												<div class="ced-flex ced-flex--wrap">
													<div class="ced-log-table">
														<div class="ced-create-action-wrap">
															<div class="ced-create-configuration-part-one">
																<h3>Google Item Id Configuration</h3>
															</div>
															<div class="ced-create-action-part-one-alt">
																<div class="ced-unlist-items">
																	<h3>Default Item ID</h3>
																	<?php
																	$product_id_view_array = array( 'Woocommerce_{{targetCountry}}_{{ sourceProductId }}_{{ sourceVariantId }}', '{{ sourceVariantId }}', '{{ sku }}' );
																	$selected_product_view = get_option( 'ced_google_shopping_product_id_view' );
																	foreach ( $product_id_view_array as $product_id_view_array_key => $product_id_view_array_val ) {
																		if ( $selected_product_view == $product_id_view_array_val ) {
																			$checked = 'checked';
																		} else {
																			$checked = '';
																		}
																		print_r( '<p><input ' . $checked . ' type="radio" value="' . $product_id_view_array_val . '" name="ced_config_product_id_view" class="ced-radio ced_config_product_id_view">' . $product_id_view_array_val . '<p>' );
																	}

																	?>
																	
																</div>
															</div>
														</div>
														<div class="ced-buttons ced-right-btn ced_save_google_product_id_view">
															<button class="ced-btn-cancel">Save</button>
														</div>
														<div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div>           
														
													</div>
												</div>
												<div class="ced-flex ced-flex--wrap">
													<div class="ced-log-table">
														<div class="ced-create-action-wrap">
															<div class="ced-create-configuration-part-one">
																<h3>Woocommmerce Product Configuration</h3>
															</div>
															<div class="ced-create-action-part-one-alt">
																<div class="ced-unlist-items">
																	<h3>Product Auto Syncing Enable/ Disable</h3>
																	<div class="ced_google_shopping_pro_atmt_label_wrapper">
																		<div class="ced_google_shopping_pro_atmt_label">
																			Enabel Auto Product Syncing
																		</div>
																		<div class="ced_google_shopping_pro_atmt_checkbox">
																			<label class="switch">
																				<input type="checkbox" id="ced_google_shopping_enable_product_syncing" name="ced_google_shopping_enable_product_syncing" <?php echo ( 'on' == $enable_product_syncing ) ? 'checked=checked' : ''; ?> >
																				<span class="slider round"></span>
																			</label>
																		</div>
																	</div>
																	<div class="ced_google_shopping_pro_atmt_label_wrapper">
																		<div class="ced_google_shopping_pro_atmt_label">
																			Enable Existing Product Syncing
																		</div>
																		<div class="ced_google_shopping_pro_atmt_checkbox">
																			<label class="switch">
																				<input type="checkbox" id="ced_google_shopping_enable_existing_product_syncing" name="ced_google_shopping_enable_existing_product_syncing" <?php echo ( 'on' == $enable_existing_product_syncing ) ? 'checked=checked' : ''; ?>>
																				<span class="slider round"></span>
																			</label>
																		</div>
																	</div>
																	<div class="ced_google_shopping_pro_atmt_label_wrapper">
																		<div class="ced_google_shopping_pro_atmt_label">
																			Enable Instant Product Syncing
																		</div>
																		<div class="ced_google_shopping_pro_atmt_checkbox">
																			<label class="switch">
																				<input type="checkbox" id="ced_google_shopping_enable_instant_product_syncing" name="ced_google_shopping_enable_instant_product_syncing" <?php echo ( 'on' == $enable_instant_product_syncing ) ? 'checked=checked' : ''; ?>>
																				<span class="slider round"></span>
																			</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="ced-buttons ced-right-btn ">
															<button class="ced-btn-cancel ced_save_google_product_automate">Save</button>
															 <div class="ced_google_shopping_loader" style="display:none"><img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></div> 
														</div>
														
													</div>
												</div>
												<div class="ced-flex ced-flex--wrap">
													<div class="ced-log-table">
														<div class="ced-create-action-wrap">
															<div class="ced-create-configuration-part-one">
																<h3>Woocommmerce Configuration</h3>
															</div>
															<div class="ced-create-action-part-one-alt">
																<div class="google_shopping_brand_mpn_wrapper">
							<div class="google_shopping_brand_content ced_brand_mpn_content">
								<div class="ced_brand_mpn_title">
									Brand
								</div>
								<div class="ced_brand_mpn_textbox">
									<input type="text" name="ced_google_shopping_brand" id="ced_google_shopping_brand" value="<?php esc_html_e( isset( $ced_configuration_details['ced_selected_brand_input_filed_value'] ) ? $ced_configuration_details['ced_selected_brand_input_filed_value'] : '' ); ?>">
								</div>
								<div class="ced_brand_mpn_slectbox">
									<?php
									// print_r(isset($ced_configuration_details['ced_selected_brand_dropdown_value'])?$ced_configuration_details['ced_selected_brand_dropdown_value']:'');
									$fieldID             = 'google_brand';
									$selectId            = $fieldID . '_attibuteMeta';
									$selectDropdownHTML  = '';
									$selectDropdownHTML .= '<select id="' . $selectId . '" name="' . $selectId . '">';
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
							<div class="google_shopping_mpn_content ced_brand_mpn_content">
								<div class="ced_brand_mpn_title">
									MPN
								</div>
								<div class="ced_brand_mpn_textbox">
									<!-- <input type="text" name="ced_google_shopping_mpn" id="ced_google_shopping_mpn"> -->
								</div>
								<div class="ced_brand_mpn_slectbox">
									<?php
									// print_r(isset($ced_configuration_details['ced_selected_mpn_dropdown_value'])?$ced_configuration_details['ced_selected_mpn_dropdown_value']:'');
									$fieldID             = 'google_mpn';
									$selectId            = $fieldID . '_attibuteMeta';
									$selectDropdownHTML  = '';
									$selectDropdownHTML .= '<select id="' . $selectId . '" name="' . $selectId . '">';
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
							<div class="google_shopping_gtin_content ced_brand_gtin_content">
								<div class="ced_brand_gtin_title">
									GTIN
								</div>
								<div class="ced_brand_gtin_textbox">
									<!-- <input type="text" name="ced_google_shopping_mpn" id="ced_google_shopping_mpn"> -->
								</div>
								<div class="ced_brand_gtin_slectbox">
									<?php
									// print_r(isset($ced_configuration_details['ced_selected_gtin_dropdown_value'])?$ced_configuration_details['ced_selected_gtin_dropdown_value']:'');
									$fieldID             = 'google_gtin';
									$selectId            = $fieldID . '_attibuteMeta';
									$selectDropdownHTML  = '';
									$selectDropdownHTML .= '<select id="' . $selectId . '" name="' . $selectId . '">';
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
							<div class="google_shopping_gtin_content ced_google_taxanomy_content">
								<div class="ced_brand_gtin_title">
									<b>Select Google Default Category</b>
								</div>
								<div class="ced_brand_gtin_textbox">
									<!-- <input type="text" name="ced_google_shopping_mpn" id="ced_google_shopping_mpn"> -->
								</div>
								<div class="ced_brand_gtin_slectbox">
									<select class="ced-select-wrap" id= "ced_gs_configuration_google_taxonomy">
										<option value="">Select Google Category</option>
										<?php
										foreach ( $google_supported_taxonomy as $google_supported_taxonomy_key => $google_supported_taxonomy_val ) {
											echo '<option ' . esc_attr($selected) . ' value="' . esc_attr( $google_supported_taxonomy_val ) . '"><p><span>' . esc_attr( $google_supported_taxonomy_val ) . '</span></p> </option>';
										}
										?>
									</select>
								</div>
							</div>
								<?php 
								$selected_val = isset( $ced_configuration_details['ced_selected_defualt_google_taxanomoy_value'] ) ? $ced_configuration_details['ced_selected_defualt_google_taxanomoy_value'] : '';
								if (!empty($selected_val)) {
									$html = '<div class="ced_gs_mapped_category">Current Selected Category - 
									<span class="ced_mapped_catgeory_name">' . ( $selected_val ) . '</span>
									</div>';
									print_r($html);
								}
								?>
						</div>
															</div>
														</div>
														<div class="ced-buttons ced-right-btn ced_save_global_config_contents">
															<button class="ced-btn-cancel">Save</button>
														</div>
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
			</div>
		</div>
	</div>
</div>
