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

namespace Admin\Language\English\Module;

class Notification {
	public static function lang() {
		// Heading
		$_['lang_heading_title']            = 'Notifications';

		// Text
		$_['lang_text_system']              = 'System';
		$_['lang_text_user']                = 'User';
		$_['lang_text_success']             = 'Success: You have modified notifications.';
		$_['lang_text_admin']               = 'Administrator';
		$_['lang_text_customer']            = 'Customer';
		$_['lang_text_send_now']            = 'Send Immediately';
		$_['lang_text_send_queue']          = 'Add to Queue';
		$_['lang_text_queue']               = 'Queue';
		$_['lang_text_immediate']           = 'Immediate';

		// Column
		$_['lang_column_name']              = 'Name';
		$_['lang_column_slug']              = 'Slug';
		$_['lang_column_type']              = 'Type';
		$_['lang_column_action']            = 'Action';
		$_['lang_column_priority']          = 'Priority';

		// Entry
		$_['lang_entry_subject']            = 'Subject:<br><span class="help">The subject for your notification.</span>';
		$_['lang_entry_email_slug']         = 'Function Slug:<br><span class="help">This is the function slug that\'s used to call your notification throughout the Dais system. Only user added notification slugs are editable.</span>';
		$_['lang_entry_text']               = 'Text Version:<br><span class="help">Text version of your notification, sent only in emails.</span>';
		$_['lang_entry_html']               = 'HTML Version:<br><span class="help">HTML version of your notification, sent in both emails and internal notifications.</span>';
		$_['lang_entry_config']             = 'Opt-Out?:<br><span class="help">Can the customer opt-out or configure this notification.</span>';
		$_['lang_entry_config_description'] = 'Description:<br><span class="help">If opt-out is set to true, enter a brief description of this notification for the user.</span>';
		$_['lang_entry_recipient']          = 'Recipient:<br><span class="help">For which group of people is this notifcation intended?</span>';
		$_['lang_entry_priority']           = 'Priority:<br><span class="help">Set priority for email sending. Most all emails should be queued in order to lighten the load on the server.</span>';


		// Error
		$_['lang_error_warning']            = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']         = 'Warning: You do not have permission to modify notifications.';
		$_['lang_error_subject']            = 'Subject is required.';
		$_['lang_error_text']               = 'Text version is required.';
		$_['lang_error_html']               = 'HTML version is required.';
		$_['lang_error_email_slug']         = 'A function slug is required for your notification.';
		$_['lang_error_system']             = 'System notifications cannot be deleted.';
		$_['lang_error_description']        = 'If Opt-Out is set to true, you must enter a description for the end user.';

		return $_;
	}
}
