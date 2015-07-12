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

class Logout {
	public static function lang() {
		// Heading
		$_['lang_heading_title'] = 'Account Logout';

		// Text
		$_['lang_text_message']  = '<p>You have successfully logged out of your account. It is now safe to leave the computer.</p><p>Your shopping cart has been saved. The items inside will be restored the next time you log into your account.</p>';
		$_['lang_text_account']  = 'Dashboard';
		$_['lang_text_logout']   = 'Logout';

		return $_;
	}
}
