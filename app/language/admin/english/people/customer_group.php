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

namespace Admin\Language\English\People;

class CustomerGroup {
	public static function lang() {
		// Heading
		$_['lang_heading_title']             = 'Customer Group';

		// Text
		$_['lang_text_success']              = 'Success: You have modified customer groups.';

		// Column
		$_['lang_column_name']               = 'Customer Group Name';
		$_['lang_column_sort_order']         = 'Sort Order';
		$_['lang_column_action']             = 'Action';

		// Entry
		$_['lang_entry_name']                = 'Customer Group Name:';
		$_['lang_entry_description']         = 'Description:';
		$_['lang_entry_approval']            = 'Approve New Customers:<br /><span class="help">Customers must be approved by an administrator before they can login.</span>';
		$_['lang_entry_company_id_display']  = 'Display Company No.:<br /><span class="help">Display a company no. field.</span>';
		$_['lang_entry_company_id_required'] = 'Company No. Required:<br /><span class="help">Select which customer groups must enter their company no. for billing addresses before checkout.</span>';
		$_['lang_entry_tax_id_display']      = 'Display Tax ID.:<br /><span class="help">Display a Tax ID. field for billing addresses.</span>';
		$_['lang_entry_tax_id_required']     = 'Tax ID Required:<br /><span class="help">Select which customer groups must enter their Tax ID for billing addresses before checkout.</span>';
		$_['lang_entry_sort_order']          = 'Sort Order:';

		// Error
		$_['lang_error_permission']          = 'Warning: You do not have permission to modify customer groups.';
		$_['lang_error_name']                = 'Customer group name must be between 3 and 32 characters.';
		$_['lang_error_default']             = 'Warning: This customer group cannot be deleted as it is currently assigned as the default store customer group.';
		$_['lang_error_store']               = 'Warning: This customer group cannot be deleted as it is currently assigned to %s stores.';
		$_['lang_error_customer']            = 'Warning: This customer group cannot be deleted as it is currently assigned to %s customers.';

		return $_;
	}
}
