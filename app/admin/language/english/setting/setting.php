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

class Setting {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                      = 'Settings';

		// Text
		$_['lang_text_success']                       = 'Success: You have modified settings.';
		$_['lang_text_flush_success']                 = 'The cache has been flushed successfully.';
		$_['lang_text_items']                         = 'Items';
		$_['lang_text_product']                       = 'Products';
		$_['lang_text_gift_card']                      = 'Gift Cards';
		$_['lang_text_tax']                           = 'Taxes';
		$_['lang_text_account']                       = 'Account';
		$_['lang_text_checkout']                      = 'Checkout';
		$_['lang_text_stock']                         = 'Stock';
		$_['lang_text_affiliate']                     = 'Affiliates';
		$_['lang_text_return']                        = 'Returns';
		$_['lang_text_image_manager']                 = 'Image Manager';
		$_['lang_text_browse']                        = 'Browse';
		$_['lang_text_clear']                         = 'Clear';
		$_['lang_text_shipping']                      = 'Shipping Address';
		$_['lang_text_payment']                       = 'Payment Address';
		$_['lang_text_mail']                          = 'Mail';
		$_['lang_text_smtp']                          = 'SMTP';
		$_['lang_text_top_level']                     = 'Example: if you have a product that is normally linked as http://example.com/<b>mobile-phones/apple/iphone5</b>, with this setting enabled your link will now show as http://example.com/<b>iphone5</b>';
		$_['lang_text_ucfirst']                       = 'Example: http://example.com/<b>mobile-phones/apple/iphone5</b> will become: http://example.com/<b>Mobile-Phones/Apple/Iphone5</b>';
		$_['lang_text_description']                   = 'Dais ships with 3 possible caching mechanisms for caching your queries.  Code caching is handled automatically by the Autoloader method to use either APC, Opcache for PHP 5.5 and above, or none if you have neither installed. However you\'ll need to select a caching class for your queries.  Memcache is highly recommended if you have a large number of products or high traffic or both.';
		$_['lang_text_available']                     = 'Only your available choices will show in the menu below.  If you wish to use a different method, please install it on your server and it will become available here.';
		$_['lang_text_style_shop']                    = 'Shop';
		$_['lang_text_style_site']                    = 'Website';
		$_['lang_text_blog_pb_firstname_lastname']    = 'Firstname Lastname';
		$_['lang_text_blog_pb_lastname_firstname']    = 'Lastname Firstname';
		$_['lang_text_blog_pb_username']              = 'Username';
		$_['lang_text_blog_width']                    = 'Width';
		$_['lang_text_blog_height']                   = 'Height';

