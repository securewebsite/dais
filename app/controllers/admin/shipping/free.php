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

class Free extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/free');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('free', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/free');
        
        $data['action'] = Url::link('shipping/free', '', 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', '', 'SSL');
        
        if (isset(Request::p()->post['free_total'])) {
            $data['free_total'] = Request::p()->post['free_total'];
        } else {
            $data['free_total'] = Config::get('free_total');
        }
        
        if (isset(Request::p()->post['free_geo_zone_id'])) {
            $data['free_geo_zone_id'] = Request::p()->post['free_geo_zone_id'];
        } else {
            $data['free_geo_zone_id'] = Config::get('free_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['free_status'])) {
            $data['free_status'] = Request::p()->post['free_status'];
        } else {
            $data['free_status'] = Config::get('free_status');
        }
        
        if (isset(Request::p()->post['free_sort_order'])) {
            $data['free_sort_order'] = Request::p()->post['free_sort_order'];
        } else {
            $data['free_sort_order'] = Config::get('free_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('shipping/free', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/free')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
