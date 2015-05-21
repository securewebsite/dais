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

class AttributeGroup {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Attribute Groups';

		// Text
		$_['lang_text_success']      = 'Success: You have modified attribute groups.';

		// Column
		$_['lang_column_name']       = 'Attribute Group Name';
		$_['lang_column_sort_order'] = 'Sort Order';
		$_['lang_column_action']     = 'Action';

		// Entry
		$_['lang_entry_name']        = 'Attribute Group Name:';
		$_['lang_entry_sort_order']  = 'Sort Order:';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify attribute groups.';
		$_['lang_error_name']        = 'Attribute Group Name must be between 3 and 64 characters.';
		$_['lang_error_attribute']   = 'Warning: This attribute group cannot be deleted as it is currently assigned to %s attributes.';
		$_['lang_error_product']     = 'Warning: This attribute group cannot be deleted as it is currently assigned to %s products.';

		return $_;
	}
}
