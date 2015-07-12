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

class BankTransfer {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Bank Transfer';

		// Text
		$_['lang_text_payment']       = 'Payment';
		$_['lang_text_success']       = 'Success: You have modified bank transfer details.';

		// Entry
		$_['lang_entry_bank']         = 'Bank Transfer Instructions:';
		$_['lang_entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
		$_['lang_entry_order_status'] = 'Order Status:';
		$_['lang_entry_geo_zone']     = 'Geo Zone:';
		$_['lang_entry_status']       = 'Status:';
		$_['lang_entry_sort_order']   = 'Sort Order:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify payment bank transfer.';
		$_['lang_error_bank']         = 'Bank Transfer Instructions Required.';

		return $_;
	}
}
