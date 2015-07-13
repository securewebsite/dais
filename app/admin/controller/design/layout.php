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

namespace Admin\Controller\Design;
use Dais\Base\Controller;

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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_layout->addLayout($this->request->post);
            
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
            
            Response::redirect(Url::link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('design/layout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/layout');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_layout->editLayout($this->request->get['layout_id'], $this->request->post);
            
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
            
            Response::redirect(Url::link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('design/layout');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/layout');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $layout_id) {
                $this->model_design_layout->deleteLayout($layout_id);
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
            
            Response::redirect(Url::link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('design/layout');
        
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
        
        Breadcrumb::add('lang_heading_title', 'design/layout', $url);
        
        $data['insert'] = Url::link('design/layout/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('design/layout/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['layouts'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $layout_total = $this->model_design_layout->getTotalLayouts();
        
        $results = $this->model_design_layout->getLayouts($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('design/layout/update', 'token=' . $this->session->data['token'] . '&layout_id=' . $result['layout_id'] . $url, 'SSL'));
            
            $data['layouts'][] = array('layout_id' => $result['layout_id'], 'name' => $result['name'], 'selected' => isset($this->request->post['selected']) && in_array($result['layout_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('design/layout', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($layout_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('design/layout', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('design/layout_list', $data));
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'design/layout', $url);
        
        if (!isset($this->request->get['layout_id'])) {
            $data['action'] = Url::link('design/layout/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('design/layout/update', 'token=' . $this->session->data['token'] . '&layout_id=' . $this->request->get['layout_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['layout_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $layout_info = $this->model_design_layout->getLayout($this->request->get['layout_id']);
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($layout_info)) {
            $data['name'] = $layout_info['name'];
        } else {
            $data['name'] = '';
        }
        
        Theme::model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['layout_route'])) {
            $data['layout_routes'] = $this->request->post['layout_route'];
        } elseif (isset($this->request->get['layout_id'])) {
            $data['layout_routes'] = $this->model_design_layout->getLayoutRoutes($this->request->get['layout_id']);
        } else {
            $data['layout_routes'] = array();
        }
        
        Theme::loadjs('javascript/design/layout_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('design/layout_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'design/layout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 64)) {
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
        
        foreach ($this->request->post['selected'] as $layout_id) {
            if (Config::get('config_layout_id') == $layout_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByLayoutId($layout_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $product_total = $this->model_catalog_product->getTotalProductsByLayoutId($layout_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
            
            $category_total = $this->model_catalog_category->getTotalCategoriesByLayoutId($layout_id);
            
            if ($category_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_category'), $category_total);
            }
            
            $page_total = $this->model_content_page->getTotalPagesByLayoutId($layout_id);
            
            if ($page_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_page'), $page_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
