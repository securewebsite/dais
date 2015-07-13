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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('twocheckout', $this->request->post);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $data['action'] = Url::link('payment/two_checkout', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['twocheckout_account'])) {
            $data['twocheckout_account'] = $this->request->post['twocheckout_account'];
        } else {
            $data['twocheckout_account'] = Config::get('twocheckout_account');
        }
        
        if (isset($this->request->post['twocheckout_secret'])) {
            $data['twocheckout_secret'] = $this->request->post['twocheckout_secret'];
        } else {
            $data['twocheckout_secret'] = Config::get('twocheckout_secret');
        }
        
        if (isset($this->request->post['twocheckout_test'])) {
            $data['twocheckout_test'] = $this->request->post['twocheckout_test'];
        } else {
            $data['twocheckout_test'] = Config::get('twocheckout_test');
        }
        
        if (isset($this->request->post['twocheckout_total'])) {
            $data['twocheckout_total'] = $this->request->post['twocheckout_total'];
        } else {
            $data['twocheckout_total'] = Config::get('twocheckout_total');
        }
        
        if (isset($this->request->post['twocheckout_order_status_id'])) {
            $data['twocheckout_order_status_id'] = $this->request->post['twocheckout_order_status_id'];
        } else {
            $data['twocheckout_order_status_id'] = Config::get('twocheckout_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['twocheckout_geo_zone_id'])) {
            $data['twocheckout_geo_zone_id'] = $this->request->post['twocheckout_geo_zone_id'];
        } else {
            $data['twocheckout_geo_zone_id'] = Config::get('twocheckout_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['twocheckout_status'])) {
            $data['twocheckout_status'] = $this->request->post['twocheckout_status'];
        } else {
            $data['twocheckout_status'] = Config::get('twocheckout_status');
        }
        
        if (isset($this->request->post['twocheckout_sort_order'])) {
            $data['twocheckout_sort_order'] = $this->request->post['twocheckout_sort_order'];
        } else {
            $data['twocheckout_sort_order'] = Config::get('twocheckout_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/two_checkout', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/twocheckout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['twocheckout_account']) {
            $this->error['account'] = Lang::get('lang_error_account');
        }
        
        if (!$this->request->post['twocheckout_secret']) {
            $this->error['secret'] = Lang::get('lang_error_secret');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
