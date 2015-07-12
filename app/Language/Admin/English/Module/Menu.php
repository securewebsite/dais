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

class Menu {
	public static function lang() {
		//Heading
		$_['lang_heading_title']          = 'Menu Builder';

		//Text
		$_['lang_text_success']           = 'Success: You have successfully modified Menu Builder.';
		$_['lang_text_header']            = 'Header';
		$_['lang_text_footer']            = 'Footer';
		$_['lang_text_sidebar']           = 'Sidebar';
		$_['lang_text_content']           = 'Content';
		$_['lang_text_content_category']  = 'Content Categories';
		$_['lang_text_product_category']  = 'Product Categories';
		$_['lang_text_page']              = 'Pages';
		$_['lang_text_post']              = 'Posts';
		$_['lang_text_custom']            = 'Custom';
		$_['lang_text_notice']            = 'Menus must be called implicitly in your theme controller. In the core Ghost theme, only headers, footers, and column left/right make calls to menus.';

		//Column
		$_['lang_column_name']            = 'Name';
		$_['lang_column_type']            = 'Type';
		$_['lang_column_status']          = 'Status';
		$_['lang_column_action']          = 'Action';
		$_['lang_column_href']            = 'External URL or Local Route';
		$_['lang_column_text']            = 'Link Text';

		//Entry
		$_['lang_entry_name']             = 'Name<br><span class="help">Name your menu (will show in Sidebar menus and Footer blocks)</span>';
		$_['lang_entry_menu_type']        = 'Type<br><span class="help">The type of menu you want to create.</span>';
		$_['lang_entry_status']           = 'Status';
		$_['lang_entry_layout']           = 'Layout<br><span class="help">Layouts are required for Column Right/Left menus, but not for Header/Footer menus.</span>';
		$_['lang_entry_content_category'] = 'Content Categories<br><span class="help">Child categories must be manually selected or they will not show in your menu.</span>';
		$_['lang_entry_product_category'] = 'Product Categories<br><span class="help">Child categories must be manually selected or they will not show in your menu.</span>';
		$_['lang_entry_page']             = 'Pages';
		$_['lang_entry_post']             = 'Posts';
		$_['lang_entry_custom']           = 'Custom';

		//Error
		$_['lang_error_warning']          = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']       = 'Warning: You do not have permission to modify menu builder.';
		$_['lang_error_name']             = 'Error: Menu name must be between 3 and 32 characters.';
		$_['lang_error_type']             = 'Error: Please select a menu type.';
		$_['lang_error_items']            = 'Error: Menu items are required for your menu.';

		return $_;
	}
}
