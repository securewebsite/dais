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

namespace App\Language\Admin\English\Sale;

class Recurring {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                        = 'Recurring Orders';

		// Text
		$_['lang_text_success']                         = 'Success: You have modified recurring profiles!';
		$_['lang_text_list']                            = 'Recurring Profile List';
		$_['lang_text_add']                             = 'Add Recurring Profile';
		$_['lang_text_edit']                            = 'Edit Recurring Profile';
		$_['lang_text_payment_profiles']                = 'Recurring Orders';
		$_['lang_text_status_active']                   = 'Active';
		$_['lang_text_status_inactive']                 = 'Inactive';
		$_['lang_text_status_cancelled']                = 'Cancelled';
		$_['lang_text_status_suspended']                = 'Suspended';
		$_['lang_text_status_expired']                  = 'Expired';
		$_['lang_text_status_pending']                  = 'Pending';
		$_['lang_text_transactions']                    = 'Transactions';
		$_['lang_text_cancel_confirm']                  = 'Profile\'s cancellation cannot be undone! Are you sure want to do this?';
		$_['lang_text_transaction_date_added']          = 'Date added';
		$_['lang_text_transaction_payment']             = 'Payment';
		$_['lang_text_transaction_outstanding_payment'] = 'Outstanding payment';
		$_['lang_text_transaction_skipped']             = 'Payment skipped';
		$_['lang_text_transaction_failed']              = 'Payment failed';
		$_['lang_text_transaction_cancelled']           = 'Cancelled';
		$_['lang_text_transaction_suspended']           = 'Suspended';
		$_['lang_text_transaction_suspended_failed']    = 'Suspended from failed payment';
		$_['lang_text_transaction_outstanding_failed']  = 'Outstanding payment failed';
		$_['lang_text_transaction_expired']             = 'Expired';
		$_['lang_text_filter']                          = 'Filter';
		$_['lang_text_cancelled']                       = 'Recurring payment has been cancelled';

		// Entry
		$_['lang_entry_cancel_payment']                 = 'Cancel Payment';
		$_['lang_entry_order_recurring']                = 'ID';
		$_['lang_entry_order_id']                       = 'Order ID';
		$_['lang_entry_reference']                      = 'Payment Reference';
		$_['lang_entry_customer']                       = 'Customer';
		$_['lang_entry_date_added']                     = 'Date Added';
		$_['lang_entry_status']                         = 'Status';
		$_['lang_entry_type']                           = 'Type';
		$_['lang_entry_action']                         = 'Action';
		$_['lang_entry_email']                          = 'Email';
		$_['lang_entry_description']                    = 'Recurring Profile\'s description';
		$_['lang_entry_product']                        = 'Product';
		$_['lang_entry_quantity']                       = 'Quantity';
		$_['lang_entry_amount']                         = 'Amount';
		$_['lang_entry_recurring']                      = 'Recurring Profile';
		$_['lang_entry_payment_method']                 = 'Payment Method';

		// Error / Success
		$_['lang_error_not_cancelled']                  = 'Error: %s';
		$_['lang_error_not_found']                      = 'Could not cancel recurring profile';

		return $_;
	}
}
