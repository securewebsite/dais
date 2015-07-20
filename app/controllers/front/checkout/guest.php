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

class Guest extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        if (isset(Session::p()->data['guest']['firstname'])) {
            $data['firstname'] = Session::p()->data['guest']['firstname'];
        } else {
            $data['firstname'] = '';
        }
        
        if (isset(Session::p()->data['guest']['lastname'])) {
            $data['lastname'] = Session::p()->data['guest']['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset(Session::p()->data['guest']['email'])) {
            $data['email'] = Session::p()->data['guest']['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset(Session::p()->data['guest']['telephone'])) {
            $data['telephone'] = Session::p()->data['guest']['telephone'];
        } else {
            $data['telephone'] = '';
        }
        
        if (isset(Session::p()->data['guest']['payment']['company'])) {
            $data['company'] = Session::p()->data['guest']['payment']['company'];
        } else {
            $data['company'] = '';
        }
        
        Theme::model('account/customer_group');
        
        $data['customer_groups'] = array();
        
        if (is_array(Config::get('config_customer_group_display'))) {
            $customer_groups = AccountCustomerGroup::getCustomerGroups();
            
            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], Config::get('config_customer_group_display'))) {
                    $data['customer_groups'][] = $customer_group;
                }
            }
        }
        
        if (isset(Session::p()->data['guest']['customer_group_id'])) {
            $data['customer_group_id'] = Session::p()->data['guest']['customer_group_id'];
        } else {
            $data['customer_group_id'] = Config::get('config_default_visibility');
        }
        
        // Company ID
        if (isset(Session::p()->data['guest']['payment']['company_id'])) {
            $data['company_id'] = Session::p()->data['guest']['payment']['company_id'];
        } else {
            $data['company_id'] = '';
        }
        
        // Tax ID
        if (isset(Session::p()->data['guest']['payment']['tax_id'])) {
            $data['tax_id'] = Session::p()->data['guest']['payment']['tax_id'];
        } else {
            $data['tax_id'] = '';
        }
        
        if (isset(Session::p()->data['guest']['payment']['address_1'])) {
            $data['address_1'] = Session::p()->data['guest']['payment']['address_1'];
        } else {
            $data['address_1'] = '';
        }
        
        if (isset(Session::p()->data['guest']['payment']['address_2'])) {
            $data['address_2'] = Session::p()->data['guest']['payment']['address_2'];
        } else {
            $data['address_2'] = '';
        }
        
        if (isset(Session::p()->data['guest']['payment']['postcode'])) {
            $data['postcode'] = Session::p()->data['guest']['payment']['postcode'];
        } elseif (isset(Session::p()->data['shipping_postcode'])) {
            $data['postcode'] = Session::p()->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset(Session::p()->data['guest']['payment']['city'])) {
            $data['city'] = Session::p()->data['guest']['payment']['city'];
        } else {
            $data['city'] = '';
        }
        
        if (isset(Session::p()->data['guest']['payment']['country_id'])) {
            $data['country_id'] = Session::p()->data['guest']['payment']['country_id'];
        } elseif (isset(Session::p()->data['shipping_country_id'])) {
            $data['country_id'] = Session::p()->data['shipping_country_id'];
        } else {
            $data['country_id'] = Config::get('config_country_id');
        }
        
        if (isset(Session::p()->data['guest']['payment']['zone_id'])) {
            $data['zone_id'] = Session::p()->data['guest']['payment']['zone_id'];
        } elseif (isset(Session::p()->data['shipping_zone_id'])) {
            $data['zone_id'] = Session::p()->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        $data['shipping_required'] = \Cart::hasShipping();
        
        if (isset(Session::p()->data['guest']['shipping_address'])) {
            $data['shipping_address'] = Session::p()->data['guest']['shipping_address'];
        } else {
            $data['shipping_address'] = true;
        }
        
        Theme::loadjs('javascript/checkout/guest', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::make('checkout/guest', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if (Customer::isLogged()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!\Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!\Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $json['redirect'] = Url::link('checkout/cart');
        }
        
        // Check if guest checkout is avaliable.
        if (!Config::get('config_guest_checkout') || Config::get('config_customer_price') || \Cart::hasDownload()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        if (!$json) {
            if ((Encode::strlen(Request::p()->post['firstname']) < 1) || (Encode::strlen(Request::p()->post['firstname']) > 32)) {
                $json['error']['firstname'] = Lang::get('lang_error_firstname');
            }
            
            if ((Encode::strlen(Request::p()->post['lastname']) < 1) || (Encode::strlen(Request::p()->post['lastname']) > 32)) {
                $json['error']['lastname'] = Lang::get('lang_error_lastname');
            }
            
            if ((Encode::strlen(Request::p()->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', Request::p()->post['email'])) {
                $json['error']['email'] = Lang::get('lang_error_email');
            }
            
            if ((Encode::strlen(Request::p()->post['telephone']) < 3) || (Encode::strlen(Request::p()->post['telephone']) > 32)) {
                $json['error']['telephone'] = Lang::get('lang_error_telephone');
            }
            
            // Customer Group
            Theme::model('account/customer_group');
            
            if (isset(Request::p()->post['customer_group_id']) && is_array(Config::get('config_customer_group_display')) && in_array(Request::p()->post['customer_group_id'], Config::get('config_customer_group_display'))) {
                $customer_group_id = (Request::p()->post['customer_group_id'] == Config::get('config_default_visibility')) ? Request::p()->post['customer_group_id'] : Config::get('config_default_visibility');
            } else {
                $customer_group_id = Config::get('config_default_visibility');
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
        }
        
        if (!$json) {
            Session::p()->data['guest']['customer_group_id'] = $customer_group_id;
            Session::p()->data['guest']['firstname']         = Request::p()->post['firstname'];
            Session::p()->data['guest']['lastname']          = Request::p()->post['lastname'];
            Session::p()->data['guest']['email']             = Request::p()->post['email'];
            Session::p()->data['guest']['telephone']         = Request::p()->post['telephone'];
            
            Session::p()->data['guest']['payment']['firstname']  = Request::p()->post['firstname'];
            Session::p()->data['guest']['payment']['lastname']   = Request::p()->post['lastname'];
            Session::p()->data['guest']['payment']['company']    = Request::p()->post['company'];
            Session::p()->data['guest']['payment']['company_id'] = Request::p()->post['company_id'];
            Session::p()->data['guest']['payment']['tax_id']     = Request::p()->post['tax_id'];
            Session::p()->data['guest']['payment']['address_1']  = Request::p()->post['address_1'];
            Session::p()->data['guest']['payment']['address_2']  = Request::p()->post['address_2'];
            Session::p()->data['guest']['payment']['postcode']   = Request::p()->post['postcode'];
            Session::p()->data['guest']['payment']['city']       = Request::p()->post['city'];
            Session::p()->data['guest']['payment']['country_id'] = Request::p()->post['country_id'];
            Session::p()->data['guest']['payment']['zone_id']    = Request::p()->post['zone_id'];
            
            Theme::model('locale/country');
            
            $country_info = LocaleCountry::getCountry(Request::p()->post['country_id']);
            
            if ($country_info) {
                Session::p()->data['guest']['payment']['country']        = $country_info['name'];
                Session::p()->data['guest']['payment']['iso_code_2']     = $country_info['iso_code_2'];
                Session::p()->data['guest']['payment']['iso_code_3']     = $country_info['iso_code_3'];
                Session::p()->data['guest']['payment']['address_format'] = $country_info['address_format'];
            } else {
                Session::p()->data['guest']['payment']['country']        = '';
                Session::p()->data['guest']['payment']['iso_code_2']     = '';
                Session::p()->data['guest']['payment']['iso_code_3']     = '';
                Session::p()->data['guest']['payment']['address_format'] = '';
            }
            
            Theme::model('locale/zone');
            
            $zone_info = LocaleZone::getZone(Request::p()->post['zone_id']);
            
            if ($zone_info) {
                Session::p()->data['guest']['payment']['zone']      = $zone_info['name'];
                Session::p()->data['guest']['payment']['zone_code'] = $zone_info['code'];
            } else {
                Session::p()->data['guest']['payment']['zone']      = '';
                Session::p()->data['guest']['payment']['zone_code'] = '';
            }
            
            if (!empty(Request::p()->post['shipping_address'])) {
                Session::p()->data['guest']['shipping_address'] = true;
            } else {
                Session::p()->data['guest']['shipping_address'] = false;
            }
            
            // Default Payment Address
            Session::p()->data['payment_country_id'] = Request::p()->post['country_id'];
            Session::p()->data['payment_zone_id'] = Request::p()->post['zone_id'];
            
            if (Session::p()->data['guest']['shipping_address']) {
                Session::p()->data['guest']['shipping']['firstname']  = Request::p()->post['firstname'];
                Session::p()->data['guest']['shipping']['lastname']   = Request::p()->post['lastname'];
                Session::p()->data['guest']['shipping']['company']    = Request::p()->post['company'];
                Session::p()->data['guest']['shipping']['address_1']  = Request::p()->post['address_1'];
                Session::p()->data['guest']['shipping']['address_2']  = Request::p()->post['address_2'];
                Session::p()->data['guest']['shipping']['postcode']   = Request::p()->post['postcode'];
                Session::p()->data['guest']['shipping']['city']       = Request::p()->post['city'];
                Session::p()->data['guest']['shipping']['country_id'] = Request::p()->post['country_id'];
                Session::p()->data['guest']['shipping']['zone_id']    = Request::p()->post['zone_id'];
                
                if ($country_info) {
                    Session::p()->data['guest']['shipping']['country']        = $country_info['name'];
                    Session::p()->data['guest']['shipping']['iso_code_2']     = $country_info['iso_code_2'];
                    Session::p()->data['guest']['shipping']['iso_code_3']     = $country_info['iso_code_3'];
                    Session::p()->data['guest']['shipping']['address_format'] = $country_info['address_format'];
                } else {
                    Session::p()->data['guest']['shipping']['country']        = '';
                    Session::p()->data['guest']['shipping']['iso_code_2']     = '';
                    Session::p()->data['guest']['shipping']['iso_code_3']     = '';
                    Session::p()->data['guest']['shipping']['address_format'] = '';
                }
                
                if ($zone_info) {
                    Session::p()->data['guest']['shipping']['zone']      = $zone_info['name'];
                    Session::p()->data['guest']['shipping']['zone_code'] = $zone_info['code'];
                } else {
                    Session::p()->data['guest']['shipping']['zone']      = '';
                    Session::p()->data['guest']['shipping']['zone_code'] = '';
                }
                
                // Default Shipping Address
                Session::p()->data['shipping_country_id'] = Request::p()->post['country_id'];
                Session::p()->data['shipping_zone_id']    = Request::p()->post['zone_id'];
                Session::p()->data['shipping_postcode']   = Request::p()->post['postcode'];
            }
            
            Session::p()->data['account'] = 'guest';
            
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
            unset(Session::p()->data['payment_method']);
            unset(Session::p()->data['payment_methods']);
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function zone() {
        $output = '<option value="">' . Lang::get('lang_text_select') . '</option>';
        
        Theme::model('locale/zone');
        
        $results = LocaleZone::getZonesByCountryId(Request::p()->get['country_id']);
        
        foreach ($results as $result) {
            $output.= '<option value="' . $result['zone_id'] . '"';
            
            if (isset(Request::p()->get['zone_id']) && (Request::p()->get['zone_id'] == $result['zone_id'])) {
                $output.= ' selected="selected"';
            }
            
            $output.= '>' . $result['name'] . '</option>';
        }
        
        if (!$results) {
            $output.= '<option value="0">' . Lang::get('lang_text_none') . '</option>';
        }
        
        Response::setOutput($output);
    }
}