		// Entry
		$_['lang_entry_name']                         = 'Store Name:';
		$_['lang_entry_owner']                        = 'Store Owner:';
		$_['lang_entry_address']                      = 'Address:';
		$_['lang_entry_email']                        = 'E-Mail:<br><span class="help">This serves as the from email for all outgoing email from your site.</span>';
		$_['lang_entry_admin_email_user']             = 'Admin E-Mail User:<br><span class="help">Select the admin user from the list that should receive all administrative emails.</span>';
		$_['lang_entry_telephone']                    = 'Telephone:';
		$_['lang_entry_title']                        = 'Title:';
		$_['lang_entry_meta_description']             = 'Meta Tag Description:';
		$_['lang_entry_layout']                       = 'Default Layout:';
		$_['lang_entry_site_style']                   = 'Public Layout Style:<br><span class="help">Website will use Shop link for store, Shop will use Blog link to blog.</span>';
		$_['lang_entry_home_page']                    = 'Home Page:<br><span class="help">Select a specific page to use as your home page. This setting only applies if you selected <strong>website</strong> as your Public Layout Style above. If you don\'t set this, the normal blog roll page will be shown.</span>';
		$_['lang_entry_theme']                        = 'Store Theme:';
		$_['lang_entry_admin_theme']                  = 'Admin Theme:';
		$_['lang_entry_country']                      = 'Country:';
		$_['lang_entry_zone']                         = 'Region / State:';
		$_['lang_entry_language']                     = 'Language:';
		$_['lang_entry_admin_language']               = 'Administration Language:';
		$_['lang_entry_currency']                     = 'Currency:<br /><span class="help">Change the default currency. Clear your browser cache to see the change and reset your existing cookie.</span>';
		$_['lang_entry_currency_auto']                = 'Auto Update Currency:<br /><span class="help">Set your store to automatically update currencies daily.</span>';
		$_['lang_entry_length_class']                 = 'Length Class:';
		$_['lang_entry_weight_class']                 = 'Weight Class:';
		$_['lang_entry_catalog_limit']                = 'Default Items Per Page (Catalog):<br /><span class="help">Determines how many catalog items are shown per page (products, categories, etc)</span>';
		$_['lang_entry_admin_limit']                  = 'Default Items Per Page (Admin):<br /><span class="help">Determines how many admin items are shown per page (orders, customers, etc)</span>';
		$_['lang_entry_product_count']                = 'Category Product Count:<br /><span class="help">Show the number of products within the subcategories in the store front header category menu. Be very, very aware that this will cause an extreme performance hit for stores with a lot of subcategories.</span>';
		$_['lang_entry_review']                       = 'Allow Reviews:<br /><span class="help">Enable/disable new review entry and display of existing reviews</span>';
		$_['lang_entry_download']                     = 'Allow Downloads:';
		$_['lang_entry_gift_card_min']                 = 'Gift Card Min:<br /><span class="help">Minimum amount for which a customer can purchase a gift card.</span>';
		$_['lang_entry_gift_card_max']                 = 'Gift Card Max:<br /><span class="help">Maximum amount for which a customer can purchase a gift card.</span>';
		$_['lang_entry_tax']                          = 'Display Prices with Tax:';
		$_['lang_entry_vat']                          = 'VAT Number Validate:<br /><span class="help">Validate VAT number with http://ec.europa.eu service.</span>';
		$_['lang_entry_tax_default']                  = 'Use Store Tax Address:<br /><span class="help">Use the store address to calculate taxes if no one is logged in. You can choose to use the store address for the customers shipping or payment address.</span>';
		$_['lang_entry_tax_customer']                 = 'Use Customer Tax Address:<br /><span class="help">Use the customers default address when they login to calculate taxes. You can choose to use the default address for the customers shipping or payment address.</span>';
		$_['lang_entry_customer_online']              = 'Customers Online:<br /><span class="help">Track customers online via the customer reports section.</span>';
		$_['lang_entry_customer_group']               = 'Customer Group:<br /><span class="help">Default customer group.</span>';
		$_['lang_entry_customer_group_display']       = 'Customer Groups:<br /><span class="help">Displays customer groups new customers can select when signing up, such as wholesale and business .</span>';
		$_['lang_entry_customer_price']               = 'Login Display Prices:<br /><span class="help">Only show prices when a customer is logged in.</span>';
		$_['lang_entry_account']                      = 'Account Terms:<br /><span class="help">This forces people to agree to terms before an account can be created.</span>';
		$_['lang_entry_cart_weight']                  = 'Display Weight on Cart Page:<br /><span class="help">Show the cart weight on the cart page</span>';
		$_['lang_entry_guest_checkout']               = 'Guest Checkout:<br /><span class="help">Allow customers to checkout without creating an account. This will not be available when a downloadable product is in the shopping cart.</span>';
		$_['lang_entry_checkout']                     = 'Checkout Terms:<br /><span class="help">This forces people to agree to terms before a customer can checkout.</span>';
		$_['lang_entry_order_edit']                   = 'Order Editing:<br /><span class="help">Number of days allowed to edit an order. This is required because prices and discounts may change over time corrupting the order if it\'s edited.</span>';
		$_['lang_entry_invoice_prefix']               = 'Invoice Prefix:<br /><span class="help">Set the invoice prefix (e.g. INV-2011-00). Invoice IDs will start at 1 for each unique prefix</span>';
		$_['lang_entry_order_status']                 = 'Order Status:<br /><span class="help">Set the default order status when an order is processed.</span>';
		$_['lang_entry_complete_status']              = 'Complete Order Status:<br /><span class="help">Set the status the customer\'s order must reach prior to being allowed access to their downloadable products and gift gift_cards.</span>';
		$_['lang_entry_stock_display']                = 'Display Stock:<br /><span class="help">Display stock quantity on the product page.</span>';
		$_['lang_entry_stock_warning']                = 'Show Out Of Stock Warning:<br /><span class="help">Display out of stock message on the shopping cart page if a product is out of stock but stock checkout is yes. (Warning always shows if stock checkout is no)</span>';
		$_['lang_entry_stock_checkout']               = 'Stock Checkout:<br /><span class="help">Allow customers to continue with checkout if the products they are ordering are not in stock.</span>';
		$_['lang_entry_stock_status']                 = 'Out of Stock Status:<br /><span class="help">Set the default out of stock status selected in product edit.</span>';
		$_['lang_entry_affiliate_allowed']            = 'Allow Affiliates:<br><span class="help">Allow customers to register as affiliates. If set to no, anything related to the affiliate program will be disabled sitewide.</span>';
		$_['lang_entry_affiliate_terms']              = 'Affiliate Terms:<br /><span class="help">This forces people to agree to terms before an affiliate account can be created.</span>';
		$_['lang_entry_commission']                   = 'Affiliate Commission (%):<br /><span class="help">The default affiliate commission percentage.</span>';
		$_['lang_entry_return']                       = 'Return Terms:<br /><span class="help">This forces people to agree to terms before a return account can be created.</span>';
		$_['lang_entry_return_status']                = 'Return Status:<br /><span class="help">Set the default return status when a return request is submitted.</span>';
		$_['lang_entry_logo']                         = 'Store Logo:';
		$_['lang_entry_icon']                         = 'Icon:<br /><span class="help">The icon should be a PNG that is 16px x 16px.</span>';
		$_['lang_entry_image_category']               = 'Category Image Size:';
		$_['lang_entry_image_thumb']                  = 'Product Image Thumb Size:';
		$_['lang_entry_image_popup']                  = 'Product Image Popup Size:';
		$_['lang_entry_image_product']                = 'Product Image List Size:';
		$_['lang_entry_image_additional']             = 'Additional Product Image Size:';
		$_['lang_entry_image_related']                = 'Related Product Image Size:';
		$_['lang_entry_image_compare']                = 'Compare Image Size:';
		$_['lang_entry_image_wishlist']               = 'Wish List Image Size:';
		$_['lang_entry_image_cart']                   = 'Cart Image Size:';
		$_['lang_entry_ftp_host']                     = 'FTP Host:';
		$_['lang_entry_ftp_port']                     = 'FTP Port:';
		$_['lang_entry_ftp_username']                 = 'FTP Username:';
		$_['lang_entry_ftp_password']                 = 'FTP Password:';
		$_['lang_entry_ftp_root']                     = 'FTP Root:<span class="help">The directory where your Dais installation is normally stored \'public_html/\'.</span>';
		$_['lang_entry_ftp_status']                   = 'Enable FTP:';
		$_['lang_entry_mail_protocol']                = 'Mail Protocol:<span class="help">Only choose \'Mail\' unless your host has disabled the PHP mail function.</span>';
		$_['lang_entry_mail_parameter']               = 'Mail Parameters:<span class="help">When using \'Mail\', additional mail parameters can be added here (e.g. "-femail@storeaddress.com").</span>';
		$_['lang_entry_smtp_host']                    = 'SMTP Host:';
		$_['lang_entry_smtp_username']                = 'SMTP Username:';
		$_['lang_entry_smtp_password']                = 'SMTP Password:';
		$_['lang_entry_smtp_port']                    = 'SMTP Port:';
		$_['lang_entry_smtp_timeout']                 = 'SMTP Timeout:';
		$_['lang_entry_mail_twitter']                 = 'Twitter Handle:<br><span class="help">Your Twitter handle for your store. DO NOT include the http address, just the handle. IE: Dais <b>NOT</b> http://twitter.com/Dais.</span>';	
		$_['lang_entry_mail_facebook']                = 'Facebook Page:<br><span class="help">Your Facebook page for your store. DO NOT include the http address, just the page name. IE: Dais <b>NOT</b> http://www.facebook.com/Dais.</span>';	
		$_['lang_entry_account_mail']                 = 'New Account Alert Mail:<br /><span class="help">Send an E-mail to the store owner when a new account is registered.</span>';
		$_['lang_entry_alert_mail']                   = 'New Order Alert Mail:<br /><span class="help">Send an E-mail to the store owner when a new order is created.</span>';
		$_['lang_entry_alert_emails']                 = 'Additional Alert E-Mails:<br /><span class="help">Any additional E-mail accounts you want alert E-mails sent to, in addition to the main store email. (comma separated)</span>';
		$_['lang_entry_signature_text']               = 'Text E-Mail Signature:<br><span class="help">Added to the footer of your text email wrapper.</span>';
		$_['lang_entry_signature_html']               = 'HTML E-Mail Signature:<br><span class="help">Added to the footer of your HTML email wrapper, and internal notifications.</span>';
		$_['lang_entry_fraud_detection']              = 'Use MaxMind Fraud Detection System:<br /><span class="help">MaxMind is a fraud detection service. If you don\'t have a license key you can <a href="http://www.maxmind.com/" target="_blank"><u>sign up here</u></a>. Once you have obtained a key copy you can paste it into the field below.</span>';
		$_['lang_entry_fraud_key']                    = 'MaxMind License Key:</span>';
		$_['lang_entry_fraud_score']                  = 'MaxMind Risk Score:<br /><span class="help">The higher the score the more likely the order is fraudulent. Set a score between 0 - 100.</span>';
		$_['lang_entry_fraud_status']                 = 'MaxMind Fraud Order Status:<br /><span class="help">Orders over your set score will be assigned this order status and will not be allowed to reach the complete status automatically.</span>';
		$_['lang_entry_secure']                       = 'Use SSL:<br /><span class="help">To use SSL check with your host if a SSL certificate is installed and added the SSL URL to the catalog and admin config files.</span>';
		$_['lang_entry_shared']                       = 'Use Shared Sessions:<br /><span class="help">Try to share the session cookie between stores so the cart can be passed between different domains.</span>';
		$_['lang_entry_robots']                       = 'Robots:<br /><span class="help">A list of web crawler user agents that shared sessions will not be used with. Use separate lines for each user agent.</span>';

