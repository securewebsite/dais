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

class PaypalProPf extends Controller {
    
    public function index() {
        $data = Theme::language('payment/paypal_pro_pf');
        
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder(Session::p()->data['order_id']);
        
        $data['owner'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
        
        $data['cards'] = array();
        
        $data['cards'][] = array('text' => 'Visa', 'value' => '0');
        
        $data['cards'][] = array('text' => 'MasterCard', 'value' => '1');
        
        $data['cards'][] = array('text' => 'Maestro', 'value' => '9');
        
        $data['cards'][] = array('text' => 'Solo', 'value' => 'S');
        
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
        
        Theme::loadjs('javascript/payment/paypal_pro_pf', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return View::make('payment/paypal_pro_pf', $data);
    }
    
    public function send() {
        Theme::language('payment/paypal_pro_pf');
        
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder(Session::p()->data['order_id']);
        
        if (!Config::get('paypal_pro_pf_transaction')) {
            $payment_type = 'A';
        } else {
            $payment_type = 'S';
        }
        
        $request = 'USER=' . urlencode(Config::get('paypal_pro_pf_user'));
        $request.= '&VENDOR=' . urlencode(Config::get('paypal_pro_pf_vendor'));
        $request.= '&PARTNER=' . urlencode(Config::get('paypal_pro_pf_partner'));
        $request.= '&PWD=' . urlencode(Config::get('paypal_pro_pf_password'));
        $request.= '&TENDER=C';
        $request.= '&TRXTYPE=' . $payment_type;
        $request.= '&AMT=' . Currency::format($order_info['total'], $order_info['currency_code'], false, false);
        $request.= '&CURRENCY=' . urlencode($order_info['currency_code']);
        $request.= '&NAME=' . urlencode(Request::p()->post['cc_owner']);
        $request.= '&STREET=' . urlencode($order_info['payment_address_1']);
        $request.= '&CITY=' . urlencode($order_info['payment_city']);
        $request.= '&STATE=' . urlencode(($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
        $request.= '&COUNTRY=' . urlencode($order_info['payment_iso_code_2']);
        $request.= '&ZIP=' . urlencode(str_replace(' ', '', $order_info['payment_postcode']));
        $request.= '&CLIENTIP=' . urlencode(Request::p()->server['REMOTE_ADDR']);
        $request.= '&EMAIL=' . urlencode($order_info['email']);
        $request.= '&ACCT=' . urlencode(str_replace(' ', '', Request::p()->post['cc_number']));
        $request.= '&ACCTTYPE=' . urlencode(Request::p()->post['cc_type']);
        $request.= '&CARDSTART=' . urlencode(Request::p()->post['cc_start_date_month'] . substr(Request::p()->post['cc_start_date_year'], -2, 2));
        $request.= '&EXPDATE=' . urlencode(Request::p()->post['cc_expire_date_month'] . substr(Request::p()->post['cc_expire_date_year'], -2, 2));
        $request.= '&CVV2=' . urlencode(Request::p()->post['cc_cvv2']);
        $request.= '&CARDISSUE=' . urlencode(Request::p()->post['cc_issue']);
        $request.= '&BUTTONSOURCE=' . urlencode('Dais_Cart_PFP');
        
        if (!Config::get('paypal_pro_pf_test')) {
            $curl = curl_init('https://payflowpro.paypal.com');
        } else {
            $curl = curl_init('https://pilot-payflowpro.paypal.com');
        }
        
        curl_setopt($curl, CURLOPT_PORT, 443);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-VPS-REQUEST-ID: ' . md5(Session::p()->data['order_id'] . mt_rand())));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        if (!$response) {
            Log::write('DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
        }
        
        $response_info = array();
        
        parse_str($response, $response_info);
        
        $json = array();
        
        if ($response_info['RESULT'] == '0') {
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
            
            CheckoutOrder::update(Session::p()->data['order_id'], Config::get('paypal_pro_pf_order_status_id'), $message);
            
            $json['success'] = Url::link('checkout/success');
        } else {
            switch ($response_info['RESULT']) {
                case '1':
                case '26':
                    $json['error'] = Lang::get('lang_error_config');
                    break;

                case '7':
                    $json['error'] = Lang::get('lang_error_address');
                    break;

                case '12':
                    $json['error'] = Lang::get('lang_error_declined');
                    break;

                case '23':
                case '24':
                    $json['error'] = Lang::get('lang_error_invalid');
                    break;

                default:
                    $json['error'] = Lang::get('lang_error_general');
                    break;
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
