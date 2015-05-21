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

namespace Front\Language\English\Notification;

class Order {
	public static function lang() {
		$_['lang_text_received']         = 'You have received an order.';
		$_['lang_text_link']             = 'To view your order click on the link below:';
		$_['lang_text_order_id']         = 'Order ID:';
		$_['lang_text_date_added']       = 'Date Added:';
		$_['lang_text_order_status']     = 'Order Status:';
		$_['lang_text_payment_method']   = 'Payment Method:';
		$_['lang_text_shipping_method']  = 'Shipping Method:';
		$_['lang_text_email']            = 'Email:';
		$_['lang_text_telephone']        = 'Telephone:';
		$_['lang_text_payment_address']  = 'Payment Address';
		$_['lang_text_shipping_address'] = 'Shipping Address';
		$_['lang_text_products']         = 'Products';
		$_['lang_text_product']          = 'Product';
		$_['lang_text_model']            = 'Model';
		$_['lang_text_quantity']         = 'Qty';
		$_['lang_text_price']            = 'Price';
		$_['lang_text_order_total']      = 'Order Totals';
		$_['lang_text_total']            = 'Total';
		$_['lang_text_download']         = 'Once your payment has been confirmed you can click on the link below to access your downloadable products:';
		$_['lang_text_comment']          = 'The comments for your order are:';
		$_['lang_text_reward']           = '%s reward points for order number: %s';
		$_['lang_text_online']           = 'Online Event';
		$_['lang_text_online_link']      = '<a href="%s">Link</a>';

		$_['lang_text_link_alert']       = '<b style="color:red;">** IMPORTANT **</b> Your order contains as least one Online Event that has a URL where you can attend.  Make sure you keep this receipt so that you can attend your Event at the appropriate time.';

		$_['lang_text_address']          = 'Address:';
		$_['lang_text_id']               = 'ID';
		$_['lang_text_subject_admin']    = 'Order %s - %s (%s)';
		// 1.Order ID, 2.Customer Name, 3.Store Name
		$_['lang_text_order_link']       = 'To view this order click on the link below:';
		$_['lang_text_sku']              = 'SKU';
		$_['lang_text_weight']           = 'Weight';
		$_['lang_text_availability']     = 'Availability: ';
		$_['lang_text_stock_quantity']   = 'Quantity remaining: ';
		$_['lang_text_product_options']  = 'Options';
		$_['lang_text_product_weight']   = 'Weight';

		return $_;
	}
}
