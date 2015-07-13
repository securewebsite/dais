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

class ReturnReason {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Return Reason';

		// Text
		$_['lang_text_success']     = 'Success: You have modified return reasons.';

		// Column
		$_['lang_column_name']      = 'Return Reason Name';
		$_['lang_column_action']    = 'Action';

		// Entry
		$_['lang_entry_name']       = 'Return Reason Name:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify return reasons.';
		$_['lang_error_name']       = 'Return Reason Name must be between 3 and 32 characters.';
		$_['lang_error_return']     = 'Warning: This return reason cannot be deleted as it is currently assigned to %s returned products.';

		return $_;
	}
}
