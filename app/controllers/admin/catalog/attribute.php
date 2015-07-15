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

namespace App\Controllers\Admin\Catalog;

use App\Controllers\Controller;

class Attribute extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('catalog/attribute');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/attribute');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('catalog/attribute');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/attribute');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_attribute->addAttribute($this->request->post);
            
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
            
            Response::redirect(Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/attribute');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/attribute');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_attribute->editAttribute($this->request->get['attribute_id'], $this->request->post);
            
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
            
            Response::redirect(Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/attribute');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/attribute');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $attribute_id) {
                $this->model_catalog_attribute->deleteAttribute($attribute_id);
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
            
            Response::redirect(Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/attribute');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'ad.name';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/attribute', $url);
        
        $data['insert'] = Url::link('catalog/attribute/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('catalog/attribute/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['attributes'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $attribute_total = $this->model_catalog_attribute->getTotalAttributes();
        
        $results = $this->model_catalog_attribute->getAttributes($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('catalog/attribute/update', 'token=' . $this->session->data['token'] . '&attribute_id=' . $result['attribute_id'] . $url, 'SSL'));
            
            $data['attributes'][] = array('attribute_id' => $result['attribute_id'], 'name' => $result['name'], 'attribute_group' => $result['attribute_group'], 'sort_order' => $result['sort_order'], 'selected' => isset($this->request->post['selected']) && in_array($result['attribute_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=ad.name' . $url, 'SSL');
        $data['sort_attribute_group'] = Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=attribute_group' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=a.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($attribute_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('catalog/attribute_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/attribute');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/attribute', $url);
        
        if (!isset($this->request->get['attribute_id'])) {
            $data['action'] = Url::link('catalog/attribute/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/attribute/update', 'token=' . $this->session->data['token'] . '&attribute_id=' . $this->request->get['attribute_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['attribute_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $attribute_info = $this->model_catalog_attribute->getAttribute($this->request->get['attribute_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = $this->model_locale_language->getLanguages();
        
        if (isset($this->request->post['attribute_description'])) {
            $data['attribute_description'] = $this->request->post['attribute_description'];
        } elseif (isset($this->request->get['attribute_id'])) {
            $data['attribute_description'] = $this->model_catalog_attribute->getAttributeDescriptions($this->request->get['attribute_id']);
        } else {
            $data['attribute_description'] = array();
        }
        
        if (isset($this->request->post['attribute_group_id'])) {
            $data['attribute_group_id'] = $this->request->post['attribute_group_id'];
        } elseif (!empty($attribute_info)) {
            $data['attribute_group_id'] = $attribute_info['attribute_group_id'];
        } else {
            $data['attribute_group_id'] = '';
        }
        
        Theme::model('catalog/attribute_group');
        
        $data['attribute_groups'] = $this->model_catalog_attribute_group->getAttributeGroups();
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($attribute_info)) {
            $data['sort_order'] = $attribute_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('catalog/attribute_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/attribute')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['attribute_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 64)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'catalog/attribute')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $attribute_id) {
            $product_total = $this->model_catalog_product->getTotalProductsByAttributeId($attribute_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_name'])) {
            Theme::model('catalog/attribute');
            
            $filter = array('filter_name' => $this->request->get['filter_name'], 'start' => 0, 'limit' => 20);
            
            $json = array();
            
            $results = $this->model_catalog_attribute->getAttributes($filter);
            
            foreach ($results as $result) {
                $json[] = array('attribute_id' => $result['attribute_id'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 'attribute_group' => $result['attribute_group']);
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
