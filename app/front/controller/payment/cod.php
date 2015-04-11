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

class Cod extends Controller {
    public function index() {
        $data = $this->theme->language('payment/cod');
        
        $data['continue'] = $this->url->link('checkout/success');
        
        $this->theme->loadjs('javascript/payment/cod', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        return $this->theme->view('payment/cod', $data);
    }
    
    public function confirm() {
        $this->theme->model('checkout/order');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
    }
}
