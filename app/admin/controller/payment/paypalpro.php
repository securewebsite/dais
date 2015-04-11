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

class Paypalpro extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/paypalpro');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypalpro', $this->request->post);
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
        $this->breadcrumb->add('lang_heading_title', 'payment/paypalpro');
        
        $data['action'] = $this->url->link('payment/paypalpro', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypalpro_username'])) {
            $data['paypalpro_username'] = $this->request->post['paypalpro_username'];
        } else {
            $data['paypalpro_username'] = $this->config->get('paypalpro_username');
        }
        
        if (isset($this->request->post['paypalpro_password'])) {
            $data['paypalpro_password'] = $this->request->post['paypalpro_password'];
        } else {
            $data['paypalpro_password'] = $this->config->get('paypalpro_password');
        }
        
        if (isset($this->request->post['paypalpro_signature'])) {
            $data['paypalpro_signature'] = $this->request->post['paypalpro_signature'];
        } else {
            $data['paypalpro_signature'] = $this->config->get('paypalpro_signature');
        }
        
        if (isset($this->request->post['paypalpro_test'])) {
            $data['paypalpro_test'] = $this->request->post['paypalpro_test'];
        } else {
            $data['paypalpro_test'] = $this->config->get('paypalpro_test');
        }
        
        if (isset($this->request->post['paypalpro_method'])) {
            $data['paypalpro_transaction'] = $this->request->post['paypalpro_transaction'];
        } else {
            $data['paypalpro_transaction'] = $this->config->get('paypalpro_transaction');
        }
        
        if (isset($this->request->post['paypalpro_total'])) {
            $data['paypalpro_total'] = $this->request->post['paypalpro_total'];
        } else {
            $data['paypalpro_total'] = $this->config->get('paypalpro_total');
        }
        
        if (isset($this->request->post['paypalpro_order_status_id'])) {
            $data['paypalpro_order_status_id'] = $this->request->post['paypalpro_order_status_id'];
        } else {
            $data['paypalpro_order_status_id'] = $this->config->get('paypalpro_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['paypalpro_geo_zone_id'])) {
            $data['paypalpro_geo_zone_id'] = $this->request->post['paypalpro_geo_zone_id'];
        } else {
            $data['paypalpro_geo_zone_id'] = $this->config->get('paypalpro_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['paypalpro_status'])) {
            $data['paypalpro_status'] = $this->request->post['paypalpro_status'];
        } else {
            $data['paypalpro_status'] = $this->config->get('paypalpro_status');
        }
        
        if (isset($this->request->post['paypalpro_sort_order'])) {
            $data['paypalpro_sort_order'] = $this->request->post['paypalpro_sort_order'];
        } else {
            $data['paypalpro_sort_order'] = $this->config->get('paypalpro_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/paypalpro', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/paypalpro')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['paypalpro_username']) {
            $this->error['username'] = $this->language->get('lang_error_username');
        }
        
        if (!$this->request->post['paypalpro_password']) {
            $this->error['password'] = $this->language->get('lang_error_password');
        }
        
        if (!$this->request->post['paypalpro_signature']) {
            $this->error['signature'] = $this->language->get('lang_error_signature');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
