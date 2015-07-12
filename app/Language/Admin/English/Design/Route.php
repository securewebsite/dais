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

namespace App\Language\Admin\English\Design;

class Route {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Custom Routes';
		
		// Text
		$_['lang_text_success']     = 'Success: You have modified routes.';
		
		// Column
		$_['lang_column_route']     = 'Route';
		$_['lang_column_slug']      = 'Slug';
		
		// Entry
		$_['lang_entry_slug']       = 'Slug:';
		$_['lang_entry_route']      = 'Route:';
		
		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify custom routes.';
		
		return $_;
	}
}
