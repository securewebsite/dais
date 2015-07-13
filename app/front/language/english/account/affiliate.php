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

class Affiliate {
	public static function lang() {
		// heading
		$_['lang_heading_title']             = 'Affiliate';

		// text
		$_['lang_text_account']              = 'Dashboard';
		$_['lang_text_affiliate']            = 'Affiliate Settings';
		$_['lang_text_general']              = 'General Details';
		$_['lang_text_success']              = 'Success: You have successfully updated your affiliate settings.';
		$_['lang_text_cheque']               = 'Check';
		$_['lang_text_paypal']               = 'PayPal';
		$_['lang_text_bank']                 = 'Bank Transfer';
		$_['lang_text_description']          = 'You can create affiliate referrals through three different strategies.</p><br><ol><li>You can simply send traffic to your base affiliate url: %s</li><li>You can send traffic to a specific product using the product links you create below.</li><li>You can refer someone who creates a customer account, and that customer will be yours for life.</li></ol><p>Product links and base affiliate tracking cookies are set for a time period of one year, after which the cookie is deleted and a new affiliate can be set for that visitor.</p><p>If on the other hand, a given visitor chooses to create an account, if your tracking cookie is found you will be set as their referrer and you will automatically receive a commission on every sale they complete, provided you have an active affiliate status.';
		$_['lang_text_code']                 = 'Your Tracking Code:';
		$_['lang_text_generator']            = 'Tracking Link Generator:<br><span class="help">Type in the name of a product you would like to link to.</span>';
		$_['lang_text_link']                 = 'Tracking Link:';
		$_['lang_text_balance']              = 'Your current balance is:';
		$_['lang_text_empty']                = 'You do not have any commissions.';
		$_['lang_text_enroll_now']           = 'Hi %s,</p><p>It looks like you didn\'t enroll as an Affiliate when you signed up.</p><p>No worries, you can enroll right now with the click of Enroll button below.';
		$_['lang_text_terms']                = 'I have read and agree to the <a class="modalbox" href="%s" alt="%s"><b>%s</b></a>';
		$_['lang_text_build']                = 'Build URL';

		// entry
		$_['lang_entry_slug']                = 'Vanity URL:<br /><span class="help">Set a vanity url for your affiliate link. Make sure you DO NOT use spaces, use hyphens (-) and click the Build button to check for uniqueness.</span>';
		$_['lang_entry_company']             = 'Company Name:';
		$_['lang_entry_website']             = 'Website:';
		$_['lang_entry_status']              = 'Status:<br><span class="help">Here you can disable or enable your own affiliate account.<br><span class="required">**NOTE: If you disable your account you will no longer receive affiliate commissions.</span></span>';
		$_['lang_entry_tax_id']              = 'Tax ID:<br><span class="help">Your SSN or Employer Tax ID number.</span>';
		$_['lang_entry_payment']             = 'Payment Method:';
		$_['lang_entry_cheque']              = 'Check Name:';
		$_['lang_entry_paypal']              = 'PayPal Email:';
		$_['lang_entry_bank_name']           = 'Bank Name:';
		$_['lang_entry_bank_branch_number']  = 'ABA/BSB number (Branch Number):';
		$_['lang_entry_bank_swift_code']     = 'SWIFT Code:';
		$_['lang_entry_bank_account_name']   = 'Account Name:';
		$_['lang_entry_bank_account_number'] = 'Account Number:';

		// column
		$_['lang_column_date_added']         = 'Date Added';
		$_['lang_column_description']        = 'Description';
		$_['lang_column_amount']             = 'Amount (%s)';

		// tab
		$_['lang_tab_general']               = 'General';
		$_['lang_tab_tracking']              = 'Tracking Codes';
		$_['lang_tab_payment']               = 'Payment Info';
		$_['lang_tab_commission']            = 'Commissions';

		// button
		$_['lang_button_save']               = 'Save Settings';

		// error
		$_['lang_error_warning']             = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_slug']                = 'Warning: You must set a vanity URL for your affiliate settings.';
		$_['lang_error_slug_found']          = 'ERROR: The vanity URL %s is already in use, please use a different one in the input field.';
		$_['lang_error_tax_id']              = 'Tax ID required.';
		$_['lang_error_payment']             = 'Payment method is required.';
		$_['lang_error_cheque']              = 'If payment method is check, a check name is required.';
		$_['lang_error_paypal']              = 'If payment method is PayPal, a PayPal email account is required.';
		$_['lang_error_bank_name']           = 'If payment method is bank, a bank name is required.';
		$_['lang_error_account_name']        = 'If payment method is bank, a bank account name is required.';
		$_['lang_error_account_number']      = 'If payment is bank, a bank account number is required.';
		$_['lang_error_agree']               = 'Warning: You must agree to the %s.';
		
		return $_;
	}
}
