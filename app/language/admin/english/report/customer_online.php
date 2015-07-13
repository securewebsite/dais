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

namespace Admin\Language\English\Report;

class CustomerOnline {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Customers Online Report';

		// Text
		$_['lang_text_guest']        = 'Guest';

		// Column
		$_['lang_column_ip']         = 'IP';
		$_['lang_column_customer']   = 'Customer';
		$_['lang_column_url']        = 'Last Page Visited';
		$_['lang_column_referer']    = 'Referrer';
		$_['lang_column_date_added'] = 'Last Click';
		$_['lang_column_action']     = 'Action';

		return $_;
	}
}
