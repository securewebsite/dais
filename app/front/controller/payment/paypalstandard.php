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

namespace Front\Controller\Payment;
use Dais\Engine\Controller;

class Paypalstandard extends Controller {
    public function index() {
        $data = $this->theme->language('payment/paypalstandard');
        
        $data['testmode'] = $this->config->get('paypalstandard_test');
        
        if (!$this->config->get('paypalstandard_test')) {
            $data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
        
        $this->theme->model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        if ($order_info) {
            $data['business'] = $this->config->get('paypalstandard_email');
            $data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
            
            $data['products'] = array();
            
            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();
                
                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $filename = $this->encryption->decrypt($option['option_value']);
                        
                        $value = $this->encode->substr($filename, 0, $this->encode->strrpos($filename, '.'));
                    }
                    
                    $option_data[] = array('name' => $option['name'], 'value' => ($this->encode->strlen($value) > 20 ? $this->encode->substr($value, 0, 20) . '..' : $value));
                }
                
                $data['products'][] = array('name' => $product['name'], 'model' => $product['model'], 'price' => $this->currency->format($product['price'], $order_info['currency_code'], false, false), 'quantity' => $product['quantity'], 'option' => $option_data, 'weight' => $product['weight']);
            }
            
            $data['discount_amount_cart'] = 0;
            
            $total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $order_info['currency_code'], false, false);
            
            if ($total > 0) {
                $data['products'][] = array('name' => $this->language->get('lang_text_total'), 'model' => '', 'price' => $total, 'quantity' => 1, 'option' => array(), 'weight' => 0);
            } else {
                $data['discount_amount_cart']-= $total;
            }
            
            $data['currency_code'] = $order_info['currency_code'];
            $data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
            $data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
            $data['address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
            $data['address2'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
            $data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
            $data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
            $data['country'] = $order_info['payment_iso_code_2'];
            $data['email'] = $order_info['email'];
            $data['invoice'] = $this->session->data['order_id'] . ' - ' . html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
            $data['lc'] = $this->session->data['language'];
            $data['return'] = $this->url->link('checkout/success');
            $data['notify_url'] = $this->url->link('payment/paypalstandard/callback', '', 'SSL');
            $data['cancel_return'] = $this->url->link('checkout/checkout', '', 'SSL');
            
            if (!$this->config->get('paypalstandard_transaction')) {
                $data['paymentaction'] = 'authorization';
            } else {
                $data['paymentaction'] = 'sale';
            }
            
            $data['custom'] = $this->session->data['order_id'];
            
            $this->theme->loadjs('javascript/payment/paypalstandard', $data);
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $data['javascript'] = $this->theme->controller('common/javascript');
            
            return $this->theme->view('payment/paypalstandard', $data);
        }
    }
    
    public function callback() {
        if (isset($this->request->post['custom'])) {
            $order_id = $this->request->post['custom'];
        } else {
            $order_id = 0;
        }
        
        $this->theme->model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        if ($order_info) {
            $request = 'cmd=_notify-validate';
            
            foreach ($this->request->post as $key => $value) {
                $request.= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }
            
            if (!$this->config->get('paypalstandard_test')) {
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
            
            if (!$response) {
                $this->log->write('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
            }
            
            if ($this->config->get('paypalstandard_debug')) {
                $this->log->write('PP_STANDARD :: IPN REQUEST: ' . $request);
                $this->log->write('PP_STANDARD :: IPN RESPONSE: ' . $response);
            }
            
            if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {
                $order_status_id = $this->config->get('config_order_status_id');
                
                switch ($this->request->post['payment_status']) {
                    case 'Canceled_Reversal':
                        $order_status_id = $this->config->get('paypalstandard_canceled_reversal_status_id');
                        break;

                    case 'Completed':
                        if ((strtolower($this->request->post['receiver_email']) == strtolower($this->config->get('paypalstandard_email'))) && ((float)$this->request->post['mc_gross'] == $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false))) {
                            $order_status_id = $this->config->get('paypalstandard_completed_status_id');
                        } else {
                            $this->log->write('PP_STANDARD :: RECEIVER EMAIL MISMATCH! ' . strtolower($this->request->post['receiver_email']));
                        }
                        break;

                    case 'Denied':
                        $order_status_id = $this->config->get('paypalstandard_denied_status_id');
                        break;

                    case 'Expired':
                        $order_status_id = $this->config->get('paypalstandard_expired_status_id');
                        break;

                    case 'Failed':
                        $order_status_id = $this->config->get('paypalstandard_failed_status_id');
                        break;

                    case 'Pending':
                        $order_status_id = $this->config->get('paypalstandard_pending_status_id');
                        break;

                    case 'Processed':
                        $order_status_id = $this->config->get('paypalstandard_processed_status_id');
                        break;

                    case 'Refunded':
                        $order_status_id = $this->config->get('paypalstandard_refunded_status_id');
                        break;

                    case 'Reversed':
                        $order_status_id = $this->config->get('paypalstandard_reversed_status_id');
                        break;

                    case 'Voided':
                        $order_status_id = $this->config->get('paypalstandard_voided_status_id');
                        break;
                }
                
                if (!$order_info['order_status_id']) {
                    
                    $this->theme->listen(__CLASS__, __FUNCTION__);
                    
                    $this->model_checkout_order->confirm($order_id, $order_status_id);
                } else {
                    $this->theme->listen(__CLASS__, __FUNCTION__);
                    
                    $this->model_checkout_order->update($order_id, $order_status_id);
                }
            } else {
                $this->theme->listen(__CLASS__, __FUNCTION__);
                
                $this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));
            }
            
            curl_close($curl);
        }
    }
}
