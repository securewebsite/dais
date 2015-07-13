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

namespace Front\Language\English\Content;

class SiteMap {
	public static function lang() {
		// Heading
		$_['lang_heading_title'] = 'Site Map';

		// Text
		$_['lang_text_special']  = 'Special Offers';
		$_['lang_text_account']  = 'Dashboard';
		$_['lang_text_edit']     = 'Account Information';
		$_['lang_text_password'] = 'Password';
		$_['lang_text_address']  = 'Address Book';
		$_['lang_text_history']  = 'Order History';
		$_['lang_text_download'] = 'Downloads';
		$_['lang_text_cart']     = 'Shopping Cart';
		$_['lang_text_checkout'] = 'Checkout';
		$_['lang_text_search']   = 'Search';
		$_['lang_text_page']     = 'Pages';
		$_['lang_text_contact']  = 'Contact Us';

		return $_;
	}
}
