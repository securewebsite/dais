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

class CustomerBanIp extends Controller {
    private $error = array();
    
    public function index() {
        Lang::load('people/customer_ban_ip');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_ban_ip');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('people/customer_ban_ip');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_ban_ip');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_customer_ban_ip->addCustomerBanIp($this->request->post);
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
            
            Response::redirect(Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/customer_ban_ip');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_ban_ip');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_customer_ban_ip->editCustomerBanIp($this->request->get['customer_ban_ip_id'], $this->request->post);
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
            
            Response::redirect(Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/customer_ban_ip');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_ban_ip');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $customer_ban_ip_id) {
                $this->model_people_customer_ban_ip->deleteCustomerBanIp($customer_ban_ip_id);
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
            
            Response::redirect(Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/customer_ban_ip');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'ip';
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
        
        Breadcrumb::add('lang_heading_title', 'people/customer_ban_ip', $url);
        
        $data['insert'] = Url::link('people/customer_ban_ip/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('people/customer_ban_ip/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['customer_ban_ips'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $customer_ban_ip_total = $this->model_people_customer_ban_ip->getTotalCustomerBanIps($filter);
        
        $results = $this->model_people_customer_ban_ip->getCustomerBanIps($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('people/customer_ban_ip/update', 'token=' . $this->session->data['token'] . '&customer_ban_ip_id=' . $result['customer_ban_ip_id'] . $url, 'SSL'));
            
            $data['customer_ban_ips'][] = array('customer_ban_ip_id' => $result['customer_ban_ip_id'], 'ip' => $result['ip'], 'total' => $result['total'], 'customer' => Url::link('people/customer', 'token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip'], 'SSL'), 'selected' => isset($this->request->post['selected']) && in_array($result['customer_ban_ip_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_ip'] = Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'] . '&sort=ip' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($customer_ban_ip_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('people/customer_ban_ip_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('people/customer_ban_ip');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['ip'])) {
            $data['error_ip'] = $this->error['ip'];
        } else {
            $data['error_ip'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'people/customer_ban_ip', $url);
        
        if (!isset($this->request->get['customer_ban_ip_id'])) {
            $data['action'] = Url::link('people/customer_ban_ip/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('people/customer_ban_ip/update', 'token=' . $this->session->data['token'] . '&customer_ban_ip_id=' . $this->request->get['customer_ban_ip_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['customer_ban_ip_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $customer_ban_ip_info = $this->model_people_customer_ban_ip->getCustomerBanIp($this->request->get['customer_ban_ip_id']);
        }
        
        if (isset($this->request->post['ip'])) {
            $data['ip'] = $this->request->post['ip'];
        } elseif (!empty($customer_ban_ip_info)) {
            $data['ip'] = $customer_ban_ip_info['ip'];
        } else {
            $data['ip'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('people/customer_ban_ip_form', $data));
    }
    
    protected function validateForm() {
        if (!\User::hasPermission('modify', 'people/customerbanip')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['ip']) < 1) || (Encode::strlen($this->request->post['ip']) > 40)) {
            $this->error['ip'] = Lang::get('lang_error_ip');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!\User::hasPermission('modify', 'people/customerbanip')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
