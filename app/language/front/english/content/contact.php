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

namespace App\Language\Front\English\Content;

class Contact {
	public static function lang() {
		// Heading
		$_['lang_heading_title']  = 'Contact Us';

		// Text
		$_['lang_text_location']  = 'Our Location';
		$_['lang_text_contact']   = 'Contact Form';
		$_['lang_text_address']   = 'Address:';
		$_['lang_text_email']     = 'E-Mail:';
		$_['lang_text_telephone'] = 'Telephone:';
		$_['lang_text_message']   = '<p>Your inquiry has been successfully sent to the website administrator.</p>';

		// Entry Fields
		$_['lang_entry_name']     = 'Full Name';
		$_['lang_entry_email']    = 'E-Mail Address';
		$_['lang_entry_enquiry']  = 'Inquiry';
		$_['lang_entry_captcha']  = 'Enter the code below';

		// Email
		$_['lang_email_subject']  = 'Inquiry %s';

		// Errors
		$_['lang_error_name']     = 'Name must be between 3 and 32 characters.';
		$_['lang_error_email']    = 'E-Mail Address does not appear to be valid.';
		$_['lang_error_enquiry']  = 'Inquiry must be between 10 and 3000 characters.';
		$_['lang_error_captcha']  = 'Verification code does not match the image.';

		return $_;
	}
}
