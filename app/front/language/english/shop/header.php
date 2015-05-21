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

namespace Front\Language\English\Shop;

class Header {
	public static function lang() {
		// Text
		$_['lang_text_home']          = 'Home';
		$_['lang_text_blog']          = 'Blog';
		$_['lang_text_shop']          = 'Shop';
		$_['lang_nav_blog']           = 'nav-blog';
		$_['lang_nav_shop']           = 'nav-shop';
		$_['lang_text_wishlist']      = 'Wish List (%s)';
		$_['lang_text_shopping_cart'] = 'Shopping Cart';
		$_['lang_text_search']        = 'Search';
		$_['lang_text_welcome']       = 'Welcome visitor you can <a href="%s">login</a> or <a href="%s">create an account</a>.';
		$_['lang_text_logged']        = 'You are logged in as <a href="%s">%s</a> ( <a href="%s">Logout</a> )';
		$_['lang_text_account']       = 'Account';
		$_['lang_text_checkout']      = 'Checkout';

		return $_;
	}
}
