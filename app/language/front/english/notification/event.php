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

namespace Front\Language\English\Notification;

class Event {
	public static function lang() {
		$_['lang_column_event_name'] = 'Event Name:';
		$_['lang_column_date_time']  = 'Date and Time:';
		$_['lang_column_location']   = 'Location:';
		$_['lang_column_telephone']  = 'Telephone:';

		return $_;
	}
}
