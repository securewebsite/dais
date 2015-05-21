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

namespace Admin\Language\English\Widget;

class Event {
	public static function lang() {
		// Heading
		$_['lang_heading_title']       = 'Events';

		// Text
		$_['lang_text_widget']         = 'Widgets';
		$_['lang_text_success']        = 'Success: You have modified widget Events.';
		$_['lang_text_content_top']    = 'Content Top';
		$_['lang_text_content_bottom'] = 'Content Bottom';
		$_['lang_text_column_left']    = 'Column Left';
		$_['lang_text_column_right']   = 'Column Right';

		// Entry
		$_['lang_entry_layout']        = 'Layout:';
		$_['lang_entry_position']      = 'Position:';
		$_['lang_entry_status']        = 'Status:';
		$_['lang_entry_sort_order']    = 'Sort Order:';

		// Error
		$_['lang_error_permission']    = 'Warning: You do not have permission to modify widget Events.';

		return $_;
	}
}
