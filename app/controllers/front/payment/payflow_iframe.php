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

namespace App\Controllers\Front\Payment;

use App\Controllers\Controller;

class PayflowIframe extends Controller {
    
    public function index() {
        Theme::model('checkout/order');
        Theme::model('payment/payflow_iframe');
        Theme::model('locale/country');
        Theme::model('locale/zone');
        
        $order_info = CheckoutOrder::getOrder(Session::p()->data['order_id']);
        
        if (Config::get('payflow_iframe_test')) {
            $mode = 'TEST';
        } else {
            $mode = 'LIVE';
        }
        
        $payflow_url = 'https://payflowlink.paypal.com';
        
        if (Config::get('payflow_iframe_transaction_method') == 'sale') {
            $transaction_type = 'S';
        } else {
            $transaction_type = 'A';
        }
        
        $secure_token_id = md5(Session::p()->data['order_id'] . mt_rand() . microtime());
        
        PaymentPayflowIframe::addOrder($order_info['order_id'], $secure_token_id);
        
        $shipping_country = LocaleCountry::getCountry($order_info['shipping_country_id']);
        $shipping_zone = LocaleZone::getZone($order_info['shipping_zone_id']);
        
        $payment_country = LocaleCountry::getCountry($order_info['payment_country_id']);
        $payment_zone = LocaleZone::getZone($order_info['payment_zone_id']);
        
        $urlParams = array('TENDER' => 'C', 'TRXTYPE' => $transaction_type, 'AMT' => Currency::format($order_info['total'], $order_info['currency_code'], false, false), 'CURRENCY' => $order_info['currency_code'], 'CREATESECURETOKEN' => 'Y', 'SECURETOKENID' => $secure_token_id, 
        'BILLTOFIRSTNAME' => $order_info['payment_firstname'], 'BILLTOLASTNAME' => $order_info['payment_lastname'], 'BILLTOSTREET' => trim($order_info['payment_address_1'] . ' ' . $order_info['payment_address_2']), 'BILLTOCITY' => $order_info['payment_city'], 'BILLTOSTATE' => $payment_zone['code'], 'BILLTOZIP' => $order_info['payment_postcode'], 'BILLTOCOUNTRY' => $payment_country['iso_code_2'],);
        
        // Does the order have shipping ?
        if ($shipping_country) {
            $urlParams['SHIPTOFIRSTNAME'] = $order_info['shipping_firstname'];
            $urlParams['SHIPTOLASTNAME'] = $order_info['shipping_lastname'];
            $urlParams['SHIPTOSTREET'] = trim($order_info['shipping_address_1'] . ' ' . $order_info['shipping_address_2']);
            $urlParams['SHIPTOCITY'] = $order_info['shipping_city'];
            $urlParams['SHIPTOSTATE'] = $shipping_zone['code'];
            $urlParams['SHIPTOZIP'] = $order_info['shipping_postcode'];
            $urlParams['SHIPTOCOUNTRY'] = $shipping_country['iso_code_2'];
        }
        
        $response_params = PaymentPayflowIframe::call($urlParams);
        
        if (isset($response_params['SECURETOKEN'])) {
            $secure_token = $response_params['SECURETOKEN'];
        } else {
            $secure_token = '';
        }
        
        $iframe_params = array('MODE' => $mode, 'SECURETOKENID' => $secure_token_id, 'SECURETOKEN' => $secure_token,);
        
        $data['iframe_url'] = $payflow_url . '?' . http_build_query($iframe_params, '', "&");
        $data['checkout_method'] = Config::get('payflow_iframe_checkout_method');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('payment/payflow_iframe', $data);
    }
    
    public function pp_return() {
        $data['checkout_success'] = Url::link('checkout/success');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('payment/payflow_iframe_return', $data));
    }
    
    public function pp_cancel() {
        $data['url'] = Url::link('checkout/checkout');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('payment/payflow_iframe_cancel', $data));
    }
    
    public function pp_error() {
        $data['url'] = Url::link('checkout/checkout');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('payment/payflow_iframe_error', $data));
    }
    
    public function pp_post() {
        Theme::model('payment/payflow_iframe');
        Theme::model('checkout/order');
        
        PaymentPayflowIframe::log('POST: ' . print_r(Request::post(), 1));
        
        $order_id = PaymentPayflowIframe::getOrderId(Request::p()->post['SECURETOKENID']);
        
        if ($order_id) {
            $order_info = CheckoutOrder::getOrder($order_id);
            
            $urlParams = array('TENDER' => 'C', 'TRXTYPE' => 'I', 'ORIGID' => Request::p()->post['PNREF'],);
            
            $response_params = PaymentPayflowIframe::call($urlParams);
            
            if ($order_info['order_status_id'] == 0 && $response_params['RESULT'] == '0' && Request::p()->post['RESULT'] == 0) {
                CheckoutOrder::confirm($order_id, Config::get('payflow_iframe_order_status_id'));
                
                if (Request::p()->post['TYPE'] == 'S') {
                    $complete = 1;
                } else {
                    $complete = 0;
                }
                
                $posted = array('secure_token_id' => Request::p()->post['SECURETOKENID'], 'transaction_reference' => Request::p()->post['PNREF'], 'transaction_type' => Request::p()->post['TYPE'], 'complete' => $complete,);
                
                PaymentPayflowIframe::updateOrder($posted);
                
                $posted = array('order_id' => $order_id, 'type' => Request::p()->post['TYPE'], 'transaction_reference' => Request::p()->post['PNREF'], 'amount' => Request::p()->post['AMT'],);
                
                PaymentPayflowIframe::addTransaction($posted);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        Response::setOutput('Ok');
    }
}
