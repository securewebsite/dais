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

class Moneybookers extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/moneybookers');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('moneybookers', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/moneybookers');
        
        $data['action'] = $this->url->link('payment/moneybookers', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['moneybookers_email'])) {
            $data['moneybookers_email'] = $this->request->post['moneybookers_email'];
        } else {
            $data['moneybookers_email'] = $this->config->get('moneybookers_email');
        }
        
        if (isset($this->request->post['moneybookers_secret'])) {
            $data['moneybookers_secret'] = $this->request->post['moneybookers_secret'];
        } else {
            $data['moneybookers_secret'] = $this->config->get('moneybookers_secret');
        }
        
        if (isset($this->request->post['moneybookers_total'])) {
            $data['moneybookers_total'] = $this->request->post['moneybookers_total'];
        } else {
            $data['moneybookers_total'] = $this->config->get('moneybookers_total');
        }
        
        if (isset($this->request->post['moneybookers_order_status_id'])) {
            $data['moneybookers_order_status_id'] = $this->request->post['moneybookers_order_status_id'];
        } else {
            $data['moneybookers_order_status_id'] = $this->config->get('moneybookers_order_status_id');
        }
        
        if (isset($this->request->post['moneybookers_pending_status_id'])) {
            $data['moneybookers_pending_status_id'] = $this->request->post['moneybookers_pending_status_id'];
        } else {
            $data['moneybookers_pending_status_id'] = $this->config->get('moneybookers_pending_status_id');
        }
        
        if (isset($this->request->post['moneybookers_canceled_status_id'])) {
            $data['moneybookers_canceled_status_id'] = $this->request->post['moneybookers_canceled_status_id'];
        } else {
            $data['moneybookers_canceled_status_id'] = $this->config->get('moneybookers_canceled_status_id');
        }
        
        if (isset($this->request->post['moneybookers_failed_status_id'])) {
            $data['moneybookers_failed_status_id'] = $this->request->post['moneybookers_failed_status_id'];
        } else {
            $data['moneybookers_failed_status_id'] = $this->config->get('moneybookers_failed_status_id');
        }
        
        if (isset($this->request->post['moneybookers_chargeback_status_id'])) {
            $data['moneybookers_chargeback_status_id'] = $this->request->post['moneybookers_chargeback_status_id'];
        } else {
            $data['moneybookers_chargeback_status_id'] = $this->config->get('moneybookers_chargeback_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['moneybookers_geo_zone_id'])) {
            $data['moneybookers_geo_zone_id'] = $this->request->post['moneybookers_geo_zone_id'];
        } else {
            $data['moneybookers_geo_zone_id'] = $this->config->get('moneybookers_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['moneybookers_status'])) {
            $data['moneybookers_status'] = $this->request->post['moneybookers_status'];
        } else {
            $data['moneybookers_status'] = $this->config->get('moneybookers_status');
        }
        
        if (isset($this->request->post['moneybookers_sort_order'])) {
            $data['moneybookers_sort_order'] = $this->request->post['moneybookers_sort_order'];
        } else {
            $data['moneybookers_sort_order'] = $this->config->get('moneybookers_sort_order');
        }
        
        if (isset($this->request->post['moneybookers_rid'])) {
            $data['moneybookers_rid'] = $this->request->post['moneybookers_rid'];
        } else {
            $data['moneybookers_rid'] = $this->config->get('moneybookers_rid');
        }
        
        if (isset($this->request->post['moneybookers_custnote'])) {
            $data['moneybookers_custnote'] = $this->request->post['moneybookers_custnote'];
        } else {
            $data['moneybookers_custnote'] = $this->config->get('moneybookers_custnote');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/moneybookers', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/moneybookers')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['moneybookers_email']) {
            $this->error['email'] = $this->language->get('lang_error_email');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
