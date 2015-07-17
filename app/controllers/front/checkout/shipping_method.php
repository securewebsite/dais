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
        
        if (Customer::isLogged() && isset(Session::p()->data['shipping_address_id'])) {
            $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
        } elseif (isset(Session::p()->data['guest'])) {
            $shipping_address = Session::p()->data['guest']['shipping'];
        }
        
        if (!empty($shipping_address)) {
            
            // Shipping Methods
            $quote_data = array();
            
            Theme::model('setting/module');
            
            $results = SettingModule::getModules('shipping');
            
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
            
            Session::p()->data['shipping_methods'] = $quote_data;
        }
        
        if (empty(Session::p()->data['shipping_methods'])) {
            $data['error_warning'] = sprintf(Lang::get('lang_error_no_shipping'), Url::link('content/contact'));
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset(Session::p()->data['shipping_methods'])) {
            $data['shipping_methods'] = Session::p()->data['shipping_methods'];
        } else {
            $data['shipping_methods'] = array();
        }
        
        if (isset(Session::p()->data['shipping_method']['code'])) {
            $data['code'] = Session::p()->data['shipping_method']['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset(Session::p()->data['comment'])) {
            $data['comment'] = Session::p()->data['comment'];
        } else {
            $data['comment'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::render('checkout/shipping_method', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!\Cart::hasShipping()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate if shipping address has been set.
        Theme::model('account/address');
        
        if (Customer::isLogged() && isset(Session::p()->data['shipping_address_id'])) {
            $shipping_address = AccountAddress::getAddress(Session::p()->data['shipping_address_id']);
        } elseif (isset(Session::p()->data['guest'])) {
            $shipping_address = Session::p()->data['guest']['shipping'];
        }
        
        if (empty($shipping_address)) {
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
            if (!isset(Request::p()->post['shipping_method'])) {
                $json['error']['warning'] = Lang::get('lang_error_shipping');
            } else {
                $shipping = explode('.', Request::p()->post['shipping_method']);
                
                if (!isset($shipping[0]) || !isset($shipping[1]) || !isset(Session::p()->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                    $json['error']['warning'] = Lang::get('lang_error_shipping');
                }
            }
            
            if (!$json) {
                $shipping = explode('.', Request::p()->post['shipping_method']);
                
                Session::p()->data['shipping_method'] = Session::p()->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
                
                Session::p()->data['comment'] = strip_tags(Request::p()->post['comment']);
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
