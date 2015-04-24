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
$_['lang_heading_title']          = 'Products';

// Text
$_['lang_text_success']           = 'Success: You have modified products.';
$_['lang_text_plus']              = '+';
$_['lang_text_minus']             = '-';
$_['lang_text_default']           = 'Default';
$_['lang_text_image_manager']     = 'Image Manager';
$_['lang_text_browse']            = 'Browse';
$_['lang_text_clear']             = 'Clear';
$_['lang_text_option']            = 'Option';
$_['lang_text_option_value']      = 'Option Value';
$_['lang_text_percent']           = 'Percentage';
$_['lang_text_amount']            = 'Fixed Amount';
$_['lang_text_build']             = 'Build Slug';
$_['lang_text_recurring_help']    = 'Recurring amounts are calculated by frequency and cycles. <br />For example if you use a frequency of "week" and a cycle of "2", then the user will be billed every 2 weeks. <br />The length is the number of times the user will make a payment, set this to 0 for recurring payments until they\'re are cancelled.';
$_['lang_text_recurring_title']   = 'Recurring payments';
$_['lang_text_recurring_trial']   = 'Trial period';
$_['lang_text_length_day']        = 'Day';
$_['lang_text_length_week']       = 'Week';
$_['lang_text_length_month']      = 'Month';
$_['lang_text_length_month_semi'] = 'Semi Month';
$_['lang_text_length_year']       = 'Year';

// Column
$_['lang_column_name']            = 'Product Name';
$_['lang_column_model']           = 'Model';
$_['lang_column_image']           = 'Image';
$_['lang_column_price']           = 'Price';
$_['lang_column_quantity']        = 'Quantity';
$_['lang_column_status']          = 'Status';
$_['lang_column_action']          = 'Action';

// Entry
$_['lang_entry_name']             = 'Product Name:';
$_['lang_entry_meta_keyword']     = 'Meta Tag Keywords:';
$_['lang_entry_meta_description'] = 'Meta Tag Description:';
$_['lang_entry_description']      = 'Description:';
$_['lang_entry_store']            = 'Stores:';
$_['lang_entry_slug']             = 'URL Slug:<br /><span class="help">Do not use spaces, instead replace spaces with - and make sure the slug is globally unique.</span>';
$_['lang_entry_model']            = 'Model:';
$_['lang_entry_sku']              = 'SKU:<br/><span class="help">Stock Keeping Unit</span>';
$_['lang_entry_upc']              = 'UPC:<br/><span class="help">Universal Product Code</span>';
$_['lang_entry_ean']              = 'EAN:<br/><span class="help">European Article Number</span>';
$_['lang_entry_jan']              = 'JAN:<br/><span class="help">Japanese Article Number</span>';
$_['lang_entry_isbn']             = 'ISBN:<br/><span class="help">International Standard Book Number</span>';
$_['lang_entry_mpn']              = 'MPN:<br/><span class="help">Manufacturer Part Number</span>';
$_['lang_entry_location']         = 'Location:';
$_['lang_entry_shipping']         = 'Requires Shipping:';
$_['lang_entry_manufacturer']     = 'Manufacturer:<br /><span class="help">(Autocomplete)</span>';
$_['lang_entry_date_available']   = 'Date Available:';
$_['lang_entry_quantity']         = 'Quantity:';
$_['lang_entry_minimum']          = 'Minimum Quantity:<br/><span class="help">Force a minimum ordered amount</span>';
$_['lang_entry_stock_status']     = 'Out Of Stock Status:<br/><span class="help">Status shown when a product is out of stock</span>';
$_['lang_entry_price']            = 'Price:';
$_['lang_entry_tax_class']        = 'Tax Class:';
$_['lang_entry_points']           = 'Points:<br/><span class="help">Number of points needed to buy this item. If you don\'t want this product to be purchased with points leave as 0.</span>';
$_['lang_entry_option_points']    = 'Points:';
$_['lang_entry_subtract']         = 'Subtract Stock:';
$_['lang_entry_weight_class']     = 'Weight Class:';
$_['lang_entry_weight']           = 'Weight:';
$_['lang_entry_length']           = 'Length Class:';
$_['lang_entry_dimension']        = 'Dimensions (L x W x H):';
$_['lang_entry_image']            = 'Image:';
$_['lang_entry_customer_group']   = 'Customer Group:';
$_['lang_entry_date_start']       = 'Date Start:';
$_['lang_entry_date_end']         = 'Date End:';
$_['lang_entry_priority']         = 'Priority:';
$_['lang_entry_attribute']        = 'Attribute:';
$_['lang_entry_attribute_group']  = 'Attribute Group:';
$_['lang_entry_text']             = 'Text:';
$_['lang_entry_option']           = 'Option:';
$_['lang_entry_option_value']     = 'Option Value:';
$_['lang_entry_required']         = 'Required:';
$_['lang_entry_status']           = 'Status:';
$_['lang_entry_sort_order']       = 'Sort Order:';
$_['lang_entry_category']         = 'Categories:<br /><span class="help">(autocomplete)</span>';
$_['lang_entry_filter']           = 'Filters:<br /><span class="help">(autocomplete)</span>';
$_['lang_entry_download']         = 'Downloads:<br /><span class="help">(autocomplete)</span>';
$_['lang_entry_related']          = 'Related Products:<br /><span class="help">(autocomplete)</span>';
$_['lang_entry_tag']              = 'Product Tags:<br /><span class="help">comma separated</span>';
$_['lang_entry_recurring']        = 'Recurring Profile';
$_['lang_entry_reward']           = 'Reward Points:';
$_['lang_entry_layout']           = 'Layout Override:';
$_['lang_entry_visibility']       = 'Visibility:<br><span class="help">Select the lowest customer group that\'s able to view this product. Any group with a lower ID will not be able to see the product.</span>';
$_['lang_entry_one_customer']     = 'Single Customer:<br><span class="help">(autocomplete)<br>Set this product for a single customer. No other customers will be able to see this product and the customer must be logged in.</span>';
$_['lang_entry_recurring']        = 'Recurring Billing:';
$_['lang_entry_recurring_price']  = 'Recurring price:';
$_['lang_entry_recurring_freq']   = 'Recurring frequency:';
$_['lang_entry_recurring_cycle']  = 'Recurring cycles:<span class="help">How often it\'s billed, must be 1 or more</span>';
$_['lang_entry_recurring_length'] = 'Recurring length:<span class="help">0 = until cancelled</span>';
$_['lang_entry_trial']            = 'Trial period:';
$_['lang_entry_trial_price']      = 'Trial recurring price:';
$_['lang_entry_trial_freq']       = 'Trial recurring frequency:';
$_['lang_entry_trial_cycle']      = 'Trial recurring cycles:<span class="help">How often it\'s billed, must be 1 or more</span>';
$_['lang_entry_trial_length']     = 'Trial recurring length:';

// Error
$_['lang_error_warning']          = 'Warning: Please check the form carefully for errors.';
$_['lang_error_permission']       = 'Warning: You do not have permission to modify products.';
$_['lang_error_name']             = 'Product Name must be greater than 3 and less than 255 characters.';
$_['lang_error_model']            = 'Product Model must be greater than 3 and less than 64 characters.';
$_['lang_error_event']            = 'Warning: This product cannot be deleted as it is currently being used by %s event(s).';
$_['lang_error_slug']             = 'Warning: Slug is required for products.';
$_['lang_error_slug_found']       = 'ERROR: The slug %s is already in use, please set a different one in the input field.';
$_['lang_error_name_first']       = 'ERROR: Please enter a name for your product before attempting to build a slug.';
