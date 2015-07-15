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

class PaypalStandard {
	public static function lang() {
		// Text
		$_['lang_text_title']    = 'PayPal';
		$_['lang_text_reason']   = 'REASON';
		$_['lang_text_testmode'] = 'Warning: The payment gateway is in \'Sandbox Mode\'. Your account will not be charged.';
		$_['lang_text_total']    = 'Shipping, Handling, Discounts & Taxes';

		return $_;
	}
}
