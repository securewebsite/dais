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

class Moneybookers extends Controller {
    public function index() {
        Theme::model('checkout/order');
        
        $data = Theme::language('payment/moneybookers');
        
        $data['action'] = 'https://www.moneybookers.com/app/payment.pl?p=Dais';
        
        $data['pay_to_email'] = Config::get('moneybookers_email');
        $data['platform'] = '31974336';
        $data['description'] = Config::get('config_name');
        $data['transaction_id'] = $this->session->data['order_id'];
        $data['return_url'] = Url::link('checkout/success');
        $data['cancel_url'] = Url::link('checkout/checkout', '', 'SSL');
        $data['status_url'] = Url::link('payment/moneybookers/callback');
        $data['language'] = $this->session->data['language'];
        $data['logo'] = Config::get('config_url') . 'image/' . Config::get('config_logo');
        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $data['pay_from_email'] = $order_info['email'];
        $data['firstname'] = $order_info['payment_firstname'];
        $data['lastname'] = $order_info['payment_lastname'];
        $data['address'] = $order_info['payment_address_1'];
        $data['address2'] = $order_info['payment_address_2'];
        $data['phone_number'] = $order_info['telephone'];
        $data['postal_code'] = $order_info['payment_postcode'];
        $data['city'] = $order_info['payment_city'];
        $data['state'] = $order_info['payment_zone'];
        $data['country'] = $order_info['payment_iso_code_3'];
        $data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['currency'] = $order_info['currency_code'];
        
        $products = '';
        
        foreach ($this->cart->getProducts() as $product) {
            $products.= $product['quantity'] . ' x ' . $product['name'] . ', ';
        }
        
        $data['detail1_text'] = $products;
        
        $data['order_id'] = $this->session->data['order_id'];
        
        Theme::loadjs('javascript/payment/moneybookers', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return Theme::view('payment/moneybookers', $data);
    }
    
    public function callback() {
        if (isset($this->request->post['order_id'])) {
            $order_id = $this->request->post['order_id'];
        } else {
            $order_id = 0;
        }
        
        Theme::model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        $order_info = Theme::listen(__CLASS__, __FUNCTION__, $order_info);
        
        if ($order_info) {
            $this->model_checkout_order->confirm($order_id, Config::get('config_order_status_id'));
            
            $verified = true;
            
            // md5sig validation
            if (Config::get('moneybookers_secret')) {
                $hash = $this->request->post['merchant_id'];
                $hash.= $this->request->post['transaction_id'];
                $hash.= strtoupper(md5(Config::get('moneybookers_secret')));
                $hash.= $this->request->post['mb_amount'];
                $hash.= $this->request->post['mb_currency'];
                $hash.= $this->request->post['status'];
                
                $md5hash = strtoupper(md5($hash));
                $md5sig = $this->request->post['md5sig'];
                
                if ($md5hash != $md5sig) {
                    $verified = false;
                }
            }
            
            if ($verified) {
                switch ($this->request->post['status']) {
                    case '2':
                        $this->model_checkout_order->update($order_id, Config::get('moneybookers_order_status_id'));
                        break;

                    case '0':
                        $this->model_checkout_order->update($order_id, Config::get('moneybookers_pending_status_id'));
                        break;

                    case '-1':
                        $this->model_checkout_order->update($order_id, Config::get('moneybookers_canceled_status_id'));
                        break;

                    case '-2':
                        $this->model_checkout_order->update($order_id, Config::get('moneybookers_failed_status_id'));
                        break;

                    case '-3':
                        $this->model_checkout_order->update($order_id, Config::get('moneybookers_chargeback_status_id'));
                        break;
                }
            } else {
                $this->log->write('md5sig returned (' + $md5sig + ') does not match generated (' + $md5hash + '). Verify Manually. Current order state: ' . Config::get('config_order_status_id'));
            }
        }
    }
}
