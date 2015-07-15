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

class Check {
	public static function lang() {
		// Text
		$_['lang_text_title']       = 'Check / Money Order';
		$_['lang_text_instruction'] = 'Check / Money Order Instructions';
		$_['lang_text_payable']     = 'Make Payable To: ';
		$_['lang_text_address']     = 'Send To: ';
		$_['lang_text_payment']     = 'Your order will not ship until we receive payment.';

		return $_;
	}
}
