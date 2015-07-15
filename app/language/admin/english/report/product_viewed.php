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

namespace App\Language\Admin\English\Report;

class ProductViewed {
	public static function lang() {
		// Heading
		$_['lang_heading_title']  = 'Products Viewed Report';

		// Text
		$_['lang_text_success']   = 'Success: You have reset the product viewed report.';

		// Column
		$_['lang_column_name']    = 'Product Name';
		$_['lang_column_model']   = 'Model';
		$_['lang_column_viewed']  = 'Viewed';
		$_['lang_column_percent'] = 'Percent';

		return $_;
	}
}
