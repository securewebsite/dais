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

class Authorizenet extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/authorizenet');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('authorizenet', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['login'])) {
            $data['error_login'] = $this->error['login'];
        } else {
            $data['error_login'] = '';
        }
        
        if (isset($this->error['key'])) {
            $data['error_key'] = $this->error['key'];
        } else {
            $data['error_key'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/authorizenetaim');
        
        $data['action'] = $this->url->link('payment/authorizenetaim', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['authorizenet_login'])) {
            $data['authorizenet_login'] = $this->request->post['authorizenet_login'];
        } else {
            $data['authorizenet_login'] = $this->config->get('authorizenet_login');
        }
        
        if (isset($this->request->post['authorizenet_key'])) {
            $data['authorizenet_key'] = $this->request->post['authorizenet_key'];
        } else {
            $data['authorizenet_key'] = $this->config->get('authorizenet_key');
        }
        
        if (isset($this->request->post['authorizenet_hash'])) {
            $data['authorizenet_hash'] = $this->request->post['authorizenet_hash'];
        } else {
            $data['authorizenet_hash'] = $this->config->get('authorizenet_hash');
        }
        
        if (isset($this->request->post['authorizenet_server'])) {
            $data['authorizenet_server'] = $this->request->post['authorizenet_server'];
        } else {
            $data['authorizenet_server'] = $this->config->get('authorizenet_server');
        }
        
        if (isset($this->request->post['authorizenet_mode'])) {
            $data['authorizenet_mode'] = $this->request->post['authorizenet_mode'];
        } else {
            $data['authorizenet_mode'] = $this->config->get('authorizenet_mode');
        }
        
        if (isset($this->request->post['authorizenet_method'])) {
            $data['authorizenet_method'] = $this->request->post['authorizenet_method'];
        } else {
            $data['authorizenet_method'] = $this->config->get('authorizenet_method');
        }
        
        if (isset($this->request->post['authorizenet_total'])) {
            $data['authorizenet_total'] = $this->request->post['authorizenet_total'];
        } else {
            $data['authorizenet_total'] = $this->config->get('authorizenet_total');
        }
        
        if (isset($this->request->post['authorizenet_order_status_id'])) {
            $data['authorizenet_order_status_id'] = $this->request->post['authorizenet_order_status_id'];
        } else {
            $data['authorizenet_order_status_id'] = $this->config->get('authorizenet_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['authorizenet_geo_zone_id'])) {
            $data['authorizenet_geo_zone_id'] = $this->request->post['authorizenet_geo_zone_id'];
        } else {
            $data['authorizenet_geo_zone_id'] = $this->config->get('authorizenet_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['authorizenet_status'])) {
            $data['authorizenet_status'] = $this->request->post['authorizenet_status'];
        } else {
            $data['authorizenet_status'] = $this->config->get('authorizenet_status');
        }
        
        if (isset($this->request->post['authorizenet_sort_order'])) {
            $data['authorizenet_sort_order'] = $this->request->post['authorizenet_sort_order'];
        } else {
            $data['authorizenet_sort_order'] = $this->config->get('authorizenet_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/authorizenet', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/authorizenetaim')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['authorizenet_login']) {
            $this->error['login'] = $this->language->get('lang_error_login');
        }
        
        if (!$this->request->post['authorizenet_key']) {
            $this->error['key'] = $this->language->get('lang_error_key');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
