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

class Returns {
	public static function lang() {
		// Heading
		$_['lang_heading_title']        = 'Product Returns';

		// Text
		$_['lang_text_opened']          = 'Opened';
		$_['lang_text_unopened']        = 'Unopened';
		$_['lang_text_success']         = 'Success: You have modified returns.';
		$_['lang_text_wait']            = 'Please Wait.';

		// Text
		$_['lang_text_return_id']       = 'Return ID:';
		$_['lang_text_order_id']        = 'Order ID:';
		$_['lang_text_date_ordered']    = 'Order Date:';
		$_['lang_text_customer']        = 'Customer:';
		$_['lang_text_email']           = 'E-Mail:';
		$_['lang_text_telephone']       = 'Telephone:';
		$_['lang_text_return_status']   = 'Return Status:';
		$_['lang_text_date_added']      = 'Date Added:';
		$_['lang_text_date_modified']   = 'Date Modified:';
		$_['lang_text_product']         = 'Product:';
		$_['lang_text_model']           = 'Model:';
		$_['lang_text_quantity']        = 'Quantity:';
		$_['lang_text_return_reason']   = 'Return Reason:';
		$_['lang_text_return_action']   = 'Return Action:';
		$_['lang_text_comment']         = 'Comment:';

		// Column
		$_['lang_column_return_id']     = 'Return ID';
		$_['lang_column_order_id']      = 'Order ID';
		$_['lang_column_customer']      = 'Customer';
		$_['lang_column_product']       = 'Product';
		$_['lang_column_model']         = 'Model';
		$_['lang_column_status']        = 'Status';
		$_['lang_column_date_added']    = 'Date Added';
		$_['lang_column_date_modified'] = 'Date Modified';
		$_['lang_column_comment']       = 'Comment';
		$_['lang_column_notify']        = 'Customer Notified';
		$_['lang_column_action']        = 'Action';

		// Entry
		$_['lang_entry_customer']       = 'Customer:';
		$_['lang_entry_order_id']       = 'Order ID:';
		$_['lang_entry_date_ordered']   = 'Order Date:';
		$_['lang_entry_firstname']      = 'First Name:';
		$_['lang_entry_lastname']       = 'Last Name:';
		$_['lang_entry_email']          = 'E-Mail:';
		$_['lang_entry_telephone']      = 'Telephone:';
		$_['lang_entry_product']        = 'Product:<br /><span class="help">(Autocomplete)</span>';
		$_['lang_entry_model']          = 'Model:';
		$_['lang_entry_quantity']       = 'Quantity:';
		$_['lang_entry_reason']         = 'Return Reason:';
		$_['lang_entry_opened']         = 'Opened:';
		$_['lang_entry_comment']        = 'Comment:';
		$_['lang_entry_return_status']  = 'Return Status:';
		$_['lang_entry_notify']         = 'Notify Customer:';
		$_['lang_entry_action']         = 'Return Action:';

		// Error
		$_['lang_error_warning']        = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']     = 'Warning: You do not have permission to modify returns.';
		$_['lang_error_order_id']       = 'Order ID required.';
		$_['lang_error_firstname']      = 'First name must be between 1 and 32 characters.';
		$_['lang_error_lastname']       = 'Last name must be between 1 and 32 characters.';
		$_['lang_error_email']          = 'E-Mail address does not appear to be valid.';
		$_['lang_error_telephone']      = 'Telephone must be between 3 and 32 characters.';
		$_['lang_error_product']        = 'Product name must be greater than 3 and less than 255 characters.';
		$_['lang_error_model']          = 'Product model must be greater than 3 and less than 64 characters.';

		return $_;
	}
}
