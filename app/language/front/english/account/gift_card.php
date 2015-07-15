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

namespace App\Language\Front\English\Account;

class GiftCard {
	public static function lang() {
		// Heading
		$_['lang_heading_title']    = 'Purchase a Gift Card';

		// Text
		$_['lang_text_account']     = 'Dashboard';
		$_['lang_text_gift_card']    = 'Gift Gard';
		$_['lang_text_description'] = 'This gift certificate will be E-Mailed to the recipient after payment is completed.';
		$_['lang_text_agree']       = 'I understand that gift cards are non-refundable.';
		$_['lang_text_message']     = '<p>Thank you for purchasing a gift card. Once you have completed your order, your gift recipient will be sent an E-Mail with details for gift card redemption.</p>';
		$_['lang_text_for']         = '%s Gift Card for %s';
		$_['lang_text_p_message']   = 'Message';
		$_['lang_text_p_amount']    = 'Amount';

		// Entry
		$_['lang_entry_to_name']    = 'Recipient\'s Name';
		$_['lang_entry_to_email']   = 'Recipient\'s Email';
		$_['lang_entry_from_name']  = 'Your Name';
		$_['lang_entry_from_email'] = 'Your Email';
		$_['lang_entry_theme']      = 'Gift Card Theme';
		$_['lang_entry_message']    = 'Message<br /><span class="help">(Optional)</span>';
		$_['lang_entry_amount']     = 'Amount<br /><span class="help">(Value must be between %s and %s)</span>';

		// Error
		$_['lang_error_to_name']    = 'Recipient\'s name must be between 1 and 64 characters.';
		$_['lang_error_from_name']  = 'Your name must be between 1 and 64 characters.';
		$_['lang_error_email']      = 'E-Mail Address does not appear to be valid.';
		$_['lang_error_theme']      = 'You must select a theme.';
		$_['lang_error_amount']     = 'Amount must be between %s and %s.';
		$_['lang_error_agree']      = 'Warning: You must agree that gift cards are non-refundable.';

		return $_;
	}
}
