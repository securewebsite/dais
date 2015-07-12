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
        
        if (isset($this->session->data['payment_address_id'])) {
            $data['address_id'] = $this->session->data['payment_address_id'];
        } else {
            $data['address_id'] = $this->customer->getAddressId();
        }
        
        $data['addresses'] = array();
        
        Theme::model('account/address');
        
        $data['addresses'] = $this->model_account_address->getAddresses();
        
        Theme::model('account/customer_group');
        
        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());
        
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
        
        if (isset($this->session->data['payment_country_id'])) {
            $data['country_id'] = $this->session->data['payment_country_id'];
        } else {
            $data['country_id'] = Config::get('config_country_id');
        }
        
        if (isset($this->session->data['payment_zone_id'])) {
            $data['zone_id'] = $this->session->data['payment_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');
        
        Theme::model('locale/country');
        
        $data['countries'] = $this->model_locale_country->getCountries();
        
        Theme::loadjs('javascript/checkout/payment_address', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        $this->response->setOutput(Theme::view('checkout/payment_address', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if (!$this->customer->isLogged()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !Config::get('config_stock_checkout'))) {
            $json['redirect'] = Url::link('checkout/cart');
        }
        
        // Validate minimum quantity requirments.
        $products = $this->cart->getProducts();
        
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
            if (isset($this->request->post['payment_address']) && $this->request->post['payment_address'] == 'existing') {
                Theme::model('account/address');
                Theme::model('account/customer_group');
                
                if (empty($this->request->post['address_id'])) {
                    $json['error']['warning'] = Lang::get('lang_error_address');
                } elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
                    $json['error']['warning'] = Lang::get('lang_error_address');
                } else {
                    
                    // Default Payment Address
                    Theme::model('account/address');
                    
                    $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);
                    
                    if ($address_info) {
                        
                        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());
                        
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
                    $this->session->data['payment_address_id'] = $this->request->post['address_id'];
                    
                    if ($address_info) {
                        $this->session->data['payment_country_id'] = $address_info['country_id'];
                        $this->session->data['payment_zone_id'] = $address_info['zone_id'];
                    } else {
                        unset($this->session->data['payment_country_id']);
                        unset($this->session->data['payment_zone_id']);
                    }
                }
            } else {
                if (($this->encode->strlen($this->request->post['firstname']) < 1) || ($this->encode->strlen($this->request->post['firstname']) > 32)) {
                    $json['error']['firstname'] = Lang::get('lang_error_firstname');
                }
                
                if (($this->encode->strlen($this->request->post['lastname']) < 1) || ($this->encode->strlen($this->request->post['lastname']) > 32)) {
                    $json['error']['lastname'] = Lang::get('lang_error_lastname');
                }
                
                // Customer Group
                Theme::model('account/customer_group');
                
                $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());
                
                if ($customer_group_info) {
                    
                    // Company ID
                    if ($customer_group_info['company_id_display'] && $customer_group_info['company_id_required'] && empty($this->request->post['company_id'])) {
                        $json['error']['company_id'] = Lang::get('lang_error_company_id');
                    }
                    
                    // Tax ID
                    if ($customer_group_info['tax_id_display'] && $customer_group_info['tax_id_required'] && empty($this->request->post['tax_id'])) {
                        $json['error']['tax_id'] = Lang::get('lang_error_tax_id');
                    }
                }
                
                if (($this->encode->strlen($this->request->post['address_1']) < 3) || ($this->encode->strlen($this->request->post['address_1']) > 128)) {
                    $json['error']['address_1'] = Lang::get('lang_error_address_1');
                }
                
                if (($this->encode->strlen($this->request->post['city']) < 2) || ($this->encode->strlen($this->request->post['city']) > 32)) {
                    $json['error']['city'] = Lang::get('lang_error_city');
                }
                
                Theme::model('locale/country');
                
                $country_info = $this->model_locale_country->getCountry($this->request->post['country_id']);
                
                if ($country_info) {
                    if ($country_info['postcode_required'] && ($this->encode->strlen($this->request->post['postcode']) < 2) || ($this->encode->strlen($this->request->post['postcode']) > 10)) {
                        $json['error']['postcode'] = Lang::get('lang_error_postcode');
                    }
                    
                    if (Config::get('config_vat') && !empty($this->request->post['tax_id']) && ($this->vat->validate($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
                        $json['error']['tax_id'] = Lang::get('lang_error_vat');
                    }
                }
                
                if ($this->request->post['country_id'] == '') {
                    $json['error']['country'] = Lang::get('lang_error_country');
                }
                
                if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                    $json['error']['zone'] = Lang::get('lang_error_zone');
                }
                
                if (!$json) {
                    
                    // Default Payment Address
                    Theme::model('account/address');
                    
                    $this->session->data['payment_address_id'] = $this->model_account_address->addAddress($this->request->post);
                    $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                    $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
                }
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
