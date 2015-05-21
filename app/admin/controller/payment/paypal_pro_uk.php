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

class PaypalProUk extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/paypal_pro_uk');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypal_pro_uk', $this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['username'])) {
            $data['error_username'] = $this->error['username'];
        } else {
            $data['error_username'] = '';
        }
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['signature'])) {
            $data['error_signature'] = $this->error['signature'];
        } else {
            $data['error_signature'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/paypal_pro_uk');
        
        $data['action'] = $this->url->link('payment/paypal_pro_uk', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypal_pro_uk_username'])) {
            $data['paypal_pro_uk_username'] = $this->request->post['paypal_pro_uk_username'];
        } else {
            $data['paypal_pro_uk_username'] = $this->config->get('paypal_pro_uk_username');
        }
        
        if (isset($this->request->post['paypal_pro_uk_password'])) {
            $data['paypal_pro_uk_password'] = $this->request->post['paypal_pro_uk_password'];
        } else {
            $data['paypal_pro_uk_password'] = $this->config->get('paypal_pro_uk_password');
        }
        
        if (isset($this->request->post['paypal_pro_uk_signature'])) {
            $data['paypal_pro_uk_signature'] = $this->request->post['paypal_pro_uk_signature'];
        } else {
            $data['paypal_pro_uk_signature'] = $this->config->get('paypal_pro_uk_signature');
        }
        
        if (isset($this->request->post['paypal_pro_uk_test'])) {
            $data['paypal_pro_uk_test'] = $this->request->post['paypal_pro_uk_test'];
        } else {
            $data['paypal_pro_uk_test'] = $this->config->get('paypal_pro_uk_test');
        }
        
        if (isset($this->request->post['paypal_pro_uk_method'])) {
            $data['paypal_pro_uk_transaction'] = $this->request->post['paypal_pro_uk_transaction'];
        } else {
            $data['paypal_pro_uk_transaction'] = $this->config->get('paypal_pro_uk_transaction');
        }
        
        if (isset($this->request->post['paypal_pro_uk_total'])) {
            $data['paypal_pro_uk_total'] = $this->request->post['paypal_pro_uk_total'];
        } else {
            $data['paypal_pro_uk_total'] = $this->config->get('paypal_pro_uk_total');
        }
        
        if (isset($this->request->post['paypal_pro_uk_order_status_id'])) {
            $data['paypal_pro_uk_order_status_id'] = $this->request->post['paypal_pro_uk_order_status_id'];
        } else {
            $data['paypal_pro_uk_order_status_id'] = $this->config->get('paypal_pro_uk_order_status_id');
        }
        
        $this->theme->model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypal_pro_uk_geo_zone_id'])) {
            $data['paypal_pro_uk_geo_zone_id'] = $this->request->post['paypal_pro_uk_geo_zone_id'];
        } else {
            $data['paypal_pro_uk_geo_zone_id'] = $this->config->get('paypal_pro_uk_geo_zone_id');
        }
        
        $this->theme->model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypal_pro_uk_status'])) {
            $data['paypal_pro_uk_status'] = $this->request->post['paypal_pro_uk_status'];
        } else {
            $data['paypal_pro_uk_status'] = $this->config->get('paypal_pro_uk_status');
        }
        
        if (isset($this->request->post['paypal_pro_uk_sort_order'])) {
            $data['paypal_pro_uk_sort_order'] = $this->request->post['paypal_pro_uk_sort_order'];
        } else {
            $data['paypal_pro_uk_sort_order'] = $this->config->get('paypal_pro_uk_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/paypal_pro_uk', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/paypal_pro_uk')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['paypal_pro_uk_username']) {
            $this->error['username'] = $this->language->get('lang_error_username');
        }
        
        if (!$this->request->post['paypal_pro_uk_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if (!$this->request->post['paypal_pro_uk_signature']) {
            $this->error['signature'] = $this->language->get('lang_error_signature');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
