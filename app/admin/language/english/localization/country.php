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
$_['lang_heading_title']           = 'Country';

// Text
$_['lang_text_success']            = 'Success: You have modified countries.';
$_['lang_text_confirm']            = 'Deleting this country will also delete all zones and geo-zones associated with this country, are you sure you want to do this, this cannot be undone?';

// Column
$_['lang_column_name']             = 'Country Name';
$_['lang_column_iso_code_2']       = 'ISO Code (2)';
$_['lang_column_iso_code_3']       = 'ISO Code (3)';
$_['lang_column_action']           = 'Action';

// Entry
$_['lang_entry_name']              = 'Country Name:';
$_['lang_entry_iso_code_2']        = 'ISO Code (2):';
$_['lang_entry_iso_code_3']        = 'ISO Code (3):';
$_['lang_entry_address_format']    = 'Address Format:<br /><span class="help">
First Name                    = {firstname}<br />
Last Name                     = {lastname}<br />
Company                       = {company}<br />
Address 1                     = {address_1}<br />
Address 2                     = {address_2}<br />
City                          = {city}<br />
Postcode                      = {postcode}<br />
Zone                          = {zone}<br />
Zone Code                     = {zone_code}<br />
Country                       = {country}</span>';
$_['lang_entry_postcode_required'] = 'Postcode Required:';
$_['lang_entry_status']            = 'Status:';

// Error
$_['lang_error_permission']        = 'Warning: You do not have permission to modify countries.';
$_['lang_error_name']              = 'Country Name must be between 3 and 128 characters.';
$_['lang_error_default']           = 'Warning: This country cannot be deleted as it is currently assigned as the default store country.';
$_['lang_error_store']             = 'Warning: This country cannot be deleted as it is currently assigned to %s stores.';
$_['lang_error_address']           = 'Warning: This country cannot be deleted as it is currently assigned to %s address book entries.';
$_['lang_error_affiliate']         = 'Warning: This country cannot be deleted as it is currently assigned to %s affiliates.';
$_['lang_error_zone']              = 'Warning: This country cannot be deleted as it is currently assigned to %s zones.';
$_['lang_error_zone_to_geo_zone']  = 'Warning: This country cannot be deleted as it is currently assigned to %s zones to geo zones.';
