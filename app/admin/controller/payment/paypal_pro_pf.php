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

class PaypalProPf extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/paypal_pro_pf');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypal_pro_pf', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/paypal_pro_pf');
        
        $data['action'] = $this->url->link('payment/paypal_pro_pf', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypal_pro_pf_vendor'])) {
            $data['paypal_pro_pf_vendor'] = $this->request->post['paypal_pro_pf_vendor'];
        } else {
            $data['paypal_pro_pf_vendor'] = $this->config->get('paypal_pro_pf_vendor');
        }
        
        if (isset($this->request->post['paypal_pro_pf_user'])) {
            $data['paypal_pro_pf_user'] = $this->request->post['paypal_pro_pf_user'];
        } else {
            $data['paypal_pro_pf_user'] = $this->config->get('paypal_pro_pf_user');
        }
        
        if (isset($this->request->post['paypal_pro_pf_password'])) {
            $data['paypal_pro_pf_password'] = $this->request->post['paypal_pro_pf_password'];
        } else {
            $data['paypal_pro_pf_password'] = $this->config->get('paypal_pro_pf_password');
        }
        
        if (isset($this->request->post['paypal_pro_pf_partner'])) {
            $data['paypal_pro_pf_partner'] = $this->request->post['paypal_pro_pf_partner'];
        } elseif ($this->config->has('paypal_pro_pf_partner')) {
            $data['paypal_pro_pf_partner'] = $this->config->get('paypal_pro_pf_partner');
        } else {
            $data['paypal_pro_pf_partner'] = 'PayPal';
        }
        
        if (isset($this->request->post['paypal_pro_pf_test'])) {
            $data['paypal_pro_pf_test'] = $this->request->post['paypal_pro_pf_test'];
        } else {
            $data['paypal_pro_pf_test'] = $this->config->get('paypal_pro_pf_test');
        }
        
        if (isset($this->request->post['paypal_pro_pf_method'])) {
            $data['paypal_pro_pf_transaction'] = $this->request->post['paypal_pro_pf_transaction'];
        } else {
            $data['paypal_pro_pf_transaction'] = $this->config->get('paypal_pro_pf_transaction');
        }
        
        if (isset($this->request->post['paypal_pro_pf_total'])) {
            $data['paypal_pro_pf_total'] = $this->request->post['paypal_pro_pf_total'];
        } else {
            $data['paypal_pro_pf_total'] = $this->config->get('paypal_pro_pf_total');
        }
        
        if (isset($this->request->post['paypal_pro_pf_order_status_id'])) {
            $data['paypal_pro_pf_order_status_id'] = $this->request->post['paypal_pro_pf_order_status_id'];
        } else {
            $data['paypal_pro_pf_order_status_id'] = $this->config->get('paypal_pro_pf_order_status_id');
        }
        
        $this->theme->model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypal_pro_pf_geo_zone_id'])) {
            $data['paypal_pro_pf_geo_zone_id'] = $this->request->post['paypal_pro_pf_geo_zone_id'];
        } else {
            $data['paypal_pro_pf_geo_zone_id'] = $this->config->get('paypal_pro_pf_geo_zone_id');
        }
        
        $this->theme->model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypal_pro_pf_status'])) {
            $data['paypal_pro_pf_status'] = $this->request->post['paypal_pro_pf_status'];
        } else {
            $data['paypal_pro_pf_status'] = $this->config->get('paypal_pro_pf_status');
        }
        
        if (isset($this->request->post['paypal_pro_pf_sort_order'])) {
            $data['paypal_pro_pf_sort_order'] = $this->request->post['paypal_pro_pf_sort_order'];
        } else {
            $data['paypal_pro_pf_sort_order'] = $this->config->get('paypal_pro_pf_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/paypal_pro_pf', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/paypal_pro_pf')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['paypal_pro_pf_vendor']) {
            $this->error['vendor'] = $this->language->get('lang_error_vendor');
        }
        
        if (!$this->request->post['paypal_pro_pf_user']) {
            $this->error['user'] = $this->language->get('lang_error_user');
        }
        
        if (!$this->request->post['paypal_pro_pf_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if (!$this->request->post['paypal_pro_pf_partner']) {
            $this->error['partner'] = $this->language->get('lang_error_partner');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
