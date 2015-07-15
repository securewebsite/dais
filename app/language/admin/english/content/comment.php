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

namespace App\Language\Admin\English\Content;

class Comment {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Blog Comments';

		// Text
		$_['lang_text_success']      = 'Success: You have modified blog comments.';

		// Column
		$_['lang_column_post']       = 'Post';
		$_['lang_column_author']     = 'Author';
		$_['lang_column_rating']     = 'Rating';
		$_['lang_column_status']     = 'Status';
		$_['lang_column_date_added'] = 'Date Added';
		$_['lang_column_action']     = 'Action';

		// Entry
		$_['lang_entry_post']        = 'Post:<br/><span class="help">(Autocomplete)</span>';
		$_['lang_entry_author']      = 'Author:';
		$_['lang_entry_rating']      = 'Rating:';
		$_['lang_entry_status']      = 'Status:';
		$_['lang_entry_text']        = 'Text:';
		$_['lang_entry_good']        = 'Good';
		$_['lang_entry_bad']         = 'Bad';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify comments.';
		$_['lang_error_post']        = 'Post required.';
		$_['lang_error_author']      = 'Author name must be between 3 and 64 characters.';
		$_['lang_error_text']        = 'Comment Text can not be empty.';
		$_['lang_error_rating']      = 'Comment rating required.';

		return $_;
	}
}
