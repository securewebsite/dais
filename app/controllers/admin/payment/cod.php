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

class Cod extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/cod');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('cod', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/cod');
        
        $data['action'] = Url::link('payment/cod', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['cod_total'])) {
            $data['cod_total'] = Request::p()->post['cod_total'];
        } else {
            $data['cod_total'] = Config::get('cod_total');
        }
        
        if (isset(Request::p()->post['cod_order_status_id'])) {
            $data['cod_order_status_id'] = Request::p()->post['cod_order_status_id'];
        } else {
            $data['cod_order_status_id'] = Config::get('cod_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['cod_geo_zone_id'])) {
            $data['cod_geo_zone_id'] = Request::p()->post['cod_geo_zone_id'];
        } else {
            $data['cod_geo_zone_id'] = Config::get('cod_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['cod_status'])) {
            $data['cod_status'] = Request::p()->post['cod_status'];
        } else {
            $data['cod_status'] = Config::get('cod_status');
        }
        
        if (isset(Request::p()->post['cod_sort_order'])) {
            $data['cod_sort_order'] = Request::p()->post['cod_sort_order'];
        } else {
            $data['cod_sort_order'] = Config::get('cod_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('payment/cod', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/cod')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
