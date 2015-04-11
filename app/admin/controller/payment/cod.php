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

namespace Admin\Controller\Payment;
use Dais\Engine\Controller;

class Cod extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('payment/cod');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cod', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_payment', 'module/payment');
        $this->breadcrumb->add('lang_heading_title', 'payment/cod');
        
        $data['action'] = $this->url->link('payment/cod', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['cod_total'])) {
            $data['cod_total'] = $this->request->post['cod_total'];
        } else {
            $data['cod_total'] = $this->config->get('cod_total');
        }
        
        if (isset($this->request->post['cod_order_status_id'])) {
            $data['cod_order_status_id'] = $this->request->post['cod_order_status_id'];
        } else {
            $data['cod_order_status_id'] = $this->config->get('cod_order_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['cod_geo_zone_id'])) {
            $data['cod_geo_zone_id'] = $this->request->post['cod_geo_zone_id'];
        } else {
            $data['cod_geo_zone_id'] = $this->config->get('cod_geo_zone_id');
        }
        
        $this->theme->model('localization/geozone');
        
        $data['geo_zones'] = $this->model_localization_geozone->getGeoZones();
        
        if (isset($this->request->post['cod_status'])) {
            $data['cod_status'] = $this->request->post['cod_status'];
        } else {
            $data['cod_status'] = $this->config->get('cod_status');
        }
        
        if (isset($this->request->post['cod_sort_order'])) {
            $data['cod_sort_order'] = $this->request->post['cod_sort_order'];
        } else {
            $data['cod_sort_order'] = $this->config->get('cod_sort_order');
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('payment/cod', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/cod')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
