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

class TwoCheckout extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/two_checkout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('two_checkout', Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
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
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/two_checkout');
        
        $data['action'] = Url::link('payment/two_checkout', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['two_checkout_account'])) {
            $data['two_checkout_account'] = Request::p()->post['two_checkout_account'];
        } else {
            $data['two_checkout_account'] = Config::get('two_checkout_account');
        }
        
        if (isset(Request::p()->post['two_checkout_secret'])) {
            $data['two_checkout_secret'] = Request::p()->post['two_checkout_secret'];
        } else {
            $data['two_checkout_secret'] = Config::get('two_checkout_secret');
        }
        
        if (isset(Request::p()->post['two_checkout_test'])) {
            $data['two_checkout_test'] = Request::p()->post['two_checkout_test'];
        } else {
            $data['two_checkout_test'] = Config::get('two_checkout_test');
        }
        
        if (isset(Request::p()->post['two_checkout_total'])) {
            $data['two_checkout_total'] = Request::p()->post['two_checkout_total'];
        } else {
            $data['two_checkout_total'] = Config::get('two_checkout_total');
        }
        
        if (isset(Request::p()->post['two_checkout_order_status_id'])) {
            $data['two_checkout_order_status_id'] = Request::p()->post['two_checkout_order_status_id'];
        } else {
            $data['two_checkout_order_status_id'] = Config::get('two_checkout_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['two_checkout_geo_zone_id'])) {
            $data['two_checkout_geo_zone_id'] = Request::p()->post['two_checkout_geo_zone_id'];
        } else {
            $data['two_checkout_geo_zone_id'] = Config::get('two_checkout_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['two_checkout_status'])) {
            $data['two_checkout_status'] = Request::p()->post['two_checkout_status'];
        } else {
            $data['two_checkout_status'] = Config::get('two_checkout_status');
        }
        
        if (isset(Request::p()->post['two_checkout_sort_order'])) {
            $data['two_checkout_sort_order'] = Request::p()->post['two_checkout_sort_order'];
        } else {
            $data['two_checkout_sort_order'] = Config::get('two_checkout_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('payment/two_checkout', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/two_checkout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['two_checkout_account']) {
            $this->error['account'] = Lang::get('lang_error_account');
        }
        
        if (!Request::p()->post['two_checkout_secret']) {
            $this->error['secret'] = Lang::get('lang_error_secret');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
