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

class Moneybookers extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/moneybookers');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('moneybookers', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/moneybookers');
        
        $data['action'] = Url::link('payment/moneybookers', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['moneybookers_email'])) {
            $data['moneybookers_email'] = Request::p()->post['moneybookers_email'];
        } else {
            $data['moneybookers_email'] = Config::get('moneybookers_email');
        }
        
        if (isset(Request::p()->post['moneybookers_secret'])) {
            $data['moneybookers_secret'] = Request::p()->post['moneybookers_secret'];
        } else {
            $data['moneybookers_secret'] = Config::get('moneybookers_secret');
        }
        
        if (isset(Request::p()->post['moneybookers_total'])) {
            $data['moneybookers_total'] = Request::p()->post['moneybookers_total'];
        } else {
            $data['moneybookers_total'] = Config::get('moneybookers_total');
        }
        
        if (isset(Request::p()->post['moneybookers_order_status_id'])) {
            $data['moneybookers_order_status_id'] = Request::p()->post['moneybookers_order_status_id'];
        } else {
            $data['moneybookers_order_status_id'] = Config::get('moneybookers_order_status_id');
        }
        
        if (isset(Request::p()->post['moneybookers_pending_status_id'])) {
            $data['moneybookers_pending_status_id'] = Request::p()->post['moneybookers_pending_status_id'];
        } else {
            $data['moneybookers_pending_status_id'] = Config::get('moneybookers_pending_status_id');
        }
        
        if (isset(Request::p()->post['moneybookers_canceled_status_id'])) {
            $data['moneybookers_canceled_status_id'] = Request::p()->post['moneybookers_canceled_status_id'];
        } else {
            $data['moneybookers_canceled_status_id'] = Config::get('moneybookers_canceled_status_id');
        }
        
        if (isset(Request::p()->post['moneybookers_failed_status_id'])) {
            $data['moneybookers_failed_status_id'] = Request::p()->post['moneybookers_failed_status_id'];
        } else {
            $data['moneybookers_failed_status_id'] = Config::get('moneybookers_failed_status_id');
        }
        
        if (isset(Request::p()->post['moneybookers_chargeback_status_id'])) {
            $data['moneybookers_chargeback_status_id'] = Request::p()->post['moneybookers_chargeback_status_id'];
        } else {
            $data['moneybookers_chargeback_status_id'] = Config::get('moneybookers_chargeback_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['moneybookers_geo_zone_id'])) {
            $data['moneybookers_geo_zone_id'] = Request::p()->post['moneybookers_geo_zone_id'];
        } else {
            $data['moneybookers_geo_zone_id'] = Config::get('moneybookers_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['moneybookers_status'])) {
            $data['moneybookers_status'] = Request::p()->post['moneybookers_status'];
        } else {
            $data['moneybookers_status'] = Config::get('moneybookers_status');
        }
        
        if (isset(Request::p()->post['moneybookers_sort_order'])) {
            $data['moneybookers_sort_order'] = Request::p()->post['moneybookers_sort_order'];
        } else {
            $data['moneybookers_sort_order'] = Config::get('moneybookers_sort_order');
        }
        
        if (isset(Request::p()->post['moneybookers_rid'])) {
            $data['moneybookers_rid'] = Request::p()->post['moneybookers_rid'];
        } else {
            $data['moneybookers_rid'] = Config::get('moneybookers_rid');
        }
        
        if (isset(Request::p()->post['moneybookers_custnote'])) {
            $data['moneybookers_custnote'] = Request::p()->post['moneybookers_custnote'];
        } else {
            $data['moneybookers_custnote'] = Config::get('moneybookers_custnote');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('payment/moneybookers', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/moneybookers')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['moneybookers_email']) {
            $this->error['email'] = Lang::get('lang_error_email');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
