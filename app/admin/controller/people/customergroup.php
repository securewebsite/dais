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

namespace Admin\Controller\People;
use Dais\Engine\Controller;

class Customergroup extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('people/customer_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/customergroup');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('people/customer_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/customergroup');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_customergroup->addCustomerGroup($this->request->post);
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
            
            $this->response->redirect($this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('people/customer_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/customergroup');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_customergroup->editCustomerGroup($this->request->get['customer_group_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('people/customer_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/customergroup');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $customer_group_id) {
                $this->model_people_customergroup->deleteCustomerGroup($customer_group_id);
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
            
            $this->response->redirect($this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('people/customer_group');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'people/customergroup', $url);
        
        $data['insert'] = $this->url->link('people/customergroup/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('people/customergroup/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['customer_groups'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $customer_group_total = $this->model_people_customergroup->getTotalCustomerGroups();
        
        $results = $this->model_people_customergroup->getCustomerGroups($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('people/customergroup/update', 'token=' . $this->session->data['token'] . '&customer_group_id=' . $result['customer_group_id'] . $url, 'SSL'));
            
            $data['customer_groups'][] = array('customer_group_id' => $result['customer_group_id'], 'name' => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_customer_group_id')) ? $this->language->get('lang_text_default') : null), 'sort_order' => $result['sort_order'], 'selected' => isset($this->request->post['selected']) && in_array($result['customer_group_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = $this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . '&sort=cgd.name' . $url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . '&sort=cg.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($customer_group_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('people/customer_group_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('people/customer_group');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'people/customergroup', $url);
        
        if (!isset($this->request->get['customer_group_id'])) {
            $data['action'] = $this->url->link('people/customergroup/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('people/customergroup/update', 'token=' . $this->session->data['token'] . '&customer_group_id=' . $this->request->get['customer_group_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('people/customergroup', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['customer_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $customer_group_info = $this->model_people_customergroup->getCustomerGroup($this->request->get['customer_group_id']);
        }
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['customer_group_description'])) {
            $data['customer_group_description'] = $this->request->post['customer_group_description'];
        } elseif (isset($this->request->get['customer_group_id'])) {
            $data['customer_group_description'] = $this->model_people_customergroup->getCustomerGroupDescriptions($this->request->get['customer_group_id']);
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
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('people/customer_group_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'people/customergroup')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['customer_group_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 3) || ($this->encode->strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'people/customergroup')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('setting/store');
        $this->theme->model('people/customer');
        
        foreach ($this->request->post['selected'] as $customer_group_id) {
            if ($this->config->get('config_customer_group_id') == $customer_group_id) {
                $this->error['warning'] = $this->language->get('lang_error_default');
            }
            
            $store_total = $this->model_setting_store->getTotalStoresByCustomerGroupId($customer_group_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_store'), $store_total);
            }
            
            $customer_total = $this->model_people_customer->getTotalCustomersByCustomerGroupId($customer_group_id);
            
            if ($customer_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_customer'), $customer_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
