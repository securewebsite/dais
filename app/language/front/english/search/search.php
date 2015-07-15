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

namespace App\Language\Front\English\Search;

class Search {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Search';
		
		// Text
		$_['lang_product']           = 'Product';
		$_['lang_product_category']  = 'Product Category';
		$_['lang_article']           = 'Article';
		$_['lang_blog_category']     = 'Blog Category';
		$_['lang_page']              = 'Page';
		$_['lang_manufacturer']      = 'Manufacturer';
		$_['lang_no_results']        = 'Sorry, no results for this search.';
		
		// Entry
		$_['lang_entry_search']      = 'Search';

		return $_;
	}
}
