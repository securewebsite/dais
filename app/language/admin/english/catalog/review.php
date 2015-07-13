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

namespace Admin\Language\English\Catalog;

class Review {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Reviews';

		// Text
		$_['lang_text_success']      = 'Success: You have modified reviews.';

		// Column
		$_['lang_column_product']    = 'Product';
		$_['lang_column_author']     = 'Author';
		$_['lang_column_rating']     = 'Rating';
		$_['lang_column_status']     = 'Status';
		$_['lang_column_date_added'] = 'Date Added';
		$_['lang_column_action']     = 'Action';

		// Entry
		$_['lang_entry_product']     = 'Product:<br/><span class="help">(Autocomplete)</span>';
		$_['lang_entry_author']      = 'Author:';
		$_['lang_entry_rating']      = 'Rating:';
		$_['lang_entry_status']      = 'Status:';
		$_['lang_entry_text']        = 'Text:';
		$_['lang_entry_good']        = 'Good';
		$_['lang_entry_bad']         = 'Bad';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify reviews.';
		$_['lang_error_product']     = 'Product required.';
		$_['lang_error_author']      = 'Author must be between 3 and 64 characters.';
		$_['lang_error_text']        = 'Review Text must be at least 1 character.';
		$_['lang_error_rating']      = 'Review rating required.';

		return $_;
	}
}
