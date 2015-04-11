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
$_['lang_heading_title']        = 'Currency';

// Text
$_['lang_text_success']         = 'Success: You have modified currencies.';

// Column
$_['lang_column_title']         = 'Currency Title';
$_['lang_column_code']          = 'Code';
$_['lang_column_value']         = 'Value';
$_['lang_column_date_modified'] = 'Last Updated';
$_['lang_column_action']        = 'Action';

// Entry
$_['lang_entry_title']          = 'Currency Title:';
$_['lang_entry_code']           = 'Code:<br /><span class="help">Do not change if this is your default currency. Must be valid <a href="http://www.xe.com/iso4217.php" target="_blank">ISO code</a>.</span>';
$_['lang_entry_value']          = 'Value:<br /><span class="help">Set to 1.00000 if this is your default currency.</span>';
$_['lang_entry_symbol_left']    = 'Currency Symbol Left:';
$_['lang_entry_symbol_right']   = 'Currency Symbol Right:';
$_['lang_entry_decimal_place']  = 'Decimal Places:';
$_['lang_entry_status']         = 'Status:';

// Error
$_['lang_error_permission']     = 'Warning: You do not have permission to modify currencies.';
$_['lang_error_title']          = 'Currency Title must be between 3 and 32 characters.';
$_['lang_error_code']           = 'Currency Code must contain 3 characters.';
$_['lang_error_default']        = 'Warning: This currency cannot be deleted as it is currently assigned as the default store currency.';
$_['lang_error_store']          = 'Warning: This currency cannot be deleted as it is currently assigned to %s stores.';
$_['lang_error_order']          = 'Warning: This currency cannot be deleted as it is currently assigned to %s orders.';
