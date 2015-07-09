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

class AuthorizeNet extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/authorize_net');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('authorize_net', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            Response::redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        $this->breadcrumb->add('lang_heading_title', 'payment/authorize_netaim');
        
        $data['action'] = $this->url->link('payment/authorize_netaim', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['authorize_net_login'])) {
            $data['authorize_net_login'] = $this->request->post['authorize_net_login'];
        } else {
            $data['authorize_net_login'] = Config::get('authorize_net_login');
        }
        
        if (isset($this->request->post['authorize_net_key'])) {
            $data['authorize_net_key'] = $this->request->post['authorize_net_key'];
        } else {
            $data['authorize_net_key'] = Config::get('authorize_net_key');
        }
        
        if (isset($this->request->post['authorize_net_hash'])) {
            $data['authorize_net_hash'] = $this->request->post['authorize_net_hash'];
        } else {
            $data['authorize_net_hash'] = Config::get('authorize_net_hash');
        }
        
        if (isset($this->request->post['authorize_net_server'])) {
            $data['authorize_net_server'] = $this->request->post['authorize_net_server'];
        } else {
            $data['authorize_net_server'] = Config::get('authorize_net_server');
        }
        
        if (isset($this->request->post['authorize_net_mode'])) {
            $data['authorize_net_mode'] = $this->request->post['authorize_net_mode'];
        } else {
            $data['authorize_net_mode'] = Config::get('authorize_net_mode');
        }
        
        if (isset($this->request->post['authorize_net_method'])) {
            $data['authorize_net_method'] = $this->request->post['authorize_net_method'];
        } else {
            $data['authorize_net_method'] = Config::get('authorize_net_method');
        }
        
        if (isset($this->request->post['authorize_net_total'])) {
            $data['authorize_net_total'] = $this->request->post['authorize_net_total'];
        } else {
            $data['authorize_net_total'] = Config::get('authorize_net_total');
        }
        
        if (isset($this->request->post['authorize_net_order_status_id'])) {
            $data['authorize_net_order_status_id'] = $this->request->post['authorize_net_order_status_id'];
        } else {
            $data['authorize_net_order_status_id'] = Config::get('authorize_net_order_status_id');
        }
        
        Theme::model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['authorize_net_geo_zone_id'])) {
            $data['authorize_net_geo_zone_id'] = $this->request->post['authorize_net_geo_zone_id'];
        } else {
            $data['authorize_net_geo_zone_id'] = Config::get('authorize_net_geo_zone_id');
        }
        
        Theme::model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['authorize_net_status'])) {
            $data['authorize_net_status'] = $this->request->post['authorize_net_status'];
        } else {
            $data['authorize_net_status'] = Config::get('authorize_net_status');
        }
        
        if (isset($this->request->post['authorize_net_sort_order'])) {
            $data['authorize_net_sort_order'] = $this->request->post['authorize_net_sort_order'];
        } else {
            $data['authorize_net_sort_order'] = Config::get('authorize_net_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/authorize_net', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/authorize_netaim')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['authorize_net_login']) {
            $this->error['login'] = $this->language->get('lang_error_login');
        }
        
        if (!$this->request->post['authorize_net_key']) {
            $this->error['key'] = $this->language->get('lang_error_key');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
