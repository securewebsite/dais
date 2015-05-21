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

class GeoZone extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/geo_zone');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/geo_zone');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/geo_zone');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/geo_zone');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_geo_zone->addGeoZone($this->request->post);
            
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
            
            $this->response->redirect($this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/geo_zone');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/geo_zone');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_geo_zone->editGeoZone($this->request->get['geo_zone_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/geo_zone');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/geo_zone');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $geo_zone_id) {
                $this->model_localization_geo_zone->deleteGeoZone($geo_zone_id);
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
            
            $this->response->redirect($this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('localization/geo_zone');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/geo_zone', $url);
        
        $data['insert'] = $this->url->link('localization/geo_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/geo_zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['geo_zones'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $geo_zone_total = $this->model_localization_geo_zone->getTotalGeoZones();
        
        $results = $this->model_localization_geo_zone->getGeoZones($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/geo_zone/update', 'token=' . $this->session->data['token'] . '&geo_zone_id=' . $result['geo_zone_id'] . $url, 'SSL'));
            
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
        
        $data['sort_name'] = $this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_description'] = $this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . '&sort=description' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($geo_zone_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/geo_zone_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('localization/geo_zone');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/geo_zone', $url);
        
        if (!isset($this->request->get['geo_zone_id'])) {
            $data['action'] = $this->url->link('localization/geo_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/geo_zone/update', 'token=' . $this->session->data['token'] . '&geo_zone_id=' . $this->request->get['geo_zone_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['geo_zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $geo_zone_info = $this->model_localization_geo_zone->getGeoZone($this->request->get['geo_zone_id']);
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
        
        $this->theme->model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries(array('filter_status' => 1));
        
        if (isset($this->request->post['zone_to_geo_zone'])) {
            $data['zone_to_geo_zones'] = $this->request->post['zone_to_geo_zone'];
        } elseif (isset($this->request->get['geo_zone_id'])) {
            $data['zone_to_geo_zones'] = $this->model_localization_geo_zone->getZoneToGeoZones($this->request->get['geo_zone_id']);
        } else {
            $data['zone_to_geo_zones'] = array();
        }
        
        $this->theme->loadjs('javascript/localization/geo_zone_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/geo_zone_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localization/geo_zone')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        if (($this->encode->strlen($this->request->post['description']) < 3) || ($this->encode->strlen($this->request->post['description']) > 255)) {
            $this->error['description'] = $this->language->get('lang_error_description');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'localization/geo_zone')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('localization/tax_rate');
        
        foreach ($this->request->post['selected'] as $geo_zone_id) {
            $tax_rate_total = $this->model_localization_tax_rate->getTotalTaxRatesByGeoZoneId($geo_zone_id);
            
            if ($tax_rate_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_tax_rate'), $tax_rate_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function zone() {
        $output = '<option value="0">' . $this->language->get('lang_text_all_zones') . '</option>';
        
        $this->theme->model('localization/zone');
        
        $results = $this->model_localization_zone->getZonesByCountryId($this->request->get['country_id']);
        
        foreach ($results as $result) {
            $output.= '<option value="' . $result['zone_id'] . '"';
            
            if ($this->request->get['zone_id'] == $result['zone_id']) {
                $output.= ' selected="selected"';
            }
            
            $output.= '>' . $result['name'] . '</option>';
        }
        
        $this->response->setOutput($output);
    }
}
