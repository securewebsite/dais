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

namespace Front\Language\English\Shipping;

class Usps {
	public static function lang() {
		// Text
		$_['lang_text_title']  = 'United States Postal Service';
		$_['lang_text_weight'] = 'Weight:';
		$_['lang_text_eta']    = 'Estimated Time:';

		return $_;
	}
}
