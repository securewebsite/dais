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

class SaleShipping {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Shipping Report';

		// Text
		$_['lang_text_year']         = 'Years';
		$_['lang_text_month']        = 'Months';
		$_['lang_text_week']         = 'Weeks';
		$_['lang_text_day']          = 'Days';
		$_['lang_text_all_status']   = 'Status (All)';

		// Column
		$_['lang_column_date_start'] = 'Date Start';
		$_['lang_column_date_end']   = 'Date End';
		$_['lang_column_title']      = 'Shipping Title';
		$_['lang_column_orders']     = 'No. Orders';
		$_['lang_column_total']      = 'Total';

		// Entry
		$_['lang_entry_date_start']  = 'Date Start:';
		$_['lang_entry_date_end']    = 'Date End:';
		$_['lang_entry_group']       = 'Group By:';
		$_['lang_entry_status']      = 'Order Status:';

		return $_;
	}
}
