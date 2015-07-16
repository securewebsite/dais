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

class PaypalProIframe extends Controller {
    
    public function index() {
        Theme::model('checkout/order');
        Theme::model('payment/paypal_pro_iframe');
        
        $data = Theme::language('payment/paypal_pro_iframe');
        
        if (Config::get('paypal_pro_iframe_checkout_method') == 'redirect') {
            $order_info = CheckoutOrder::getOrder($this->session->data['order_id']);
            
            $hosted_button_id = $this->constructButtonData($order_info);
            
            if (Config::get('paypal_pro_iframe_test')) {
                $data['url'] = 'https://securepayments.sandbox.paypal.com/cgi-bin/webscr';
            } else {
                $data['url'] = 'https://securepayments.paypal.com/cgi-bin/webscr';
            }
            
            if ($hosted_button_id) {
                $data['code'] = $hosted_button_id;
                $data['error_connection'] = '';
            } else {
                $data['error_connection'] = Lang::get('lang_error_connection');
            }
        }
        
        $data['checkout_method'] = Config::get('paypal_pro_iframe_checkout_method');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('payment/paypal_pro_iframe', $data);
    }
    
    public function create() {
        $data = Theme::language('payment/paypal_pro_iframe');
        Theme::model('checkout/order');
        Theme::model('payment/paypal_pro_iframe');
        
        $order_info = CheckoutOrder::getOrder($this->session->data['order_id']);
        
        $hosted_button_id = $this->constructButtonData($order_info);
        
        if ($hosted_button_id) {
            $data['code'] = $hosted_button_id;
            
            if (Config::get('paypal_pro_iframe_test')) {
                $data['url'] = 'https://securepayments.sandbox.paypal.com/cgi-bin/webscr';
            } else {
                $data['url'] = 'https://securepayments.paypal.com/cgi-bin/webscr';
            }
            
            $data['error_connection'] = '';
        } else {
            $data['error_connection'] = Lang::get('lang_error_connection');
        }
        
        if (file_exists(Config::get('path.public') . 'asset/' . Config::get('config_theme') . '/css/stylesheet.css')) {
            $data['stylesheet'] = '/asset/' . Config::get('config_theme') . '/css/stylesheet.css';
        } else {
            $data['stylesheet'] = '/asset/default/css/stylesheet.css';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::render('payment/paypal_pro_iframe_body', $data));
    }
    
