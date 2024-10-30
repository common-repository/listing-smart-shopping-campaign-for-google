(function( $ ) {
	'use strict';

	function fun_data_prepration_for_create_user(this_attribute, during_gads=''){
		var google_create_user_data = new Object();
		if (during_gads == true) {
			if ($( '.ced_acceptTerm_checkbox' ).is( ":checked" )) {
				$( '.ced_signinwithgoogle_acceptTerm_alert' ).hide();
				$( '.ced_acceptTerm_checkbox' ).css( 'border','' );
				var store                                 = $( this_attribute ).attr( 'data-store' );
				var framework                             = $( this_attribute ).attr( 'data-framework' );
				var email                                 = $( this_attribute ).attr( 'data-email' );
				google_create_user_data['store']          = store;
				google_create_user_data['framework']      = framework;
				google_create_user_data['email']          = email;
				google_create_user_data['ajax_condition'] = true;
				return google_create_user_data;
			} else {
				$( '.ced_acceptTerm_checkbox' ).css( 'border','1px solid red' );
				$( '.ced_signinwithgoogle_acceptTerm_alert' ).show();
				google_create_user_data['ajax_condition'] = false;
				return google_create_user_data;
			}
		} else {
			if ($( '.ced_acceptTerm_checkbox' ).is( ":checked" )) {
				$( '.ced_signinwithgoogle_acceptTerm_alert' ).hide();
				$( '.ced_acceptTerm_checkbox' ).css( 'border','' );
				var store                                 = $( this_attribute ).attr( 'data-store' );
				var framework                             = $( this_attribute ).attr( 'data-framework' );
				var email                                 = $( this_attribute ).attr( 'data-email' );
				google_create_user_data['store']          = store;
				google_create_user_data['framework']      = framework;
				google_create_user_data['email']          = email;
				google_create_user_data['ajax_condition'] = true;
				return google_create_user_data;
			} else {
				$( '.ced_acceptTerm_checkbox' ).css( 'border','1px solid red' );
				$( '.ced_signinwithgoogle_acceptTerm_alert' ).show();
				google_create_user_data['ajax_condition'] = false;
				return google_create_user_data;
			}
		}

	}

	function ajax_call_for_create_user(this_attribute,during_gads=''){
		var data_prepration_for_create_user = fun_data_prepration_for_create_user( this_attribute, during_gads );console.log( 'df' );
		console.log( data_prepration_for_create_user );
		if (data_prepration_for_create_user.ajax_condition == true) {
			$( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url : ced_google_admin_obj.ajax_url,
							data : {
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action : 'ced_google_create_user',
								store : data_prepration_for_create_user.store,
								email : data_prepration_for_create_user.email,
								framework : data_prepration_for_create_user.framework,
							},
							type : 'POST',
							datatype : 'json',
							success: function(response) {
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								resolve( response );
							}
						}
					);
				}
			);
		}

	}

	$( document ).on(
		'click touchstart',
		'#ced_connect_another_gmail_account_for_google_ads_account',
		function(je){
			je.preventDefault();
			var this_attribute                  = this;
			var during_gads                     = true;
			var data_prepration_for_create_user = fun_data_prepration_for_create_user( this_attribute,during_gads );
			console.log( data_prepration_for_create_user );
			if (data_prepration_for_create_user.ajax_condition == true) {
				$( '.ced_google_loader' ).show();
				$.ajax(
					{
						url : ced_google_admin_obj.ajax_url,
						data : {
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action : 'ced_connect_another_gmail_account_for_gads',
							store : data_prepration_for_create_user.store,
							email : data_prepration_for_create_user.email,
							framework : data_prepration_for_create_user.framework,
						},
						type : 'POST',
						datatype : 'json',
						success: function(response) {
							$( '.ced_google_loader' ).hide();
							// response = jQuery.parseJSON( response );
							window.open( response );
							$( '.ced_google_loader' ).show();

						}
					}
				);

			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_signinwithgoogle_createuser_dash',
		function(je){
			je.preventDefault();
			/*        var this_attribute = this;
			var during_gads = true;
			var data_prepration_for_create_user = fun_data_prepration_for_create_user(this_attribute,during_gads);
			console.log(data_prepration_for_create_user);
			if(data_prepration_for_create_user.ajax_condition == true) {
			$('.ced_google_loader').show();
			$.ajax(
			{
				url : ced_google_admin_obj.ajax_url,
				data : {
					ajax_nonce : ced_google_admin_obj.ajax_nonce,
					action : 'ced_connect_another_gmail_account_for_gads',
					store : data_prepration_for_create_user.store,
					email : data_prepration_for_create_user.email,
					framework : data_prepration_for_create_user.framework,
					on_boarding : 'false',
				},
				type : 'POST',
				datatype : 'json',
				success: function(response) {
					$('.ced_google_loader').hide();
						// response = jQuery.parseJSON( response );
						window.open( response );
						$('.ced_google_loader').show();

					}
				}
				);

			}*/

			je.preventDefault();
			var this_attribute                  = this;
			var during_gads                     = false;
			var data_prepration_for_create_user = fun_data_prepration_for_create_user( this_attribute, during_gads );
			if (data_prepration_for_create_user.ajax_condition == true) {
				ajax_call_for_create_user( this_attribute, during_gads ).then(
					(resp) => {
						if ( resp.status == 'success' ) {
							jQuery( '.ced_error_during_creating_account' ).hide();
							cedWgeiGetNewUserToken( resp.data, data_prepration_for_create_user.store, data_prepration_for_create_user.email, data_prepration_for_create_user.framework,'from_dashboard' );
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_creating_account' ).show();
						jQuery( '.ced_error_during_creating_account' ).text( 'Error during "Create" account - ' + resp.message );
						}
					}
				);
			}

		}
	);
	$( document ).on(
		'click touchstart',
		'#ced_signinwithgoogle_createuser',
		function(je){
			je.preventDefault();
			var this_attribute                  = this;
			var during_gads                     = false;
			var data_prepration_for_create_user = fun_data_prepration_for_create_user( this_attribute, during_gads );
			if (data_prepration_for_create_user.ajax_condition == true) {
				ajax_call_for_create_user( this_attribute, during_gads ).then(
					(resp) => {
						if ( resp.status == 'success' ) {
							jQuery( '.ced_error_during_creating_account' ).hide();
							cedWgeiGetNewUserToken( resp.data, data_prepration_for_create_user.store, data_prepration_for_create_user.email, data_prepration_for_create_user.framework );
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_creating_account' ).show();
						jQuery( '.ced_error_during_creating_account' ).text( 'Error during "Create" account - ' + resp.message );
						}
					}
				);
			}

		}
	);
	function cedWgeiGetNewUserToken(userData, userStore, userEmail, userFramework, from_dashboard = ''){
		var from_dashboard = from_dashboard;
		$( '.ced_google_loader' ).show();
		$.ajax(
			{
				url : ced_google_admin_obj.ajax_url,
				data : {
					ajax_nonce : ced_google_admin_obj.ajax_nonce,
					action : 'ced_google_get_user_token',
					user_data: userData,
				},
				type : 'POST',
				datatype : 'json',
				success: function(response){
					$( '.ced_google_loader' ).hide();
					response = jQuery.parseJSON( response );
					console.log( response );
					if (response.status == 'success') {
						jQuery( '.ced_error_during_creating_account' ).hide();
						cedWgeiCreateGoogleAccount( response.data.data.token, userData.username, userData.email, userFramework, from_dashboard )
					} else if (response.status == 'error') {
						jQuery( '.ced_error_during_creating_account' ).show();
						jQuery( '.ced_error_during_creating_account' ).text( 'Error during "Create" account - ' + response.message );

					}
				}
			}
		);

	}

	function cedWgeiCreateGoogleAccount(userToken, userStore, userEmail, userFramework, from_dashboard='') {
		var from_dashboard = from_dashboard;
		$( '.ced_google_loader' ).show();
		$.ajax(
			{
				url: ced_google_admin_obj.ajax_url,
				data : {
					ajax_nonce : ced_google_admin_obj.ajax_nonce,
					action : 'ced_google_authorisation',
					framework : userFramework,
					store : userStore,
					email : userEmail,
					user_token: userToken,
					from_dashboard : from_dashboard,
				},
				type : 'POST',
				datatype : 'json',
				success: function(response){
					$( '.ced_google_loader' ).hide();
					console.log( response.message );

					if ( response != 'error' ) {
						window.open( response );
						jQuery( '.ced_error_during_creating_account' ).hide();
					} else if (response.status == 'error') {
						console.log( response );
						jQuery( '.ced_error_during_creating_account' ).show();
						jQuery( '.ced_error_during_creating_account' ).text( 'Error during "Create" account - ' + response.message );

					}
				}

			}
		)
	}

	$( document ).on(
		'click touchstart',
		'.ced_google_merchant_nav',
		function(je){
			var current_content_id = $( this ).attr( 'data-id' );
			const cars             = new Array( "ced_google_accoount_content", "ced_google_merchantCenter_content", "ced_google_linkAddAccount_content", "ced_google_configuration_content", "ced_google_compaign_content" );
			for (let x in cars) {
				if (cars[x] == current_content_id) {
					$( '#' + cars[x] ).show();
					$( this ).addClass( 'active' );
				} else {
					$( '#' + cars[x] ).hide();
				}
			}
		}
	);
	$( document ).on(
		'click touchstart',
		'.ced_google_next_page_redirector',
		function(je){
			// je.preventDefault();
			$( '.ced_google_loader' ).show();
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_Save_And_ConnectGogoleAccount',
		function(je){
			if ($( '.ced_acceptTerm_checkbox_connectGoogleAccount' ).is( ":checked" )) {
				$( '.ced_SaveAndConnectGoogleAccount_acceptTerm_alert' ).hide();
				$( '.ced_acceptTerm_checkbox_connectGoogleAccount' ).css( 'border','' );
				$( '.ced_google_loader' ).show();
			} else {
				je.preventDefault();
				$( '.ced_SaveAndConnectGoogleAccount_acceptTerm_alert' ).show();
				$( '.ced_acceptTerm_checkbox_connectGoogleAccount' ).css( 'border','1px solid red' );
			}
		}
	);
	function data_prepraiton_for_create_gmc_accout() {
		var ajax               = true;
		var account_name       = $( '#ced-google-merachant-accountname' ).val();
		var framework          = 'woocommerce';
		var term_and_condiiton = true;
		var user_id            = $( '#ced-google-merachant-accountname' ).attr( 'data-user_id' );
		var ajax_checkbox      = false;
		var ajax_name          = false;
		if ($( '.ced_acceptTerm_checkbox_createGMCaccount' ).prop( "checked" ) == true) {
			console.log( "Checkbox is checked." );
			ajax_checkbox = true;
			$( '.ced_acceptTerm_checkbox_createGMCaccount' ).css( 'border','' );
			$( '.ced_show_error_nonselecet_gmc_create_account' ).hide();

		} else if ($( '.ced_acceptTerm_checkbox_createGMCaccount' ).prop( "checked" ) == false) {
			console.log( "Checkbox is unchecked." );
			ajax_checkbox = false;
			$( '.ced_SaveAndConnectGoogleAccount_acceptTerm_alert' ).show();
			$( '.ced_acceptTerm_checkbox_createGMCaccount' ).css( 'border','1px solid red' );
			$( '.ced_show_error_nonselecet_gmc_create_account' ).show();
		}
		if (account_name != null && account_name != '') {
			ajax_name = true;
			$( '#ced-google-merachant-accountname' ).css( 'border','' );
		} else {
			$( '#ced-google-merachant-accountname' ).css( 'border','1px solid red' );
			ajax_name = false;
		}
		var google_create_merchant_data = new Object();
		if (ajax_name == true && ajax_checkbox == true) {
			google_create_merchant_data['account_name']       = account_name;
			google_create_merchant_data['framework']          = framework;
			google_create_merchant_data['user_id']            = user_id;
			google_create_merchant_data['term_and_condiiton'] = term_and_condiiton;
			google_create_merchant_data['ajax_condition']     = true;
			return google_create_merchant_data;
		} else {
			google_create_merchant_data['ajax_condition'] = false;
			return google_create_merchant_data;
		}

	}

	function ajax_call_for_create_gmc_account() {
		var google_create_merchant_data = data_prepraiton_for_create_gmc_accout();
		console.log( google_create_merchant_data );
		if (google_create_merchant_data.ajax_condition == true) {
			$( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url : ced_google_admin_obj.ajax_url,
							data : {
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action : 'ced_Save_And_CreateGMCAccount',
								account_name : google_create_merchant_data.account_name,
								framework : google_create_merchant_data.framework,
								term_and_condiiton : google_create_merchant_data.term_and_condiiton,
								user_id : google_create_merchant_data.user_id,
							},
							type : 'POST',
							datatype : 'json',
							success: function(response) {
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								resolve( response );
							}
						}
					);
				}
			);
		}
	}
	$( document ).on(
		'click touchstart',
		'#ced_Save_And_CreateGMCAccount',
		function(je){
			je.preventDefault();
			var google_create_merchant_data = data_prepraiton_for_create_gmc_accout();
			console.log( google_create_merchant_data );

			if (google_create_merchant_data.ajax_condition == true) {
				ajax_call_for_create_gmc_account().then(
					(resp) => {
						if ( resp.status == 'success' ) {
							var redirect_url = resp.redirect_url + '&section=merchant-center&action=changegmc';
							window.location  = redirect_url;
						} else if (resp.status == 'error') {
						jQuery( '.ced_error_during_creation_merchant_account' ).show();
						jQuery( '.ced_error_during_creation_merchant_account' ).text( 'Error during creating "Merchant" account - ' + resp.message );
						}
					}
				);
			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_dash_Save_And_CreateGMCAccount',
		function(je){
			je.preventDefault();
			var google_create_merchant_data = data_prepraiton_for_create_gmc_accout();
			console.log( google_create_merchant_data );

			if (google_create_merchant_data.ajax_condition == true) {
				ajax_call_for_create_gmc_account().then(
					(resp) => {
						if ( resp.status == 'success' ) {
							var redirect_url = resp.redirect_url + '&section=dashboard&content=dash-reconnect';
							window.location  = redirect_url;
						} else if (resp.status == 'error') {
						jQuery( '.ced_error_during_creation_merchant_account' ).show();
						jQuery( '.ced_error_during_creation_merchant_account' ).text( 'Error during creating "Merchant" account - ' + response.message );
						}
					}
				);
			}
		}
	);

	function data_prepraiton_for_create_google_ads_account() {
		var google_create_googleads_data = new Object();
		if ($( '.ced_acceptTerm_checkbox_createGoogleAdsAccount' ).is( ":checked" )) {
			$( '.ced_show_error_nonselecet_ads_create_account' ).hide();
			$( '.ced_acceptTerm_checkbox_createGoogleAdsAccount' ).css( 'border','' );
			var accountName                                 = $( '#cedGoogleAccountName' ).val();
			var google_currency                             = jQuery( "#cedSelectGoogleAccountCurrency option:selected" ).val();
			var google_timezone                             = jQuery( "#cedSelectGoogleSupportedTimezone option:selected" ).val();
			google_create_googleads_data['accountName']     = accountName;
			google_create_googleads_data['google_currency'] = google_currency;
			google_create_googleads_data['google_timezone'] = google_timezone;
			google_create_googleads_data['ajax_condition']  = true;
			return google_create_googleads_data;
		} else {
			$( '.ced_acceptTerm_checkbox_createGoogleAdsAccount' ).css( 'border','1px solid red' );
			$( '.ced_show_error_nonselecet_ads_create_account' ).show();
			google_create_googleads_data['ajax_condition'] = false;
			return google_create_googleads_data;
		}

	}

	function ajax_call_for_create_google_ads_account() {
		var google_create_googleads_data = data_prepraiton_for_create_google_ads_account();
		console.log( google_create_googleads_data );
		if (google_create_googleads_data.ajax_condition == true) {

			$( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url: ced_google_admin_obj.ajax_url,
							data:{
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action: 'ced_Save_And_CreateGoogleAdsAccount',
								account_name: google_create_googleads_data.accountName,
								google_currency: google_create_googleads_data.google_currency,
								google_timezone: google_create_googleads_data.google_timezone
							},
							type : 'POST',
							datatype : 'json',
							success: function(response){
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								resolve( response );
							}
						}
					)
				}
			);
		}
	}

	$( document ).on(
		'click touchstart',
		'#ced_Save_And_CreateGoogleAdsAccount',
		function(je){
			je.preventDefault();
			var google_create_googleads_data = data_prepraiton_for_create_google_ads_account();
			console.log( google_create_googleads_data );
			if (google_create_googleads_data.ajax_condition == true) {
				ajax_call_for_create_google_ads_account().then(
					(resp) => {
						if ( resp.status == 'success' ) {
							console.log( resp );
							jQuery( '.ced_ads_creation_warpper' ).hide();
							jQuery( resp.html ).insertAfter( '.ced_ads_creation_warpper' );
							jQuery( '.ced_error_during_creation_adsaccount' ).hide();
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_creation_adsaccount' ).show();
						jQuery( '.ced_error_during_creation_adsaccount' ).text( 'Error during creating "Google Ads" account - ' + resp.message );
						}
					}
				);
			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_dash_Save_And_CreateGoogleAdsAccount',
		function(je){
			je.preventDefault();
			var google_create_googleads_data = data_prepraiton_for_create_google_ads_account();
			console.log( google_create_googleads_data );
			if (google_create_googleads_data.ajax_condition == true) {
				ajax_call_for_create_google_ads_account().then(
					(resp) => {
						if ( resp.status == 'success' ) {
							console.log( resp );
							jQuery( '.ced_ads_creation_warpper' ).hide();
							jQuery( resp.html ).insertAfter( '.ced_ads_creation_warpper' );
							jQuery( '.ced_error_during_creation_adsaccount' ).hide();
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_creation_adsaccount' ).show();
						jQuery( '.ced_error_during_creation_adsaccount' ).text( 'Error during creating "Google Ads" account - ' + resp.message );
						}
					}
				);
			}
		}
	);

	function data_prepraiton_for_set_gmc_account(){
		var data_google_set_gmc_account = new Object();
		var selected_gmc_account_value  = jQuery( "#ced_selected_gmc_account option:selected" ).val();
		var selected_gmc_account_text   = jQuery( "#ced_selected_gmc_account option:selected" ).text();
		if (selected_gmc_account_value == '' || selected_gmc_account_value == null) {
			$( '#ced_selected_gmc_account' ).css( 'border','1px solid red' );
			$( '.ced_show_error_nonselecet_gmc' ).show();
			data_google_set_gmc_account['ajax_condition'] = false;
			return data_google_set_gmc_account;
		} else {
			$( '.ced_show_error_nonselecet_gmc' ).hide();
			$( '#ced_selected_gmc_account' ).css( 'border','' );
			data_google_set_gmc_account['ajax_condition']             = true;
			data_google_set_gmc_account['selected_gmc_account_value'] = selected_gmc_account_value;
			data_google_set_gmc_account['selected_gmc_account_text']  = selected_gmc_account_text;
			return data_google_set_gmc_account;
		}
	}

	function ajax_call_for_set_gmc_account(){
		var data_google_set_gmc_account = data_prepraiton_for_set_gmc_account();
		if (data_google_set_gmc_account.ajax_condition == true) {
			$( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url: ced_google_admin_obj.ajax_url,
							data:{
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action: 'ced_connect_gmc_account',
								selected_gmc_account_value: data_google_set_gmc_account.selected_gmc_account_value,
								selected_gmc_account_text: data_google_set_gmc_account.selected_gmc_account_text,
							},
							type : 'POST',
							datatype : 'json',
							success: function(response){
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								console.log( response );
								resolve( response );

							}
						}
					)
				}
			);
		}

	}
	function ajax_call_for_set_gmc_account_dash(){
		var data_google_set_gmc_account = data_prepraiton_for_set_gmc_account();
		if (data_google_set_gmc_account.ajax_condition == true) {
			$( '#ced_dash_connect_gmc_account' ).siblings( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url: ced_google_admin_obj.ajax_url,
							data:{
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action: 'ced_connect_gmc_account',
								selected_gmc_account_value: data_google_set_gmc_account.selected_gmc_account_value,
								selected_gmc_account_text: data_google_set_gmc_account.selected_gmc_account_text,
								from_dash : 'from_dash',
							},
							type : 'POST',
							datatype : 'json',
							success: function(response){
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								console.log( response );
								resolve( response );

							}
						}
					)
				}
			);
		}

	}

	$( document ).on(
		'click touchstart',
		'#ced_connect_gmc_account',
		function(je){
			je.preventDefault();
			var data_google_set_gmc_account = data_prepraiton_for_set_gmc_account();
			if (data_google_set_gmc_account.ajax_condition == true) {
				ajax_call_for_set_gmc_account().then(
					(resp) => {
						if (resp.status == 'Success') {
							var redirect_url = resp.redirect_url + '&section=merchant-center';
							window.location  = redirect_url;
							console.log( resp );
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_set_gmc_account' ).show();
						jQuery( '.ced_error_during_set_gmc_account' ).text( 'Error during connect "Merchant" account - ' + resp.message );
						}
					}
				);
			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_dash_connect_gmc_account',
		function(je){
			je.preventDefault();
			var data_google_set_gmc_account = data_prepraiton_for_set_gmc_account();
			if (data_google_set_gmc_account.ajax_condition == true) {
				ajax_call_for_set_gmc_account_dash().then(
					(resp) => {
						if (resp.status == 'Success') {
							/*var redirect_url = resp.redirect_url+'&section=merchant-center';
							window.location = redirect_url;*/
							console.log( resp );
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_set_gmc_account' ).show();
						jQuery( '.ced_error_during_set_gmc_account' ).text( 'Error during connect "Merchant" account - ' + resp.message );
						}
					}
				);
			}
		}
	);
	function data_prepraiton_for_set_googleAds_account(){
		var data_google_set_googleAds_account = new Object();
		var selected_ads_account_value        = jQuery( "#ced_selected_ads_account option:selected" ).val();
		var selected_ads_account_text         = jQuery( "#ced_selected_ads_account option:selected" ).text();
		if (selected_ads_account_value == '' || selected_ads_account_value == null) {
			$( '#ced_selected_ads_account' ).css( 'border','1px solid red' );
			$( '.ced_show_error_nonselecet_ads' ).show();
			data_google_set_googleAds_account['ajax_condition'] = false;
			return data_google_set_googleAds_account;
		} else {
			$( '#ced_selected_ads_account' ).css( 'border','' );
			$( '.ced_show_error_nonselecet_ads' ).hide();
			data_google_set_googleAds_account['ajax_condition']             = true;
			data_google_set_googleAds_account['selected_ads_account_value'] = selected_ads_account_value;
			data_google_set_googleAds_account['selected_ads_account_text']  = selected_ads_account_text;
			return data_google_set_googleAds_account;
		}
	}
	function ajax_call_for_set_googleAds_account(){
		var data_google_set_googleAds_account = data_prepraiton_for_set_googleAds_account();
		if (data_google_set_googleAds_account.ajax_condition == true) {
			$( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url: ced_google_admin_obj.ajax_url,
							data:{
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action: 'ced_connect_ads_account',
								selected_ads_account_value: data_google_set_googleAds_account.selected_ads_account_value,
								selected_ads_account_text: data_google_set_googleAds_account.selected_ads_account_text,
							},
							type : 'POST',
							datatype : 'json',
							success: function(response){
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								resolve( response );

							}
						}
					)
				}
			);
		}
	}
	function ajax_call_for_set_googleAds_account_dash(){
		var data_google_set_googleAds_account = data_prepraiton_for_set_googleAds_account();
		if (data_google_set_googleAds_account.ajax_condition == true) {
			$( '#ced_dash_connect_ads_account' ).siblings( '.ced_google_loader' ).show();
			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url: ced_google_admin_obj.ajax_url,
							data:{
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action: 'ced_connect_ads_account',
								selected_ads_account_value: data_google_set_googleAds_account.selected_ads_account_value,
								selected_ads_account_text: data_google_set_googleAds_account.selected_ads_account_text,
								from_dash : 'from_dash',
							},
							type : 'POST',
							datatype : 'json',
							success: function(response){
								$( '.ced_google_loader' ).hide();
								response = jQuery.parseJSON( response );
								resolve( response );

							}
						}
					)
				}
			);
		}
	}
	$( document ).on(
		'click touchstart',
		'#ced_connect_ads_account',
		function(je){
			je.preventDefault();
			var data_google_set_googleAds_account = data_prepraiton_for_set_googleAds_account();
			if (data_google_set_googleAds_account.ajax_condition == true) {
				ajax_call_for_set_googleAds_account().then(
					(resp) => {
					console.log( resp );
						if (resp.status == 'Success') {
							var redirect_url = resp.redirect_url + '&section=ads-setting';
							window.location  = redirect_url;
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_set_ads_account' ).show();
						jQuery( '.ced_error_during_set_ads_account' ).text( 'Error during connect "Ads - " account - ' + resp.message );
						}
					}
				);
			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_dash_connect_ads_account',
		function(je){
			je.preventDefault();
			var data_google_set_googleAds_account = data_prepraiton_for_set_googleAds_account();
			if (data_google_set_googleAds_account.ajax_condition == true) {
				ajax_call_for_set_googleAds_account_dash().then(
					(resp) => {
					console.log( resp );
						if (resp.status == 'Success') {
							var redirect_url = resp.redirect_url + '&section=dashboard&content=dash-reconnect';
							window.location  = redirect_url;
						} else if (resp.status == 'error') {
						console.log( resp.message );
						jQuery( '.ced_error_during_set_ads_account' ).show();
						jQuery( '.ced_error_during_set_ads_account' ).text( 'Error during connect "Ads - " account - ' + resp.message );
						}
					}
				);
			}
		}
	);

	function data_prepration_for_save_config_details(){
		const error = [];
		// error.push("true");
		var ced_selected_config_language         = jQuery( "#ced_selected_config_language" ).val();
		var ced_selected_config_country          = jQuery( "#ced_selected_config_country" ).val();
		var ced_selected_config_currency         = jQuery( "#ced_selected_config_currency" ).val();
		var ced_selected_config_gender           = jQuery( "#ced_selected_config_gender" ).val();
		var ced_selected_config_agegroup         = jQuery( "#ced_selected_config_agegroup" ).val();
		var ced_selected_include_destination     = jQuery( "#ced_selected_include_destination" ).val();
		var ced_selected_brand_dropdown_value    = jQuery( "#google_brand_attibuteMeta" ).val();
		var ced_selected_brand_input_filed_value = jQuery( "#ced_google_shopping_brand" ).val();
		var ced_selected_mpn_dropdown_value      = jQuery( "#google_mpn_attibuteMeta" ).val();
		var ced_selected_gtin_dropdown_value     = jQuery( "#google_gtin_attibuteMeta" ).val();
		if ($( "input[type='radio'].ced_google_product_needs_to_submit" ).is( ':checked' )) {
			var products_needs_to_submit = $( "input[type='radio'].ced_google_product_needs_to_submit:checked" ).val();
			if (products_needs_to_submit == 'Products from a collection') {
				products_needs_to_submit = jQuery( '#ced_cat_select' ).val();
			}
		}
		if ($( "input[type='radio'].ced_google_product_variation_preference" ).is( ':checked' )) {
			var product_variation_preference = $( "input[type='radio'].ced_google_product_variation_preference:checked" ).val();
		}
		if (ced_selected_config_language == '' || ced_selected_config_language == null ) {
			error.push( "true" );
			$( '#ced_selected_config_language' ).css( 'border','1px solid red' );
		} else {
			error.push( "false" );
			$( '#ced_selected_config_language' ).css( 'border','' );
		}
		if (ced_selected_config_country == '' || ced_selected_config_country == null ) {
			error.push( "true" );
			$( '#ced_selected_config_country' ).css( 'border','1px solid red' );
		} else {
			error.push( "false" );
			$( '#ced_selected_config_country' ).css( 'border','' );
		}
		if (ced_selected_config_currency == '' || ced_selected_config_currency == null ) {
			error.push( "true" );
			$( '#ced_selected_config_currency' ).css( 'border','1px solid red' );
		} else {
			error.push( "false" );
			$( '#ced_selected_config_currency' ).css( 'border','' );
		}
		if (ced_selected_config_gender == '' || ced_selected_config_gender == null ) {
			error.push( "true" );
			$( '#ced_selected_config_gender' ).css( 'border','1px solid red' );
		} else {
			error.push( "false" );
			$( '#ced_selected_config_gender' ).css( 'border','' );
		}
		if (ced_selected_config_agegroup == '' || ced_selected_config_agegroup == null ) {
			error.push( "true" );
			$( '#ced_selected_config_agegroup' ).css( 'border','1px solid red' );
		} else {
			error.push( "false" );
			$( '#ced_selected_config_agegroup' ).css( 'border','' );
		}

		var data_array = new Object();
		if ( ! error.includes( 'true' )) {
			data_array['ced_selected_config_language']         = ced_selected_config_language;
			data_array['ced_selected_config_country']          = ced_selected_config_country;
			data_array['ced_selected_config_currency']         = ced_selected_config_currency;
			data_array['ced_selected_config_gender']           = ced_selected_config_gender;
			data_array['ced_selected_config_agegroup']         = ced_selected_config_agegroup;
			data_array['products_needs_to_submit']             = products_needs_to_submit;
			data_array['product_variation_preference']         = product_variation_preference;
			data_array['ced_selected_include_destination']     = ced_selected_include_destination;
			data_array['ced_selected_brand_dropdown_value']    = ced_selected_brand_dropdown_value;
			data_array['ced_selected_brand_input_filed_value'] = ced_selected_brand_input_filed_value;
			data_array['ced_selected_mpn_dropdown_value']      = ced_selected_mpn_dropdown_value;
			data_array['ced_selected_gtin_dropdown_value']     = ced_selected_gtin_dropdown_value;
			data_array['ajax_condition']                       = true;
			return data_array;
		} else {

			data_array['ajax_condition'] = false;
			return data_array;

		}
	}

	function ajax_call_for_save_config_details(){
		return new Promise(
			(resolve) => {
			var data_array = data_prepration_for_save_config_details();
			$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_save_account_config_content',
							ced_selected_config_language: data_array.ced_selected_config_language,
							ced_selected_config_country: data_array.ced_selected_config_country,
							ced_selected_config_currency: data_array.ced_selected_config_currency,
							ced_selected_config_gender: data_array.ced_selected_config_gender,
							ced_selected_config_agegroup: data_array.ced_selected_config_agegroup,
							products_needs_to_submit: data_array.products_needs_to_submit,
							product_variation_preference: data_array.product_variation_preference,
							ced_selected_include_destination: data_array.ced_selected_include_destination,
							ced_selected_brand_dropdown_value: data_array.ced_selected_brand_dropdown_value,
							ced_selected_brand_input_filed_value: data_array.ced_selected_brand_input_filed_value,
							ced_selected_mpn_dropdown_value: data_array.ced_selected_mpn_dropdown_value,
							ced_selected_gtin_dropdown_value: data_array.ced_selected_gtin_dropdown_value,

						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							response = jQuery.parseJSON( response );
							resolve( response );
						}
					}
				)
			}
		);
	}

	$( document ).on(
		'click touchstart',
		'#ced_save_account_config_content',
		function(je){
			je.preventDefault();
			var data_array = data_prepration_for_save_config_details();
			if (data_array.ajax_condition == true) {
				ajax_call_for_save_config_details().then(
					(resp) => {
					console.log( resp );
					var redirect_url = resp.redirect_url + '&section=compaign&step=5';
					console.log( redirect_url );
					window.location = redirect_url;
					}
				);
			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_dash_save_account_config_content',
		function(je){
			je.preventDefault();
			var data_array = data_prepration_for_save_config_details();
			if (data_array.ajax_condition == true) {
				ajax_call_for_save_config_details().then(
					(resp) => {
					console.log( resp );
					/*var redirect_url = resp.redirect_url+'&section=compaign';
						console.log(redirect_url);
						window.location = redirect_url;*/
					}
				);
			}
		}
	);

	$( document ).ready(
		function(){
			$( "body" ).addClass( "ced__Sidebar--expanded" );
			$( "#googleSelectCampaignCity" ).hide();
			$( document ).on(
				'click touchstart',
				'.ced-cam-radio',
				function(je){
					if ($( '#ced_select_another_location' ).is( ':checked' )) {
						$( "#googleSelectCampaignCity" ).show();
						$( "#googleSelectCampaignCity" ).find( 'input' ).attr( 'required', true );
					} else {
						$( "#googleSelectCampaignCity" ).hide();
						$( "#googleSelectCampaignCity" ).find( 'input' ).attr( 'required', false );
					}
				}
			);
			if (false != ced_google_admin_obj.user_access_token) {
				var access_token = ced_google_admin_obj.user_access_token['data']['token'];

			}

			function split( val ) {
				return val.split( /,\s*/ );
			}
			function extractLast( term ) {
				return split( term ).pop();
			}

			$( "#campaignSelectCity" )
			.on(
				"keydown",
				function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).autocomplete( "instance" ).menu.active ) {
						event.preventDefault();
					}
				}
			)
			.autocomplete(
				{
					source: function( request, response ) {
						var search_term  = request.term.split( "," );
						var searchLength = search_term.length;
						console.log( search_term[searchLength - 1] );
						var jsonData = {
							search_text: jQuery.trim( search_term[searchLength - 1] ),
							fetch_all: false,
						}
						$.ajax(
							{
								headers: {
									'Authorization': 'Bearer ' + access_token,
								},
								type:'POST',
								url: 'https://express.sellernext.com/googleads/main/getLocations',
								dataType: "json",
								data: JSON.stringify( jsonData ),
								contentType: "application/json",
								success: function(data){
									console.log( data );
									response(
										$.map(
											data.data,
											function(item){
												return {
													label: item['Canonical Name'],
													value: item['Criteria ID']
												};
											}
										)
									)
								}
							}
						);
					},
					minLength:3,
					search: function() {
						var term = extractLast( this.value );
						if ( term.length < 2 ) {
							return false;
						}
					},
					focus: function() {
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.label );
						$( "<input>" ).attr(
							{
								name: "selectedGoogleCampaignLocation",
								class: "selectedGoogleCampaignLocation",
								type: "hidden",
								value : ui.item.value
							}
						).appendTo( $( "#googleSelectCampaignCity" ) );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					},

				}
			);

			// function split( val ) {
			// return val.split( /,\s*/ );
			// }
			// function extractLast( term ) {
			// return split( term ).pop();
			// }

			$( "#campaignSelectCity_update_campaign" )
			.on(
				"keydown",
				function( event ) {
					if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).autocomplete( "instance" ).menu.active ) {
						event.preventDefault();
					}
				}
			)
			.autocomplete(
				{
					source: function( request, response ) {
						// var search_term  = request.term;
						var search_term  = request.term.split( "," );
						var searchLength = search_term.length;
						console.log( search_term[searchLength - 1] );
						var jsonData = {
							search_text: jQuery.trim( search_term[searchLength - 1] ),
							fetch_all: false,
						}
						$.ajax(
							{
								headers: {
									'Authorization': 'Bearer ' + access_token,
								},
								type:'POST',
								url: 'https://express.sellernext.com/googleads/main/getLocations',
								dataType: "json",
								data: JSON.stringify( jsonData ),
								contentType: "application/json",
								success: function(data){
									console.log( data );
									response(
										$.map(
											data.data,
											function(item){
												return {
													label: item['Canonical Name'],
													value: item['Criteria ID']
												};
											}
										)
									)
								}
							}
						);
					},
					minLength:3,
					search: function() {
						var term = extractLast( this.value );
						if ( term.length < 2 ) {
							return false;
						}
					},
					focus: function() {
						return false;
					},
					select: function( event, ui ) {
						$( '.ced_during_location_error' ).hide();
						var html = '<div class="ced_pre_selcted_compaign_location" data-campaign_loca_val=' + ui.item.value + '>' + ui.item.label + '<span class="ced_remove_selected_campaign_location">x</span></div>';
						// $( html ).insertAfter( $( ".ced_pre_selcted_compaign_location" ) );
						$( ".selected_campaign_loc_wrapper" ).append( html );
						setTimeout(
							function() {
								$( '#campaignSelectCity_update_campaign' ).val( '' );
							},
							220
						); // After 420 ms
						/*              var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.label );
						$( "<input>" ).attr(
						{
						name: "selectedGoogleCampaignLocation",
						class: "selectedGoogleCampaignLocation",
						type: "hidden",
						value : ui.item.value
						}
						).appendTo( $( "#ced_googleSelectCampaignCity_update_campaign" ) );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;*/
					},

				}
			);
		}
	);

	function data_prepration_for_create_compaign(){
		var ced_compaign_name       = $( "#ced_compaign_name" ).val();
		var ced_compaign_budget     = $( "#ced_compaign_budget" ).val();
		var campaign_location_array = [];
		if ($( "#ced_select_another_location" ).is( ":checked" )) {
			$( ".selectedGoogleCampaignLocation" ).each(
				function(){
					var criteria_id = $( this ).val();
					campaign_location_array.push( criteria_id );
				}
			);
		}
		if ($( "input[type='radio'].ced_compaign_location" ).is( ':checked' )) {
			var compaign_location = $( "input[type='radio'].ced_compaign_location:checked" ).val();
		}
		var ced_dash_campaign_start_date                          = $( '#ced_dash_campaign_start_date' ).val();
		var ced_dash_campaign_end_date                            = $( '#ced_dash_campaign_end_date' ).val();
		var ced_dash_campaign_roas_amount                         = $( '#ced_dash_campaign_roas_amount' ).val();
		var data_for_create_compaign                              = new Object();
		data_for_create_compaign['ced_compaign_name']             = ced_compaign_name;
		data_for_create_compaign['ced_compaign_budget']           = ced_compaign_budget;
		data_for_create_compaign['campaign_location_array']       = campaign_location_array;
		data_for_create_compaign['compaign_location']             = compaign_location;
		data_for_create_compaign['ced_dash_campaign_start_date']  = ced_dash_campaign_start_date;
		data_for_create_compaign['ced_dash_campaign_end_date']    = ced_dash_campaign_end_date;
		data_for_create_compaign['ced_dash_campaign_roas_amount'] = ced_dash_campaign_roas_amount;
		data_for_create_compaign['ajax_condition']                = true;
		return data_for_create_compaign;
	}
	function ajax_call_for_create_compaign() {
		var data_for_create_compaign = data_prepration_for_create_compaign();
		if (data_for_create_compaign.ajax_condition == true) {
			$( '.ced_google_loader' ).show();
			$( '.ced_google_shopping_loader' ).show();
			$( this ).siblings( '.ced_google_shopping_loader' ).show();

			return new Promise(
				(resolve) => {
				$.ajax(
						{
							url: ced_google_admin_obj.ajax_url,
							data: {
								ajax_nonce : ced_google_admin_obj.ajax_nonce,
								action: 'ced_save_and_create_compaign',
								ced_compaign_name: data_for_create_compaign.ced_compaign_name,
								ced_compaign_budget: data_for_create_compaign.ced_compaign_budget,
								campaign_location_array: data_for_create_compaign.campaign_location_array,
								compaign_location: data_for_create_compaign.compaign_location,
								ced_dash_campaign_start_date: data_for_create_compaign.ced_dash_campaign_start_date,
								ced_dash_campaign_end_date: data_for_create_compaign.ced_dash_campaign_end_date,
								ced_dash_campaign_roas_amount: data_for_create_compaign.ced_dash_campaign_roas_amount,
							},
							type:'post',
							success: function(response){
								$( '.ced_google_loader' ).hide();
								$( '.ced_google_shopping_loader' ).hide();
								response = jQuery.parseJSON( response );
								resolve( response );
							}
						}
					)
				}
			);
		}

	}
	$( document ).on(
		'click touchstart',
		'#ced_save_and_create_compaign',
		function(je){
			je.preventDefault();
			var data_for_create_compaign = data_prepration_for_create_compaign();
			if (data_for_create_compaign.ajax_condition == true) {
				ajax_call_for_create_compaign().then(
					(resp) => {
					console.log( resp );
						if (resp.status == 'error') {
							console.log( resp );
							jQuery( '.ced_error_during_creating_compaign' ).show();
							jQuery( '.ced_error_during_creating_compaign' ).text( 'Error during "Create" compaign - ' + resp.message );

						} else if (resp.status == 'success') {
						console.log( resp );
						var redirect_url = resp.redirect_url + '&section=onboard';
						window.location  = redirect_url;
						}
					}
				);

			}
		}
	);

	$( document ).on(
		'click touchstart',
		'#ced_dash_save_and_create_compaign',
		function(je){
			je.preventDefault();
			var data_for_create_compaign = data_prepration_for_create_compaign();
			if (data_for_create_compaign.ajax_condition == true) {
				ajax_call_for_create_compaign().then(
					(resp) => {
					console.log( resp );
						if (resp.status == 'error') {
							console.log( resp );
							jQuery( '.ced_error_during_creating_compaign' ).show();
							jQuery( '.ced_error_during_creating_compaign' ).text( 'Error during "Create" compaign - ' + resp.message );

						} else if (resp.status == 'success') {
						console.log( resp );
						}
					}
				);
			}
		}
	)
	$( document ).on(
		'click touchstart',
		'#ced_create_pmax_campaign',
		function(je){
			je.preventDefault();
			var data_for_create_compaign = data_prepration_for_create_compaign();
			if (data_for_create_compaign.ajax_condition == true) {
				ajax_call_for_create_compaign().then(
					(resp) => {
					console.log( resp );
						if (resp.status == 'error') {
							console.log( resp );
							jQuery( '.ced_error_during_creating_compaign' ).show();
							jQuery( '.ced_error_during_creating_compaign' ).text( 'Error during "Create" compaign - ' + resp.message );

						} else if (resp.status == 'success') {
						jQuery( '.ced_show_response_messages' ).show();
						jQuery( '.ced_show_response_messages' ).text( 'Response - ' + resp.message );
						window.location.reload();
						console.log( resp );
						}
					}
				);
			}
		}
	)
	$( document ).on(
		'click touchstart',
		'.google_connector_refresh_icon',
		function(je){
			je.preventDefault();
			window.location.reload();
		}
	)
	jQuery( document ).ready(
		function(){

				// $("body").toggleClass("ced__Sidebar--expanded");
			jQuery( '.ced_cat_select' ).select2();
			jQuery( ".ced_cat_select" ).select2(
				{
					width: 'resolve'
				}
			);
			// jQuery('.ced_selected_include_destination').select2();
			jQuery( "#ced_selected_include_destination" ).select2(
				{
					width: 'resolve'
				}
			);
			// JS FOR DASHBOARD SECTION
			$( "#ced__Sidebar" ).click(
				function(){
					$( "body" ).toggleClass( "ced__Sidebar--expanded" );
				}
			);
			const hamburger = document.querySelector( ".ced__Toggle " );
			const navMenu   = document.querySelector( ".ced__Sidebar" );

			// hamburger.addEventListener("click", mobileMenu);
			function mobileMenu() {
				hamburger.classList.toggle( "ced__toggle--Active" );
				navMenu.classList.toggle( "ced__Sidebar--Active" );
			}
			const accordion = document.getElementsByClassName( 'ced-acco-container' );
			var i           = 0;
			for (i = 0; i < accordion.length; i++) {
				accordion[i].addEventListener(
					'click',
					function () {
						this.classList.toggle( 'active' )
					}
				)
			}
		}
	)
	$( document ).on(
		'change',
		'#ced_google_shopping_list_per_page' ,
		function() {
			var per_page = $( this ).val();
			$( '.ced_google_shopping_loader' ).show();
			$.ajax(
				{
					url : ced_google_admin_obj.ajax_url,
					data : {
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action : 'ced_google_shopping_list_per_page',
						per_page : per_page,
					},
					type : 'POST',
					success: function( response ) {
						window.location.reload();
					}
				}
			);

		}
	);

	$( document ).on(
		'click',
		'.ced_dash_edit_enable_disable_button' ,
		function() {
			var need_to_show = $( this ).attr( 'data-need_to_show' );
			$( '.' + need_to_show ).toggle();
		}
	);

	$( document ).on(
		'click',
		'#ced_google_shopping_bulk_operation',
			function(e){
				e.preventDefault();
				$( '.ced_google_shopping_loader' ).show();
				var operation = $( '.bulk-action-selector' ).val();
				if (operation <= 0 ) {
					let message = 'Please select any bulk operation.';
					let status  = 400;
					$( '.ced_google_shopping_loader' ).hide();
					ced_google_shopping_display_notice( message,status );
					return false;
				} else {
					var operation                    = $( '.bulk-action-selector' ).val();
					var google_shopping_products_ids = new Array();
					$( '.google_shopping_products_id:checked' ).each(
					function(){
						google_shopping_products_ids.push( $( this ).val() );
					}
					);
					perform_bulk_action( google_shopping_products_ids,operation );
				}

			}
	);

	function perform_bulk_action(google_shopping_products_ids,operation) {
		if (google_shopping_products_ids == '') {
			$( '.ced_google_shopping_loader' ).hide();
			let message = 'Please select any products.';
			let status  = 400;
			ced_google_shopping_display_notice( message,status );
			return false;
		}
		$.ajax(
			{
				url : ced_google_admin_obj.ajax_url,
				data : {
					ajax_nonce : ced_google_admin_obj.ajax_nonce,
					action : 'ced_good_shopping_process_bulk_action',
					operation : operation,
					google_shopping_products_ids : google_shopping_products_ids,
				},
				type : 'POST',
				success: function(response)
				{
						console.log( response );
						$( '.ced_google_shopping_loader' ).hide();
						var parsed_response = jQuery.parseJSON( response );
						// if(parsed_response.status == 'success') {
						var message = parsed_response.message;
						// }
						var status = 200;
						ced_google_shopping_display_notice( message , status );
				}
			}
		);
	}

	/*-------------------Display Notices-----------------------*/
	function ced_google_shopping_display_notice( message = '' , status = 200){
		if ( status == 400 ) {
			var classes = 'notice-error';
		} else {
			var classes = 'notice-success';
		}
		var notice = '';
		notice    += '<div class="notice ' + classes + ' ced_google_shopping_notices_content">';
		notice    += '<p>' + message + '</p>';
		notice    += '</div>';
		scroll_at_top();
		$( '.ced_google_shopping_notice_era' ).after( notice );
		if (status != 400) {

			window.setTimeout( function(){window.location.reload()}, 4000 );
		}
	}

	function scroll_at_top() {
		$( "html, body" ).animate(
			{
				scrollTop: 0
			},
			600
		);
	}

	$( document ).on(
		'click touchstart',
		'#ced_skip_google_connect_ads_account',
		function(je){
			je.preventDefault();
			$( '.ced_google_loader' ).show();
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_skip_connect_ads_account',
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_loader' ).hide();
						response = jQuery.parseJSON( response );
						if (response.status == 'Success') {
							var redirect_url = response.redirect_url + '&section=configuration&step=4';
							window.location  = redirect_url;
							console.log( response );
						} else if (response.status == 'error') {
							console.log( response.message );
							jQuery( '.ced_error_during_set_gmc_account' ).show();
							jQuery( '.ced_error_during_set_gmc_account' ).text( 'Error during connect "Merchant" account - ' + resp.message );
						}
					}
				}
			)

		}
	);

	$( document ).on(
		'click touchstart',
		'.ced_google_reset_connected_account',
		function(je){
			je.preventDefault();
			let confirmAction = confirm( "Are you sure you want to reset the onboarding setting.." );
			if (confirmAction) {

				$( '.ced_google_loader' ).show();
				$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_google_reset_connected_account',
						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							$( '.ced_google_loader' ).hide();
							response = jQuery.parseJSON( response );
							if (response.status == 'success') {
								var redirect_url = response.redirect_url;
								window.location  = redirect_url;
								console.log( response );
							}
						}
					}
				)
			}

		}
	);
	jQuery( document ).on(
		'click',
		'.ced_google_onboarding_skip',
		function(je){
			je.preventDefault();
			$( '.ced_google_loader' ).show();
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_google_onboarding_skip',
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_loader' ).hide();
						response = jQuery.parseJSON( response );
						if (response.status == 'Success') {
							var redirect_url = response.redirect_url + '&section=onboard';
							window.location  = redirect_url;
						}
					}
				}
			)

		}
	);
