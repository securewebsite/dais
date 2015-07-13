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

namespace Admin\Language\English\Total;

class GiftCard {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Gift Card';

		// Text
		$_['lang_text_total']       = 'Order Totals';
		$_['lang_text_success']     = 'Success: You have modified gift card total.';

		// Entry
		$_['lang_entry_status']     = 'Status:';
		$_['lang_entry_sort_order'] = 'Sort Order:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify gift card total.';

		return $_;
	}
}
