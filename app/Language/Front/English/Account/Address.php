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

namespace App\Language\Front\English\Account;

class Address {
	public static function lang() {
		// Heading
		$_['lang_heading_title']     = 'Address Book';

		// Text
		$_['lang_text_account']      = 'Dashboard';
		$_['lang_text_address_book'] = 'Address Book Entries';
		$_['lang_text_edit_address'] = 'Edit Address';
		$_['lang_text_insert']       = 'Your address has been successfully inserted';
		$_['lang_text_update']       = 'Your address has been successfully updated';
		$_['lang_text_delete']       = 'Your address has been successfully deleted';

		// Entry
		$_['lang_entry_firstname']   = 'First Name';
		$_['lang_entry_lastname']    = 'Last Name';
		$_['lang_entry_company']     = 'Company';
		$_['lang_entry_company_id']  = 'Company ID';
		$_['lang_entry_tax_id']      = 'Tax ID';
		$_['lang_entry_address_1']   = 'Address 1';
		$_['lang_entry_address_2']   = 'Address 2';
		$_['lang_entry_postcode']    = 'Post Code';
		$_['lang_entry_city']        = 'City';
		$_['lang_entry_country']     = 'Country';
		$_['lang_entry_zone']        = 'Region / State';
		$_['lang_entry_default']     = 'Default Address';

		// Error
		$_['lang_error_delete']      = 'Warning: You must have at least one address.';
		$_['lang_error_default']     = 'Warning: You can not delete your default address.';
		$_['lang_error_firstname']   = 'First Name must be between 1 and 32 characters.';
		$_['lang_error_lastname']    = 'Last Name must be between 1 and 32 characters.';
		$_['lang_error_vat']         = 'VAT number is invalid.';
		$_['lang_error_address_1']   = 'Address must be between 3 and 128 characters.';
		$_['lang_error_postcode']    = 'Postcode must be between 2 and 10 characters.';
		$_['lang_error_city']        = 'City must be between 2 and 128 characters.';
		$_['lang_error_country']     = 'Please select a country.';
		$_['lang_error_zone']        = 'Please select a region / state.';

		return $_;
	}
}
