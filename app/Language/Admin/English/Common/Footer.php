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

namespace App\Language\Admin\English\Common;

class Footer {
	public static function lang() {
		// Text
		$_['lang_text_footer'] = '<a href="http://dais.io">Dais</a> &copy; ' . date('Y') . ' All Rights Reserved.<br />Version %s';

		return $_;
	}
}
