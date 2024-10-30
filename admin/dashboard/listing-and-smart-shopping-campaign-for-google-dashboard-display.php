<?php
$content = isset( $_GET['content'] ) ? sanitize_text_field( $_GET['content'] ) : 'dash-layout';
echo '<div id="root" class="">';
echo '<div class="ced ced-wrapper">';
google_shopping_dashboard_header_section();
google_shopping_dashboard_nav_sections();
if ( 'dash-layout' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-content.php';
}

if ( 'dash-googleads' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-googleads.php';
}
if ( 'dash-products' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-products.php';
}

if ( 'dash-reconnect' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-reconnect.php';
}
if ( 'dash-faq' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-faq.php';
}

if ( 'dash-support' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-support.php';
}

if ( 'dash-activities' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-activites.php';
}
if ( 'dash-profile' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-profile.php';
}
if ( 'dash-configuration' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-configuration.php';
}
if ( 'dash-verifyandclaim' == $content ) {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-verifyandclaim.php';
}


echo '</div>';
echo '</div>';



function google_shopping_dashboard_nav_sections() {
	$content = isset( $_GET['content'] ) ? sanitize_text_field( $_GET['content'] ) : 'dash-layout';
	?>
	   <div class="ced__Toggle ">
		 <div class="ced__Hamburger"><span></span></div>
	  </div>
	  <div class=" ced__Sidebar" id="ced__Sidebar">
		 <div class="ced__Sidebar--toggle ced-Desktop--show ced-Mobile--hide">
			<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
			   <path d="M17.3334 22.6667L24 16L17.3334 9.33331" stroke="#E7E6FA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
			   <path d="M8 22.6667L14.6667 16L8 9.33331" stroke="#E7E6FA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
		 </div>
		 <div class="ced__SidebarItems" id="sidebar">
			<ul class="ced-flex  ced-flex--vertical">
				<?php
				$dash_menus = google_shopping_dashboard_menu_array();
				$html       = '';
				foreach ( $dash_menus as $dash_menus_key => $dash_menus_value ) {
					// print_r($content);
					$active_class = '';
					if ( $content == $dash_menus_value['content'] ) {
						$active_class = 'active';
					}
					$html .= '<li class="ced-flex__item ced__Menus--' . $active_class . '">';
					$html .= '<a class="ced__Menus  ced__Menus--' . $active_class . '" href="' . $dash_menus_value['url'] . '">';
					$html .= '<span class="ced__menuIcon">';
					$html .= '<img class="ced-menu-icon" src="' . $dash_menus_value['icon_image'] . '">';
					$html .= '</span>';
					$html .= '<span class="ced__menuItem">' . $dash_menus_key . '</span>';
					$html .= '</a></li>';
				}
				print_r( $html );
				?>
			   
			</ul>
		 </div>
	  </div>
	<?php

}
function google_shopping_dashboard_header_section() {
	?>
	  <div class="ced__Topbar">
		 <div class="ced-flex ced-flex--distribute-spaceBetween ced-flex--align-center ced-flex--spacing-Extraloose">
			<div class="ced-flex__item">
			   <div class="ced-flex ced-flex--align-center  ced-flex--spacing-loose   ced-flex--wrap"></div>
			</div>
			<div class="ced-flex__item">
			   <div class="ced__accountsWrapper">
				  <div class="ced__Popover-Wrapper--parent">
					 <div class="ced__Accounts">
						<div class="ced__Avatar"><img src="<?php esc_attr_e( CED_WGEI_URL . 'admin/images/logo.png' ); ?>" alt="" width="50" height="50"></div>
						<?php
						$merchant_details      = get_option( 'ced_save_merchant_details', true );
						$connected_merchant_id = isset( $merchant_details['merchant_id'] ) ? $merchant_details['merchant_id'] : '';
						$merhcant_google_url   = 'https://merchants.google.com/mc/overview?a=' . $connected_merchant_id;
						?>
						<div class="ced__accountName"><span class="ced__user"><a href="<?php print_r( $merhcant_google_url ); ?>" target="_blank">Visit Merchant Center</a></span></div>
					 </div>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
	<?php
}
function google_shopping_dashboard_menu_array() {
	$dash_navigation_menus                      = array();
	$dash_navigation_menus['Dashboard']         = array(
		'content'    => 'dash-layout',
		'icon_image' => CED_WGEI_URL . 'admin/images/home.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-layout',
	);
	$dash_navigation_menus['Products']          = array(
		'content'    => 'dash-products',
		'icon_image' => CED_WGEI_URL . 'admin/images/package.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-products',
	);
	$dash_navigation_menus['Google Ads']        = array(
		'content'    => 'dash-googleads',
		'icon_image' => CED_WGEI_URL . 'admin/images/megaphone.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-googleads',
	);
	$dash_navigation_menus['Profile']           = array(
		'content'    => 'dash-profile',
		'icon_image' => CED_WGEI_URL . 'admin/images/profile.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-profile',
	);
	$dash_navigation_menus['Reconnect Account'] = array(
		'content'    => 'dash-reconnect',
		'icon_image' => CED_WGEI_URL . 'admin/images/settings.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-reconnect',
	);
	$dash_navigation_menus['Configuration']     = array(
		'content'    => 'dash-configuration',
		'icon_image' => CED_WGEI_URL . 'admin/images/configuration.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-configuration',
	);
	$dash_navigation_menus['Merchant Center']   = array(
		'content'    => 'dash-verifyandclaim',
		'icon_image' => CED_WGEI_URL . 'admin/images/verifyandclaim.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-verifyandclaim',
	);
	$dash_navigation_menus['Activities']        = array(
		'content'    => 'dash-activities',
		'icon_image' => CED_WGEI_URL . 'admin/images/activities.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-activities',
	);
	$dash_navigation_menus['FAQ']               = array(
		'content'    => 'dash-faq',
		'icon_image' => CED_WGEI_URL . 'admin/images/information.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-faq',
	);
	$dash_navigation_menus['Support']           = array(
		'content'    => 'dash-support',
		'icon_image' => CED_WGEI_URL . 'admin/images/support.png',
		'url'        => admin_url() . 'admin.php?page=ced_google&section=dashboard&content=dash-support',
	);
	return $dash_navigation_menus;

}
?>
