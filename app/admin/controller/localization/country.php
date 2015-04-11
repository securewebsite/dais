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

class Country extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/country');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('localization/country');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/country');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('localization/country');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_country->addCountry($this->request->post);
            
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
            
            $this->response->redirect($this->url->link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/country');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('localization/country');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_country->editCountry($this->request->get['country_id'], $this->request->post);
            
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
            
            $this->response->redirect($this->url->link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/country');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('localization/country');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $country_id) {
                $this->model_localization_country->deleteCountry($country_id);
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
            
            $this->response->redirect($this->url->link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('localization/country');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/country', $url);
        
        $data['insert'] = $this->url->link('localization/country/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/country/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['countries'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $country_total = $this->model_localization_country->getTotalCountries();
        
        $results = $this->model_localization_country->getCountries($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/country/update', 'token=' . $this->session->data['token'] . '&country_id=' . $result['country_id'] . $url, 'SSL'));
            
            $data['countries'][] = array('country_id' => $result['country_id'], 'name' => $result['name'] . (($result['country_id'] == $this->config->get('config_country_id')) ? $this->language->get('lang_text_default') : null), 'iso_code_2' => $result['iso_code_2'], 'iso_code_3' => $result['iso_code_3'], 'selected' => isset($this->request->post['selected']) && in_array($result['country_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = $this->url->link('localization/country', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_iso_code_2'] = $this->url->link('localization/country', 'token=' . $this->session->data['token'] . '&sort=iso_code_2' . $url, 'SSL');
        $data['sort_iso_code_3'] = $this->url->link('localization/country', 'token=' . $this->session->data['token'] . '&sort=iso_code_3' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($country_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/country', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/country_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('localization/country');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/country', $url);
        
        if (!isset($this->request->get['country_id'])) {
            $data['action'] = $this->url->link('localization/country/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/country/update', 'token=' . $this->session->data['token'] . '&country_id=' . $this->request->get['country_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/country', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
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
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/country_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localization/country')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 128)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'localization/country')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('setting/store');
        $this->theme->model('people/customer');
        $this->theme->model('localization/zone');
        $this->theme->model('localization/geozone');
        
        foreach ($this->request->post['selected'] as $country_id) {
            if ($this->config->get('config_country_id') == $country_id) {
                $this->error['warning'] = $this->language->get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByCountryId($country_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_store'), $store_total);
            }
            
            $address_total = $this->model_people_customer->getTotalAddressesByCountryId($country_id);
            
            if ($address_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_address'), $address_total);
            }
            
            $affiliate_total = $this->model_people_customer->getTotalAffiliatesByCountryId($country_id);
            
            if ($affiliate_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_affiliate'), $affiliate_total);
            }
            
            $zones = $this->model_localization_zone->findZonesByCountryId($country_id);
            
            if (!empty($zones) && !$this->error) {
                foreach ($zones as $zone):
                    $this->model_localization_zone->deleteZone($zone['zone_id']);
                endforeach;
            }
            
            $geo_zones = $this->model_localization_geozone->getGeoZonesByCountryId($country_id);
            
            if (!empty($geo_zones) && !$this->error) {
                foreach ($geo_zones as $geo_zone):
                    $this->model_localization_geozone->deleteGeoZone($geo_zone['geo_zone_id']);
                endforeach;
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
