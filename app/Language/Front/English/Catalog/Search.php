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

namespace App\Language\Front\English\Catalog;

class Search {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Search';

		// Text
		$_['lang_text_search']       = 'Products meeting the search criteria';
		$_['lang_text_keyword']      = 'Keywords';
		$_['lang_text_category']     = 'All Categories';
		$_['lang_text_sub_category'] = 'Search in subcategories';
		$_['lang_text_critea']       = 'Search Criteria';
		$_['lang_text_empty']        = 'There is no product that matches the search criteria.';
		$_['lang_text_quantity']     = 'Qty:';
		$_['lang_text_manufacturer'] = 'Brand:';
		$_['lang_text_model']        = 'Product Code:';
		$_['lang_text_points']       = 'Reward Points:';
		$_['lang_text_price']        = 'Price:';
		$_['lang_text_tax']          = 'Ex Tax:';
		$_['lang_text_reviews']      = 'Based on %s reviews.';
		$_['lang_text_compare']      = 'Product Compare (%s)';
		$_['lang_text_display']      = 'Display:';
		$_['lang_text_list']         = 'List';
		$_['lang_text_grid']         = 'Grid';
		$_['lang_text_sort']         = 'Sort By:';
		$_['lang_text_default']      = 'Default';
		$_['lang_text_name_asc']     = 'Name (A - Z)';
		$_['lang_text_name_desc']    = 'Name (Z - A)';
		$_['lang_text_price_asc']    = 'Price (Low &gt; High)';
		$_['lang_text_price_desc']   = 'Price (High &gt; Low)';
		$_['lang_text_rating_asc']   = 'Rating (Lowest)';
		$_['lang_text_rating_desc']  = 'Rating (Highest)';
		$_['lang_text_model_asc']    = 'Model (A - Z)';
		$_['lang_text_model_desc']   = 'Model (Z - A)';
		$_['lang_text_limit']        = 'Show:';

		// Entry
		$_['lang_entry_search']      = 'Search';
		$_['lang_entry_description'] = 'Search in product descriptions';

		return $_;
	}
}
