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

namespace App\Language\Front\English\Widget;

class BlogLatest {
	public static function lang() {
		// Heading
		$_['lang_heading_title']          = 'Latest Posts';

		// Text
		$_['lang_text_reviews']           = '%s comments';
		$_['lang_text_posted_categories'] = '<a href="%s">%s</a>';
		$_['lang_text_views']             = '%s views';

		return $_;
	}
}
