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

class Order {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                           = 'Orders';

		// Text
		$_['lang_text_name']                               = 'Name:';
		$_['lang_text_success']                            = 'Success: You have modified orders.';
		$_['lang_text_order_id']                           = 'Order ID:';
		$_['lang_text_invoice_no']                         = 'Invoice No.:';
		$_['lang_text_invoice_date']                       = 'Invoice Date:';
		$_['lang_text_store_name']                         = 'Store Name:';
		$_['lang_text_store_url']                          = 'Store URL:';
		$_['lang_text_customer']                           = 'Customer:';
		$_['lang_text_customer_group']                     = 'Customer Group:';
		$_['lang_text_email']                              = 'E-Mail:';
		$_['lang_text_telephone']                          = 'Telephone:';
		$_['lang_text_shipping_method']                    = 'Shipping Method:';
		$_['lang_text_payment_method']                     = 'Payment Method:';
		$_['lang_text_total']                              = 'Total:';
		$_['lang_text_reward']                             = 'Reward Points:';
		$_['lang_text_order_status']                       = 'Order Status:';
		$_['lang_text_comment']                            = 'Comment:';
		$_['lang_text_affiliate']                          = 'Affiliate:';
		$_['lang_text_commission']                         = 'Commission:';
		$_['lang_text_ip']                                 = 'IP Address:';
		$_['lang_text_forwarded_ip']                       = 'Forwarded IP:';
		$_['lang_text_user_agent']                         = 'User Agent:';
		$_['lang_text_accept_language']                    = 'Accept Language:';
		$_['lang_text_date_added']                         = 'Date Added:';
		$_['lang_text_date_modified']                      = 'Date Modified:';
		$_['lang_text_firstname']                          = 'First Name:';
		$_['lang_text_lastname']                           = 'Last Name:';
		$_['lang_text_company']                            = 'Company:';
		$_['lang_text_company_id']                         = 'Company ID:';
		$_['lang_text_tax_id']                             = 'Tax ID:';
		$_['lang_text_address_1']                          = 'Address 1:';
		$_['lang_text_address_2']                          = 'Address 2:';
		$_['lang_text_postcode']                           = 'Postal Code:';
		$_['lang_text_city']                               = 'City:';
		$_['lang_text_zone']                               = 'Region / State:';
		$_['lang_text_zone_code']                          = 'Region / State Code:';
		$_['lang_text_country']                            = 'Country:';
		$_['lang_text_download']                           = 'Order Downloads';
		$_['lang_text_invoice']                            = 'Invoice';
		$_['lang_text_to']                                 = 'To';
		$_['lang_text_ship_to']                            = 'Ship To (if different address)';
		$_['lang_text_missing']                            = 'Missing Orders';
		$_['lang_text_default']                            = 'Default';
		$_['lang_text_wait']                               = 'Please Wait.';
		$_['lang_text_product']                            = 'Add Product(s)';
		$_['lang_text_gift_card']                           = 'Add Gift Card(s)';
		$_['lang_text_order']                              = 'Order Details';
		$_['lang_text_generate']                           = 'Generate';
		$_['lang_text_reward_add']                         = 'Add Reward Points';
		$_['lang_text_reward_added']                       = 'Success: Reward points Added.';
		$_['lang_text_reward_remove']                      = 'Remove Reward Points';
		$_['lang_text_reward_removed']                     = 'Success: Reward points Removed.';
		$_['lang_text_commission_add']                     = 'Add Commission';
		$_['lang_text_commission_added']                   = 'Success: Commission Added.';
		$_['lang_text_commission_remove']                  = 'Remove Commission';
		$_['lang_text_commission_removed']                 = 'Success: Commission Removed.';
		$_['lang_text_credit_add']                         = 'Add Credit';
		$_['lang_text_credit_added']                       = 'Success: Account Credit Added.';
		$_['lang_text_credit_remove']                      = 'Remove Credit';
		$_['lang_text_credit_removed']                     = 'Success: Account credit removed.';
		$_['lang_text_upload']                             = 'Your file was successfully uploaded.';
		$_['lang_text_country_match']                      = 'Country Match:<br /><span class="help">Whether country of IP address matches billing address country (mismatch = higher risk).</span>';
		$_['lang_text_country_code']                       = 'Country Code:<br /><span class="help">Country code of the IP address.</span>';
		$_['lang_text_high_risk_country']                  = 'High Risk Country:<br /><span class="help">Whether IP address or billing address country is in Ghana, Nigeria, or Vietnam.</span>';
		$_['lang_text_distance']                           = 'Distance:<br /><span class="help">Distance from IP address to billing location in kilometers (large distance = higher risk).</span>';
		$_['lang_text_ip_region']                          = 'IP Region:<br /><span class="help">Estimated state/region of the IP address.</span>';
		$_['lang_text_ip_city']                            = 'IP City:<br /><span class="help">Estimated city of the IP address.</span>';
		$_['lang_text_ip_latitude']                        = 'IP Latitude:<br /><span class="help">Estimated latitude of the IP address.</span>';
		$_['lang_text_ip_longitude']                       = 'IP Longitude:<br /><span class="help">Estimated longitude of the IP address.</span>';
		$_['lang_text_ip_isp']                             = 'ISP:<br /><span class="help">ISP of the IP address.</span>';
		$_['lang_text_ip_org']                             = 'IP Organization:<br /><span class="help">Organization of the IP address.</span>';
		$_['lang_text_ip_asnum']                           = 'ASNUM:<br /><span class="help">Estimated autonomous system number of the IP address.</span>';
		$_['lang_text_ip_user_type']                       = 'IP User Type:<br /><span class="help">Estimated user type of the IP address.</span>';
		$_['lang_text_ip_country_confidence']              = 'IP Country Confidence:<br /><span class="help">Representing our confidence that the country location is correct.</span>';
		$_['lang_text_ip_region_confidence']               = 'IP Region Confidence:<br /><span class="help">Representing our confidence that the region location is correct.</span>';
		$_['lang_text_ip_city_confidence']                 = 'IP City Confidence:<br /><span class="help">Representing our confidence that the city location is correct.</span>';
		$_['lang_text_ip_postal_confidence']               = 'IP Postal Confidence:<br /><span class="help">Representing our confidence that the postal code location is correct.</span>';
		$_['lang_text_ip_postal_code']                     = 'IP Postal Code:<br /><span class="help">Estimated postal code of the IP address.</span>';
		$_['lang_text_ip_accuracy_radius']                 = 'IP Accuracy Radius:<br /><span class="help">The average distance between the actual location of the end user using the IP address and the location returned by the GeoIP city database, in miles.</span>';
		$_['lang_text_ip_net_speed_cell']                  = 'IP Net Speed Cell:<br /><span class="help">Estimated network type of the IP address.</span>';
		$_['lang_text_ip_metro_code']                      = 'IP Metro Code:<br /><span class="help">Estimated metro code of the IP address.</span>';
		$_['lang_text_ip_area_code']                       = 'IP Area Code:<br /><span class="help">Estimated area code of the IP address.</span>';
		$_['lang_text_ip_time_zone']                       = 'IP Time Zone:<br /><span class="help">Estimated time zone of the IP address.</span>';
		$_['lang_text_ip_region_name']                     = 'IP Region Name:<br /><span class="help">Estimated region name of the IP address.</span>';
		$_['lang_text_ip_domain']                          = 'IP Domain:<br /><span class="help">Estimated domain of the IP address.</span>';
		$_['lang_text_ip_country_name']                    = 'IP Country Name:<br /><span class="help">Estimated country name of the IP address.</span>';
		$_['lang_text_ip_continent_code']                  = 'IP Continent Code:<br /><span class="help">Estimated continent code of the IP address.</span>';
		$_['lang_text_ip_corporate_proxy']                 = 'IP Corporate Proxy:<br /><span class="help">Whether the IP is a corporate proxy in the database or not.</span>';
		$_['lang_text_anonymous_proxy']                    = 'Anonymous Proxy:<br /><span class="help">Whether IP address is anonymous proxy (anonymous proxy = very high risk).</span>';
		$_['lang_text_proxy_score']                        = 'Proxy Score:<br /><span class="help">Likelihood of IP address being an open proxy.</span>';
		$_['lang_text_is_trans_proxy']                     = 'Is Transparent Proxy:<br /><span class="help">Whether IP address is in our database of known transparent proxy servers, returned if forwarded IP is passed as an input.</span>';
		$_['lang_text_free_mail']                          = 'Free Mail:<br /><span class="help">Whether e-mail is from free e-mail provider (free e-mail = higher risk).</span>';
		$_['lang_text_carder_email']                       = 'Carder Email:<br /><span class="help">Whether e-mail is in database of high risk e-mails.</span>';
		$_['lang_text_high_risk_username']                 = 'High Risk Username:<br /><span class="help">Whether usernameMD5 input is in database of high risk usernames. Only returned if usernameMD5 is included in inputs.</span>';
		$_['lang_text_high_risk_password']                 = 'High Risk Password:<br /><span class="help">Whether passwordMD5 input is in database of high risk passwords. Only returned if passwordMD5 is included in inputs.</span>';
		$_['lang_text_bin_match']                          = 'Bin Match:<br /><span class="help">Whether country of issuing bank based on BIN number matches billing address country.</span>';
		$_['lang_text_bin_country']                        = 'Bin Country:<br /><span class="help">Country code of the bank which issued the credit card based on BIN number.</span>';
		$_['lang_text_bin_name_match']                     = 'Bin Name Match:<br /><span class="help">Whether name of issuing bank matches input BIN name. A return value of Yes provides a positive indication that card holder is in possession of credit card.</span>';
		$_['lang_text_bin_name']                           = 'Bin Name:<br /><span class="help">Name of the bank which issued the credit card based on BIN number. Available for approximately 96% of BIN numbers.</span>';
		$_['lang_text_bin_phone_match']                    = 'Bin Phone Match:<br /><span class="help">Whether customer service phone number matches input BIN Phone. A return value of Yes provides a positive indication that card holder is in possession of credit card.</span>';
		$_['lang_text_bin_phone']                          = 'Bin Phone:<br /><span class="help">Customer service phone number listed on back of credit card. Available for approximately 75% of BIN numbers. In some cases phone number returned may be outdated.</span>';
		$_['lang_text_customer_phone_in_billing_location'] = 'Customer Phone Number in Billing Location:<br /><span class="help">Whether the customer phone number is in the billing zip code. A return value of Yes provides a positive indication that the phone number listed belongs to the card holder. A return value of No indicates that the phone number may be in a different area, or may not be listed in our database. NotFound is returned when the phone number prefix cannot be found in our database at all. Currently we only support US Phone numbers.</span>';
		$_['lang_text_ship_forward']                       = 'Shipping Forward:<br /><span class="help">Whether shipping address is in database of known mail drops.</span>';
		$_['lang_text_city_postal_match']                  = 'City Postal Match:<br /><span class="help">Whether billing city and state match zip code. Currently available for US addresses only, returns empty string outside the US.</span>';
		$_['lang_text_ship_city_postal_match']             = 'Shipping City Postal Match:<br /><span class="help">Whether shipping city and state match zip code. Currently available for US addresses only, returns empty string outside the US.</span>';
		$_['lang_text_score']                              = 'Score:<br /><span class="help">Overall fraud score based on outputs listed above. This is the original fraud score, and is based on a simple formula. It has been replaced with risk score (see below), but is kept for backwards compatibility.</span>';
		$_['lang_text_explanation']                        = 'Explanation:<br /><span class="help">A brief explanation of the score, detailing what factors contributed to it, according to our formula. Please note this corresponds to the score, not the risk score.</span>';
		$_['lang_text_risk_score']                         = 'Risk Score:<br /><span class="help">New fraud score representing the estimated probability that the order is fraud, based on an analysis of past minFraud transactions. Requires an upgrade for clients who signed up before February 2007.</span>';
		$_['lang_text_queries_remaining']                  = 'Queries Remaining:<br /><span class="help">Number of queries remaining in your account, can be used to alert you when you may need to add more queries to your account.</span>';
		$_['lang_text_maxmind_id']                         = 'Maxmind ID:<br /><span class="help">Unique identifier, used to reference transactions when reporting fraudulent activity back to MaxMind. This reporting will help MaxMind improve its service to you and will enable a planned feature to customize the fraud scoring formula based on your charge back history.</span>';
		$_['lang_text_error']                              = 'Error:<br /><span class="help">Returns an error string with a warning message or the reason the request failed.</span>';

