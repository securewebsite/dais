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

class PostWall {
	public static function lang() {
		// Heading
		$_['lang_heading_latest']   = 'Latest Posts';
		$_['lang_heading_featured'] = 'Featured Posts';

		// Text
		$_['lang_text_free']        = 'Free';
		$_['lang_text_reviews']     = 'Based on %s reviews.';
		$_['lang_text_empty']       = 'There are no %s posts to show right now.';
		$_['lang_text_read_more']   = 'Read More';

		// Button
		$_['lang_button_view_post'] = '<i class="fa fa-eye"></i> Read More <span class="fa fa-chevron-right"></span>';

		return $_;
	}
}
