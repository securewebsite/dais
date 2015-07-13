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

namespace Front\Language\English\Payment;

class PaypalPro {
	public static function lang() {
		// Text
		$_['lang_text_title']           = 'Credit or Debit Card (Processed securely by PayPal)';
		$_['lang_text_credit_card']     = 'Credit Card Details';
		$_['lang_text_start_date']      = '(if available)';
		$_['lang_text_issue']           = '(for Maestro and Solo cards only)';
		$_['lang_text_wait']            = 'Please wait.';

		// Entry
		$_['lang_entry_cc_type']        = 'Card Type';
		$_['lang_entry_cc_number']      = 'Card Number';
		$_['lang_entry_cc_start_date']  = 'Card Valid From Date';
		$_['lang_entry_cc_expire_date'] = 'Card Expiry Date';
		$_['lang_entry_cc_cvv2']        = 'Card Security Code (CVV2)';
		$_['lang_entry_cc_issue']       = 'Card Issue Number';

		return $_;
	}
}