		// Column
		$_['lang_column_order_id']                         = 'Order ID';
		$_['lang_column_customer']                         = 'Customer';
		$_['lang_column_status']                           = 'Status';
		$_['lang_column_date_added']                       = 'Date Added';
		$_['lang_column_date_modified']                    = 'Date Modified';
		$_['lang_column_total']                            = 'Total';
		$_['lang_column_product']                          = 'Product';
		$_['lang_column_model']                            = 'Model';
		$_['lang_column_quantity']                         = 'Quantity';
		$_['lang_column_price']                            = 'Unit Price';
		$_['lang_column_download']                         = 'Download Name';
		$_['lang_column_filename']                         = 'Filename';
		$_['lang_column_remaining']                        = 'Remaining Downloads';
		$_['lang_column_comment']                          = 'Comment';
		$_['lang_column_notify']                           = 'Customer Notified';
		$_['lang_column_action']                           = 'Action';

		// Entry
		$_['lang_entry_store']                             = 'Store:';
		$_['lang_entry_customer']                          = 'Customer:';
		$_['lang_entry_customer_group']                    = 'Customer Group:';
		$_['lang_entry_firstname']                         = 'First Name:';
		$_['lang_entry_lastname']                          = 'Last Name:';
		$_['lang_entry_email']                             = 'E-Mail:';
		$_['lang_entry_telephone']                         = 'Telephone:';
		$_['lang_entry_address']                           = 'Choose Address:';
		$_['lang_entry_company']                           = 'Company:';
		$_['lang_entry_company_id']                        = 'Company ID:';
		$_['lang_entry_tax_id']                            = 'Tax ID:';
		$_['lang_entry_address_1']                         = 'Address 1:';
		$_['lang_entry_address_2']                         = 'Address 2:';
		$_['lang_entry_city']                              = 'City:';
		$_['lang_entry_postcode']                          = 'Postal Code:';
		$_['lang_entry_country']                           = 'Country:';
		$_['lang_entry_zone']                              = 'Region / State:';
		$_['lang_entry_zone_code']                         = 'Region / State Code:';
		$_['lang_entry_product']                           = 'Choose Product:';
		$_['lang_entry_option']                            = 'Choose Option(s):';
		$_['lang_entry_quantity']                          = 'Quantity:';
		$_['lang_entry_to_name']                           = 'Recipient\'s Name:';
		$_['lang_entry_to_email']                          = 'Recipient\'s E-mail:';
		$_['lang_entry_from_name']                         = 'Senders Name:';
		$_['lang_entry_from_email']                        = 'Senders E-mail:';
		$_['lang_entry_theme']                             = 'Gift Certificate Theme:';
		$_['lang_entry_message']                           = 'Message:';
		$_['lang_entry_amount']                            = 'Amount:';
		$_['lang_entry_affiliate']                         = 'Affiliate:';
		$_['lang_entry_order_status']                      = 'Order Status:';
		$_['lang_entry_notify']                            = 'Notify Customer:';
		$_['lang_entry_comment']                           = 'Comment:';
		$_['lang_entry_shipping']                          = 'Shipping Method:';
		$_['lang_entry_payment']                           = 'Payment Method:';
		$_['lang_entry_coupon']                            = 'Coupon:';
		$_['lang_entry_gift_card']                          = 'Gift Card:';
		$_['lang_entry_reward']                            = 'Reward:';

