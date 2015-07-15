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

namespace App\Language\Admin\English\Catalog;

class Download {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Downloads';

		// Text
		$_['lang_text_success']     = 'Success: You have modified downloads.';
		$_['lang_text_upload']      = 'Your file was successfully uploaded.';

		// Column
		$_['lang_column_name']      = 'Download Name';
		$_['lang_column_remaining'] = 'Total Downloads Allowed';
		$_['lang_column_action']    = 'Action';

		// Entry
		$_['lang_entry_name']       = 'Download Name:';
		$_['lang_entry_filename']   = 'Filename:<br /><span class="help">You can upload via the upload button or use FTP to upload to the download directory and enter the details below.<br /><br />It is recommended that the filename and the mask are different to prevent people from trying to directly link to your downloads.</span>';
		$_['lang_entry_mask']       = 'Mask:';
		$_['lang_entry_remaining']  = 'Total Downloads Allowed:';
		$_['lang_entry_update']     = 'Push to Previous Customers:<br /><span class="help">Check this to update previously purchased versions as well.</span>';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify downloads.';
		$_['lang_error_name']       = 'Name must be between 3 and 64 characters.';
		$_['lang_error_upload']     = 'Upload required.';
		$_['lang_error_filename']   = 'Filename must be between 3 and 128 characters.';
		$_['lang_error_exists']     = 'File does not exist.';
		$_['lang_error_mask']       = 'Mask must be between 3 and 128 characters.';
		$_['lang_error_filetype']   = 'Invalid file type.';
		$_['lang_error_product']    = 'Warning: This download cannot be deleted as it is currently assigned to %s products.';

		return $_;
	}
}
