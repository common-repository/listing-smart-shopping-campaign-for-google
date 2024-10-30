<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://cedcommerce.com
 * @since      1.0.0
 *
 * @package    Listing_And_Smart_Shopping_Campaign_For_Google
 * @subpackage Listing_And_Smart_Shopping_Campaign_For_Google/admin/partials
 */
$section                     = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';
$ced_compaign_submit_detials = get_option( 'ced_compaign_details' );

if ( ! empty( $ced_compaign_submit_detials ) ) {
	$section = 'dashboard';
}
$ced_google_nav_step = get_option( 'ced_google_nav_step' );

if ( 'dashboard' == $section ) {
	ced_dashboard_details();
} elseif ( 'onboard' != $section ) {
	ced_google_header();
} else {
	ced_show_googleOnboard();
}
function ced_show_googleOnboard() {
	require CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-googleOnboard.php';
	$redirect_url = admin_url() . 'admin.php?page=ced_google&section=dashboard';
	header( "refresh:2;url=$redirect_url" );
}
function ced_google_navigation() {
	$account_setting_finished_class  = 'unfinished';
	$merchant_setting_finished_class = 'unfinished';
	$linkads_setting_finished_class  = 'unfinished';
	$config_setting_finished_class   = 'unfinished';
	$compaign_setting_finished_class = 'unfinished';
	$ced_google_account_data         = get_option( 'ced_google_account_data' );

	$ced_google_account_data = get_option( 'ced_google_account_data' );
	if ( ! empty( $ced_google_account_data ) && is_array( $ced_google_account_data ) ) {
		$account_setting_finished_class = 'completed';
	}
	$ads_details = get_option( 'ced_save_ads_details' );
	if ( ! empty( $ads_details ) && is_array( $ads_details ) ) {
		$linkads_setting_finished_class = 'completed';
	}
	if ( 'skipped' == $ads_details ) {
		$linkads_setting_finished_class = 'completed';
	}
	$merchant_details = get_option( 'ced_save_merchant_details', true );
	if ( ! empty( $merchant_details ) && is_array( $merchant_details ) ) {
		$merchant_setting_finished_class = 'completed';
	}

	$ced_configuration_details = get_option( 'ced_configuration_details', true );
	if ( ! empty( $ced_configuration_details ) && is_array( $ced_configuration_details ) ) {
		$config_setting_finished_class = 'completed';
	}

	$ced_compaign_setting_finished_class = get_option( 'ced_compaign_details', true );
	if ( ! empty( $ced_compaign_setting_finished_class ) && is_array( $ced_compaign_setting_finished_class ) ) {
		$compaign_setting_finished_class = 'completed';
	}

	$navigation_menus                     = array();
	$navigation_menus['Account']          = array(
		'section'      => 'accounting-setting',
		'status_class' => $account_setting_finished_class,
		'url'          => admin_url() . 'admin.php?page=ced_google&section=accounting-setting',
	);
	$navigation_menus['Merchant Center']  = array(
		'section'      => 'merchant-center',
		'status_class' => $merchant_setting_finished_class,
		'url'          => admin_url() . 'admin.php?page=ced_google&section=merchant-center',
	);
	$navigation_menus['Link Ads Account'] = array(
		'section'      => 'ads-setting',
		'status_class' => $linkads_setting_finished_class,
		'url'          => admin_url() . 'admin.php?page=ced_google&section=ads-setting',
	);
	$navigation_menus['Configuration']    = array(
		'section'      => 'configuration',
		'status_class' => $config_setting_finished_class,
		'url'          => admin_url() . 'admin.php?page=ced_google&section=configuration',
	);
	$navigation_menus['Campaign']         = array(
		'section'      => 'compaign',
		'status_class' => $compaign_setting_finished_class,
		'url'          => admin_url() . 'admin.php?page=ced_google&section=compaign',
	);
	/**
	 * A filter used for create navigation_menus ced_google_navigation_menus.
	 *
	 * A filter used for create navigation_menus.
	 *
	 * @since 1.0.0
	 * @filter ced_google_navigation_menus
	 */
	$navigation_menus = apply_filters( 'ced_google_navigation_menus', $navigation_menus );
	return $navigation_menus;
}
function ced_google_header() {
	$user_token_data             = get_option( 'ced_google_user_login_data', true );
	$user_id                     = isset( $user_token_data['user_id'] ) ? $user_token_data['user_id'] : '';
	$section                     = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'accounting-setting';
	$ced_google_nav_step_from_db = get_option( 'ced_google_nav_step' );
			$ced_google_nav_step = isset( $_GET['step'] ) ? sanitize_text_field( $_GET['step'] ) : '';
	if ( empty( $ced_google_nav_step ) ) {
		$ced_google_nav_step = ! empty( $ced_google_nav_step_from_db ) ? $ced_google_nav_step_from_db : '1';

	}
	if ( '1' == $ced_google_nav_step ) {
		$section = 'accounting-setting';
	}if ( '2' == $ced_google_nav_step ) {
		$section = 'merchant-center';
	}if ( '3' == $ced_google_nav_step ) {
		$section = 'ads-setting';
	}if ( '4' == $ced_google_nav_step ) {
		$section = 'configuration';
	}if ( '5' == $ced_google_nav_step ) {
		$section = 'compaign';
	}
	$navigation_menus = ced_google_navigation();
	$home_url         = home_url();
	$home_url         = str_replace( 'http://', 'https://', $home_url );
	$page             = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';
	?>
  <!-- This file should primarily consist of HTML with a little bit of PHP. -->
  <div class="ced-header">
	<div class="ced-container">
	  <div class="row">
		<div class="ced-head-wrap">
		  <div class="ced-header-logo">
			<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/logo.png' ); ?>">
		  </div>
		  <div class="ced-logo-content">
			<p>
			  <span>Suite for <br>
			  </span>
			  <span>Google Shopping Feed</span>
			</p>
		  </div>
		</div>
		<div class="ced-header-right">
		  <div class="ced-user">
			<div class="ced-user-img">
			  <img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/icon.png' ); ?>">
			</div>
			<div class="ced-user-content">
			 
			  <p>User ID : <?php esc_html_e( $user_id ); ?></p>
			 
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <div class="ced-main-content-wrapper">
	<div class="ced-main-wrap">
	  <div class="row">
		<div class="ced-main-content">
		  <div class="ced-progress-steps">
			<div class="container">
			  <ul class="ced-progressbar">
				<?php
				$html                = '';
				$count               = 1;
				$ced_google_nav_step = get_option( 'ced_google_nav_step' );
				if ( empty( $ced_google_nav_step ) ) {
					$ced_google_nav_step = '1';
				}
				foreach ( $navigation_menus as $label => $nav_detail ) {
					$active_class = '';
					if ( $nav_detail['section'] == $section ) {
						$active_class = 'active';
					}
					if ( 'completed' == $nav_detail['status_class'] ) {
						$html .= '<a href="' . $nav_detail['url'] . '&step=' . $count . '">';
					} else {
						$html .= '<a href="#">';
					}
					// $nav_detail['status_class']=  '';
					// $html.= '<a href="'.$nav_detail['url']. '&step='.$count.'">';
					$html .= '<li class="ced_google_merchant_nav ' . $active_class . ' ' . $nav_detail['status_class'] . '"><p>' . $label . '</p></li>';
					$html .= '</a>';
					$count++;
				}
				print_r( $html );
				?>
			  </ul>
			</div>
		  </div>
		  <!-- Starting of Account Content -->
		  <?php
			// $section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';
			$ced_google_nav_step_from_db = get_option( 'ced_google_nav_step' );
			$ced_google_nav_step         = isset( $_GET['step'] ) ? sanitize_text_field( $_GET['step'] ) : '';
			if ( empty( $ced_google_nav_step ) ) {
								$ced_google_nav_step = ! empty( $ced_google_nav_step_from_db ) ? $ced_google_nav_step_from_db : '1';

			}
			if ( '1' == $ced_google_nav_step ) {
				$section = 'accounting-setting';
			}if ( '2' == $ced_google_nav_step ) {
				$section = 'merchant-center';
			}if ( '3' == $ced_google_nav_step ) {
				$section = 'ads-setting';
			}if ( '4' == $ced_google_nav_step ) {
				$section = 'configuration';
			}if ( '5' == $ced_google_nav_step ) {
				$section = 'compaign';
			}

			if ( ( 'accounting-setting' == $section || '' == $section ) && ( '1' == $ced_google_nav_step ) ) {
				require CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-accontsetting.php';
			}
			?>
		  <!-- Ending of Account Content -->
		  <!-- Start of Merchant Center Content  -->
		  <?php
			if ( 'merchant-center' == $section && '2' == $ced_google_nav_step ) {
				require CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-merchantcenter.php';

			}
			?>
		  <!-- End of Merchant Center Content -->
		  <!-- Start of Link Adds Account -->
		  <?php
			if ( 'ads-setting' == $section && '3' == $ced_google_nav_step ) {
				require CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-googleAdds.php';
			}
			?>
		  <!-- End of Link Adds Account -->
		  <!-- Start of Google Configuration content -->
		  <?php
			if ( 'configuration' == $section && '4' == $ced_google_nav_step ) {
				require CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-googleConfiguration.php';
			}
			?>
		  <!-- End of  Google Configuration content-->
		  <!-- Start of Google Compaign Content  -->
		  <?php
			if ( 'compaign' == $section && '5' == $ced_google_nav_step ) {
				require CED_WGEI_DIRPATH . 'admin/partials/listing-and-smart-shopping-campaign-for-google-googleCompaign.php';
			}
			?>
		  <!-- End of Google Compaign Content-->
		</div>
		<div class="ced-main-sidebar">
			<div class="ced-video-back-alt">
			<a href="#video-bck" class="ced-play-btn">
			  <img src="<?php echo esc_attr( CED_WGEI_URL . 'admin/images/play-button.png' ); ?>">
			</a>
		  </div>
		</div>
	  </div>
	</div>
  </div>

 <!-------popup---->
<div id="video-bck" class="overlay">
  <div class="popup-alt">
	<div class="popup-head"><a class="close google_shopping_help_video_modal_close_icon" href="#">&times;</a></div>
	<div class="content">
	  <div class="ced-video-back">
	  <iframe id="google_shopping_help_video_modal" width="100%" height="335" src="https://www.youtube.com/embed/SBOTCJ3_W7c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
	  
  </div>
  </div>
</div>


	<?php
}
function ced_dashboard_details() {
	require CED_WGEI_DIRPATH . 'admin/dashboard/listing-and-smart-shopping-campaign-for-google-dashboard-display.php';
}
?>
