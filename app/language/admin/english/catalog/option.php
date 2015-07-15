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

namespace App\Language\Admin\English\Catalog;

class Option {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Options';

		// Text
		$_['lang_text_success']       = 'Success: You have modified options.';
		$_['lang_text_choose']        = 'Choose';
		$_['lang_text_select']        = 'Select';
		$_['lang_text_radio']         = 'Radio';
		$_['lang_text_checkbox']      = 'Checkbox';
		$_['lang_text_image']         = 'Image';
		$_['lang_text_input']         = 'Input';
		$_['lang_text_text']          = 'Text';
		$_['lang_text_textarea']      = 'Textarea';
		$_['lang_text_file']          = 'File';
		$_['lang_text_date']          = 'Date';
		$_['lang_text_datetime']      = 'Date &amp; Time';
		$_['lang_text_time']          = 'Time';
		$_['lang_text_image_manager'] = 'Image Manager';
		$_['lang_text_browse']        = 'Browse';
		$_['lang_text_clear']         = 'Clear';

		// Column
		$_['lang_column_name']        = 'Option Name';
		$_['lang_column_sort_order']  = 'Sort Order';
		$_['lang_column_action']      = 'Action';

		// Entry
		$_['lang_entry_name']         = 'Option Name:';
		$_['lang_entry_type']         = 'Type:';
		$_['lang_entry_option_value'] = 'Option Value Name:';
		$_['lang_entry_image']        = 'Image:';
		$_['lang_entry_sort_order']   = 'Sort Order:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify options.';
		$_['lang_error_name']         = 'Option Name must be between 1 and 128 characters.';
		$_['lang_error_type']         = 'Warning: Option Values required.';
		$_['lang_error_option_value'] = 'Option Value Name must be between 1 and 128 characters.';
		$_['lang_error_product']      = 'Warning: This option cannot be deleted as it is currently assigned to %s products.';

		return $_;
	}
}
