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

class Weightclass extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/weight_class');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/weightclass');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/weight_class');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/weightclass');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_weightclass->addWeightClass($this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/weight_class');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/weightclass');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_weightclass->editWeightClass($this->request->get['weight_class_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/weight_class');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/weightclass');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $weight_class_id) {
                $this->model_localization_weightclass->deleteWeightClass($weight_class_id);
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
            
            $this->response->redirect($this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('localization/weight_class');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/weightclass', $url);
        
        $data['insert'] = $this->url->link('localization/weightclass/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/weightclass/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['weight_classes'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $weight_class_total = $this->model_localization_weightclass->getTotalWeightClasses();
        
        $results = $this->model_localization_weightclass->getWeightClasses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/weightclass/update', 'token=' . $this->session->data['token'] . '&weight_class_id=' . $result['weight_class_id'] . $url, 'SSL'));
            
            $data['weight_classes'][] = array('weight_class_id' => $result['weight_class_id'], 'title' => $result['title'] . (($result['unit'] == $this->config->get('config_weight_class')) ? $this->language->get('lang_text_default') : null), 'unit' => $result['unit'], 'value' => $result['value'], 'selected' => isset($this->request->post['selected']) && in_array($result['weight_class_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_title'] = $this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
        $data['sort_unit'] = $this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . '&sort=unit' . $url, 'SSL');
        $data['sort_value'] = $this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . '&sort=value' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($weight_class_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/weight_class_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('localization/weight_class');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/weightclass', $url);
        
        if (!isset($this->request->get['weight_class_id'])) {
            $data['action'] = $this->url->link('localization/weightclass/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/weightclass/update', 'token=' . $this->session->data['token'] . '&weight_class_id=' . $this->request->get['weight_class_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/weightclass', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['weight_class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $weight_class_info = $this->model_localization_weightclass->getWeightClass($this->request->get['weight_class_id']);
        }
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['weight_class_description'])) {
            $data['weight_class_description'] = $this->request->post['weight_class_description'];
        } elseif (isset($this->request->get['weight_class_id'])) {
            $data['weight_class_description'] = $this->model_localization_weightclass->getWeightClassDescriptions($this->request->get['weight_class_id']);
        } else {
            $data['weight_class_description'] = array();
        }
        
        if (isset($this->request->post['value'])) {
            $data['value'] = $this->request->post['value'];
        } elseif (!empty($weight_class_info)) {
            $data['value'] = $weight_class_info['value'];
        } else {
            $data['value'] = '';
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/weight_class_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localization/weightclass')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['weight_class_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['title']) < 3) || ($this->encode->strlen($value['title']) > 32)) {
                $this->error['title'][$language_id] = $this->language->get('lang_error_title');
            }
            
            if (!$value['unit'] || ($this->encode->strlen($value['unit']) > 4)) {
                $this->error['unit'][$language_id] = $this->language->get('lang_error_unit');
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'localization/weightclass')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('catalog/product');
        
        foreach ($this->request->post['selected'] as $weight_class_id) {
            if ($this->config->get('config_weight_class_id') == $weight_class_id) {
                $this->error['warning'] = $this->language->get('lang_error_default');
            }
            
            $product_total = $this->model_catalog_product->getTotalProductsByWeightClassId($weight_class_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_product'), $product_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
