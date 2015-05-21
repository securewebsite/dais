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

namespace Admin\Language\English\Design;

class Banner {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Banners';

		// Text
		$_['lang_text_success']       = 'Success: You have modified banners.';
		$_['lang_text_default']       = 'Default';
		$_['lang_text_image_manager'] = 'Image Manager';
		$_['lang_text_browse']        = 'Browse';
		$_['lang_text_clear']         = 'Clear';

		// Column
		$_['lang_column_name']        = 'Banner Name';
		$_['lang_column_status']      = 'Status';
		$_['lang_column_action']      = 'Action';

		// Entry
		$_['lang_entry_name']         = 'Banner Name:';
		$_['lang_entry_title']        = 'Title:';
		$_['lang_entry_link']         = 'Link:';
		$_['lang_entry_image']        = 'Image:';
		$_['lang_entry_status']       = 'Status:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify banners.';
		$_['lang_error_name']         = 'Banner Name must be between 3 and 64 characters.';
		$_['lang_error_title']        = 'Banner Title must be between 2 and 64 characters.';
		$_['lang_error_default']      = 'Warning: This layout cannot be deleted as it is currently assigned as the default store layout.';
		$_['lang_error_product']      = 'Warning: This layout cannot be deleted as it is currently assigned to %s products.';
		$_['lang_error_category']     = 'Warning: This layout cannot be deleted as it is currently assigned to %s categories.';
		$_['lang_error_page']         = 'Warning: This layout cannot be deleted as it is currently assigned to %s pages.';

		return $_;
	}
}
