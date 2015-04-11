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

// Heading
$_['lang_heading_title']                = 'UPS';

// Text
$_['lang_text_shipping']                = 'Shipping';
$_['lang_text_success']                 = 'Success: You have modified UPS shipping.';
$_['lang_text_regular_daily_pickup']    = 'Regular Daily Pick Up';
$_['lang_text_daily_pickup']            = 'Daily Pick Up';
$_['lang_text_customer_counter']        = 'Customer Counter';
$_['lang_text_one_time_pickup']         = 'One Time Pick Up';
$_['lang_text_on_call_air_pickup']      = 'On Call Air Pick Up';
$_['lang_text_letter_center']           = 'Letter Center';
$_['lang_text_air_service_center']      = 'Air Service Center';
$_['lang_text_suggested_retail_rates']  = 'Suggested Retail Rates (UPS Store)';
$_['lang_text_package']                 = 'Package';
$_['lang_text_ups_letter']              = 'UPS Letter';
$_['lang_text_ups_tube']                = 'UPS Tube';
$_['lang_text_ups_pak']                 = 'UPS Pak';
$_['lang_text_ups_express_box']         = 'UPS Express Box';
$_['lang_text_ups_25kg_box']            = 'UPS 25kg box';
$_['lang_text_ups_10kg_box']            = 'UPS 10kg box';
$_['lang_text_us']                      = 'US Origin';
$_['lang_text_ca']                      = 'Canada Origin';
$_['lang_text_eu']                      = 'European Union Origin';
$_['lang_text_pr']                      = 'Puerto Rico Origin';
$_['lang_text_mx']                      = 'Mexico Origin';
$_['lang_text_other']                   = 'All Other Origins';
$_['lang_text_test']                    = 'Test';
$_['lang_text_production']              = 'Production';
$_['lang_text_residential']             = 'Residential';
$_['lang_text_commercial']              = 'Commercial';
$_['lang_text_next_day_air']            = 'UPS Next Day Air';
$_['lang_text_2nd_day_air']             = 'UPS Second Day Air';
$_['lang_text_ground']                  = 'UPS Ground';
$_['lang_text_3_day_select']            = 'UPS Three-Day Select';
$_['lang_text_next_day_air_saver']      = 'UPS Next Day Air Saver';
$_['lang_text_next_day_air_early_am']   = 'UPS Next Day Air Early A.M.';
$_['lang_text_2nd_day_air_am']          = 'UPS Second Day Air A.M.';
$_['lang_text_saver']                   = 'UPS Saver';
$_['lang_text_worldwide_express']       = 'UPS Worldwide Express';
$_['lang_text_worldwide_expedited']     = 'UPS Worldwide Expedited';
$_['lang_text_standard']                = 'UPS Standard';
$_['lang_text_worldwide_express_plus']  = 'UPS Worldwide Express Plus';
$_['lang_text_express']                 = 'UPS Express';
$_['lang_text_expedited']               = 'UPS Expedited';
$_['lang_text_express_early_am']        = 'UPS Express Early A.M.';
$_['lang_text_express_plus']            = 'UPS Express Plus';
$_['lang_text_today_standard']          = 'UPS Today Standard';
$_['lang_text_today_dedicated_courier'] = 'UPS Today Dedicated Courier';
$_['lang_text_today_intercity']         = 'UPS Today Intercity';
$_['lang_text_today_express']           = 'UPS Today Express';
$_['lang_text_today_express_saver']     = 'UPS Today Express Saver';

// Entry
$_['lang_entry_key']                    = 'Access Key:<span class="help">Enter the XML rates access key assigned to you by UPS.</span>';
$_['lang_entry_username']               = 'Username:<span class="help">Enter your UPS services account username.</span>';
$_['lang_entry_password']               = 'Password:<span class="help">Enter your UPS services account password.</span>';
$_['lang_entry_pickup']                 = 'Pick Up Method:<span class="help">How do you give packages to UPS (only used when origin is US)?</span>';
$_['lang_entry_packaging']              = 'Packaging Type:<span class="help">What kind of packaging do you use?</span>';
$_['lang_entry_classification']         = 'Customer Classification Code:<span class="help">01 - If you are billing to a UPS account and have a daily UPS pick up, 03 - If you do not have a UPS account or you are billing to a UPS account but do not have a daily pickup, 04 - If you are shipping from a retail outlet (only used when origin is US)</span>';
$_['lang_entry_origin']                 = 'Shipping Origin Code:<span class="help">What origin point should be used (this setting affects only what UPS product names are shown to the user)</span>';
$_['lang_entry_city']                   = 'Origin City:<span class="help">Enter the name of the origin city.</span>';
$_['lang_entry_state']                  = 'Origin State/Province:<span class="help">Enter the two-letter code for your origin state/province.</span>';
$_['lang_entry_country']                = 'Origin Country:<span class="help">Enter the two-letter code for your origin country.</span>';
$_['lang_entry_postcode']               = 'Origin Zip/Postal Code:<span class="help">Enter your origin zip/postalcode.</span>';
$_['lang_entry_test']                   = 'Test Mode:<span class="help">Use this widget in Test (YES) or Production mode (NO)?</span>';
$_['lang_entry_quote_type']             = 'Quote Type:<span class="help">Quote for Residential or Commercial Delivery.</span>';
$_['lang_entry_service']                = 'Services:<span class="help">Select the UPS services to be offered.</span>';
$_['lang_entry_insurance']              = 'Enable Insurance:<span class="help">Enables insurance with product total as the value</span>';
$_['lang_entry_display_weight']         = 'Display Delivery Weight:<br /><span class="help">Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 Kg\'s)</span>';
$_['lang_entry_weight_class']           = 'Weight Class:<span class="help">Set to kilograms or pounds.</span>';
$_['lang_entry_length_class']           = 'Length Class:<span class="help">Set to centimeters or inches.</span>';
$_['lang_entry_dimension']              = 'Dimensions (L x W x H):<br /><span class="help">This is assumed to be your average packing box size. Individual item dimensions are not supported at this time so you must enter average dimensions like 5x5x5.</span>';
$_['lang_entry_tax_class']              = 'Tax Class:';
$_['lang_entry_geo_zone']               = 'Geo Zone:';
$_['lang_entry_status']                 = 'Status:';
$_['lang_entry_sort_order']             = 'Sort Order:';
$_['lang_entry_debug']                  = 'Debug Mode:<br /><span class="help">Saves send/recv data to the system log</span>';

// Error
$_['lang_error_permission']             = 'Warning: You do not have permission to modify UPS (US) shipping.';
$_['lang_error_key']                    = 'Access Key Required.';
$_['lang_error_username']               = 'Username Required.';
$_['lang_error_password']               = 'Password Required.';
$_['lang_error_city']                   = 'Origin City.';
$_['lang_error_state']                  = 'Origin State/Province Required.';
$_['lang_error_country']                = 'Origin Country Required.';
$_['lang_error_dimension']              = 'Average Dimensions Required.';
