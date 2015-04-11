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

class Check extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/check');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('check', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['payable'])) {
            $data['error_payable'] = $this->error['payable'];
        } else {
            $data['error_payable'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/check');
        
        $data['action'] = $this->url->link('payment/check', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['check_payable'])) {
            $data['check_payable'] = $this->request->post['check_payable'];
        } else {
            $data['check_payable'] = $this->config->get('check_payable');
        }
        
        if (isset($this->request->post['check_total'])) {
            $data['check_total'] = $this->request->post['check_total'];
        } else {
            $data['check_total'] = $this->config->get('check_total');
        }
        
        if (isset($this->request->post['check_order_status_id'])) {
            $data['check_order_status_id'] = $this->request->post['check_order_status_id'];
        } else {
            $data['check_order_status_id'] = $this->config->get('check_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['check_geo_zone_id'])) {
            $data['check_geo_zone_id'] = $this->request->post['check_geo_zone_id'];
        } else {
            $data['check_geo_zone_id'] = $this->config->get('check_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['check_status'])) {
            $data['check_status'] = $this->request->post['check_status'];
        } else {
            $data['check_status'] = $this->config->get('check_status');
        }
        
        if (isset($this->request->post['check_sort_order'])) {
            $data['check_sort_order'] = $this->request->post['check_sort_order'];
        } else {
            $data['check_sort_order'] = $this->config->get('check_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/check', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/check')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['check_payable']) {
            $this->error['payable'] = $this->language->get('lang_error_payable');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
