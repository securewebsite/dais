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

class PaypalProIframe extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/paypal_pro_iframe');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypal_pro_iframe', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['sig'])) {
            $data['error_sig'] = $this->error['sig'];
        } else {
            $data['error_sig'] = '';
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
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_pro_iframe');
        
        $data['action'] = Url::link('payment/paypal_pro_iframe', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypal_pro_iframe_sig'])) {
            $data['paypal_pro_iframe_sig'] = $this->request->post['paypal_pro_iframe_sig'];
        } else {
            $data['paypal_pro_iframe_sig'] = Config::get('paypal_pro_iframe_sig');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_user'])) {
            $data['paypal_pro_iframe_user'] = $this->request->post['paypal_pro_iframe_user'];
        } else {
            $data['paypal_pro_iframe_user'] = Config::get('paypal_pro_iframe_user');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_password'])) {
            $data['paypal_pro_iframe_password'] = $this->request->post['paypal_pro_iframe_password'];
        } else {
            $data['paypal_pro_iframe_password'] = Config::get('paypal_pro_iframe_password');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_transaction_method'])) {
            $data['paypal_pro_iframe_transaction_method'] = $this->request->post['paypal_pro_iframe_transaction_method'];
        } else {
            $data['paypal_pro_iframe_transaction_method'] = Config::get('paypal_pro_iframe_transaction_method');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_test'])) {
            $data['paypal_pro_iframe_test'] = $this->request->post['paypal_pro_iframe_test'];
        } else {
            $data['paypal_pro_iframe_test'] = Config::get('paypal_pro_iframe_test');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_total'])) {
            $data['paypal_pro_iframe_total'] = $this->request->post['paypal_pro_iframe_total'];
        } else {
            $data['paypal_pro_iframe_total'] = Config::get('paypal_pro_iframe_total');
        }
        
        Theme::model('localization/order_status');
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypal_pro_iframe_canceled_reversal_status_id'])) {
            $data['paypal_pro_iframe_canceled_reversal_status_id'] = $this->request->post['paypal_pro_iframe_canceled_reversal_status_id'];
        } else {
            $data['paypal_pro_iframe_canceled_reversal_status_id'] = Config::get('paypal_pro_iframe_canceled_reversal_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_completed_status_id'])) {
            $data['paypal_pro_iframe_completed_status_id'] = $this->request->post['paypal_pro_iframe_completed_status_id'];
        } else {
            $data['paypal_pro_iframe_completed_status_id'] = Config::get('paypal_pro_iframe_completed_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_denied_status_id'])) {
            $data['paypal_pro_iframe_denied_status_id'] = $this->request->post['paypal_pro_iframe_denied_status_id'];
        } else {
            $data['paypal_pro_iframe_denied_status_id'] = Config::get('paypal_pro_iframe_denied_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_expired_status_id'])) {
            $data['paypal_pro_iframe_expired_status_id'] = $this->request->post['paypal_pro_iframe_expired_status_id'];
        } else {
            $data['paypal_pro_iframe_expired_status_id'] = Config::get('paypal_pro_iframe_expired_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_failed_status_id'])) {
            $data['paypal_pro_iframe_failed_status_id'] = $this->request->post['paypal_pro_iframe_failed_status_id'];
        } else {
            $data['paypal_pro_iframe_failed_status_id'] = Config::get('paypal_pro_iframe_failed_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_pending_status_id'])) {
            $data['paypal_pro_iframe_pending_status_id'] = $this->request->post['paypal_pro_iframe_pending_status_id'];
        } else {
            $data['paypal_pro_iframe_pending_status_id'] = Config::get('paypal_pro_iframe_pending_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_processed_status_id'])) {
            $data['paypal_pro_iframe_processed_status_id'] = $this->request->post['paypal_pro_iframe_processed_status_id'];
        } else {
            $data['paypal_pro_iframe_processed_status_id'] = Config::get('paypal_pro_iframe_processed_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_refunded_status_id'])) {
            $data['paypal_pro_iframe_refunded_status_id'] = $this->request->post['paypal_pro_iframe_refunded_status_id'];
        } else {
            $data['paypal_pro_iframe_refunded_status_id'] = Config::get('paypal_pro_iframe_refunded_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_reversed_status_id'])) {
            $data['paypal_pro_iframe_reversed_status_id'] = $this->request->post['paypal_pro_iframe_reversed_status_id'];
        } else {
            $data['paypal_pro_iframe_reversed_status_id'] = Config::get('paypal_pro_iframe_reversed_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_voided_status_id'])) {
            $data['paypal_pro_iframe_voided_status_id'] = $this->request->post['paypal_pro_iframe_voided_status_id'];
        } else {
            $data['paypal_pro_iframe_voided_status_id'] = Config::get('paypal_pro_iframe_voided_status_id');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_geo_zone_id'])) {
            $data['paypal_pro_iframe_geo_zone_id'] = $this->request->post['paypal_pro_iframe_geo_zone_id'];
        } else {
            $data['paypal_pro_iframe_geo_zone_id'] = Config::get('paypal_pro_iframe_geo_zone_id');
        }
        
        Theme::model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypal_pro_iframe_status'])) {
            $data['paypal_pro_iframe_status'] = $this->request->post['paypal_pro_iframe_status'];
        } else {
            $data['paypal_pro_iframe_status'] = Config::get('paypal_pro_iframe_status');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_sort_order'])) {
            $data['paypal_pro_iframe_sort_order'] = $this->request->post['paypal_pro_iframe_sort_order'];
        } else {
            $data['paypal_pro_iframe_sort_order'] = Config::get('paypal_pro_iframe_sort_order');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_checkout_method'])) {
            $data['paypal_pro_iframe_checkout_method'] = $this->request->post['paypal_pro_iframe_checkout_method'];
        } else {
            $data['paypal_pro_iframe_checkout_method'] = Config::get('paypal_pro_iframe_checkout_method');
        }
        
        if (isset($this->request->post['paypal_pro_iframe_debug'])) {
            $data['paypal_pro_iframe_debug'] = $this->request->post['paypal_pro_iframe_debug'];
        } else {
            $data['paypal_pro_iframe_debug'] = Config::get('paypal_pro_iframe_debug');
        }
        
        $data['ipn_url'] = Config::get('https.public') . 'payment/paypal_pro_iframe/notify';
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_pro_iframe', $data));
    }
    
    public function install() {
        Theme::model('payment/paypal_pro_iframe');
        $this->model_payment_paypal_pro_iframe->install();
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function uninstall() {
        Theme::model('payment/paypal_pro_iframe');
        $this->model_payment_paypal_pro_iframe->uninstall();
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function refund() {
        $data = Theme::language('payment/paypal_pro_iframe');
        Theme::model('payment/paypal_pro_iframe');
        
        Theme::setTitle(Lang::get('lang_text_refund'));
        
        Breadcrumb::add('lang_heading_title', 'payment/paypal_pro_iframe');
        Breadcrumb::add('lang_text_refund', 'payment/paypal_pro_iframe/refund');
        
        //button actions
        $data['action'] = Url::link('payment/paypal_pro_iframe/doRefund', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->get['order_id'])) {
            $data['cancel'] = Url::link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
        } else {
            $data['cancel'] = '';
        }
        
        $data['transaction_id'] = $this->request->get['transaction_id'];
        
        $pp_transaction = $this->model_payment_paypal_pro_iframe->getTransaction($this->request->get['transaction_id']);
        
        $data['amount_original'] = $pp_transaction['AMT'];
        $data['currency_code'] = $pp_transaction['CURRENCYCODE'];
        
        $refunded = number_format($this->model_payment_paypal_pro_iframe->totalRefundedTransaction($this->request->get['transaction_id']), 2);
        
        if ($refunded != 0.00) {
            $data['refund_available'] = number_format($data['amount_original'] + $refunded, 2);
            $data['attention'] = Lang::get('lang_text_current_refunds') . ': ' . $data['refund_available'];
        } else {
            $data['refund_available'] = '';
            $data['attention'] = '';
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }
        
        Theme::loadjs('javascript/payment/paypal_pro_iframe_refund', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_pro_iframe_refund', $data));
    }
    
    public function doRefund() {
        
        /**
         * used to issue a refund for a captured payment
         *
         * refund can be full or partial
         */
        if (isset($this->request->post['transaction_id']) && isset($this->request->post['refund_full'])) {
            
            Theme::model('payment/paypal_pro_iframe');
            Lang::load('payment/paypal_pro_iframe');
            
            if ($this->request->post['refund_full'] == 0 && $this->request->post['amount'] == 0) {
                $this->session->data['error'] = Lang::get('lang_error_partial_amt');
            } else {
                $order_id = $this->model_payment_paypal_pro_iframe->getOrderId($this->request->post['transaction_id']);
                $paypal_order = $this->model_payment_paypal_pro_iframe->getOrder($order_id);
                
                if ($paypal_order) {
                    $call_data = array();
                    $call_data['METHOD'] = 'RefundTransaction';
                    $call_data['TRANSACTIONID'] = $this->request->post['transaction_id'];
                    $call_data['NOTE'] = urlencode($this->request->post['refund_message']);
                    $call_data['MSGSUBID'] = uniqid(mt_rand(), true);
                    
                    $current_transaction = $this->model_payment_paypal_pro_iframe->getLocalTransaction($this->request->post['transaction_id']);
                    
                    if ($this->request->post['refund_full'] == 1) {
                        $call_data['REFUNDTYPE'] = 'Full';
                    } else {
                        $call_data['REFUNDTYPE'] = 'Partial';
                        $call_data['AMT'] = number_format($this->request->post['amount'], 2);
                        $call_data['CURRENCYCODE'] = $this->request->post['currency_code'];
                    }
                    
                    $result = $this->model_payment_paypal_pro_iframe->call($call_data);
                    
                    $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $this->request->post['transaction_id'], 'note' => $this->request->post['refund_message'], 'msgsubid' => $call_data['MSGSUBID'], 'receipt_id' => '', 'payment_type' => '', 'payment_status' => 'Refunded', 'transaction_entity' => 'payment', 'pending_reason' => '', 'amount' => '-' . (isset($call_data['AMT']) ? $call_data['AMT'] : $current_transaction['amount']), 'debug_data' => json_encode($result),);
                    
                    if ($result === false) {
                        $transaction['payment_status'] = 'Failed';
                        $this->model_payment_paypal_pro_iframe->addTransaction($transaction, $call_data);
                        
                        Theme::listen(__CLASS__, __FUNCTION__);
                        
                        Response::redirect(Url::link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $paypal_order['order_id'], 'SSL'));
                    } else if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                        
                        $transaction['transaction_id'] = $result['REFUNDTRANSACTIONID'];
                        $transaction['payment_type'] = $result['REFUNDSTATUS'];
                        $transaction['pending_reason'] = $result['PENDINGREASON'];
                        $transaction['amount'] = '-' . $result['GROSSREFUNDAMT'];
                        
                        $this->model_payment_paypal_pro_iframe->addTransaction($transaction);
                        
                        if ($result['TOTALREFUNDEDAMOUNT'] == $this->request->post['amount_original']) {
                            $this->model_payment_paypal_pro_iframe->updateRefundTransaction($this->request->post['transaction_id'], 'Refunded');
                        } else {
                            $this->model_payment_paypal_pro_iframe->updateRefundTransaction($this->request->post['transaction_id'], 'Partially-Refunded');
                        }
                        
                        Theme::listen(__CLASS__, __FUNCTION__);
                        
                        //redirect back to the order
                        Response::redirect(Url::link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $paypal_order['order_id'], 'SSL'));
                    } else {
                        $this->model_payment_paypal_pro_iframe->log(json_encode($result));
                        $this->session->data['error'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error') . (isset($result['L_LONGMESSAGE0']) ? '<br />' . $result['L_LONGMESSAGE0'] : '');
                        
                        Theme::listen(__CLASS__, __FUNCTION__);
                        
                        Response::redirect(Url::link('payment/paypal_pro_iframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
                    }
                } else {
                    $this->session->data['error'] = Lang::get('lang_error_data_missing');
                    
                    Theme::listen(__CLASS__, __FUNCTION__);
                    
                    Response::redirect(Url::link('payment/paypal_pro_iframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
                }
            }
        } else {
            $this->session->data['error'] = Lang::get('lang_error_data');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect(Url::link('payment/paypal_pro_iframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
        }
    }
    
    public function reauthorise() {
        Lang::load('payment/paypal_pro_iframe');
        Theme::model('payment/paypal_pro_iframe');
        
        $json = array();
        
        if (isset($this->request->post['order_id'])) {
            $paypal_order = $this->model_payment_paypal_pro_iframe->getOrder($this->request->post['order_id']);
            
            $call_data = array();
            $call_data['METHOD'] = 'DoReauthorization';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            $call_data['AMT'] = number_format($paypal_order['total'], 2);
            $call_data['CURRENCYCODE'] = $paypal_order['currency_code'];
            
            $result = $this->model_payment_paypal_pro_iframe->call($call_data);
            
            if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $this->model_payment_paypal_pro_iframe->updateAuthorizationId($paypal_order['paypal_iframe_order_id'], $result['AUTHORIZATIONID']);
                
                $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => '', 'receipt_id' => '', 'payment_type' => 'instant', 'payment_status' => $result['PAYMENTSTATUS'], 'transaction_entity' => 'auth', 'pending_reason' => $result['PENDINGREASON'], 'amount' => '-' . '', 'debug_data' => json_encode($result),);
                
                $this->model_payment_paypal_pro_iframe->addTransaction($transaction);
                
                $transaction['created'] = date("Y-m-d H:i:s");
                
                $json['data'] = $transaction;
                $json['error'] = false;
                $json['msg'] = 'Ok';
            } else {
                $json['error'] = true;
                $json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : Lang::get('lang_error_general'));
            }
        } else {
            $json['error'] = true;
            $json['msg'] = Lang::get('lang_error_missing_data');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function viewTransaction() {
        Theme::model('payment/paypal_pro_iframe');
        $data = Theme::language('payment/paypal_pro_iframe');
        
        Breadcrumb::add('lang_heading_title', 'paypal_pro_iframe');
        Breadcrumb::add('lang_text_transaction', 'payment/paypal_pro_iframe/viewTransaction', 'transaction_id=' . $this->request->get['transaction_id']);
        
        $transaction = $this->model_payment_paypal_pro_iframe->getTransaction($this->request->get['transaction_id']);
        $transaction = array_map('urldecode', $transaction);
        
        $data['transaction'] = $transaction;
        $data['view_link'] = Url::link('payment/paypal_pro_iframe/viewTransaction', 'token=' . $this->session->data['token'], 'SSL');
        $data['token'] = $this->session->data['token'];
        
        Theme::setTitle(Lang::get('lang_text_transaction'));
        
        if (isset($this->request->get['order_id'])) {
            $data['back'] = Url::link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
        } else {
            $data['back'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_pro_iframe_transaction', $data));
    }
    
    public function capture() {
        Lang::load('payment/paypal_pro_iframe');
        
        /**
         * used to capture authorised payments
         *
         * capture can be full or partial amounts
         */
        
        $json = array();
        
        if (isset($this->request->post['order_id']) && $this->request->post['amount'] > 0 && isset($this->request->post['order_id']) && isset($this->request->post['complete'])) {
            
            Theme::model('payment/paypal_pro_iframe');
            
            $paypal_order = $this->model_payment_paypal_pro_iframe->getOrder($this->request->post['order_id']);
            
            if ($this->request->post['complete'] == 1) {
                $complete = 'Complete';
            } else {
                $complete = 'NotComplete';
            }
            
            $call_data = array();
            $call_data['METHOD'] = 'DoCapture';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            $call_data['AMT'] = number_format($this->request->post['amount'], 2);
            $call_data['CURRENCYCODE'] = $paypal_order['currency_code'];
            $call_data['COMPLETETYPE'] = $complete;
            $call_data['MSGSUBID'] = uniqid(mt_rand(), true);
            
            $result = $this->model_payment_paypal_pro_iframe->call($call_data);
            
            $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => $call_data['MSGSUBID'], 'receipt_id' => '', 'payment_type' => '', 'payment_status' => '', 'pending_reason' => '', 'transaction_entity' => 'payment', 'amount' => '', 'debug_data' => json_encode($result),);
            
            if ($result === false) {
                $transaction['amount'] = number_format($this->request->post['amount'], 2);
                $paypal_iframe_order_transaction_id = $this->model_payment_paypal_pro_iframe->addTransaction($transaction, $call_data);
                
                $json['error'] = true;
                
                $json['failed_transaction']['paypal_iframe_order_transaction_id'] = $paypal_iframe_order_transaction_id;
                $json['failed_transaction']['amount'] = $transaction['amount'];
                $json['failed_transaction']['created'] = date("Y-m-d H:i:s");
                
                $json['msg'] = Lang::get('lang_error_timeout');
            } else if (isset($result['ACK']) && $result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $transaction['transaction_id'] = $result['TRANSACTIONID'];
                $transaction['payment_type'] = $result['PAYMENTTYPE'];
                $transaction['payment_status'] = $result['PAYMENTSTATUS'];
                $transaction['pending_reason'] = (isset($result['PENDINGREASON']) ? $result['PENDINGREASON'] : '');
                $transaction['amount'] = $result['AMT'];
                
                $this->model_payment_paypal_pro_iframe->addTransaction($transaction);
                
                unset($transaction['debug_data']);
                $transaction['created'] = date("Y-m-d H:i:s");
                
                $captured = number_format($this->model_payment_paypal_pro_iframe->totalCaptured($paypal_order['paypal_iframe_order_id']), 2);
                $refunded = number_format($this->model_payment_paypal_pro_iframe->totalRefundedOrder($paypal_order['paypal_iframe_order_id']), 2);
                
                $transaction['captured'] = $captured;
                $transaction['refunded'] = $refunded;
                $transaction['remaining'] = number_format($paypal_order['total'] - $captured, 2);
                
                $transaction['status'] = 0;
                if ($transaction['remaining'] == 0.00) {
                    $transaction['status'] = 1;
                    $this->model_payment_paypal_pro_iframe->updateOrder('Complete', $this->request->post['order_id']);
                }
                
                $transaction['void'] = '';
                
                if ($this->request->post['complete'] == 1 && $transaction['remaining'] > 0) {
                    $transaction['void'] = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => '', 'receipt_id' => '', 'payment_type' => '', 'payment_status' => 'Void', 'pending_reason' => '', 'amount' => '', 'debug_data' => 'Voided after capture', 'transaction_entity' => 'auth',);
                    
                    $this->model_payment_paypal_pro_iframe->addTransaction($transaction['void']);
                    $this->model_payment_paypal_pro_iframe->updateOrder('Complete', $this->request->post['order_id']);
                    $transaction['void']['created'] = date("Y-m-d H:i:s");
                    $transaction['status'] = 1;
                }
                
                $json['data'] = $transaction;
                $json['error'] = false;
                $json['msg'] = 'Ok';
            } else {
                $json['error'] = true;
                $json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error');
            }
        } else {
            $json['error'] = true;
            $json['msg'] = 'Missing data';
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function void() {
        Lang::load('payment/paypal_pro_iframe');
        
        $json = array();
        
        if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
            Theme::model('payment/paypal_pro_iframe');
            
            $paypal_order = $this->model_payment_paypal_pro_iframe->getOrder($this->request->post['order_id']);
            
            $call_data = array();
            $call_data['METHOD'] = 'DoVoid';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            
            $result = $this->model_payment_paypal_pro_iframe->call($call_data);
            
            if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => '', 'receipt_id' => '', 'payment_type' => 'void', 'payment_status' => 'Void', 'pending_reason' => '', 'transaction_entity' => 'auth', 'amount' => '', 'debug_data' => json_encode($result),);
                
                $this->model_payment_paypal_pro_iframe->addTransaction($transaction);
                $this->model_payment_paypal_pro_iframe->updateOrder('Complete', $this->request->post['order_id']);
                
                unset($transaction['debug_data']);
                $transaction['created'] = date("Y-m-d H:i:s");
                
                $json['data'] = $transaction;
                $json['error'] = false;
                $json['msg'] = 'Transaction void';
            } else {
                $json['error'] = true;
                $json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : Lang::get('lang_error_general'));
            }
        } else {
            $json['error'] = true;
            $json['msg'] = Lang::get('lang_error_missing_data');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function orderAction() {
        Theme::model('payment/paypal_pro_iframe');
        $data = Theme::language('payment/paypal_pro_iframe');
        
        $paypal_order = $this->model_payment_paypal_pro_iframe->getOrder($this->request->get['order_id']);
        
        if ($paypal_order) {
            $data['paypal_order'] = $paypal_order;
            $data['token'] = $this->session->data['token'];
            
            $data['order_id'] = $this->request->get['order_id'];
            $data['order_id'] = $this->request->get['order_id'];
            
            $captured = number_format($this->model_payment_paypal_pro_iframe->totalCaptured($data['paypal_order']['paypal_iframe_order_id']), 2);
            $refunded = number_format($this->model_payment_paypal_pro_iframe->totalRefundedOrder($data['paypal_order']['paypal_iframe_order_id']), 2);
            
            $data['paypal_order']['captured'] = $captured;
            $data['paypal_order']['refunded'] = $refunded;
            $data['paypal_order']['remaining'] = number_format($data['paypal_order']['total'] - $captured, 2);
            
            $data['transactions'] = array();
            
            $data['view_link'] = Url::link('payment/paypal_pro_iframe/viewTransaction', 'token=' . $this->session->data['token'], 'SSL');
            $data['refund_link'] = Url::link('payment/paypal_pro_iframe/refund', 'token=' . $this->session->data['token'], 'SSL');
            $data['resend_link'] = Url::link('payment/paypal_pro_iframe/resend', 'token=' . $this->session->data['token'], 'SSL');
            
            if ($paypal_order) {
                $captured = number_format($this->model_payment_paypal_pro_iframe->totalCaptured($paypal_order['paypal_iframe_order_id']), 2);
                $refunded = number_format($this->model_payment_paypal_pro_iframe->totalRefundedOrder($paypal_order['paypal_iframe_order_id']), 2);
                
                $data['paypal_order'] = $paypal_order;
                
                $data['paypal_order']['captured'] = $captured;
                $data['paypal_order']['refunded'] = $refunded;
                $data['paypal_order']['remaining'] = number_format($paypal_order['total'] - $captured, 2);
                
                foreach ($paypal_order['transactions'] as $transaction) {
                    $data['transactions'][] = array('paypal_iframe_order_transaction_id' => $transaction['paypal_iframe_order_transaction_id'], 'transaction_id' => $transaction['transaction_id'], 'amount' => $transaction['amount'], 'created' => $transaction['created'], 'payment_type' => $transaction['payment_type'], 'payment_status' => $transaction['payment_status'], 'pending_reason' => $transaction['pending_reason'], 'view' => Url::link('payment/paypal_pro_iframe/viewTransaction', 'token=' . $this->session->data['token'] . "&transaction_id=" . $transaction['transaction_id'] . '&order_id=' . $this->request->get['order_id'], 'SSL'), 'refund' => Url::link('payment/paypal_pro_iframe/refund', 'token=' . $this->session->data['token'] . "&transaction_id=" . $transaction['transaction_id'] . "&order_id=" . $this->request->get['order_id'], 'SSL'), 'resend' => Url::link('payment/paypal_pro_iframe/resend', 'token=' . $this->session->data['token'] . "&paypal_iframe_order_transaction_id=" . $transaction['paypal_iframe_order_transaction_id'], 'SSL'),);
                }
            }
            
            $data['reauthorise_link'] = Url::link('payment/paypal_pro_iframe/reauthorise', 'token=' . $this->session->data['token'], 'SSL');
            
            Theme::loadjs('javascript/payment/paypal_pro_iframe_order', $data);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            $data['javascript'] = Theme::controller('common/javascript');
            
            Response::setOutput(Theme::view('payment/paypal_pro_iframe_order', $data));
        }
    }
    
    public function resend() {
        Theme::model('payment/paypal_pro_iframe');
        Lang::load('payment/paypal_pro_iframe');
        
        $json = array();
        
        if (isset($this->request->get['paypal_iframe_order_transaction_id'])) {
            $transaction = $this->model_payment_paypal_pro_iframe->getFailedTransaction($this->request->get['paypal_iframe_order_transaction_id']);
            
            if ($transaction) {
                $call_data = unserialize($transaction['call_data']);
                
                $result = $this->model_payment_paypal_pro_iframe->call($call_data);
                
                if ($result) {
                    $parent_transaction = $this->model_payment_paypal_pro_iframe->getLocalTransaction($transaction['parent_transaction_id']);
                    
                    if ($parent_transaction['amount'] == abs($transaction['amount'])) {
                        $this->model_payment_paypal_pro_iframe->updateRefundTransaction($transaction['parent_transaction_id'], 'Refunded');
                    } else {
                        $this->model_payment_paypal_pro_iframe->updateRefundTransaction($transaction['parent_transaction_id'], 'Partially-Refunded');
                    }
                    
                    if (isset($result['REFUNDTRANSACTIONID'])) {
                        $transaction['transaction_id'] = $result['REFUNDTRANSACTIONID'];
                    } else {
                        $transaction['transaction_id'] = $result['TRANSACTIONID'];
                    }
                    
                    if (isset($result['PAYMENTTYPE'])) {
                        $transaction['payment_type'] = $result['PAYMENTTYPE'];
                    } else {
                        $transaction['payment_type'] = $result['REFUNDSTATUS'];
                    }
                    
                    if (isset($result['PAYMENTSTATUS'])) {
                        $transaction['payment_status'] = $result['PAYMENTSTATUS'];
                    } else {
                        $transaction['payment_status'] = 'Refunded';
                    }
                    
                    if (isset($result['AMT'])) {
                        $transaction['amount'] = $result['AMT'];
                    } else {
                        $transaction['amount'] = $transaction['amount'];
                    }
                    
                    $transaction['pending_reason'] = (isset($result['PENDINGREASON']) ? $result['PENDINGREASON'] : '');
                    
                    $this->model_payment_paypal_pro_iframe->updateTransaction($transaction);
                    
                    $json['success'] = Lang::get('lang_success_transaction_resent');
                } else {
                    $json['error'] = Lang::get('lang_error_timeout');
                }
            } else {
                $json['error'] = Lang::get('lang_error_transaction_missing');
            }
        } else {
            $json['error'] = Lang::get('lang_error_missing_data');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/paypal_pro_iframe')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['paypal_pro_iframe_sig']) {
            $this->error['sig'] = Lang::get('lang_error_sig');
        }
        
        if (!$this->request->post['paypal_pro_iframe_user']) {
            $this->error['user'] = Lang::get('lang_error_user');
        }
        
        if (!$this->request->post['paypal_pro_iframe_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
