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

class ShippingAddress extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        if (isset($this->session->data['shipping_address_id'])) {
            $data['address_id'] = $this->session->data['shipping_address_id'];
        } else {
            $data['address_id'] = Customer::getAddressId();
        }
        
        Theme::model('account/address');
        
        $data['addresses'] = AccountAddress::getAddresses();
        
        if (isset($this->session->data['shipping_postcode'])) {
            $data['postcode'] = $this->session->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset($this->session->data['shipping_country_id'])) {
            $data['country_id'] = $this->session->data['shipping_country_id'];
        } else {
            $data['country_id'] = Config::get('config_country_id');
        }
        
        if (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        Theme::loadjs('javascript/checkout/shipping_address', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::render('checkout/shipping_address', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if (!Customer::isLogged()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!Cart::hasShipping()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!Cart::hasProducts() && empty($this->session->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $json['redirect'] = Url::link('checkout/cart');
        }
        
        // Validate minimum quantity requirments.
        $products = Cart::getProducts();
        
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
            if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
                Theme::model('account/address');
                
                if (empty($this->request->post['address_id'])) {
                    $json['error']['warning'] = Lang::get('lang_error_address');
                } elseif (!in_array($this->request->post['address_id'], array_keys(AccountAddress::getAddresses()))) {
                    $json['error']['warning'] = Lang::get('lang_error_address');
                }
                
                if (!$json) {
                    $this->session->data['shipping_address_id'] = $this->request->post['address_id'];
                    
                    // Default Shipping Address
                    Theme::model('account/address');
                    
                    $address_info = AccountAddress::getAddress($this->request->post['address_id']);
                    
                    if ($address_info) {
                        $this->session->data['shipping_country_id'] = $address_info['country_id'];
                        $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                        $this->session->data['shipping_postcode'] = $address_info['postcode'];
                    } else {
                        unset($this->session->data['shipping_country_id']);
                        unset($this->session->data['shipping_zone_id']);
                        unset($this->session->data['shipping_postcode']);
                    }
                }
            }
            
            if ($this->request->post['shipping_address'] == 'new') {
                if ((Encode::strlen($this->request->post['firstname']) < 1) || (Encode::strlen($this->request->post['firstname']) > 32)) {
                    $json['error']['firstname'] = Lang::get('lang_error_firstname');
                }
                
                if ((Encode::strlen($this->request->post['lastname']) < 1) || (Encode::strlen($this->request->post['lastname']) > 32)) {
                    $json['error']['lastname'] = Lang::get('lang_error_lastname');
                }
                
                if ((Encode::strlen($this->request->post['address_1']) < 3) || (Encode::strlen($this->request->post['address_1']) > 128)) {
                    $json['error']['address_1'] = Lang::get('lang_error_address_1');
                }
                
                if ((Encode::strlen($this->request->post['city']) < 2) || (Encode::strlen($this->request->post['city']) > 128)) {
                    $json['error']['city'] = Lang::get('lang_error_city');
                }
                
                Theme::model('locale/country');
                
                $country_info = LocaleCountry::getCountry($this->request->post['country_id']);
                
                if ($country_info && $country_info['postcode_required'] && (Encode::strlen($this->request->post['postcode']) < 2) || (Encode::strlen($this->request->post['postcode']) > 10)) {
                    $json['error']['postcode'] = Lang::get('lang_error_postcode');
                }
                
                if ($this->request->post['country_id'] == '') {
                    $json['error']['country'] = Lang::get('lang_error_country');
                }
                
                if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                    $json['error']['zone'] = Lang::get('lang_error_zone');
                }
                
                if (!$json) {
                    
                    // Default Shipping Address
                    Theme::model('account/address');
                    
                    $this->session->data['shipping_address_id'] = AccountAddress::addAddress($this->request->post);
                    $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                    $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                    $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
                }
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
