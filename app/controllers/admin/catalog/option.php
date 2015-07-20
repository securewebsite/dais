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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogOption::addOption(Request::post());
            
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
            
            Response::redirect(Url::link('catalog/option', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/option');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/option');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogOption::editOption(Request::p()->get['option_id'], Request::post());
            
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
            
            Response::redirect(Url::link('catalog/option', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/option');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/option');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $option_id) {
                CatalogOption::deleteOption($option_id);
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
            
            Response::redirect(Url::link('catalog/option', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/option');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'od.name';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/option', $url);
        
        $data['insert'] = Url::link('catalog/option/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('catalog/option/delete', '' . $url, 'SSL');
        
        $data['options'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $option_total = CatalogOption::getTotalOptions();
        
        $results = CatalogOption::getOptions($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('catalog/option/update', '' . 'option_id=' . $result['option_id'] . $url, 'SSL'));
            
            $data['options'][] = array('option_id' => $result['option_id'], 'name' => $result['name'], 'sort_order' => $result['sort_order'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['option_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('catalog/option', '' . 'sort=od.name' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('catalog/option', '' . 'sort=o.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($option_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/option', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/option_list', $data));
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'catalog/option', $url);
        
        if (!isset(Request::p()->get['option_id'])) {
            $data['action'] = Url::link('catalog/option/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/option/update', '' . 'option_id=' . Request::p()->get['option_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/option', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['option_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $option_info = CatalogOption::getOption(Request::p()->get['option_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['option_description'])) {
            $data['option_description'] = Request::p()->post['option_description'];
        } elseif (isset(Request::p()->get['option_id'])) {
            $data['option_description'] = CatalogOption::getOptionDescriptions(Request::p()->get['option_id']);
        } else {
            $data['option_description'] = array();
        }
        
        if (isset(Request::p()->post['type'])) {
            $data['type'] = Request::p()->post['type'];
        } elseif (!empty($option_info)) {
            $data['type'] = $option_info['type'];
        } else {
            $data['type'] = '';
        }
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($option_info)) {
            $data['sort_order'] = $option_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        if (isset(Request::p()->post['option_value'])) {
            $option_values = Request::p()->post['option_value'];
        } elseif (isset(Request::p()->get['option_id'])) {
            $option_values = CatalogOption::getOptionValueDescriptions(Request::p()->get['option_id']);
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
            
            $data['option_values'][] = array('option_value_id' => $option_value['option_value_id'], 'option_value_description' => $option_value['option_value_description'], 'image' => $image, 'thumb' => ToolImage::resize($image, 100, 100), 'sort_order' => $option_value['sort_order']);
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 100, 100);
        
        Theme::loadjs('javascript/catalog/option_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/option_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/option')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['option_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 1) || (Encode::strlen($value['name']) > 128)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if ((Request::p()->post['type'] == 'select' || Request::p()->post['type'] == 'radio' || Request::p()->post['type'] == 'checkbox') && !isset(Request::p()->post['option_value'])) {
            $this->error['warning'] = Lang::get('lang_error_type');
        }
        
        if (isset(Request::p()->post['option_value'])) {
            foreach (Request::p()->post['option_value'] as $option_value_id => $option_value) {
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
        
        foreach (Request::p()->post['selected'] as $option_id) {
            $product_total = CatalogProduct::getTotalProductsByOptionId($option_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset(Request::p()->get['filter_name'])) {
            Lang::load('catalog/option');
            
            Theme::model('catalog/option');
            
            Theme::model('tool/image');
            
            $filter = array('filter_name' => Request::p()->get['filter_name'], 'start' => 0, 'limit' => 20);
            
            $options = CatalogOption::getOptions($filter);
            
            foreach ($options as $option) {
                $option_value_data = array();
                
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $option_values = CatalogOption::getOptionValues($option['option_id']);
                    
                    foreach ($option_values as $option_value) {
                        if ($option_value['image'] && file_exists(Config::get('path.image') . $option_value['image'])) {
                            $image = ToolImage::resize($option_value['image'], 50, 50);
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
