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
$_['lang_heading_title']    = 'Order Status';

// Text
$_['lang_text_success']     = 'Success: You have modified order statuses.';

// Column
$_['lang_column_name']      = 'Order Status Name';
$_['lang_column_action']    = 'Action';

// Entry
$_['lang_entry_name']       = 'Order Status Name:';

// Error
$_['lang_error_permission'] = 'Warning: You do not have permission to modify order statues.';
$_['lang_error_name']       = 'Order Status Name must be between 3 and 32 characters.';
$_['lang_error_default']    = 'Warning: This order status cannot be deleted as it is currently assigned as the default store order status.';
$_['lang_error_download']   = 'Warning: This order status cannot be deleted as it is currently assigned as the default download status.';
$_['lang_error_store']      = 'Warning: This order status cannot be deleted as it is currently assigned to %s stores.';
$_['lang_error_order']      = 'Warning: This order status cannot be deleted as it is currently assigned to %s orders.';
