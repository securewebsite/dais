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

namespace App\Language\Front\English\Checkout;

class Cart {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                           = 'Shopping Cart';

		// Text
		$_['lang_text_success']                            = 'Success: You have added <a href="%s">%s</a> to your <a href="%s">shopping cart</a>.';
		$_['lang_text_remove']                             = 'Success: You have modified your shopping cart.';
		$_['lang_text_coupon']                             = 'Success: Your coupon discount has been applied.';
		$_['lang_text_gift_card']                           = 'Success: Your gift card discount has been applied.';
		$_['lang_text_reward']                             = 'Success: Your reward points discount has been applied.';
		$_['lang_text_shipping']                           = 'Success: Your shipping estimate has been applied.';
		$_['lang_text_login']                              = 'Attention: You must <a href="%s">login</a> or <a href="%s">create an account</a> to view prices.';
		$_['lang_text_points']                             = 'Reward Points: %s';
		$_['lang_text_items']                              = '%s item(s) - %s';
		$_['lang_text_next']                               = 'What would you like to do next?';
		$_['lang_text_next_choice']                        = 'Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.';
		$_['lang_text_use_coupon']                         = 'Use Coupon Code';
		$_['lang_text_use_gift_card']                       = 'Use Gift Card';
		$_['lang_text_use_reward']                         = 'Use Reward Points (Available %s)';
		$_['lang_text_shipping_estimate']                  = 'Estimate Shipping &amp; Taxes';
		$_['lang_text_shipping_detail']                    = 'Enter your destination to get a shipping estimate.';
		$_['lang_text_shipping_method']                    = 'Please select the preferred shipping method to use on this order.';
		$_['lang_text_empty']                              = 'Your shopping cart is empty.';
		$_['lang_text_until_cancelled']                    = 'until cancelled';
		$_['lang_text_recurring_item']                     = 'Recurring item';
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
		$_['lang_column_image']                            = 'Image';
		$_['lang_column_name']                             = 'Product Name';
		$_['lang_column_model']                            = 'Model';
		$_['lang_column_quantity']                         = 'Quantity';
		$_['lang_column_price']                            = 'Unit Price';
		$_['lang_column_total']                            = 'Total';

		// Entry
		$_['lang_entry_coupon']                            = 'Enter your coupon here';
		$_['lang_entry_gift_card']                          = 'Enter your gift card code here';
		$_['lang_entry_reward']                            = 'Points to use (Max %s)';
		$_['lang_entry_country']                           = 'Country';
		$_['lang_entry_zone']                              = 'Region / State';
		$_['lang_entry_postcode']                          = 'Post Code';

		// Error
		$_['lang_error_stock']                             = 'Products marked with *** are not available in the desired quantity or not in stock.';
		$_['lang_error_minimum']                           = 'Minimum order amount for %s is %s.';
		$_['lang_error_required']                          = '%s required.';
		$_['lang_error_product']                           = 'Warning: There are no products in your cart.';
		$_['lang_error_coupon']                            = 'Warning: Coupon is either invalid, expired or reached it\'s usage limit.';
		$_['lang_error_gift_card']                          = 'Warning: Gift Card is either invalid or the balance has been used up.';
		$_['lang_error_reward']                            = 'Warning: Please enter the amount of reward points to use.';
		$_['lang_error_points']                            = 'Warning: You don\'t have %s reward points.';
		$_['lang_error_maximum']                           = 'Warning: The maximum number of points that can be applied is %s.';
		$_['lang_error_postcode']                          = 'Postcode must be between 2 and 10 characters.';
		$_['lang_error_country']                           = 'Please select a country.';
		$_['lang_error_zone']                              = 'Please select a region / state.';
		$_['lang_error_shipping']                          = 'Warning: Shipping method required.';
		$_['lang_error_no_shipping']                       = 'Warning: No Shipping options are available. Please <a href="%s">contact us</a> for assistance.';
		$_['lang_error_profile_required']                  = 'Please select a payment profile.';

		$_['lang_text_trial']                              = '%s every %s %s for %s payments then ';
		$_['lang_text_recurring']                          = '%s every %s %s';
		$_['lang_text_length']                             = ' for %s payments';

		return $_;
	}
}
