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

namespace Front\Language\English\Search;

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
		
		// Entry
		$_['lang_entry_search']      = 'Search';
		$_['lang_entry_description'] = 'Search in product descriptions';

		

		return $_;
	}
}
