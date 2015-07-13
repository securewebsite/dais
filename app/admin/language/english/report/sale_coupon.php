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

class SaleCoupon {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Coupon Report';

		// Column
		$_['lang_column_name']      = 'Coupon Name';
		$_['lang_column_code']      = 'Code';
		$_['lang_column_orders']    = 'Orders';
		$_['lang_column_total']     = 'Total';
		$_['lang_column_action']    = 'Action';

		// Entry
		$_['lang_entry_date_start'] = 'Date Start:';
		$_['lang_entry_date_end']   = 'Date End:';

		return $_;
	}
}
