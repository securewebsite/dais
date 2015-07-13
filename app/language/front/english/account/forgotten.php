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

class Forgotten {
	public static function lang() {
		// Heading
		$_['lang_heading_title']   = 'Forgot Your Password?';

		// Text
		$_['lang_text_account']    = 'Dashboard';
		$_['lang_text_forgotten']  = 'Forgotten Password';
		$_['lang_text_your_email'] = 'Your E-Mail Address';
		$_['lang_text_email']      = 'Enter the e-mail address associated with your account. Click submit, and a password reset link will be e-mailed to you.';
		$_['lang_text_success']    = 'An email with a confirmation link has been sent your admin email address.';

		// Entry
		$_['lang_entry_email']     = 'E-Mail Address';

		// Error
		$_['lang_error_email']     = 'Warning: The E-Mail address you entered was not found in our records, please try again.';

		return $_;
	}
}
