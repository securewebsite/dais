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

namespace App\Controllers\Admin\Localization;
use App\Controllers\Controller;

class Country extends Controller {
    private $error = array();
    
    public function index() {
        Lang::load('localization/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('localization/country');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('localization/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('localization/country');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_country->addCountry($this->request->post);
            
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
            
            Response::redirect(Url::link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('localization/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('localization/country');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_country->editCountry($this->request->get['country_id'], $this->request->post);
            
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
            
            Response::redirect(Url::link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('localization/country');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('localization/country');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $country_id) {
                $this->model_localization_country->deleteCountry($country_id);
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
            
            Response::redirect(Url::link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('localization/country');
        
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
        
        Breadcrumb::add('lang_heading_title', 'localization/country', $url);
        
        $data['insert'] = Url::link('localization/country/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('localization/country/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['countries'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $country_total = $this->model_localization_country->getTotalCountries();
        
        $results = $this->model_localization_country->getCountries($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('localization/country/update', 'token=' . $this->session->data['token'] . '&country_id=' . $result['country_id'] . $url, 'SSL'));
            
            $data['countries'][] = array('country_id' => $result['country_id'], 'name' => $result['name'] . (($result['country_id'] == Config::get('config_country_id')) ? Lang::get('lang_text_default') : null), 'iso_code_2' => $result['iso_code_2'], 'iso_code_3' => $result['iso_code_3'], 'selected' => isset($this->request->post['selected']) && in_array($result['country_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('localization/country', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_iso_code_2'] = Url::link('localization/country', 'token=' . $this->session->data['token'] . '&sort=iso_code_2' . $url, 'SSL');
        $data['sort_iso_code_3'] = Url::link('localization/country', 'token=' . $this->session->data['token'] . '&sort=iso_code_3' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($country_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('localization/country', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('localization/country_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('localization/country');
        
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
        
        Breadcrumb::add('lang_heading_title', 'localization/country', $url);
        
        if (!isset($this->request->get['country_id'])) {
            $data['action'] = Url::link('localization/country/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('localization/country/update', 'token=' . $this->session->data['token'] . '&country_id=' . $this->request->get['country_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['country_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $country_info = $this->model_localization_country->getCountry($this->request->get['country_id']);
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($country_info)) {
            $data['name'] = $country_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['iso_code_2'])) {
            $data['iso_code_2'] = $this->request->post['iso_code_2'];
        } elseif (!empty($country_info)) {
            $data['iso_code_2'] = $country_info['iso_code_2'];
        } else {
            $data['iso_code_2'] = '';
        }
        
        if (isset($this->request->post['iso_code_3'])) {
            $data['iso_code_3'] = $this->request->post['iso_code_3'];
        } elseif (!empty($country_info)) {
            $data['iso_code_3'] = $country_info['iso_code_3'];
        } else {
            $data['iso_code_3'] = '';
        }
        
        if (isset($this->request->post['address_format'])) {
            $data['address_format'] = $this->request->post['address_format'];
        } elseif (!empty($country_info)) {
            $data['address_format'] = $country_info['address_format'];
        } else {
            $data['address_format'] = '';
        }
        
        if (isset($this->request->post['postcode_required'])) {
            $data['postcode_required'] = $this->request->post['postcode_required'];
        } elseif (!empty($country_info)) {
            $data['postcode_required'] = $country_info['postcode_required'];
        } else {
            $data['postcode_required'] = 0;
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($country_info)) {
            $data['status'] = $country_info['status'];
        } else {
            $data['status'] = '1';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('localization/country_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'localization/country')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 128)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'localization/country')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('people/customer');
        Theme::model('localization/zone');
        Theme::model('localization/geo_zone');
        
        foreach ($this->request->post['selected'] as $country_id) {
            if (Config::get('config_country_id') == $country_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByCountryId($country_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $address_total = $this->model_people_customer->getTotalAddressesByCountryId($country_id);
            
            if ($address_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_address'), $address_total);
            }
            
            $affiliate_total = $this->model_people_customer->getTotalAffiliatesByCountryId($country_id);
            
            if ($affiliate_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_affiliate'), $affiliate_total);
            }
            
            $zones = $this->model_localization_zone->findZonesByCountryId($country_id);
            
            if (!empty($zones) && !$this->error) {
                foreach ($zones as $zone):
                    $this->model_localization_zone->deleteZone($zone['zone_id']);
                endforeach;
            }
            
            $geo_zones = $this->model_localization_geo_zone->getGeoZonesByCountryId($country_id);
            
            if (!empty($geo_zones) && !$this->error) {
                foreach ($geo_zones as $geo_zone):
                    $this->model_localization_geo_zone->deleteGeoZone($geo_zone['geo_zone_id']);
                endforeach;
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
