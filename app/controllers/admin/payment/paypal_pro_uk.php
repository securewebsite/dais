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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('paypal_pro_uk', Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
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
        Breadcrumb::add('lang_heading_title', 'payment/paypal_pro_uk');
        
        $data['action'] = Url::link('payment/paypal_pro_uk', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['paypal_pro_uk_username'])) {
            $data['paypal_pro_uk_username'] = Request::p()->post['paypal_pro_uk_username'];
        } else {
            $data['paypal_pro_uk_username'] = Config::get('paypal_pro_uk_username');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_password'])) {
            $data['paypal_pro_uk_password'] = Request::p()->post['paypal_pro_uk_password'];
        } else {
            $data['paypal_pro_uk_password'] = Config::get('paypal_pro_uk_password');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_signature'])) {
            $data['paypal_pro_uk_signature'] = Request::p()->post['paypal_pro_uk_signature'];
        } else {
            $data['paypal_pro_uk_signature'] = Config::get('paypal_pro_uk_signature');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_test'])) {
            $data['paypal_pro_uk_test'] = Request::p()->post['paypal_pro_uk_test'];
        } else {
            $data['paypal_pro_uk_test'] = Config::get('paypal_pro_uk_test');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_method'])) {
            $data['paypal_pro_uk_transaction'] = Request::p()->post['paypal_pro_uk_transaction'];
        } else {
            $data['paypal_pro_uk_transaction'] = Config::get('paypal_pro_uk_transaction');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_total'])) {
            $data['paypal_pro_uk_total'] = Request::p()->post['paypal_pro_uk_total'];
        } else {
            $data['paypal_pro_uk_total'] = Config::get('paypal_pro_uk_total');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_order_status_id'])) {
            $data['paypal_pro_uk_order_status_id'] = Request::p()->post['paypal_pro_uk_order_status_id'];
        } else {
            $data['paypal_pro_uk_order_status_id'] = Config::get('paypal_pro_uk_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['paypal_pro_uk_geo_zone_id'])) {
            $data['paypal_pro_uk_geo_zone_id'] = Request::p()->post['paypal_pro_uk_geo_zone_id'];
        } else {
            $data['paypal_pro_uk_geo_zone_id'] = Config::get('paypal_pro_uk_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['paypal_pro_uk_status'])) {
            $data['paypal_pro_uk_status'] = Request::p()->post['paypal_pro_uk_status'];
        } else {
            $data['paypal_pro_uk_status'] = Config::get('paypal_pro_uk_status');
        }
        
        if (isset(Request::p()->post['paypal_pro_uk_sort_order'])) {
            $data['paypal_pro_uk_sort_order'] = Request::p()->post['paypal_pro_uk_sort_order'];
        } else {
            $data['paypal_pro_uk_sort_order'] = Config::get('paypal_pro_uk_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/paypal_pro_uk', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'payment/paypal_pro_uk')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['paypal_pro_uk_username']) {
            $this->error['username'] = Lang::get('lang_error_username');
        }
        
        if (!Request::p()->post['paypal_pro_uk_password']) {
            $this->error['password'] = Lang::get('lang_error_password');
        }
        
        if (!Request::p()->post['paypal_pro_uk_signature']) {
            $this->error['signature'] = Lang::get('lang_error_signature');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
