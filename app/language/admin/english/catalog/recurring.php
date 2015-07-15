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

namespace App\Language\Admin\English\Catalog;

class Recurring {
	public static function lang() {
		// Heading
		$_['lang_heading_title']         = 'Recurring Profiles';

		// Text
		$_['lang_text_success']          = 'Success: You have modified recurring profiles!';
		$_['lang_text_list']             = 'Recurring Profile List';
		$_['lang_text_add']              = 'Add Recurring Profile';
		$_['lang_text_edit']             = 'Edit Recurring Profile';
		$_['lang_text_day']              = 'Day';
		$_['lang_text_week']             = 'Week';
		$_['lang_text_semi_month']       = 'Semi Month';
		$_['lang_text_month']            = 'Month';
		$_['lang_text_year']             = 'Year';
		$_['lang_text_recurring']        = 'Recurring amounts are calculated by the frequency and cycles.<br>For example if you use a frequency of "week" and a cycle of "2", then the user will be billed every 2 weeks.<br>The duration is the number of times the user will make a payment, set this to 0 if you want payments until they are cancelled.';
		$_['lang_text_profile']          = 'Recurring Profile';
		$_['lang_text_trial']            = 'Trial Profile';

		// Entry
		$_['lang_entry_name']            = 'Name';
		$_['lang_entry_price']           = 'Price';
		$_['lang_entry_duration']        = 'Duration';
		$_['lang_entry_cycle']           = 'Cycle';
		$_['lang_entry_frequency']       = 'Frequency';
		$_['lang_entry_trial_price']     = 'Trial price';
		$_['lang_entry_trial_duration']  = 'Trial duration';
		$_['lang_entry_trial_status']    = 'Trial status';
		$_['lang_entry_trial_cycle']     = 'Trial cycle';
		$_['lang_entry_trial_frequency'] = 'Trial frequency';
		$_['lang_entry_status']          = 'Status';
		$_['lang_entry_sort_order']      = 'Sort Order';

		// Column
		$_['lang_column_name']           = 'Name';
		$_['lang_column_sort_order']     = 'Sort Order';
		$_['lang_column_action']         = 'Action';

		// Error
		$_['lang_error_warning']         = 'Warning: Please check the form carefully for errors!';
		$_['lang_error_permission']      = 'Warning: You do not have permission to modify recurring profiles!';
		$_['lang_error_name']            = 'Profile Name must be greater than 3 and less than 255 characters!';
		$_['lang_error_product']         = 'Warning: This recurring profile cannot be deleted as it is currently assigned to %s products!';

		return $_;
	}
}
