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

class AuthorizeNet {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Authorize.Net (AIM)';

		// Text
		$_['lang_text_payment']       = 'Payment';
		$_['lang_text_success']       = 'Success: You have modified Authorize.Net (AIM) account details.';
		$_['lang_text_test']          = 'Test';
		$_['lang_text_live']          = 'Live';
		$_['lang_text_authorization'] = 'Authorization';
		$_['lang_text_capture']       = 'Capture';

		// Entry
		$_['lang_entry_login']        = 'Login ID:';
		$_['lang_entry_key']          = 'Transaction Key:';
		$_['lang_entry_hash']         = 'MD5 Hash:';
		$_['lang_entry_server']       = 'Transaction Server:';
		$_['lang_entry_mode']         = 'Transaction Mode:';
		$_['lang_entry_method']       = 'Transaction Method:';
		$_['lang_entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
		$_['lang_entry_order_status'] = 'Order Status:';
		$_['lang_entry_geo_zone']     = 'Geo Zone:';
		$_['lang_entry_status']       = 'Status:';
		$_['lang_entry_sort_order']   = 'Sort Order:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify payment Authorize.Net (AIM).';
		$_['lang_error_login']        = 'Login ID Required.';
		$_['lang_error_key']          = 'Transaction Key Required.';

		return $_;
	}
}
