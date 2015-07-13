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

class BankTransfer extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/bank_transfer');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('bank_transfer', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Theme::model('localization/language');
        
        $languages = $this->model_localization_language->getLanguages();
        
        foreach ($languages as $language) {
            if (isset($this->error['bank_' . $language['language_id']])) {
                $data['error_bank_' . $language['language_id']] = $this->error['bank_' . $language['language_id']];
            } else {
                $data['error_bank_' . $language['language_id']] = '';
            }
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/bank_transfer');
        
        $data['action'] = Url::link('payment/bank_transfer', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
        
        Theme::model('localization/language');
        
        foreach ($languages as $language) {
            if (isset($this->request->post['bank_transfer_bank_' . $language['language_id']])) {
                $data['bank_transfer_bank_' . $language['language_id']] = $this->request->post['bank_transfer_bank_' . $language['language_id']];
            } else {
                $data['bank_transfer_bank_' . $language['language_id']] = Config::get('bank_transfer_bank_' . $language['language_id']);
            }
        }
        
        $data['languages'] = $languages;
        
        if (isset($this->request->post['bank_transfer_total'])) {
            $data['bank_transfer_total'] = $this->request->post['bank_transfer_total'];
        } else {
            $data['bank_transfer_total'] = Config::get('bank_transfer_total');
        }
        
        if (isset($this->request->post['bank_transfer_order_status_id'])) {
            $data['bank_transfer_order_status_id'] = $this->request->post['bank_transfer_order_status_id'];
        } else {
            $data['bank_transfer_order_status_id'] = Config::get('bank_transfer_order_status_id');
        }
        
        Theme::model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        if (isset($this->request->post['bank_transfer_geo_zone_id'])) {
            $data['bank_transfer_geo_zone_id'] = $this->request->post['bank_transfer_geo_zone_id'];
        } else {
            $data['bank_transfer_geo_zone_id'] = Config::get('bank_transfer_geo_zone_id');
        }
        
        Theme::model('localization/geo_zone');
        
        $data['geo_zones'] = $this->model_localization_geo_zone->getGeoZones();
        
        if (isset($this->request->post['bank_transfer_status'])) {
            $data['bank_transfer_status'] = $this->request->post['bank_transfer_status'];
        } else {
            $data['bank_transfer_status'] = Config::get('bank_transfer_status');
        }
        
        if (isset($this->request->post['bank_transfer_sort_order'])) {
            $data['bank_transfer_sort_order'] = $this->request->post['bank_transfer_sort_order'];
        } else {
            $data['bank_transfer_sort_order'] = Config::get('bank_transfer_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('payment/bank_transfer', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/bank_transfer')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('localization/language');
        
        $languages = $this->model_localization_language->getLanguages();
        
        foreach ($languages as $language) {
            if (!$this->request->post['bank_transfer_bank_' . $language['language_id']]) {
                $this->error['bank_' . $language['language_id']] = Lang::get('lang_error_bank');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
