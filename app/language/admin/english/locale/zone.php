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

class Zone {
	public static function lang() {
		// Heading
		$_['lang_heading_title']          = 'Zones';

		// Text
		$_['lang_text_success']           = 'Success: You have modified zones.';

		// Column
		$_['lang_column_name']            = 'Zone Name';
		$_['lang_column_code']            = 'Zone Code';
		$_['lang_column_country']         = 'Country';
		$_['lang_column_action']          = 'Action';

		// Entry
		$_['lang_entry_status']           = 'Zone Status:';
		$_['lang_entry_name']             = 'Zone Name:';
		$_['lang_entry_code']             = 'Zone Code:';
		$_['lang_entry_country']          = 'Country:';

		// Error
		$_['lang_error_permission']       = 'Warning: You do not have permission to modify zones.';
		$_['lang_error_name']             = 'Zone name must be between 3 and 128 characters.';
		$_['lang_error_default']          = 'Warning: This zone cannot be deleted as it is currently assigned as the default store zone.';
		$_['lang_error_store']            = 'Warning: This zone cannot be deleted as it is currently assigned to %s stores.';
		$_['lang_error_address']          = 'Warning: This zone cannot be deleted as it is currently assigned to %s address book entries.';
		$_['lang_error_affiliate']        = 'Warning: This zone cannot be deleted as it is currently assigned to %s affiliates.';
		$_['lang_error_zone_to_geo_zone'] = 'Warning: This zone cannot be deleted as it is currently assigned to %s zones to geo zones.';

		return $_;
	}
}
