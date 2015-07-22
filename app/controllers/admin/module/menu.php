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

namespace App\Controllers\Admin\Module;

use App\Controllers\Controller;

class Menu extends Controller {
    
    private $error;
    
    public function index() {
        Lang::load('module/menu');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/menu');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('module/menu');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/menu');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ModuleMenu::addMenu(Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('module/menu', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('module/menu');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/menu');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ModuleMenu::editMenu(Request::p()->get['menu_id'], Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('module/menu', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('module/menu');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('module/menu');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $menu_id) {
                ModuleMenu::deleteMenu($menu_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('module/menu', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function getList() {
        $data = Theme::language('module/menu');
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $url = '';
        
        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;
        
        Breadcrumb::add('lang_heading_title', 'module/menu');
        
        $data['insert'] = Url::link('module/menu/insert', $url, 'SSL');
        $data['delete'] = Url::link('module/menu/delete', $url, 'SSL');
        
        $data['menus'] = array();
        
        $filter = array(
            'start' => ($page - 1) * Config::get('config_admin_limit'), 
            'limit' => Config::get('config_admin_limit')
        );
        
        $menu_total = ModuleMenu::getTotalMenus();
        $results    = ModuleMenu::getMenus($filter);
        
        foreach ($results as $result):
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('module/menu/update', 'menu_id=' . $result['menu_id'] . $url, 'SSL')
            );
            
            $data['menus'][] = array(
                'menu_id'  => $result['menu_id'], 
                'name'     => $result['name'], 
                'type'     => Lang::get('lang_text_' . $result['type']), 
                'status'   => $result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled'), 
                'selected' => isset(Request::p()->post['selected']) && in_array($result['menu_id'], Request::p()->post['selected']), 
                'action'   => $action
            );
        endforeach;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $data['pagination'] = Theme::paginate(
            $menu_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('module/menu', $url . '&page={page}', 'SSL')
        );
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/menu_builder_list', $data));
    }
    
    public function getForm() {
        $data = Theme::language('module/menu');
        
        $errors = array('warning', 'name', 'type', 'items');
        
        foreach ($errors as $err):
            if (isset($this->error[$err])):
                $data["error_{$err}"] = $this->error[$err];
            else:
                $data["error_{$err}"] = '';
            endif;
        endforeach;
        
        // Hack for passing error to ajax delivered panels
        if (isset($this->error['items'])):
            Session::p()->data['error_items'] = $this->error['items'];
        endif;
        
        $url = '';
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'module/menu', $url);
        
        if (!isset(Request::p()->get['menu_id'])):
            $data['action'] = Url::link('module/menu/insert', $url, 'SSL');
        else:
            $data['action'] = Url::link('module/menu/update', 'menu_id=' . Request::p()->get['menu_id'] . $url, 'SSL');
        endif;
        
        $data['cancel'] = Url::link('module/menu', $url, 'SSL');
        
        $data['menu_id'] = false;
        
        if (isset(Request::p()->get['menu_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $results = ModuleMenu::getMenu(Request::p()->get['menu_id']);
            $data['menu_id'] = Request::p()->get['menu_id'];
        }
        
        $fields = array(
            'name', 
            'type', 
            'items', 
            'status'
        );
        
        foreach ($fields as $field):
            if (isset(Request::p()->post[$field])):
                $data[$field] = Request::p()->post[$field];
            elseif (!empty($results)):
                $data[$field] = $results[$field];
            else:
                $data[$field] = false;
            endif;
        endforeach;
        
        $data['menu_types'] = array();
        
        $menu_types = array(
            'product_category' => Lang::get('lang_text_product_category'), 
            'content_category' => Lang::get('lang_text_content_category'), 
            'page'             => Lang::get('lang_text_page'), 
            'post'             => Lang::get('lang_text_post'), 
            'custom'           => Lang::get('lang_text_custom')
        );
        
        foreach ($menu_types as $key => $value):
            $data['menu_types'][] = array(
                'type' => $key, 
                'name' => $value
            );
        endforeach;
        
        $data['layouts'] = array();
        
        $data['menu_item'] = array();
        
        Theme::loadjs('javascript/module/menu_builder_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/menu_builder_form', $data));
    }
    
    private function validateForm() {
        if (!User::hasPermission('modify', 'module/menu')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 32)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if (!Request::p()->post['type']):
            $this->error['type'] = Lang::get('lang_error_type');
        endif;
        
        if (!isset(Request::p()->post['menu_item'])):
            $this->error['items'] = Lang::get('lang_error_items');
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = Lang::get('lang_error_warning');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!User::hasPermission('modify', 'module/menu')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function product_category() {
        $data = Theme::language('module/menu');
        
        Theme::model('catalog/category');
        Theme::model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset(Request::p()->get['menu_id'])):
            $result = ModuleMenu::getMenu(Request::p()->get['menu_id']);
            if ($result['type'] === 'product_category'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        if (isset(Session::p()->data['error_items'])):
            $data['error_items'] = Session::p()->data['error_items'];
            unset(Session::p()->data['error_items']);
        else:
            $data['error_items'] = '';
        endif;
        
        $data['categories'] = array();
        
        $data['lang_entry_category'] = Lang::get('lang_entry_product_category');
        
        $results = CatalogCategory::getCategories();
        
        foreach ($results as $result):
            $data['categories'][] = array(
                'category_id' => $result['category_id'], 
                'name'        => $result['name']
            );
        endforeach;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('module/menu_category', $data));
    }
    
    public function content_category() {
        $data = Theme::language('module/menu');
        
        Theme::model('content/category');
        Theme::model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset(Request::p()->get['menu_id'])):
            $result = ModuleMenu::getMenu(Request::p()->get['menu_id']);
            if ($result['type'] === 'content_category'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        if (isset(Session::p()->data['error_items'])):
            $data['error_items'] = Session::p()->data['error_items'];
            unset(Session::p()->data['error_items']);
        else:
            $data['error_items'] = '';
        endif;
        
        $data['categories'] = array();
        
        $data['lang_entry_category'] = Lang::get('lang_entry_content_category');
        
        $results = ContentCategory::getCategories(0);
        
        foreach ($results as $result):
            $data['categories'][] = array(
                'category_id' => $result['category_id'], 
                'name'        => $result['name']
            );
        endforeach;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('module/menu_category', $data));
    }
    
    public function page() {
        $data = Theme::language('module/menu');
        
        Theme::model('content/page');
        Theme::model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset(Request::p()->get['menu_id'])):
            $result = ModuleMenu::getMenu(Request::p()->get['menu_id']);
            if ($result['type'] === 'page'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        $data['singles'] = array();
        
        $data['lang_entry_single'] = Lang::get('lang_entry_page');
        
        $results = ContentPage::getPages();
        
        foreach ($results as $result):
            $data['singles'][] = array(
                'item_id' => $result['page_id'], 
                'name'    => $result['title']
            );
        endforeach;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('module/menu_single', $data));
    }
    
    public function post() {
        $data = Theme::language('module/menu');
        
        Theme::model('content/post');
        Theme::model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset(Request::p()->get['menu_id'])):
            $result = ModuleMenu::getMenu(Request::p()->get['menu_id']);
            if ($result['type'] === 'post'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        $data['singles'] = array();
        
        $data['lang_entry_single'] = Lang::get('lang_entry_post');
        
        $results = ContentPost::getPosts();
        
        foreach ($results as $result):
            $data['singles'][] = array(
                'item_id' => $result['post_id'], 
                'name'    => $result['name']
            );
        endforeach;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('module/menu_single', $data));
    }
    
    public function custom() {
        $data = Theme::language('module/menu');
        
        Theme::model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset(Request::p()->get['menu_id'])):
            $result = ModuleMenu::getMenu(Request::p()->get['menu_id']);
            if ($result['type'] === 'custom'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        if (isset(Session::p()->data['error_items'])):
            $data['error_items'] = Session::p()->data['error_items'];
            unset(Session::p()->data['error_items']);
        else:
            $data['error_items'] = '';
        endif;
        
        Theme::loadjs('javascript/module/menu_custom', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::make('module/menu_custom', $data));
    }
}
