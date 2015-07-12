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

namespace App\Language\Admin\English\Feed;

class GoogleSiteMap {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Google Sitemap';

		// Text
		$_['lang_text_feed']        = 'Product Feeds';
		$_['lang_text_success']     = 'Success: You have modified Google Sitemap feed.';

		// Entry
		$_['lang_entry_status']     = 'Status:';
		$_['lang_entry_data_feed']  = 'Data Feed Url:';

		// Error
		$_['lang_error_permission'] = 'Warning: You do not have permission to modify Google Sitemap feed.';

		return $_;
	}
}
