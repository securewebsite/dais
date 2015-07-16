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
            SettingSetting::editSetting('paypal_pro', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
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
        
        $data['action'] = Url::link('payment/paypal_pro', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset($this->request->post['paypal_pro_username'])) {
            $data['paypal_pro_username'] = $this->request->post['paypal_pro_username'];
        } else {
            $data['paypal_pro_username'] = Config::get('paypal_pro_username');
        }
        
        if (isset($this->request->post['paypal_pro_password'])) {
            $data['paypal_pro_password'] = $this->request->post['paypal_pro_password'];
        } else {
            $data['paypal_pro_password'] = Config::get('paypal_pro_password');
        }
        
        if (isset($this->request->post['paypal_pro_signature'])) {
            $data['paypal_pro_signature'] = $this->request->post['paypal_pro_signature'];
        } else {
            $data['paypal_pro_signature'] = Config::get('paypal_pro_signature');
        }
        
        if (isset($this->request->post['paypal_pro_test'])) {
            $data['paypal_pro_test'] = $this->request->post['paypal_pro_test'];
        } else {
            $data['paypal_pro_test'] = Config::get('paypal_pro_test');
        }
        
        if (isset($this->request->post['paypal_pro_method'])) {
            $data['paypal_pro_transaction'] = $this->request->post['paypal_pro_transaction'];
        } else {
            $data['paypal_pro_transaction'] = Config::get('paypal_pro_transaction');
        }
        
        if (isset($this->request->post['paypal_pro_total'])) {
            $data['paypal_pro_total'] = $this->request->post['paypal_pro_total'];
        } else {
            $data['paypal_pro_total'] = Config::get('paypal_pro_total');
        }
        
        if (isset($this->request->post['paypal_pro_order_status_id'])) {
            $data['paypal_pro_order_status_id'] = $this->request->post['paypal_pro_order_status_id'];
        } else {
            $data['paypal_pro_order_status_id'] = Config::get('paypal_pro_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset($this->request->post['paypal_pro_geo_zone_id'])) {
            $data['paypal_pro_geo_zone_id'] = $this->request->post['paypal_pro_geo_zone_id'];
        } else {
            $data['paypal_pro_geo_zone_id'] = Config::get('paypal_pro_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset($this->request->post['paypal_pro_status'])) {
            $data['paypal_pro_status'] = $this->request->post['paypal_pro_status'];
        } else {
            $data['paypal_pro_status'] = Config::get('paypal_pro_status');
        }
        
        if (isset($this->request->post['paypal_pro_sort_order'])) {
            $data['paypal_pro_sort_order'] = $this->request->post['paypal_pro_sort_order'];
        } else {
            $data['paypal_pro_sort_order'] = Config::get('paypal_pro_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_pro', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/paypal_pro')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['paypal_pro_username']) {
            $this->error['username'] = Lang::get('lang_error_username');
        }
        
        if (!$this->request->post['paypal_pro_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!$this->request->post['paypal_pro_signature']) {
            $this->error['signature'] = Lang::get('lang_error_signature');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
