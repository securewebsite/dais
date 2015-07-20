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

namespace App\Controllers\Admin\Shipping;

use App\Controllers\Controller;

class Pickup extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/pickup');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('pickup', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/pickup');
        
        $data['action'] = Url::link('shipping/pickup', '', 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', '', 'SSL');
        
        if (isset(Request::p()->post['pickup_geo_zone_id'])) {
            $data['pickup_geo_zone_id'] = Request::p()->post['pickup_geo_zone_id'];
        } else {
            $data['pickup_geo_zone_id'] = Config::get('pickup_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['pickup_status'])) {
            $data['pickup_status'] = Request::p()->post['pickup_status'];
        } else {
            $data['pickup_status'] = Config::get('pickup_status');
        }
        
        if (isset(Request::p()->post['pickup_sort_order'])) {
            $data['pickup_sort_order'] = Request::p()->post['pickup_sort_order'];
        } else {
            $data['pickup_sort_order'] = Config::get('pickup_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('shipping/pickup', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/pickup')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
