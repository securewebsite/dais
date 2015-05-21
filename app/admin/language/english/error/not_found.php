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

namespace Admin\Language\English\Error;

class NotFound {
	public static function lang() {
		// Heading
		$_['lang_heading_title']  = 'Page Not Found.';

		// Text
		$_['lang_text_not_found'] = 'The page you are looking for could not be found. Please contact your administrator if the problem persists.';

		return $_;
	}
}
