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

class PaypalProPf {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'PayPal Payments Pro Payflow Edition';

		// Text
		$_['lang_text_payment']       = 'Payment';
		$_['lang_text_success']       = 'Success: You have modified PayPal Direct (UK) account details.';
		$_['lang_text_authorization'] = 'Authorization';
		$_['lang_text_sale']          = 'Sale';

		// Entry
		$_['lang_entry_vendor']       = 'Vendor:<br /><span class="help">Your merchant login ID that you created when you registered for the Website Payments Pro account.</span>';
		$_['lang_entry_user']         = 'User:<br /><span class="help">If you set up one or more additional users on the account, this value is the ID of the user authorized to process transactions. If, however, you have not set up additional users on the account, USER has the same value as VENDOR.</span>';
		$_['lang_entry_password']     = 'Password:<br /><span class="help">The 6 to 32 character password that you defined while registering for the account.</span>';
		$_['lang_entry_partner']      = 'Partner:<br /><span class="help">The ID provided to you by the authorised PayPal Reseller who registered you for the Payflow SDK. If you purchased your account directly from PayPal, use PayPalUK.</span>';
		$_['lang_entry_test']         = 'Test Mode:<br /><span class="help">Use the live or testing (sandbox) gateway server to process transactions?</span>';
		$_['lang_entry_transaction']  = 'Transaction Method:';
		$_['lang_entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
		$_['lang_entry_order_status'] = 'Order Status:';
		$_['lang_entry_geo_zone']     = 'Geo Zone:';
		$_['lang_entry_status']       = 'Status:';
		$_['lang_entry_sort_order']   = 'Sort Order:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify payment PayPal Website Payment Pro (UK).';
		$_['lang_error_vendor']       = 'Vendor Required.';
		$_['lang_error_user']         = 'User Required.';
		$_['lang_error_password']     = 'Password Required.';
		$_['lang_error_partner']      = 'Partner Required.';

		return $_;
	}
}
