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

class LengthClass extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/length_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/length_class');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/length_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/length_class');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleLengthClass::addLengthClass(Request::post());
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
            
            Response::redirect(Url::link('locale/length_class', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/length_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/length_class');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleLengthClass::editLengthClass(Request::p()->get['length_class_id'], Request::post());
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
            
            Response::redirect(Url::link('locale/length_class', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/length_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/length_class');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $length_class_id) {
                LocaleLengthClass::deleteLengthClass($length_class_id);
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
            
            Response::redirect(Url::link('locale/length_class', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/length_class');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'title';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/length_class', $url);
        
        $data['insert'] = Url::link('locale/length_class/insert', $url, 'SSL');
        $data['delete'] = Url::link('locale/length_class/delete', $url, 'SSL');
        
        $data['length_classes'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $length_class_total = LocaleLengthClass::getTotalLengthClasses();
        
        $results = LocaleLengthClass::getLengthClasses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/length_class/update', 'length_class_id=' . $result['length_class_id'] . $url, 'SSL'));
            
            $data['length_classes'][] = array('length_class_id' => $result['length_class_id'], 'title' => $result['title'] . (($result['unit'] == Config::get('config_length_class')) ? Lang::get('lang_text_default') : null), 'unit' => $result['unit'], 'value' => $result['value'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['length_class_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_title'] = Url::link('locale/length_class', 'sort=title' . $url, 'SSL');
        $data['sort_unit'] = Url::link('locale/length_class', 'sort=unit' . $url, 'SSL');
        $data['sort_value'] = Url::link('locale/length_class', 'sort=value' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($length_class_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/length_class', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/length_class_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/length_class');
        
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/length_class', $url);
        
        if (!isset(Request::p()->get['length_class_id'])) {
            $data['action'] = Url::link('locale/length_class/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/length_class/update', 'length_class_id=' . Request::p()->get['length_class_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/length_class', $url, 'SSL');
        
        if (isset(Request::p()->get['length_class_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $length_class_info = LocaleLengthClass::getLengthClass(Request::p()->get['length_class_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['length_class_description'])) {
            $data['length_class_description'] = Request::p()->post['length_class_description'];
        } elseif (isset(Request::p()->get['length_class_id'])) {
            $data['length_class_description'] = LocaleLengthClass::getLengthClassDescriptions(Request::p()->get['length_class_id']);
        } else {
            $data['length_class_description'] = array();
        }
        
        if (isset(Request::p()->post['value'])) {
            $data['value'] = Request::p()->post['value'];
        } elseif (!empty($length_class_info)) {
            $data['value'] = $length_class_info['value'];
        } else {
            $data['value'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/length_class_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/length_class')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['length_class_description'] as $language_id => $value) {
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
        if (!User::hasPermission('modify', 'locale/length_class')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach (Request::p()->post['selected'] as $length_class_id) {
            if (Config::get('config_length_class_id') == $length_class_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $product_total = CatalogProduct::getTotalProductsByLengthClassId($length_class_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
