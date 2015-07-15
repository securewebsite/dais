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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_zone->addZone($this->request->post);
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
            
            Response::redirect(Url::link('locale/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/zone');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_zone->editZone($this->request->get['zone_id'], $this->request->post);
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
            
            Response::redirect(Url::link('locale/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/zone');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/zone');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $zone_id) {
                $this->model_locale_zone->deleteZone($zone_id);
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
            
            Response::redirect(Url::link('locale/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/zone');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'c.name';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/zone', $url);
        
        $data['insert'] = Url::link('locale/zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('locale/zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['zones'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $zone_total = $this->model_locale_zone->getTotalZones();
        
        $results = $this->model_locale_zone->getZones($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/zone/update', 'token=' . $this->session->data['token'] . '&zone_id=' . $result['zone_id'] . $url, 'SSL'));
            
            $data['zones'][] = array('zone_id' => $result['zone_id'], 'country' => $result['country'], 'name' => $result['name'] . (($result['zone_id'] == Config::get('config_zone_id')) ? Lang::get('lang_text_default') : null), 'code' => $result['code'], 'selected' => isset($this->request->post['selected']) && in_array($result['zone_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_country'] = Url::link('locale/zone', 'token=' . $this->session->data['token'] . '&sort=c.name' . $url, 'SSL');
        $data['sort_name'] = Url::link('locale/zone', 'token=' . $this->session->data['token'] . '&sort=z.name' . $url, 'SSL');
        $data['sort_code'] = Url::link('locale/zone', 'token=' . $this->session->data['token'] . '&sort=z.code' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($zone_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('locale/zone_list', $data));
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/zone', $url);
        
        if (!isset($this->request->get['zone_id'])) {
            $data['action'] = Url::link('locale/zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/zone/update', 'token=' . $this->session->data['token'] . '&zone_id=' . $this->request->get['zone_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/zone', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $zone_info = $this->model_locale_zone->getZone($this->request->get['zone_id']);
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($zone_info)) {
            $data['status'] = $zone_info['status'];
        } else {
            $data['status'] = '1';
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($zone_info)) {
            $data['name'] = $zone_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['code'])) {
            $data['code'] = $this->request->post['code'];
        } elseif (!empty($zone_info)) {
            $data['code'] = $zone_info['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset($this->request->post['country_id'])) {
            $data['country_id'] = $this->request->post['country_id'];
        } elseif (!empty($zone_info)) {
            $data['country_id'] = $zone_info['country_id'];
        } else {
            $data['country_id'] = '';
        }
        
        Theme::model('locale/country');
        
        $data['countries'] = $this->model_locale_country->getCountries();
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('locale/zone_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/zone')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 64)) {
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
        
        foreach ($this->request->post['selected'] as $zone_id) {
            if (Config::get('config_zone_id') == $zone_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByZoneId($zone_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $address_total = $this->model_people_customer->getTotalAddressesByZoneId($zone_id);
            
            if ($address_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_address'), $address_total);
            }
            
            $affiliate_total = $this->model_people_customer->getTotalAffiliatesByZoneId($zone_id);
            
            if ($affiliate_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_affiliate'), $affiliate_total);
            }
            
            $zone_to_geo_zone_total = $this->model_locale_geo_zone->getTotalZoneToGeoZoneByZoneId($zone_id);
            
            if ($zone_to_geo_zone_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_zone_to_geo_zone'), $zone_to_geo_zone_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
