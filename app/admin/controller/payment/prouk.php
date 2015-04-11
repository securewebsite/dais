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

class Prouk extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/prouk');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('prouk', $this->request->post);
            
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
        $this->breadcrumb->add('lang_heading_title', 'payment/prouk');
        
        $data['action'] = $this->url->link('payment/prouk', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['prouk_username'])) {
            $data['prouk_username'] = $this->request->post['prouk_username'];
        } else {
            $data['prouk_username'] = $this->config->get('prouk_username');
        }
        
        if (isset($this->request->post['prouk_password'])) {
            $data['prouk_password'] = $this->request->post['prouk_password'];
        } else {
            $data['prouk_password'] = $this->config->get('prouk_password');
        }
        
        if (isset($this->request->post['prouk_signature'])) {
            $data['prouk_signature'] = $this->request->post['prouk_signature'];
        } else {
            $data['prouk_signature'] = $this->config->get('prouk_signature');
        }
        
        if (isset($this->request->post['prouk_test'])) {
            $data['prouk_test'] = $this->request->post['prouk_test'];
        } else {
            $data['prouk_test'] = $this->config->get('prouk_test');
        }
        
        if (isset($this->request->post['prouk_method'])) {
            $data['prouk_transaction'] = $this->request->post['prouk_transaction'];
        } else {
            $data['prouk_transaction'] = $this->config->get('prouk_transaction');
        }
        
        if (isset($this->request->post['prouk_total'])) {
            $data['prouk_total'] = $this->request->post['prouk_total'];
        } else {
            $data['prouk_total'] = $this->config->get('prouk_total');
        }
        
        if (isset($this->request->post['prouk_order_status_id'])) {
            $data['prouk_order_status_id'] = $this->request->post['prouk_order_status_id'];
        } else {
            $data['prouk_order_status_id'] = $this->config->get('prouk_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['prouk_geo_zone_id'])) {
            $data['prouk_geo_zone_id'] = $this->request->post['prouk_geo_zone_id'];
        } else {
            $data['prouk_geo_zone_id'] = $this->config->get('prouk_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['prouk_status'])) {
            $data['prouk_status'] = $this->request->post['prouk_status'];
        } else {
            $data['prouk_status'] = $this->config->get('prouk_status');
        }
        
        if (isset($this->request->post['prouk_sort_order'])) {
            $data['prouk_sort_order'] = $this->request->post['prouk_sort_order'];
        } else {
            $data['prouk_sort_order'] = $this->config->get('prouk_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/prouk', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/prouk')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['prouk_username']) {
            $this->error['username'] = $this->language->get('lang_error_username');
        }
        
        if (!$this->request->post['prouk_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if (!$this->request->post['prouk_signature']) {
            $this->error['signature'] = $this->language->get('lang_error_signature');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
