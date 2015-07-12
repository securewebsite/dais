<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

namespace App\Language\Front\English\Payment;

class PaypalProIframe {
	public static function lang() {
		// Text
		$_['lang_text_title']             = 'Credit or Debit Card';
		$_['lang_text_secure_connection'] = 'Creating a secure connection...';

		//Errors
		$_['lang_error_connection']       = "Could not connect to PayPal. Please contact the shop's administrator for assistance or choose a different payment method.";
		
		return $_;
	}
}
