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

class Login extends Controller {
    
    public function index() {
        $data = Theme::language('checkout/checkout');
        
        $data['guest_checkout'] = (Config::get('config_guest_checkout') && !Config::get('config_customer_price') && !\Cart::hasDownload());
        
        if (isset(Session::p()->data['account'])) {
            $data['account'] = Session::p()->data['account'];
            unset(Session::p()->data['account']);
        } else {
            $data['account'] = 'register';
        }
        
        $data['forgotten'] = Url::link('account/forgotten', '', 'SSL');
        
        Theme::loadjs('javascript/checkout/login', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::make('checkout/login', $data));
    }
    
    public function validate() {
        Theme::language('checkout/checkout');
        
        $json = array();
        
        if (Customer::isLogged()) {
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        if ((!\Cart::hasProducts() && empty(Session::p()->data['gift_cards'])) || (!\Cart::hasStock() && !Config::get('config_stock_checkout'))) {
            $json['redirect'] = Url::link('checkout/cart');
        }
        
        if (!$json) {
            if (!Customer::login(Request::p()->post['email'], Request::p()->post['password'])) {
                $json['error']['warning'] = Lang::get('lang_error_login');
            }
            
            Theme::model('account/customer');
            
            $customer_info = AccountCustomer::getCustomerByEmail(Request::p()->post['email']);
            
            if ($customer_info && !$customer_info['approved']) {
                $json['error']['warning'] = Lang::get('lang_error_approved');
            }
        }
        
        if (!$json) {
            unset(Session::p()->data['guest']);
            
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
            
            $json['redirect'] = Url::link('checkout/checkout', '', 'SSL');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
