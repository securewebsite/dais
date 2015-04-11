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

//Headings
$_['lang_heading_title']                  = 'PayPal Payflow Pro iFrame';
$_['lang_heading_refund']                 = 'Refund';

//Table columns
$_['lang_column_transaction_id']          = 'Transaction ID';
$_['lang_column_transaction_type']        = 'Transaction Type';
$_['lang_column_amount']                  = 'Amount';
$_['lang_column_time']                    = 'Time';
$_['lang_column_actions']                 = 'Actions';

//Text
$_['lang_text_payment']                   = 'Payment';
$_['lang_text_success']                   = 'Success: You have modified PayPal Payflow Pro iFrame account details.';
$_['lang_text_payflowiframe']             = '<a onclick="window.open(\'\');"><img src="asset/default/img/payment/paypal.png" alt="PayPal Payflow Pro" title="PayPal Payflow Pro iFrame" style="border: 1px solid #EEEEEE;" /></a>';
$_['lang_text_authorization']             = 'Authorization';
$_['lang_text_sale']                      = 'Sale';
$_['lang_text_authorise']                 = 'Authorize';
$_['lang_text_capture']                   = 'Delayed Capture';
$_['lang_text_void']                      = 'Void';
$_['lang_text_payment_info']              = 'Payment information';
$_['lang_text_complete']                  = 'Complete';
$_['lang_text_incomplete']                = 'Incomplete';
$_['lang_text_transaction']               = 'Transaction';
$_['lang_text_confirm_void']              = 'If you void this transaction you cannot capture any further funds';
$_['lang_text_refund']                    = 'Refund';
$_['lang_text_refund_issued']             = 'Refund was issued successfully';
$_['lang_text_redirect']                  = 'Redirect';
$_['lang_text_iframe']                    = 'iframe';
$_['lang_help_vendor']                    = 'The merchant login ID that you created when you registered for the Website Payments Pro account.';
$_['lang_help_user']                      = 'If you set up one or more additional users on the account, this value is the ID of the user authorized to process transactions. If, however, you have not set up additional users on the account, USER has the same value as VENDOR.';
$_['lang_help_password']                  = 'The 6 to 32 character password that you defined while registering for the account.';
$_['lang_help_partner']                   = 'The ID provided to you by the authorised PayPal Reseller who registered you for the Payflow SDK. If you purchased your account directly from PayPal, use PayPal';
$_['lang_help_checkout_method']           = "Please use redirect method if you do not have SSL installed, or if you do not have Pay with PayPal option disabled on your hosted payment page.";
$_['lang_help_debug']                     = "Logs additional information.";

//Buttons
$_['lang_button_refund']                  = 'Refund';
$_['lang_button_void']                    = 'Void';
$_['lang_button_capture']                 = 'Capture';

//Tabs
$_['lang_tab_settings']                   = 'Settings';
$_['lang_tab_order_status']               = 'Order Status';
$_['lang_tab_checkout_customisation']     = 'Checkout Customization';

//Form entry
$_['lang_entry_vendor']                   = 'Vendor:';
$_['lang_entry_user']                     = 'User:';
$_['lang_entry_password']                 = 'Password:';
$_['lang_entry_partner']                  = 'Partner:';
$_['lang_entry_test']                     = 'Test Mode:<br /><span class="help">Use the live or testing (sandbox) gateway server to process transactions? Test may fail in Internet Explorer</span>';
$_['lang_entry_total']                    = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['lang_entry_order_status']             = 'Order Status:';
$_['lang_entry_geo_zone']                 = 'Geo Zone:';
$_['lang_entry_status']                   = 'Status:';
$_['lang_entry_sort_order']               = 'Sort Order:';
$_['lang_entry_transaction_method']       = 'Transaction method:';
$_['lang_entry_transaction_id']           = 'Transaction ID';
$_['lang_entry_full_refund']              = 'Full refund';
$_['lang_entry_amount']                   = 'Amount';
$_['lang_entry_message']                  = 'Message';
$_['lang_entry_ipn_url']                  = 'IPN URL:';
$_['lang_entry_checkout_method']          = 'Checkout Method:';
$_['lang_entry_debug']                    = 'Debug mode:';
$_['lang_entry_transaction_reference']    = 'Transaction Reference';
$_['lang_entry_transaction_amount']       = 'Transaction Amount';
$_['lang_entry_refund_amount']            = 'Refund Amount';
$_['lang_entry_capture_status']           = 'Capture Status';
$_['lang_entry_void']                     = 'Void';
$_['lang_entry_capture']                  = 'Capture';
$_['lang_entry_transactions']             = 'Transactions';
$_['lang_entry_complete_capture']         = 'Complete Capture';
$_['lang_entry_canceled_reversal_status'] = 'Cancelled Reversal Status:';
$_['lang_entry_completed_status']         = 'Completed Status:';
$_['lang_entry_denied_status']            = 'Denied Status:';
$_['lang_entry_expired_status']           = 'Expired Status:';
$_['lang_entry_failed_status']            = 'Failed Status:';
$_['lang_entry_pending_status']           = 'Pending Status:';
$_['lang_entry_processed_status']         = 'Processed Status:';
$_['lang_entry_refunded_status']          = 'Refunded Status:';
$_['lang_entry_reversed_status']          = 'Reversed Status:';
$_['lang_entry_voided_status']            = 'Voided Status:';
$_['lang_entry_cancel_url']               = 'Cancel URL:';
$_['lang_entry_error_url']                = 'Error URL:';
$_['lang_entry_return_url']               = 'Return URL:';
$_['lang_entry_post_url']                 = 'Silent POST URL:';

//Errors
$_['lang_error_permission']               = 'Warning: You do not have permission to modify payment PayPal Website Payment Pro iFrame (UK).';
$_['lang_error_vendor']                   = 'Vendor Required.';
$_['lang_error_user']                     = 'User Required.';
$_['lang_error_password']                 = 'Password Required.';
$_['lang_error_partner']                  = 'Partner Required.';
$_['lang_error_missing_data']             = 'Missing data';
$_['lang_error_missing_order']            = 'Could not locate the order';
$_['lang_error_general']                  = 'There was an error';
$_['lang_error_capture_amt']              = 'Enter the amount to capture';
