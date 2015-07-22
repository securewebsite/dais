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

namespace App\Controllers\Admin\Locale;

use App\Controllers\Controller;

class Country extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/country');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/country');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleCountry::addCountry(Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('locale/country', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/country');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleCountry::editCountry(Request::p()->get['country_id'], Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('locale/country', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/country');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $country_id) {
                LocaleCountry::deleteCountry($country_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('locale/country', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/country');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'name';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/country', $url);
        
        $data['insert'] = Url::link('locale/country/insert', $url, 'SSL');
        $data['delete'] = Url::link('locale/country/delete', $url, 'SSL');
        
        $data['countries'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $country_total = LocaleCountry::getTotalCountries();
        
        $results = LocaleCountry::getCountries($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/country/update', 'country_id=' . $result['country_id'] . $url, 'SSL'));
            
            $data['countries'][] = array('country_id' => $result['country_id'], 'name' => $result['name'] . (($result['country_id'] == Config::get('config_country_id')) ? Lang::get('lang_text_default') : null), 'iso_code_2' => $result['iso_code_2'], 'iso_code_3' => $result['iso_code_3'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['country_id'], Request::p()->post['selected']), 'action' => $action);
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $url = '';
        
        if ($order == 'asc') {
            $url.= '&order=desc';
        } else {
            $url.= '&order=asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_name'] = Url::link('locale/country', 'sort=name' . $url, 'SSL');
        $data['sort_iso_code_2'] = Url::link('locale/country', 'sort=iso_code_2' . $url, 'SSL');
        $data['sort_iso_code_3'] = Url::link('locale/country', 'sort=iso_code_3' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($country_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/country', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/country_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/country');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/country', $url);
        
        if (!isset(Request::p()->get['country_id'])) {
            $data['action'] = Url::link('locale/country/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/country/update', 'country_id=' . Request::p()->get['country_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/country', $url, 'SSL');
        
        if (isset(Request::p()->get['country_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $country_info = LocaleCountry::getCountry(Request::p()->get['country_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($country_info)) {
            $data['name'] = $country_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['iso_code_2'])) {
            $data['iso_code_2'] = Request::p()->post['iso_code_2'];
        } elseif (!empty($country_info)) {
            $data['iso_code_2'] = $country_info['iso_code_2'];
        } else {
            $data['iso_code_2'] = '';
        }
        
        if (isset(Request::p()->post['iso_code_3'])) {
            $data['iso_code_3'] = Request::p()->post['iso_code_3'];
        } elseif (!empty($country_info)) {
            $data['iso_code_3'] = $country_info['iso_code_3'];
        } else {
            $data['iso_code_3'] = '';
        }
        
        if (isset(Request::p()->post['address_format'])) {
            $data['address_format'] = Request::p()->post['address_format'];
        } elseif (!empty($country_info)) {
            $data['address_format'] = $country_info['address_format'];
        } else {
            $data['address_format'] = '';
        }
        
        if (isset(Request::p()->post['postcode_required'])) {
            $data['postcode_required'] = Request::p()->post['postcode_required'];
        } elseif (!empty($country_info)) {
            $data['postcode_required'] = $country_info['postcode_required'];
        } else {
            $data['postcode_required'] = 0;
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($country_info)) {
            $data['status'] = $country_info['status'];
        } else {
            $data['status'] = '1';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/country_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/country')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 128)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/country')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('people/customer');
        Theme::model('locale/zone');
        Theme::model('locale/geo_zone');
        
        foreach (Request::p()->post['selected'] as $country_id) {
            if (Config::get('config_country_id') == $country_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = SettingStore::getTotalStoresByCountryId($country_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $address_total = PeopleCustomer::getTotalAddressesByCountryId($country_id);
            
            if ($address_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_address'), $address_total);
            }
            
            $affiliate_total = PeopleCustomer::getTotalAffiliatesByCountryId($country_id);
            
            if ($affiliate_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_affiliate'), $affiliate_total);
            }
            
            $zones = LocaleZone::findZonesByCountryId($country_id);
            
            if (!empty($zones) && !$this->error) {
                foreach ($zones as $zone):
                    LocaleZone::deleteZone($zone['zone_id']);
                endforeach;
            }
            
            $geo_zones = LocaleGeoZone::getGeoZonesByCountryId($country_id);
            
            if (!empty($geo_zones) && !$this->error) {
                foreach ($geo_zones as $geo_zone):
                    LocaleGeoZone::deleteGeoZone($geo_zone['geo_zone_id']);
                endforeach;
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
