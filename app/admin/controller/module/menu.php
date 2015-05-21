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

namespace Admin\Controller\Module;
use Dais\Engine\Controller;

class Menu extends Controller {
    private $error;
    
    public function index() {
        $this->language->load('module/menu');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/menu');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('module/menu');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/menu');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_module_menu->addMenu($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('module/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('module/menu');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/menu');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_module_menu->editMenu($this->request->get['menu_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('module/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('module/menu');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/menu');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $menu_id) {
                $this->model_module_menu->deleteMenu($menu_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('module/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function getList() {
        $data = $this->theme->language('module/menu');
        
        if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'module/menu');
        
        $data['insert'] = $this->url->link('module/menu/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('module/menu/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['menus'] = array();
        
        $filter = array(
            'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            'limit' => $this->config->get('config_admin_limit')
        );
        
        $menu_total = $this->model_module_menu->getTotalMenus();
        $results = $this->model_module_menu->getMenus($filter);
        
        foreach ($results as $result):
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_edit'), 
                'href' => $this->url->link('module/menu/update', 'token=' . $this->session->data['token'] . '&menu_id=' . $result['menu_id'] . $url, 'SSL')
            );
            
            $data['menus'][] = array(
                'menu_id'  => $result['menu_id'], 
                'name'     => $result['name'], 
                'type'     => $this->language->get('lang_text_' . $result['type']), 
                'status'   => $result['status'] ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled'), 
                'selected' => isset($this->request->post['selected']) && in_array($result['menu_id'], $this->request->post['selected']), 
                'action'   => $action
            );
        endforeach;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $data['pagination'] = $this->theme->paginate(
            $menu_total, 
            $page, 
            $this->config->get('config_admin_limit'), 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('module/menu', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('module/menu_builder_list', $data));
    }
    
    public function getForm() {
        $data = $this->theme->language('module/menu');
        
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
            $this->session->data['error_items'] = $this->error['items'];
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'module/menu', $url);
        
        if (!isset($this->request->get['menu_id'])):
            $data['action'] = $this->url->link('module/menu/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        else:
            $data['action'] = $this->url->link('module/menu/update', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL');
        endif;
        
        $data['cancel'] = $this->url->link('module/menu', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['menu_id'] = false;
        
        if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $results = $this->model_module_menu->getMenu($this->request->get['menu_id']);
            $data['menu_id'] = $this->request->get['menu_id'];
        }
        
        $data['token'] = $this->session->data['token'];
        
        $fields = array(
            'name', 
            'type', 
            'items', 
            'status'
        );
        
        foreach ($fields as $field):
            if (isset($this->request->post[$field])):
                $data[$field] = $this->request->post[$field];
            elseif (!empty($results)):
                $data[$field] = $results[$field];
            else:
                $data[$field] = false;
            endif;
        endforeach;
        
        $data['menu_types'] = array();
        
        $menu_types = array(
            'product_category' => $this->language->get('lang_text_product_category'), 
            'content_category' => $this->language->get('lang_text_content_category'), 
            'page'             => $this->language->get('lang_text_page'), 
            'post'             => $this->language->get('lang_text_post'), 
            'custom'           => $this->language->get('lang_text_custom')
        );
        
        foreach ($menu_types as $key => $value):
            $data['menu_types'][] = array(
                'type' => $key, 
                'name' => $value
            );
        endforeach;
        
        $data['layouts'] = array();
        
        $data['menu_item'] = array();
        
        $this->theme->loadjs('javascript/module/menu_builder_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('module/menu_builder_form', $data));
    }
    
    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'module/menu')):
            $this->error['warning'] = $this->language->get('lang_error_permission');
        endif;
        
        if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        if (!$this->request->post['type']):
            $this->error['type'] = $this->language->get('lang_error_type');
        endif;
        
        if (!isset($this->request->post['menu_item'])):
            $this->error['items'] = $this->language->get('lang_error_items');
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = $this->language->get('lang_error_warning');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'module/menu')):
            $this->error['warning'] = $this->language->get('lang_error_permission');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function product_category() {
        $data = $this->theme->language('module/menu');
        
        $this->theme->model('catalog/category');
        $this->theme->model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset($this->request->get['menu_id'])):
            $result = $this->model_module_menu->getMenu($this->request->get['menu_id']);
            if ($result['type'] === 'product_category'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        if (isset($this->session->data['error_items'])):
            $data['error_items'] = $this->session->data['error_items'];
            unset($this->session->data['error_items']);
        else:
            $data['error_items'] = '';
        endif;
        
        $data['categories'] = array();
        
        $data['lang_entry_category'] = $this->language->get('lang_entry_product_category');
        
        $results = $this->model_catalog_category->getCategories();
        
        foreach ($results as $result):
            $data['categories'][] = array(
                'category_id' => $result['category_id'], 
                'name'        => $result['name']
            );
        endforeach;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('module/menu_category', $data));
    }
    
    public function content_category() {
        $data = $this->theme->language('module/menu');
        
        $this->theme->model('content/category');
        $this->theme->model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset($this->request->get['menu_id'])):
            $result = $this->model_module_menu->getMenu($this->request->get['menu_id']);
            if ($result['type'] === 'content_category'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        if (isset($this->session->data['error_items'])):
            $data['error_items'] = $this->session->data['error_items'];
            unset($this->session->data['error_items']);
        else:
            $data['error_items'] = '';
        endif;
        
        $data['categories'] = array();
        
        $data['lang_entry_category'] = $this->language->get('lang_entry_content_category');
        
        $results = $this->model_content_category->getCategories(0);
        
        foreach ($results as $result):
            $data['categories'][] = array(
                'category_id' => $result['category_id'], 
                'name'        => $result['name']
            );
        endforeach;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('module/menu_category', $data));
    }
    
