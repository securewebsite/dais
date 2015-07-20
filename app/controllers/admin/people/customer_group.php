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

namespace App\Controllers\Admin\People;

use App\Controllers\Controller;

class CustomerGroup extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('people/customer_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_group');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('people/customer_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_group');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleCustomerGroup::addCustomerGroup(Request::post());
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
            
            Response::redirect(Url::link('people/customer_group', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/customer_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_group');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleCustomerGroup::editCustomerGroup(Request::p()->get['customer_group_id'], Request::post());
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
            
            Response::redirect(Url::link('people/customer_group', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/customer_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_group');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $customer_group_id) {
                PeopleCustomerGroup::deleteCustomerGroup($customer_group_id);
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
            
            Response::redirect(Url::link('people/customer_group', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/customer_group');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'cg.sort_order';
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
        
        Breadcrumb::add('lang_heading_title', 'people/customer_group', $url);
        
        $data['insert'] = Url::link('people/customer_group/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('people/customer_group/delete', '' . $url, 'SSL');
        
        $data['customer_groups'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $customer_group_total = PeopleCustomerGroup::getTotalCustomerGroups();
        
        $results = PeopleCustomerGroup::getCustomerGroups($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('people/customer_group/update', '' . 'customer_group_id=' . $result['customer_group_id'] . $url, 'SSL'));
            
            $data['customer_groups'][] = array('customer_group_id' => $result['customer_group_id'], 'name' => $result['name'] . (($result['customer_group_id'] == Config::get('config_customer_group_id')) ? Lang::get('lang_text_default') : null), 'sort_order' => $result['sort_order'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['customer_group_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('people/customer_group', '' . 'sort=cgd.name' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('people/customer_group', '' . 'sort=cg.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($customer_group_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('people/customer_group', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/customer_group_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('people/customer_group');
        
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
        
        Breadcrumb::add('lang_heading_title', 'people/customer_group', $url);
        
        if (!isset(Request::p()->get['customer_group_id'])) {
            $data['action'] = Url::link('people/customer_group/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('people/customer_group/update', '' . 'customer_group_id=' . Request::p()->get['customer_group_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('people/customer_group', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['customer_group_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $customer_group_info = PeopleCustomerGroup::getCustomerGroup(Request::p()->get['customer_group_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['customer_group_description'])) {
            $data['customer_group_description'] = Request::p()->post['customer_group_description'];
        } elseif (isset(Request::p()->get['customer_group_id'])) {
            $data['customer_group_description'] = PeopleCustomerGroup::getCustomerGroupDescriptions(Request::p()->get['customer_group_id']);
        } else {
            $data['customer_group_description'] = array();
        }
        
        if (isset(Request::p()->post['approval'])) {
            $data['approval'] = Request::p()->post['approval'];
        } elseif (!empty($customer_group_info)) {
            $data['approval'] = $customer_group_info['approval'];
        } else {
            $data['approval'] = '';
        }
        
        if (isset(Request::p()->post['company_id_display'])) {
            $data['company_id_display'] = Request::p()->post['company_id_display'];
        } elseif (!empty($customer_group_info)) {
            $data['company_id_display'] = $customer_group_info['company_id_display'];
        } else {
            $data['company_id_display'] = '';
        }
        
        if (isset(Request::p()->post['company_id_required'])) {
            $data['company_id_required'] = Request::p()->post['company_id_required'];
        } elseif (!empty($customer_group_info)) {
            $data['company_id_required'] = $customer_group_info['company_id_required'];
        } else {
            $data['company_id_required'] = '';
        }
        
        if (isset(Request::p()->post['tax_id_display'])) {
            $data['tax_id_display'] = Request::p()->post['tax_id_display'];
        } elseif (!empty($customer_group_info)) {
            $data['tax_id_display'] = $customer_group_info['tax_id_display'];
        } else {
            $data['tax_id_display'] = '';
        }
        
        if (isset(Request::p()->post['tax_id_required'])) {
            $data['tax_id_required'] = Request::p()->post['tax_id_required'];
        } elseif (!empty($customer_group_info)) {
            $data['tax_id_required'] = $customer_group_info['tax_id_required'];
        } else {
            $data['tax_id_required'] = '';
        }
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($customer_group_info)) {
            $data['sort_order'] = $customer_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/customer_group_form', $data));
    }
    
    protected function validateForm() {
        if (!\User::hasPermission('modify', 'people/customer_group')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['customer_group_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!\User::hasPermission('modify', 'people/customer_group')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('people/customer');
        
        foreach (Request::p()->post['selected'] as $customer_group_id) {
            if (Config::get('config_customer_group_id') == $customer_group_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = SettingStore::getTotalStoresByCustomerGroupId($customer_group_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $customer_total = PeopleCustomer::getTotalCustomersByCustomerGroupId($customer_group_id);
            
            if ($customer_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_customer'), $customer_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
