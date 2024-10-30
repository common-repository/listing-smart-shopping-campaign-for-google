<?php
$user_id                     = isset( $user_token_data['user_id'] ) ? $user_token_data['user_id'] : '';
?>
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
			  <h3></h3>
			  <p>User ID : <?php esc_html_e($user_id  ); ?></p>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <div class="ced-main-content-wrapper">
	<div class="ced-main-wrap">
		<div class="ced-main-content-alt">
		 
		  <div class="ced-onboard">
			<img src="<?php esc_html_e( CED_WGEI_URL . 'admin/images/thumbsup.png' ); ?>">
			<h3>Welcome Onboard!!</h3>
			<p>Redirecting to Dashboard</p>
		  </div>
	   
	</div>
  </div>
  </div>