    public function page() {
        $data = $this->theme->language('module/menu');
        
        $this->theme->model('content/page');
        $this->theme->model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset($this->request->get['menu_id'])):
            $result = $this->model_module_menu->getMenu($this->request->get['menu_id']);
            if ($result['type'] === 'page'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        $data['singles'] = array();
        
        $data['lang_entry_single'] = $this->language->get('lang_entry_page');
        
        $results = $this->model_content_page->getPages();
        
        foreach ($results as $result):
            $data['singles'][] = array(
                'item_id' => $result['page_id'], 
                'name'    => $result['title']
            );
        endforeach;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('module/menu_single', $data));
    }
    
    public function post() {
        $data = $this->theme->language('module/menu');
        
        $this->theme->model('content/post');
        $this->theme->model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset($this->request->get['menu_id'])):
            $result = $this->model_module_menu->getMenu($this->request->get['menu_id']);
            if ($result['type'] === 'post'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        $data['singles'] = array();
        
        $data['lang_entry_single'] = $this->language->get('lang_entry_post');
        
        $results = $this->model_content_post->getPosts();
        
        foreach ($results as $result):
            $data['singles'][] = array(
                'item_id' => $result['post_id'], 
                'name'    => $result['name']
            );
        endforeach;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('module/menu_single', $data));
    }
    
    public function custom() {
        $data = $this->theme->language('module/menu');
        
        $this->theme->model('module/menu');
        
        $data['menu_items'] = array();
        
        if (isset($this->request->get['menu_id'])):
            $result = $this->model_module_menu->getMenu($this->request->get['menu_id']);
            if ($result['type'] === 'custom'):
                $data['menu_items'] = $result['items'];
            endif;
        endif;
        
        if (isset($this->session->data['error_items'])):
            $data['error_items'] = $this->session->data['error_items'];
            unset($this->session->data['error_items']);
        else:
            $data['error_items'] = '';
        endif;
        
        $this->theme->loadjs('javascript/module/menu_custom', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = $this->theme->controller('common/javascript');
        
        $this->response->setOutput($this->theme->view('module/menu_custom', $data));
    }
}
