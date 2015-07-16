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

class TaxClass extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/tax_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_class');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/tax_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_class');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleTaxClass::addTaxClass($this->request->post);
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
            
            Response::redirect(Url::link('locale/tax_class', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/tax_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_class');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleTaxClass::editTaxClass($this->request->get['tax_class_id'], $this->request->post);
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
            
            Response::redirect(Url::link('locale/tax_class', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/tax_class');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_class');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $tax_class_id) {
                LocaleTaxClass::deleteTaxClass($tax_class_id);
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
            
            Response::redirect(Url::link('locale/tax_class', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/tax_class');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/tax_class', $url);
        
        $data['insert'] = Url::link('locale/tax_class/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('locale/tax_class/delete', '' . $url, 'SSL');
        
        $data['tax_classes'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $tax_class_total = LocaleTaxClass::getTotalTaxClasses();
        
        $results = LocaleTaxClass::getTaxClasses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/tax_class/update', '' . '&tax_class_id=' . $result['tax_class_id'] . $url, 'SSL'));
            
            $data['tax_classes'][] = array('tax_class_id' => $result['tax_class_id'], 'title' => $result['title'], 'selected' => isset($this->request->post['selected']) && in_array($result['tax_class_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_title'] = Url::link('locale/tax_class', '' . '&sort=title' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($tax_class_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/tax_class', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('locale/tax_class_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/tax_class');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = '';
        }
        
        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/tax_class', $url);
        
        if (!isset($this->request->get['tax_class_id'])) {
            $data['action'] = Url::link('locale/tax_class/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/tax_class/update', '' . '&tax_class_id=' . $this->request->get['tax_class_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/tax_class', '' . $url, 'SSL');
        
        if (isset($this->request->get['tax_class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $tax_class_info = LocaleTaxClass::getTaxClass($this->request->get['tax_class_id']);
        }
        
        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($tax_class_info)) {
            $data['title'] = $tax_class_info['title'];
        } else {
            $data['title'] = '';
        }
        
        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } elseif (!empty($tax_class_info)) {
            $data['description'] = $tax_class_info['description'];
        } else {
            $data['description'] = '';
        }
        
        Theme::model('locale/tax_rate');
        
        $data['tax_rates'] = LocaleTaxRate::getTaxRates();
        
        if (isset($this->request->post['tax_rule'])) {
            $data['tax_rules'] = $this->request->post['tax_rule'];
        } elseif (isset($this->request->get['tax_class_id'])) {
            $data['tax_rules'] = LocaleTaxClass::getTaxRules($this->request->get['tax_class_id']);
        } else {
            $data['tax_rules'] = array();
        }
        
        Theme::loadjs('javascript/locale/tax_class_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('locale/tax_class_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/tax_class')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['title']) < 3) || (Encode::strlen($this->request->post['title']) > 32)) {
            $this->error['title'] = Lang::get('lang_error_title');
        }
        
        if ((Encode::strlen($this->request->post['description']) < 3) || (Encode::strlen($this->request->post['description']) > 255)) {
            $this->error['description'] = Lang::get('lang_error_description');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/tax_class')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $tax_class_id) {
            $product_total = CatalogProduct::getTotalProductsByTaxClassId($tax_class_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
