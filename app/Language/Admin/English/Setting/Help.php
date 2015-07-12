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

namespace App\Language\Admin\English\Setting;

class Help {
	public static function lang() {
		// Heading
		$_['lang_heading_title'] = 'Dais Documentation';

		// Text
		$_['lang_text_welcome']  = '<p>Welcome to the Dais Documentation. This section is a work in progress and will be updated as the application development continues.</p><p>Please use the tabs to navigate through the various sections of the docs.</p>';
		$_['lang_text_events']   = '<p>All the following events are built in to the Dais system and are fired each time the given Class\Method is executed. This allows you to program hooks and other callbacks to be executed in Plugins or Themes when a given event occurs.</p>';

		// Tab
		$_['lang_tab_events']    = 'Events';
		$_['lang_tab_welcome']   = 'Welcome';

		// Columns
		$_['lang_column_event']  = 'Event Name';
		$_['lang_column_param']  = 'Params';
		$_['lang_column_class']  = 'Class\Method';

		return $_;
	}
}
