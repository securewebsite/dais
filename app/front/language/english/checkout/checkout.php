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

namespace Front\Language\English\Checkout;

class Checkout {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                           = 'Checkout';

		// Text
		$_['lang_text_cart']                               = 'Shopping Cart';
		$_['lang_text_checkout_option']                    = 'Checkout Options';
		$_['lang_text_checkout_account']                   = 'Account &amp; Billing Details';
		$_['lang_text_checkout_payment_address']           = 'Billing Details';
		$_['lang_text_checkout_shipping_address']          = 'Delivery Details';
		$_['lang_text_checkout_shipping_method']           = 'Delivery Method';
		$_['lang_text_checkout_payment_method']            = 'Payment Method';
		$_['lang_text_checkout_confirm']                   = 'Confirm Order';
		$_['lang_text_modify']                             = 'Modify &raquo;';
		$_['lang_text_new_customer']                       = 'New Customer';
		$_['lang_text_returning_customer']                 = 'Returning Customer';
		$_['lang_text_checkout']                           = 'Checkout Options:';
		$_['lang_text_i_am_returning_customer']            = 'I am a returning customer';
		$_['lang_text_register']                           = 'Register Account';
		$_['lang_text_guest']                              = 'Guest Checkout';
		$_['lang_text_register_account']                   = 'By creating an account you will be able to shop faster, be up to date on an order\'s status, and keep track of the orders you have previously made.';
		$_['lang_text_forgotten']                          = 'Forgotten Password';
		$_['lang_text_your_details']                       = 'Your Personal Details';
		$_['lang_text_your_address']                       = 'Your Address';
		$_['lang_text_your_password']                      = 'Your Password';
		$_['lang_text_agree']                              = 'I have read and agree to the <a class="modalbox" href="%s" alt="%s"><b>%s</b></a>';
		$_['lang_text_address_new']                        = 'I want to use a new address';
		$_['lang_text_address_existing']                   = 'I want to use an existing address';
		$_['lang_text_shipping_method']                    = 'Please select the preferred shipping method to use on this order.';
		$_['lang_text_payment_method']                     = 'Please select the preferred payment method to use on this order.';
		$_['lang_text_comments']                           = 'Add Comments About Your Order';

		$_['lang_text_recurring_item']                     = 'Recurring Item';
		$_['lang_text_payment_profile']                    = 'Payment Profile';
		$_['lang_text_trial_description']                  = '%s every %d %s(s) for %d payment(s) then';
		$_['lang_text_payment_description']                = '%s every %d %s(s) for %d payment(s)';
		$_['lang_text_payment_until_canceled_description'] = '%s every %d %s(s) until canceled';
		$_['lang_text_day']                                = 'day';
		$_['lang_text_week']                               = 'week';
		$_['lang_text_semi_month']                         = 'half-month';
		$_['lang_text_month']                              = 'month';
		$_['lang_text_year']                               = 'year';

		// Column
		$_['lang_column_name']                             = 'Product Name';
		$_['lang_column_model']                            = 'Model';
		$_['lang_column_quantity']                         = 'Quantity';
		$_['lang_column_price']                            = 'Price';
		$_['lang_column_total']                            = 'Total';

		// Entry
		$_['lang_entry_email_address']                     = 'E-Mail Address';
		$_['lang_entry_user_email']                        = 'Username or E-mail';
		$_['lang_entry_email']                             = 'E-mail Address';
		$_['lang_entry_password']                          = 'Password';
		$_['lang_entry_confirm']                           = 'Password Confirm';
		$_['lang_entry_username']                          = 'Username';
		$_['lang_entry_firstname']                         = 'First Name';
		$_['lang_entry_lastname']                          = 'Last Name';
		$_['lang_entry_telephone']                         = 'Telephone';
		$_['lang_entry_company']                           = 'Company';
		$_['lang_entry_customer_group']                    = 'Business Type';
		$_['lang_entry_company_id']                        = 'Company ID';
		$_['lang_entry_tax_id']                            = 'Tax ID';
		$_['lang_entry_address_1']                         = 'Address 1';
		$_['lang_entry_address_2']                         = 'Address 2';
		$_['lang_entry_postcode']                          = 'Post Code';
		$_['lang_entry_city']                              = 'City';
		$_['lang_entry_country']                           = 'Country';
		$_['lang_entry_zone']                              = 'Region / State';
		$_['lang_entry_newsletter']                        = 'I wish to subscribe to the %s newsletter.';
		$_['lang_entry_shipping']                          = 'My delivery and billing addresses are the same.';

		// Error
		$_['lang_error_warning']                           = 'There was a problem while trying to process your order. If the problem persists please try selecting a different payment method or you can contact the store owner by <a href="%s">clicking here</a>.';
		$_['lang_error_login']                             = 'Warning: No match for E-Mail Address and/or Password.';
		$_['lang_error_approved']                          = 'Warning: Your account requires approval before you can login.';
		$_['lang_error_exists']                            = 'Warning: E-Mail Address is already registered.';
		$_['lang_error_uexists']                           = 'Warning: Username is already registered.';
		$_['lang_error_username']                          = 'Username must be between 3 and 16 characters.';
		$_['lang_error_firstname']                         = 'First Name must be between 1 and 32 characters.';
		$_['lang_error_lastname']                          = 'Last Name must be between 1 and 32 characters.';
		$_['lang_error_email']                             = 'E-Mail Address does not appear to be valid.';
		$_['lang_error_telephone']                         = 'Telephone must be between 3 and 32 characters.';
		$_['lang_error_password']                          = 'Password must be between 3 and 20 characters.';
		$_['lang_error_confirm']                           = 'Password confirmation does not match password.';
		$_['lang_error_company_id']                        = 'Company ID required.';
		$_['lang_error_tax_id']                            = 'Tax ID required.';
		$_['lang_error_vat']                               = 'VAT number is invalid.';
		$_['lang_error_address_1']                         = 'Address 1 must be between 3 and 128 characters.';
		$_['lang_error_city']                              = 'City must be between 2 and 128 characters.';
		$_['lang_error_postcode']                          = 'Postcode must be between 2 and 10 characters.';
		$_['lang_error_country']                           = 'Please select a country.';
		$_['lang_error_zone']                              = 'Please select a region / state.';
		$_['lang_error_agree']                             = 'Warning: You must agree to the %s.';
		$_['lang_error_address']                           = 'Warning: You must select address.';
		$_['lang_error_shipping']                          = 'Warning: Shipping method required.';
		$_['lang_error_no_shipping']                       = 'Warning: No Shipping options are available. Please <a href="%s">contact us</a> for assistance.';
		$_['lang_error_payment']                           = 'Warning: Payment method required.';
		$_['lang_error_no_payment']                        = 'Warning: No Payment options are available. Please <a href="%s">contact us</a> for assistance.';

		$_['lang_text_trial']                              = '%s every %s %s for %s payments then ';
		$_['lang_text_recurring']                          = '%s every %s %s';
		$_['lang_text_length']                             = ' for %s payments';

		return $_;
	}
}
