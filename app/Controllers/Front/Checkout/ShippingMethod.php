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

class ShippingMethod extends Controller {
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        Theme::model('account/address');
        
        if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
            $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
        } elseif (isset($this->session->data['guest'])) {
            $shipping_address = $this->session->data['guest']['shipping'];
        }
        
        if (!empty($shipping_address)) {
            
            // Shipping Methods
            $quote_data = array();
            
            Theme::model('setting/module');
            
            $results = $this->model_setting_module->getModules('shipping');
            
            foreach ($results as $result) {
                if (Config::get($result['code'] . '_status')) {
                    Theme::model('shipping/' . $result['code']);
                    
                    $quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);
                    
                    if ($quote) {
                        $quote_data[$result['code']] = array(
                            'title'      => $quote['title'], 
                            'quote'      => $quote['quote'], 
                            'sort_order' => $quote['sort_order'], 
                            'error'      => $quote['error']
                        );
                    }
                }
            }
            
            $sort_order = array();
            
            foreach ($quote_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }
            
            array_multisort($sort_order, SORT_ASC, $quote_data);
            
            $this->session->data['shipping_methods'] = $quote_data;
        }
        
        if (empty($this->session->data['shipping_methods'])) {
            $data['error_warning'] = sprintf(Lang::get('lang_error_no_shipping'), Url::link('content/contact'));
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['shipping_methods'])) {
            $data['shipping_methods'] = $this->session->data['shipping_methods'];
        } else {
            $data['shipping_methods'] = array();
        }
        
        if (isset($this->session->data['shipping_method']['code'])) {
            $data['code'] = $this->session->data['shipping_method']['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset($this->session->data['comment'])) {
            $data['comment'] = $this->session->data['comment'];
        } else {
            $data['comment'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput(Theme::view('checkout/shipping_method', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!$this->cart->hasShipping()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate if shipping address has been set.
        Theme::model('account/address');
        
        if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
            $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
        } elseif (isset($this->session->data['guest'])) {
            $shipping_address = $this->session->data['guest']['shipping'];
        }
        
        if (empty($shipping_address)) {
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
            if (!isset($this->request->post['shipping_method'])) {
                $json['error']['warning'] = Lang::get('lang_error_shipping');
            } else {
                $shipping = explode('.', $this->request->post['shipping_method']);
                
                if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                    $json['error']['warning'] = Lang::get('lang_error_shipping');
                }
            }
            
            if (!$json) {
                $shipping = explode('.', $this->request->post['shipping_method']);
                
                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
                
                $this->session->data['comment'] = strip_tags($this->request->post['comment']);
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
