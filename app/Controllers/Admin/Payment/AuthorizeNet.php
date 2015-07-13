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

namespace App\Controllers\Admin\Payment;
use App\Controllers\Controller;

class AuthorizeNet extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/authorize_net');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('authorizenet', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/authorize_netaim');
        
        $data['action'] = Url::link('payment/authorize_netaim', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['authorizenet_login'])) {
            $data['authorizenet_login'] = $this->request->post['authorizenet_login'];
        } else {
            $data['authorizenet_login'] = Config::get('authorizenet_login');
        }
        
        if (isset($this->request->post['authorizenet_key'])) {
            $data['authorizenet_key'] = $this->request->post['authorizenet_key'];
        } else {
            $data['authorizenet_key'] = Config::get('authorizenet_key');
        }
        
        if (isset($this->request->post['authorizenet_hash'])) {
            $data['authorizenet_hash'] = $this->request->post['authorizenet_hash'];
        } else {
            $data['authorizenet_hash'] = Config::get('authorizenet_hash');
        }
        
        if (isset($this->request->post['authorizenet_server'])) {
            $data['authorizenet_server'] = $this->request->post['authorizenet_server'];
        } else {
            $data['authorizenet_server'] = Config::get('authorizenet_server');
        }
        
        if (isset($this->request->post['authorizenet_mode'])) {
            $data['authorizenet_mode'] = $this->request->post['authorizenet_mode'];
        } else {
            $data['authorizenet_mode'] = Config::get('authorizenet_mode');
        }
        
        if (isset($this->request->post['authorizenet_method'])) {
            $data['authorizenet_method'] = $this->request->post['authorizenet_method'];
        } else {
            $data['authorizenet_method'] = Config::get('authorizenet_method');
        }
        
        if (isset($this->request->post['authorizenet_total'])) {
            $data['authorizenet_total'] = $this->request->post['authorizenet_total'];
        } else {
            $data['authorizenet_total'] = Config::get('authorizenet_total');
        }
        
        if (isset($this->request->post['authorizenet_order_status_id'])) {
            $data['authorizenet_order_status_id'] = $this->request->post['authorizenet_order_status_id'];
        } else {
            $data['authorizenet_order_status_id'] = Config::get('authorizenet_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['authorizenet_geo_zone_id'])) {
            $data['authorizenet_geo_zone_id'] = $this->request->post['authorizenet_geo_zone_id'];
        } else {
            $data['authorizenet_geo_zone_id'] = Config::get('authorizenet_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['authorizenet_status'])) {
            $data['authorizenet_status'] = $this->request->post['authorizenet_status'];
        } else {
            $data['authorizenet_status'] = Config::get('authorizenet_status');
        }
        
        if (isset($this->request->post['authorizenet_sort_order'])) {
            $data['authorizenet_sort_order'] = $this->request->post['authorizenet_sort_order'];
        } else {
            $data['authorizenet_sort_order'] = Config::get('authorizenet_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/authorize_net', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/authorizenetaim')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['authorizenet_login']) {
            $this->error['login'] = Lang::get('lang_error_login');
        }
        
        if (!$this->request->post['authorizenet_key']) {
            $this->error['key'] = Lang::get('lang_error_key');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