		$_['lang_entry_top_level']                    = 'Make URLs Top Level:<br><span class="help">This will force all links for products, categories, manufacturers and pages to appear as top level URLs.</span>';
		$_['lang_entry_ucfirst']                      = 'UC First:<br><span class="help">Enabling this setting will convert your URL slugs to capitalize the first letter of each word.</span>';

		$_['lang_entry_file_extension_allowed']       = 'Allowed File Extensions:<br /><span class="help">Add which file extensions are allowed to be uploaded. Use a new line for each value.</span>';
		$_['lang_entry_file_mime_allowed']            = 'Allowed File Mime Types:<br /><span class="help">Add which file mime types are allowed to be uploaded. Use a new line for each value.</span>';
		$_['lang_entry_maintenance']                  = 'Maintenance Mode:<br /><span class="help">Prevents customers from browsing your store. They will instead see a maintenance message. If logged in as admin, you will see the store as normal.</span>';
		$_['lang_entry_password']                     = 'Allow Forgotten Password:<br /><span class="help">Allow forgotten password to be used for the admin. This will be disabled automatically if the system detects a hack attempt.</span>';
		$_['lang_entry_encryption']                   = 'Encryption Key:<br /><span class="help">Please provide a secret key that will be used to encrypt private information when processing orders.</span>';
		$_['lang_entry_compression']                  = 'Output Compression Level:<br /><span class="help">GZIP for more efficient transfer to requesting clients. Compression level must be between 0 - 9</span>';
		$_['lang_entry_error_display']                = 'Display Errors:';
		$_['lang_entry_error_log']                    = 'Log Errors:';
		$_['lang_entry_error_filename']               = 'Error Log Filename:';
		$_['lang_entry_google_analytics']             = 'Google Analytics Code:<br /><span class="help">Login to your <a href="http://www.google.com/analytics/" target="_blank"><u>Google Analytics</u></a> account and after creating your web site profile copy and paste the Google Analytics code into this field.</span>';
		$_['lang_entry_caches']                       = 'Query Cache Type:';
		$_['lang_entry_cache_status']                 = 'Cache Status:<br><span class="help">If Disabled, your cache will still be used, but will be flushed on each page load. Disable this ONLY during development.</span>';
		$_['lang_entry_default_visibility']           = 'Content Visibility:<br><span class="help">This sets the default visibility for blog posts and pages so that you can control which posts/pages are publicly viewable.</span>';
		$_['lang_entry_free_customer']                = 'Free Customer Level:<br><span class="help">Select your free customer group for determining content visibility.</span>';
		$_['lang_entry_default_category']             = 'Owner Blog Category:<br><span class="help">Select your Owner Blog category.</span>';
		$_['lang_entry_delete_posts']                 = 'Delete Posts?:<br><span class="help">When a customer with write priviledges is deleted should we delete their posts. <span class="text-danger"><b>Recommended: NO</b></span></span>';
		$_['lang_entry_assign_to']                    = 'Assign Posts To:<br><span class="help">(autocomplete)<br>If keeping posts, select a customer account to assign as the new author.<br><span class="text-danger"><b>Must be active, and Top Customer Level.</b></span></span>';
		$_['lang_entry_top_customer']                 = 'Top Customer Level:<br><span class="help">Your top level customer group.</span>';
		$_['lang_entry_member_image_dir']             = 'Upload Image Directory:<br><span class="help">Set the base upload folder for blog writers so that they can only access their own images. <br>Do not include a trailing slash.</span>';
		$_['lang_entry_review_anonymous']             = 'Anonymous Reviews:<br><span class="help">Set to yes to allow anonymous reviews, no to require customers to be logged in to post a review.</span>';
		$_['lang_entry_blog_posted_by']               = 'Author Info:<br><span class="help">How should we show the author info?</span>';
		$_['lang_entry_blog_comment']                 = 'Allow Comments:<br><span class="help">Enable/Disable new comment entry and display of existing comments.</span>';
		$_['lang_entry_blog_comment_require_approve'] = 'Comments Require Approval?:<br><span class="help">Should comments be approved by an admin?</span>';
		$_['lang_entry_blog_admin_group']             = 'Admin Group:<span class="help">Allowed to add/edit any post from the Admin area.</span>';
		$_['lang_entry_blog_image_thumb']             = 'Post Image Thumb Size:';
		$_['lang_entry_blog_image_popup']             = 'Post Image Popup Size:';
		$_['lang_entry_blog_image_post']              = 'Post Image List Size:';
		$_['lang_entry_blog_image_additional']        = 'Post Gallery Image Size:';
		$_['lang_entry_blog_image_related']           = 'Related Post Image Size:';
		$_['lang_entry_blog_comment_anonymous']       = 'Anonymous Comments:<br><span class="help">Set to yes to allow anonymous comments, no to require customers to be logged in to post a comment.</span>';

