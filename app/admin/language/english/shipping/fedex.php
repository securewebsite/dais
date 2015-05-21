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

namespace Admin\Language\English\Shipping;

class Fedex {
	public static function lang() {
		// Heading
		$_['lang_heading_title']                            = 'Fedex';

		// Text
		$_['lang_text_shipping']                            = 'Shipping';
		$_['lang_text_success']                             = 'Success: You have modified Fedex shipping.';
		$_['lang_text_europe_first_international_priority'] = 'Europe First International Priority';
		$_['lang_text_fedex_1_day_freight']                 = 'Fedex 1 Day Freight';
		$_['lang_text_fedex_2_day']                         = 'Fedex 2 Day';
		$_['lang_text_fedex_2_day_am']                      = 'Fedex 2 Day AM';
		$_['lang_text_fedex_2_day_freight']                 = 'Fedex 2 Day Freight';
		$_['lang_text_fedex_3_day_freight']                 = 'Fedex 3 Day Freight';
		$_['lang_text_fedex_express_saver']                 = 'Fedex Express Saver';
		$_['lang_text_fedex_first_freight']                 = 'Fedex First Fright';
		$_['lang_text_fedex_freight_economy']               = 'Fedex Fright Economy';
		$_['lang_text_fedex_freight_priority']              = 'Fedex Fright Priority';
		$_['lang_text_fedex_ground']                        = 'Fedex Ground';
		$_['lang_text_first_overnight']                     = 'First Overnight';
		$_['lang_text_ground_home_delivery']                = 'Ground Home Delivery';
		$_['lang_text_international_economy']               = 'International Economy';
		$_['lang_text_international_economy_freight']       = 'International Economy Freight';
		$_['lang_text_international_first']                 = 'International First';
		$_['lang_text_international_priority']              = 'International Priority';
		$_['lang_text_international_priority_freight']      = 'International Priority Freight';
		$_['lang_text_priority_overnight']                  = 'Priority Overnight';
		$_['lang_text_smart_post']                          = 'Smart Post';
		$_['lang_text_standard_overnight']                  = 'Standard Overnight';
		$_['lang_text_regular_pickup']                      = 'Regular Pickup';
		$_['lang_text_request_courier']                     = 'Request Courier';
		$_['lang_text_drop_box']                            = 'Drop Box';
		$_['lang_text_business_service_center']             = 'Business Service Center';
		$_['lang_text_station']                             = 'Station';
		$_['lang_text_fedex_envelope']                      = 'FedEx Envelope';
		$_['lang_text_fedex_pak']                           = 'FedEx Pak';
		$_['lang_text_fedex_box']                           = 'FedEx Box';
		$_['lang_text_fedex_tube']                          = 'FedEx Tube';
		$_['lang_text_fedex_10kg_box']                      = 'FedEx 10kg Box';
		$_['lang_text_fedex_25kg_box']                      = 'FedEx 25kg Box';
		$_['lang_text_your_packaging']                      = 'Your Packaging';
		$_['lang_text_list_rate']                           = 'List Rate';
		$_['lang_text_account_rate']                        = 'Account Rate';

		// Entry
		$_['lang_entry_key']                                = 'Key:';
		$_['lang_entry_password']                           = 'Password:';
		$_['lang_entry_account']                            = 'Account Number:';
		$_['lang_entry_meter']                              = 'Meter Number:';
		$_['lang_entry_postcode']                           = 'Post Code:';
		$_['lang_entry_test']                               = 'Test Mode:';
		$_['lang_entry_service']                            = 'Services:';
		$_['lang_entry_dropoff_type']                       = 'Drop Off Type:';
		$_['lang_entry_packaging_type']                     = 'Packaging Type:';
		$_['lang_entry_rate_type']                          = 'Rate Type:';
		$_['lang_entry_display_time']                       = 'Display Delivery Time:<br /><span class="help">Do you want to display the shipping time? (e.g. Ships within 3 to 5 days)</span>';
		$_['lang_entry_display_weight']                     = 'Display Delivery Weight:<br /><span class="help">Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 Kg\'s)</span>';
		$_['lang_entry_weight_class']                       = 'Weight Class:<span class="help">Set to kilograms or pounds.</span>';
		$_['lang_entry_tax_class']                          = 'Tax Class:';
		$_['lang_entry_geo_zone']                           = 'Geo Zone:';
		$_['lang_entry_status']                             = 'Status:';
		$_['lang_entry_sort_order']                         = 'Sort Order:';

		// Error
		$_['lang_error_permission']                         = 'Warning: You do not have permission to modify Fedex shipping.';
		$_['lang_error_key']                                = 'Key Required.';
		$_['lang_error_password']                           = 'Password Required.';
		$_['lang_error_account']                            = 'Account Required.';
		$_['lang_error_meter']                              = 'Meter Required.';
		$_['lang_error_postcode']                           = 'Post Code Required.';

		return $_;
	}
}