    public function notify() {
        Theme::model('payment/paypal_pro_iframe');
        
        if (isset($this->request->post['custom'])) {
            $order_id = $this->encryption->decrypt($this->request->post['custom']);
        } else {
            $order_id = 0;
        }
        
        Theme::model('checkout/order');
        
        $order_info = CheckoutOrder::getOrder($order_id);
        
        if ($order_info) {
            $request = 'cmd=_notify-validate';
            
            foreach ($this->request->post as $key => $value) {
                $request.= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }
            
            if (!Config::get('paypal_pro_iframe_test')) {
                $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
            } else {
                $curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
            }
            
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($curl);
            
            if (curl_errno($curl)) {
                PaymentPaypalProIframe::log('paypal_pro_iframe_test :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
            } else {
                PaymentPaypalProIframe::log('paypal_pro_iframe_test :: IPN REQUEST: ' . $request);
                PaymentPaypalProIframe::log('paypal_pro_iframe_test :: IPN RESPONSE: ' . $response);
                
                if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {
                    $order_status_id = Config::get('paypal_pro_iframe_canceled_reversal_status_id');
                    
                    switch ($this->request->post['payment_status']) {
                        case 'Canceled_Reversal':
                            $order_status_id = Config::get('paypal_pro_iframe_canceled_reversal_status_id');
                            break;

                        case 'Completed':
                            $order_status_id = Config::get('paypal_pro_iframe_completed_status_id');
                            break;

                        case 'Denied':
                            $order_status_id = Config::get('paypal_pro_iframe_denied_status_id');
                            break;

                        case 'Expired':
                            $order_status_id = Config::get('paypal_pro_iframe_expired_status_id');
                            break;

                        case 'Failed':
                            $order_status_id = Config::get('paypal_pro_iframe_failed_status_id');
                            break;

                        case 'Pending':
                            $order_status_id = Config::get('paypal_pro_iframe_pending_status_id');
                            break;

                        case 'Processed':
                            $order_status_id = Config::get('paypal_pro_iframe_processed_status_id');
                            break;

                        case 'Refunded':
                            $order_status_id = Config::get('paypal_pro_iframe_refunded_status_id');
                            break;

                        case 'Reversed':
                            $order_status_id = Config::get['paypal_pro_iframe_reversed_status_id'];
                            break;

                        case 'Voided':
                            $order_status_id = Config::get('paypal_pro_iframe_voided_status_id');
                            break;
                    }
                    
                    if (!$order_info['order_status_id']) {
                        $paypal_order_data = array('order_id' => $order_id, 'capture_status' => (Config::get('paypal_pro_iframe_transaction_method') == 'sale' ? 'Complete' : 'NotComplete'), 'currency_code' => $this->request->post['mc_currency'], 'authorization_id' => $this->request->post['txn_id'], 'total' => $this->request->post['mc_gross'],);
                        
                        $paypal_iframe_order_id = PaymentPaypalProIframe::addOrder($paypal_order_data);
                        
                        $paypal_transaction_data = array('paypal_iframe_order_id' => $paypal_iframe_order_id, 'transaction_id' => $this->request->post['txn_id'], 'parent_transaction_id' => '', 'note' => '', 'msgsubid' => '', 'receipt_id' => $this->request->post['receipt_id'], 'payment_type' => $this->request->post['payment_type'], 'payment_status' => $this->request->post['payment_status'], 'pending_reason' => (isset($this->request->post['pending_reason']) ? $this->request->post['pending_reason'] : ''), 'transaction_entity' => (Config::get('paypal_pro_iframe_transaction_method') == 'sale' ? 'payment' : 'auth'), 'amount' => $this->request->post['mc_gross'], 'debug_data' => json_encode($this->request->post),);
                        
                        PaymentPaypalProIframe::addTransaction($paypal_transaction_data);
                        
                        Theme::listen(__CLASS__, __FUNCTION__);
                        
                        CheckoutOrder::confirm($order_id, $order_status_id);
                    } else {
                        Theme::listen(__CLASS__, __FUNCTION__);
                        
                        CheckoutOrder::update($order_id, $order_status_id);
                    }
                } else {
                    Theme::listen(__CLASS__, __FUNCTION__);
                    
                    CheckoutOrder::confirm($order_id, Config::get('config_order_status_id'));
                }
            }
            
            curl_close($curl);
        }
    }
    
    private function constructButtonData($order_info) {
        $s_data = array();
        $s_data['METHOD'] = 'BMCreateButton';
        $s_data['VERSION'] = '65.2';
        $s_data['BUTTONCODE'] = 'TOKEN';
        
        $s_data['BUTTONLANGUAGE'] = 'en';
        $s_data['BUTTONSOURCE'] = 'Dais_Cart_WPP';
        
        $s_data['USER'] = Config::get('paypal_pro_iframe_user');
        $s_data['SIGNATURE'] = Config::get('paypal_pro_iframe_sig');
        $s_data['PWD'] = Config::get('paypal_pro_iframe_password');
        
        $s_data['BUTTONTYPE'] = 'PAYMENT';
        $s_data['L_BUTTONVAR0'] = 'sub_total=' . Currency::format($order_info['total'], $order_info['currency_code'], false, false);
        $s_data['L_BUTTONVAR1'] = 'tax=0.00';
        $s_data['L_BUTTONVAR2'] = 'shipping=0.00';
        $s_data['L_BUTTONVAR3'] = 'handling=0.00';
        
        if (Cart::hasShipping()) {
            $s_data['L_BUTTONVAR4'] = 'first_name=' . urlencode($order_info['shipping_firstname']);
            $s_data['L_BUTTONVAR5'] = 'last_name=' . urlencode($order_info['shipping_lastname']);
            $s_data['L_BUTTONVAR6'] = 'address1=' . urlencode($order_info['shipping_address_1']);
            $s_data['L_BUTTONVAR7'] = 'address2=' . urlencode($order_info['shipping_address_2']);
            $s_data['L_BUTTONVAR8'] = 'city=' . urlencode($order_info['shipping_city']);
            $s_data['L_BUTTONVAR9'] = 'state=' . urlencode($order_info['shipping_zone']);
            $s_data['L_BUTTONVAR10'] = 'zip=' . urlencode($order_info['shipping_postcode']);
            $s_data['L_BUTTONVAR11'] = 'country=' . urlencode($order_info['shipping_iso_code_2']);
        } else {
            $s_data['L_BUTTONVAR4'] = 'first_name=' . urlencode($order_info['payment_firstname']);
            $s_data['L_BUTTONVAR5'] = 'last_name=' . urlencode($order_info['payment_lastname']);
            $s_data['L_BUTTONVAR6'] = 'address1=' . urlencode($order_info['payment_address_1']);
            $s_data['L_BUTTONVAR7'] = 'address2=' . urlencode($order_info['payment_address_2']);
            $s_data['L_BUTTONVAR8'] = 'city=' . urlencode($order_info['payment_city']);
            $s_data['L_BUTTONVAR9'] = 'state=' . urlencode($order_info['payment_zone']);
            $s_data['L_BUTTONVAR10'] = 'zip=' . urlencode($order_info['payment_postcode']);
            $s_data['L_BUTTONVAR11'] = 'country=' . urlencode($order_info['payment_iso_code_2']);
        }
        
        $s_data['L_BUTTONVAR12'] = 'billing_first_name=' . urlencode($order_info['payment_firstname']);
        $s_data['L_BUTTONVAR13'] = 'billing_last_name=' . urlencode($order_info['payment_lastname']);
        $s_data['L_BUTTONVAR14'] = 'billing_address1=' . urlencode($order_info['payment_address_1']);
        $s_data['L_BUTTONVAR15'] = 'billing_address2=' . urlencode($order_info['payment_address_2']);
        $s_data['L_BUTTONVAR16'] = 'billing_city=' . urlencode($order_info['payment_city']);
        $s_data['L_BUTTONVAR17'] = 'billing_state=' . urlencode($order_info['payment_zone']);
        $s_data['L_BUTTONVAR18'] = 'billing_zip=' . urlencode($order_info['payment_postcode']);
        $s_data['L_BUTTONVAR19'] = 'billing_country=' . urlencode($order_info['payment_iso_code_2']);
        
        $s_data['L_BUTTONVAR20'] = 'notify_url=' . Url::link('payment/paypal_pro_iframe/notify', '', 'SSL');
        $s_data['L_BUTTONVAR21'] = 'cancel_return=' . Url::link('checkout/checkout', '', 'SSL');
        $s_data['L_BUTTONVAR22'] = 'paymentaction=' . Config::get('paypal_pro_iframe_transaction_method');
        $s_data['L_BUTTONVAR23'] = 'currency_code=' . urlencode($order_info['currency_code']);
        $s_data['L_BUTTONVAR26'] = 'showBillingAddress=false';
        $s_data['L_BUTTONVAR27'] = 'showShippingAddress=false';
        $s_data['L_BUTTONVAR28'] = 'showBillingEmail=false';
        $s_data['L_BUTTONVAR29'] = 'showBillingPhone=false';
        $s_data['L_BUTTONVAR30'] = 'showCustomerName=true';
        $s_data['L_BUTTONVAR31'] = 'showCardInfo=true';
        $s_data['L_BUTTONVAR32'] = 'showHostedThankyouPage=false';
        $s_data['L_BUTTONVAR33'] = 'bn=GBD';
        $s_data['L_BUTTONVAR35'] = 'address_override=true';
        $s_data['L_BUTTONVAR36'] = 'cpp_header_image=Red';
        $s_data['L_BUTTONVAR44'] = 'bodyBgColor=#AEAEAE';
        $s_data['L_BUTTONVAR47'] = 'PageTitleTextColor=Blue';
        $s_data['L_BUTTONVAR48'] = 'PageCollapseBgColor=#AEAEAE';
        $s_data['L_BUTTONVAR49'] = 'PageCollapseTextColor=#AEAEAE';
        $s_data['L_BUTTONVAR50'] = 'PageButtonBgColor=#AEAEAE';
        $s_data['L_BUTTONVAR51'] = 'orderSummaryBgColor=#AEAEAE';
        $s_data['L_BUTTONVAR55'] = 'template=templateD';
        $s_data['L_BUTTONVAR56'] = 'return=' . Url::link('checkout/success', '', 'SSL');
        $s_data['L_BUTTONVAR57'] = 'custom=' . $this->encryption->encrypt($order_info['order_id']);
        
        if (Config::get('paypal_pro_iframe_test')) {
            $url = 'https://api-3t.sandbox.paypal.com/nvp';
        } else {
            $url = 'https://api-3t.paypal.com/nvp';
        }
        
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_PORT, 443);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($s_data, '', "&"));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-VPS-REQUEST-ID: ' . md5($order_info['order_id'] . mt_rand())));
        
        $response = curl_exec($curl);
        
        $response_data = array();
        
        parse_str($response, $response_data);
        
        $response_data = Theme::listen(__CLASS__, __FUNCTION__, $response_data);
        
        PaymentPaypalProIframe::log(print_r(serialize($response_data), 1));
        
        curl_close($curl);
        
        if (!$response || !isset($response_data['HOSTEDBUTTONID'])) {
            return false;
        } else {
            return $response_data['HOSTEDBUTTONID'];
        }
    }
}
