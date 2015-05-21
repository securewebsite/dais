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

class CustomerReward {
	public static function lang() {
		// Heading
		$_['lang_heading_title']         = 'Customer Reward Points Report';

		// Column
		$_['lang_column_customer']       = 'Customer Name';
		$_['lang_column_email']          = 'E-Mail';
		$_['lang_column_customer_group'] = 'Customer Group';
		$_['lang_column_status']         = 'Status';
		$_['lang_column_points']         = 'Reward Points';
		$_['lang_column_orders']         = 'No. Orders';
		$_['lang_column_total']          = 'Total';
		$_['lang_column_action']         = 'Action';

		// Entry
		$_['lang_entry_date_start']      = 'Date Start:';
		$_['lang_entry_date_end']        = 'Date End:';

		return $_;
	}
}
