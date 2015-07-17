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

class Zone extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/zone');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/zone');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleZone::addZone(Request::post());
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
            
            Response::redirect(Url::link('locale/zone', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/zone');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleZone::editZone(Request::p()->get['zone_id'], Request::post());
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
            
            Response::redirect(Url::link('locale/zone', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/zone');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $zone_id) {
                LocaleZone::deleteZone($zone_id);
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
            
            Response::redirect(Url::link('locale/zone', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/zone');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'c.name';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'ASC';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/zone', $url);
        
        $data['insert'] = Url::link('locale/zone/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('locale/zone/delete', '' . $url, 'SSL');
        
        $data['zones'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $zone_total = LocaleZone::getTotalZones();
        
        $results = LocaleZone::getZones($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/zone/update', '' . 'zone_id=' . $result['zone_id'] . $url, 'SSL'));
            
            $data['zones'][] = array('zone_id' => $result['zone_id'], 'country' => $result['country'], 'name' => $result['name'] . (($result['zone_id'] == Config::get('config_zone_id')) ? Lang::get('lang_text_default') : null), 'code' => $result['code'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['zone_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_country'] = Url::link('locale/zone', '' . 'sort=c.name' . $url, 'SSL');
        $data['sort_name'] = Url::link('locale/zone', '' . 'sort=z.name' . $url, 'SSL');
        $data['sort_code'] = Url::link('locale/zone', '' . 'sort=z.code' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($zone_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/zone', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('locale/zone_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/zone');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/zone', $url);
        
        if (!isset(Request::p()->get['zone_id'])) {
            $data['action'] = Url::link('locale/zone/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/zone/update', '' . 'zone_id=' . Request::p()->get['zone_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/zone', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['zone_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $zone_info = LocaleZone::getZone(Request::p()->get['zone_id']);
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($zone_info)) {
            $data['status'] = $zone_info['status'];
        } else {
            $data['status'] = '1';
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($zone_info)) {
            $data['name'] = $zone_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['code'])) {
            $data['code'] = Request::p()->post['code'];
        } elseif (!empty($zone_info)) {
            $data['code'] = $zone_info['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset(Request::p()->post['country_id'])) {
            $data['country_id'] = Request::p()->post['country_id'];
        } elseif (!empty($zone_info)) {
            $data['country_id'] = $zone_info['country_id'];
        } else {
            $data['country_id'] = '';
        }
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('locale/zone_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/zone')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 64)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/zone')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('people/customer');
        Theme::model('locale/geo_zone');
        
        foreach (Request::p()->post['selected'] as $zone_id) {
            if (Config::get('config_zone_id') == $zone_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = SettingStore::getTotalStoresByZoneId($zone_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $address_total = PeopleCustomer::getTotalAddressesByZoneId($zone_id);
            
            if ($address_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_address'), $address_total);
            }
            
            $affiliate_total = PeopleCustomer::getTotalAffiliatesByZoneId($zone_id);
            
            if ($affiliate_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_affiliate'), $affiliate_total);
            }
            
            $zone_to_geo_zone_total = LocaleGeoZone::getTotalZoneToGeoZoneByZoneId($zone_id);
            
            if ($zone_to_geo_zone_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_zone_to_geo_zone'), $zone_to_geo_zone_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
