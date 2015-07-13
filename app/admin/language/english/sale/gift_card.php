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

namespace Admin\Language\English\Sale;

class GiftCard {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Gift Card';

		// Text
		$_['lang_text_send']         = 'Send';
		$_['lang_text_success']      = 'Success: You have modified Gift Cards.';
		$_['lang_text_sent']         = 'Success: Gift Card E-mail has been sent.';
		$_['lang_text_wait']         = 'Please Wait.';

		// Column
		$_['lang_column_name']       = 'Gift Card Name';
		$_['lang_column_code']       = 'Code';
		$_['lang_column_from']       = 'From';
		$_['lang_column_to']         = 'To';
		$_['lang_column_theme']      = 'Theme';
		$_['lang_column_amount']     = 'Amount';
		$_['lang_column_status']     = 'Status';
		$_['lang_column_order_id']   = 'Order ID';
		$_['lang_column_customer']   = 'Customer';
		$_['lang_column_date_added'] = 'Date Added';
		$_['lang_column_action']     = 'Action';

		// Entry
		$_['lang_entry_code']        = 'Code:<br /><span class="help">The code the customer enters to activate the Gift Card.</span>';
		$_['lang_entry_from_name']   = 'From Name:';
		$_['lang_entry_from_email']  = 'From E-Mail:';
		$_['lang_entry_to_name']     = 'To Name:';
		$_['lang_entry_to_email']    = 'To E-Mail:';
		$_['lang_entry_theme']       = 'Theme:';
		$_['lang_entry_message']     = 'Message:';
		$_['lang_entry_amount']      = 'Amount:';
		$_['lang_entry_status']      = 'Status:';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify Gift Cards.';
		$_['lang_error_exists']      = 'Warning: Gift Card code is already in use.';
		$_['lang_error_code']        = 'Code must be between 3 and 10 characters.';
		$_['lang_error_to_name']     = 'Recipient\'s name must be between 1 and 64 characters.';
		$_['lang_error_from_name']   = 'Your name must be between 1 and 64 characters.';
		$_['lang_error_email']       = 'E-Mail address does not appear to be valid.';
		$_['lang_error_amount']      = 'Amount must be greater than or equal to 1.';
		$_['lang_error_order']       = 'Warning: This Gift Card cannot be deleted as it is part of an <a href="%s">order</a>.';

		return $_;
	}
}
