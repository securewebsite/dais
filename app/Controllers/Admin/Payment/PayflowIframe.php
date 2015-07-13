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
use Dais\Base\Action;

class PayflowIframe extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/payflow_iframe');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payflowiframe', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $data['action'] = Url::link('payment/payflow_iframe', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['payflowiframe_vendor'])) {
            $data['payflowiframe_vendor'] = $this->request->post['payflowiframe_vendor'];
        } else {
            $data['payflowiframe_vendor'] = Config::get('payflowiframe_vendor');
        }
        
        if (isset($this->request->post['payflowiframe_user'])) {
            $data['payflowiframe_user'] = $this->request->post['payflowiframe_user'];
        } else {
            $data['payflowiframe_user'] = Config::get('payflowiframe_user');
        }
        
        if (isset($this->request->post['payflowiframe_password'])) {
            $data['payflowiframe_password'] = $this->request->post['payflowiframe_password'];
        } else {
            $data['payflowiframe_password'] = Config::get('payflowiframe_password');
        }
        
        if (isset($this->request->post['payflowiframe_partner'])) {
            $data['payflowiframe_partner'] = $this->request->post['payflowiframe_partner'];
        } else {
            $data['payflowiframe_partner'] = Config::get('payflowiframe_partner');
        }
        
        if (isset($this->request->post['payflowiframe_transaction_method'])) {
            $data['payflowiframe_transaction_method'] = $this->request->post['payflowiframe_transaction_method'];
        } else {
            $data['payflowiframe_transaction_method'] = Config::get('payflowiframe_transaction_method');
        }
        
        if (isset($this->request->post['payflowiframe_test'])) {
            $data['payflowiframe_test'] = $this->request->post['payflowiframe_test'];
        } else {
            $data['payflowiframe_test'] = Config::get('payflowiframe_test');
        }
        
        if (isset($this->request->post['payflowiframe_total'])) {
            $data['payflowiframe_total'] = $this->request->post['payflowiframe_total'];
        } else {
            $data['payflowiframe_total'] = Config::get('payflowiframe_total');
        }
        
        Theme::model('locale/order_status');
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['payflowiframe_order_status_id'])) {
            $data['payflowiframe_order_status_id'] = $this->request->post['payflowiframe_order_status_id'];
        } else {
            $data['payflowiframe_order_status_id'] = Config::get('payflowiframe_order_status_id');
        }
        
        if (isset($this->request->post['payflowiframe_geo_zone_id'])) {
            $data['payflowiframe_geo_zone_id'] = $this->request->post['payflowiframe_geo_zone_id'];
        } else {
            $data['payflowiframe_geo_zone_id'] = Config::get('payflowiframe_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['payflowiframe_status'])) {
            $data['payflowiframe_status'] = $this->request->post['payflowiframe_status'];
        } else {
            $data['payflowiframe_status'] = Config::get('payflowiframe_status');
        }
        
        if (isset($this->request->post['payflowiframe_sort_order'])) {
            $data['payflowiframe_sort_order'] = $this->request->post['payflowiframe_sort_order'];
        } else {
            $data['payflowiframe_sort_order'] = Config::get('payflowiframe_sort_order');
        }
        
        if (isset($this->request->post['payflowiframe_checkout_method'])) {
            $data['payflowiframe_checkout_method'] = $this->request->post['payflowiframe_checkout_method'];
        } else {
            $data['payflowiframe_checkout_method'] = Config::get('payflowiframe_checkout_method');
        }
        
        if (isset($this->request->post['payflowiframe_debug'])) {
            $data['payflowiframe_debug'] = $this->request->post['payflowiframe_debug'];
        } else {
            $data['payflowiframe_debug'] = Config::get('payflowiframe_debug');
        }
        
        $data['cancel_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_cancel';
        $data['error_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_error';
        $data['return_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_return';
        $data['post_url'] = Config::get('https.public') . 'payment/payflow_iframe/pp_post';
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/payflow_iframe', $data));
    }
    
    public function install() {
        Theme::model('payment/payflow_iframe');
        $this->model_payment_payflow_iframe->install();
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function uninstall() {
        Theme::model('payment/payflow_iframe');
        $this->model_payment_payflow_iframe->uninstall();
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function refund() {
        Theme::model('payment/payflow_iframe');
        Theme::model('sale/order');
        $data = Theme::language('payment/payflow_iframe');
        
        $transaction = $this->model_payment_payflow_iframe->getTransaction($this->request->get['transaction_reference']);
        
        if ($transaction) {
            Theme::setTitle(Lang::get('lang_heading_refund'));
            
            Breadcrumb::add('lang_text_payment', 'module/payment');
            Breadcrumb::add('lang_heading_title', 'payment/payflow_iframe');
            Breadcrumb::add('lang_heading_refund', 'payment/payflow_iframe/refund', 'transaction_reference=' . $this->request->get['transaction_reference']);
            
            $data['transaction_reference'] = $transaction['transaction_reference'];
            $data['transaction_amount'] = number_format($transaction['amount'], 2);
            $data['cancel'] = Url::link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $transaction['order_id'], 'SSL');
            
            $data['token'] = $this->session->data['token'];
            
            Theme::loadjs('javascript/payment/payflowiframe_refund', $data);
            
            $data = Theme::render_controllers($data);
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::setOutput(Theme::view('payment/payflowiframe_refund', $data));
        } else {
            return new Action('error/not_found');
        }
    }
    
    public function do_refund() {
        Theme::model('payment/payflow_iframe');
        Lang::load('payment/payflow_iframe');
        $json = array();
        
        if (isset($this->request->post['transaction_reference']) && isset($this->request->post['amount'])) {
            
            $transaction = $this->model_payment_payflow_iframe->getTransaction($this->request->post['transaction_reference']);
            
            if ($transaction) {
                $call_data = array('TRXTYPE' => 'C', 'TENDER' => 'C', 'ORIGID' => $transaction['transaction_reference'], 'AMT' => $this->request->post['amount'],);
                
                $result = $this->model_payment_payflow_iframe->call($call_data);
                
                if ($result['RESULT'] == 0) {
                    $json['success'] = Lang::get('lang_text_refund_issued');
                    
                    $filter = array('order_id' => $transaction['order_id'], 'type' => 'C', 'transaction_reference' => $result['PNREF'], 'amount' => $this->request->post['amount'],);
                    
                    $this->model_payment_payflow_iframe->addTransaction($filter);
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
        
        if (isset($this->request->post['order_id']) && isset($this->request->post['amount']) && isset($this->request->post['complete'])) {
            $order_id = $this->request->post['order_id'];
            $paypal_order = $this->model_payment_payflow_iframe->getOrder($order_id);
            $order_info = $this->model_sale_order->getOrder($order_id);
            
            if ($paypal_order && $order_info) {
                if ($this->request->post['complete'] == 1) {
                    $complete = 'Y';
                } else {
                    $complete = 'N';
                }
                
                $call_data = array('TRXTYPE' => 'D', 'TENDER' => 'C', 'ORIGID' => $paypal_order['transaction_reference'], 'AMT' => $this->request->post['amount'], 'CAPTURECOMPLETE' => $complete,);
                
                $result = $this->model_payment_payflow_iframe->call($call_data);
                
                if ($result['RESULT'] == 0) {
                    
                    $filter = array('order_id' => $order_id, 'type' => 'D', 'transaction_reference' => $result['PNREF'], 'amount' => $this->request->post['amount'],);
                    
                    $this->model_payment_payflow_iframe->addTransaction($filter);
                    $this->model_payment_payflow_iframe->updateOrderStatus($order_id, $this->request->post['complete']);
                    
                    $actions = array();
                    
                    $actions[] = array('title' => Lang::get('lang_text_capture'), 'href' => Url::link('payment/payflow_iframe/refund', 'transaction_reference=' . $result['PNREF'] . '&token=' . $this->session->data['token']),);
                    
                    $json['success'] = array('transaction_type' => Lang::get('lang_text_capture'), 'transaction_reference' => $result['PNREF'], 'time' => date('Y-m-d H:i:s'), 'amount' => number_format($this->request->post['amount'], 2), 'actions' => $actions,);
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
        
        if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
            $order_id = $this->request->post['order_id'];
            $paypal_order = $this->model_payment_payflow_iframe->getOrder($order_id);
            
            if ($paypal_order) {
                $call_data = array('TRXTYPE' => 'V', 'TENDER' => 'C', 'ORIGID' => $paypal_order['transaction_reference'],);
                
                $result = $this->model_payment_payflow_iframe->call($call_data);
                
                if ($result['RESULT'] == 0) {
                    $json['success'] = Lang::get('lang_text_void_success');
                    $this->model_payment_payflow_iframe->updateOrderStatus($order_id, 1);
                    
                    $filter = array('order_id' => $order_id, 'type' => 'V', 'transaction_reference' => $result['PNREF'], 'amount' => '',);
                    
                    $this->model_payment_payflow_iframe->addTransaction($filter);
                    $this->model_payment_payflow_iframe->updateOrderStatus($order_id, 1);
                    
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
        
        $order_id = $this->request->get['order_id'];
        
        $paypal_order = $this->model_payment_payflow_iframe->getOrder($order_id);
        
        if ($paypal_order) {
            $data['complete'] = $paypal_order['complete'];
            $data['order_id'] = $this->request->get['order_id'];
            $data['token'] = $this->request->get['token'];
            
            $data['transactions'] = array();
            
            $transactions = $this->model_payment_payflow_iframe->getTransactions($order_id);
            
            foreach ($transactions as $transaction) {
                $actions = array();
                
                switch ($transaction['transaction_type']) {
                    case 'V':
                        $transaction_type = Lang::get('lang_text_void');
                        break;

                    case 'S':
                        $transaction_type = Lang::get('lang_text_sale');
                        
                        $actions[] = array('title' => Lang::get('lang_text_refund'), 'href' => Url::link('payment/payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference'] . '&token=' . $this->session->data['token']),);
                        
                        break;

                    case 'D':
                        $transaction_type = Lang::get('lang_text_capture');
                        
                        $actions[] = array('title' => Lang::get('lang_text_refund'), 'href' => Url::link('payment/payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference'] . '&token=' . $this->session->data['token']),);
                        
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
            
            Theme::loadjs('javascript/payment/payflowiframe_order', $data);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            $data['javascript'] = Theme::controller('common/javascript');
            
            Response::setOutput(Theme::view('payment/payflowiframe_order', $data));
        }
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/payflowiframe')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['payflowiframe_vendor']) {
            $this->error['vendor'] = Lang::get('lang_error_vendor');
        }
        
        if (!$this->request->post['payflowiframe_user']) {
            $this->error['user'] = Lang::get('lang_error_user');
        }
        
        if (!$this->request->post['payflowiframe_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!$this->request->post['payflowiframe_partner']) {
            $this->error['partner'] = Lang::get('lang_error_partner');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}