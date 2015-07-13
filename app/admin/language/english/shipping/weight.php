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

namespace Admin\Language\English\Shipping;

class Weight {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Weight Based Shipping';

		// Text
		$_['lang_text_shipping']    = 'Shipping';
		$_['lang_text_success']     = 'Success: You have modified weight based shipping.';

		// Entry
		$_['lang_entry_rate']       = 'Rates:<br /><span class="help">Example: 5:10.00,7:12.00 Weight:Cost,Weight:Cost, etc..</span>';
		$_['lang_entry_tax_class']  = 'Tax Class:';
		$_['lang_entry_geo_zone']   = 'Geo Zone:';
		$_['lang_entry_status']     = 'Status:';
		$_['lang_entry_sort_order'] = 'Sort Order:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify weight based shipping.';

		return $_;
	}
}
