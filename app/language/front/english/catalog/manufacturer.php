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

class Manufacturer {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Find Your Favorite Brand';

		// Text
		$_['lang_text_brand']        = 'Brand';
		$_['lang_text_index']        = 'Brand Index <span class="fa fa-caret-right"></span>';
		$_['lang_text_error']        = 'Brand not found.';
		$_['lang_text_empty']        = 'There are no products to list.';
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

		return $_;
	}
}
