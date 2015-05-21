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

namespace Front\Language\English\Account;

class Order {
	public static function lang() {
		// Heading
		$_['lang_heading_title']         = 'Order History';

		// Text
		$_['lang_text_account']          = 'Dashboard';
		$_['lang_text_order']            = 'Order Information';
		$_['lang_text_order_detail']     = 'Order Details';
		$_['lang_text_invoice_no']       = 'Invoice No.:';
		$_['lang_text_order_id']         = 'Order ID:';
		$_['lang_text_status']           = 'Status:';
		$_['lang_text_date_added']       = 'Date Added:';
		$_['lang_text_customer']         = 'Customer:';
		$_['lang_text_shipping_address'] = 'Shipping Address';
		$_['lang_text_shipping_method']  = 'Shipping Method:';
		$_['lang_text_payment_address']  = 'Payment Address';
		$_['lang_text_payment_method']   = 'Payment Method:';
		$_['lang_text_products']         = 'Products:';
		$_['lang_text_total']            = 'Total:';
		$_['lang_text_comment']          = 'Order Comments';
		$_['lang_text_history']          = 'Order History';
		$_['lang_text_success']          = 'You have successfully added the products from order ID #%s to your cart.';
		$_['lang_text_empty']            = 'You have not made any previous orders.';
		$_['lang_text_error']            = 'The order you requested could not be found.';

		// Column
		$_['lang_column_name']           = 'Product Name';
		$_['lang_column_model']          = 'Model';
		$_['lang_column_quantity']       = 'Quantity';
		$_['lang_column_price']          = 'Price';
		$_['lang_column_total']          = 'Total';
		$_['lang_column_action']         = 'Action';
		$_['lang_column_date_added']     = 'Date Added';
		$_['lang_column_status']         = 'Status';
		$_['lang_column_comment']        = 'Comment';

		return $_;
	}
}
