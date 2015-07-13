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

namespace Front\Language\English\Account;

class Notification {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Notifications';

		// Text
		$_['lang_text_account']      = 'Dashboard';
		$_['lang_text_settings']     = 'Check the boxes below to set your notification preferences.';
		$_['lang_text_email']        = 'Email';
		$_['lang_text_internal']     = 'Inbox';
		$_['lang_text_success']      = 'You have successfully updated your notification settings.';
		$_['lang_text_empty']        = 'You have no notifications.';
		$_['lang_text_success']      = 'You have successfully deleted a notification.';
		$_['lang_not_available']     = 'This email is no longer available for viewing online.';

		// Column
		$_['lang_column_message']    = 'Message';
		$_['lang_column_read']       = 'Read';


		// Tab
		$_['lang_tab_notifications'] = 'Inbox';
		$_['lang_tab_settings']      = 'Settings';

		return $_;
	}
}
