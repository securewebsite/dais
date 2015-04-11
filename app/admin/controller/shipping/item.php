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

class Item extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('shipping/item');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('item', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_shipping', 'module/shipping');
        $this->breadcrumb->add('lang_heading_title', 'shipping/item');
        
        $data['action'] = $this->url->link('shipping/item', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['item_cost'])) {
            $data['item_cost'] = $this->request->post['item_cost'];
        } else {
            $data['item_cost'] = $this->config->get('item_cost');
        }
        
        if (isset($this->request->post['item_tax_class_id'])) {
            $data['item_tax_class_id'] = $this->request->post['item_tax_class_id'];
        } else {
            $data['item_tax_class_id'] = $this->config->get('item_tax_class_id');
        }
        
        $this->theme->model('localization/taxclass');
        
        $data['tax_classes'] = $this->model_localization_taxclass->getTaxClasses();
        
        if (isset($this->request->post['item_geo_zone_id'])) {
            $data['item_geo_zone_id'] = $this->request->post['item_geo_zone_id'];
        } else {
            $data['item_geo_zone_id'] = $this->config->get('item_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['item_status'])) {
            $data['item_status'] = $this->request->post['item_status'];
        } else {
            $data['item_status'] = $this->config->get('item_status');
        }
        
        if (isset($this->request->post['item_sort_order'])) {
            $data['item_sort_order'] = $this->request->post['item_sort_order'];
        } else {
            $data['item_sort_order'] = $this->config->get('item_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('shipping/item', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'shipping/item')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
