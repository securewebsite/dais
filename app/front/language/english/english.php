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

namespace Front\Language\English;

class English {
	public static function lang() {
		// Locale
		$_['lang_code']                  = 'en';
		$_['lang_direction']             = 'ltr';
		$_['lang_date_format_short']     = 'm/d/Y';
		$_['lang_date_format_long']      = 'l F dS, Y';
		$_['lang_time_format']           = 'g:i A';
		$_['lang_decimal_point']         = '.';
		$_['lang_thousand_point']        = ',';
		$_['lang_post_date']             = '\o\n F dS, Y \a\t g:i A';

		// Text
		$_['lang_text_home']             = '<i class="fa fa-home fa-lg"></i>';
		$_['lang_text_yes']              = 'Yes';
		$_['lang_text_no']               = 'No';
		$_['lang_text_none']             = ' --- None --- ';
		$_['lang_text_select']           = ' --- Please Select --- ';
		$_['lang_text_all_zones']        = 'All Zones';
		$_['lang_text_pagination']       = 'Showing {start} to {end} of {total} ({pages} Pages)';
		$_['lang_text_separator']        = ' &raquo; ';
		$_['lang_text_read_more']        = 'Read More';
		$_['lang_text_by']               = 'by';
		$_['lang_text_enabled']			 = 'Enabled';
		$_['lang_text_disabled']		 = 'Disabled';

		// Buttons
		$_['lang_button_add_address']    = 'Add Address';
		$_['lang_button_back']           = 'Back';
		$_['lang_button_continue']       = 'Continue';
		$_['lang_button_cart']           = 'Add to Cart';
		$_['lang_button_close']			 = 'Close';
		$_['lang_button_compare']        = 'Compare Product';
		$_['lang_button_wishlist']       = 'Add to Wish List';
		$_['lang_button_checkout']       = 'Checkout';
		$_['lang_button_confirm']        = 'Confirm Order';
		$_['lang_button_coupon']         = 'Apply Coupon';
		$_['lang_button_delete']         = 'Delete';
		$_['lang_button_download']       = 'Download';
		$_['lang_button_edit']           = 'Edit';
		$_['lang_button_filter']         = 'Refine Search';
		$_['lang_button_new_address']    = 'New Address';
		$_['lang_button_change_address'] = 'Change Address';
		$_['lang_button_reviews']        = 'Reviews';
		$_['lang_button_write']          = 'Write Review';
		$_['lang_button_login']          = 'Login';
		$_['lang_button_update']         = 'Update';
		$_['lang_button_remove']         = 'Remove';
		$_['lang_button_reorder']        = 'Reorder';
		$_['lang_button_return']         = 'Return';
		$_['lang_button_shopping']       = 'Continue Shopping';
		$_['lang_button_search']         = 'Search';
		$_['lang_button_shipping']       = 'Apply Shipping';
		$_['lang_button_guest']          = 'Guest Checkout';
		$_['lang_button_view']           = 'View';
		$_['lang_button_view_event']     = 'View Event';
		$_['lang_button_gift_card']       = 'Apply Gift Card';
		$_['lang_button_upload']         = 'Upload File';
		$_['lang_button_reward']         = 'Apply Points';
		$_['lang_button_quote']          = 'Get Quotes';
		$_['lang_button_submit']         = 'Submit';
		$_['lang_button_save']           = 'Save';

		// Error
		$_['lang_error_upload_1']        = 'Warning: The uploaded file exceeds the upload_max_filesize directive in php.ini.';
		$_['lang_error_upload_2']        = 'Warning: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
		$_['lang_error_upload_3']        = 'Warning: The uploaded file was only partially uploaded.';
		$_['lang_error_upload_4']        = 'Warning: No file was uploaded.';
		$_['lang_error_upload_6']        = 'Warning: Missing a temporary folder.';
		$_['lang_error_upload_7']        = 'Warning: Failed to write file to disk.';
		$_['lang_error_upload_8']        = 'Warning: File upload stopped by extension.';
		$_['lang_error_upload_999']      = 'Warning: No error code available.';

		return $_;
	}
}
