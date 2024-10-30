<?php
function regenerate_expired_token_for_google_shopping_intigration() {
		$ced_google_user_token_data = get_option( 'ced_google_user_token_data', true );
		$connected_username         = isset( $ced_google_user_token_data['username'] ) ? $ced_google_user_token_data['username'] : '';
		$connected_email            = isset( $ced_google_user_token_data['email'] ) ? $ced_google_user_token_data['email'] : '';
		$user_token                 = isset( $ced_google_user_token_data['token'] ) ? $ced_google_user_token_data['token'] : '';
		$parameters                 = array();
		$parameters['username']     = $connected_username;
		$parameters['email']        = $connected_email;

		$header                          = array(
			'Content-Type'  => 'application/x-www-form-urlencoded',
			'Authorization' => 'Bearer ' . $user_token,
		);
		$apiUrl                          = 'https://express.sellernext.com/connector/framework/login';
		$api_response                    = wp_remote_post(
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
		$response                        = json_decode( $api_response['body'], true );
		$time_during_create_google_token = gmdate( 'H:i:s' );
		update_option( 'ced_google_user_login_data', $response );
		update_option( 'time_during_create_google_token', $time_during_create_google_token );
		set_transient( 'time_during_create_google_token', $time_during_create_google_token, 14000 );
}
