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

namespace Front\Language\English\Widget;

class BlogHotTopics {
	public static function lang() {
		// Heading
		$_['lang_heading_title']        = 'Hot Topics';

		// Tab
		$_['lang_tab_recent']           = 'Most Recent';
		$_['lang_tab_viewed']           = 'Most Viewed';
		$_['lang_tab_discussed']        = 'Most Discussed';

		// Text
		$_['lang_text_viewed_times']    = 'viewed %s times';
		$_['lang_text_discussed_times'] = 'discussed %s times';

		return $_;
	}
}
