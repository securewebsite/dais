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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('authorize_net', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
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
        
        $data['action'] = Url::link('payment/authorize_netaim', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['authorize_net_login'])) {
            $data['authorize_net_login'] = Request::p()->post['authorize_net_login'];
        } else {
            $data['authorize_net_login'] = Config::get('authorize_net_login');
        }
        
        if (isset(Request::p()->post['authorize_net_key'])) {
            $data['authorize_net_key'] = Request::p()->post['authorize_net_key'];
        } else {
            $data['authorize_net_key'] = Config::get('authorize_net_key');
        }
        
        if (isset(Request::p()->post['authorize_net_hash'])) {
            $data['authorize_net_hash'] = Request::p()->post['authorize_net_hash'];
        } else {
            $data['authorize_net_hash'] = Config::get('authorize_net_hash');
        }
        
        if (isset(Request::p()->post['authorize_net_server'])) {
            $data['authorize_net_server'] = Request::p()->post['authorize_net_server'];
        } else {
            $data['authorize_net_server'] = Config::get('authorize_net_server');
        }
        
        if (isset(Request::p()->post['authorize_net_mode'])) {
            $data['authorize_net_mode'] = Request::p()->post['authorize_net_mode'];
        } else {
            $data['authorize_net_mode'] = Config::get('authorize_net_mode');
        }
        
        if (isset(Request::p()->post['authorize_net_method'])) {
            $data['authorize_net_method'] = Request::p()->post['authorize_net_method'];
        } else {
            $data['authorize_net_method'] = Config::get('authorize_net_method');
        }
        
        if (isset(Request::p()->post['authorize_net_total'])) {
            $data['authorize_net_total'] = Request::p()->post['authorize_net_total'];
        } else {
            $data['authorize_net_total'] = Config::get('authorize_net_total');
        }
        
        if (isset(Request::p()->post['authorize_net_order_status_id'])) {
            $data['authorize_net_order_status_id'] = Request::p()->post['authorize_net_order_status_id'];
        } else {
            $data['authorize_net_order_status_id'] = Config::get('authorize_net_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['authorize_net_geo_zone_id'])) {
            $data['authorize_net_geo_zone_id'] = Request::p()->post['authorize_net_geo_zone_id'];
        } else {
            $data['authorize_net_geo_zone_id'] = Config::get('authorize_net_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['authorize_net_status'])) {
            $data['authorize_net_status'] = Request::p()->post['authorize_net_status'];
        } else {
            $data['authorize_net_status'] = Config::get('authorize_net_status');
        }
        
        if (isset(Request::p()->post['authorize_net_sort_order'])) {
            $data['authorize_net_sort_order'] = Request::p()->post['authorize_net_sort_order'];
        } else {
            $data['authorize_net_sort_order'] = Config::get('authorize_net_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('payment/authorize_net', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/authorize_netaim')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['authorize_net_login']) {
            $this->error['login'] = Lang::get('lang_error_login');
        }
        
        if (!Request::p()->post['authorize_net_key']) {
            $this->error['key'] = Lang::get('lang_error_key');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
