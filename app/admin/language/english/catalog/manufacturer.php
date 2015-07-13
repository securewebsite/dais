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

namespace Admin\Language\English\Catalog;

class Manufacturer {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Manufacturer';

		// Text
		$_['lang_text_success']       = 'Success: You have modified manufacturers.';
		$_['lang_text_default']       = 'Default';
		$_['lang_text_image_manager'] = 'Image Manager';
		$_['lang_text_browse']        = 'Browse';
		$_['lang_text_clear']         = 'Clear';
		$_['lang_text_percent']       = 'Percentage';
		$_['lang_text_amount']        = 'Fixed Amount';
		$_['lang_text_build']         = 'Build Slug';

		// Column
		$_['lang_column_name']        = 'Manufacturer Name';
		$_['lang_column_sort_order']  = 'Sort Order';
		$_['lang_column_action']      = 'Action';

		// Entry
		$_['lang_entry_name']         = 'Manufacturer Name:';
		$_['lang_entry_store']        = 'Stores:';
		$_['lang_entry_slug']         = 'Slug:<br /><span class="help">Do not use spaces instead replace spaces with - and make sure the slug is globally unique.</span>';
		$_['lang_entry_image']        = 'Image:';
		$_['lang_entry_sort_order']   = 'Sort Order:';
		$_['lang_entry_type']         = 'Type:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify manufacturers.';
		$_['lang_error_name']         = 'Manufacturer Name must be between 3 and 64 characters.';
		$_['lang_error_product']      = 'Warning: This manufacturer cannot be deleted as it is currently assigned to %s products.';
		$_['lang_error_slug']         = 'Warning: Slug is required for product manufacturers.';
		$_['lang_error_slug_found']   = 'ERROR: The slug %s is already in use, please use a different one in the input field.';
		$_['lang_error_name_first']   = 'ERROR: Please enter a name for your manufacturer before attempting to build a slug.';

		return $_;
	}
}
