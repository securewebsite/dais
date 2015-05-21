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

namespace Admin\Language\English\Setting;

class Store {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                = 'Settings';

		// Text
		$_['lang_text_success']                 = 'Success: You have modified settings.';
		$_['lang_text_items']                   = 'Items';
		$_['lang_text_tax']                     = 'Taxes';
		$_['lang_text_account']                 = 'Account';
		$_['lang_text_checkout']                = 'Checkout';
		$_['lang_text_stock']                   = 'Stock';
		$_['lang_text_image_manager']           = 'Image Manager';
		$_['lang_text_browse']                  = 'Browse';
		$_['lang_text_clear']                   = 'Clear';
		$_['lang_text_shipping']                = 'Shipping Address';
		$_['lang_text_payment']                 = 'Payment Address';

		// Column
		$_['lang_column_name']                  = 'Store Name';
		$_['lang_column_url']                   = 'Store URL';
		$_['lang_column_action']                = 'Action';

		// Entry
		$_['lang_entry_url']                    = 'Store URL:<br /><span class="help">Include the full URL to your store. Make sure to add \'/\' at the end. Example: http://www.yourdomain.com/path/<br /><br />Don\'t use directories to create a new store. You should always point another domain or sub domain to your hosting.</span>';
		$_['lang_entry_ssl']                    = 'SSL URL:<br /><span class="help">SSL URL to your store. Make sure to add \'/\' at the end. Example: http://www.yourdomain.com/path/<br /><br />Don\'t use directories to create a new store. You should always point another domain or sub domain to your hosting.</span>';
		$_['lang_entry_name']                   = 'Store Name:';
		$_['lang_entry_owner']                  = 'Store Owner:';
		$_['lang_entry_address']                = 'Address:';
		$_['lang_entry_email']                  = 'E-Mail:';
		$_['lang_entry_telephone']              = 'Telephone:';
		$_['lang_entry_title']                  = 'Title:';
		$_['lang_entry_meta_description']       = 'Meta Tag Description:';
		$_['lang_entry_layout']                 = 'Default Layout:';
		$_['lang_entry_theme']                  = 'Store Theme:';
		$_['lang_entry_country']                = 'Country:';
		$_['lang_entry_zone']                   = 'Region / State:';
		$_['lang_entry_language']               = 'Language:';
		$_['lang_entry_currency']               = 'Currency:';
		$_['lang_entry_catalog_limit']          = 'Default Items Per Page (Catalog):<br /><span class="help">Determines how many catalog items are shown per page (products, categories, etc)</span>';
		$_['lang_entry_tax']                    = 'Display Prices With Tax:';
		$_['lang_entry_tax_default']            = 'Use Store Tax Address:<br /><span class="help">Use the store address to calculate taxes if no one is logged in. You can choose to use the store address for the customers shipping or payment address.</span>';
		$_['lang_entry_tax_customer']           = 'Use Customer Tax Address:<br /><span class="help">Use the customers default address when they login to calculate taxes. You can choose to use the default address for the customers shipping or payment address.</span>';
		$_['lang_entry_customer_group']         = 'Customer Group:<br /><span class="help">Default customer group.</span>';
		$_['lang_entry_customer_group_display'] = 'Customer Groups:<br /><span class="help">Display customer groups that new customers can select to use such as wholesale and business when signing up.</span>';
		$_['lang_entry_customer_price']         = 'Login Display Prices:<br /><span class="help">Only show prices when a customer is logged in.</span>';
		$_['lang_entry_account']                = 'Account Terms:<br /><span class="help">This forces people to agree to terms before an account can be created.</span>';
		$_['lang_entry_cart_weight']            = 'Display Weight on Cart Page:';
		$_['lang_entry_guest_checkout']         = 'Guest Checkout:<br /><span class="help">Allow customers to checkout without creating an account. This will not be available when a downloadable product is in the shopping cart.</span>';
		$_['lang_entry_checkout']               = 'Checkout Terms:<br /><span class="help">This forces people to agree to terms before a customer can checkout.</span>';
		$_['lang_entry_order_status']           = 'Order Status:<br /><span class="help">Set the default order status when an order is processed.</span>';
		$_['lang_entry_stock_display']          = 'Display Stock:<br /><span class="help">Display stock quantity on the product page.</span>';
		$_['lang_entry_stock_checkout']         = 'Stock Checkout:<br /><span class="help">Allow customers to checkout even if the products they are ordering are not in stock.</span>';
		$_['lang_entry_logo']                   = 'Store Logo:';
		$_['lang_entry_icon']                   = 'Icon:<br /><span class="help">The icon should be a PNG that is 16px x 16px.</span>';
		$_['lang_entry_image_category']         = 'Category Image Size:';
		$_['lang_entry_image_thumb']            = 'Product Image Thumb Size:';
		$_['lang_entry_image_popup']            = 'Product Image Popup Size:';
		$_['lang_entry_image_product']          = 'Product Image List Size:';
		$_['lang_entry_image_additional']       = 'Additional Product Image Size:';
		$_['lang_entry_image_related']          = 'Related Product Image Size:';
		$_['lang_entry_image_compare']          = 'Compare Image Size:';
		$_['lang_entry_image_wishlist']         = 'Wish List Image Size:';
		$_['lang_entry_image_cart']             = 'Cart Image Size:';
		$_['lang_entry_secure']                 = 'Use SSL:<br /><span class="help">To use SSL, check with your host to discover if an SSL certificate is installed.</span>';

		// Error
		$_['lang_error_warning']                = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']             = 'Warning: You do not have permission to modify stores.';
		$_['lang_error_name']                   = 'Store name must be between 3 and 32 characters.';
		$_['lang_error_owner']                  = 'Store owner must be between 3 and 64 characters.';
		$_['lang_error_address']                = 'Store address must be between 10 and 256 characters.';
		$_['lang_error_email']                  = 'E-Mail Address does not appear to be valid.';
		$_['lang_error_telephone']              = 'Telephone must be between 3 and 32 characters.';
		$_['lang_error_url']                    = 'Store URL required.';
		$_['lang_error_title']                  = 'Title must be between 3 and 32 characters.';
		$_['lang_error_limit']                  = 'Limit required.';
		$_['lang_error_customer_group_display'] = 'You must include the default customer group if you are going to use this feature.';
		$_['lang_error_image_thumb']            = 'Product image thumb size dimensions required.';
		$_['lang_error_image_popup']            = 'Product image popup size dimensions required.';
		$_['lang_error_image_product']          = 'Product list size dimensions required.';
		$_['lang_error_image_category']         = 'Category list size dimensions required.';
		$_['lang_error_image_additional']       = 'Additional product image size dimensions required.';
		$_['lang_error_image_related']          = 'Related product image size dimensions required.';
		$_['lang_error_image_compare']          = 'Compare image size dimensions required.';
		$_['lang_error_image_wishlist']         = 'Wish list image size dimensions required.';
		$_['lang_error_image_cart']             = 'Cart image size dimensions required.';
		$_['lang_error_default']                = 'Warning: You can not delete your default store.';
		$_['lang_error_store']                  = 'Warning: This store cannot be deleted as it is currently assigned to %s orders.';

		return $_;
	}
}
