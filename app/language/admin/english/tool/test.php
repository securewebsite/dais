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

namespace App\Language\Admin\English\Tool;

class Test {
	public static function lang() {
		// Heading
		$_['lang_heading_title'] = 'Testing Suite';

		// Text
		$_['lang_text_success']  = 'Success: %s.';

		return $_;
	}
}
