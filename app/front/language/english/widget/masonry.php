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

class Masonry {
	public static function lang() {
		// Heading
		$_['lang_heading_latest']     = 'Latest Products';
		$_['lang_heading_featured']   = 'Featured Products';
		$_['lang_heading_special']    = 'Specials Products';
		$_['lang_heading_best_seller'] = 'Bestsellers Products';

		// Text
		$_['lang_text_free']          = 'Free';
		$_['lang_text_reviews']       = 'Based on %s reviews.';
		$_['lang_text_empty']         = 'There are no %s products to show right now.';
		$_['lang_text_message']       = '<div class="attention">Bootstrap is required for Masonry module.</div>';
		$_['lang_text_cart_add']      = 'Add to Cart';
		$_['lang_text_view_event']    = 'View Event';

		// Button
		$_['lang_button_add_cart']    = '<i class="fa fa-shopping-cart"></i>';
		$_['lang_button_view_event']  = '<i class="fa fa-users"></i>';

		return $_;
	}
}
