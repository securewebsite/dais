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

class Page {
	public static function lang() {
		// Heading
		$_['lang_heading_title']          = 'Page';

		// Text
		$_['lang_text_success']           = 'Success: You have modified pages.';
		$_['lang_text_default']           = 'Default';
		$_['lang_text_build']             = 'Build Slug';
		$_['lang_text_posted']            = 'Posted';
		$_['lang_text_draft']             = 'Draft';

		// Column
		$_['lang_column_title']           = 'Page Title';
		$_['lang_column_sort_order']      = 'Sort Order';
		$_['lang_column_action']          = 'Action';

		// Entry
		$_['lang_entry_title']            = 'Page Title:';
		$_['lang_entry_description']      = 'Content:';
		$_['lang_entry_meta_keyword']     = 'Meta Keywords:<br><span class="help">Once you\'ve filled in your content, click the generate button to generate keywords from your content.</span>';
		$_['lang_entry_meta_description'] = 'Meta Description:<br><span class="help">Once you\'ve filled in your content, click the generate button to generate a description from your content.</span>';
		$_['lang_entry_tag']              = 'Tags:<br><span class="help">Comma separated search tags.</span>';
		$_['lang_entry_store']            = 'Stores:';
		$_['lang_entry_slug']             = 'URL Slug:<br /><span class="help">Do not use spaces instead replace spaces with - and make sure the slug is globally unique.</span>';
		$_['lang_entry_bottom']           = 'Bottom:<br/><span class="help">Display in the bottom footer.</span>';
		$_['lang_entry_status']           = 'Status:';
		$_['lang_entry_sort_order']       = 'Sort Order:';
		$_['lang_entry_layout']           = 'Layout Override:';
		$_['lang_entry_visibility']       = 'Visibility';
		$_['lang_entry_event']            = 'Event:<br><span class="help">This page is linked to an event.</span>';

		// Error
		$_['lang_error_warning']          = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']       = 'Warning: You do not have permission to modify pages.';
		$_['lang_error_title']            = 'Page Title must be between 3 and 64 characters.';
		$_['lang_error_description']      = 'Content must be more than 3 characters.';
		$_['lang_error_account']          = 'Warning: This page cannot be deleted as it is currently assigned to the store account terms.';
		$_['lang_error_checkout']         = 'Warning: This page cannot be deleted as it is currently assigned to the store checkout terms.';
		$_['lang_error_affiliate']        = 'Warning: This page cannot be deleted as it is currently assigned to the store affiliate terms.';
		$_['lang_error_store']            = 'Warning: This page cannot be deleted as it is currently being used by %s store(s).';
		$_['lang_error_event']            = 'Warning: This page cannot be deleted as it is currently being used by %s event(s).';
		$_['lang_error_slug']             = 'Warning: Slug is required for pages.';
		$_['lang_error_slug_found']       = 'ERROR: The slug %s is already in use, please set a different one in the input field.';
		$_['lang_error_name_first']       = 'ERROR: Please enter a title for your page before attempting to build a slug.';

		return $_;
	}
}
