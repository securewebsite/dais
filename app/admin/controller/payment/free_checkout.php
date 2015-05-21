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

class FreeCheckout extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/free_checkout');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('free_checkout', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/free_checkout');
        
        $data['action'] = $this->url->link('payment/free_checkout', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['free_checkout_order_status_id'])) {
            $data['free_checkout_order_status_id'] = $this->request->post['free_checkout_order_status_id'];
        } else {
            $data['free_checkout_order_status_id'] = $this->config->get('free_checkout_order_status_id');
        }
        
        $this->theme->model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['free_checkout_status'])) {
            $data['free_checkout_status'] = $this->request->post['free_checkout_status'];
        } else {
            $data['free_checkout_status'] = $this->config->get('free_checkout_status');
        }
        
        if (isset($this->request->post['free_checkout_sort_order'])) {
            $data['free_checkout_sort_order'] = $this->request->post['free_checkout_sort_order'];
        } else {
            $data['free_checkout_sort_order'] = $this->config->get('free_checkout_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/free_checkout', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/free_checkout')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
