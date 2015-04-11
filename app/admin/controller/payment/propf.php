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

class Propf extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/propf');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('propf', $this->request->post);
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
        $this->breadcrumb->add('lang_heading_title', 'payment/pppropf');
        
        $data['action'] = $this->url->link('payment/pppropf', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['propf_vendor'])) {
            $data['propf_vendor'] = $this->request->post['propf_vendor'];
        } else {
            $data['propf_vendor'] = $this->config->get('propf_vendor');
        }
        
        if (isset($this->request->post['propf_user'])) {
            $data['propf_user'] = $this->request->post['propf_user'];
        } else {
            $data['propf_user'] = $this->config->get('propf_user');
        }
        
        if (isset($this->request->post['propf_password'])) {
            $data['propf_password'] = $this->request->post['propf_password'];
        } else {
            $data['propf_password'] = $this->config->get('propf_password');
        }
        
        if (isset($this->request->post['propf_partner'])) {
            $data['propf_partner'] = $this->request->post['propf_partner'];
        } elseif ($this->config->has('propf_partner')) {
            $data['propf_partner'] = $this->config->get('propf_partner');
        } else {
            $data['propf_partner'] = 'PayPal';
        }
        
        if (isset($this->request->post['propf_test'])) {
            $data['propf_test'] = $this->request->post['propf_test'];
        } else {
            $data['propf_test'] = $this->config->get('propf_test');
        }
        
        if (isset($this->request->post['propf_method'])) {
            $data['propf_transaction'] = $this->request->post['propf_transaction'];
        } else {
            $data['propf_transaction'] = $this->config->get('propf_transaction');
        }
        
        if (isset($this->request->post['propf_total'])) {
            $data['propf_total'] = $this->request->post['propf_total'];
        } else {
            $data['propf_total'] = $this->config->get('propf_total');
        }
        
        if (isset($this->request->post['propf_order_status_id'])) {
            $data['propf_order_status_id'] = $this->request->post['propf_order_status_id'];
        } else {
            $data['propf_order_status_id'] = $this->config->get('propf_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['propf_geo_zone_id'])) {
            $data['propf_geo_zone_id'] = $this->request->post['propf_geo_zone_id'];
        } else {
            $data['propf_geo_zone_id'] = $this->config->get('propf_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['propf_status'])) {
            $data['propf_status'] = $this->request->post['propf_status'];
        } else {
            $data['propf_status'] = $this->config->get('propf_status');
        }
        
        if (isset($this->request->post['propf_sort_order'])) {
            $data['propf_sort_order'] = $this->request->post['propf_sort_order'];
        } else {
            $data['propf_sort_order'] = $this->config->get('propf_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/propf', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/pppropf')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['propf_vendor']) {
            $this->error['vendor'] = $this->language->get('lang_error_vendor');
        }
        
        if (!$this->request->post['propf_user']) {
            $this->error['user'] = $this->language->get('lang_error_user');
        }
        
        if (!$this->request->post['propf_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if (!$this->request->post['propf_partner']) {
            $this->error['partner'] = $this->language->get('lang_error_partner');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
