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

class PaypalProUk extends Controller {
    
    public function index() {
        $data = Theme::language('payment/paypal_pro_uk');
        
        $data['cards'] = array();
        
        $data['cards'][] = array('text' => 'Visa', 'value' => 'VISA');
        
        $data['cards'][] = array('text' => 'MasterCard', 'value' => 'MASTERCARD');
        
        $data['cards'][] = array('text' => 'Discover Card', 'value' => 'DISCOVER');
        
        $data['cards'][] = array('text' => 'American Express', 'value' => 'AMEX');
        
        $data['cards'][] = array('text' => 'Maestro', 'value' => 'SWITCH');
        
        $data['cards'][] = array('text' => 'Solo', 'value' => 'SOLO');
        
        $data['months'] = array();
        
        for ($i = 1; $i <= 12; $i++) {
            $data['months'][] = array('text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)), 'value' => sprintf('%02d', $i));
        }
        
        $today = getdate();
        
        $data['year_valid'] = array();
        
        for ($i = $today['year'] - 10; $i < $today['year'] + 1; $i++) {
            $data['year_valid'][] = array('text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)), 'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)));
        }
        
        $data['year_expire'] = array();
        
        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][] = array('text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)), 'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)));
        }
        
        Theme::loadjs('javascript/payment/paypal_pro_uk', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return View::render('payment/paypal_pro_uk', $data);
    }
    
    public function send() {
        if (!Config::get('paypal_pro_uk_transaction')) {
            $payment_type = 'Authorization';
        } else {
            $payment_type = 'Sale';
        }
        
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder(Session::p()->data['order_id']);
        
        $request = 'METHOD=DoDirectPayment';
        $request.= '&VERSION=51.0';
        $request.= '&USER=' . urlencode(Config::get('paypal_pro_uk_username'));
        $request.= '&PWD=' . urlencode(Config::get('paypal_pro_uk_password'));
        $request.= '&SIGNATURE=' . urlencode(Config::get('paypal_pro_uk_signature'));
        $request.= '&CUSTREF=' . (int)$order_info['order_id'];
        $request.= '&PAYMENTACTION=' . $payment_type;
        $request.= '&AMT=' . Currency::format($order_info['total'], $order_info['currency_code'], false, false);
        $request.= '&CREDITCARDTYPE=' . Request::p()->post['cc_type'];
        $request.= '&ACCT=' . urlencode(str_replace(' ', '', Request::p()->post['cc_number']));
        $request.= '&CARDSTART=' . urlencode(Request::p()->post['cc_start_date_month'] . Request::p()->post['cc_start_date_year']);
        $request.= '&EXPDATE=' . urlencode(Request::p()->post['cc_expire_date_month'] . Request::p()->post['cc_expire_date_year']);
        $request.= '&CVV2=' . urlencode(Request::p()->post['cc_cvv2']);
        
        if (Request::p()->post['cc_type'] == 'SWITCH' || Request::p()->post['cc_type'] == 'SOLO') {
            $request.= '&CARDISSUE=' . urlencode(Request::p()->post['cc_issue']);
        }
        
        $request.= '&FIRSTNAME=' . urlencode($order_info['payment_firstname']);
        $request.= '&LASTNAME=' . urlencode($order_info['payment_lastname']);
        $request.= '&EMAIL=' . urlencode($order_info['email']);
        $request.= '&PHONENUM=' . urlencode($order_info['telephone']);
        $request.= '&IPADDRESS=' . urlencode(Request::p()->server['REMOTE_ADDR']);
        $request.= '&STREET=' . urlencode($order_info['payment_address_1']);
        $request.= '&CITY=' . urlencode($order_info['payment_city']);
        $request.= '&STATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
        $request.= '&ZIP=' . urlencode($order_info['payment_postcode']);
        $request.= '&COUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
        $request.= '&CURRENCYCODE=' . urlencode($order_info['currency_code']);
        $request.= '&BUTTONSOURCE=' . urlencode('Dais_Cart_WPP');
        
        if (Cart::hasShipping()) {
            $request.= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
            $request.= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
            $request.= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
            $request.= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
            $request.= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
            $request.= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);
        } else {
            $request.= '&SHIPTONAME=' . urlencode($order_info['payment_firstname'] . ' ' . $order_info['payment_lastname']);
            $request.= '&SHIPTOSTREET=' . urlencode($order_info['payment_address_1']);
            $request.= '&SHIPTOCITY=' . urlencode($order_info['payment_city']);
            $request.= '&SHIPTOSTATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
            $request.= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['payment_iso_code_2']);
            $request.= '&SHIPTOZIP=' . urlencode($order_info['payment_postcode']);
        }
        
        if (!Config::get('paypal_pro_uk_test')) {
            $curl = curl_init('https://api-3t.paypal.com/nvp');
        } else {
            $curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
        }
        
        curl_setopt($curl, CURLOPT_PORT, 443);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        if (!$response) {
            $this->log->write('DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
        }
        
        $response_info = array();
        
        parse_str($response, $response_info);
        
        $json = array();
        
        if (($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) {
            CheckoutOrder::confirm(Session::p()->data['order_id'], Config::get('config_order_status_id'));
            
            $message = '';
            
            if (isset($response_info['AVSCODE'])) {
                $message.= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
            }
            
            if (isset($response_info['CVV2MATCH'])) {
                $message.= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
            }
            
            if (isset($response_info['TRANSACTIONID'])) {
                $message.= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
            }
            
            CheckoutOrder::update(Session::p()->data['order_id'], Config::get('paypal_pro_uk_order_status_id'), $message);
            
            $json['success'] = Url::link('checkout/success');
        } else {
            $json['error'] = $response_info['L_LONGMESSAGE0'];
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