		// Error
		$_['lang_error_warning']                           = 'Warning: Please check the form carefully for errors.';
		$_['lang_error_permission']                        = 'Warning: You do not have permission to modify orders.';
		$_['lang_error_firstname']                         = 'First name must be between 1 and 32 characters.';
		$_['lang_error_lastname']                          = 'Last name must be between 1 and 32 characters.';
		$_['lang_error_email']                             = 'E-Mail address does not appear to be valid.';
		$_['lang_error_telephone']                         = 'Telephone must be between 3 and 32 characters.';
		$_['lang_error_password']                          = 'Password must be between 3 and 20 characters.';
		$_['lang_error_confirm']                           = 'Password and password confirmation do not match.';
		$_['lang_error_company_id']                        = 'Company ID required.';
		$_['lang_error_tax_id']                            = 'Tax ID required.';
		$_['lang_error_vat']                               = 'VAT number is invalid.';
		$_['lang_error_address_1']                         = 'Address 1 must be between 3 and 128 characters.';
		$_['lang_error_city']                              = 'City must be between 3 and 128 characters.';
		$_['lang_error_postcode']                          = 'Postal code must be between 2 and 10 characters for this country.';
		$_['lang_error_country']                           = 'Please select a country.';
		$_['lang_error_zone']                              = 'Please select a region / state.';
		$_['lang_error_shipping']                          = 'Warning: Shipping method required.';
		$_['lang_error_payment']                           = 'Warning: Payment method required.';
		$_['lang_error_upload']                            = 'Upload required.';
		$_['lang_error_filename']                          = 'Filename must be between 3 and 128 characters.';
		$_['lang_error_filetype']                          = 'Invalid file type.';
		$_['lang_error_action']                            = 'Warning: Could not complete this action.';

		return $_;
	}
}
