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

class Recurring {
	public static function lang() {
		// heading
		$_['lang_heading_title']                        = 'Recurring Payments';

		// text
		$_['lang_text_empty']                           = 'No recurring payment profiles found.';
		$_['lang_text_product']                         = 'Product: ';
		$_['lang_text_order']                           = 'Order: ';
		$_['lang_text_quantity']                        = 'Quantity: ';
		$_['lang_text_account']                         = 'Account';
		$_['lang_text_action']                          = 'Action';
		$_['lang_text_recurring']                       = 'Recurring Payment';
		$_['lang_text_transactions']                    = 'Transactions';
		$_['lang_text_empty_transactions']              = 'No transactions for this recurring payment profile.';
		$_['lang_text_recurring_detail']                = 'Recurring Payment Details';
		$_['lang_text_recurring_id']                    = 'Profile ID: ';
		$_['lang_text_payment_method']                  = 'Payment Method: ';
		$_['lang_text_date_added']                      = 'Created: ';
		$_['lang_text_recurring_description']           = 'Description: ';
		$_['lang_text_status']                          = 'Status: ';
		$_['lang_text_ref']                             = 'Reference: ';
		$_['lang_text_status_active']                   = 'Active';
		$_['lang_text_status_inactive']                 = 'Inactive';
		$_['lang_text_status_cancelled']                = 'Cancelled';
		$_['lang_text_status_suspended']                = 'Suspended';
		$_['lang_text_status_expired']                  = 'Expired';
		$_['lang_text_status_pending']                  = 'Pending';
		$_['lang_text_transaction_date_added']          = 'Created';
		$_['lang_text_transaction_payment']             = 'Payment';
		$_['lang_text_transaction_outstanding_payment'] = 'Outstanding Payment';
		$_['lang_text_transaction_skipped']             = 'Payment Skipped';
		$_['lang_text_transaction_failed']              = 'Payment Failed';
		$_['lang_text_transaction_cancelled']           = 'Cancelled';
		$_['lang_text_transaction_suspended']           = 'Suspended';
		$_['lang_text_transaction_suspended_failed']    = 'Suspended from Failed Payment';
		$_['lang_text_transaction_outstanding_failed']  = 'Outstanding Payment Failed';
		$_['lang_text_transaction_expired']             = 'Expired';
		$_['lang_text_cancelled']                       = 'Recurring payment has been cancelled.';
		$_['lang_text_confirm_cancel']                  = 'Are you sure you want to cancel this payment, this cannot be undone?';

		// button
		$_['lang_button_continue']                      = 'Continue';
		$_['lang_button_view']                          = 'View';
		$_['lang_button_return']                        = 'Return';

		// column
		$_['lang_column_date_added']                    = 'Created';
		$_['lang_column_type']                          = 'Type';
		$_['lang_column_amount']                        = 'Amount';
		$_['lang_column_status']                        = 'Status';
		$_['lang_column_product']                       = 'Product';
		$_['lang_column_action']                        = 'Action';
		$_['lang_column_recurring_id']                  = 'Profile ID';

		// error
		$_['lang_error_not_cancelled']                  = 'Error: %s';
		$_['lang_error_not_found']                      = 'Could not cancel recurring payment.';

		return $_;
	}
}
