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
        
        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
        } elseif (isset($this->session->data['guest'])) {
            $payment_address = $this->session->data['guest']['payment'];
        }
        
        if (!empty($payment_address)) {
            
            // Totals
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();
            
            Theme::model('setting/module');
            
            $sort_order = array();
            
            $results = $this->model_setting_module->getModules('total');
            
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
            
            $results = $this->model_setting_module->getModules('payment');
            
            $cart_has_recurring = $this->cart->hasRecurringProducts();
            
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
            
            $this->session->data['payment_methods'] = $method_data;
        }
        
        if (empty($this->session->data['payment_methods'])) {
            $data['error_warning'] = sprintf(Lang::get('lang_error_no_payment'), Url::link('content/contact'));
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['payment_methods'])) {
            $data['payment_methods'] = $this->session->data['payment_methods'];
        } else {
            $data['payment_methods'] = array();
        }
        
        if (isset($this->session->data['payment_method']['code'])) {
            $data['code'] = $this->session->data['payment_method']['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset($this->session->data['comment'])) {
            $data['comment'] = $this->session->data['comment'];
        } else {
            $data['comment'] = '';
        }
        
        if (Config::get('config_checkout_id')) {
            Theme::model('content/page');
            
            $page_info = $this->model_content_page->getPage(Config::get('config_checkout_id'));
            
            if ($page_info) {
                $data['text_agree'] = sprintf(Lang::get('lang_text_agree'), Url::link('content/page/info', 'page_id=' . Config::get('config_checkout_id'), 'SSL'), $page_info['title'], $page_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }
        
        if (isset($this->session->data['agree'])) {
            $data['agree'] = $this->session->data['agree'];
        } else {
            $data['agree'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput(Theme::view('checkout/payment_method', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        // Validate if payment address has been set.
        Theme::model('account/address');
        
        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
        } elseif (isset($this->session->data['guest'])) {
            $payment_address = $this->session->data['guest']['payment'];
        }
        
        if (empty($payment_address)) {
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
            if (!isset($this->request->post['payment_method'])) {
                $json['error']['warning'] = Lang::get('lang_error_payment');
            } elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
                $json['error']['warning'] = Lang::get('lang_error_payment');
            }
            
            if (Config::get('config_checkout_id')) {
                Theme::model('content/page');
                
                $page_info = $this->model_content_page->getPage(Config::get('config_checkout_id'));
                
                if ($page_info && !isset($this->request->post['agree'])) {
                    $json['error']['warning'] = sprintf(Lang::get('lang_error_agree'), $page_info['title']);
                }
            }
            
            if (!$json) {
                $this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
                
                $this->session->data['comment'] = strip_tags($this->request->post['comment']);
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
