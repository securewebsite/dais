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

namespace App\Language\Admin\English\Shipping;

class Free {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Free Shipping';

		// Text
		$_['lang_text_shipping']    = 'Shipping';
		$_['lang_text_success']     = 'Success: You have modified free shipping.';

		// Entry
		$_['lang_entry_total']      = 'Total:<br /><span class="help">Sub-Total amount needed before the free shipping widget becomes available.</span>';
		$_['lang_entry_geo_zone']   = 'Geo Zone:';
		$_['lang_entry_status']     = 'Status:';
		$_['lang_entry_sort_order'] = 'Sort Order:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify free shipping.';

		return $_;
	}
}
