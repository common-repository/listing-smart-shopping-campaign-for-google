<?php
class Google_Shopping_Lib {
	public function google_shopping_get_connected_acount() {
		$ced_google_user_login_data = get_option( 'ced_google_user_login_data' );
		if ( ! empty( $ced_google_user_login_data ) && is_array( $ced_google_user_login_data ) ) {

			$user_id               = $ced_google_user_login_data['user_id'];
			$user_token            = $ced_google_user_login_data['data']['token'];
			$parameters            = array();
			$parameters['user_id'] = $user_id;
			$parameters['step']    = 2;
			$header                = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			// $apiUrl                = 'https://dev-express.sellernext.com/frontend/app/getStepData';
			$apiUrl                  = 'https://express.sellernext.com/frontend/app/getStepData';
			$GmcAccount_api_response = wp_remote_post(
				$apiUrl,
				array(
					'body'        => $parameters,
					'headers'     => $header,
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
				)
			);
			if ( isset( $GmcAccount_api_response['body'] ) ) {
				$response = json_decode( $GmcAccount_api_response['body'], true );
				if ( isset( $response['data']['connected_gmail'] ) ) {
					$connected_gmail     = $response['data']['connected_gmail'];
					$connected_ads_gmail = $response['data']['connected_ads_gmail'];
					update_option( 'ced_google_connected_gmail', $connected_gmail );
					update_option( 'ced_google_connected_ads_gmail', $connected_ads_gmail );
					return $connected_gmail;
				} else {
					return $GmcAccount_api_response['body'];
				}
			} else {
				return $GmcAccount_api_response;
			}
		}
		return 'user not loggedin';

	}
	public function google_shopping_get_connected_merechant_acount() {
		$ced_google_user_login_data = get_option( 'ced_google_user_login_data' );
		if ( ! empty( $ced_google_user_login_data ) && is_array( $ced_google_user_login_data ) ) {
			$user_id               = $ced_google_user_login_data['user_id'];
			$user_token            = $ced_google_user_login_data['data']['token'];
			$parameters            = array();
			$parameters['user_id'] = $user_id;
			$parameters['step']    = 2;
			$header                = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			// $apiUrl                = 'https://dev-express.sellernext.com/frontend/app/getStepData';
			$apiUrl                  = 'https://express.sellernext.com/frontend/app/getStepData';
			$GmcAccount_api_response = wp_remote_post(
				$apiUrl,
				array(
					'body'        => $parameters,
					'headers'     => $header,
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
				)
			);
			/*
			print_r($GmcAccount_api_response);
			die();*/
			if ( isset( $GmcAccount_api_response['body'] ) ) {
				$response = json_decode( $GmcAccount_api_response['body'], true );
				if ( isset( $response['data']['all_gmc_account'] ) ) {
					$all_gmc_accounts = $response['data']['all_gmc_account'];
					return $all_gmc_accounts;
				}
			}
		}
		return 'user not loggedin';

	}
	public function google_shopping_get_connected_googleads_acount( $from_dash = '' ) {
		$ced_google_user_login_data = get_option( 'ced_google_user_login_data' );
		if ( ! empty( $ced_google_user_login_data ) && is_array( $ced_google_user_login_data ) ) {

			$user_id    = $ced_google_user_login_data['user_id'];
			$user_token = $ced_google_user_login_data['data']['token'];

			$parameters            = array();
			$parameters['user_id'] = $user_id;
			/*
						$parameters['merchantId']  = $merchant_id;
			$parameters['websiteUrl']  = $websiteUrl;
			$parameters['accountName'] = $account_name;*/
			$header       = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			$apiUrl       = 'https://express.sellernext.com/gfront/app/saveAllGoogleAdsAccount';
			$api_response = wp_remote_post(
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

			$parameters            = array();
			$parameters['user_id'] = $user_id;
			$parameters['step']    = 3;
			$header                = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			// $apiUrl                = 'https://dev-express.sellernext.com/frontend/app/getStepData';
			$apiUrl = 'https://express.sellernext.com/frontend/app/getStepData';

			$GAdsAccount_api_response = wp_remote_post(
				$apiUrl,
				array(
					'body'        => $parameters,
					'headers'     => $header,
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
				)
			);
			if ( isset( $GAdsAccount_api_response['body'] ) ) {
				$response = json_decode( $GAdsAccount_api_response['body'], true );
				if ( isset( $response['data'] ) ) {
					if ( ! empty( $from_dash ) ) {
						$connected_gmail          = $response['data']['connected_gmail'];
						$conected_gads_gmail      = $response['data']['connected_ads_gmail'];
						$connected_gmc_account    = $response['data']['connected_gmc_account'];
						$active_all_Gmcs_accounts = $response['data']['all_gmc_account'];
						$connected_gads_account   = $response['data']['connected_google_ads_id'];
						$active_all_Gads_accounts = $response['data']['all_google_ads_id'];

						$array_for_getstepalldata = array(
							'connected_gmail'          => $connected_gmail,
							'conected_gads_gmail'      => $conected_gads_gmail,
							'connected_gads_account'   => $connected_gads_account,
							'active_all_Gads_accounts' => $active_all_Gads_accounts,
							'connected_gmc_account'    => $connected_gmc_account,
							'active_all_Gmcs_accounts' => $active_all_Gmcs_accounts,
						);
						return $array_for_getstepalldata;
					} else {
						$google_ads_account_details = $response['data']['all_google_ads_id'];
						return $google_ads_account_details;
					}
				}
			}
		}
		return 'user not loggedin';

	}


	public function google_shopping_get_connected_googleads_acount_data_only( $from_dash = '' ) {
		$ced_google_user_login_data = get_option( 'ced_google_user_login_data' );
		if ( ! empty( $ced_google_user_login_data ) && is_array( $ced_google_user_login_data ) ) {

			$user_id    = $ced_google_user_login_data['user_id'];
			$user_token = $ced_google_user_login_data['data']['token'];

			$parameters            = array();
			$parameters['user_id'] = $user_id;
			$parameters['step']    = 3;
			$header                = array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $user_token,
			);
			// $apiUrl                = 'https://dev-express.sellernext.com/frontend/app/getStepData';
			$apiUrl = 'https://express.sellernext.com/frontend/app/getStepData';

			$GAdsAccount_api_response = wp_remote_post(
				$apiUrl,
				array(
					'body'        => $parameters,
					'headers'     => $header,
					'httpversion' => '1.0',
					'sslverify'   => false,
					'timeout'     => 120,
				)
			);
			if ( isset( $GAdsAccount_api_response['body'] ) ) {
				$response = json_decode( $GAdsAccount_api_response['body'], true );
				if ( isset( $response['data'] ) ) {
					if ( ! empty( $from_dash ) ) {
						$connected_gmail          = $response['data']['connected_gmail'];
						$conected_gads_gmail      = $response['data']['connected_ads_gmail'];
						$connected_gmc_account    = $response['data']['connected_gmc_account'];
						$active_all_Gmcs_accounts = $response['data']['all_gmc_account'];
						$connected_gads_account   = $response['data']['connected_google_ads_id'];
						$active_all_Gads_accounts = $response['data']['all_google_ads_id'];

						$array_for_getstepalldata = array(
							'connected_gmail'          => $connected_gmail,
							'conected_gads_gmail'      => $conected_gads_gmail,
							'connected_gads_account'   => $connected_gads_account,
							'active_all_Gads_accounts' => $active_all_Gads_accounts,
							'connected_gmc_account'    => $connected_gmc_account,
							'active_all_Gmcs_accounts' => $active_all_Gmcs_accounts,
						);
						return $array_for_getstepalldata;
					} else {
						$google_ads_account_details = $response['data']['all_google_ads_id'];
						return $google_ads_account_details;
					}
				}
			}
		}
		return 'user not loggedin';

	}

