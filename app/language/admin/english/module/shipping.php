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

namespace App\Language\Admin\English\Module;

class Shipping {
	public static function lang() {
		// Heading
		$_['lang_heading_shipping']  = 'Shipping';

		// Text
		$_['lang_text_install']      = 'Install';
		$_['lang_text_uninstall']    = 'Uninstall';

		// Column
		$_['lang_column_name']       = 'Shipping Method';
		$_['lang_column_status']     = 'Status';
		$_['lang_column_sort_order'] = 'Sort Order';
		$_['lang_column_action']     = 'Action';

		// Error
		$_['lang_error_permission']  = 'Warning: You do not have permission to modify shipping.';

		return $_;
	}
}
