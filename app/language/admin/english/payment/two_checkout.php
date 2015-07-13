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

class TwoCheckout {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = '2Checkout';

		// Text
		$_['lang_text_payment']       = 'Payment';
		$_['lang_text_success']       = 'Success: You have modified 2Checkout account details.';

		// Entry
		$_['lang_entry_account']      = '2Checkout Account ID:';
		$_['lang_entry_secret']       = 'Secret Word:<br /><span class="help">The secret word used to confirm transactions, (this must be the same word as defined on the merchant account configuration page).</span>';
		$_['lang_entry_test']         = 'Test Mode:';
		$_['lang_entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
		$_['lang_entry_order_status'] = 'Order Status:';
		$_['lang_entry_geo_zone']     = 'Geo Zone:';
		$_['lang_entry_status']       = 'Status:';
		$_['lang_entry_sort_order']   = 'Sort Order:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify payment 2Checkout.';
		$_['lang_error_account']      = 'Account No. Required.';
		$_['lang_error_secret']       = 'Secret Word Required.';

		return $_;
	}
}
