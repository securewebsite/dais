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

class TwoCheckout extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/two_checkout');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('two_checkout', $this->request->post);
            
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
        $this->breadcrumb->add('lang_heading_title', 'payment/two_checkout');
        
        $data['action'] = $this->url->link('payment/two_checkout', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['two_checkout_account'])) {
            $data['two_checkout_account'] = $this->request->post['two_checkout_account'];
        } else {
            $data['two_checkout_account'] = $this->config->get('two_checkout_account');
        }
        
        if (isset($this->request->post['two_checkout_secret'])) {
            $data['two_checkout_secret'] = $this->request->post['two_checkout_secret'];
        } else {
            $data['two_checkout_secret'] = $this->config->get('two_checkout_secret');
        }
        
        if (isset($this->request->post['two_checkout_test'])) {
            $data['two_checkout_test'] = $this->request->post['two_checkout_test'];
        } else {
            $data['two_checkout_test'] = $this->config->get('two_checkout_test');
        }
        
        if (isset($this->request->post['two_checkout_total'])) {
            $data['two_checkout_total'] = $this->request->post['two_checkout_total'];
        } else {
            $data['two_checkout_total'] = $this->config->get('two_checkout_total');
        }
        
        if (isset($this->request->post['two_checkout_order_status_id'])) {
            $data['two_checkout_order_status_id'] = $this->request->post['two_checkout_order_status_id'];
        } else {
            $data['two_checkout_order_status_id'] = $this->config->get('two_checkout_order_status_id');
        }
        
        $this->theme->model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['two_checkout_geo_zone_id'])) {
            $data['two_checkout_geo_zone_id'] = $this->request->post['two_checkout_geo_zone_id'];
        } else {
            $data['two_checkout_geo_zone_id'] = $this->config->get('two_checkout_geo_zone_id');
        }
        
        $this->theme->model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['two_checkout_status'])) {
            $data['two_checkout_status'] = $this->request->post['two_checkout_status'];
        } else {
            $data['two_checkout_status'] = $this->config->get('two_checkout_status');
        }
        
        if (isset($this->request->post['two_checkout_sort_order'])) {
            $data['two_checkout_sort_order'] = $this->request->post['two_checkout_sort_order'];
        } else {
            $data['two_checkout_sort_order'] = $this->config->get('two_checkout_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/two_checkout', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/two_checkout')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['two_checkout_account']) {
            $this->error['account'] = $this->language->get('lang_error_account');
        }
        
        if (!$this->request->post['two_checkout_secret']) {
            $this->error['secret'] = $this->language->get('lang_error_secret');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
