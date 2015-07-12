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

namespace App\Language\Admin\English\People;

class UserGroup {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'User Group';

		// Text
		$_['lang_text_success']     = 'Success: You have modified user groups.';

		// Column
		$_['lang_column_name']      = 'User Group Name';
		$_['lang_column_action']    = 'Action';

		// Entry
		$_['lang_entry_name']       = 'User Group Name:';
		$_['lang_entry_access']     = 'Access Permission:';
		$_['lang_entry_modify']     = 'Modify Permission:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify user groups.';
		$_['lang_error_name']       = 'User group name must be between 3 and 64 characters.';
		$_['lang_error_user']       = 'Warning: This user group cannot be deleted as it is currently assigned to %s users.';

		return $_;
	}
}
