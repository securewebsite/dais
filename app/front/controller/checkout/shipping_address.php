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

namespace Front\Controller\Checkout;
use Dais\Base\Controller;

class ShippingAddress extends Controller {
    public function index() {
        $data = $this->theme->language('checkout/checkout');
        
        if (isset($this->session->data['shipping_address_id'])) {
            $data['address_id'] = $this->session->data['shipping_address_id'];
        } else {
            $data['address_id'] = $this->customer->getAddressId();
        }
        
        $this->theme->model('account/address');
        
        $data['addresses'] = $this->model_account_address->getAddresses();
        
        if (isset($this->session->data['shipping_postcode'])) {
            $data['postcode'] = $this->session->data['shipping_postcode'];
        } else {
            $data['postcode'] = '';
        }
        
        if (isset($this->session->data['shipping_country_id'])) {
            $data['country_id'] = $this->session->data['shipping_country_id'];
        } else {
            $data['country_id'] = $this->config->get('config_country_id');
        }
        
        if (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        
        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . $this->language->get('lang_text_select') . '","none":"' . $this->language->get('lang_text_none') . '"}');
        
        $this->theme->model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries();
        
        $this->theme->loadjs('javascript/checkout/shipping_address', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        $this->response->setOutput($this->theme->view('checkout/shipping_address', $data));
    }
    
    public function validate() {
        $this->theme->language('checkout/checkout');
        
        $json = array();
        
        // Validate if customer is logged in.
        if (!$this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!$this->cart->hasShipping()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['gift_cards'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
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
                $json['redirect'] = $this->url->link('checkout/cart');
                
                break;
            }
        }
        
        if (!$json) {
            if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
                $this->theme->model('account/address');
                
                if (empty($this->request->post['address_id'])) {
                    $json['error']['warning'] = $this->language->get('lang_error_address');
                } elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
                    $json['error']['warning'] = $this->language->get('lang_error_address');
                }
                
                if (!$json) {
                    $this->session->data['shipping_address_id'] = $this->request->post['address_id'];
                    
                    // Default Shipping Address
                    $this->theme->model('account/address');
                    
                    $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);
                    
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
                if (($this->encode->strlen($this->request->post['firstname']) < 1) || ($this->encode->strlen($this->request->post['firstname']) > 32)) {
                    $json['error']['firstname'] = $this->language->get('lang_error_firstname');
                }
                
                if (($this->encode->strlen($this->request->post['lastname']) < 1) || ($this->encode->strlen($this->request->post['lastname']) > 32)) {
                    $json['error']['lastname'] = $this->language->get('lang_error_lastname');
                }
                
                if (($this->encode->strlen($this->request->post['address_1']) < 3) || ($this->encode->strlen($this->request->post['address_1']) > 128)) {
                    $json['error']['address_1'] = $this->language->get('lang_error_address_1');
                }
                
                if (($this->encode->strlen($this->request->post['city']) < 2) || ($this->encode->strlen($this->request->post['city']) > 128)) {
                    $json['error']['city'] = $this->language->get('lang_error_city');
                }
                
                $this->theme->model('localization/country');
                
                $country_info = $this->model_localization_country->getCountry($this->request->post['country_id']);
                
                if ($country_info && $country_info['postcode_required'] && ($this->encode->strlen($this->request->post['postcode']) < 2) || ($this->encode->strlen($this->request->post['postcode']) > 10)) {
                    $json['error']['postcode'] = $this->language->get('lang_error_postcode');
                }
                
                if ($this->request->post['country_id'] == '') {
                    $json['error']['country'] = $this->language->get('lang_error_country');
                }
                
                if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
                    $json['error']['zone'] = $this->language->get('lang_error_zone');
                }
                
                if (!$json) {
                    
                    // Default Shipping Address
                    $this->theme->model('account/address');
                    
                    $this->session->data['shipping_address_id'] = $this->model_account_address->addAddress($this->request->post);
                    $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                    $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                    $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
                }
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
