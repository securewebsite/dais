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

class Banktransfer extends Controller {
    public function index() {
        $data = $this->theme->language('payment/banktransfer');
        
        $data['bank'] = nl2br($this->config->get('banktransfer_bank_' . $this->config->get('config_language_id')));
        
        $data['continue'] = $this->url->link('checkout/success');
        
        $this->theme->loadjs('javascript/payment/banktransfer', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        return $this->theme->view('payment/banktransfer', $data);
    }
    
    public function confirm() {
        $data = $this->theme->language('payment/banktransfer');
        
        $this->theme->model('checkout/order');
        
        $comment = $this->language->get('lang_text_instruction') . "\n\n";
        $comment.= $this->config->get('banktransfer_bank_' . $this->config->get('config_language_id')) . "\n\n";
        $comment.= $this->language->get('lang_text_payment');
        
        $data['comment'] = $comment;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('banktransfer_order_status_id'), $data['comment'], true);
    }
}
