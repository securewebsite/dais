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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('bank_transfer', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Theme::model('locale/language');
        
        $languages = LocaleLanguage::getLanguages();
        
        foreach ($languages as $language) {
            if (isset($this->error['bank_' . $language['language_id']])) {
                $data['error_bank_' . $language['language_id']] = $this->error['bank_' . $language['language_id']];
            } else {
                $data['error_bank_' . $language['language_id']] = '';
            }
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/bank_transfer');
        
        $data['action'] = Url::link('payment/bank_transfer', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        Theme::model('locale/language');
        
        foreach ($languages as $language) {
            if (isset(Request::p()->post['bank_transfer_bank_' . $language['language_id']])) {
                $data['bank_transfer_bank_' . $language['language_id']] = Request::p()->post['bank_transfer_bank_' . $language['language_id']];
            } else {
                $data['bank_transfer_bank_' . $language['language_id']] = Config::get('bank_transfer_bank_' . $language['language_id']);
            }
        }
        
        $data['languages'] = $languages;
        
        if (isset(Request::p()->post['bank_transfer_total'])) {
            $data['bank_transfer_total'] = Request::p()->post['bank_transfer_total'];
        } else {
            $data['bank_transfer_total'] = Config::get('bank_transfer_total');
        }
        
        if (isset(Request::p()->post['bank_transfer_order_status_id'])) {
            $data['bank_transfer_order_status_id'] = Request::p()->post['bank_transfer_order_status_id'];
        } else {
            $data['bank_transfer_order_status_id'] = Config::get('bank_transfer_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['bank_transfer_geo_zone_id'])) {
            $data['bank_transfer_geo_zone_id'] = Request::p()->post['bank_transfer_geo_zone_id'];
        } else {
            $data['bank_transfer_geo_zone_id'] = Config::get('bank_transfer_geo_zone_id');
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        if (isset(Request::p()->post['bank_transfer_status'])) {
            $data['bank_transfer_status'] = Request::p()->post['bank_transfer_status'];
        } else {
            $data['bank_transfer_status'] = Config::get('bank_transfer_status');
        }
        
        if (isset(Request::p()->post['bank_transfer_sort_order'])) {
            $data['bank_transfer_sort_order'] = Request::p()->post['bank_transfer_sort_order'];
        } else {
            $data['bank_transfer_sort_order'] = Config::get('bank_transfer_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('payment/bank_transfer', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/bank_transfer')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('locale/language');
        
        $languages = LocaleLanguage::getLanguages();
        
        foreach ($languages as $language) {
            if (!Request::p()->post['bank_transfer_bank_' . $language['language_id']]) {
                $this->error['bank_' . $language['language_id']] = Lang::get('lang_error_bank');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
