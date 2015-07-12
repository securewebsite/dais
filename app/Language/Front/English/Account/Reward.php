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

class Reward {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Your Reward Points';

		// Column
		$_['lang_column_date_added']  = 'Date Added';
		$_['lang_column_description'] = 'Description';
		$_['lang_column_points']      = 'Points';

		// Text
		$_['lang_text_account']       = 'Dashboard';
		$_['lang_text_reward']        = 'Reward Points';
		$_['lang_text_total']         = 'Your total number of reward points is:';
		$_['lang_text_empty']         = 'You do not have any reward points.';

		return $_;
	}
}
