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

// Heading
$_['lang_heading_title']             = 'Customer';

// Text
$_['lang_text_success']              = 'Success: You have modified customers.';
$_['lang_text_credit_success']       = 'Success: You have successfully added a credit.';
$_['lang_text_commission_success']   = 'Success: You have successfully added a commission.';
$_['lang_text_reward_success']       = 'Success: You have successfully adjusted reward points.';
$_['lang_text_default']              = 'Default';
$_['lang_text_approved']             = 'You have approved %s accounts.';
$_['lang_text_wait']                 = 'Please Wait.';
$_['lang_text_balance']              = 'Balance:';
$_['lang_text_add_ban_ip']           = 'Add Ban IP';
$_['lang_text_remove_ban_ip']        = 'Remove Ban IP';
$_['lang_text_balance']              = 'Balance:';
$_['lang_text_cheque']               = 'Check';
$_['lang_text_paypal']               = 'PayPal';
$_['lang_text_bank']                 = 'Bank Transfer';
$_['lang_text_confirm_login']        = 'Logging into a customer account will log you out of the Admin area. Click OK if you wish to proceed.';
$_['lang_text_no_referrer']			 = 'No Referrer';

// Column
$_['lang_column_username']           = 'Username';
$_['lang_column_name']               = 'Customer Name';
$_['lang_column_email']              = 'E-Mail';
$_['lang_column_customer_group']     = 'Customer Group';
$_['lang_column_status']             = 'Status';
$_['lang_column_login']              = 'Login to Store';
$_['lang_column_approved']           = 'Approved';
$_['lang_column_date_added']         = 'Date Added';
$_['lang_column_comment']            = 'Comment';
$_['lang_column_description']        = 'Description';
$_['lang_column_amount']             = 'Amount';
$_['lang_column_points']             = 'Points';
$_['lang_column_ip']                 = 'IP';
$_['lang_column_total']              = 'Total Accounts';
$_['lang_column_action']             = 'Action';

// Entry
$_['lang_entry_referrer']			 = 'Referred by:';
$_['lang_entry_username']            = 'Username:';
$_['lang_entry_firstname']           = 'First Name:';
$_['lang_entry_lastname']            = 'Last Name:';
$_['lang_entry_email']               = 'E-Mail:';
$_['lang_entry_telephone']           = 'Telephone:';
$_['lang_entry_newsletter']          = 'Newsletter:';
$_['lang_entry_customer_group']      = 'Customer Group:';
$_['lang_entry_status']              = 'Status:';
$_['lang_entry_password']            = 'Password:';
$_['lang_entry_confirm']             = 'Confirm:';
$_['lang_entry_company']             = 'Company:';
$_['lang_entry_company_id']          = 'Company ID:';
$_['lang_entry_tax_id']              = 'Tax ID:';
$_['lang_entry_address_1']           = 'Address 1:';
$_['lang_entry_address_2']           = 'Address 2:';
$_['lang_entry_city']                = 'City:';
$_['lang_entry_postcode']            = 'Postal Code:';
$_['lang_entry_country']             = 'Country:';
$_['lang_entry_zone']                = 'Region / State:';
$_['lang_entry_default']             = 'Default Address:';
$_['lang_entry_comment']             = 'Comment:';
$_['lang_entry_description']         = 'Description:';
$_['lang_entry_amount']              = 'Amount:';
$_['lang_entry_points']              = 'Points:<br /><span class="help">Use minus to remove points</span>';
$_['lang_entry_website']             = 'Website:';
$_['lang_entry_code']                = 'Tracking Code:<span class="help">The tracking code that will be used to track referrals.</span>';
$_['lang_entry_commission']          = 'Commission (%):<span class="help">Percentage the affiliate receives on each order.</span>';
$_['lang_entry_tax_id']              = 'Tax ID:';
$_['lang_entry_payment_method']      = 'Payment Method:';
$_['lang_entry_cheque']              = 'Check Payee Name:';
$_['lang_entry_paypal']              = 'PayPal E-mail Account:';
$_['lang_entry_bank_name']           = 'Bank Name:';
$_['lang_entry_bank_branch_number']  = 'ABA/BSB number (Branch Number):';
$_['lang_entry_bank_swift_code']     = 'SWIFT Code:';
$_['lang_entry_bank_account_name']   = 'Account Name:';
$_['lang_entry_bank_account_number'] = 'Account Number:';
$_['lang_entry_affiliate_status']    = 'Affiliate Status:<br><span class="help">This will enable/disable the customer\'s ability to earn commissions.</span>';

// Error
$_['lang_error_warning']             = 'Warning: Please check the form carefully for errors.';
$_['lang_error_permission']          = 'Warning: You do not have permission to modify customers.';
$_['lang_error_exists']              = 'Warning: E-Mail Address or Username is already registered.';
$_['lang_error_username']            = 'Username must be between 3 and 16 characters.';
$_['lang_error_firstname']           = 'First name must be between 1 and 32 characters.';
$_['lang_error_lastname']            = 'Last name must be between 1 and 32 characters.';
$_['lang_error_email']               = 'E-Mail address does not appear to be valid.';
$_['lang_error_telephone']           = 'Telephone must be between 3 and 32 characters.';
$_['lang_error_password']            = 'Password must be between 4 and 20 characters.';
$_['lang_error_confirm']             = 'Password and password confirmation do not match.';
$_['lang_error_company_id']          = 'Company ID required.';
$_['lang_error_vat']                 = 'VAT number is invalid.';
$_['lang_error_address_1']           = 'Address 1 must be between 3 and 128 characters.';
$_['lang_error_city']                = 'City must be between 2 and 128 characters.';
$_['lang_error_postcode']            = 'Postal code must be between 2 and 10 characters for this country.';
$_['lang_error_country']             = 'Please select a country.';
$_['lang_error_zone']                = 'Please select a region / state.';
$_['lang_error_code']                = 'Tracking code required.';
$_['lang_error_commission']          = 'Commission percentage is required.';
$_['lang_error_tax_id']              = 'Tax ID required.';
$_['lang_error_payment']             = 'Payment method is required.';
$_['lang_error_cheque']              = 'If payment method is check, a check name is required.';
$_['lang_error_paypal']              = 'If payment method is PayPal, a PayPal email account is required.';
$_['lang_error_bank_name']           = 'If payment method is bank, a bank name is required.';
$_['lang_error_account_name']        = 'If payment method is bank, a bank account name is required.';
$_['lang_error_account_number']      = 'If payment is bank, a bank account number is required.';

