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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('paypal_pro_pf', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
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
        
        $data['action'] = Url::link('payment/paypal_pro_pf', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['paypal_pro_pf_vendor'])) {
            $data['paypal_pro_pf_vendor'] = Request::p()->post['paypal_pro_pf_vendor'];
        } else {
            $data['paypal_pro_pf_vendor'] = Config::get('paypal_pro_pf_vendor');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_user'])) {
            $data['paypal_pro_pf_user'] = Request::p()->post['paypal_pro_pf_user'];
        } else {
            $data['paypal_pro_pf_user'] = Config::get('paypal_pro_pf_user');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_password'])) {
            $data['paypal_pro_pf_password'] = Request::p()->post['paypal_pro_pf_password'];
        } else {
            $data['paypal_pro_pf_password'] = Config::get('paypal_pro_pf_password');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_partner'])) {
            $data['paypal_pro_pf_partner'] = Request::p()->post['paypal_pro_pf_partner'];
        } elseif ($this->config->has('paypal_pro_pf_partner')) {
            $data['paypal_pro_pf_partner'] = Config::get('paypal_pro_pf_partner');
        } else {
            $data['paypal_pro_pf_partner'] = 'PayPal';
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_test'])) {
            $data['paypal_pro_pf_test'] = Request::p()->post['paypal_pro_pf_test'];
        } else {
            $data['paypal_pro_pf_test'] = Config::get('paypal_pro_pf_test');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_method'])) {
            $data['paypal_pro_pf_transaction'] = Request::p()->post['paypal_pro_pf_transaction'];
        } else {
            $data['paypal_pro_pf_transaction'] = Config::get('paypal_pro_pf_transaction');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_total'])) {
            $data['paypal_pro_pf_total'] = Request::p()->post['paypal_pro_pf_total'];
        } else {
            $data['paypal_pro_pf_total'] = Config::get('paypal_pro_pf_total');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_order_status_id'])) {
            $data['paypal_pro_pf_order_status_id'] = Request::p()->post['paypal_pro_pf_order_status_id'];
        } else {
            $data['paypal_pro_pf_order_status_id'] = Config::get('paypal_pro_pf_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['paypal_pro_pf_geo_zone_id'])) {
            $data['paypal_pro_pf_geo_zone_id'] = Request::p()->post['paypal_pro_pf_geo_zone_id'];
        } else {
            $data['paypal_pro_pf_geo_zone_id'] = Config::get('paypal_pro_pf_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['paypal_pro_pf_status'])) {
            $data['paypal_pro_pf_status'] = Request::p()->post['paypal_pro_pf_status'];
        } else {
            $data['paypal_pro_pf_status'] = Config::get('paypal_pro_pf_status');
        }
        
        if (isset(Request::p()->post['paypal_pro_pf_sort_order'])) {
            $data['paypal_pro_pf_sort_order'] = Request::p()->post['paypal_pro_pf_sort_order'];
        } else {
            $data['paypal_pro_pf_sort_order'] = Config::get('paypal_pro_pf_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_pro_pf', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'payment/paypal_pro_pf')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['paypal_pro_pf_vendor']) {
            $this->error['vendor'] = Lang::get('lang_error_vendor');
        }
        
        if (!Request::p()->post['paypal_pro_pf_user']) {
            $this->error['user'] = Lang::get('lang_error_user');
        }
        
        if (!Request::p()->post['paypal_pro_pf_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!Request::p()->post['paypal_pro_pf_partner']) {
            $this->error['partner'] = Lang::get('lang_error_partner');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
