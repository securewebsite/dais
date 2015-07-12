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

namespace App\Language\Admin\English\Payment;

class PaypalExpress {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                  = 'PayPal Express Checkout';

		// Text
		$_['lang_text_payment']                   = 'Payment';
		$_['lang_text_success']                   = 'Success: You have modified PayPal Express Checkout account details.';
		$_['lang_text_authorization']             = 'Authorization';
		$_['lang_text_sale']                      = 'Sale';
		$_['lang_text_clear']                     = 'Clear';
		$_['lang_text_browse']                    = 'Browse';
		$_['lang_text_image_manager']             = 'Image manager';
		$_['lang_text_ipn']                       = 'IPN URL<span class="help">Required for subscriptions</span>';

		// Entry
		$_['lang_entry_username']                 = 'API Username:';
		$_['lang_entry_password']                 = 'API Password:';
		$_['lang_entry_signature']                = 'API Signature:';
		$_['lang_entry_test']                     = 'Test (Sandbox) Mode:';
		$_['lang_entry_method']                   = 'Transaction Method:';
		$_['lang_entry_geo_zone']                 = 'Geo Zone:';
		$_['lang_entry_status']                   = 'Status:';
		$_['lang_entry_sort_order']               = 'Sort Order:';
		$_['lang_entry_icon_sort_order']          = 'Icon Sort Order:';
		$_['lang_entry_debug']                    = 'Debug logging:';
		$_['lang_entry_total']                    = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
		$_['lang_entry_currency']                 = 'Default currency<span class="help">Used for transaction searches</span>';
		$_['lang_entry_recurring_cancellation']   = 'Allow customers to cancel recurring payments.';
		$_['lang_entry_canceled_reversal_status'] = 'Cancelled Reversal Status:';
		$_['lang_entry_completed_status']         = 'Completed Status:';
		$_['lang_entry_denied_status']            = 'Denied Status:';
		$_['lang_entry_expired_status']           = 'Expired Status:';
		$_['lang_entry_failed_status']            = 'Failed Status:';
		$_['lang_entry_pending_status']           = 'Pending Status:';
		$_['lang_entry_processed_status']         = 'Processed Status:';
		$_['lang_entry_refunded_status']          = 'Refunded Status:';
		$_['lang_entry_reversed_status']          = 'Reversed Status:';
		$_['lang_entry_voided_status']            = 'Voided Status:';
		$_['lang_entry_display_checkout']         = 'Display quick checkout icon:';
		$_['lang_entry_allow_notes']              = 'Allow notes:';
		$_['lang_entry_logo']                     = 'Logo<span class="help">Max 750px(w) x 90px(h)<br />You should only use a logo if you have SSL set up.</span>';
		$_['lang_entry_border_colour']            = 'Header border colour:<span class="help">6 character HTML colour code</span>';
		$_['lang_entry_header_colour']            = 'Header background colour:<span class="help">6 character HTML colour code</span>';
		$_['lang_entry_page_colour']              = 'Page background colour:<span class="help">6 character HTML colour code</span>';

		// Error
		$_['lang_error_permission']               = 'Warning: You do not have permission to modify payment PayPal Express Checkout.';
		$_['lang_error_username']                 = 'API Username Required.';
		$_['lang_error_password']                 = 'API Password Required.';
		$_['lang_error_signature']                = 'API Signature Required.';
		$_['lang_error_data']                     = 'Data missing from request';
		$_['lang_error_timeout']                  = 'Request timed out';

		// Tab headings
		$_['lang_tab_general']                    = 'General';
		$_['lang_tab_api_details']                = 'API Details';
		$_['lang_tab_order_status']               = 'Order Status';
		$_['lang_tab_customise']                  = 'Customise Checkout';

		return $_;
	}
}
