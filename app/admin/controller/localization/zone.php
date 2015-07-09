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

namespace Admin\Controller\Localization;
use Dais\Engine\Controller;

class Zone extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/zone');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/zone');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/zone');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/zone');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_zone->addZone($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
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
            
            Response::redirect($this->url->link('localization/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/zone');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/zone');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_zone->editZone($this->request->get['zone_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
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
            
            Response::redirect($this->url->link('localization/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/zone');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/zone');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $zone_id) {
                $this->model_localization_zone->deleteZone($zone_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
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
            
            Response::redirect($this->url->link('localization/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('localization/zone');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/zone', $url);
        
        $data['insert'] = $this->url->link('localization/zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['zones'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $zone_total = $this->model_localization_zone->getTotalZones();
        
        $results = $this->model_localization_zone->getZones($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/zone/update', 'token=' . $this->session->data['token'] . '&zone_id=' . $result['zone_id'] . $url, 'SSL'));
            
            $data['zones'][] = array('zone_id' => $result['zone_id'], 'country' => $result['country'], 'name' => $result['name'] . (($result['zone_id'] == Config::get('config_zone_id')) ? $this->language->get('lang_text_default') : null), 'code' => $result['code'], 'selected' => isset($this->request->post['selected']) && in_array($result['zone_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_country'] = $this->url->link('localization/zone', 'token=' . $this->session->data['token'] . '&sort=c.name' . $url, 'SSL');
        $data['sort_name'] = $this->url->link('localization/zone', 'token=' . $this->session->data['token'] . '&sort=z.name' . $url, 'SSL');
        $data['sort_code'] = $this->url->link('localization/zone', 'token=' . $this->session->data['token'] . '&sort=z.code' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($zone_total, $page, Config::get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('localization/zone_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('localization/zone');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/zone', $url);
        
        if (!isset($this->request->get['zone_id'])) {
            $data['action'] = $this->url->link('localization/zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/zone/update', 'token=' . $this->session->data['token'] . '&zone_id=' . $this->request->get['zone_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/zone', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $zone_info = $this->model_localization_zone->getZone($this->request->get['zone_id']);
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
        
        Theme::model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries();
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('localization/zone_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'localization/zone')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'localization/zone')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('people/customer');
        Theme::model('localization/geo_zone');
        
        foreach ($this->request->post['selected'] as $zone_id) {
            if (Config::get('config_zone_id') == $zone_id) {
                $this->error['warning'] = $this->language->get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByZoneId($zone_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_store'), $store_total);
            }
            
            $address_total = $this->model_people_customer->getTotalAddressesByZoneId($zone_id);
            
            if ($address_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_address'), $address_total);
            }
            
            $affiliate_total = $this->model_people_customer->getTotalAffiliatesByZoneId($zone_id);
            
            if ($affiliate_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_affiliate'), $affiliate_total);
            }
            
            $zone_to_geo_zone_total = $this->model_localization_geo_zone->getTotalZoneToGeoZoneByZoneId($zone_id);
            
            if ($zone_to_geo_zone_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_zone_to_geo_zone'), $zone_to_geo_zone_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
