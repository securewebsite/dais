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

class BankTransfer {
	public static function lang() {
		// Text
		$_['lang_text_title']       = 'Bank Transfer';
		$_['lang_text_instruction'] = 'Bank Transfer Instructions';
		$_['lang_text_description'] = 'Please transfer the total amount to the following bank account.';
		$_['lang_text_payment']     = 'Your order will not ship until we receive payment.';

		return $_;
	}
}
