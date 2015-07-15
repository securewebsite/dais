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

namespace App\Language\Admin\English\Sale;

class Coupon {
	public static function lang() {
		// Heading
		$_['lang_heading_title']       = 'Coupon';

		// Text
		$_['lang_text_success']        = 'Success: You have modified coupons.';
		$_['lang_text_percent']        = 'Percentage';
		$_['lang_text_amount']         = 'Fixed Amount';

		// Column
		$_['lang_column_name']         = 'Coupon Name';
		$_['lang_column_code']         = 'Code';
		$_['lang_column_discount']     = 'Discount';
		$_['lang_column_date_start']   = 'Date Start';
		$_['lang_column_date_end']     = 'Date End';
		$_['lang_column_status']       = 'Status';
		$_['lang_column_order_id']     = 'Order ID';
		$_['lang_column_customer']     = 'Customer';
		$_['lang_column_amount']       = 'Amount';
		$_['lang_column_date_added']   = 'Date Added';
		$_['lang_column_action']       = 'Action';

		// Entry
		$_['lang_entry_name']          = 'Coupon Name:';
		$_['lang_entry_code']          = 'Code:<br /><span class="help">The code the customer enters to get the discount</span>';
		$_['lang_entry_type']          = 'Type:<br /><span class="help">Percentage or Fixed Amount</span>';
		$_['lang_entry_discount']      = 'Discount:';
		$_['lang_entry_logged']        = 'Customer Login:<br /><span class="help">Customer must be logged in to use the coupon.</span>';
		$_['lang_entry_shipping']      = 'Free Shipping:';
		$_['lang_entry_total']         = 'Total Amount:<br /><span class="help">The total amount that must reached before the coupon is valid.</span>';
		$_['lang_entry_category']      = 'Category:<br /><span class="help">Choose all products under selected category.</span>';
		$_['lang_entry_product']       = 'Products:<br /><span class="help">Choose the specific products the coupon will apply to. Select no products for coupon to apply to entire cart.</span>';
		$_['lang_entry_date_start']    = 'Date Start:';
		$_['lang_entry_date_end']      = 'Date End:';
		$_['lang_entry_uses_total']    = 'Uses Per Coupon:<br /><span class="help">The maximum number of times the coupon may be used by any one customer. Leave blank for unlimited</span>';
		$_['lang_entry_uses_customer'] = 'Uses Per Customer:<br /><span class="help">The maximum number of times the coupon may be used by an individual customer. Leave blank for unlimited</span>';
		$_['lang_entry_status']        = 'Status:';

		// Error
		$_['lang_error_permission']    = 'Warning: You do not have permission to modify coupons.';
		$_['lang_error_exists']        = 'Warning: Coupon code is already in use.';
		$_['lang_error_name']          = 'Coupon Name must be between 3 and 128 characters.';
		$_['lang_error_code']          = 'Code must be between 3 and 10 characters.';

		return $_;
	}
}
