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
use Dais\Base\Controller;

class Free extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('shipping/free');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('free', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_shipping', 'module/shipping');
        Breadcrumb::add('lang_heading_title', 'shipping/free');
        
        $data['action'] = Url::link('shipping/free', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['free_total'])) {
            $data['free_total'] = $this->request->post['free_total'];
        } else {
            $data['free_total'] = Config::get('free_total');
        }
        
        if (isset($this->request->post['free_geo_zone_id'])) {
            $data['free_geo_zone_id'] = $this->request->post['free_geo_zone_id'];
        } else {
            $data['free_geo_zone_id'] = Config::get('free_geo_zone_id');
        }
        
        Theme::model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['free_status'])) {
            $data['free_status'] = $this->request->post['free_status'];
        } else {
            $data['free_status'] = Config::get('free_status');
        }
        
        if (isset($this->request->post['free_sort_order'])) {
            $data['free_sort_order'] = $this->request->post['free_sort_order'];
        } else {
            $data['free_sort_order'] = Config::get('free_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('shipping/free', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'shipping/free')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
