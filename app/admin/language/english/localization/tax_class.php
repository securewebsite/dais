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

namespace Admin\Language\English\Localization;

class TaxClass {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Tax Class';

		// Text
		$_['lang_text_shipping']     = 'Shipping Address';
		$_['lang_text_payment']      = 'Payment Address';
		$_['lang_text_store']        = 'Store Address';
		$_['lang_text_success']      = 'Success: You have modified tax classes.';

		// Column
		$_['lang_column_title']      = 'Tax Class Title';
		$_['lang_column_action']     = 'Action';

		// Entry
		$_['lang_entry_title']       = 'Tax Class Title:';
		$_['lang_entry_description'] = 'Description:';
		$_['lang_entry_rate']        = 'Tax Rate:';
		$_['lang_entry_based']       = 'Based On:';
		$_['lang_entry_geo_zone']    = 'Geo Zone:';
		$_['lang_entry_priority']    = 'Priority:';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify tax classes.';
		$_['lang_error_title']       = 'Tax class title must be between 3 and 32 characters.';
		$_['lang_error_description'] = 'Description must be between 3 and 255 characters.';
		$_['lang_error_product']     = 'Warning: This tax class cannot be deleted as it is currently assigned to %s products.';

		return $_;
	}
}
