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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_customer_group->addCustomerGroup($this->request->post);
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
            
            Response::redirect(Url::link('people/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/customer_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_group');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_customer_group->editCustomerGroup($this->request->get['customer_group_id'], $this->request->post);
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
            
            Response::redirect(Url::link('people/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/customer_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_group');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $customer_group_id) {
                $this->model_people_customer_group->deleteCustomerGroup($customer_group_id);
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
            
            Response::redirect(Url::link('people/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/customer_group');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'cg.sort_order';
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
        
        Breadcrumb::add('lang_heading_title', 'people/customer_group', $url);
        
        $data['insert'] = Url::link('people/customer_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('people/customer_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['customer_groups'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $customer_group_total = $this->model_people_customer_group->getTotalCustomerGroups();
        
        $results = $this->model_people_customer_group->getCustomerGroups($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('people/customer_group/update', 'token=' . $this->session->data['token'] . '&customer_group_id=' . $result['customer_group_id'] . $url, 'SSL'));
            
            $data['customer_groups'][] = array('customer_group_id' => $result['customer_group_id'], 'name' => $result['name'] . (($result['customer_group_id'] == Config::get('config_customer_group_id')) ? Lang::get('lang_text_default') : null), 'sort_order' => $result['sort_order'], 'selected' => isset($this->request->post['selected']) && in_array($result['customer_group_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('people/customer_group', 'token=' . $this->session->data['token'] . '&sort=cgd.name' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('people/customer_group', 'token=' . $this->session->data['token'] . '&sort=cg.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($customer_group_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('people/customer_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('people/customer_group_list', $data));
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'people/customer_group', $url);
        
        if (!isset($this->request->get['customer_group_id'])) {
            $data['action'] = Url::link('people/customer_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('people/customer_group/update', 'token=' . $this->session->data['token'] . '&customer_group_id=' . $this->request->get['customer_group_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('people/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['customer_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $customer_group_info = $this->model_people_customer_group->getCustomerGroup($this->request->get['customer_group_id']);
        }
        
        Theme::model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['customer_group_description'])) {
            $data['customer_group_description'] = $this->request->post['customer_group_description'];
        } elseif (isset($this->request->get['customer_group_id'])) {
            $data['customer_group_description'] = $this->model_people_customer_group->getCustomerGroupDescriptions($this->request->get['customer_group_id']);
        } else {
            $data['customer_group_description'] = array();
        }
        
        if (isset($this->request->post['approval'])) {
            $data['approval'] = $this->request->post['approval'];
        } elseif (!empty($customer_group_info)) {
            $data['approval'] = $customer_group_info['approval'];
        } else {
            $data['approval'] = '';
        }
        
        if (isset($this->request->post['company_id_display'])) {
            $data['company_id_display'] = $this->request->post['company_id_display'];
        } elseif (!empty($customer_group_info)) {
            $data['company_id_display'] = $customer_group_info['company_id_display'];
        } else {
            $data['company_id_display'] = '';
        }
        
        if (isset($this->request->post['company_id_required'])) {
            $data['company_id_required'] = $this->request->post['company_id_required'];
        } elseif (!empty($customer_group_info)) {
            $data['company_id_required'] = $customer_group_info['company_id_required'];
        } else {
            $data['company_id_required'] = '';
        }
        
        if (isset($this->request->post['tax_id_display'])) {
            $data['tax_id_display'] = $this->request->post['tax_id_display'];
        } elseif (!empty($customer_group_info)) {
            $data['tax_id_display'] = $customer_group_info['tax_id_display'];
        } else {
            $data['tax_id_display'] = '';
        }
        
        if (isset($this->request->post['tax_id_required'])) {
            $data['tax_id_required'] = $this->request->post['tax_id_required'];
        } elseif (!empty($customer_group_info)) {
            $data['tax_id_required'] = $customer_group_info['tax_id_required'];
        } else {
            $data['tax_id_required'] = '';
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($customer_group_info)) {
            $data['sort_order'] = $customer_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('people/customer_group_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'people/customer_group')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['customer_group_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'people/customer_group')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('people/customer');
        
        foreach ($this->request->post['selected'] as $customer_group_id) {
            if (Config::get('config_customer_group_id') == $customer_group_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByCustomerGroupId($customer_group_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $customer_total = $this->model_people_customer->getTotalCustomersByCustomerGroupId($customer_group_id);
            
            if ($customer_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_customer'), $customer_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
