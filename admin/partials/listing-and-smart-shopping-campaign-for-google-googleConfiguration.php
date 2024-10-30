<?php
require_once ABSPATH . 'wp-admin/includes/translation-install.php';
$wc_countries          = new WC_Countries();
$woo_countries         = $wc_countries->get_countries();
$currency_code_options = get_woocommerce_currencies();
$woo_store_categories  = get_terms( 'product_cat' );
foreach ( $currency_code_options as $code => $name ) {
	$currency_code_options[ $code ] = $name . ' (' . get_woocommerce_currency_symbol( $code ) . ')';
}
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
$ced_configuration_details = get_option( 'ced_configuration_details', true );
$google_supported_langaue  = file( CED_WGEI_DIRPATH . 'admin/language-codes_json.json' );
$woo_languages             = ( json_decode( $google_supported_langaue[0], 1 ) );



$attributes         = wc_get_attribute_taxonomies();
$attrOptions        = array();
$addedMetaKeys      = get_option( 'CedUmbProfileSelectedMetaKeys', false );
$selectDropdownHTML = '';

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
<div class="ced-google-wrap" >
	<h3>Account Configuration</h3>
	<p>Set a default configuration for uploading your products. These settings will allow your products and variants to be included in the feed. 
	 <p><i><strong>Note:</strong> These settings can be customised later for specific products and variants.</i></p>


	 <div class="ced-accordian">

		<div class="ced-tab ced_config_accordion" id="ced_config_accordion_1">
			<input id="ced-tab-1" type="checkbox" checked>
			<label for="ced-tab-1">General</label>
			<div class="content">
				<div class="ced-data">
					<div class="ced-left">
						<p >Target Country <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
						<p>
							<select class="ced-setting-select" id="ced_selected_config_country">
								<option value="">Select Target Country </option>
								<?php
								$selected_country = isset( $ced_configuration_details['ced_selected_config_country'] ) ? $ced_configuration_details['ced_selected_config_country'] : '';
								foreach ( $woo_countries as $key => $countries ) {
									if ( ! empty( $selected_country ) && $key == $selected_country ) {
										echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
									} else {
										echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $countries ) . '</span></p> </option>';
									}
								}
								?>
							</select>
					</p></div>
					<div class="ced-right">
						<p>Content Language <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
						<p>
							<select class="ced-setting-select" id="ced_selected_config_language">
								<option value="">Select Content Language </option>
								<?php
								foreach ( $woo_languages as $key => $language ) {
									$selected_lang = isset( $ced_configuration_details['ced_selected_config_language'] ) ? $ced_configuration_details['ced_selected_config_language'] : '';
									if ( ! empty( $selected_lang ) && $language['Language code'] == $selected_lang ) {

										echo '<option value="' . esc_attr( $language['Language code'] ) . '" selected><p><span>' . esc_attr( $language['Language name'] ) . '</span></p> </option>';
									} else {

										echo '<option value="' . esc_attr( $language['Language code'] ) . '"><p><span>' . esc_attr( $language['Language name'] ) . '</span></p> </option>';
									}
								}
								?>
							</select>
						</p></div>
					</div>
					<div class="ced-data">
						<div class="ced-left">
							<p>Currency <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
							<p>
								<select class="ced-setting-select" id="ced_selected_config_currency">
									<option value="">Select Currency </option>
									<?php
									$selected_currency = isset( $ced_configuration_details['ced_selected_config_currency'] ) ? $ced_configuration_details['ced_selected_config_currency'] : '';
									foreach ( $woo_currencies as $key => $currencies ) {

										if ( ! empty( $selected_currency ) && $key == $selected_currency ) {

											echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';
										} else {

											echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $currencies ) . '</span></p> </option>';
										}
									}
									?>
								</select>
							</p></div>
							<div class="ced-right">
								<p>Gender <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
								<p>
									<select class="ced-setting-select" id="ced_selected_config_gender">
										<option value="">Select Gender </option>
										<?php
										$selected_gender = isset( $ced_configuration_details['ced_selected_config_gender'] ) ? $ced_configuration_details['ced_selected_config_gender'] : '';
										foreach ( $gender as $key => $gender ) {
											if ( ! empty( $selected_gender ) && $key == $selected_gender ) {

												echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
											} else {

												echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $gender ) . '</span></p> </option>';
											}
										}
										?>
									</select>
								</p></div>
							</div> 
							<div class="ced-data">
								<div class="ced-left">
									<p>Age Group <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
									<p><select class="ced-setting-select" id="ced_selected_config_agegroup">
										<option value="" disabled selected hidden>Select Age Group </option>
										<?php
										$selected_age_group = isset( $ced_configuration_details['ced_selected_config_agegroup'] ) ? $ced_configuration_details['ced_selected_config_agegroup'] : '';
										foreach ( $age_group as $key => $age_group ) {
											if ( ! empty( $selected_age_group ) && $key == $selected_age_group ) {

												echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
											} else {

												echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $age_group ) . '</span></p> </option>';
											}
										}
										?>
									</select></p>
								</div>
								


								<div class="ced-right">

									<p>Include Destination <img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
									<p><select multiple class="ced-setting-select" id="ced_selected_include_destination">
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
											if ( ! empty( $incliude_destinaiton ) ) {

												foreach ( $incliude_destinaiton as $incliude_destinaiton_key => $incliude_destinaiton_val ) {

													if ( $key == $incliude_destinaiton_val ) {

														  echo '<option value="' . esc_attr( $key ) . '" selected><p><span>' . esc_attr( $destination ) . '</span></p> </option>';
													}
												}
											} else {

												 echo '<option value="' . esc_attr( $key ) . '"><p><span>' . esc_attr( $destination ) . '</span></p> </option>';
											}
										}
										?>
								</select></p>
							</div>
						</div> 
					</div>
				</div>

				<div class="ced-tab ced_config_accordion" id="ced_config_accordion_2">
					<input id="ced-tab-2" type="checkbox" >
					<label for="ced-tab-2">Product</label>
					<div class="content">
						<div class="ced-data">
							<div class="ced-left ced_ced-left-hide">
								<p><strong>Products which needs to be submitted in Feed?</strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
								<?php
								$ced_products_needs_to_submit = isset( $ced_configuration_details['ced_products_needs_to_submit'] ) ? $ced_configuration_details['ced_products_needs_to_submit'] : '';
										// print_r($ced_products_needs_to_submit);
								$product_array = array( 'All Products', 'Products from a collection' );
								foreach ( $product_array as $key => $val ) {
									$checked = '';
									if ( ! empty( $ced_products_needs_to_submit ) && is_array(
										$ced_products_needs_to_submit
									) ) {
										$ced_products_needs_to_submit = 'Products from a collection';
									} else {
										$ced_products_needs_to_submit = $val;
									}
									if ( $val == $ced_products_needs_to_submit ) {
										$checked = 'checked';
									}
									echo '<input type="radio" ' . esc_attr( $checked ) . ' class="ced_google_product_needs_to_submit" name="ced_google_product_needs_to_submit" value="' . esc_attr( $val ) . '">
                                    <span>' . esc_attr( $val ) . '</span><br>';
								}
								$selected_category = isset( $ced_configuration_details['ced_products_needs_to_submit'] ) ? sanitize_text_field( $ced_configuration_details['ced_products_needs_to_submit'] ) : array();
								?>
								<div class="ced-optn-selt">
									<select class="ced-data-selt ced_cat_select select2" id="ced_cat_select" name="_ced_cat_select" multiple='multiple'>
										<?php
										foreach ( $woo_store_categories as $key => $value ) {
											if ( in_array( $value->term_id, $selected_category ) ) {
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
								</div>
							</div>
							<div class="ced-right">
								<p><strong>Variant Submission Preference</strong><img class="ced-notify" src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/notify.png' ); ?>"></p>
								<?php
								$ced_product_variation_preference = isset( $ced_configuration_details['ced_product_variation_preference'] ) ? sanitize_text_field( $ced_configuration_details['ced_product_variation_preference'] ) : '';
								$product_var_array                = array( 'All Variants', 'First Variants Only' );
								foreach ( $product_var_array as $var_key => $var_val ) {
									$checked = '';

									if ( $var_val == $ced_product_variation_preference ) {
										$checked = 'checked';
									}
									echo ' <input type="radio" ' . esc_attr( $checked ) . ' class="ced_google_product_variation_preference" name="ced_google_product_variation_preference" value="' . esc_attr( $var_val ) . '">
                                    <span>' . esc_attr( $var_val ) . '</span><br>';
								}
								?>
							</div>


						</div>
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
											$selected_val = isset( $ced_configuration_details['ced_selected_mpn_dropdown_value'] ) ? $ced_configuration_details['ced_selected_mpn_dropdown_value'] : '';
											$selected     = '';
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
											$selected_val = isset( $ced_configuration_details['ced_selected_gtin_dropdown_value'] ) ? $ced_configuration_details['ced_selected_gtin_dropdown_value'] : '';
											$selected     = '';
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
				</div>

			</div>
		</div>
		<div class="ced-google-butn">
			<div class="ced-button-combo">
				<div class="ced-button-save" id="ced_save_account_config_content">
				  <span class="ced_span">Submit</span>

			  </div>
			  <span class="ced_google_loader"><img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/ced_loader.gif' ); ?>"></span>
		  </div>
		  <p class="ced-suggestion">In case of any query or suggestion, please read our <a href="https://woocommerce.com/document/listing-and-smart-shopping-campaign-for-google/" target="_blank">Help Manual.</a>
		  </p>
		  <p class="ced-footer-text">A CedCommerce Inc Product</p>
	  </div>
