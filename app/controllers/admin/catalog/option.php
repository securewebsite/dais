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

class Option extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('catalog/option');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/option');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('catalog/option');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/option');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_option->addOption($this->request->post);
            
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
            
            Response::redirect(Url::link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/option');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/option');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_option->editOption($this->request->get['option_id'], $this->request->post);
            
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
            
            Response::redirect(Url::link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/option');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/option');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $option_id) {
                $this->model_catalog_option->deleteOption($option_id);
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
            
            Response::redirect(Url::link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/option');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'od.name';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/option', $url);
        
        $data['insert'] = Url::link('catalog/option/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('catalog/option/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['options'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $option_total = $this->model_catalog_option->getTotalOptions();
        
        $results = $this->model_catalog_option->getOptions($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('catalog/option/update', 'token=' . $this->session->data['token'] . '&option_id=' . $result['option_id'] . $url, 'SSL'));
            
            $data['options'][] = array('option_id' => $result['option_id'], 'name' => $result['name'], 'sort_order' => $result['sort_order'], 'selected' => isset($this->request->post['selected']) && in_array($result['option_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('catalog/option', 'token=' . $this->session->data['token'] . '&sort=od.name' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('catalog/option', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($option_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/option', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('catalog/option_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/option');
        
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
        
        if (isset($this->error['option_value'])) {
            $data['error_option_value'] = $this->error['option_value'];
        } else {
            $data['error_option_value'] = array();
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/option', $url);
        
        if (!isset($this->request->get['option_id'])) {
            $data['action'] = Url::link('catalog/option/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/option/update', 'token=' . $this->session->data['token'] . '&option_id=' . $this->request->get['option_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['option_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $option_info = $this->model_catalog_option->getOption($this->request->get['option_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        Theme::model('locale/language');
        
        $data['languages'] = $this->model_locale_language->getLanguages();
        
        if (isset($this->request->post['option_description'])) {
            $data['option_description'] = $this->request->post['option_description'];
        } elseif (isset($this->request->get['option_id'])) {
            $data['option_description'] = $this->model_catalog_option->getOptionDescriptions($this->request->get['option_id']);
        } else {
            $data['option_description'] = array();
        }
        
        if (isset($this->request->post['type'])) {
            $data['type'] = $this->request->post['type'];
        } elseif (!empty($option_info)) {
            $data['type'] = $option_info['type'];
        } else {
            $data['type'] = '';
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($option_info)) {
            $data['sort_order'] = $option_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        if (isset($this->request->post['option_value'])) {
            $option_values = $this->request->post['option_value'];
        } elseif (isset($this->request->get['option_id'])) {
            $option_values = $this->model_catalog_option->getOptionValueDescriptions($this->request->get['option_id']);
        } else {
            $option_values = array();
        }
        
        Theme::model('tool/image');
        
        $data['option_values'] = array();
        
        foreach ($option_values as $option_value) {
            if ($option_value['image'] && file_exists(Config::get('path.image') . $option_value['image'])) {
                $image = $option_value['image'];
            } else {
                $image = 'placeholder.png';
            }
            
            $data['option_values'][] = array('option_value_id' => $option_value['option_value_id'], 'option_value_description' => $option_value['option_value_description'], 'image' => $image, 'thumb' => $this->model_tool_image->resize($image, 100, 100), 'sort_order' => $option_value['sort_order']);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        Theme::loadjs('javascript/catalog/option_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('catalog/option_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/option')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['option_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 1) || (Encode::strlen($value['name']) > 128)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['option_value'])) {
            $this->error['warning'] = Lang::get('lang_error_type');
        }
        
        if (isset($this->request->post['option_value'])) {
            foreach ($this->request->post['option_value'] as $option_value_id => $option_value) {
                foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
                    if ((Encode::strlen($option_value_description['name']) < 1) || (Encode::strlen($option_value_description['name']) > 128)) {
                        $this->error['option_value'][$option_value_id][$language_id] = Lang::get('lang_error_option_value');
                    }
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'catalog/option')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $option_id) {
            $product_total = $this->model_catalog_product->getTotalProductsByOptionId($option_id);
            
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
            Lang::load('catalog/option');
            
            Theme::model('catalog/option');
            
            Theme::model('tool/image');
            
            $filter = array('filter_name' => $this->request->get['filter_name'], 'start' => 0, 'limit' => 20);
            
            $options = $this->model_catalog_option->getOptions($filter);
            
            foreach ($options as $option) {
                $option_value_data = array();
                
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $option_values = $this->model_catalog_option->getOptionValues($option['option_id']);
                    
                    foreach ($option_values as $option_value) {
                        if ($option_value['image'] && file_exists(Config::get('path.image') . $option_value['image'])) {
                            $image = $this->model_tool_image->resize($option_value['image'], 50, 50);
                        } else {
                            $image = '';
                        }
                        
                        $option_value_data[] = array('option_value_id' => $option_value['option_value_id'], 'name' => html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8'), 'image' => $image);
                    }
                    
                    $sort_order = array();
                    
                    foreach ($option_value_data as $key => $value) {
                        $sort_order[$key] = $value['name'];
                    }
                    
                    array_multisort($sort_order, SORT_ASC, $option_value_data);
                }
                
                $type = '';
                
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $type = Lang::get('lang_text_choose');
                }
                
                if ($option['type'] == 'text' || $option['type'] == 'textarea') {
                    $type = Lang::get('lang_text_input');
                }
                
                if ($option['type'] == 'file') {
                    $type = Lang::get('lang_text_file');
                }
                
                if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                    $type = Lang::get('lang_text_date');
                }
                
                $json[] = array('option_id' => $option['option_id'], 'name' => strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8')), 'category' => $type, 'type' => $option['type'], 'option_value' => $option_value_data);
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
