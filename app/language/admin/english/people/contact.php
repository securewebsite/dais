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

namespace App\Language\Admin\English\People;

class Contact {
	public static function lang() {
		// Heading
		$_['lang_heading_title']        = 'Mail';

		// Text
		$_['lang_text_success']         = 'Your message has been successfully sent.';
		$_['lang_text_sent']            = 'Your message has been successfully sent to %s of %s recipients.';
		$_['lang_text_default']         = 'Default';
		$_['lang_text_newsletter']      = 'All Newsletter Subscribers';
		$_['lang_text_customer_all']    = 'All Customers';
		$_['lang_text_customer_group']  = 'Customer Group';
		$_['lang_text_customer']        = 'Customers';
		$_['lang_text_affiliate_all']   = 'All Affiliates';
		$_['lang_text_affiliate']       = 'Affiliates';
		$_['lang_text_product']         = 'Products';

		// Entry
		$_['lang_entry_store']          = 'From:';
		$_['lang_entry_to']             = 'To:';
		$_['lang_entry_customer_group'] = 'Customer Group:';
		$_['lang_entry_customer']       = 'Customer:<br /><span class="help">Autocomplete</span>';
		$_['lang_entry_affiliate']      = 'Affiliate:<br /><span class="help">Autocomplete</span>';
		$_['lang_entry_product']        = 'Products:<br /><span class="help">Send only to customers who have ordered products in the list. (Autocomplete)</span>';
		$_['lang_entry_subject']        = 'Subject:<br><span class="The subject of your message."></span>';
		$_['lang_entry_html']           = 'Message HTML:<br><span class="An html version is required."></span>';
		$_['lang_entry_text']           = 'Message Text:<br><span class="A text version is required."></span>';

		// Error
		$_['lang_error_permission']     = 'Warning: You do not have permission to send E-Mail\'s.';
		$_['lang_error_subject']        = 'E-Mail Subject required.';
		$_['lang_error_text']           = 'E-Mail text version required.';
		$_['lang_error_html']           = 'E-Mail html version required.';// Heading
		$_['lang_heading_title']        = 'Mail';

		// Text
		$_['lang_text_success']         = 'Your message has been successfully sent.';
		$_['lang_text_sent']            = 'Your message has been successfully sent to %s of %s recipients.';
		$_['lang_text_default']         = 'Default';
		$_['lang_text_newsletter']      = 'All Newsletter Subscribers';
		$_['lang_text_customer_all']    = 'All Customers';
		$_['lang_text_customer_group']  = 'Customer Group';
		$_['lang_text_customer']        = 'Customers';
		$_['lang_text_affiliate_all']   = 'All Affiliates';
		$_['lang_text_affiliate']       = 'Affiliates';
		$_['lang_text_product']         = 'Products';

		// Entry
		$_['lang_entry_store']          = 'From:';
		$_['lang_entry_to']             = 'To:';
		$_['lang_entry_customer_group'] = 'Customer Group:';
		$_['lang_entry_customer']       = 'Customer:<br /><span class="help">Autocomplete</span>';
		$_['lang_entry_affiliate']      = 'Affiliate:<br /><span class="help">Autocomplete</span>';
		$_['lang_entry_product']        = 'Products:<br /><span class="help">Send only to customers who have ordered products in the list. (Autocomplete)</span>';
		$_['lang_entry_subject']        = 'Subject:<br><span class="The subject of your message."></span>';
		$_['lang_entry_html']           = 'Message HTML:<br><span class="An html version is required."></span>';
		$_['lang_entry_text']           = 'Message Text:<br><span class="A text version is required."></span>';

		// Error
		$_['lang_error_permission']     = 'Warning: You do not have permission to send E-Mail\'s.';
		$_['lang_error_subject']        = 'E-Mail Subject required.';
		$_['lang_error_text']           = 'E-Mail text version required.';
		$_['lang_error_html']           = 'E-Mail html version required.';

		return $_;
	}
}
