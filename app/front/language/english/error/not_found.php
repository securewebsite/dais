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

namespace Front\Language\English\Error;

class NotFound {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'The page you requested cannot be found.';
		$_['lang_page_title']       = 'Whoops!';

		// Text
		$_['lang_text_error']       = 'The page you requested cannot be found.';
		$_['lang_breadcrumb_error'] = 'Error 404';

		return $_;
	}
}