	public function google_shopping_get_google_supported_currency() {
		$google_supported_currency = array(
			'AED' => 'Arab Emirate Dirham',
			'ALL' => 'Albania Lek',
			'AFN' => 'Afghanistan Afghani',
			'ARS' => 'Argentina Peso',
			'AWG' => 'Aruba Guilder',
			'AUD' => 'Australia Dollar',
			'AZN' => 'Azerbaijan New Manat',
			'BSD' => 'Bahamas Dollar',
			'BBD' => 'Barbados Dollar',
			'BDT' => 'Bangladeshi taka',
			'BYR' => 'Belarus Ruble',
			'BZD' => 'Belize Dollar',
			'BMD' => 'Bermuda Dollar',
			'BOB' => 'Bolivia Boliviano',
			'BAM' => 'Bosnia and Herzegovina Convertible Marka',
			'BWP' => 'Botswana Pula',
			'BGN' => 'Bulgaria Lev',
			'BRL' => 'Brazil Real',
			'BND' => 'Brunei Darussalam Dollar',
			'KHR' => 'Cambodia Riel',
			'CAD' => 'Canada Dollar',
			'KYD' => 'Cayman Islands Dollar',
			'CLP' => 'Chile Peso',
			'CNY' => 'China Yuan Renminbi',
			'COP' => 'Colombia Peso',
			'CRC' => 'Costa Rica Colon',
			'HRK' => 'Croatia Kuna',
			'CUP' => 'Cuba Peso',
			'CZK' => 'Czech Republic Koruna',
			'DKK' => 'Denmark Krone',
			'DOP' => 'Dominican Republic Peso',
			'XCD' => 'East Caribbean Dollar',
			'EGP' => 'Egypt Pound',
			'SVC' => 'El Salvador Colon',
			'EEK' => 'Estonia Kroon',
			'EUR' => 'Euro Member Countries',
			'FKP' => 'Falkland Islands (Malvinas) Pound',
			'FJD' => 'Fiji Dollar',
			'GHS' => 'Ghana Cedis',
			'GIP' => 'Gibraltar Pound',
			'GTQ' => 'Guatemala Quetzal',
			'GGP' => 'Guernsey Pound',
			'GYD' => 'Guyana Dollar',
			'HNL' => 'Honduras Lempira',
			'HKD' => 'Hong Kong Dollar',
			'HUF' => 'Hungary Forint',
			'ISK' => 'Iceland Krona',
			'INR' => 'India Rupee',
			'IDR' => 'Indonesia Rupiah',
			'IRR' => 'Iran Rial',
			'IMP' => 'Isle of Man Pound',
			'ILS' => 'Israel Shekel',
			'JMD' => 'Jamaica Dollar',
			'JPY' => 'Japan Yen',
			'JEP' => 'Jersey Pound',
			'KZT' => 'Kazakhstan Tenge',
			'KPW' => 'Korea (North) Won',
			'KRW' => 'Korea (South) Won',
			'KGS' => 'Kyrgyzstan Som',
			'LAK' => 'Laos Kip',
			'LVL' => 'Latvia Lat',
			'LBP' => 'Lebanon Pound',
			'LRD' => 'Liberia Dollar',
			'LTL' => 'Lithuania Litas',
			'MKD' => 'Macedonia Denar',
			'MYR' => 'Malaysia Ringgit',
			'MUR' => 'Mauritius Rupee',
			'MXN' => 'Mexico Peso',
			'MNT' => 'Mongolia Tughrik',
			'MZN' => 'Mozambique Metical',
			'NAD' => 'Namibia Dollar',
			'NPR' => 'Nepal Rupee',
			'ANG' => 'Netherlands Antilles Guilder',
			'NZD' => 'New Zealand Dollar',
			'NIO' => 'Nicaragua Cordoba',
			'NGN' => 'Nigeria Naira',
			'NOK' => 'Norway Krone',
			'OMR' => 'Oman Rial',
			'PKR' => 'Pakistan Rupee',
			'PAB' => 'Panama Balboa',
			'PYG' => 'Paraguay Guarani',
			'PEN' => 'Peru Nuevo Sol',
			'PHP' => 'Philippines Peso',
			'PLN' => 'Poland Zloty',
			'QAR' => 'Qatar Riyal',
			'RON' => 'Romania New Leu',
			'RUB' => 'Russia Ruble',
			'SHP' => 'Saint Helena Pound',
			'SAR' => 'Saudi Arabia Riyal',
			'RSD' => 'Serbia Dinar',
			'SCR' => 'Seychelles Rupee',
			'SGD' => 'Singapore Dollar',
			'SBD' => 'Solomon Islands Dollar',
			'SOS' => 'Somalia Shilling',
			'ZAR' => 'South Africa Rand',
			'LKR' => 'Sri Lanka Rupee',
			'SEK' => 'Sweden Krona',
			'CHF' => 'Switzerland Franc',
			'SRD' => 'Suriname Dollar',
			'SYP' => 'Syria Pound',
			'TWD' => 'Taiwan New Dollar',
			'THB' => 'Thailand Baht',
			'TTD' => 'Trinidad and Tobago Dollar',
			'TRY' => 'Turkey Lira',
			'TRL' => 'Turkey Lira',
			'TVD' => 'Tuvalu Dollar',
			'UAH' => 'Ukraine Hryvna',
			'GBP' => 'United Kingdom Pound',
			'USD' => 'United States Dollar',
			'UYU' => 'Uruguay Peso',
			'UZS' => 'Uzbekistan Som',
			'VEF' => 'Venezuela Bolivar',
			'VND' => 'Viet Nam Dong',
			'YER' => 'Yemen Rial',
			'ZWD' => 'Zimbabwe Dollar',
			'AMD' => 'Armenian Dram',
			'AOA' => 'Angolan Kwanza',
			'BHD' => 'Bahraini Dinar',
			'BIF' => 'Burundian Franc',
			'BTC' => 'Bitcoin',
			'BTN' => 'Bhutanese Ngultrum',
			'BYN' => 'Belarusian Ruble',
			'CDF' => 'Congolese Franc',
			'CLF' => 'Chilean Unit of Account (UF)',
			'CNH' => 'Chinese Yuan (Offshore)',
			'CUC' => 'Cuban Convertible Peso',
			'CVE' => 'Cape Verdean Escudo',
			'DJF' => 'Djiboutian Franc',
			'DZD' => 'Algerian Dinar',
			'ERN' => 'Eritrean Nakfa',
			'ETB' => 'Ethiopian Birr',
			'GEL' => 'Georgian Lari',
			'GMD' => 'Gambian Dalasi',
			'GNF' => 'Guinean Franc',
			'HTG' => 'Haitian Gourde',
			'IQD' => 'Iraqi Dinar',
			'JOD' => 'Jordanian Dinar',
			'KES' => 'Kenyan Shilling',
			'KMF' => 'Comorian Franc',
			'KWD' => 'Kuwaiti Dinar',
			'LSL' => 'Lesotho Loti',
			'LYD' => 'Libyan Dinar',
			'MAD' => 'Moroccan Dirham',
			'MDL' => 'Moldovan Leu',
			'MGA' => 'Malagasy Ariary',
			'MMK' => 'Myanma Kyat',
			'MOP' => 'Macanese Pataca',
			'MRO' => 'Mauritanian Ouguiya (pre-2018)',
			'MRU' => 'Mauritanian Ouguiya',
			'MVR' => 'Maldivian Rufiyaa',
			'MWK' => 'Malawian Kwacha',
			'PGK' => 'Papua New Guinean Kina',
			'RWF' => 'Rwandan Franc',
			'SDG' => 'Sudanese Pound',
			'SLL' => 'Sierra Leonean Leone',
			'SSP' => 'South Sudanese Pound',
			'STD' => 'São Tomé and Príncipe Dobra (pre-2018)',
			'STN' => 'São Tomé and Príncipe Dobra',
			'SZL' => 'Swazi Lilangeni',
			'TJS' => 'Tajikistani Somoni',
			'TMT' => 'Turkmenistani Manat',
			'TND' => 'Tunisian Dinar',
			'TOP' => 'Tongan Paanga',
			'TZS' => 'Tanzanian Shilling',
			'UGX' => 'Ugandan Shilling',
			'VUV' => 'Vanuatu Vatu',
			'WST' => 'Samoan Tala',
			'XAF' => 'CFA Franc BEAC',
			'XAG' => 'Silver Ounce',
			'XAU' => 'Gold Ounce',
			'XDR' => 'Special Drawing Rights',
			'XOF' => 'CFA Franc BCEAO',
			'XPD' => 'Palladium Ounce',
			'XPF' => 'CFP Franc',
			'XPT' => 'Platinum Ounce',
			'ZMW' => 'Zambian Kwacha',
			'ZWL' => 'Zimbabwean Dollar',
		);
		return $google_supported_currency;
	}
}

