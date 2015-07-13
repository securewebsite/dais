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

class PaypalProPf extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/paypal_pro_pf');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypalpropf', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_pro_pf');
        
        $data['action'] = Url::link('payment/paypal_pro_pf', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypalpropf_vendor'])) {
            $data['paypalpropf_vendor'] = $this->request->post['paypalpropf_vendor'];
        } else {
            $data['paypalpropf_vendor'] = Config::get('paypalpropf_vendor');
        }
        
        if (isset($this->request->post['paypalpropf_user'])) {
            $data['paypalpropf_user'] = $this->request->post['paypalpropf_user'];
        } else {
            $data['paypalpropf_user'] = Config::get('paypalpropf_user');
        }
        
        if (isset($this->request->post['paypalpropf_password'])) {
            $data['paypalpropf_password'] = $this->request->post['paypalpropf_password'];
        } else {
            $data['paypalpropf_password'] = Config::get('paypalpropf_password');
        }
        
        if (isset($this->request->post['paypalpropf_partner'])) {
            $data['paypalpropf_partner'] = $this->request->post['paypalpropf_partner'];
        } elseif ($this->config->has('paypalpropf_partner')) {
            $data['paypalpropf_partner'] = Config::get('paypalpropf_partner');
        } else {
            $data['paypalpropf_partner'] = 'PayPal';
        }
        
        if (isset($this->request->post['paypalpropf_test'])) {
            $data['paypalpropf_test'] = $this->request->post['paypalpropf_test'];
        } else {
            $data['paypalpropf_test'] = Config::get('paypalpropf_test');
        }
        
        if (isset($this->request->post['paypalpropf_method'])) {
            $data['paypalpropf_transaction'] = $this->request->post['paypalpropf_transaction'];
        } else {
            $data['paypalpropf_transaction'] = Config::get('paypalpropf_transaction');
        }
        
        if (isset($this->request->post['paypalpropf_total'])) {
            $data['paypalpropf_total'] = $this->request->post['paypalpropf_total'];
        } else {
            $data['paypalpropf_total'] = Config::get('paypalpropf_total');
        }
        
        if (isset($this->request->post['paypalpropf_order_status_id'])) {
            $data['paypalpropf_order_status_id'] = $this->request->post['paypalpropf_order_status_id'];
        } else {
            $data['paypalpropf_order_status_id'] = Config::get('paypalpropf_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypalpropf_geo_zone_id'])) {
            $data['paypalpropf_geo_zone_id'] = $this->request->post['paypalpropf_geo_zone_id'];
        } else {
            $data['paypalpropf_geo_zone_id'] = Config::get('paypalpropf_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypalpropf_status'])) {
            $data['paypalpropf_status'] = $this->request->post['paypalpropf_status'];
        } else {
            $data['paypalpropf_status'] = Config::get('paypalpropf_status');
        }
        
        if (isset($this->request->post['paypalpropf_sort_order'])) {
            $data['paypalpropf_sort_order'] = $this->request->post['paypalpropf_sort_order'];
        } else {
            $data['paypalpropf_sort_order'] = Config::get('paypalpropf_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_pro_pf', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'payment/paypalpropf')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['paypalpropf_vendor']) {
            $this->error['vendor'] = Lang::get('lang_error_vendor');
        }
        
        if (!$this->request->post['paypalpropf_user']) {
            $this->error['user'] = Lang::get('lang_error_user');
        }
        
        if (!$this->request->post['paypalpropf_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!$this->request->post['paypalpropf_partner']) {
            $this->error['partner'] = Lang::get('lang_error_partner');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
