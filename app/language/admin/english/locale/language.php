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

class Language {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Language';

		// Text
		$_['lang_text_success']      = 'Success: You have modified languages.';

		// Column
		$_['lang_column_name']       = 'Language Name';
		$_['lang_column_code']       = 'Code';
		$_['lang_column_sort_order'] = 'Sort Order';
		$_['lang_column_action']     = 'Action';

		// Entry
		$_['lang_entry_name']        = 'Language Name:';
		$_['lang_entry_code']        = 'Code:<br /><span class="help">eg: en. Do not change if this is your default language.</span>';
		$_['lang_entry_locale']      = 'Locale:<br /><span class="help">eg: en_US.UTF-8,en_US,en-gb,en_gb,english</span>';
		$_['lang_entry_image']       = 'Image:<br /><span class="help">eg: gb.png</span>';
		$_['lang_entry_directory']   = 'Directory:<br /><span class="help">name of the language directory (case-sensitive)</span>';
		$_['lang_entry_filename']    = 'Filename:<br /><span class="help">main language filename without extension</span>';
		$_['lang_entry_status']      = 'Status:<br /><span class="help">Hide/Show it in language dropdown</span>';
		$_['lang_entry_sort_order']  = 'Sort Order:';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify languages.';
		$_['lang_error_name']        = 'Language name must be between 3 and 32 characters.';
		$_['lang_error_code']        = 'Language code must at least 2 characters.';
		$_['lang_error_locale']      = 'Locale required.';
		$_['lang_error_image']       = 'Image filename must be between 3 and 64 characters.';
		$_['lang_error_directory']   = 'Directory required.';
		$_['lang_error_filename']    = 'Filename must be between 3 and 64 characters.';
		$_['lang_error_default']     = 'Warning: This language cannot be deleted as it is currently assigned as the default store language.';
		$_['lang_error_admin']       = 'Warning: This Language cannot be deleted as it is currently assigned as the administration language.';
		$_['lang_error_store']       = 'Warning: This language cannot be deleted as it is currently assigned to %s stores.';
		$_['lang_error_order']       = 'Warning: This language cannot be deleted as it is currently assigned to %s orders.';

		return $_;
	}
}
