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

class Login {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                = 'Account Login';

		// Text
		$_['lang_text_account']                 = 'Dashboard';
		$_['lang_text_login']                   = 'Login';
		$_['lang_text_new_customer']            = 'New Customer';
		$_['lang_text_register']                = 'Register Account';
		$_['lang_text_register_account']        = 'By creating an account you can shop faster, stay up to date on an order\'s status, and keep track of your previous orders.';
		$_['lang_text_returning_customer']      = 'Returning Customer';
		$_['lang_text_i_am_returning_customer'] = 'I am a returning customer';
		$_['lang_text_forgotten']               = 'Forgotten Password';

		// Entry
		$_['lang_entry_email']                  = 'Username/E-Mail';
		$_['lang_entry_password']               = 'Password';

		// Error
		$_['lang_error_login']                  = 'Warning: No match for Username/E-Mail and/or Password.';
		$_['lang_error_approved']               = 'Warning: Your account requires approval before you can login.';

		return $_;
	}
}
