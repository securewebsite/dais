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

namespace Admin\Controller\Shipping;
use Dais\Engine\Controller;

class Weight extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/weight');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('weight', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/weight');
        
        $data['action'] = Url::link('shipping/weight', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        Theme::model('localization/geo_zone');
        
        $geo_zones = $this->model_localization_geo_zone->getGeoZones();
        
        foreach ($geo_zones as $geo_zone) {
            if (isset($this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_rate'])) {
                $data['weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_rate'];
            } else {
                $data['weight_' . $geo_zone['geo_zone_id'] . '_rate'] = Config::get('weight_' . $geo_zone['geo_zone_id'] . '_rate');
            }
            
            if (isset($this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_status'])) {
                $data['weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['weight_' . $geo_zone['geo_zone_id'] . '_status'];
            } else {
                $data['weight_' . $geo_zone['geo_zone_id'] . '_status'] = Config::get('weight_' . $geo_zone['geo_zone_id'] . '_status');
            }
        }
        
        $data['geo_zones'] = $geo_zones;
        
        if (isset($this->request->post['weight_tax_class_id'])) {
            $data['weight_tax_class_id'] = $this->request->post['weight_tax_class_id'];
        } else {
            $data['weight_tax_class_id'] = Config::get('weight_tax_class_id');
        }
        
        Theme::model('localization/tax_class');
        
        $data['tax_classes'] = $this->model_localization_tax_class->getTaxClasses();
        
        if (isset($this->request->post['weight_status'])) {
            $data['weight_status'] = $this->request->post['weight_status'];
        } else {
            $data['weight_status'] = Config::get('weight_status');
        }
        
        if (isset($this->request->post['weight_sort_order'])) {
            $data['weight_sort_order'] = $this->request->post['weight_sort_order'];
        } else {
            $data['weight_sort_order'] = Config::get('weight_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('shipping/weight', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/weight')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
