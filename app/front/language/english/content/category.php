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

namespace Front\Language\English\Content;

class Category {
	public static function lang() {
		// Text
		$_['lang_text_refine']            = 'Refine Search';
		$_['lang_text_error']             = 'Category not found.';
		$_['lang_text_empty']             = 'There are no posts yet in this category.';
		$_['lang_text_comments']          = '%s comments';
		$_['lang_text_views']             = '%s reads';
		$_['lang_text_all_posts']         = 'All Articles in';
		$_['lang_text_all_by']            = 'All Articles by';
		$_['lang_text_in']                = 'in';
		$_['lang_text_tag']               = 'Tags:';
		$_['lang_text_posted_categories'] = '<a href="%s">%s</a>';

		return $_;
	}
}
