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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cod', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/cod');
        
        $data['action'] = Url::link('payment/cod', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['cod_total'])) {
            $data['cod_total'] = $this->request->post['cod_total'];
        } else {
            $data['cod_total'] = Config::get('cod_total');
        }
        
        if (isset($this->request->post['cod_order_status_id'])) {
            $data['cod_order_status_id'] = $this->request->post['cod_order_status_id'];
        } else {
            $data['cod_order_status_id'] = Config::get('cod_order_status_id');
        }
        
        Theme::model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['cod_geo_zone_id'])) {
            $data['cod_geo_zone_id'] = $this->request->post['cod_geo_zone_id'];
        } else {
            $data['cod_geo_zone_id'] = Config::get('cod_geo_zone_id');
        }
        
        Theme::model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['cod_status'])) {
            $data['cod_status'] = $this->request->post['cod_status'];
        } else {
            $data['cod_status'] = Config::get('cod_status');
        }
        
        if (isset($this->request->post['cod_sort_order'])) {
            $data['cod_sort_order'] = $this->request->post['cod_sort_order'];
        } else {
            $data['cod_sort_order'] = Config::get('cod_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/cod', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/cod')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
