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
namespace App\Language\Admin\English\Payment;

class PaypalExpressRefund {
	public static function lang() {
		//Heading
		$_['lang_heading_title']        = 'Refund Transaction';

		//Text
		$_['lang_text_paypal_express']   = 'PayPal Express Checkout';
		$_['lang_text_current_refunds'] = 'Refund has already been done for this transaction. The maximum refund is';

		//Button
		$_['lang_button_cancel']        = 'Cancel';
		$_['lang_button_refund']        = 'Issue Refund';

		//Form entry
		$_['lang_entry_transaction_id'] = 'Transaction ID';
		$_['lang_entry_full_refund']    = 'Full Refund';
		$_['lang_entry_amount']         = 'Amount';
		$_['lang_entry_message']        = 'Message';

		//Error
		$_['lang_error_partial_amt']    = 'You must enter a partial refund amount';
		$_['lang_error_data']           = 'Data missing from request';

		return $_;
	}
}
