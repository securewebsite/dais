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

class Route {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Custom Routes';
		
		// Text
		$_['lang_text_success']     = 'Success: You have modified routes.';
		$_['lang_text_default']     = 'Default';
		
		// Column
		$_['lang_column_route']     = 'Route';
		$_['lang_column_slug']      = 'Slug';
		$_['lang_column_action']    = 'Action';
		
		// Entry
		$_['lang_entry_slug']       = 'Slug:';
		$_['lang_entry_store']      = 'Store:';
		$_['lang_entry_route']      = 'Route:';
		
		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify custom routes.';
		$_['lang_error_slug']       = 'Slug must be between 3 and 64 characters.';
		$_['lang_error_layout']     = 'Warning: This slug cannot be deleted as it is currently assigned to %s pages.';
		
		return $_;
	}
}
