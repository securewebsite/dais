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

namespace App\Controllers\Admin\Design;

use App\Controllers\Controller;

class Layout extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('design/layout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/layout');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('design/layout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/layout');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            DesignLayout::addLayout(Request::post());
            
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
            
            Response::redirect(Url::link('design/layout', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('design/layout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/layout');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            DesignLayout::editLayout(Request::p()->get['layout_id'], Request::post());
            
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
            
            Response::redirect(Url::link('design/layout', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('design/layout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/layout');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $layout_id) {
                DesignLayout::deleteLayout($layout_id);
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
            
            Response::redirect(Url::link('design/layout', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('design/layout');
        
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
        
        Breadcrumb::add('lang_heading_title', 'design/layout', $url);
        
        $data['insert'] = Url::link('design/layout/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('design/layout/delete', '' . $url, 'SSL');
        
        $data['layouts'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $layout_total = DesignLayout::getTotalLayouts();
        
        $results = DesignLayout::getLayouts($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('design/layout/update', '' . 'layout_id=' . $result['layout_id'] . $url, 'SSL'));
            
            $data['layouts'][] = array('layout_id' => $result['layout_id'], 'name' => $result['name'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['layout_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('design/layout', '' . 'sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($layout_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('design/layout', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('design/layout_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('design/layout');
        
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
        
        Breadcrumb::add('lang_heading_title', 'design/layout', $url);
        
        if (!isset(Request::p()->get['layout_id'])) {
            $data['action'] = Url::link('design/layout/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('design/layout/update', '' . 'layout_id=' . Request::p()->get['layout_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('design/layout', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['layout_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $layout_info = DesignLayout::getLayout(Request::p()->get['layout_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($layout_info)) {
            $data['name'] = $layout_info['name'];
        } else {
            $data['name'] = '';
        }
        
        Theme::model('setting/store');
        
        $data['stores'] = SettingStore::getStores();
        
        if (isset(Request::p()->post['layout_route'])) {
            $data['layout_routes'] = Request::p()->post['layout_route'];
        } elseif (isset(Request::p()->get['layout_id'])) {
            $data['layout_routes'] = DesignLayout::getLayoutRoutes(Request::p()->get['layout_id']);
        } else {
            $data['layout_routes'] = array();
        }
        
        Theme::loadjs('javascript/design/layout_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('design/layout_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'design/layout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 64)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'design/layout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('catalog/product');
        Theme::model('catalog/category');
        Theme::model('content/page');
        
        foreach (Request::p()->post['selected'] as $layout_id) {
            if (Config::get('config_layout_id') == $layout_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = SettingStore::getTotalStoresByLayoutId($layout_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $product_total = CatalogProduct::getTotalProductsByLayoutId($layout_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
            
            $category_total = CatalogCategory::getTotalCategoriesByLayoutId($layout_id);
            
            if ($category_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_category'), $category_total);
            }
            
            $page_total = ContentPage::getTotalPagesByLayoutId($layout_id);
            
            if ($page_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_page'), $page_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
