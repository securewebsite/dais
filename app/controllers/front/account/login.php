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
        Theme::model('account/customer');
        
        // Login override for admin users
        if (!empty($this->request->get['token'])) {
            Customer::logout();
            Cart::clear();
            
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
            
            $customer_info = AccountCustomer::getCustomerByToken($this->request->get['token']);
            
            if ($customer_info && Customer::login($customer_info['email'], '', true)) {
                
                // Default Addresses
                Theme::model('account/address');
                
                $address_info = AccountAddress::getAddress(Customer::getAddressId());
                
                if ($address_info) {
                    if (Config::get('config_tax_customer') == 'shipping') {
                        $this->session->data['shipping_country_id'] = $address_info['country_id'];
                        $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                        $this->session->data['shipping_postcode'] = $address_info['postcode'];
                    }
                    
                    if (Config::get('config_tax_customer') == 'payment') {
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
                
                Theme::trigger('front_customer_login', array('customer_id' => Customer::getId()));
                
                Response::redirect(Url::link('account/dashboard', '', 'SSL'));
            }
        }
        
        if (Customer::isLogged()) {
            Response::redirect(Url::link('account/dashboard', '', 'SSL'));
        }
        
        $data = Theme::language('account/login');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            unset($this->session->data['guest']);
            
            // Default Shipping Address
            Theme::model('account/address');
            
            $address_info = AccountAddress::getAddress(Customer::getAddressId());
            
            if ($address_info) {
                if (Config::get('config_tax_customer') == 'shipping') {
                    $this->session->data['shipping_country_id'] = $address_info['country_id'];
                    $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                    $this->session->data['shipping_postcode'] = $address_info['postcode'];
                }
                
                if (Config::get('config_tax_customer') == 'payment') {
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
            
            if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], Config::get('config_url')) !== false || strpos($this->request->post['redirect'], Config::get('config_ssl')) !== false)) {
                Response::redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
            } else {
                Response::redirect(Url::link('account/dashboard', '', 'SSL'));
            }
        }
        
        if (Customer::isLogged()):
            Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        endif;
        
        Breadcrumb::add('lang_text_login', 'account/login', null, true, 'SSL');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $data['action']    = Url::link('account/login', '', 'SSL');
        $data['register']  = Url::link('account/register', '', 'SSL');
        $data['forgotten'] = Url::link('account/forgotten', '', 'SSL');
        
        if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], Config::get('config_url')) !== false || strpos($this->request->post['redirect'], Config::get('config_ssl')) !== false)) {
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
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/login', $data));
    }
    
    protected function validate() {
        if (!Customer::login($this->request->post['email'], $this->request->post['password'])) {
            $this->error['warning'] = Lang::get('lang_error_login');
        }
        
        $customer_info = AccountCustomer::getCustomerByEmail($this->request->post['email']);
        
        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = Lang::get('lang_error_approved');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
