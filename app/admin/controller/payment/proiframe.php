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

namespace Admin\Controller\Payment;
use Dais\Engine\Controller;

class Proiframe extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/proiframe');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('proiframe', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/proiframe');
        
        $data['action'] = $this->url->link('payment/proiframe', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['proiframe_sig'])) {
            $data['proiframe_sig'] = $this->request->post['proiframe_sig'];
        } else {
            $data['proiframe_sig'] = $this->config->get('proiframe_sig');
        }
        
        if (isset($this->request->post['proiframe_user'])) {
            $data['proiframe_user'] = $this->request->post['proiframe_user'];
        } else {
            $data['proiframe_user'] = $this->config->get('proiframe_user');
        }
        
        if (isset($this->request->post['proiframe_password'])) {
            $data['proiframe_password'] = $this->request->post['proiframe_password'];
        } else {
            $data['proiframe_password'] = $this->config->get('proiframe_password');
        }
        
        if (isset($this->request->post['proiframe_transaction_method'])) {
            $data['proiframe_transaction_method'] = $this->request->post['proiframe_transaction_method'];
        } else {
            $data['proiframe_transaction_method'] = $this->config->get('proiframe_transaction_method');
        }
        
        if (isset($this->request->post['proiframe_test'])) {
            $data['proiframe_test'] = $this->request->post['proiframe_test'];
        } else {
            $data['proiframe_test'] = $this->config->get('proiframe_test');
        }
        
        if (isset($this->request->post['proiframe_total'])) {
            $data['proiframe_total'] = $this->request->post['proiframe_total'];
        } else {
            $data['proiframe_total'] = $this->config->get('proiframe_total');
        }
        
        $this->theme->model('localization/orderstatus');
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['proiframe_canceled_reversal_status_id'])) {
            $data['proiframe_canceled_reversal_status_id'] = $this->request->post['proiframe_canceled_reversal_status_id'];
        } else {
            $data['proiframe_canceled_reversal_status_id'] = $this->config->get('proiframe_canceled_reversal_status_id');
        }
        
        if (isset($this->request->post['proiframe_completed_status_id'])) {
            $data['proiframe_completed_status_id'] = $this->request->post['proiframe_completed_status_id'];
        } else {
            $data['proiframe_completed_status_id'] = $this->config->get('proiframe_completed_status_id');
        }
        
        if (isset($this->request->post['proiframe_denied_status_id'])) {
            $data['proiframe_denied_status_id'] = $this->request->post['proiframe_denied_status_id'];
        } else {
            $data['proiframe_denied_status_id'] = $this->config->get('proiframe_denied_status_id');
        }
        
        if (isset($this->request->post['proiframe_expired_status_id'])) {
            $data['proiframe_expired_status_id'] = $this->request->post['proiframe_expired_status_id'];
        } else {
            $data['proiframe_expired_status_id'] = $this->config->get('proiframe_expired_status_id');
        }
        
        if (isset($this->request->post['proiframe_failed_status_id'])) {
            $data['proiframe_failed_status_id'] = $this->request->post['proiframe_failed_status_id'];
        } else {
            $data['proiframe_failed_status_id'] = $this->config->get('proiframe_failed_status_id');
        }
        
        if (isset($this->request->post['proiframe_pending_status_id'])) {
            $data['proiframe_pending_status_id'] = $this->request->post['proiframe_pending_status_id'];
        } else {
            $data['proiframe_pending_status_id'] = $this->config->get('proiframe_pending_status_id');
        }
        
        if (isset($this->request->post['proiframe_processed_status_id'])) {
            $data['proiframe_processed_status_id'] = $this->request->post['proiframe_processed_status_id'];
        } else {
            $data['proiframe_processed_status_id'] = $this->config->get('proiframe_processed_status_id');
        }
        
        if (isset($this->request->post['proiframe_refunded_status_id'])) {
            $data['proiframe_refunded_status_id'] = $this->request->post['proiframe_refunded_status_id'];
        } else {
            $data['proiframe_refunded_status_id'] = $this->config->get('proiframe_refunded_status_id');
        }
        
        if (isset($this->request->post['proiframe_reversed_status_id'])) {
            $data['proiframe_reversed_status_id'] = $this->request->post['proiframe_reversed_status_id'];
        } else {
            $data['proiframe_reversed_status_id'] = $this->config->get('proiframe_reversed_status_id');
        }
        
        if (isset($this->request->post['proiframe_voided_status_id'])) {
            $data['proiframe_voided_status_id'] = $this->request->post['proiframe_voided_status_id'];
        } else {
            $data['proiframe_voided_status_id'] = $this->config->get('proiframe_voided_status_id');
        }
        
        if (isset($this->request->post['proiframe_geo_zone_id'])) {
            $data['proiframe_geo_zone_id'] = $this->request->post['proiframe_geo_zone_id'];
        } else {
            $data['proiframe_geo_zone_id'] = $this->config->get('proiframe_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['proiframe_status'])) {
            $data['proiframe_status'] = $this->request->post['proiframe_status'];
        } else {
            $data['proiframe_status'] = $this->config->get('proiframe_status');
        }
        
        if (isset($this->request->post['proiframe_sort_order'])) {
            $data['proiframe_sort_order'] = $this->request->post['proiframe_sort_order'];
        } else {
            $data['proiframe_sort_order'] = $this->config->get('proiframe_sort_order');
        }
        
        if (isset($this->request->post['proiframe_checkout_method'])) {
            $data['proiframe_checkout_method'] = $this->request->post['proiframe_checkout_method'];
        } else {
            $data['proiframe_checkout_method'] = $this->config->get('proiframe_checkout_method');
        }
        
        if (isset($this->request->post['proiframe_debug'])) {
            $data['proiframe_debug'] = $this->request->post['proiframe_debug'];
        } else {
            $data['proiframe_debug'] = $this->config->get('proiframe_debug');
        }
        
        $data['ipn_url'] = $this->app['https.public'] . 'payment/proiframe/notify';
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/proiframe', $data));
    }
    
    public function install() {
        $this->theme->model('payment/proiframe');
        $this->model_payment_proiframe->install();
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
    }
    
    public function uninstall() {
        $this->theme->model('payment/proiframe');
        $this->model_payment_proiframe->uninstall();
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
    }
    
    public function refund() {
        $data = $this->theme->language('payment/proiframe');
        $this->theme->model('payment/proiframe');
        
        $this->theme->setTitle($this->language->get('lang_text_refund'));
        
        $this->breadcrumb->add('lang_heading_title', 'payment/proiframe');
        $this->breadcrumb->add('lang_text_refund', 'payment/proiframe/refund');
        
        //button actions
        $data['action'] = $this->url->link('payment/proiframe/doRefund', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->get['order_id'])) {
            $data['cancel'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
        } else {
            $data['cancel'] = '';
        }
        
        $data['transaction_id'] = $this->request->get['transaction_id'];
        
        $pp_transaction = $this->model_payment_proiframe->getTransaction($this->request->get['transaction_id']);
        
        $data['amount_original'] = $pp_transaction['AMT'];
        $data['currency_code'] = $pp_transaction['CURRENCYCODE'];
        
        $refunded = number_format($this->model_payment_proiframe->totalRefundedTransaction($this->request->get['transaction_id']), 2);
        
        if ($refunded != 0.00) {
            $data['refund_available'] = number_format($data['amount_original'] + $refunded, 2);
            $data['attention'] = $this->language->get('lang_text_current_refunds') . ': ' . $data['refund_available'];
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
        
        $this->theme->loadjs('javascript/payment/proiframe_refund', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/proiframe_refund', $data));
    }
    
    public function doRefund() {
        
        /**
         * used to issue a refund for a captured payment
         *
         * refund can be full or partial
         */
        if (isset($this->request->post['transaction_id']) && isset($this->request->post['refund_full'])) {
            
            $this->theme->model('payment/proiframe');
            $this->language->load('payment/proiframe');
            
            if ($this->request->post['refund_full'] == 0 && $this->request->post['amount'] == 0) {
                $this->session->data['error'] = $this->language->get('lang_error_partial_amt');
            } else {
                $order_id = $this->model_payment_proiframe->getOrderId($this->request->post['transaction_id']);
                $paypal_order = $this->model_payment_proiframe->getOrder($order_id);
                
                if ($paypal_order) {
                    $call_data = array();
                    $call_data['METHOD'] = 'RefundTransaction';
                    $call_data['TRANSACTIONID'] = $this->request->post['transaction_id'];
                    $call_data['NOTE'] = urlencode($this->request->post['refund_message']);
                    $call_data['MSGSUBID'] = uniqid(mt_rand(), true);
                    
                    $current_transaction = $this->model_payment_proiframe->getLocalTransaction($this->request->post['transaction_id']);
                    
                    if ($this->request->post['refund_full'] == 1) {
                        $call_data['REFUNDTYPE'] = 'Full';
                    } else {
                        $call_data['REFUNDTYPE'] = 'Partial';
                        $call_data['AMT'] = number_format($this->request->post['amount'], 2);
                        $call_data['CURRENCYCODE'] = $this->request->post['currency_code'];
                    }
                    
                    $result = $this->model_payment_proiframe->call($call_data);
                    
                    $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $this->request->post['transaction_id'], 'note' => $this->request->post['refund_message'], 'msgsubid' => $call_data['MSGSUBID'], 'receipt_id' => '', 'payment_type' => '', 'payment_status' => 'Refunded', 'transaction_entity' => 'payment', 'pending_reason' => '', 'amount' => '-' . (isset($call_data['AMT']) ? $call_data['AMT'] : $current_transaction['amount']), 'debug_data' => json_encode($result),);
                    
                    if ($result === false) {
                        $transaction['payment_status'] = 'Failed';
                        $this->model_payment_proiframe->addTransaction($transaction, $call_data);
                        
                        $this->theme->listen(__CLASS__, __FUNCTION__);
                        
                        $this->response->redirect($this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $paypal_order['order_id'], 'SSL'));
                    } else if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                        
                        $transaction['transaction_id'] = $result['REFUNDTRANSACTIONID'];
                        $transaction['payment_type'] = $result['REFUNDSTATUS'];
                        $transaction['pending_reason'] = $result['PENDINGREASON'];
                        $transaction['amount'] = '-' . $result['GROSSREFUNDAMT'];
                        
                        $this->model_payment_proiframe->addTransaction($transaction);
                        
                        if ($result['TOTALREFUNDEDAMOUNT'] == $this->request->post['amount_original']) {
                            $this->model_payment_proiframe->updateRefundTransaction($this->request->post['transaction_id'], 'Refunded');
                        } else {
                            $this->model_payment_proiframe->updateRefundTransaction($this->request->post['transaction_id'], 'Partially-Refunded');
                        }
                        
                        $this->theme->listen(__CLASS__, __FUNCTION__);
                        
                        //redirect back to the order
                        $this->response->redirect($this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $paypal_order['order_id'], 'SSL'));
                    } else {
                        $this->model_payment_proiframe->log(json_encode($result));
                        $this->session->data['error'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error') . (isset($result['L_LONGMESSAGE0']) ? '<br />' . $result['L_LONGMESSAGE0'] : '');
                        
                        $this->theme->listen(__CLASS__, __FUNCTION__);
                        
                        $this->response->redirect($this->url->link('payment/proiframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
                    }
                } else {
                    $this->session->data['error'] = $this->language->get('lang_error_data_missing');
                    
                    $this->theme->listen(__CLASS__, __FUNCTION__);
                    
                    $this->response->redirect($this->url->link('payment/proiframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
                }
            }
        } else {
            $this->session->data['error'] = $this->language->get('lang_error_data');
            
            $this->theme->listen(__CLASS__, __FUNCTION__);
            
            $this->response->redirect($this->url->link('payment/proiframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
        }
    }
    
    public function reauthorise() {
        $this->language->load('payment/proiframe');
        $this->theme->model('payment/proiframe');
        
        $json = array();
        
        if (isset($this->request->post['order_id'])) {
            $paypal_order = $this->model_payment_proiframe->getOrder($this->request->post['order_id']);
            
            $call_data = array();
            $call_data['METHOD'] = 'DoReauthorization';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            $call_data['AMT'] = number_format($paypal_order['total'], 2);
            $call_data['CURRENCYCODE'] = $paypal_order['currency_code'];
            
            $result = $this->model_payment_proiframe->call($call_data);
            
            if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $this->model_payment_proiframe->updateAuthorizationId($paypal_order['paypal_iframe_order_id'], $result['AUTHORIZATIONID']);
                
                $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => '', 'receipt_id' => '', 'payment_type' => 'instant', 'payment_status' => $result['PAYMENTSTATUS'], 'transaction_entity' => 'auth', 'pending_reason' => $result['PENDINGREASON'], 'amount' => '-' . '', 'debug_data' => json_encode($result),);
                
                $this->model_payment_proiframe->addTransaction($transaction);
                
                $transaction['created'] = date("Y-m-d H:i:s");
                
                $json['data'] = $transaction;
                $json['error'] = false;
                $json['msg'] = 'Ok';
            } else {
                $json['error'] = true;
                $json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : $this->language->get('lang_error_general'));
            }
        } else {
            $json['error'] = true;
            $json['msg'] = $this->language->get('lang_error_missing_data');
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function viewTransaction() {
        $this->theme->model('payment/proiframe');
        $data = $this->theme->language('payment/proiframe');
        
        $this->breadcrumb->add('lang_heading_title', 'proiframe');
        $this->breadcrumb->add('lang_text_transaction', 'payment/proiframe/viewTransaction', 'transaction_id=' . $this->request->get['transaction_id']);
        
        $transaction = $this->model_payment_proiframe->getTransaction($this->request->get['transaction_id']);
        $transaction = array_map('urldecode', $transaction);
        
        $data['transaction'] = $transaction;
        $data['view_link'] = $this->url->link('payment/proiframe/viewTransaction', 'token=' . $this->session->data['token'], 'SSL');
        $data['token'] = $this->session->data['token'];
        
        $this->theme->setTitle($this->language->get('lang_text_transaction'));
        
        if (isset($this->request->get['order_id'])) {
            $data['back'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
        } else {
            $data['back'] = '';
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/proiframe_transaction', $data));
    }
    
    public function capture() {
        $this->language->load('payment/proiframe');
        
        /**
         * used to capture authorised payments
         *
         * capture can be full or partial amounts
         */
        
        $json = array();
        
        if (isset($this->request->post['order_id']) && $this->request->post['amount'] > 0 && isset($this->request->post['order_id']) && isset($this->request->post['complete'])) {
            
            $this->theme->model('payment/proiframe');
            
            $paypal_order = $this->model_payment_proiframe->getOrder($this->request->post['order_id']);
            
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
            
            $result = $this->model_payment_proiframe->call($call_data);
            
            $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => $call_data['MSGSUBID'], 'receipt_id' => '', 'payment_type' => '', 'payment_status' => '', 'pending_reason' => '', 'transaction_entity' => 'payment', 'amount' => '', 'debug_data' => json_encode($result),);
            
            if ($result === false) {
                $transaction['amount'] = number_format($this->request->post['amount'], 2);
                $paypal_iframe_order_transaction_id = $this->model_payment_proiframe->addTransaction($transaction, $call_data);
                
                $json['error'] = true;
                
                $json['failed_transaction']['paypal_iframe_order_transaction_id'] = $paypal_iframe_order_transaction_id;
                $json['failed_transaction']['amount'] = $transaction['amount'];
                $json['failed_transaction']['created'] = date("Y-m-d H:i:s");
                
                $json['msg'] = $this->language->get('lang_error_timeout');
            } else if (isset($result['ACK']) && $result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $transaction['transaction_id'] = $result['TRANSACTIONID'];
                $transaction['payment_type'] = $result['PAYMENTTYPE'];
                $transaction['payment_status'] = $result['PAYMENTSTATUS'];
                $transaction['pending_reason'] = (isset($result['PENDINGREASON']) ? $result['PENDINGREASON'] : '');
                $transaction['amount'] = $result['AMT'];
                
                $this->model_payment_proiframe->addTransaction($transaction);
                
                unset($transaction['debug_data']);
                $transaction['created'] = date("Y-m-d H:i:s");
                
                $captured = number_format($this->model_payment_proiframe->totalCaptured($paypal_order['paypal_iframe_order_id']), 2);
                $refunded = number_format($this->model_payment_proiframe->totalRefundedOrder($paypal_order['paypal_iframe_order_id']), 2);
                
                $transaction['captured'] = $captured;
                $transaction['refunded'] = $refunded;
                $transaction['remaining'] = number_format($paypal_order['total'] - $captured, 2);
                
                $transaction['status'] = 0;
                if ($transaction['remaining'] == 0.00) {
                    $transaction['status'] = 1;
                    $this->model_payment_proiframe->updateOrder('Complete', $this->request->post['order_id']);
                }
                
                $transaction['void'] = '';
                
                if ($this->request->post['complete'] == 1 && $transaction['remaining'] > 0) {
                    $transaction['void'] = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => '', 'receipt_id' => '', 'payment_type' => '', 'payment_status' => 'Void', 'pending_reason' => '', 'amount' => '', 'debug_data' => 'Voided after capture', 'transaction_entity' => 'auth',);
                    
                    $this->model_payment_proiframe->addTransaction($transaction['void']);
                    $this->model_payment_proiframe->updateOrder('Complete', $this->request->post['order_id']);
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
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function void() {
        $this->language->load('payment/proiframe');
        
        $json = array();
        
        if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
            $this->theme->model('payment/proiframe');
            
            $paypal_order = $this->model_payment_proiframe->getOrder($this->request->post['order_id']);
            
            $call_data = array();
            $call_data['METHOD'] = 'DoVoid';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            
            $result = $this->model_payment_proiframe->call($call_data);
            
            if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $transaction = array('paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'], 'transaction_id' => '', 'parent_transaction_id' => $paypal_order['authorization_id'], 'note' => '', 'msgsubid' => '', 'receipt_id' => '', 'payment_type' => 'void', 'payment_status' => 'Void', 'pending_reason' => '', 'transaction_entity' => 'auth', 'amount' => '', 'debug_data' => json_encode($result),);
                
                $this->model_payment_proiframe->addTransaction($transaction);
                $this->model_payment_proiframe->updateOrder('Complete', $this->request->post['order_id']);
                
                unset($transaction['debug_data']);
                $transaction['created'] = date("Y-m-d H:i:s");
                
                $json['data'] = $transaction;
                $json['error'] = false;
                $json['msg'] = 'Transaction void';
            } else {
                $json['error'] = true;
                $json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : $this->language->get('lang_error_general'));
            }
        } else {
            $json['error'] = true;
            $json['msg'] = $this->language->get('lang_error_missing_data');
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function orderAction() {
        $this->theme->model('payment/proiframe');
        $data = $this->theme->language('payment/proiframe');
        
        $paypal_order = $this->model_payment_proiframe->getOrder($this->request->get['order_id']);
        
        if ($paypal_order) {
            $data['paypal_order'] = $paypal_order;
            $data['token'] = $this->session->data['token'];
            
            $data['order_id'] = $this->request->get['order_id'];
            $data['order_id'] = $this->request->get['order_id'];
            
            $captured = number_format($this->model_payment_proiframe->totalCaptured($data['paypal_order']['paypal_iframe_order_id']), 2);
            $refunded = number_format($this->model_payment_proiframe->totalRefundedOrder($data['paypal_order']['paypal_iframe_order_id']), 2);
            
            $data['paypal_order']['captured'] = $captured;
            $data['paypal_order']['refunded'] = $refunded;
            $data['paypal_order']['remaining'] = number_format($data['paypal_order']['total'] - $captured, 2);
            
            $data['transactions'] = array();
            
            $data['view_link'] = $this->url->link('payment/proiframe/viewTransaction', 'token=' . $this->session->data['token'], 'SSL');
            $data['refund_link'] = $this->url->link('payment/proiframe/refund', 'token=' . $this->session->data['token'], 'SSL');
            $data['resend_link'] = $this->url->link('payment/proiframe/resend', 'token=' . $this->session->data['token'], 'SSL');
            
            if ($paypal_order) {
                $captured = number_format($this->model_payment_proiframe->totalCaptured($paypal_order['paypal_iframe_order_id']), 2);
                $refunded = number_format($this->model_payment_proiframe->totalRefundedOrder($paypal_order['paypal_iframe_order_id']), 2);
                
                $data['paypal_order'] = $paypal_order;
                
                $data['paypal_order']['captured'] = $captured;
                $data['paypal_order']['refunded'] = $refunded;
                $data['paypal_order']['remaining'] = number_format($paypal_order['total'] - $captured, 2);
                
                foreach ($paypal_order['transactions'] as $transaction) {
                    $data['transactions'][] = array('paypal_iframe_order_transaction_id' => $transaction['paypal_iframe_order_transaction_id'], 'transaction_id' => $transaction['transaction_id'], 'amount' => $transaction['amount'], 'created' => $transaction['created'], 'payment_type' => $transaction['payment_type'], 'payment_status' => $transaction['payment_status'], 'pending_reason' => $transaction['pending_reason'], 'view' => $this->url->link('payment/proiframe/viewTransaction', 'token=' . $this->session->data['token'] . "&transaction_id=" . $transaction['transaction_id'] . '&order_id=' . $this->request->get['order_id'], 'SSL'), 'refund' => $this->url->link('payment/proiframe/refund', 'token=' . $this->session->data['token'] . "&transaction_id=" . $transaction['transaction_id'] . "&order_id=" . $this->request->get['order_id'], 'SSL'), 'resend' => $this->url->link('payment/proiframe/resend', 'token=' . $this->session->data['token'] . "&paypal_iframe_order_transaction_id=" . $transaction['paypal_iframe_order_transaction_id'], 'SSL'),);
                }
            }
            
            $data['reauthorise_link'] = $this->url->link('payment/proiframe/reauthorise', 'token=' . $this->session->data['token'], 'SSL');
            
            $this->theme->loadjs('javascript/payment/proiframe_order', $data);
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $data['javascript'] = $this->theme->controller('common/javascript');
            
            $this->response->setOutput($this->theme->view('payment/proiframe_order', $data));
        }
    }
    
    public function resend() {
        $this->theme->model('payment/proiframe');
        $this->language->load('payment/proiframe');
        
        $json = array();
        
        if (isset($this->request->get['paypal_iframe_order_transaction_id'])) {
            $transaction = $this->model_payment_proiframe->getFailedTransaction($this->request->get['paypal_iframe_order_transaction_id']);
            
            if ($transaction) {
                $call_data = unserialize($transaction['call_data']);
                
                $result = $this->model_payment_proiframe->call($call_data);
                
                if ($result) {
                    $parent_transaction = $this->model_payment_proiframe->getLocalTransaction($transaction['parent_transaction_id']);
                    
                    if ($parent_transaction['amount'] == abs($transaction['amount'])) {
                        $this->model_payment_proiframe->updateRefundTransaction($transaction['parent_transaction_id'], 'Refunded');
                    } else {
                        $this->model_payment_proiframe->updateRefundTransaction($transaction['parent_transaction_id'], 'Partially-Refunded');
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
                    
                    $this->model_payment_proiframe->updateTransaction($transaction);
                    
                    $json['success'] = $this->language->get('lang_success_transaction_resent');
                } else {
                    $json['error'] = $this->language->get('lang_error_timeout');
                }
            } else {
                $json['error'] = $this->language->get('lang_error_transaction_missing');
            }
        } else {
            $json['error'] = $this->language->get('lang_error_missing_data');
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/proiframe')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['proiframe_sig']) {
            $this->error['sig'] = $this->language->get('lang_error_sig');
        }
        
        if (!$this->request->post['proiframe_user']) {
            $this->error['user'] = $this->language->get('lang_error_user');
        }
        
        if (!$this->request->post['proiframe_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
