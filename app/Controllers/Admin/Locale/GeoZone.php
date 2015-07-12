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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_geo_zone->addGeoZone($this->request->post);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            Response::redirect(Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/geo_zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/geo_zone');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_geo_zone->editGeoZone($this->request->get['geo_zone_id'], $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            Response::redirect(Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/geo_zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/geo_zone');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $geo_zone_id) {
                $this->model_locale_geo_zone->deleteGeoZone($geo_zone_id);
            }
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            Response::redirect(Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/geo_zone');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }
        
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/geo_zone', $url);
        
        $data['insert'] = Url::link('locale/geo_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('locale/geo_zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['geo_zones'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $geo_zone_total = $this->model_locale_geo_zone->getTotalGeoZones();
        
        $results = $this->model_locale_geo_zone->getGeoZones($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/geo_zone/update', 'token=' . $this->session->data['token'] . '&geo_zone_id=' . $result['geo_zone_id'] . $url, 'SSL'));
            
            $data['geo_zones'][] = array('geo_zone_id' => $result['geo_zone_id'], 'name' => $result['name'], 'description' => $result['description'], 'selected' => isset($this->request->post['selected']) && in_array($result['geo_zone_id'], $this->request->post['selected']), 'action' => $action);
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $url = '';
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $data['sort_name'] = Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_description'] = Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . '&sort=description' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($geo_zone_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('locale/geo_zone_list', $data));
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/geo_zone', $url);
        
        if (!isset($this->request->get['geo_zone_id'])) {
            $data['action'] = Url::link('locale/geo_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/geo_zone/update', 'token=' . $this->session->data['token'] . '&geo_zone_id=' . $this->request->get['geo_zone_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['geo_zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $geo_zone_info = $this->model_locale_geo_zone->getGeoZone($this->request->get['geo_zone_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($geo_zone_info)) {
            $data['name'] = $geo_zone_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } elseif (!empty($geo_zone_info)) {
            $data['description'] = $geo_zone_info['description'];
        } else {
            $data['description'] = '';
        }
        
        Theme::model('locale/country');
        
        $data['countries'] = $this->model_locale_country->getCountries(array('filter_status' => 1));
        
        if (isset($this->request->post['zone_to_geo_zone'])) {
            $data['zone_to_geo_zones'] = $this->request->post['zone_to_geo_zone'];
        } elseif (isset($this->request->get['geo_zone_id'])) {
            $data['zone_to_geo_zones'] = $this->model_locale_geo_zone->getZoneToGeoZones($this->request->get['geo_zone_id']);
        } else {
            $data['zone_to_geo_zones'] = array();
        }
        
        Theme::loadjs('javascript/locale/geo_zone_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('locale/geo_zone_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/geo_zone')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if ((Encode::strlen($this->request->post['description']) < 3) || (Encode::strlen($this->request->post['description']) > 255)) {
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
        
        foreach ($this->request->post['selected'] as $geo_zone_id) {
            $tax_rate_total = $this->model_locale_tax_rate->getTotalTaxRatesByGeoZoneId($geo_zone_id);
            
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
        
        $results = $this->model_locale_zone->getZonesByCountryId($this->request->get['country_id']);
        
        foreach ($results as $result) {
            $output.= '<option value="' . $result['zone_id'] . '"';
            
            if ($this->request->get['zone_id'] == $result['zone_id']) {
                $output.= ' selected="selected"';
            }
            
            $output.= '>' . $result['name'] . '</option>';
        }
        
        Response::setOutput($output);
    }
}
