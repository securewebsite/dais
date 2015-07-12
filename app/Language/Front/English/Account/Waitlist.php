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

namespace App\Language\Front\English\Account;

class Waitlist {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Your Wait Lists';

		// Text
		$_['lang_text_no_waitlists'] = 'You are not on any wait lists.';
		$_['lang_text_waitlists']    = 'Wait Lists';
		$_['lang_text_dashboard']    = 'Dashboard';
		$_['lang_text_remove']       = 'Remove from Wait List';

		// Column
		$_['lang_column_event']      = 'Event Name';
		$_['lang_column_start_date'] = 'Event Date';
		$_['lang_column_location']   = 'Event Location';
		$_['lang_column_telephone']  = 'Telephone';
		$_['lang_column_action']     = 'Action';

		// Button
		$_['lang_button_remove']     = 'Remove';

		return $_;
	}
}
