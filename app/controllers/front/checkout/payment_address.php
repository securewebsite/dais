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

namespace App\Controllers\Front\Checkout;

use App\Controllers\Controller;

class PaymentAddress extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        if (isset(Session::p()->data['payment_address_id'])) {
            $data['address_id'] = Session::p()->data['payment_address_id'];
        } else {
            $data['address_id'] = Customer::getAddressId();
        }
        
        $data['addresses'] = array();
        
        Theme::model('account/address');
        
        $data['addresses'] = AccountAddress::getAddresses();
        
        Theme::model('account/customer_group');
        
        $customer_group_info = AccountCustomerGroup::getCustomerGroup(Customer::getGroupId());
        
        if ($customer_group_info) {
            $data['company_id_display'] = $customer_group_info['company_id_display'];
        } else {
            $data['company_id_display'] = '';
        }
        
        if ($customer_group_info) {
            $data['company_id_required'] = $customer_group_info['company_id_required'];
        } else {
            $data['company_id_required'] = '';
        }
        
        if ($customer_group_info) {
            $data['tax_id_display'] = $customer_group_info['tax_id_display'];
        } else {
            $data['tax_id_display'] = '';
        }
        
        if ($customer_group_info) {
            $data['tax_id_required'] = $customer_group_info['tax_id_required'];
        } else {
            $data['tax_id_required'] = '';
        }
        
        if (isset(Session::p()->data['payment_country_id'])) {
            $data['country_id'] = Session::p()->data['payment_country_id'];
        } else {
            $data['country_id'] = Config::get('config_country_id');
        }
        
        if (isset(Session::p()->data['payment_zone_id'])) {
            $data['zone_id'] = Session::p()->data['payment_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        Theme::loadjs('javascript/checkout/payment_address', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::render('checkout/payment_address', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if (!Customer::isLogged()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!\Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!\Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $json['redirect'] = Url::link('checkout/cart');
        }
        
        // Validate minimum quantity requirments.
        $products = \Cart::getProducts();
        
        foreach ($products as $product) {
            $product_total = 0;
            
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total+= $product_2['quantity'];
                }
            }
            
            if ($product['minimum'] > $product_total) {
                $json['redirect'] = Url::link('checkout/cart');
                
                break;
            }
        }
        
        if (!$json) {
            if (isset(Request::p()->post['payment_address']) && Request::p()->post['payment_address'] == 'existing') {
                Theme::model('account/address');
                Theme::model('account/customer_group');
                
                if (empty(Request::p()->post['address_id'])) {
                    $json['error']['warning'] = Lang::get('lang_error_address');
                } elseif (!in_array(Request::p()->post['address_id'], array_keys(AccountAddress::getAddresses()))) {
                    $json['error']['warning'] = Lang::get('lang_error_address');
                } else {
                    
                    // Default Payment Address
                    Theme::model('account/address');
                    
                    $address_info = AccountAddress::getAddress(Request::p()->post['address_id']);
                    
                    if ($address_info) {
                        
                        $customer_group_info = AccountCustomerGroup::getCustomerGroup(Customer::getGroupId());
                        
                        // Company ID
                        if ($customer_group_info['company_id_display'] && $customer_group_info['company_id_required'] && !$address_info['company_id']) {
                            $json['error']['warning'] = Lang::get('lang_error_company_id');
                        }
                        
                        // Tax ID
                        if ($customer_group_info['tax_id_display'] && $customer_group_info['tax_id_required'] && !$address_info['tax_id']) {
                            $json['error']['warning'] = Lang::get('lang_error_tax_id');
                        }
                    }
                }
                
                if (!$json) {
                    Session::p()->data['payment_address_id'] = Request::p()->post['address_id'];
                    
                    if ($address_info) {
                        Session::p()->data['payment_country_id'] = $address_info['country_id'];
                        Session::p()->data['payment_zone_id'] = $address_info['zone_id'];
                    } else {
                        unset(Session::p()->data['payment_country_id']);
                        unset(Session::p()->data['payment_zone_id']);
                    }
                }
            } else {
                if ((Encode::strlen(Request::p()->post['firstname']) < 1) || (Encode::strlen(Request::p()->post['firstname']) > 32)) {
                    $json['error']['firstname'] = Lang::get('lang_error_firstname');
                }
                
                if ((Encode::strlen(Request::p()->post['lastname']) < 1) || (Encode::strlen(Request::p()->post['lastname']) > 32)) {
                    $json['error']['lastname'] = Lang::get('lang_error_lastname');
                }
                
                // Customer Group
                Theme::model('account/customer_group');
                
                $customer_group_info = AccountCustomerGroup::getCustomerGroup(Customer::getGroupId());
                
                if ($customer_group_info) {
                    
                    // Company ID
                    if ($customer_group_info['company_id_display'] && $customer_group_info['company_id_required'] && empty(Request::p()->post['company_id'])) {
                        $json['error']['company_id'] = Lang::get('lang_error_company_id');
                    }
                    
                    // Tax ID
                    if ($customer_group_info['tax_id_display'] && $customer_group_info['tax_id_required'] && empty(Request::p()->post['tax_id'])) {
                        $json['error']['tax_id'] = Lang::get('lang_error_tax_id');
                    }
                }
                
                if ((Encode::strlen(Request::p()->post['address_1']) < 3) || (Encode::strlen(Request::p()->post['address_1']) > 128)) {
                    $json['error']['address_1'] = Lang::get('lang_error_address_1');
                }
                
                if ((Encode::strlen(Request::p()->post['city']) < 2) || (Encode::strlen(Request::p()->post['city']) > 32)) {
                    $json['error']['city'] = Lang::get('lang_error_city');
                }
                
                Theme::model('locale/country');
                
                $country_info = LocaleCountry::getCountry(Request::p()->post['country_id']);
                
                if ($country_info) {
                    if ($country_info['postcode_required'] && (Encode::strlen(Request::p()->post['postcode']) < 2) || (Encode::strlen(Request::p()->post['postcode']) > 10)) {
                        $json['error']['postcode'] = Lang::get('lang_error_postcode');
                    }
                    
                    if (Config::get('config_vat') && !empty(Request::p()->post['tax_id']) && ($this->vat->validate($country_info['iso_code_2'], Request::p()->post['tax_id']) == 'invalid')) {
                        $json['error']['tax_id'] = Lang::get('lang_error_vat');
                    }
                }
                
                if (Request::p()->post['country_id'] == '') {
                    $json['error']['country'] = Lang::get('lang_error_country');
                }
                
                if (!isset(Request::p()->post['zone_id']) || Request::p()->post['zone_id'] == '') {
                    $json['error']['zone'] = Lang::get('lang_error_zone');
                }
                
                if (!$json) {
                    
                    // Default Payment Address
                    Theme::model('account/address');
                    
                    Session::p()->data['payment_address_id'] = AccountAddress::addAddress(Request::post());
                    Session::p()->data['payment_country_id'] = Request::p()->post['country_id'];
                    Session::p()->data['payment_zone_id'] = Request::p()->post['zone_id'];
                }
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
