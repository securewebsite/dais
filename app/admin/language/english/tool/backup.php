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

namespace Admin\Language\English\Tool;

class Backup {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Backup / Restore';

		// Text
		$_['lang_text_backup']      = 'Download Backup';
		$_['lang_text_success']     = 'Success: You have successfully imported your database.';

		// Entry
		$_['lang_entry_restore']    = 'Restore Backup:';
		$_['lang_entry_backup']     = 'Backup:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify backups.';
		$_['lang_error_backup']     = 'Warning: You must select at least one table to backup.';
		$_['lang_error_empty']      = 'Warning: The file you uploaded was empty.';

		return $_;
	}
}
