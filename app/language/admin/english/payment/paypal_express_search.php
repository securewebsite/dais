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

namespace Admin\Language\English\Payment;

class PaypalExpressSearch {
	public static function lang() {
		//Headings
		$_['lang_heading_title']            = 'Search Transactions';

		//Text
		$_['lang_text_searching']           = 'Searching';
		$_['lang_text_name']                = 'Name';
		$_['lang_text_buyer_info']          = 'Buyer information';
		$_['lang_text_view']                = 'View';
		$_['lang_text_paypal_express']       = 'PayPal Express Checkout';

		//Table column
		$_['lang_column_date']              = 'Date';
		$_['lang_column_type']              = 'Type';
		$_['lang_column_email']             = 'Email';
		$_['lang_column_name']              = 'Name';
		$_['lang_column_transid']           = 'Transaction ID';
		$_['lang_column_status']            = 'Status';
		$_['lang_column_currency']          = 'Currency';
		$_['lang_column_amount']            = 'Amount';
		$_['lang_column_fee']               = 'Fee';
		$_['lang_column_netamt']            = 'Net Amount';
		$_['lang_column_action']            = 'Action';

		//Button
		$_['lang_button_search']            = 'Search';
		$_['lang_button_edit_search']       = 'Edit Search';

		//Form entry status
		$_['lang_entry_status_all']         = 'All';
		$_['lang_entry_status_pending']     = 'Pending';
		$_['lang_entry_status_processing']  = 'Processing';
		$_['lang_entry_status_success']     = 'Success';
		$_['lang_entry_status_denied']      = 'Denied';
		$_['lang_entry_status_reversed']    = 'Reversed';
		$_['lang_entry_trans_all']          = 'All';
		$_['lang_entry_trans_sent']         = 'Sent';
		$_['lang_entry_trans_received']     = 'Received';
		$_['lang_entry_trans_masspay']      = 'Mass Pay';
		$_['lang_entry_trans_money_req']    = 'Money Request';
		$_['lang_entry_trans_funds_add']    = 'Funds Added';
		$_['lang_entry_trans_funds_with']   = 'Funds Withdrawn';
		$_['lang_entry_trans_referral']     = 'Referral';
		$_['lang_entry_trans_fee']          = 'Fee';
		$_['lang_entry_trans_subscription'] = 'Subscription';
		$_['lang_entry_trans_dividend']     = 'Dividend';
		$_['lang_entry_trans_billpay']      = 'Bill Pay';
		$_['lang_entry_trans_refund']       = 'Refund';
		$_['lang_entry_trans_conv']         = 'Currency Conversion';
		$_['lang_entry_trans_bal_trans']    = 'Balance Transfer';
		$_['lang_entry_trans_reversal']     = 'Reversal';
		$_['lang_entry_trans_shipping']     = 'Shipping';
		$_['lang_entry_trans_bal_affect']   = 'Balance Affecting';
		$_['lang_entry_trans_echeck']       = 'E Check';
		$_['lang_entry_date']               = 'Date';
		$_['lang_entry_date_start']         = 'Date Start';
		$_['lang_entry_date_end']           = 'Date End';
		$_['lang_entry_date_to']            = 'to';
		$_['lang_entry_transaction']        = 'Transaction';
		$_['lang_entry_transaction_type']   = 'Type';
		$_['lang_entry_transaction_status'] = 'Status';
		$_['lang_entry_email']              = 'Email';
		$_['lang_entry_email_buyer']        = 'Buyer';
		$_['lang_entry_email_merchant']     = 'Receiver';
		$_['lang_entry_receipt']            = 'Receipt ID';
		$_['lang_entry_transaction_id']     = 'Transaction ID';
		$_['lang_entry_invoice_no']         = 'Invoice number';
		$_['lang_entry_auction']            = 'Auction item number';
		$_['lang_entry_amount']             = 'Amount';
		$_['lang_entry_profile_id']         = 'Profile ID';
		$_['lang_entry_salutation']         = 'Salutation';
		$_['lang_entry_firstname']          = 'First';
		$_['lang_entry_middlename']         = 'Middle';
		$_['lang_entry_lastname']           = 'Last';
		$_['lang_entry_suffix']             = 'Suffix';

		return $_;
	}
}