		// Error
		$_['lang_error_warning']                      = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']                   = 'Warning: You do not have permission to modify settings.';
		$_['lang_error_name']                         = 'Store name must be between 3 and 32 characters.';
		$_['lang_error_owner']                        = 'Store owner must be between 3 and 64 characters.';
		$_['lang_error_address']                      = 'Store address must be between 10 and 256 characters.';
		$_['lang_error_email']                        = 'E-Mail address does not appear to be valid.';
		$_['lang_error_admin_email_user']             = 'Admin email user is required.';
		$_['lang_error_telephone']                    = 'Telephone must be between 3 and 32 characters.';
		$_['lang_error_title']                        = 'Title must be between 3 and 32 characters.';
		$_['lang_error_limit']                        = 'Limit required.';
		$_['lang_error_customer_group_display']       = 'You must include the default customer group in order to use this feature.';
		$_['lang_error_gift_card_min']                 = 'Minimum gift card amount required.';
		$_['lang_error_gift_card_max']                 = 'Maximum gift card amount required.';
		$_['lang_error_image_thumb']                  = 'Product image thumb size dimensions required.';
		$_['lang_error_image_popup']                  = 'Product image pop-up size dimensions required.';
		$_['lang_error_image_product']                = 'Product list size dimensions required.';
		$_['lang_error_image_category']               = 'Category list size dimensions required.';
		$_['lang_error_image_additional']             = 'Additional product image size dimensions required.';
		$_['lang_error_image_related']                = 'Related product image size dimensions required.';
		$_['lang_error_image_compare']                = 'Compare image size dimensions required.';
		$_['lang_error_image_wishlist']               = 'Wish list image size dimensions required.';
		$_['lang_error_image_cart']                   = 'Cart image size dimensions required.';
		$_['lang_error_ftp_host']                     = 'FTP Host required.';
		$_['lang_error_ftp_port']                     = 'FTP Port required.';
		$_['lang_error_ftp_username']                 = 'FTP Username required.';
		$_['lang_error_ftp_password']                 = 'FTP Password required.';
		$_['lang_error_error_filename']               = 'Error Log Filename required.';
		$_['lang_error_encryption']                   = 'Encryption must be between 3 and 32 characters.';
		$_['lang_error_default_visibility']           = 'Please select a Content Visibility.';
		$_['lang_error_free_customer']                = 'Please select a Free Customer Level.';
		$_['lang_error_top_customer']                 = 'Please select a Top Customer Level.';
		$_['lang_error_assign_to']                    = 'If you\'re not deleting posts, you must assign a new author.';
		$_['lang_error_member_image_dir']             = 'Please set the Upload Image Directory for member uploaded pictures.';
		$_['lang_error_affiliate_terms']              = 'If allowing affiliates, Terms must be selected.';
		$_['lang_error_affiliate_commission']         = 'If allowing affiliates, a Commission percentage must be set.';
		$_['lang_error_text_signature']               = 'Text signature is required.';
		$_['lang_error_html_signature']               = 'HTML signature is required.';
		$_['lang_error_blog_posted_by']               = 'Choose author name display mode.';
		$_['lang_error_blog_admin_group_id']          = 'Choose group for admin accounts.';
		$_['lang_error_blog_image_thumb']             = 'Post Image Thumb Size dimensions required.';
		$_['lang_error_blog_image_popup']             = 'Post Image Popup Size dimensions required.';
		$_['lang_error_blog_image_post']              = 'Post List Size dimensions required.';
		$_['lang_error_blog_image_additional']        = 'Post Gallery Image Size dimensions required.';
		$_['lang_error_blog_image_related']           = 'Related Product Image Size dimensions required.';

		return $_;
	}
}
