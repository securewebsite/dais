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

class WeightClass {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Weight Class';

		// Text
		$_['lang_text_success']     = 'Success: You have modified weight class.';

		// Column
		$_['lang_column_title']     = 'Weight Title';
		$_['lang_column_unit']      = 'Weight Unit';
		$_['lang_column_value']     = 'Value';
		$_['lang_column_action']    = 'Action';

		// Entry
		$_['lang_entry_title']      = 'Weight Title:';
		$_['lang_entry_unit']       = 'Weight Unit:';
		$_['lang_entry_value']      = 'Value:<br /><span class="help">Set to 1.00000 if this is your default weight.</span>';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify weight class.';
		$_['lang_error_title']      = 'Weight title must be between 3 and 32 characters.';
		$_['lang_error_unit']       = 'Weight unit must be between 1 and 4 characters.';
		$_['lang_error_default']    = 'Warning: This weight class cannot be deleted as it is currently assigned as the default store weight class.';
		$_['lang_error_product']    = 'Warning: This weight class cannot be deleted as it is currently assigned to %s products.';

		return $_;
	}
}
