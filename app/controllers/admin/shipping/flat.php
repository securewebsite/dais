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

class Flat extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/flat');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('flat', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/flat');
        
        $data['action'] = Url::link('shipping/flat', '', 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', '', 'SSL');
        
        if (isset(Request::p()->post['flat_cost'])) {
            $data['flat_cost'] = Request::p()->post['flat_cost'];
        } else {
            $data['flat_cost'] = Config::get('flat_cost');
        }
        
        if (isset(Request::p()->post['flat_tax_class_id'])) {
            $data['flat_tax_class_id'] = Request::p()->post['flat_tax_class_id'];
        } else {
            $data['flat_tax_class_id'] = Config::get('flat_tax_class_id');
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = LocaleTaxClass::getTaxClasses();
        
        if (isset(Request::p()->post['flat_geo_zone_id'])) {
            $data['flat_geo_zone_id'] = Request::p()->post['flat_geo_zone_id'];
        } else {
            $data['flat_geo_zone_id'] = Config::get('flat_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['flat_status'])) {
            $data['flat_status'] = Request::p()->post['flat_status'];
        } else {
            $data['flat_status'] = Config::get('flat_status');
        }
        
        if (isset(Request::p()->post['flat_sort_order'])) {
            $data['flat_sort_order'] = Request::p()->post['flat_sort_order'];
        } else {
            $data['flat_sort_order'] = Config::get('flat_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('shipping/flat', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/flat')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
