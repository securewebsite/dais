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

class PaypalPro extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/paypal_pro');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypalpro', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/paypal_pro');
        
        $data['action'] = Url::link('payment/paypal_pro', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypalpro_username'])) {
            $data['paypalpro_username'] = $this->request->post['paypalpro_username'];
        } else {
            $data['paypalpro_username'] = Config::get('paypalpro_username');
        }
        
        if (isset($this->request->post['paypalpro_password'])) {
            $data['paypalpro_password'] = $this->request->post['paypalpro_password'];
        } else {
            $data['paypalpro_password'] = Config::get('paypalpro_password');
        }
        
        if (isset($this->request->post['paypalpro_signature'])) {
            $data['paypalpro_signature'] = $this->request->post['paypalpro_signature'];
        } else {
            $data['paypalpro_signature'] = Config::get('paypalpro_signature');
        }
        
        if (isset($this->request->post['paypalpro_test'])) {
            $data['paypalpro_test'] = $this->request->post['paypalpro_test'];
        } else {
            $data['paypalpro_test'] = Config::get('paypalpro_test');
        }
        
        if (isset($this->request->post['paypalpro_method'])) {
            $data['paypalpro_transaction'] = $this->request->post['paypalpro_transaction'];
        } else {
            $data['paypalpro_transaction'] = Config::get('paypalpro_transaction');
        }
        
        if (isset($this->request->post['paypalpro_total'])) {
            $data['paypalpro_total'] = $this->request->post['paypalpro_total'];
        } else {
            $data['paypalpro_total'] = Config::get('paypalpro_total');
        }
        
        if (isset($this->request->post['paypalpro_order_status_id'])) {
            $data['paypalpro_order_status_id'] = $this->request->post['paypalpro_order_status_id'];
        } else {
            $data['paypalpro_order_status_id'] = Config::get('paypalpro_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypalpro_geo_zone_id'])) {
            $data['paypalpro_geo_zone_id'] = $this->request->post['paypalpro_geo_zone_id'];
        } else {
            $data['paypalpro_geo_zone_id'] = Config::get('paypalpro_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypalpro_status'])) {
            $data['paypalpro_status'] = $this->request->post['paypalpro_status'];
        } else {
            $data['paypalpro_status'] = Config::get('paypalpro_status');
        }
        
        if (isset($this->request->post['paypalpro_sort_order'])) {
            $data['paypalpro_sort_order'] = $this->request->post['paypalpro_sort_order'];
        } else {
            $data['paypalpro_sort_order'] = Config::get('paypalpro_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_pro', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/paypalpro')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['paypalpro_username']) {
            $this->error['username'] = Lang::get('lang_error_username');
        }
        
        if (!$this->request->post['paypalpro_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!$this->request->post['paypalpro_signature']) {
            $this->error['signature'] = Lang::get('lang_error_signature');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
