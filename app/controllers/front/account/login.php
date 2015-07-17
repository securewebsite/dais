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
        if (!empty(Request::p()->get['token'])) {
            Customer::logout();
            Cart::clear();
            
            unset(Session::p()->data['wishlist']);
            unset(Session::p()->data['shipping_address_id']);
            unset(Session::p()->data['shipping_country_id']);
            unset(Session::p()->data['shipping_zone_id']);
            unset(Session::p()->data['shipping_postcode']);
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
            unset(Session::p()->data['payment_address_id']);
            unset(Session::p()->data['payment_country_id']);
            unset(Session::p()->data['payment_zone_id']);
            unset(Session::p()->data['payment_method']);
            unset(Session::p()->data['payment_methods']);
            unset(Session::p()->data['comment']);
            unset(Session::p()->data['order_id']);
            unset(Session::p()->data['coupon']);
            unset(Session::p()->data['reward']);
            unset(Session::p()->data['gift_card']);
            unset(Session::p()->data['gift_cards']);
            
            $customer_info = AccountCustomer::getCustomerByToken(Request::p()->get['token']);
            
            if ($customer_info && Customer::login($customer_info['email'], '', true)) {
                
                // Default Addresses
                Theme::model('account/address');
                
                $address_info = AccountAddress::getAddress(Customer::getAddressId());
                
                if ($address_info) {
                    if (Config::get('config_tax_customer') == 'shipping') {
                        Session::p()->data['shipping_country_id'] = $address_info['country_id'];
                        Session::p()->data['shipping_zone_id'] = $address_info['zone_id'];
                        Session::p()->data['shipping_postcode'] = $address_info['postcode'];
                    }
                    
                    if (Config::get('config_tax_customer') == 'payment') {
                        Session::p()->data['payment_country_id'] = $address_info['country_id'];
                        Session::p()->data['payment_zone_id'] = $address_info['zone_id'];
                    }
                } else {
                    unset(Session::p()->data['shipping_country_id']);
                    unset(Session::p()->data['shipping_zone_id']);
                    unset(Session::p()->data['shipping_postcode']);
                    unset(Session::p()->data['payment_country_id']);
                    unset(Session::p()->data['payment_zone_id']);
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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            unset(Session::p()->data['guest']);
            
            // Default Shipping Address
            Theme::model('account/address');
            
            $address_info = AccountAddress::getAddress(Customer::getAddressId());
            
            if ($address_info) {
                if (Config::get('config_tax_customer') == 'shipping') {
                    Session::p()->data['shipping_country_id'] = $address_info['country_id'];
                    Session::p()->data['shipping_zone_id'] = $address_info['zone_id'];
                    Session::p()->data['shipping_postcode'] = $address_info['postcode'];
                }
                
                if (Config::get('config_tax_customer') == 'payment') {
                    Session::p()->data['payment_country_id'] = $address_info['country_id'];
                    Session::p()->data['payment_zone_id'] = $address_info['zone_id'];
                }
            } else {
                unset(Session::p()->data['shipping_country_id']);
                unset(Session::p()->data['shipping_zone_id']);
                unset(Session::p()->data['shipping_postcode']);
                unset(Session::p()->data['payment_country_id']);
                unset(Session::p()->data['payment_zone_id']);
            }
            
            if (isset(Request::p()->post['redirect']) && (strpos(Request::p()->post['redirect'], Config::get('config_url')) !== false || strpos(Request::p()->post['redirect'], Config::get('config_ssl')) !== false)) {
                Response::redirect(str_replace('&amp;', '&', Request::p()->post['redirect']));
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
        
        if (isset(Request::p()->post['redirect']) && (strpos(Request::p()->post['redirect'], Config::get('config_url')) !== false || strpos(Request::p()->post['redirect'], Config::get('config_ssl')) !== false)) {
            $data['redirect'] = Request::p()->post['redirect'];
        } elseif (isset(Session::p()->data['redirect'])) {
            $data['redirect'] = Session::p()->data['redirect'];
            
            unset(Session::p()->data['redirect']);
        } else {
            $data['redirect'] = '';
        }
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset(Request::p()->post['email'])) {
            $data['email'] = Request::p()->post['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset(Request::p()->post['password'])) {
            $data['password'] = Request::p()->post['password'];
        } else {
            $data['password'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/login', $data));
    }
    
    protected function validate() {
        if (!Customer::login(Request::p()->post['email'], Request::p()->post['password'])) {
            $this->error['warning'] = Lang::get('lang_error_login');
        }
        
        $customer_info = AccountCustomer::getCustomerByEmail(Request::p()->post['email']);
        
        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = Lang::get('lang_error_approved');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
