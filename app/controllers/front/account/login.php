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


namespace App\Controllers\Front\Account;
use App\Controllers\Controller;

class Login extends Controller {
    private $error = array();
    
    public function index() {
        $this->theme->model('account/customer');
        
        // Login override for admin users
        if (!empty($this->request->get['token'])) {
            $this->customer->logout();
            $this->cart->clear();
            
            unset($this->session->data['wishlist']);
            unset($this->session->data['shipping_address_id']);
            unset($this->session->data['shipping_country_id']);
            unset($this->session->data['shipping_zone_id']);
            unset($this->session->data['shipping_postcode']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_address_id']);
            unset($this->session->data['payment_country_id']);
            unset($this->session->data['payment_zone_id']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['gift_card']);
            unset($this->session->data['gift_cards']);
            
            $customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);
            
            if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
                
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
                
                $this->theme->trigger('front_customer_login', array('customer_id' => $this->customer->getId()));
                
                $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
            }
        }
        
        if ($this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
        }
        
        $data = $this->theme->language('account/login');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            unset($this->session->data['guest']);
            
            // Default Shipping Address
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
            
            if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
                $this->response->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
            } else {
                $this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
            }
        }
        
        if ($this->customer->isLogged()):
            $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        endif;
        
        $this->breadcrumb->add('lang_text_login', 'account/login', null, true, 'SSL');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $data['action']    = $this->url->link('account/login', '', 'SSL');
        $data['register']  = $this->url->link('account/register', '', 'SSL');
        $data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
        
        if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
            $data['redirect'] = $this->request->post['redirect'];
        } elseif (isset($this->session->data['redirect'])) {
            $data['redirect'] = $this->session->data['redirect'];
            
            unset($this->session->data['redirect']);
        } else {
            $data['redirect'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->renderControllers($data);
        
        $this->response->setOutput($this->theme->view('account/login', $data));
    }
    
    protected function validate() {
        if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
            $this->error['warning'] = $this->language->get('lang_error_login');
        }
        
        $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
        
        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = $this->language->get('lang_error_approved');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
