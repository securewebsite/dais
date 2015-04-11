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
use Dais\Engine\Controller;

class Login extends Controller {
    public function index() {
        $data = $this->theme->language('checkout/checkout');
        
        $data['guest_checkout'] = ($this->config->get('config_guest_checkout') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());
        
        if (isset($this->session->data['account'])) {
            $data['account'] = $this->session->data['account'];
            unset($this->session->data['account']);
        } else {
            $data['account'] = 'register';
        }
        
        $data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
        
        $this->theme->loadjs('javascript/checkout/login', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        $this->response->setOutput($this->theme->view('checkout/login', $data));
    }
    
    public function validate() {
        $this->theme->language('checkout/checkout');
        
        $json = array();
        
        if ($this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        if ((!$this->cart->hasProducts() && empty($this->session->data['giftcards'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }
        
        if (!$json) {
            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                $json['error']['warning'] = $this->language->get('lang_error_login');
            }
            
            $this->theme->model('account/customer');
            
            $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
            
            if ($customer_info && !$customer_info['approved']) {
                $json['error']['warning'] = $this->language->get('lang_error_approved');
            }
        }
        
        if (!$json) {
            unset($this->session->data['guest']);
            
            // Default Addresses
            $this->theme->model('account/address');
            
            $address_info = $this->model_account_address->getAddress($this->customer->getAddressId());
            
            if ($address_info) {
                if ($this->config->get('config_tax_customer') == 'shipping') {
                    $this->session->data['shipping_country_id'] = $address_info['country_id'];
                    $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                    $this->session->data['shipping_postcode'] = $address_info['postcode'];
                }
                
                if ($this->config->get('config_tax_customer') == 'payment') {
                    $this->session->data['payment_country_id'] = $address_info['country_id'];
                    $this->session->data['payment_zone_id'] = $address_info['zone_id'];
                }
            } else {
                unset($this->session->data['shipping_country_id']);
                unset($this->session->data['shipping_zone_id']);
                unset($this->session->data['shipping_postcode']);
                unset($this->session->data['payment_country_id']);
                unset($this->session->data['payment_zone_id']);
            }
            
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
