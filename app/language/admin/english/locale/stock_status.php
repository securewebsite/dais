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

namespace App\Language\Admin\English\Locale;

class StockStatus {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Stock Status';

		// Text
		$_['lang_text_success']     = 'Success: You have modified stock status.';

		// Column
		$_['lang_column_name']      = 'Stock Status Name';
		$_['lang_column_action']    = 'Action';

		// Entry
		$_['lang_entry_name']       = 'Stock Status Name:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify stock status.';
		$_['lang_error_name']       = 'Stock status name must be between 3 and 32 characters.';
		$_['lang_error_product']    = 'Warning: This stock status cannot be deleted as it is currently assigned to %s products.';

		return $_;
	}
}
