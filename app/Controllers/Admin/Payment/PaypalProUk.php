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

class PaypalProUk extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/paypal_pro_uk');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paypalprouk', $this->request->post);
            
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
        Breadcrumb::add('lang_heading_title', 'payment/paypal_pro_uk');
        
        $data['action'] = Url::link('payment/paypal_pro_uk', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['paypalprouk_username'])) {
            $data['paypalprouk_username'] = $this->request->post['paypalprouk_username'];
        } else {
            $data['paypalprouk_username'] = Config::get('paypalprouk_username');
        }
        
        if (isset($this->request->post['paypalprouk_password'])) {
            $data['paypalprouk_password'] = $this->request->post['paypalprouk_password'];
        } else {
            $data['paypalprouk_password'] = Config::get('paypalprouk_password');
        }
        
        if (isset($this->request->post['paypalprouk_signature'])) {
            $data['paypalprouk_signature'] = $this->request->post['paypalprouk_signature'];
        } else {
            $data['paypalprouk_signature'] = Config::get('paypalprouk_signature');
        }
        
        if (isset($this->request->post['paypalprouk_test'])) {
            $data['paypalprouk_test'] = $this->request->post['paypalprouk_test'];
        } else {
            $data['paypalprouk_test'] = Config::get('paypalprouk_test');
        }
        
        if (isset($this->request->post['paypalprouk_method'])) {
            $data['paypalprouk_transaction'] = $this->request->post['paypalprouk_transaction'];
        } else {
            $data['paypalprouk_transaction'] = Config::get('paypalprouk_transaction');
        }
        
        if (isset($this->request->post['paypalprouk_total'])) {
            $data['paypalprouk_total'] = $this->request->post['paypalprouk_total'];
        } else {
            $data['paypalprouk_total'] = Config::get('paypalprouk_total');
        }
        
        if (isset($this->request->post['paypalprouk_order_status_id'])) {
            $data['paypalprouk_order_status_id'] = $this->request->post['paypalprouk_order_status_id'];
        } else {
            $data['paypalprouk_order_status_id'] = Config::get('paypalprouk_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['paypalprouk_geo_zone_id'])) {
            $data['paypalprouk_geo_zone_id'] = $this->request->post['paypalprouk_geo_zone_id'];
        } else {
            $data['paypalprouk_geo_zone_id'] = Config::get('paypalprouk_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['paypalprouk_status'])) {
            $data['paypalprouk_status'] = $this->request->post['paypalprouk_status'];
        } else {
            $data['paypalprouk_status'] = Config::get('paypalprouk_status');
        }
        
        if (isset($this->request->post['paypalprouk_sort_order'])) {
            $data['paypalprouk_sort_order'] = $this->request->post['paypalprouk_sort_order'];
        } else {
            $data['paypalprouk_sort_order'] = Config::get('paypalprouk_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/paypal_pro_uk', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'payment/paypalprouk')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['paypalprouk_username']) {
            $this->error['username'] = Lang::get('lang_error_username');
        }
        
        if (!$this->request->post['paypalprouk_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!$this->request->post['paypalprouk_signature']) {
            $this->error['signature'] = Lang::get('lang_error_signature');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
