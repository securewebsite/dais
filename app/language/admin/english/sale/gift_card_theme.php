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

namespace App\Language\Admin\English\Sale;

class GiftCardTheme {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Gift Card Themes';

		// Text
		$_['lang_text_success']       = 'Success: You have modified Gift Card themes.';
		$_['lang_text_image_manager'] = 'Image Manager';
		$_['lang_text_browse']        = 'Browse';
		$_['lang_text_clear']         = 'Clear';

		// Column
		$_['lang_column_name']        = 'Gift Card Theme Name';
		$_['lang_column_action']      = 'Action';

		// Entry
		$_['lang_entry_name']         = 'Gift Card Theme Name:';
		$_['lang_entry_description']  = 'Gift Card Theme Description:';
		$_['lang_entry_image']        = 'Image:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify gift card themes.';
		$_['lang_error_name']         = 'Gift Card theme name must be between 3 and 32 characters.';
		$_['lang_error_image']        = 'Image Required.';
		$_['lang_error_gift_card']     = 'Warning: This gift card theme cannot be deleted as it is currently assigned to %s gift cards.';

		return $_;
	}
}
