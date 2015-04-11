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

class Twocheckout extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/twocheckout');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('twocheckout', $this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['account'])) {
            $data['error_account'] = $this->error['account'];
        } else {
            $data['error_account'] = '';
        }
        
        if (isset($this->error['secret'])) {
            $data['error_secret'] = $this->error['secret'];
        } else {
            $data['error_secret'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/twocheckout');
        
        $data['action'] = $this->url->link('payment/twocheckout', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['twocheckout_account'])) {
            $data['twocheckout_account'] = $this->request->post['twocheckout_account'];
        } else {
            $data['twocheckout_account'] = $this->config->get('twocheckout_account');
        }
        
        if (isset($this->request->post['twocheckout_secret'])) {
            $data['twocheckout_secret'] = $this->request->post['twocheckout_secret'];
        } else {
            $data['twocheckout_secret'] = $this->config->get('twocheckout_secret');
        }
        
        if (isset($this->request->post['twocheckout_test'])) {
            $data['twocheckout_test'] = $this->request->post['twocheckout_test'];
        } else {
            $data['twocheckout_test'] = $this->config->get('twocheckout_test');
        }
        
        if (isset($this->request->post['twocheckout_total'])) {
            $data['twocheckout_total'] = $this->request->post['twocheckout_total'];
        } else {
            $data['twocheckout_total'] = $this->config->get('twocheckout_total');
        }
        
        if (isset($this->request->post['twocheckout_order_status_id'])) {
            $data['twocheckout_order_status_id'] = $this->request->post['twocheckout_order_status_id'];
        } else {
            $data['twocheckout_order_status_id'] = $this->config->get('twocheckout_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['twocheckout_geo_zone_id'])) {
            $data['twocheckout_geo_zone_id'] = $this->request->post['twocheckout_geo_zone_id'];
        } else {
            $data['twocheckout_geo_zone_id'] = $this->config->get('twocheckout_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['twocheckout_status'])) {
            $data['twocheckout_status'] = $this->request->post['twocheckout_status'];
        } else {
            $data['twocheckout_status'] = $this->config->get('twocheckout_status');
        }
        
        if (isset($this->request->post['twocheckout_sort_order'])) {
            $data['twocheckout_sort_order'] = $this->request->post['twocheckout_sort_order'];
        } else {
            $data['twocheckout_sort_order'] = $this->config->get('twocheckout_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/twocheckout', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/twocheckout')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['twocheckout_account']) {
            $this->error['account'] = $this->language->get('lang_error_account');
        }
        
        if (!$this->request->post['twocheckout_secret']) {
            $this->error['secret'] = $this->language->get('lang_error_secret');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
