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

class GeoZone extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/geo_zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/geo_zone');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/geo_zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/geo_zone');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleGeoZone::addGeoZone(Request::post());
            
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
            
            Response::redirect(Url::link('locale/geo_zone', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/geo_zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/geo_zone');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleGeoZone::editGeoZone(Request::p()->get['geo_zone_id'], Request::post());
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
            
            Response::redirect(Url::link('locale/geo_zone', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/geo_zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/geo_zone');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $geo_zone_id) {
                LocaleGeoZone::deleteGeoZone($geo_zone_id);
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
            
            Response::redirect(Url::link('locale/geo_zone', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/geo_zone');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/geo_zone', $url);
        
        $data['insert'] = Url::link('locale/geo_zone/insert', $url, 'SSL');
        $data['delete'] = Url::link('locale/geo_zone/delete', $url, 'SSL');
        
        $data['geo_zones'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $geo_zone_total = LocaleGeoZone::getTotalGeoZones();
        
        $results = LocaleGeoZone::getGeoZones($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/geo_zone/update', 'geo_zone_id=' . $result['geo_zone_id'] . $url, 'SSL'));
            
            $data['geo_zones'][] = array('geo_zone_id' => $result['geo_zone_id'], 'name' => $result['name'], 'description' => $result['description'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['geo_zone_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('locale/geo_zone', 'sort=name' . $url, 'SSL');
        $data['sort_description'] = Url::link('locale/geo_zone', 'sort=description' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($geo_zone_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/geo_zone', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/geo_zone_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/geo_zone');
        
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
        
        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/geo_zone', $url);
        
        if (!isset(Request::p()->get['geo_zone_id'])) {
            $data['action'] = Url::link('locale/geo_zone/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/geo_zone/update', 'geo_zone_id=' . Request::p()->get['geo_zone_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/geo_zone', $url, 'SSL');
        
        if (isset(Request::p()->get['geo_zone_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $geo_zone_info = LocaleGeoZone::getGeoZone(Request::p()->get['geo_zone_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($geo_zone_info)) {
            $data['name'] = $geo_zone_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['description'])) {
            $data['description'] = Request::p()->post['description'];
        } elseif (!empty($geo_zone_info)) {
            $data['description'] = $geo_zone_info['description'];
        } else {
            $data['description'] = '';
        }
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries(array('filter_status' => 1));
        
        if (isset(Request::p()->post['zone_to_geo_zone'])) {
            $data['zone_to_geo_zones'] = Request::p()->post['zone_to_geo_zone'];
        } elseif (isset(Request::p()->get['geo_zone_id'])) {
            $data['zone_to_geo_zones'] = LocaleGeoZone::getZoneToGeoZones(Request::p()->get['geo_zone_id']);
        } else {
            $data['zone_to_geo_zones'] = array();
        }
        
        Theme::loadjs('javascript/locale/geo_zone_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/geo_zone_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/geo_zone')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 32)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if ((Encode::strlen(Request::p()->post['description']) < 3) || (Encode::strlen(Request::p()->post['description']) > 255)) {
            $this->error['description'] = Lang::get('lang_error_description');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/geo_zone')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('locale/tax_rate');
        
        foreach (Request::p()->post['selected'] as $geo_zone_id) {
            $tax_rate_total = LocaleTaxRate::getTotalTaxRatesByGeoZoneId($geo_zone_id);
            
            if ($tax_rate_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_tax_rate'), $tax_rate_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function zone() {
        $output = '<option value="0">' . Lang::get('lang_text_all_zones') . '</option>';
        
        Theme::model('locale/zone');
        
        $results = LocaleZone::getZonesByCountryId(Request::p()->get['country_id']);
        
        foreach ($results as $result) {
            $output.= '<option value="' . $result['zone_id'] . '"';
            
            if (Request::p()->get['zone_id'] == $result['zone_id']) {
                $output.= ' selected="selected"';
            }
            
            $output.= '>' . $result['name'] . '</option>';
        }
        
        Response::setOutput($output);
    }
}
