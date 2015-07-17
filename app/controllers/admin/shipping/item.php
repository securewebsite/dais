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

class Item extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/item');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('item', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/item');
        
        $data['action'] = Url::link('shipping/item', '', 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', '', 'SSL');
        
        if (isset(Request::p()->post['item_cost'])) {
            $data['item_cost'] = Request::p()->post['item_cost'];
        } else {
            $data['item_cost'] = Config::get('item_cost');
        }
        
        if (isset(Request::p()->post['item_tax_class_id'])) {
            $data['item_tax_class_id'] = Request::p()->post['item_tax_class_id'];
        } else {
            $data['item_tax_class_id'] = Config::get('item_tax_class_id');
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = LocaleTaxClass::getTaxClasses();
        
        if (isset(Request::p()->post['item_geo_zone_id'])) {
            $data['item_geo_zone_id'] = Request::p()->post['item_geo_zone_id'];
        } else {
            $data['item_geo_zone_id'] = Config::get('item_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['item_status'])) {
            $data['item_status'] = Request::p()->post['item_status'];
        } else {
            $data['item_status'] = Config::get('item_status');
        }
        
        if (isset(Request::p()->post['item_sort_order'])) {
            $data['item_sort_order'] = Request::p()->post['item_sort_order'];
        } else {
            $data['item_sort_order'] = Config::get('item_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('shipping/item', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/item')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
