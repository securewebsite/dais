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

class AttributeGroup extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('catalog/attribute_group');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/attribute_group');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('catalog/attribute_group');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/attribute_group');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogAttributeGroup::addAttributeGroup(Request::post());
            
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
            
            Response::redirect(Url::link('catalog/attribute_group', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/attribute_group');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/attribute_group');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogAttributeGroup::editAttributeGroup(Request::p()->get['attribute_group_id'], Request::post());
            
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
            
            Response::redirect(Url::link('catalog/attribute_group', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/attribute_group');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/attribute_group');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $attribute_group_id) {
                CatalogAttributeGroup::deleteAttributeGroup($attribute_group_id);
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
            
            Response::redirect(Url::link('catalog/attribute_group', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/attribute_group');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'name';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/attribute_group', $url);
        
        $data['insert'] = Url::link('catalog/attribute_group/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('catalog/attribute_group/delete', '' . $url, 'SSL');
        
        $data['attribute_groups'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $attribute_group_total = CatalogAttributeGroup::getTotalAttributeGroups();
        
        $results = CatalogAttributeGroup::getAttributeGroups($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('catalog/attribute_group/update', '' . 'attribute_group_id=' . $result['attribute_group_id'] . $url, 'SSL'));
            
            $data['attribute_groups'][] = array('attribute_group_id' => $result['attribute_group_id'], 'name' => $result['name'], 'sort_order' => $result['sort_order'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['attribute_group_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('catalog/attribute_group', '' . 'sort=agd.name' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('catalog/attribute_group', '' . 'sort=ag.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($attribute_group_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/attribute_group', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('catalog/attribute_group_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/attribute_group');
        
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'catalog/attribute_group', $url);
        
        if (!isset(Request::p()->get['attribute_group_id'])) {
            $data['action'] = Url::link('catalog/attribute_group/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/attribute_group/update', '' . 'attribute_group_id=' . Request::p()->get['attribute_group_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/attribute_group', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['attribute_group_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $attribute_group_info = CatalogAttributeGroup::getAttributeGroup(Request::p()->get['attribute_group_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['attribute_group_description'])) {
            $data['attribute_group_description'] = Request::p()->post['attribute_group_description'];
        } elseif (isset(Request::p()->get['attribute_group_id'])) {
            $data['attribute_group_description'] = CatalogAttributeGroup::getAttributeGroupDescriptions(Request::p()->get['attribute_group_id']);
        } else {
            $data['attribute_group_description'] = array();
        }
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($attribute_group_info)) {
            $data['sort_order'] = $attribute_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('catalog/attribute_group_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/attribute_group')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['attribute_group_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 64)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'catalog/attribute_group')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/attribute');
        
        foreach (Request::p()->post['selected'] as $attribute_group_id) {
            $attribute_total = CatalogAttribute::getTotalAttributesByAttributeGroupId($attribute_group_id);
            
            if ($attribute_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_attribute'), $attribute_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
