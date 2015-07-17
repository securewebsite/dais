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

class PaymentMethod extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        Theme::model('account/address');
        
        if (Customer::isLogged() && isset(Session::p()->data['payment_address_id'])) {
            $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
        } elseif (isset(Session::p()->data['guest'])) {
            $payment_address = Session::p()->data['guest']['payment'];
        }
        
        if (!empty($payment_address)) {
            
            // Totals
            $total_data = array();
            $total = 0;
            $taxes = Cart::getTaxes();
            
            Theme::model('setting/module');
            
            $sort_order = array();
            
            $results = SettingModule::getModules('total');
            
            foreach ($results as $key => $value) {
                $sort_order[$key] = Config::get($value['code'] . '_sort_order');
            }
            
            array_multisort($sort_order, SORT_ASC, $results);
            
            foreach ($results as $result) {
                if (Config::get($result['code'] . '_status')) {
                    Theme::model('total/' . $result['code']);
                    
                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                }
            }
            
            // Payment Methods
            $method_data = array();
            
            Theme::model('setting/module');
            
            $results = SettingModule::getModules('payment');
            
            $cart_has_recurring = Cart::hasRecurringProducts();
            
            foreach ($results as $result) {
                if (Config::get($result['code'] . '_status')) {
                    Theme::model('payment/' . $result['code']);
                    
                    $method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);
                    
                    if ($method) {
                        if ($cart_has_recurring > 0) {
                            if (method_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments')) {
                                if ($this->{'model_payment_' . $result['code']}->recurringPayments() === true) {
                                    $method_data[$result['code']] = $method;
                                }
                            }
                        } else {
                            $method_data[$result['code']] = $method;
                        }
                    }
                }
            }
            
            $sort_order = array();
            
            foreach ($method_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }
            
            array_multisort($sort_order, SORT_ASC, $method_data);
            
            Session::p()->data['payment_methods'] = $method_data;
        }
        
        if (empty(Session::p()->data['payment_methods'])) {
            $data['error_warning'] = sprintf(Lang::get('lang_error_no_payment'), Url::link('content/contact'));
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset(Session::p()->data['payment_methods'])) {
            $data['payment_methods'] = Session::p()->data['payment_methods'];
        } else {
            $data['payment_methods'] = array();
        }
        
        if (isset(Session::p()->data['payment_method']['code'])) {
            $data['code'] = Session::p()->data['payment_method']['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset(Session::p()->data['comment'])) {
            $data['comment'] = Session::p()->data['comment'];
        } else {
            $data['comment'] = '';
        }
        
        if (Config::get('config_checkout_id')) {
            Theme::model('content/page');
            
            $page_info = ContentPage::getPage(Config::get('config_checkout_id'));
            
            if ($page_info) {
                $data['text_agree'] = sprintf(Lang::get('lang_text_agree'), Url::link('content/page/info', 'page_id=' . Config::get('config_checkout_id'), 'SSL'), $page_info['title'], $page_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }
        
        if (isset(Session::p()->data['agree'])) {
            $data['agree'] = Session::p()->data['agree'];
        } else {
            $data['agree'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::render('checkout/payment_method', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if payment address has been set.
        Theme::model('account/address');
        
        if (Customer::isLogged() && isset(Session::p()->data['payment_address_id'])) {
            $payment_address = AccountAddress::getAddress(Session::p()->data['payment_address_id']);
        } elseif (isset(Session::p()->data['guest'])) {
            $payment_address = Session::p()->data['guest']['payment'];
        }
        
        if (empty($payment_address)) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        // Validate cart has products and has stock.
        if ((!Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!Cart::hasStock() && !Config::get('config_stock_checkout'))) {
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
            if (!isset(Request::p()->post['payment_method'])) {
                $json['error']['warning'] = Lang::get('lang_error_payment');
            } elseif (!isset(Session::p()->data['payment_methods'][Request::p()->post['payment_method']])) {
                $json['error']['warning'] = Lang::get('lang_error_payment');
            }
            
            if (Config::get('config_checkout_id')) {
                Theme::model('content/page');
                
                $page_info = ContentPage::getPage(Config::get('config_checkout_id'));
                
                if ($page_info && !isset(Request::p()->post['agree'])) {
                    $json['error']['warning'] = sprintf(Lang::get('lang_error_agree'), $page_info['title']);
                }
            }
            
            if (!$json) {
                Session::p()->data['payment_method'] = Session::p()->data['payment_methods'][Request::p()->post['payment_method']];
                
                Session::p()->data['comment'] = strip_tags(Request::p()->post['comment']);
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
