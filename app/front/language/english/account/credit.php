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

class Credit {
	public static function lang() {
		// Heading
		$_['lang_heading_title']      = 'Your Credits';

		// Column
		$_['lang_column_date_added']  = 'Date Added';
		$_['lang_column_description'] = 'Description';
		$_['lang_column_amount']      = 'Amount (%s)';

		// Text
		$_['lang_text_account']       = 'Dashboard';
		$_['lang_text_transaction']   = 'Your Credits';
		$_['lang_text_total']         = 'Your current balance is:';
		$_['lang_text_empty']         = 'You do not have any credits.';

		return $_;
	}
}
