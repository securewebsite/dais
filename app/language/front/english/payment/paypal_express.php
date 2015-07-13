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

namespace Front\Language\English\Payment;

class PaypalExpress {
	public static function lang() {
		// Text
		$_['lang_text_title']              = 'PayPal Express Checkout';
		$_['lang_text_cart']               = 'Shopping Cart';
		$_['lang_text_shipping_updated']   = 'Shipping service updated';
		$_['lang_text_trial']              = '%s every %s %s for %s payments then ';
		$_['lang_text_recurring']          = '%s every %s %s';
		$_['lang_text_length']             = ' for %s payments';

		// Standard checkout error page
		$_['lang_error_heading_title']     = 'There was an error';
		$_['lang_error_too_many_failures'] = 'Your payment has failed too many times';

		// Button
		$_['lang_button_continue']         = 'Continue';
		$_['lang_button_cancel_recurring'] = 'Cancel Recurring Payment';

		// Express confirm page
		$_['lang_express_text_title']      = 'Confirm order';
		$_['lang_express_button_coupon']   = 'Add';
		$_['lang_express_button_confirm']  = 'Confirm';
		$_['lang_express_button_login']    = 'Continue to PayPal';
		$_['lang_express_button_shipping'] = 'Update shipping';
		$_['lang_express_entry_coupon']    = 'Enter your coupon here';

		return $_;
	}
}
