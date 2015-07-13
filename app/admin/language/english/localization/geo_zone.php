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

namespace Admin\Language\English\Localization;

class GeoZone {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Geo Zones';

		// Text
		$_['lang_text_success']       = 'Success: You have modified geo zones.';

		// Column
		$_['lang_column_name']        = 'Geo Zone Name';
		$_['lang_column_description'] = 'Description';
		$_['lang_column_action']      = 'Action';

		// Entry
		$_['lang_entry_name']         = 'Geo Zone Name:';
		$_['lang_entry_description']  = 'Description:';
		$_['lang_entry_country']      = 'Country:';
		$_['lang_entry_zone']         = 'Zone:';

		// Error
		$_['lang_error_permission']   = 'Warning: You do not have permission to modify geo zones.';
		$_['lang_error_name']         = 'Geo zone name must be between 3 and 32 characters.';
		$_['lang_error_description']  = 'Description name must be between 3 and 255 characters.';
		$_['lang_error_tax_rate']     = 'Warning: This geo zone cannot be deleted as it is currently assigned to one or more tax rates.';

		return $_;
	}
}
