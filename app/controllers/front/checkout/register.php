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

class Register extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        $data['entry_newsletter'] = sprintf(Lang::get('lang_entry_newsletter'), Config::get('config_name'));
        
        $data['customer_groups'] = array();
        
        if (is_array(Config::get('config_customer_group_display'))) {
            Theme::model('account/customer_group');
            
            $customer_groups = AccountCustomerGroup::getCustomerGroups();
            
            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], Config::get('config_customer_group_display'))) {
                    $data['customer_groups'][] = $customer_group;
                }
            }
        }
        
        $data['customer_group_id'] = Config::get('config_customer_group_id');
        
        if (isset(Session::p()->data['shipping_postcode'])) {
            $data['postcode'] = Session::p()->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset(Session::p()->data['shipping_country_id'])) {
            $data['country_id'] = Session::p()->data['shipping_country_id'];
        } else {
            $data['country_id'] = Config::get('config_country_id');
        }
        
        if (isset(Session::p()->data['shipping_zone_id'])) {
            $data['zone_id'] = Session::p()->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        if (Config::get('config_account_id')) {
            Theme::model('content/page');
            
            $page_info = ContentPage::getPage(Config::get('config_account_id'));
            
            if ($page_info) {
                $data['text_agree'] = sprintf(Lang::get('lang_text_agree'), Url::link('content/page/info', 'page_id=' . Config::get('config_account_id'), 'SSL'), $page_info['title'], $page_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }
        
        $data['shipping_required'] = \Cart::hasShipping();
        
        Theme::loadjs('javascript/checkout/register', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::make('checkout/register', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        Theme::model('account/customer');
        
        $json = array();
        
        // Validate if customer is already logged out.
        if (Customer::isLogged()) {
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
            if ((Encode::strlen(Request::p()->post['username']) < 3) || (Encode::strlen(Request::p()->post['username']) > 16)) {
                $json['error']['username'] = Lang::get('lang_error_username');
            }
            
            if ((Encode::strlen(Request::p()->post['firstname']) < 1) || (Encode::strlen(Request::p()->post['firstname']) > 32)) {
                $json['error']['firstname'] = Lang::get('lang_error_firstname');
            }
            
            if ((Encode::strlen(Request::p()->post['lastname']) < 1) || (Encode::strlen(Request::p()->post['lastname']) > 32)) {
                $json['error']['lastname'] = Lang::get('lang_error_lastname');
            }
            
            if ((Encode::strlen(Request::p()->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', Request::p()->post['email'])) {
                $json['error']['email'] = Lang::get('lang_error_email');
            }
            
            if (AccountCustomer::getTotalCustomersByUsername(Request::p()->post['username'])) {
                $json['error']['warning'] = Lang::get('lang_error_uexists');
            }
            
            if (AccountCustomer::getTotalCustomersByEmail(Request::p()->post['email'])) {
                $json['error']['warning'] = Lang::get('lang_error_exists');
            }
            
            if ((Encode::strlen(Request::p()->post['telephone']) < 3) || (Encode::strlen(Request::p()->post['telephone']) > 32)) {
                $json['error']['telephone'] = Lang::get('lang_error_telephone');
            }
            
            // Customer Group
            Theme::model('account/customer_group');
            
            if (isset(Request::p()->post['customer_group_id']) && is_array(Config::get('config_customer_group_display')) && in_array(Request::p()->post['customer_group_id'], Config::get('config_customer_group_display'))) {
                $customer_group_id = Request::p()->post['customer_group_id'];
            } else {
                $customer_group_id = Config::get('config_customer_group_id');
            }
            
            $customer_group = AccountCustomerGroup::getCustomerGroup($customer_group_id);
            
            if ($customer_group) {
                
                // Company ID
                if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty(Request::p()->post['company_id'])) {
                    $json['error']['company_id'] = Lang::get('lang_error_company_id');
                }
                
                // Tax ID
                if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty(Request::p()->post['tax_id'])) {
                    $json['error']['tax_id'] = Lang::get('lang_error_tax_id');
                }
            }
            
            if ((Encode::strlen(Request::p()->post['address_1']) < 3) || (Encode::strlen(Request::p()->post['address_1']) > 128)) {
                $json['error']['address_1'] = Lang::get('lang_error_address_1');
            }
            
            if ((Encode::strlen(Request::p()->post['city']) < 2) || (Encode::strlen(Request::p()->post['city']) > 128)) {
                $json['error']['city'] = Lang::get('lang_error_city');
            }
            
            Theme::model('locale/country');
            
            $country_info = LocaleCountry::getCountry(Request::p()->post['country_id']);
            
            if ($country_info) {
                if ($country_info['postcode_required'] && (Encode::strlen(Request::p()->post['postcode']) < 2) || (Encode::strlen(Request::p()->post['postcode']) > 10)) {
                    $json['error']['postcode'] = Lang::get('lang_error_postcode');
                }
                
                if (Config::get('config_vat') && Request::p()->post['tax_id'] && ($this->vat->validate($country_info['iso_code_2'], Request::p()->post['tax_id']) == 'invalid')) {
                    $json['error']['tax_id'] = Lang::get('lang_error_vat');
                }
            }
            
            if (Request::p()->post['country_id'] == '') {
                $json['error']['country'] = Lang::get('lang_error_country');
            }
            
            if (!isset(Request::p()->post['zone_id']) || Request::p()->post['zone_id'] == '') {
                $json['error']['zone'] = Lang::get('lang_error_zone');
            }
            
            if ((Encode::strlen(Request::p()->post['password']) < 4) || (Encode::strlen(Request::p()->post['password']) > 20)) {
                $json['error']['password'] = Lang::get('lang_error_password');
            }
            
            if (Request::p()->post['confirm'] != Request::p()->post['password']) {
                $json['error']['confirm'] = Lang::get('lang_error_confirm');
            }
            
            if (Config::get('config_account_id')) {
                Theme::model('content/page');
                
                $page_info = ContentPage::getPage(Config::get('config_account_id'));
                
                if ($page_info && !isset(Request::p()->post['agree'])) {
                    $json['error']['warning'] = sprintf(Lang::get('lang_error_agree'), $page_info['title']);
                }
            }
        }
        
        if (!$json) {
            AccountCustomer::addCustomer(Request::post());
            
            Session::p()->data['account'] = 'register';
            
            if ($customer_group && !$customer_group['approval']) {
                Customer::login(Request::p()->post['email'], Request::p()->post['password']);
                
                Session::p()->data['payment_address_id'] = Customer::getAddressId();
                Session::p()->data['payment_country_id'] = Request::p()->post['country_id'];
                Session::p()->data['payment_zone_id']    = Request::p()->post['zone_id'];
                
                if (!empty(Request::p()->post['shipping_address'])) {
                    Session::p()->data['shipping_address_id'] = Customer::getAddressId();
                    Session::p()->data['shipping_country_id'] = Request::p()->post['country_id'];
                    Session::p()->data['shipping_zone_id']    = Request::p()->post['zone_id'];
                    Session::p()->data['shipping_postcode']   = Request::p()->post['postcode'];
                }
            } else {
                $json['redirect'] = Url::link('account/success');
            }
            
            unset(Session::p()->data['guest']);
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
            unset(Session::p()->data['payment_method']);
            unset(Session::p()->data['payment_methods']);
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
