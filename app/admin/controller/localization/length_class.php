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

class LengthClass extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/length_class');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/length_class');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/length_class');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/length_class');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_length_class->addLengthClass($this->request->post);
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
            
            Response::redirect($this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/length_class');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/length_class');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_length_class->editLengthClass($this->request->get['length_class_id'], $this->request->post);
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
            
            Response::redirect($this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/length_class');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('localization/length_class');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $length_class_id) {
                $this->model_localization_length_class->deleteLengthClass($length_class_id);
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
            
            Response::redirect($this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('localization/length_class');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'title';
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/length_class', $url);
        
        $data['insert'] = $this->url->link('localization/length_class/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/length_class/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['length_classes'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $length_class_total = $this->model_localization_length_class->getTotalLengthClasses();
        
        $results = $this->model_localization_length_class->getLengthClasses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/length_class/update', 'token=' . $this->session->data['token'] . '&length_class_id=' . $result['length_class_id'] . $url, 'SSL'));
            
            $data['length_classes'][] = array('length_class_id' => $result['length_class_id'], 'title' => $result['title'] . (($result['unit'] == Config::get('config_length_class')) ? $this->language->get('lang_text_default') : null), 'unit' => $result['unit'], 'value' => $result['value'], 'selected' => isset($this->request->post['selected']) && in_array($result['length_class_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_title'] = $this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
        $data['sort_unit'] = $this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . '&sort=unit' . $url, 'SSL');
        $data['sort_value'] = $this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . '&sort=value' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($length_class_total, $page, Config::get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('localization/length_class_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('localization/length_class');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }
        
        if (isset($this->error['unit'])) {
            $data['error_unit'] = $this->error['unit'];
        } else {
            $data['error_unit'] = array();
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/length_class', $url);
        
        if (!isset($this->request->get['length_class_id'])) {
            $data['action'] = $this->url->link('localization/length_class/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/length_class/update', 'token=' . $this->session->data['token'] . '&length_class_id=' . $this->request->get['length_class_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/length_class', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['length_class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $length_class_info = $this->model_localization_length_class->getLengthClass($this->request->get['length_class_id']);
        }
        
        Theme::model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['length_class_description'])) {
            $data['length_class_description'] = $this->request->post['length_class_description'];
        } elseif (isset($this->request->get['length_class_id'])) {
            $data['length_class_description'] = $this->model_localization_length_class->getLengthClassDescriptions($this->request->get['length_class_id']);
        } else {
            $data['length_class_description'] = array();
        }
        
        if (isset($this->request->post['value'])) {
            $data['value'] = $this->request->post['value'];
        } elseif (!empty($length_class_info)) {
            $data['value'] = $length_class_info['value'];
        } else {
            $data['value'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('localization/length_class_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'localization/length_class')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['length_class_description'] as $language_id => $value) {
            if ((Encode::strlen($value['title']) < 3) || (Encode::strlen($value['title']) > 32)) {
                $this->error['title'][$language_id] = $this->language->get('lang_error_title');
            }
            
            if (!$value['unit'] || (Encode::strlen($value['unit']) > 4)) {
                $this->error['unit'][$language_id] = $this->language->get('lang_error_unit');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'localization/length_class')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $length_class_id) {
            if (Config::get('config_length_class_id') == $length_class_id) {
                $this->error['warning'] = $this->language->get('lang_error_default');
            }
            
            $product_total = $this->model_catalog_product->getTotalProductsByLengthClassId($length_class_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
