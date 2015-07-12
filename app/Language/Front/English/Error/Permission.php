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

namespace App\Language\Front\English\Error;

class Permission {
	public static function lang() {
		$_['lang_heading_title'] = 'Permission Denied';
		$_['lang_page_title']    = 'Whoops!';
		$_['lang_text_denied']   = 'Sorry, your current membership level doesn\'t allow you to view this content.';

		return $_;
	}
}
