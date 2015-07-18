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

namespace App\Controllers\Admin\Payment;

use App\Controllers\Controller;

class PayflowIframe extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/payflow_iframe');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('payflow_iframe', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['vendor'])) {
            $data['error_vendor'] = $this->error['vendor'];
        } else {
            $data['error_vendor'] = '';
        }
        
        if (isset($this->error['user'])) {
            $data['error_user'] = $this->error['user'];
        } else {
            $data['error_user'] = '';
        }
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['partner'])) {
            $data['error_partner'] = $this->error['partner'];
        } else {
            $data['error_partner'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/payflow_iframe');
        
        $data['action'] = Url::link('payment/payflow_iframe', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['payflow_iframe_vendor'])) {
            $data['payflow_iframe_vendor'] = Request::p()->post['payflow_iframe_vendor'];
        } else {
            $data['payflow_iframe_vendor'] = Config::get('payflow_iframe_vendor');
        }
        
        if (isset(Request::p()->post['payflow_iframe_user'])) {
            $data['payflow_iframe_user'] = Request::p()->post['payflow_iframe_user'];
        } else {
            $data['payflow_iframe_user'] = Config::get('payflow_iframe_user');
        }
        
        if (isset(Request::p()->post['payflow_iframe_password'])) {
            $data['payflow_iframe_password'] = Request::p()->post['payflow_iframe_password'];
        } else {
            $data['payflow_iframe_password'] = Config::get('payflow_iframe_password');
        }
        
        if (isset(Request::p()->post['payflow_iframe_partner'])) {
            $data['payflow_iframe_partner'] = Request::p()->post['payflow_iframe_partner'];
        } else {
            $data['payflow_iframe_partner'] = Config::get('payflow_iframe_partner');
        }
        
        if (isset(Request::p()->post['payflow_iframe_transaction_method'])) {
            $data['payflow_iframe_transaction_method'] = Request::p()->post['payflow_iframe_transaction_method'];
        } else {
            $data['payflow_iframe_transaction_method'] = Config::get('payflow_iframe_transaction_method');
        }
        
        if (isset(Request::p()->post['payflow_iframe_test'])) {
            $data['payflow_iframe_test'] = Request::p()->post['payflow_iframe_test'];
        } else {
            $data['payflow_iframe_test'] = Config::get('payflow_iframe_test');
        }
        
        if (isset(Request::p()->post['payflow_iframe_total'])) {
            $data['payflow_iframe_total'] = Request::p()->post['payflow_iframe_total'];
        } else {
            $data['payflow_iframe_total'] = Config::get('payflow_iframe_total');
        }
        
        Theme::model('locale/order_status');
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['payflow_iframe_order_status_id'])) {
            $data['payflow_iframe_order_status_id'] = Request::p()->post['payflow_iframe_order_status_id'];
        } else {
            $data['payflow_iframe_order_status_id'] = Config::get('payflow_iframe_order_status_id');
        }
        
        if (isset(Request::p()->post['payflow_iframe_geo_zone_id'])) {
            $data['payflow_iframe_geo_zone_id'] = Request::p()->post['payflow_iframe_geo_zone_id'];
        } else {
            $data['payflow_iframe_geo_zone_id'] = Config::get('payflow_iframe_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['payflow_iframe_status'])) {
            $data['payflow_iframe_status'] = Request::p()->post['payflow_iframe_status'];
        } else {
            $data['payflow_iframe_status'] = Config::get('payflow_iframe_status');
        }
        
        if (isset(Request::p()->post['payflow_iframe_sort_order'])) {
            $data['payflow_iframe_sort_order'] = Request::p()->post['payflow_iframe_sort_order'];
        } else {
            $data['payflow_iframe_sort_order'] = Config::get('payflow_iframe_sort_order');
        }
        
        if (isset(Request::p()->post['payflow_iframe_checkout_method'])) {
            $data['payflow_iframe_checkout_method'] = Request::p()->post['payflow_iframe_checkout_method'];
        } else {
            $data['payflow_iframe_checkout_method'] = Config::get('payflow_iframe_checkout_method');
        }
        
        if (isset(Request::p()->post['payflow_iframe_debug'])) {
            $data['payflow_iframe_debug'] = Request::p()->post['payflow_iframe_debug'];
        } else {
            $data['payflow_iframe_debug'] = Config::get('payflow_iframe_debug');
        }
        
        $data['cancel_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_cancel';
        $data['error_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_error';
        $data['return_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_return';
        $data['post_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_post';
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/payflow_iframe', $data));
    }
    
    public function install() {
        Theme::model('payment/payflow_iframe');
        PaymentPayflowIframe::install();
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function uninstall() {
        Theme::model('payment/payflow_iframe');
        PaymentPayflowIframe::uninstall();
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function refund() {
        Theme::model('payment/payflow_iframe');
        Theme::model('sale/order');
        $data = Theme::language('payment/payflow_iframe');
        
        $transaction = PaymentPayflowIframe::getTransaction(Request::p()->get['transaction_reference']);
        
        if ($transaction) {
            Theme::setTitle(Lang::get('lang_heading_refund'));
            
            Breadcrumb::add('lang_text_payment', 'module/payment');
            Breadcrumb::add('lang_heading_title', 'payment/payflow_iframe');
            Breadcrumb::add('lang_heading_refund', 'payment/payflow_iframe/refund', 'transaction_reference=' . Request::p()->get['transaction_reference']);
            
            $data['transaction_reference'] = $transaction['transaction_reference'];
            $data['transaction_amount'] = number_format($transaction['amount'], 2);
            $data['cancel'] = Url::link('sale/order/info', '' . 'order_id=' . $transaction['order_id'], 'SSL');
            
            Theme::loadjs('javascript/payment/payflow_iframe_refund', $data);
            
            $data = Theme::renderControllers($data);
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::setOutput(View::render('payment/payflow_iframe_refund', $data));
        } else {
            return new Action('error/not_found');
        }
    }
    
    public function do_refund() {
        Theme::model('payment/payflow_iframe');
        Lang::load('payment/payflow_iframe');
        $json = array();
        
        if (isset(Request::p()->post['transaction_reference']) && isset(Request::p()->post['amount'])) {
            
            $transaction = PaymentPayflowIframe::getTransaction(Request::p()->post['transaction_reference']);
            
            if ($transaction) {
                $call_data = array('TRXTYPE' => 'C', 'TENDER' => 'C', 'ORIGID' => $transaction['transaction_reference'], 'AMT' => Request::p()->post['amount'],);
                
                $result = PaymentPayflowIframe::call($call_data);
                
                if ($result['RESULT'] == 0) {
                    $json['success'] = Lang::get('lang_text_refund_issued');
                    
                    $filter = array('order_id' => $transaction['order_id'], 'type' => 'C', 'transaction_reference' => $result['PNREF'], 'amount' => Request::p()->post['amount'],);
                    
                    PaymentPayflowIframe::addTransaction($filter);
                } else {
                    $json['error'] = $result['RESPMSG'];
                }
            } else {
                $json['error'] = Lang::get('lang_error_missing_order');
            }
        } else {
            $json['error'] = Lang::get('lang_error_missing_data');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function capture() {
        Theme::model('payment/payflow_iframe');
        Theme::model('sale/order');
        Lang::load('payment/payflow_iframe');
        
        $json = array();
        
        if (isset(Request::p()->post['order_id']) && isset(Request::p()->post['amount']) && isset(Request::p()->post['complete'])) {
            $order_id = Request::p()->post['order_id'];
            $paypal_order = PaymentPayflowIframe::getOrder($order_id);
            $order_info = SaleOrder::getOrder($order_id);
            
            if ($paypal_order && $order_info) {
                if (Request::p()->post['complete'] == 1) {
                    $complete = 'Y';
                } else {
                    $complete = 'N';
                }
                
                $call_data = array('TRXTYPE' => 'D', 'TENDER' => 'C', 'ORIGID' => $paypal_order['transaction_reference'], 'AMT' => Request::p()->post['amount'], 'CAPTURECOMPLETE' => $complete,);
                
                $result = PaymentPayflowIframe::call($call_data);
                
                if ($result['RESULT'] == 0) {
                    
                    $filter = array('order_id' => $order_id, 'type' => 'D', 'transaction_reference' => $result['PNREF'], 'amount' => Request::p()->post['amount'],);
                    
                    PaymentPayflowIframe::addTransaction($filter);
                    PaymentPayflowIframe::updateOrderStatus($order_id, Request::p()->post['complete']);
                    
                    $actions = array();
                    
                    $actions[] = array('title' => Lang::get('lang_text_capture'), 'href' => Url::link('payment/payflow_iframe/refund', 'transaction_reference=' . $result['PNREF']);
                    
                    $json['success'] = array('transaction_type' => Lang::get('lang_text_capture'), 'transaction_reference' => $result['PNREF'], 'time' => date('Y-m-d H:i:s'), 'amount' => number_format(Request::p()->post['amount'], 2), 'actions' => $actions,);
                } else {
                    $json['error'] = $result['RESPMSG'];
                }
            } else {
                $json['error'] = Lang::get('lang_error_missing_order');
            }
        } else {
            $json['error'] = Lang::get('lang_error_missing_data');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function void() {
        Theme::model('payment/payflow_iframe');
        Lang::load('payment/payflow_iframe');
        
        $json = array();
        
        if (isset(Request::p()->post['order_id']) && Request::p()->post['order_id'] != '') {
            $order_id = Request::p()->post['order_id'];
            $paypal_order = PaymentPayflowIframe::getOrder($order_id);
            
            if ($paypal_order) {
                $call_data = array('TRXTYPE' => 'V', 'TENDER' => 'C', 'ORIGID' => $paypal_order['transaction_reference'],);
                
                $result = PaymentPayflowIframe::call($call_data);
                
                if ($result['RESULT'] == 0) {
                    $json['success'] = Lang::get('lang_text_void_success');
                    PaymentPayflowIframe::updateOrderStatus($order_id, 1);
                    
                    $filter = array('order_id' => $order_id, 'type' => 'V', 'transaction_reference' => $result['PNREF'], 'amount' => '',);
                    
                    PaymentPayflowIframe::addTransaction($filter);
                    PaymentPayflowIframe::updateOrderStatus($order_id, 1);
                    
                    $json['success'] = array('transaction_type' => Lang::get('lang_text_void'), 'transaction_reference' => $result['PNREF'], 'time' => date('Y-m-d H:i:s'), 'amount' => '0.00',);
                } else {
                    $json['error'] = $result['RESPMSG'];
                }
            } else {
                $json['error'] = Lang::get('lang_error_missing_order');
            }
        } else {
            $json['error'] = Lang::get('lang_error_missing_data');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function orderAction() {
        Theme::model('payment/payflow_iframe');
        $data = Theme::language('payment/payflow_iframe');
        
        $order_id = Request::p()->get['order_id'];
        
        $paypal_order = PaymentPayflowIframe::getOrder($order_id);
        
        if ($paypal_order) {
            $data['complete'] = $paypal_order['complete'];
            $data['order_id'] = Request::p()->get['order_id'];
            
            $data['transactions'] = array();
            
            $transactions = PaymentPayflowIframe::getTransactions($order_id);
            
            foreach ($transactions as $transaction) {
                $actions = array();
                
                switch ($transaction['transaction_type']) {
                    case 'V':
                        $transaction_type = Lang::get('lang_text_void');
                        break;

                    case 'S':
                        $transaction_type = Lang::get('lang_text_sale');
                        
                        $actions[] = array('title' => Lang::get('lang_text_refund'), 'href' => Url::link('payment/payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference']);
                        
                        break;

                    case 'D':
                        $transaction_type = Lang::get('lang_text_capture');
                        
                        $actions[] = array('title' => Lang::get('lang_text_refund'), 'href' => Url::link('payment/payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference']);
                        
                        break;

                    case 'A':
                        $transaction_type = Lang::get('lang_text_authorise');
                        break;

                    case 'C':
                        $transaction_type = Lang::get('lang_text_refund'); //
                        break;

                    default:
                        $transaction_type = '';
                        break;
                }
                
                $data['transactions'][] = array('transaction_reference' => $transaction['transaction_reference'], 'transaction_type' => $transaction_type, 'time' => $transaction['time'], 'amount' => $transaction['amount'], 'actions' => $actions,);
            }
            
            Theme::loadjs('javascript/payment/payflow_iframe_order', $data);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            $data['javascript'] = Theme::controller('common/javascript');
            
            Response::setOutput(View::render('payment/payflow_iframe_order', $data));
        }
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/payflow_iframe')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['payflow_iframe_vendor']) {
            $this->error['vendor'] = Lang::get('lang_error_vendor');
        }
        
        if (!Request::p()->post['payflow_iframe_user']) {
            $this->error['user'] = Lang::get('lang_error_user');
        }
        
        if (!Request::p()->post['payflow_iframe_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!Request::p()->post['payflow_iframe_partner']) {
            $this->error['partner'] = Lang::get('lang_error_partner');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
