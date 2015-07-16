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

class PaypalExpress extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/paypal_express');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('setting/setting');
        Theme::model('setting/module');
        Theme::model('payment/paypal_express');
        
        $this->error = array();
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('paypal_express', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
        } else {
            $data['error'] = $this->error;
        }
        
        $data['text_ipn_url'] = Config::get('https.public') . 'payment/paypal_express/ipn';
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_express');
        
        //button actions
        $data['action'] = Url::link('payment/paypal_express', '', 'SSL');
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        $data['search'] = Url::link('payment/paypal_express/search', '', 'SSL');
        
        $data['paypal_express_login_seamless'] = true;
        
        if (isset($this->request->post['paypal_express_username'])) {
            $data['paypal_express_username'] = $this->request->post['paypal_express_username'];
        } else {
            $data['paypal_express_username'] = Config::get('paypal_express_username');
        }
        
        if (isset($this->request->post['paypal_express_password'])) {
            $data['paypal_express_password'] = $this->request->post['paypal_express_password'];
        } else {
            $data['paypal_express_password'] = Config::get('paypal_express_password');
        }
        
        if (isset($this->request->post['paypal_express_signature'])) {
            $data['paypal_express_signature'] = $this->request->post['paypal_express_signature'];
        } else {
            $data['paypal_express_signature'] = Config::get('paypal_express_signature');
        }
        
        if (isset($this->request->post['paypal_express_test'])) {
            $data['paypal_express_test'] = $this->request->post['paypal_express_test'];
        } else {
            $data['paypal_express_test'] = Config::get('paypal_express_test');
        }
        
        if (isset($this->request->post['paypal_express_method'])) {
            $data['paypal_express_method'] = $this->request->post['paypal_express_method'];
        } else {
            $data['paypal_express_method'] = Config::get('paypal_express_method');
        }
        
        if (isset($this->request->post['paypal_express_total'])) {
            $data['paypal_express_total'] = $this->request->post['paypal_express_total'];
        } else {
            $data['paypal_express_total'] = Config::get('paypal_express_total');
        }
        
        if (isset($this->request->post['paypal_express_debug'])) {
            $data['paypal_express_debug'] = $this->request->post['paypal_express_debug'];
        } else {
            $data['paypal_express_debug'] = Config::get('paypal_express_debug');
        }
        
        if (isset($this->request->post['paypal_express_currency'])) {
            $data['paypal_express_currency'] = $this->request->post['paypal_express_currency'];
        } else {
            $data['paypal_express_currency'] = Config::get('paypal_express_currency');
        }
        
        $data['currency_codes'] = PaymentPaypalExpress::currencyCodes();
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset($this->request->post['paypal_express_canceled_reversal_status_id'])) {
            $data['paypal_express_canceled_reversal_status_id'] = $this->request->post['paypal_express_canceled_reversal_status_id'];
        } else {
            $data['paypal_express_canceled_reversal_status_id'] = Config::get('paypal_express_canceled_reversal_status_id');
        }
        
        if (isset($this->request->post['paypal_express_completed_status_id'])) {
            $data['paypal_express_completed_status_id'] = $this->request->post['paypal_express_completed_status_id'];
        } else {
            $data['paypal_express_completed_status_id'] = Config::get('paypal_express_completed_status_id');
        }
        
        if (isset($this->request->post['paypal_express_denied_status_id'])) {
            $data['paypal_express_denied_status_id'] = $this->request->post['paypal_express_denied_status_id'];
        } else {
            $data['paypal_express_denied_status_id'] = Config::get('paypal_express_denied_status_id');
        }
        
        if (isset($this->request->post['paypal_express_expired_status_id'])) {
            $data['paypal_express_expired_status_id'] = $this->request->post['paypal_express_expired_status_id'];
        } else {
            $data['paypal_express_expired_status_id'] = Config::get('paypal_express_expired_status_id');
        }
        
        if (isset($this->request->post['paypal_express_failed_status_id'])) {
            $data['paypal_express_failed_status_id'] = $this->request->post['paypal_express_failed_status_id'];
        } else {
            $data['paypal_express_failed_status_id'] = Config::get('paypal_express_failed_status_id');
        }
        
        if (isset($this->request->post['paypal_express_pending_status_id'])) {
            $data['paypal_express_pending_status_id'] = $this->request->post['paypal_express_pending_status_id'];
        } else {
            $data['paypal_express_pending_status_id'] = Config::get('paypal_express_pending_status_id');
        }
        
        if (isset($this->request->post['paypal_express_processed_status_id'])) {
            $data['paypal_express_processed_status_id'] = $this->request->post['paypal_express_processed_status_id'];
        } else {
            $data['paypal_express_processed_status_id'] = Config::get('paypal_express_processed_status_id');
        }
        
        if (isset($this->request->post['paypal_express_refunded_status_id'])) {
            $data['paypal_express_refunded_status_id'] = $this->request->post['paypal_express_refunded_status_id'];
        } else {
            $data['paypal_express_refunded_status_id'] = Config::get('paypal_express_refunded_status_id');
        }
        
        if (isset($this->request->post['paypal_express_reversed_status_id'])) {
            $data['paypal_express_reversed_status_id'] = $this->request->post['paypal_express_reversed_status_id'];
        } else {
            $data['paypal_express_reversed_status_id'] = Config::get('paypal_express_reversed_status_id');
        }
        
        if (isset($this->request->post['paypal_express_voided_status_id'])) {
            $data['paypal_express_voided_status_id'] = $this->request->post['paypal_express_voided_status_id'];
        } else {
            $data['paypal_express_voided_status_id'] = Config::get('paypal_express_voided_status_id');
        }
        
        if (isset($this->request->post['paypal_express_allow_note'])) {
            $data['paypal_express_allow_note'] = $this->request->post['paypal_express_allow_note'];
        } else {
            $data['paypal_express_allow_note'] = Config::get('paypal_express_allow_note');
        }
        
        if (isset($this->request->post['paypal_express_logo'])) {
            $data['paypal_express_logo'] = $this->request->post['paypal_express_logo'];
        } else {
            $data['paypal_express_logo'] = Config::get('paypal_express_logo');
        }
        
        if (isset($this->request->post['paypal_express_page_colour'])) {
            $data['paypal_express_page_colour'] = str_replace('#', '', $this->request->post['paypal_express_page_colour']);
        } else {
            $data['paypal_express_page_colour'] = Config::get('paypal_express_page_colour');
        }
        
        if (isset($this->request->post['paypal_express_recurring_cancel_status'])) {
            $data['paypal_express_recurring_cancel_status'] = $this->request->post['paypal_express_recurring_cancel_status'];
        } else {
            $data['paypal_express_recurring_cancel_status'] = Config::get('paypal_express_recurring_cancel_status');
        }
        
        Theme::model('tool/image');
        
        $logo = Config::get('paypal_express_logo');
        
        if (isset($this->request->post['paypal_express_logo']) && file_exists(Config::get('path.image') . $this->request->post['paypal_express_logo'])) {
            $data['thumb'] = ToolImage::resize($this->request->post['paypal_express_logo'], 750, 90);
        } elseif (($logo != '') && file_exists(Config::get('path.image') . $logo)) {
            $data['thumb'] = ToolImage::resize($logo, 750, 90);
        } else {
            $data['thumb'] = ToolImage::resize('placeholder.png', 750, 90);
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 750, 90);
        
        if (isset($this->request->post['paypal_express_geo_zone_id'])) {
            $data['paypal_express_geo_zone_id'] = $this->request->post['paypal_express_geo_zone_id'];
        } else {
            $data['paypal_express_geo_zone_id'] = Config::get('paypal_express_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset($this->request->post['paypal_express_status'])) {
            $data['paypal_express_status'] = $this->request->post['paypal_express_status'];
        } else {
            $data['paypal_express_status'] = Config::get('paypal_express_status');
        }
        
        if (isset($this->request->post['paypal_express_sort_order'])) {
            $data['paypal_express_sort_order'] = $this->request->post['paypal_express_sort_order'];
        } else {
            $data['paypal_express_sort_order'] = Config::get('paypal_express_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_express', $data));
    }
    
    public function imageLogo() {
        Theme::model('tool/image');
        
        if (isset($this->request->get['image'])) {
            Response::setOutput(ToolImage::resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), 750, 90));
        }
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/paypal_express')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (empty($this->request->post['paypal_express_username'])) {
            $this->error['username'] = Lang::get('lang_error_username');
        }
        
        if (empty($this->request->post['paypal_express_password'])) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (empty($this->request->post['paypal_express_signature'])) {
            $this->error['signature'] = Lang::get('lang_error_signature');
        }
        
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    
    public function resend() {
        Theme::language('payment/paypal_express');
        Theme::model('payment/paypal_express');
        
        $json = array();
        
        if (isset($this->request->get['paypal_order_transaction_id'])) {
            $transaction = PaymentPaypalExpress::getFailedTransaction($this->request->get['paypal_order_transaction_id']);
            
            if ($transaction) {
                $call_data = unserialize($transaction['call_data']);
                
                $result = PaymentPaypalExpress::call($call_data);
                
                if ($result) {
                    
                    $parent_transaction = PaymentPaypalExpress::getLocalTransaction($transaction['parent_transaction_id']);
                    
                    if ($parent_transaction['amount'] == abs($transaction['amount'])) {
                        $this->db->query("
							UPDATE `{$this->db->prefix}paypal_order_transaction` 
							SET 
								`payment_status` = 'Refunded' 
							WHERE `transaction_id` = '" . $this->db->escape($transaction['parent_transaction_id']) . "' 
							LIMIT 1");
                    } else {
                        $this->db->query("
							UPDATE `{$this->db->prefix}paypal_order_transaction` 
							SET 
								`payment_status` = 'Partially-Refunded' 
							WHERE `transaction_id` = '" . $this->db->escape($transaction['parent_transaction_id']) . "' 
							LIMIT 1");
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
                    
                    PaymentPaypalExpress::updateTransaction($transaction);
                    
                    $json['success'] = Lang::get('lang_success_transaction_resent');
                } else {
                    $json['error'] = Lang::get('lang_error_timeout');
                }
            } else {
                $json['error'] = Lang::get('lang_error_transaction_missing');
            }
        } else {
            $json['error'] = Lang::get('lang_error_data');
        }
        
        Response::addHeader('Content-Type: application/json');
        Response::setOutput(json_encode($json));
    }
    
    public function capture() {
        Theme::language('payment/paypal_express');
        
        /**
         * used to capture authorised payments
         *
         * capture can be full or partial amounts
         */
        if (isset($this->request->post['order_id']) && $this->request->post['amount'] > 0 && isset($this->request->post['order_id']) && isset($this->request->post['complete'])) {
            
            Theme::model('payment/paypal_express');
            
            $paypal_order = PaymentPaypalExpress::getOrder($this->request->post['order_id']);
            
            if ($this->request->post['complete'] == 1) {
                $complete = 'Complete';
            } else {
                $complete = 'NotComplete';
            }
            
            $call_data                    = array();
            $call_data['METHOD']          = 'DoCapture';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            $call_data['AMT']             = number_format($this->request->post['amount'], 2);
            $call_data['CURRENCYCODE']    = $paypal_order['currency_code'];
            $call_data['COMPLETETYPE']    = $complete;
            $call_data['MSGSUBID']        = uniqid(mt_rand(), true);
            
            $result = PaymentPaypalExpress::call($call_data);
            
            $transaction = array(
                'paypal_order_id'       => $paypal_order['paypal_order_id'], 
                'transaction_id'        => '', 
                'parent_transaction_id' => $paypal_order['authorization_id'], 
                'note'                  => '', 
                'msgsubid'              => $call_data['MSGSUBID'], 
                'receipt_id'            => '', 
                'payment_type'          => '', 
                'payment_status'        => '', 
                'pending_reason'        => '', 
                'transaction_entity'    => 'payment', 
                'amount'                => '', 
                'debug_data'            => json_encode($result)
            );
            
            if ($result === false) {
                $transaction['amount']       = number_format($this->request->post['amount'], 2);
                $paypal_order_transaction_id = PaymentPaypalExpress::addTransaction($transaction, $call_data);
                
                $json['error'] = true;
                
                $json['failed_transaction']['paypal_order_transaction_id'] = $paypal_order_transaction_id;
                $json['failed_transaction']['amount']                      = $transaction['amount'];
                $json['failed_transaction']['column_date_added']           = date("Y-m-d H:i:s");
                
                $json['msg'] = Lang::get('lang_error_timeout');
            } else if (isset($result['ACK']) && $result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $transaction['transaction_id'] = $result['TRANSACTIONID'];
                $transaction['payment_type']   = $result['PAYMENTTYPE'];
                $transaction['payment_status'] = $result['PAYMENTSTATUS'];
                $transaction['pending_reason'] = (isset($result['PENDINGREASON']) ? $result['PENDINGREASON'] : '');
                $transaction['amount']         = $result['AMT'];
                
                PaymentPaypalExpress::addTransaction($transaction);
                
                unset($transaction['debug_data']);
                $transaction['date_added'] = date("Y-m-d H:i:s");
                
                $captured = number_format(PaymentPaypalExpress::totalCaptured($paypal_order['paypal_order_id']), 2);
                $refunded = number_format(PaymentPaypalExpress::totalRefundedOrder($paypal_order['paypal_order_id']), 2);
                
                $transaction['captured']  = $captured;
                $transaction['refunded']  = $refunded;
                $transaction['remaining'] = number_format($paypal_order['total'] - $captured, 2);
                
                $transaction['status'] = 0;
                if ($transaction['remaining'] == 0.00) {
                    $transaction['status'] = 1;
                    PaymentPaypalExpress::updateOrder('Complete', $this->request->post['order_id']);
                }
                
                $transaction['void'] = '';
                
                if ($this->request->post['complete'] == 1 && $transaction['remaining'] > 0) {
                    $transaction['void'] = array(
                        'paypal_order_id'       => $paypal_order['paypal_order_id'], 
                        'transaction_id'        => '', 
                        'parent_transaction_id' => $paypal_order['authorization_id'], 
                        'note'                  => '', 
                        'msgsubid'              => '', 
                        'receipt_id'            => '', 
                        'payment_type'          => '', 
                        'payment_status'        => 'Void', 
                        'pending_reason'        => '', 
                        'amount'                => '', 
                        'debug_data'            => 'Voided after capture', 
                        'transaction_entity'    => 'auth'
                    );
                    
                    PaymentPaypalExpress::addTransaction($transaction['void']);
                    PaymentPaypalExpress::updateOrder('Complete', $this->request->post['order_id']);
                    $transaction['void']['date_added'] = date("Y-m-d H:i:s");
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
        
        Response::addHeader('Content-Type: application/json');
        Response::setOutput(json_encode($json));
    }
    
    public function void() {
        
        /**
         * used to void an authorized payment
         */
        if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
            Theme::model('payment/paypal_express');
            
            $paypal_order = PaymentPaypalExpress::getOrder($this->request->post['order_id']);
            
            $call_data = array();
            $call_data['METHOD'] = 'DoVoid';
            $call_data['AUTHORIZATIONID'] = $paypal_order['authorization_id'];
            
            $result = PaymentPaypalExpress::call($call_data);
            
            if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                $transaction = array(
                    'paypal_order_id'       => $paypal_order['paypal_order_id'], 
                    'transaction_id'        => '', 
                    'parent_transaction_id' => $paypal_order['authorization_id'], 
                    'note'                  => '', 
                    'msgsubid'              => '', 
                    'receipt_id'            => '', 
                    'payment_type'          => 'void', 
                    'payment_status'        => 'Void', 
                    'pending_reason'        => '', 
                    'transaction_entity'    => 'auth', 
                    'amount'                => '', 
                    'debug_data'            => json_encode($result)
                );
                
                PaymentPaypalExpress::addTransaction($transaction);
                PaymentPaypalExpress::updateOrder('Complete', $this->request->post['order_id']);
                
                unset($transaction['debug_data']);
                $transaction['date_added'] = date("Y-m-d H:i:s");
                
                $json['data'] = $transaction;
                $json['error'] = false;
                $json['msg'] = 'Transaction void';
            } else {
                $json['error'] = true;
                $json['msg'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error');
            }
        } else {
            $json['error'] = true;
            $json['msg'] = 'Missing data';
        }
        
        Response::addHeader('Content-Type: application/json');
        Response::setOutput(json_encode($json));
    }
    
    public function refund() {
        $data = Theme::language('payment/paypal_express_refund');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_paypal_express', 'payment/paypal_express');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_express/refund');
        
        //button actions
        $data['action'] = Url::link('payment/paypal_express/doRefund', '', 'SSL');
        $data['cancel'] = Url::link('payment/paypal_express', '', 'SSL');
        
        $data['transaction_id'] = $this->request->get['transaction_id'];
        
        Theme::model('payment/paypal_express');
        $pp_transaction = PaymentPaypalExpress::getTransaction($this->request->get['transaction_id']);
        
        $data['amount_original'] = $pp_transaction['AMT'];
        $data['currency_code'] = $pp_transaction['CURRENCYCODE'];
        
        $refunded = number_format(PaymentPaypalExpress::totalRefundedTransaction($this->request->get['transaction_id']), 2);
        
        if ($refunded != 0.00) {
            $data['refund_available'] = number_format($data['amount_original'] + $refunded, 2);
            $data['attention'] = Lang::get('lang_text_current_refunds') . ': ' . $data['refund_available'];
        } else {
            $data['refund_available'] = '';
            $data['attention'] = '';
        }
        
        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_express_refund', $data));
    }
    
    public function doRefund() {
        
        /**
         * used to issue a refund for a captured payment
         *
         * refund can be full or partial
         */
        if (isset($this->request->post['transaction_id']) && isset($this->request->post['refund_full'])) {
            
            Theme::model('payment/paypal_express');
            Theme::language('payment/paypal_express_refund');
            
            if ($this->request->post['refund_full'] == 0 && $this->request->post['amount'] == 0) {
                $this->session->data['error'] = Lang::get('lang_error_partial_amt');
            } else {
                $order_id     = PaymentPaypalExpress::getOrderId($this->request->post['transaction_id']);
                $paypal_order = PaymentPaypalExpress::getOrder($order_id);
                
                if ($paypal_order) {
                    $call_data                  = array();
                    $call_data['METHOD']        = 'RefundTransaction';
                    $call_data['TRANSACTIONID'] = $this->request->post['transaction_id'];
                    $call_data['NOTE']          = urlencode($this->request->post['refund_message']);
                    $call_data['MSGSUBID']      = uniqid(mt_rand(), true);
                    
                    $current_transaction = PaymentPaypalExpress::getLocalTransaction($this->request->post['transaction_id']);
                    
                    if ($this->request->post['refund_full'] == 1) {
                        $call_data['REFUNDTYPE'] = 'Full';
                    } else {
                        $call_data['REFUNDTYPE']   = 'Partial';
                        $call_data['AMT']          = number_format($this->request->post['amount'], 2);
                        $call_data['CURRENCYCODE'] = $this->request->post['currency_code'];
                    }
                    
                    $result = PaymentPaypalExpress::call($call_data);
                    
                    $transaction = array(
                        'paypal_order_id'       => $paypal_order['paypal_order_id'], 
                        'transaction_id'        => '', 
                        'parent_transaction_id' => $this->request->post['transaction_id'], 
                        'note'                  => $this->request->post['refund_message'], 
                        'msgsubid'              => $call_data['MSGSUBID'], 
                        'receipt_id'            => '', 
                        'payment_type'          => '', 
                        'payment_status'        => 'Refunded', 
                        'transaction_entity'    => 'payment', 
                        'pending_reason'        => '', 
                        'amount'                => '-' . (isset($call_data['AMT']) ? $call_data['AMT'] : $current_transaction['amount']), 
                        'debug_data'            => json_encode($result)
                    );
                    
                    if ($result === false) {
                        $transaction['payment_status'] = 'Failed';
                        PaymentPaypalExpress::addTransaction($transaction, $call_data);
                        Response::redirect(Url::link('sale/order/info', '' . '&order_id=' . $paypal_order['order_id'], 'SSL'));
                    } else if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning') {
                        
                        $transaction['transaction_id'] = $result['REFUNDTRANSACTIONID'];
                        $transaction['payment_type']   = $result['REFUNDSTATUS'];
                        $transaction['pending_reason'] = $result['PENDINGREASON'];
                        $transaction['amount']         = '-' . $result['GROSSREFUNDAMT'];
                        
                        PaymentPaypalExpress::addTransaction($transaction);
                        
                        //edit transaction to refunded status
                        if ($result['TOTALREFUNDEDAMOUNT'] == $this->request->post['amount_original']) {
                            $this->db->query("
								UPDATE `{$this->db->prefix}paypal_order_transaction` 
								SET 
									`payment_status` = 'Refunded' 
								WHERE `transaction_id` = '" . $this->db->escape($this->request->post['transaction_id']) . "' 
								LIMIT 1");
                        } else {
                            $this->db->query("
								UPDATE `{$this->db->prefix}paypal_order_transaction` 
								SET 
									`payment_status` = 'Partially-Refunded' 
								WHERE `transaction_id` = '" . $this->db->escape($this->request->post['transaction_id']) . "' 
								LIMIT 1");
                        }
                        
                        //redirect back to the order
                        Response::redirect(Url::link('sale/order/info', '' . '&order_id=' . $paypal_order['order_id'], 'SSL'));
                    } else {
                        PaymentPaypalExpress::log(json_encode($result));
                        $this->session->data['error'] = (isset($result['L_SHORTMESSAGE0']) ? $result['L_SHORTMESSAGE0'] : 'There was an error') . (isset($result['L_LONGMESSAGE0']) ? '<br />' . $result['L_LONGMESSAGE0'] : '');
                        Response::redirect(Url::link('payment/paypal_express/refund', '' . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
                    }
                } else {
                    $this->session->data['error'] = Lang::get('lang_error_data_missing');
                    Response::redirect(Url::link('payment/paypal_express/refund', '' . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
                }
            }
        } else {
            $this->session->data['error'] = Lang::get('lang_error_data');
            Response::redirect(Url::link('payment/paypal_express/refund', '' . '&transaction_id=' . $this->request->post['transaction_id'], 'SSL'));
        }
    }
    
    public function install() {
        Theme::model('payment/paypal_express');
        PaymentPaypalExpress::install();
    }
    
    public function uninstall() {
        Theme::model('payment/paypal_express');
        PaymentPaypalExpress::uninstall();
    }
    
    public function orderAction() {
        if (Config::get('paypal_express_status')) {
            $data = Theme::language('payment/paypal_express_order');
            Theme::model('payment/paypal_express');
            
            $paypal_order = PaymentPaypalExpress::getOrder($this->request->get['order_id']);
            
            if ($paypal_order) {
                $data['paypal_order'] = $paypal_order;
                $data['order_id']     = $this->request->get['order_id'];
                
                $captured = number_format(PaymentPaypalExpress::totalCaptured($data['paypal_order']['paypal_order_id']), 2);
                $refunded = number_format(PaymentPaypalExpress::totalRefundedOrder($data['paypal_order']['paypal_order_id']), 2);
                
                $data['paypal_order']['captured']  = $captured;
                $data['paypal_order']['refunded']  = $refunded;
                $data['paypal_order']['remaining'] = number_format($data['paypal_order']['total'] - $captured, 2);
                
                $captured = number_format(PaymentPaypalExpress::totalCaptured($paypal_order['paypal_order_id']), 2);
                $refunded = number_format(PaymentPaypalExpress::totalRefundedOrder($paypal_order['paypal_order_id']), 2);
                
                $data['paypal_order'] = $paypal_order;
                
                $data['paypal_order']['captured']  = $captured;
                $data['paypal_order']['refunded']  = $refunded;
                $data['paypal_order']['remaining'] = number_format($paypal_order['total'] - $captured, 2);
                
                $data['refund_link'] = Url::link('payment/paypal_express/refund', '', 'SSL');
                $data['view_link']   = Url::link('payment/paypal_express/viewTransaction', '', 'SSL');
                $data['resend_link'] = Url::link('payment/paypal_express/resend', '', 'SSL');
                
                Theme::listen(__CLASS__, __FUNCTION__);
                
                return View::render('payment/paypal_express_order', $data);
            }
        }
    }
    
    public function search() {
        $data = Theme::language('payment/paypal_express_search');
        Theme::model('payment/paypal_express');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        $data['currency_codes']   = PaymentPaypalExpress::currencyCodes();
        $data['default_currency'] = Config::get('paypal_express_currency');
        
        Breadcrumb::add('lang_text_paypal_express', 'payment/paypal_express');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_express/search');
        
        $data['date_start'] = date("Y-m-d", strtotime('-30 days'));
        $data['date_end']   = date("Y-m-d");
        $data['view_link']  = Url::link('payment/paypal_express/viewTransaction', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::loadjs('javascript/payment/paypal_express_search', $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_express_search', $data));
    }
    
    public function doSearch() {
        
        /**
         * used to search for transactions from a user account
         */
        if (isset($this->request->post['date_start'])) {
            
            Theme::model('payment/paypal_express');
            
            $call_data = array();
            $call_data['METHOD'] = 'TransactionSearch';
            $call_data['STARTDATE'] = gmdate($this->request->post['date_start'] . "\TH:i:s\Z");
            
            if (!empty($this->request->post['date_end'])) {
                $call_data['ENDDATE'] = gmdate($this->request->post['date_end'] . "\TH:i:s\Z");
            }
            
            if (!empty($this->request->post['transaction_class'])) {
                $call_data['TRANSACTIONCLASS'] = $this->request->post['transaction_class'];
            }
            
            if (!empty($this->request->post['status'])) {
                $call_data['STATUS'] = $this->request->post['status'];
            }
            
            if (!empty($this->request->post['buyer_email'])) {
                $call_data['EMAIL'] = $this->request->post['buyer_email'];
            }
            
            if (!empty($this->request->post['merchant_email'])) {
                $call_data['RECEIVER'] = $this->request->post['merchant_email'];
            }
            
            if (!empty($this->request->post['receipt_id'])) {
                $call_data['RECEIPTID'] = $this->request->post['receipt_id'];
            }
            
            if (!empty($this->request->post['transaction_id'])) {
                $call_data['TRANSACTIONID'] = $this->request->post['transaction_id'];
            }
            
            if (!empty($this->request->post['invoice_number'])) {
                $call_data['INVNUM'] = $this->request->post['invoice_number'];
            }
            
            if (!empty($this->request->post['auction_item_number'])) {
                $call_data['AUCTIONITEMNUMBER'] = $this->request->post['auction_item_number'];
            }
            
            if (!empty($this->request->post['amount'])) {
                $call_data['AMT'] = number_format($this->request->post['amount'], 2);
                $call_data['CURRENCYCODE'] = $this->request->post['currency_code'];
            }
            
            if (!empty($this->request->post['recurring_id'])) {
                $call_data['PROFILEID'] = $this->request->post['recurring_id'];
            }
            
            if (!empty($this->request->post['name_salutation'])) {
                $call_data['SALUTATION'] = $this->request->post['name_salutation'];
            }
            
            if (!empty($this->request->post['name_first'])) {
                $call_data['FIRSTNAME'] = $this->request->post['name_first'];
            }
            
            if (!empty($this->request->post['name_middle'])) {
                $call_data['MIDDLENAME'] = $this->request->post['name_middle'];
            }
            
            if (!empty($this->request->post['name_last'])) {
                $call_data['LASTNAME'] = $this->request->post['name_last'];
            }
            
            if (!empty($this->request->post['name_suffix'])) {
                $call_data['SUFFIX'] = $this->request->post['name_suffix'];
            }
            
            $result = PaymentPaypalExpress::call($call_data);
            
            if ($result['ACK'] != 'Failure' && $result['ACK'] != 'FailureWithWarning' && $result['ACK'] != 'Warning') {
                $response['error']  = false;
                $response['result'] = $this->formatRows($result);
            } else {
                $response['error']     = true;
                $response['error_msg'] = $result['L_LONGMESSAGE0'];
            }
            
            Response::addHeader('Content-Type: application/json');
            Response::setOutput(json_encode($response));
        } else {
            $response['error']     = true;
            $response['error_msg'] = 'Enter a start date';
            Response::addHeader('Content-Type: application/json');
            Response::setOutput(json_encode($response));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function viewTransaction() {
        $data = Theme::language('payment/paypal_express_view');
        Theme::model('payment/paypal_express');
        
        $data['transaction'] = PaymentPaypalExpress::getTransaction($this->request->get['transaction_id']);
        $data['lines']       = $this->formatRows($data['transaction']);
        $data['view_link']   = Url::link('payment/paypal_express/viewTransaction', '', 'SSL');
        $data['cancel']      = Url::link('payment/paypal_express/search', '', 'SSL');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_paypal_express', 'payment/paypal_express');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_express/viewTransaction');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_express_view', $data));
    }
    
    private function formatRows($data) {
        $return = array();
        
        foreach ($data as $k => $v) {
            $elements = preg_split("/(\d+)/", $k, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            if (isset($elements[1]) && isset($elements[0])) {
                if ($elements[0] == 'L_TIMESTAMP') {
                    $v = str_replace('T', ' ', $v);
                    $v = str_replace('Z', '', $v);
                }
                $return[$elements[1]][$elements[0]] = $v;
            }
        }
        
        return $return;
    }
    
    public function recurringCancel() {
        
        //cancel an active recurring
        Lang::load('sale/recurring');
        
        Theme::model('sale/recurring');
        Theme::model('payment/paypal_express');
        
        $recurring = SaleRecurring::getRecurring($this->request->get['order_recurring_id']);
        
        if ($recurring && !empty($recurring['reference'])) {
            
            $result = PaymentPaypalExpress::recurringCancel($recurring['reference']);
            
            if (isset($result['PROFILEID'])) {
                $this->db->query("
					INSERT INTO `{$this->db->prefix}order_recurring_transaction` 
					SET 
						`order_recurring_id` = '" . (int)$recurring['order_recurring_id'] . "', 
						`date_added` = NOW(), 
						`type` = '5'");
                
                $this->db->query("
					UPDATE `{$this->db->prefix}order_recurring` 
					SET 
						`status` = 4 
					WHERE `order_recurring_id` = '" . (int)$recurring['order_recurring_id'] . "' 
					LIMIT 1");
                
                $this->session->data['success'] = Lang::get('lang_text_cancelled');
            } else {
                $this->session->data['error'] = sprintf(Lang::get('lang_error_not_cancelled'), $result['L_LONGMESSAGE0']);
            }
        } else {
            $this->session->data['error'] = Lang::get('lang_error_not_found');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        Response::redirect(Url::link('sale/recurring/info', 'order_recurring_id=' . $this->request->get['order_recurring_id'], 'SSL'));
    }
    
    public function recurringButtons() {
        Theme::model('sale/recurring');
        
        $recurring = SaleRecurring::getRecurring($this->request->get['order_recurring_id']);
        
        $data['buttons'] = array();
        
        if ($recurring['status_id'] == 2 || $recurring['status_id'] == 3) {
            $data['buttons'][] = array(
                'text' => Lang::get('lang_button_cancel_recurring'), 
                'link' => Url::link('payment/paypal_express/recurringCancel', 'order_recurring_id=' . $this->request->get['order_recurring_id'], 'SSL')
            );
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return View::render('common/buttons', $data);
    }
}
