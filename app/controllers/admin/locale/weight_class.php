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

namespace App\Controllers\Admin\Locale;

use App\Controllers\Controller;

class WeightClass extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/weight_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/weight_class');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/weight_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/weight_class');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_weight_class->addWeightClass($this->request->post);
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
            
            Response::redirect(Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/weight_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/weight_class');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_weight_class->editWeightClass($this->request->get['weight_class_id'], $this->request->post);
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
            
            Response::redirect(Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/weight_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/weight_class');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $weight_class_id) {
                $this->model_locale_weight_class->deleteWeightClass($weight_class_id);
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
            
            Response::redirect(Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/weight_class');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/weight_class', $url);
        
        $data['insert'] = Url::link('locale/weight_class/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('locale/weight_class/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['weight_classes'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $weight_class_total = $this->model_locale_weight_class->getTotalWeightClasses();
        
        $results = $this->model_locale_weight_class->getWeightClasses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/weight_class/update', 'token=' . $this->session->data['token'] . '&weight_class_id=' . $result['weight_class_id'] . $url, 'SSL'));
            
            $data['weight_classes'][] = array('weight_class_id' => $result['weight_class_id'], 'title' => $result['title'] . (($result['unit'] == Config::get('config_weight_class')) ? Lang::get('lang_text_default') : null), 'unit' => $result['unit'], 'value' => $result['value'], 'selected' => isset($this->request->post['selected']) && in_array($result['weight_class_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_title'] = Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
        $data['sort_unit'] = Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . '&sort=unit' . $url, 'SSL');
        $data['sort_value'] = Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . '&sort=value' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($weight_class_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('locale/weight_class_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/weight_class');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/weight_class', $url);
        
        if (!isset($this->request->get['weight_class_id'])) {
            $data['action'] = Url::link('locale/weight_class/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/weight_class/update', 'token=' . $this->session->data['token'] . '&weight_class_id=' . $this->request->get['weight_class_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/weight_class', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['weight_class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $weight_class_info = $this->model_locale_weight_class->getWeightClass($this->request->get['weight_class_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = $this->model_locale_language->getLanguages();
        
        if (isset($this->request->post['weight_class_description'])) {
            $data['weight_class_description'] = $this->request->post['weight_class_description'];
        } elseif (isset($this->request->get['weight_class_id'])) {
            $data['weight_class_description'] = $this->model_locale_weight_class->getWeightClassDescriptions($this->request->get['weight_class_id']);
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
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('locale/weight_class_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/weight_class')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['weight_class_description'] as $language_id => $value) {
            if ((Encode::strlen($value['title']) < 3) || (Encode::strlen($value['title']) > 32)) {
                $this->error['title'][$language_id] = Lang::get('lang_error_title');
            }
            
            if (!$value['unit'] || (Encode::strlen($value['unit']) > 4)) {
                $this->error['unit'][$language_id] = Lang::get('lang_error_unit');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/weight_class')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $weight_class_id) {
            if (Config::get('config_weight_class_id') == $weight_class_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $product_total = $this->model_catalog_product->getTotalProductsByWeightClassId($weight_class_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
