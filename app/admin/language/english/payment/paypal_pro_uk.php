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

namespace Admin\Language\English\Payment;

class PaypalProUk {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'PayPal Payments Pro (UK)';

		// Text
		$_['lang_text_payment']       = 'Payment';
		$_['lang_text_success']       = 'Success: You have modified PayPal Website Payment Pro Checkout account details.';
		$_['lang_text_authorization'] = 'Authorization';
		$_['lang_text_sale']          = 'Sale';

		// Entry
		$_['lang_entry_username']     = 'API Username:';
		$_['lang_entry_password']     = 'API Password:';
		$_['lang_entry_signature']    = 'API Signature:';
		$_['lang_entry_test']         = 'Test Mode:<br /><span class="help">Use the live or testing (sandbox) gateway server to process transactions?</span>';
		$_['lang_entry_transaction']  = 'Transaction Method:';
		$_['lang_entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
		$_['lang_entry_order_status'] = 'Order Status:';
		$_['lang_entry_geo_zone']     = 'Geo Zone:';
		$_['lang_entry_status']       = 'Status:';
		$_['lang_entry_sort_order']   = 'Sort Order:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify payment PayPal Website Payment Pro Checkout.';
		$_['lang_error_username']     = 'API Username Required.';
		$_['lang_error_password']     = 'API Password Required.';
		$_['lang_error_signature']    = 'API Signature Required.';

		return $_;
	}
}
