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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('flat', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/flat');
        
        $data['action'] = Url::link('shipping/flat', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['flat_cost'])) {
            $data['flat_cost'] = $this->request->post['flat_cost'];
        } else {
            $data['flat_cost'] = Config::get('flat_cost');
        }
        
        if (isset($this->request->post['flat_tax_class_id'])) {
            $data['flat_tax_class_id'] = $this->request->post['flat_tax_class_id'];
        } else {
            $data['flat_tax_class_id'] = Config::get('flat_tax_class_id');
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = $this->model_locale_tax_class->getTaxClasses();
        
        if (isset($this->request->post['flat_geo_zone_id'])) {
            $data['flat_geo_zone_id'] = $this->request->post['flat_geo_zone_id'];
        } else {
            $data['flat_geo_zone_id'] = Config::get('flat_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = $this->model_locale_geo_zone->getGeoZones();
        
        if (isset($this->request->post['flat_status'])) {
            $data['flat_status'] = $this->request->post['flat_status'];
        } else {
            $data['flat_status'] = Config::get('flat_status');
        }
        
        if (isset($this->request->post['flat_sort_order'])) {
            $data['flat_sort_order'] = $this->request->post['flat_sort_order'];
        } else {
            $data['flat_sort_order'] = Config::get('flat_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('shipping/flat', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/flat')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