jQuery( document ).on(
		'click',
		'.ced_save_google_product_automate',
			function(je){
				je.preventDefault();
				$( this ).siblings( '.ced_google_shopping_loader' ).show();
				var product_sync          = 'off';
				var existing_product_sync = 'off';
				var instant_product_sync = 'off';
				if ($( '#ced_google_shopping_enable_product_syncing' ).is( ":checked" )) {
					product_sync = 'on';
				}
				if ($( '#ced_google_shopping_enable_existing_product_syncing' ).is( ":checked" )) {
					existing_product_sync = 'on';
				}
				if ($( '#ced_google_shopping_enable_instant_product_syncing' ).is( ":checked" )) {
					instant_product_sync = 'on';
				}
				// alert(existing_product_sync_enable);
				$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_google_save_product_automate_setting',
						product_sync : product_sync,
						existing_product_sync : existing_product_sync,
						instant_product_sync : instant_product_sync,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						if (response.status == 'success') {
							$( '.ced_success_msg' ).remove();
							jQuery( '<span class="ced_success_msg">Product Automate setting saved successfully. </span>' ).insertAfter( '.ced_save_google_product_automate' );
						}
					}
					}
				)

			}
	);
	jQuery( document ).on(
		'click',
		'.ced-cancel',
		function(){
			jQuery( '.ced_google_shopping_popup' ).hide();
		}
	);

	jQuery( document ).on(
		'click',
		'.google_shopping_help_video_modal_close_icon',
		function(je){
			var redirect_url     = String( document.location.href ).replace( /#video-bck/, "" );
			window.location.href = redirect_url;

		}
	);

	/*jQuery( document ).on('click touchstart','.ced-tablink',function(je){
		je.preventDefault();
		$('.ced-tablink').removeClass('active_gads_section');

		$(this).addClass('active_gads_section');
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("ced-tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}

		var current_page = $(this).data("openpage");
		$('#'+current_page).show();
	}); */
	jQuery( document ).on(
		'click touchstart',
		'#ced_dash_gmc_unlink',
		function(je){
			je.preventDefault();
			$( '.ced_google_shopping_loader' ).show();
			var current_service_linkid = $( this ).data( "linkid" );
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_dash_gmc_unlink',
						current_service_linkid : current_service_linkid,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						window.location.reload();
						console.log( response );
						/*if (response.status == 'success') {
						jQuery(response.message).insertAfter('.ced_save_google_product_automate');
						}*/
					}
				}
			)

		}
	);

	jQuery( document ).on(
		'click touchstart',
		'#ced_edit_campaign',
		function(je){
			/*je.preventDefault();
			$('#edit_campaigns').attr('visibility':'unset');*/
			console.log( 'df' );
			var campaign_budget_id = $( this ).data( "budgetid" );
			var campaign_id        = $( this ).data( "campaign_id" );
			var campaign_name      = $( this ).data( "campaign_name" );
			var campaign_budget    = $( this ).data( "campaign_budget" );
			$( '.ced_dash_update_campaign_edit_location_content' ).hide();
			$( '#ced_compaign_submited_name' ).val( campaign_name );
			$( '#ced_compaign_submited_budget' ).val( campaign_budget );
			$( '.ced_dash_update_campaign_edit_location' ).attr( {"data-campaign_budget_id":campaign_budget_id,"data-campaign_id":campaign_id} ); // setter
			$( '.ced_update_gmax_campaign' ).attr( {"data-campaign_budget_id":campaign_budget_id,"data-campaign_id":campaign_id} ); // setter

		}
	);

	jQuery( document ).on(
		'click',
		'.ced_dash_update_campaign_edit_location',
		function(je){
			je.preventDefault();
			$( ".ced_dash_update_campaign_edit_location_content" ).children().prop( 'disabled',true );
			let campaign_budget_id      = $( this ).attr( "data-campaign_budget_id" );
			let campaign_id_during_edit = $( this ).attr( "data-campaign_id" );
			$( this ).siblings( '.ced_google_shopping_loader' ).show();
			$( '.ced_dash_update_campaign_edit_location_content' ).show();
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_dash_get_campaign_location',
						campaign_id : campaign_id_during_edit,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						// $('.ced_google_shopping_loader').hide();
						response        = jQuery.parseJSON( response );
						const locations = response.message;
						var html        = '<div class="selected_campaign_loc_wrapper">';
						if (locations != null && locations != '') {
							$( '.ced_during_location_error' ).hide();
							for (let i = 0; i < locations.length; i++) {
								var location_val   = locations[i][0]; // here i represents index
								var location_value = location_val.split( '-' )[0];
								var location_name  = location_val.split( '-' )[1];
								html              += '<div class="ced_pre_selcted_compaign_location" data-campaign_loca_val=' + location_value + '>' + location_name + '<span class="ced_remove_selected_campaign_location">x</span></div>';
							}
						} else {
							html += '<div class="ced_during_location_error">No location are selceted here - </div>';

						}
						html += '</div>';

						$( html ).insertAfter( $( "#ced_googleSelectCampaignCity_update_campaign" ) );
						console.log( html );
						$( '.ced_google_shopping_loader' ).hide();
						$( ".ced_dash_update_campaign_edit_location_content" ).children().prop( 'disabled',false );
					}
				}
			)

		}
	);

	jQuery( document ).on(
		'click',
		'.ced_update_gmax_campaign',
		function(je){
			je.preventDefault();
			$( this ).siblings( '.ced_google_shopping_loader' ).show();

			// $('.ced_google_shopping_loader').show();
			let campaign_budget_id           = $( this ).attr( "data-campaign_budget_id" );
			let campaign_id_during_edit      = $( this ).attr( "data-campaign_id" );
			var ced_compaign_submited_name   = $( '#ced_compaign_submited_name' ).val();
			var ced_compaign_submited_budget = $( '#ced_compaign_submited_budget' ).val();
			var campaign_location_array      = [];
			$( ".ced_pre_selcted_compaign_location" ).each(
				function(){
					var criteria_id = $( this ).attr( "data-campaign_loca_val" );
					campaign_location_array.push( criteria_id );
				}
			);
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_update_gmax_campaign',
						campaign_submited_name : ced_compaign_submited_name,
						campaign_submited_budget : ced_compaign_submited_budget,
						campaign_location_array : campaign_location_array,
						campaign_id_during_edit : campaign_id_during_edit,
						campaign_budget_id_during_edit : campaign_budget_id,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response         = jQuery.parseJSON( response );
						var redirect_url = response.redirect_url;
						window.location  = redirect_url;
						console.log( response );
					}
				}
			);
		}
	);
	jQuery( document ).on(
		'change',
		'.ced_set_campaign_status',
		function(je){
			je.preventDefault();
			var campaign_id = $( this ).data( "campaign_id" );
			var status      = '';
			if ($( this ).is( ":checked" )) {
				status = 'ENABLED';
			} else {
				status = 'PAUSED';
			}
			// $(this).siblings('.ced_google_shopping_loader').show();
			$( this ).parent().siblings( ".ced_google_shopping_loader" ).show();
			// $('.ced_google_shopping_loader').show();
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_update_gmax_campaign_status',
						status : status,
						campaign_id : campaign_id,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						console.log( response );
						// window.location.reload();
					}
				}
			)
		}
	);

	jQuery( document ).on(
		'click',
		'.ced_ads_gids_after_remove_gmc_acnt',
		function(je){
			je.preventDefault();
			jQuery( '.ced_error_during_set_ads_account' ).hide();
			var ced_ads_google_ids = $( '#ced_ads_google_ids' ).val();
			if (ced_ads_google_ids != '' && ced_ads_google_ids != null) {
				$( '.ced_google_shopping_loader' ).show();
				$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_ads_gids_after_remove_gmc_acnt',
							ced_ads_google_ids : ced_ads_google_ids,
						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							$( '.ced_google_shopping_loader' ).hide();
							$( '.ced_google_shopping_loader' ).hide();
							response = jQuery.parseJSON( response );
							console.log( response );
							var redirect_url = response.redirect_url;
							window.location  = redirect_url;
						}
					}
				)
			} else {
				jQuery( '.ced_error_during_set_ads_account' ).show();
				jQuery( '.ced_error_during_set_ads_account' ).text( 'Ads ID feild is required.' );
			}
		}
	);

	jQuery( document ).on(
		'click touchstart',
		'#ced_dash_gmc_approve',
		function(je){
			je.preventDefault();
			$( '.ced_google_shopping_loader' ).show();
			var current_service_linkid = $( this ).data( "linkid" );
			var operator               = 'SET';
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_dash_gmc_unlink',
						current_service_linkid : current_service_linkid,
						operator : operator,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						window.location.reload();
						console.log( response );
					}
				}
			)

		}
	);

	jQuery( document ).on(
		'click touchstart',
		'.ced_google_create_conversion',
		function(je){
			je.preventDefault();
			$( '.ced_google_shopping_loader' ).show();
			var ced_google_conversion_name = jQuery( '#ced_google_conversion_name' ).val();
			if ($( "input[type='radio'].ced_google_conversion_cat_action_track" ).is( ':checked' )) {
				var ced_google_conversion_action_track_category = $( "input[type='radio'].ced_google_conversion_cat_action_track:checked" ).val();
			}
			if ($( "input[type='radio'].ced_google_conversion_action_count" ).is( ':checked' )) {
				var ced_google_conversion_action_track_count = $( "input[type='radio'].ced_google_conversion_action_count:checked" ).val();
			}
			var ced_google_throug_cnvrsn_windw_max_time_after_day = jQuery( ".ced_google_throug_cnvrsn_windw_after_day" ).val();
			if (ced_google_throug_cnvrsn_windw_max_time_after_day == 'CUSTOM') {
				var ced_google_throug_cnvrsn_windw_max_time_after_day = jQuery( '.ced_google_throug_cnvrsn_windw_after_day_inp_val' ).val();
			}

			var ced_google_throug_cnvrsn_windw_max_time_view = jQuery( '.ced_google_cnvrsn_view_throug_cnvrsn_windw' ).val();
			if (ced_google_throug_cnvrsn_windw_max_time_view == 'CUSTOM') {
				var ced_google_throug_cnvrsn_windw_max_time_view = jQuery( '.ced_google_cnvrsn_view_throug_cnvrsn_windw_inp_wrap_val' ).val();
			}
			var ced_google_conversion_attribute_model = jQuery( '.ced_google_conversion_attribute_model' ).val();
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_google_create_conversion',
						ced_google_conversion_name : ced_google_conversion_name,
						ced_google_conversion_action_track_category : ced_google_conversion_action_track_category,
						ced_google_conversion_action_track_count : ced_google_conversion_action_track_count,
						ced_google_throug_cnvrsn_windw_max_time_after_day : ced_google_throug_cnvrsn_windw_max_time_after_day,
						ced_google_throug_cnvrsn_windw_max_time_view : ced_google_throug_cnvrsn_windw_max_time_view,
						ced_google_conversion_attribute_model : ced_google_conversion_attribute_model,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_create_conversion_fields' ).hide();
						$( '.ced_google_shopping_conversion_created_section' ).show();
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						// let respond_tags = response.message[0];
						let needed_content      = response.message;
						let GoogleGlobalSiteTag = (needed_content[0].GoogleGlobalSiteTag);
						let GoogleEventSnippet  = (needed_content[0].GoogleEventSnippet);
						let conversionid        = (needed_content[0].Id);
						jQuery( '.ced_google_shopping_conversion_global_site_tag' ).val( '' );
						jQuery( '.ced_google_shopping_conversion_global_site_tag' ).val( GoogleGlobalSiteTag );
						jQuery( '.ced_google_shopping_conversion_event_site_tag' ).val( '' );
						jQuery( '.ced_google_shopping_conversion_event_site_tag' ).val( GoogleEventSnippet );
						jQuery( '.ced_auto_upload_google_global_site_tag' ).attr( 'data-conversionid',conversionid );
					}
				}
			)
		}
	);

	jQuery( document ).on(
		'change',
		'.ced_google_cnvrsn_view_throug_cnvrsn_windw',
		function(je){
			je.preventDefault();
			var selected_value = $( this ).val();
			if (selected_value == 'CUSTOM') {
				jQuery( '.ced_google_cnvrsn_view_throug_cnvrsn_windw_inp_wrap' ).show();
			} else {
				jQuery( '.ced_google_cnvrsn_view_throug_cnvrsn_windw_inp_wrap' ).hide();
			}
		}
	)
	jQuery( document ).on(
		'change',
		'.ced_google_throug_cnvrsn_windw_after_day',
		function(je){
			je.preventDefault();
			var selected_value = $( this ).val();
			if (selected_value == 'CUSTOM') {
				jQuery( '.ced_google_throug_cnvrsn_windw_after_day_inp_wrap' ).show();
			} else {
				jQuery( '.ced_google_throug_cnvrsn_windw_after_day_inp_wrap' ).hide();
			}
		}
	)

	jQuery( document ).on(
		'click',
		'.ced_google_shopping_continue_after_create_conversion',
		function(je){
			$( '.ced_google_shopping_conversion_created_section' ).hide();
			$( '.ced_google_shopping_conversion_created_section_message' ).show();

		}
	);
	jQuery( document ).on(
		'click',
		'.ced_show_created_conversion_popup',
		function(je){
			// je.preventDefault();
			// $('.ced_google_shopping_popup_loader').show();
			// $('.ced_google_shopping_conversion_data_visible').hide();
			var conversionid = $( this ).data( "conversionid" );
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_show_created_conversion_popup',
						conversionid : conversionid,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						response                = jQuery.parseJSON( response );
						let needed_content      = response.message.rows;
						let GoogleGlobalSiteTag = (needed_content[0].GoogleGlobalSiteTag);
						let GoogleEventSnippet  = (needed_content[0].GoogleEventSnippet);
						jQuery( '.ced_google_shopping_conversion_global_site_tag_popup' ).val( '' );
						jQuery( '.ced_google_shopping_conversion_global_site_tag_popup' ).val( GoogleGlobalSiteTag );
						jQuery( '.ced_google_shopping_conversion_event_site_tag_popup' ).val( '' );
						jQuery( '.ced_google_shopping_conversion_event_site_tag_popup' ).val( GoogleEventSnippet );
						jQuery( '.ced_auto_upload_google_global_site_tag' ).attr( 'data-conversionid',conversionid );
						// $('.ced_google_shopping_popup_loader').hide();
						$( '.ced_google_shopping_conversion_data_visible' ).show();

						/*                $('.ced_google_shopping_conversion_created_section').hide();
						$('.ced_google_shopping_conversion_created_section_message').show();*/
					}
				}
			)

		}
	);
	jQuery( document ).on(
		'click',
		'.google_shopping_conversion_global_site_tag_copied',
		function(je){
			$( ".google_shopping_conversion_event_site_tag_copied" ).html( 'Click To clipboard' );
			$( '.ced_google_shopping_conversion_event_site_tag_popup' ).prop( 'disabled', true );
			$( '.ced_google_shopping_conversion_global_site_tag_popup' ).prop( 'disabled', false );
			$( '.ced_google_shopping_conversion_global_site_tag_popup' ).focus();
			var copyText = $( '.ced_google_shopping_conversion_global_site_tag_popup' ).val();
			navigator.clipboard.writeText( copyText );
			$( ".google_shopping_conversion_global_site_tag_copied" ).html( 'Copied' );
		}
	);
	jQuery( document ).on(
		'click',
		'.google_shopping_conversion_event_site_tag_copied',
		function(je){
			$( ".google_shopping_conversion_global_site_tag_copied" ).html( 'Click To clipboard' );
			$( '.ced_google_shopping_conversion_global_site_tag_popup' ).prop( 'disabled', true );
			$( '.ced_google_shopping_conversion_event_site_tag_popup' ).prop( 'disabled', false );
			$( '.ced_google_shopping_conversion_event_site_tag_popup' ).focus();
			var copyText = $( '.ced_google_shopping_conversion_event_site_tag_popup' ).val();
			navigator.clipboard.writeText( copyText );
			$( ".google_shopping_conversion_event_site_tag_copied" ).html( 'Copied' );

		}
	);

	jQuery( document ).on(
		'click',
		'.ced_google_shopping_conversion_global_site_tag_copied',
		function(je){
			$( ".ced_google_shopping_conversion_event_site_tag_copied" ).html( 'Click To clipboard' );
			$( '.ced_google_shopping_conversion_event_site_tag' ).prop( 'disabled', true );
			$( '.ced_google_shopping_conversion_global_site_tag' ).prop( 'disabled', false );
			$( '.ced_google_shopping_conversion_global_site_tag' ).focus();
			var copyText = $( '.ced_google_shopping_conversion_global_site_tag' ).val();
			$( '.ced_google_shopping_conversion_global_site_tag' ).focus();
			navigator.clipboard.writeText( copyText );
			$( this ).html( 'Copied' );
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_google_shopping_conversion_event_site_tag_copied',
		function(je){
			$( ".ced_google_shopping_conversion_global_site_tag_copied" ).html( 'Click To clipboard' );
			$( '.ced_google_shopping_conversion_global_site_tag' ).prop( 'disabled', true );
			$( '.ced_google_shopping_conversion_event_site_tag' ).prop( 'disabled', false );
			$( '.ced_google_shopping_conversion_event_site_tag' ).focus();
			var copyText = $( '.ced_google_shopping_conversion_event_site_tag' ).val();
			navigator.clipboard.writeText( copyText );
			$( this ).html( 'Copied' );
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_auto_upload_google_global_site_tag',
		function(je){
			$( '.ced_google_shopping_loader' ).show();
			var conversionid = $( this ).data( "conversionid" );
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_show_created_conversion_popup',
						conversionid : conversionid,
						globalSiteTag : 'insertInHeader',
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						 $( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						if (response.status == 'uploaded') {
							window.location = response.redirect_url;
						} else {
							let needed_content = response.message.rows;
							$( '.ced_auto_upload_google_global_site_tag' ).html( 'Global Site tage Uploaded' );
						}
					}
				}
			)

		}
	);

	jQuery( document ).on(
		'click',
		'.ced_auto_create_conversion_and_upload_tag',
		function(je){
			je.preventDefault();
			$( this ).siblings( '.ced_google_shopping_loader' ).show();
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_auto_create_conversion_and_upload_tag',
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( this ).siblings( '.ced_google_shopping_loader' ).hide();
						response         = jQuery.parseJSON( response );
						var redirect_url = response.redirect_url;
						window.location  = redirect_url;
					}
				}
			)
		}
	);
	jQuery( document ).on(
		'change',
		'.ced_google_shopping_get_reports_dropdown_values',
		function(je){
			je.preventDefault();
			$( '.ced-report-type-filter' ).siblings( '.ced_google_shopping_loader' ).show();

			// $('.ced_google_shopping_loader').show();
			var campaign_type       = $( '#ced_google_shopping_campaign_type' ).val();
			var campaign_date_range = $( '#ced_google_shopping_campaign_date_range' ).val();
			var campaign_status     = $( '#ced_google_shopping_campaign_status' ).val();

			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_google_shopping_get_Ads_reports',
						campaign_type : campaign_type,
						campaign_date_range : campaign_date_range,
						campaign_status : campaign_status,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						if (response.table_html != null || response.table_html != '') {
						let report_prepapred_html = response.table_html;

							$('#ced_download_google_campaign_report').show();
							$( '.ced_google_shopping_report_table_content' ).html( report_prepapred_html );
						}
						// console.log(report_prepapred_html);
					}
				}
			)
		}
	);

	jQuery( document ).on(
		'click',
		'#ced_download_google_campaign_report',
		function(je){
			je.preventDefault();
			$( this ).siblings( '.ced_google_shopping_loader' ).show();
			var campaign_type       = $( '#ced_google_shopping_campaign_type' ).val();
			var campaign_date_range = $( '#ced_google_shopping_campaign_date_range' ).val();
			var campaign_status     = $( '#ced_google_shopping_campaign_status' ).val();
			var download_report     = 'enabled';

			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_google_shopping_get_Ads_reports',
						campaign_type : campaign_type,
						campaign_date_range : campaign_date_range,
						campaign_status : campaign_status,
						download_report : download_report,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						if (response.table_html == null || response.table_html == '') {
							$('.ced_google_report_error').html('');
							$("<span class='ced_google_report_error'>No records found to download.</span>").insertAfter("#ced_download_google_campaign_report");
						} else {
							window.location = response.table_html;
						}

					}
				}
			)
		}
	);

	jQuery( document ).on(
		'click',
		'.ced_btn_google_re_connect_account',
		function(je){
			je.preventDefault();
			$( this ).hide();
			let need_to_show = $( this ).data( "show_attr" );
			let need_to_hide = $( this ).data( "hide_attr" );
			jQuery( '.' + need_to_show ).show();
			jQuery( '.' + need_to_hide ).hide();
		}
	)

	jQuery( document ).on(
		'click',
		'.ced_remove_selected_campaign_location',
		function(je){
			$( this ).parent().remove();

		}
	);
	jQuery( document ).on(
		'click',
		'.ced_create_and_save_profile',
		function(je){
			je.preventDefault();
			let profile_name = $( '.ced_google_shopping_profile_name' ).val();
			if (profile_name == '' || profile_name == null || profile_name == undefined ) {
				$( '.ced_profile_creation_error' ).html( 'Profile Name is required here' );
			} else {
				$( '.ced_google_shopping_loader' ).show();
				profile_name = $( '.ced_google_shopping_profile_name' ).val();
				$( '.ced_profile_creation_error' ).html( '' );
				$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_create_and_save_profile',
							profile_name : profile_name,
						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							// $('.ced_google_shopping_loader').hide();
							response = jQuery.parseJSON( response );
							// console.log(response);
							window.location = response.redirect_url;
						}
					}
				)
			}
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_gs_profiled_edit_woo_taxonomy',
		function(je){
			$( '.ced_gs_profile_selected_category' ).prop( 'disabled', false );
			$( '.ced_gs_profile_selected_category' ).focus();
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_gs_profiled_edit_google_taxonomy',
		function(je){
			$( '.ced_gs_profile_google_taxonomy_val' ).prop( 'disabled', false );
			$( '.ced_gs_profile_google_taxonomy_val' ).focus();
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_gs_proffile_create_and_save',
		function(je){
			je.preventDefault();
			let ced_gs_profile_country                = $( '.ced_gs_profile_country' ).val();
			let ced_gs_profile_name                   = $( '.ced_gs_profile_name' ).val();
			let ced_gs_profile_language               = $( '.ced_gs_profile_language' ).val();
			let ced_gs_profile_currency               = $( '.ced_gs_profile_currency' ).val();
			let ced_gs_profile_include_destination    = $( '.ced_gs_profile_include_destination' ).val();
			let ced_gs_profile_selected_category      = $( '.ced_gs_profile_selected_category' ).val();
			let ced_gs_profile_agegroup               = $( '.ced_gs_profile_agegroup' ).val();
			let ced_gs_profile_gender                 = $( '.ced_gs_profile_gender' ).val();
			let ced_google_shopping_profile_promition = $( '.ced_google_shopping_profile_promition' ).val();
			let ced_gs_profile_itemGroupId_val        = $( '.ced_gs_profile_itemGroupId_val' ).val();
			let ced_gs_profile_isAdult_val            = $( '.ced_gs_profile_isAdult_val' ).val();
			let ced_gs_profile_fixed_inv_val          = $( '.ced_gs_profile_fixed_inv_val' ).val();
			if (ced_gs_profile_fixed_inv_val == '' || ced_gs_profile_fixed_inv_val == null) {
				ced_gs_profile_fixed_inv_val = 0;
			}
			let ced_gs_profile_threshold_inv_val = $( '.ced_gs_profile_threshold_inv_val' ).val();
			if (ced_gs_profile_threshold_inv_val == '' || ced_gs_profile_threshold_inv_val == null) {
				ced_gs_profile_threshold_inv_val = 0;
			}
			let ced_gs_profile_google_taxonomy_val = $( '.ced_gs_profile_google_taxonomy_val' ).val();
			let ced_gs_profile_repricer_flow_val   = $( '.ced_gs_profile_repricer_flow_val' ).val();
			let ced_gs_profile_repricer_type_val   = $( '.ced_gs_profile_repricer_type_val' ).val();
			let ced_gs_profile_repricer_val        = $( '.ced_gs_profile_repricer_val' ).val();
			if (ced_gs_profile_repricer_val == '' || ced_gs_profile_repricer_val == null) {
				ced_gs_profile_repricer_val = 0;
			}
			var ced_gs_selected_brand_dropdown_value    = jQuery( "#google_brand_attibuteMeta" ).val();
			var ced_gs_selected_brand_input_filed_value = jQuery( "#ced_google_shopping_brand" ).val();
			var ced_gs_selected_mpn_dropdown_value      = jQuery( "#google_mpn_attibuteMeta" ).val();
			var ced_gs_selected_gtin_dropdown_value     = jQuery( "#google_gtin_attibuteMeta" ).val();
			var ajax_cond                               = '';
			$( ".ced_profile_data_required" ).each(
				function() {
					let required_check_val = $( this ).val();
					var attribute_id       = $( this ).attr( 'id' );
					if (required_check_val == '' || required_check_val == null || required_check_val == undefined) {
						if (attribute_id == 'ced_selected_include_destination') {
							  $( '#ced_selected_include_destination' ).siblings( '.select2-container' ).css( 'border','2px solid red' );
							  console.log( required_check_val );
						}
						if (attribute_id == 'ced_gs_profile_selected_category') {
							  $( '#ced_gs_profile_selected_category' ).siblings( '.select2-container' ).css( 'border','2px solid red' );
							  console.log( required_check_val );
						}
						$( this ).css( 'border','2px solid red' );
						$( this ).focus();
						ajax_cond = false;
					} else {
						ajax_cond = true;
						$( this ).css( 'border','' );
						if (attribute_id == 'ced_selected_include_destination') {
							  $( '#ced_selected_include_destination' ).siblings( '.select2-container' ).css( 'border','' );
							  console.log( required_check_val );
						}
						if (attribute_id == 'ced_gs_profile_selected_category') {
							  $( '#ced_gs_profile_selected_category' ).siblings( '.select2-container' ).css( 'border','' );
							  console.log( required_check_val );
						}
					}
				}
			);

			if (ajax_cond) {
				$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_gs_proffile_create_and_save',
							ced_gs_profile_name : ced_gs_profile_name,
							ced_gs_profile_country  : ced_gs_profile_country,
							ced_gs_profile_language : ced_gs_profile_language,
							ced_gs_profile_currency : ced_gs_profile_currency,
							ced_gs_profile_include_destination : ced_gs_profile_include_destination,
							ced_gs_profile_selected_category : ced_gs_profile_selected_category,
							ced_gs_profile_agegroup : ced_gs_profile_agegroup,
							ced_gs_profile_gender : ced_gs_profile_gender,
							ced_google_shopping_profile_promition : ced_google_shopping_profile_promition,
							ced_gs_profile_itemGroupId_val : ced_gs_profile_itemGroupId_val,
							ced_gs_profile_isAdult_val : ced_gs_profile_isAdult_val,
							ced_gs_profile_fixed_inv_val : ced_gs_profile_fixed_inv_val,
							ced_gs_profile_threshold_inv_val : ced_gs_profile_threshold_inv_val,
							ced_gs_profile_google_taxonomy_val : ced_gs_profile_google_taxonomy_val,
							ced_gs_profile_repricer_flow_val : ced_gs_profile_repricer_flow_val,
							ced_gs_profile_repricer_type_val : ced_gs_profile_repricer_type_val,
							ced_gs_profile_repricer_val : ced_gs_profile_repricer_val,
							ced_gs_selected_brand_dropdown_value : ced_gs_selected_brand_dropdown_value,
							ced_gs_selected_brand_input_filed_value : ced_gs_selected_brand_input_filed_value,
							ced_gs_selected_mpn_dropdown_value : ced_gs_selected_mpn_dropdown_value,
							ced_gs_selected_gtin_dropdown_value : ced_gs_selected_gtin_dropdown_value,

						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							$( '.ced_google_shopping_loader' ).hide();
							response = jQuery.parseJSON( response );
							console.log( response );
							window.location = response.redirect_url;
						}
					}
				)
			}
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_re_update_the_existing_profile',
		function(je){
			je.preventDefault();
			let ced_gs_profile_country                  = $( '.ced_gs_profile_country' ).val();
			let ced_gs_profile_name                     = $( '.ced_gs_profile_name' ).val();
			let ced_gs_profile_language                 = $( '.ced_gs_profile_language' ).val();
			let ced_gs_profile_currency                 = $( '.ced_gs_profile_currency' ).val();
			let ced_gs_profile_include_destination      = $( '.ced_gs_profile_include_destination' ).val();
			let ced_gs_profile_selected_category        = $( '.ced_gs_profile_selected_category' ).val();
			let ced_gs_profile_agegroup                 = $( '.ced_gs_profile_agegroup' ).val();
			let ced_gs_profile_gender                   = $( '.ced_gs_profile_gender' ).val();
			let ced_google_shopping_profile_promition   = $( '.ced_google_shopping_profile_promition' ).val();
			let ced_gs_profile_itemGroupId_val          = $( '.ced_gs_profile_itemGroupId_val' ).val();
			let ced_gs_profile_isAdult_val              = $( '.ced_gs_profile_isAdult_val' ).val();
			let ced_gs_profile_fixed_inv_val            = $( '.ced_gs_profile_fixed_inv_val' ).val();
			let ced_gs_profile_threshold_inv_val        = $( '.ced_gs_profile_threshold_inv_val' ).val();
			let ced_gs_profile_google_taxonomy_val      = $( '.ced_gs_profile_google_taxonomy_val' ).val();
			let ced_gs_profile_repricer_flow_val        = $( '.ced_gs_profile_repricer_flow_val' ).val();
			let ced_gs_profile_repricer_type_val        = $( '.ced_gs_profile_repricer_type_val' ).val();
			let ced_gs_profile_repricer_val             = $( '.ced_gs_profile_repricer_val' ).val();
			var ced_gs_selected_brand_dropdown_value    = jQuery( "#google_brand_attibuteMeta" ).val();
			var ced_gs_selected_brand_input_filed_value = jQuery( "#ced_google_shopping_brand" ).val();
			var ced_gs_selected_mpn_dropdown_value      = jQuery( "#google_mpn_attibuteMeta" ).val();
			var ced_gs_selected_gtin_dropdown_value     = jQuery( "#google_gtin_attibuteMeta" ).val();
			if (ced_gs_profile_fixed_inv_val == '' || ced_gs_profile_fixed_inv_val == null) {
				ced_gs_profile_fixed_inv_val = 0;
			}
			if (ced_gs_profile_threshold_inv_val == '' || ced_gs_profile_threshold_inv_val == null) {
				ced_gs_profile_threshold_inv_val = 0;
			}
			if (ced_gs_profile_repricer_val == '' || ced_gs_profile_repricer_val == null) {
				ced_gs_profile_repricer_val = 0;
			}
			var ajax_cond = '';
			$( ".ced_profile_data_required" ).each(
				function() {
					let required_check_val = $( this ).val();
					if (required_check_val == '' || required_check_val == null || required_check_val == undefined) {
						console.log( 'dfgd' );
						// $(this).css("border: 2px solid red;");
						$( this ).css( 'border','2px solid red' );
						ajax_cond = false;
					} else {
						ajax_cond = true;
					}
				}
			);

			if (ajax_cond) {
				$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_gs_proffile_create_and_save',
							ced_gs_profile_name : ced_gs_profile_name,
							ced_gs_profile_country  : ced_gs_profile_country,
							ced_gs_profile_language : ced_gs_profile_language,
							ced_gs_profile_currency : ced_gs_profile_currency,
							ced_gs_profile_include_destination : ced_gs_profile_include_destination,
							ced_gs_profile_selected_category : ced_gs_profile_selected_category,
							ced_gs_profile_agegroup : ced_gs_profile_agegroup,
							ced_gs_profile_gender : ced_gs_profile_gender,
							ced_google_shopping_profile_promition : ced_google_shopping_profile_promition,
							ced_gs_profile_itemGroupId_val : ced_gs_profile_itemGroupId_val,
							ced_gs_profile_isAdult_val : ced_gs_profile_isAdult_val,
							ced_gs_profile_fixed_inv_val : ced_gs_profile_fixed_inv_val,
							ced_gs_profile_threshold_inv_val : ced_gs_profile_threshold_inv_val,
							ced_gs_profile_google_taxonomy_val : ced_gs_profile_google_taxonomy_val,
							ced_gs_profile_repricer_flow_val : ced_gs_profile_repricer_flow_val,
							ced_gs_profile_repricer_type_val : ced_gs_profile_repricer_type_val,
							ced_gs_profile_repricer_val : ced_gs_profile_repricer_val,
							ced_gs_selected_brand_dropdown_value : ced_gs_selected_brand_dropdown_value,
							ced_gs_selected_brand_input_filed_value : ced_gs_selected_brand_input_filed_value,
							ced_gs_selected_mpn_dropdown_value : ced_gs_selected_mpn_dropdown_value,
							ced_gs_selected_gtin_dropdown_value : ced_gs_selected_gtin_dropdown_value,
						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							$( '.ced_google_shopping_loader' ).hide();
							response = jQuery.parseJSON( response );
							console.log( response );
							window.location = response.redirect_url;
						}
					}
				)
			}
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_gs_delete_profile',
		function(je){
			je.preventDefault();
			let confirmAction = confirm( "Are you sure you want to delete this profile - " );
			if (confirmAction) {
				$( '.ced_google_shopping_loader' ).show();
				var profile_name = $( this ).attr( 'data-profile_name' );
				$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_delete_existing_profile',
						profile_name : profile_name,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						$( '.ced_google_shopping_loader' ).hide();
						response = jQuery.parseJSON( response );
						// console.log(response);
						window.location = response.redirect_url;
					}
				}
				)
			}
		}
	);
	jQuery( document ).on(
		'click',
		'.ced_save_google_product_id_view',
		function(je){
			je.preventDefault();
			$( this ).siblings( '.ced_google_shopping_loader' ).show();
			var product_id_view = '';
			if ($( "input[type='radio'].ced_config_product_id_view" ).is( ':checked' )) {
				product_id_view = $( "input[type='radio'].ced_config_product_id_view:checked" ).val();
				$.ajax(
					{
						url: ced_google_admin_obj.ajax_url,
						data:{
							ajax_nonce : ced_google_admin_obj.ajax_nonce,
							action: 'ced_save_google_product_id_view',
							product_id_view : product_id_view,
						},
						type : 'POST',
						datatype : 'json',
						success: function(response){
							response = jQuery.parseJSON( response );
							$( '.ced_google_shopping_loader' ).hide();
							if (response.message == 'success') {
								$( '.ced_success_msg' ).remove();
								$( "<span class='ced_success_msg'>Product ID view saved successfully.</span>" ).insertAfter( ".ced_save_google_product_id_view" );
							}
						}
					}
				)
			}
		}
	)
	jQuery( document ).on(
		'click',
		'.ced_save_global_config_contents',
			function(je){
				je.preventDefault();
				$( this ).siblings( '.ced_google_shopping_loader' ).show();
				var ced_selected_brand_dropdown_value    = jQuery( "#google_brand_attibuteMeta" ).val();
				var ced_selected_brand_input_filed_value = jQuery( "#ced_google_shopping_brand" ).val();
				var ced_selected_mpn_dropdown_value      = jQuery( "#google_mpn_attibuteMeta" ).val();
				var ced_selected_gtin_dropdown_value     = jQuery( "#google_gtin_attibuteMeta" ).val();
				var ced_selected_defualt_google_taxanomoy_value     = jQuery( "#ced_gs_configuration_google_taxonomy" ).val();
				$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_save_global_config_contents',
						ced_selected_brand_dropdown_value :ced_selected_brand_dropdown_value,
						ced_selected_brand_input_filed_value :ced_selected_brand_input_filed_value,
						ced_selected_mpn_dropdown_value :ced_selected_mpn_dropdown_value,
						ced_selected_gtin_dropdown_value :ced_selected_gtin_dropdown_value,
						ced_selected_defualt_google_taxanomoy_value :ced_selected_defualt_google_taxanomoy_value,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						response = jQuery.parseJSON( response );
						$( '.ced_google_shopping_loader' ).hide();
						// $('.ced_success_msg').remove();
						$( ".ced_success_msg" ).each(
							function() {
								$( this ).remove();
							}
						);
						$( "<span class='ced_success_msg'>Woocommerce configuration saved successfully. </span>" ).insertAfter( ".ced_save_global_config_contents" );
					}
					}
				)
			}
	);
	jQuery( document ).on(
		'click',
		'.ced_gs_gmc_verify_and_claim',
		function(je){
			je.preventDefault();
			$( '.ced_google_shopping_loader' ).show();

			var websiteurl = $( this ).attr( 'data-websiteurl' );
			$.ajax(
				{
					url: ced_google_admin_obj.ajax_url,
					data:{
						ajax_nonce : ced_google_admin_obj.ajax_nonce,
						action: 'ced_gs_gmc_verify_and_claim',
						websiteurl : websiteurl,
					},
					type : 'POST',
					datatype : 'json',
					success: function(response){
						response = jQuery.parseJSON( response );
						$( '.ced_google_shopping_loader' ).hide();
						var redirect_url = response.redirect_url;
						window.location  = redirect_url;
					}
				}
			)

		}
	);
	jQuery( document ).on(
		'click',
		'.ced_view_products_error',
		function(je){
			$(this).siblings('.ced_details_view_products_error').show();

		}
	);
})( jQuery );
