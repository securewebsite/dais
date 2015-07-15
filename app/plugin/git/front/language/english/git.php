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

namespace App\Plugin\Git\Front\Language\English;

class Git {
	public static function lang() {
		// Errors
		$_['lang_error_data_not_set'] = 'HTTP_RAW_POST_DATA is not set.';
		$_['lang_error_json_decode']  = 'An error was encountered while attempting to json_decode the HTTP_RAW_POST_DATA.';
		$_['lang_error_branch']       = 'This is the incorrect branch. This repo accepts only %s calls, %s branch sent with hook call.';
		$_['lang_error_pull_failed']  = 'Pull failed.';

		return $_;
	}
}
