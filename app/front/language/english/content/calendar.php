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

class Calendar {
	public static function lang() {
		// heading
		$_['lang_heading_title'] = 'Event Calendar';

		$_['lang_text_prev']     = 'Prev';
		$_['lang_text_today']    = 'Today';
		$_['lang_text_next']     = 'Next';
		$_['lang_text_year']     = 'Year';
		$_['lang_text_month']    = 'Month';
		$_['lang_text_week']     = 'Week';
		$_['lang_text_day']      = 'Day';

		$_['lang_text_finished'] = 'This event has already ended. Please check the calendar for our next event.';

		return $_;
	}
}
