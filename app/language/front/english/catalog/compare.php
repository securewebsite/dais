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

namespace Front\Language\English\Catalog;

class Compare {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Product Comparison';

		// Text
		$_['lang_text_product']      = 'Product Details';
		$_['lang_text_name']         = 'Product';
		$_['lang_text_image']        = 'Image';
		$_['lang_text_price']        = 'Price';
		$_['lang_text_model']        = 'Model';
		$_['lang_text_manufacturer'] = 'Brand';
		$_['lang_text_availability'] = 'Availability';
		$_['lang_text_instock']      = 'In Stock';
		$_['lang_text_rating']       = 'Rating';
		$_['lang_text_reviews']      = 'Based on %s reviews.';
		$_['lang_text_summary']      = 'Summary';
		$_['lang_text_weight']       = 'Weight';
		$_['lang_text_dimension']    = 'Dimensions (L x W x H)';
		$_['lang_text_compare']      = 'Product Compare (%s)';
		$_['lang_text_success']      = 'Success: You have added <a href="%s">%s</a> to your <a href="%s">product comparison</a>.';
		$_['lang_text_remove']       = 'Success: You have modified your product comparison.';
		$_['lang_text_empty']        = 'You have not chosen any products to compare.';

		return $_;
	}
}
