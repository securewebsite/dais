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

class Usps {
	public static function lang() {
		// Heading
		$_['lang_heading_title']         = 'United States Postal Service';

		// Text
		$_['lang_text_shipping']         = 'Shipping';
		$_['lang_text_success']          = 'Success: You have modified United States Postal Service.';
		$_['lang_text_domestic_00']      = 'First-Class Mail Parcel';
		$_['lang_text_domestic_01']      = 'First-Class Mail Large Envelope';
		$_['lang_text_domestic_02']      = 'First-Class Mail Letter';
		$_['lang_text_domestic_03']      = 'First-Class Mail Postcards';
		$_['lang_text_domestic_1']       = 'Priority Mail';
		$_['lang_text_domestic_2']       = 'Express Mail Hold for Pickup';
		$_['lang_text_domestic_3']       = 'Express Mail';
		$_['lang_text_domestic_4']       = 'Parcel Post';
		$_['lang_text_domestic_5']       = 'Bound Printed Matter';
		$_['lang_text_domestic_6']       = 'Media Mail';
		$_['lang_text_domestic_7']       = 'Library';
		$_['lang_text_domestic_12']      = 'First-Class Postcard Stamped';
		$_['lang_text_domestic_13']      = 'Express Mail Flat-Rate Envelope';
		$_['lang_text_domestic_16']      = 'Priority Mail Flat-Rate Envelope';
		$_['lang_text_domestic_17']      = 'Priority Mail Regular Flat-Rate Box';
		$_['lang_text_domestic_18']      = 'Priority Mail Keys and IDs';
		$_['lang_text_domestic_19']      = 'First-Class Keys and IDs';
		$_['lang_text_domestic_22']      = 'Priority Mail Flat-Rate Large Box';
		$_['lang_text_domestic_23']      = 'Express Mail Sunday/Holiday';
		$_['lang_text_domestic_25']      = 'Express Mail Flat-Rate Envelope Sunday/Holiday';
		$_['lang_text_domestic_27']      = 'Express Mail Flat-Rate Envelope Hold For Pickup';
		$_['lang_text_domestic_28']      = 'Priority Mail Small Flat-Rate Box';
		$_['lang_text_international_1']  = 'Express Mail International';
		$_['lang_text_international_2']  = 'Priority Mail International';
		$_['lang_text_international_4']  = 'Global Express Guaranteed (Document and Non-document)';
		$_['lang_text_international_5']  = 'Global Express Guaranteed Document used';
		$_['lang_text_international_6']  = 'Global Express Guaranteed Non-Document Rectangular shape';
		$_['lang_text_international_7']  = 'Global Express Guaranteed Non-Document Non-Rectangular';
		$_['lang_text_international_8']  = 'Priority Mail Flat Rate Envelope';
		$_['lang_text_international_9']  = 'Priority Mail Flat Rate Box';
		$_['lang_text_international_10'] = 'Express Mail International Flat Rate Envelope';
		$_['lang_text_international_11'] = 'Priority Mail Flat Rate Large Box';
		$_['lang_text_international_12'] = 'Global Express Guaranteed Envelope';
		$_['lang_text_international_13'] = 'First Class Mail International Letters';
		$_['lang_text_international_14'] = 'First Class Mail International Flats';
		$_['lang_text_international_15'] = 'First Class Mail International Parcels';
		$_['lang_text_international_16'] = 'Priority Mail Flat Rate Small Box';
		$_['lang_text_international_21'] = 'Postcards';
		$_['lang_text_regular']          = 'Regular';
		$_['lang_text_large']            = 'Large';
		$_['lang_text_rectangular']      = 'Rectangular';
		$_['lang_text_non_rectangular']  = 'Non Rectangular';
		$_['lang_text_variable']         = 'Variable';

		// Entry
		$_['lang_entry_user_id']         = 'User ID:';
		$_['lang_entry_postcode']        = 'Zip Code:';
		$_['lang_entry_domestic']        = 'Domestic Services:';
		$_['lang_entry_international']   = 'International Services:';
		$_['lang_entry_size']            = 'Size:';
		$_['lang_entry_container']       = 'Container:';
		$_['lang_entry_machinable']      = 'Machinable:';
		$_['lang_entry_dimension']       = 'Dimensions (L x W x H):<br/><span class="help">Average package dimensions for shipping package. Product dimensions are not used for shipping at this time.</span>';
		$_['lang_entry_display_time']    = 'Display Delivery Time:<br /><span class="help">Do you want to display the shipping time? (e.g. Ships within 3 to 5 days)</span>';
		$_['lang_entry_display_weight']  = 'Display Delivery Weight:<br /><span class="help">Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 Kg\'s)</span>';
		$_['lang_entry_weight_class']    = 'Weight Class:<br /><span class="help">Must be set to Pound.</span>';
		$_['lang_entry_tax']             = 'Tax Class:';
		$_['lang_entry_geo_zone']        = 'Geo Zone:';
		$_['lang_entry_status']          = 'Status:';
		$_['lang_entry_sort_order']      = 'Sort Order:';
		$_['lang_entry_debug']           = 'Debug Mode:<br /><span class="help">Saves send/recv data to the system log</span>';

		// Error
		$_['lang_error_permission']      = 'Warning: You do not have permission to modify United States Postal Service.';
		$_['lang_error_user_id']         = 'User ID Required.';
		$_['lang_error_postcode']        = 'Zip Code Required.';
		$_['lang_error_width']           = 'Width Required.';
		$_['lang_error_length']          = 'Length Required.';
		$_['lang_error_height']          = 'Height Required.';
		$_['lang_error_girth']           = 'Girth Required.';

		return $_;
	}
}
