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

namespace Admin\Controller\Content;
use Dais\Engine\Controller;

class Category extends Controller {
    private $error = array();
    
    public function index() {
        $this->theme->language('content/category');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/category');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->theme->language('content/category');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/category');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_category->addCategory($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('content/category', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->theme->language('content/category');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/category');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_category->editCategory($this->request->get['category_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('content/category', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->theme->language('content/category');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/category');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $category_id) {
                $this->model_content_category->deleteCategory($category_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            $this->response->redirect($this->url->link('content/category', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    private function getList() {
        $data = $this->theme->language('content/category');
        
        $this->breadcrumb->add('lang_heading_title', 'content/category');
        
        $data['insert'] = $this->url->link('content/category/insert', 'token=' . $this->session->data['token'], 'SSL');
        $data['delete'] = $this->url->link('content/category/delete', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['categories'] = array();
        
        $results = $this->model_content_category->getCategories(0);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_edit'), 
                'href' => $this->url->link('content/category/update', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'], 'SSL')
            );
            
            $data['categories'][] = array(
                'category_id' => $result['category_id'], 
                'name'        => $result['name'], 
                'sort_order'  => $result['sort_order'], 
                'selected'    => isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected']), 
                'action'      => $action
            );
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
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/category_list', $data));
    }
    
    private function getForm() {
        $data = $this->theme->language('content/category');
        
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
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = array();
        }
        
        $this->breadcrumb->add('lang_heading_title', 'content/category');
        
        if (!isset($this->request->get['category_id'])) {
            $data['action'] = $this->url->link('content/category/insert', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $data['action'] = $this->url->link('content/category/update', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'], 'SSL');
        }
        
        $data['cancel'] = $this->url->link('content/category', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $category_info = $this->model_content_category->getCategory($this->request->get['category_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['category_description'])) {
            $data['category_description'] = $this->request->post['category_description'];
        } elseif (isset($this->request->get['category_id'])) {
            $data['category_description'] = $this->model_content_category->getCategoryDescriptions($this->request->get['category_id']);
        } else {
            $data['category_description'] = array();
        }
        
        $categories = $this->model_content_category->getCategories(0);
        
        // Remove own id from list
        if (!empty($category_info)) {
            foreach ($categories as $key => $category) {
                if ($category['category_id'] == $category_info['category_id']) {
                    unset($categories[$key]);
                }
            }
        }
        
        $data['categories'] = $categories;
        
        if (isset($this->request->post['parent_id'])) {
            $data['parent_id'] = $this->request->post['parent_id'];
        } elseif (!empty($category_info)) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['category_store'])) {
            $data['category_store'] = $this->request->post['category_store'];
        } elseif (isset($this->request->get['category_id'])) {
            $data['category_store'] = $this->model_content_category->getCategoryStores($this->request->get['category_id']);
        } else {
            $data['category_store'] = array(0);
        }
        
        if (isset($this->request->post['slug'])) {
            $data['slug'] = $this->request->post['slug'];
        } elseif (!empty($category_info)) {
            $data['slug'] = $category_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($category_info)) {
            $data['image'] = $category_info['image'];
        } else {
            $data['image'] = '';
        }
        
        $this->theme->model('tool/image');
        
        if (isset($this->request->post['image']) && file_exists($this->app['path.image'] . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($category_info) && $category_info['image'] && file_exists($this->app['path.image'] . $category_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($category_info)) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        if (isset($this->request->post['category_layout'])) {
            $data['category_layout'] = $this->request->post['category_layout'];
        } elseif (isset($this->request->get['category_id'])) {
            $data['category_layout'] = $this->model_content_category->getCategoryLayouts($this->request->get['category_id']);
        } else {
            $data['category_layout'] = array();
        }
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();

        $this->theme->loadjs('javascript/content/category_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/category_form', $data));
    }
    
    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'content/category')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['category_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 2) || ($this->encode->strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
        }
        
        if (isset($this->request->post['slug']) && $this->encode->strlen($this->request->post['slug']) > 0):
            $this->theme->model('tool/utility');
            $query = $this->model_tool_utility->findSlugByName($this->request->post['slug']);
            
            if (isset($this->request->get['category_id'])):
                if ($query):
                    if ($query != 'blog_category_id:' . $this->request->get['category_id']):
                        $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                    endif;
                endif;
            else:
                if ($query):
                    $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                endif;
            endif;
        else:
            $this->error['slug'] = $this->language->get('lang_error_slug');
        endif;
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_warning');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'content/category')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function slug() {
        $this->language->load('content/category');
        $this->theme->model('tool/utility');
        
        $json = array();
        
        if (!isset($this->request->get['name']) || $this->encode->strlen($this->request->get['name']) < 1):
            $json['error'] = $this->language->get('lang_error_name_first');
        else:
            
            // build slug
            $slug = $this->url->build_slug($this->request->get['name']);
            
            // check that the slug is globally unique
            $query = $this->model_tool_utility->findSlugByName($slug);
            
            if ($query):
                if (isset($this->request->get['category_id'])):
                    if ($query != 'blog_category_id:' . $this->request->get['category_id']):
                        $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                    else:
                        $json['slug'] = $slug;
                    endif;
                else:
                    $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                endif;
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }

    public function description() {
        $json = array();

        if (isset($this->request->post['description']))
            $json['success'] = $this->keyword->getDescription($this->request->post['description']);

        $this->response->setOutput(json_encode($json));
    }

    public function keyword() {
        $json = array();

        if (isset($this->request->post['keywords'])):
            // let's clean up the data first
            $keywords        = $this->keyword->getDescription($this->request->post['keywords']);
            $json['success'] = $this->keyword->getKeywords($keywords);
        endif;

        $this->response->setOutput(json_encode($json));
    }
}
