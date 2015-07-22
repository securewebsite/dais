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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleCustomerBanIp::addCustomerBanIp(Request::post());
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
            
            Response::redirect(Url::link('people/customer_ban_ip', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/customer_ban_ip');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_ban_ip');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleCustomerBanIp::editCustomerBanIp(Request::p()->get['customer_ban_ip_id'], Request::post());
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
            
            Response::redirect(Url::link('people/customer_ban_ip', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/customer_ban_ip');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer_ban_ip');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $customer_ban_ip_id) {
                PeopleCustomerBanIp::deleteCustomerBanIp($customer_ban_ip_id);
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
            
            Response::redirect(Url::link('people/customer_ban_ip', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/customer_ban_ip');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'ip';
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
        
        Breadcrumb::add('lang_heading_title', 'people/customer_ban_ip', $url);
        
        $data['insert'] = Url::link('people/customer_ban_ip/insert', $url, 'SSL');
        $data['delete'] = Url::link('people/customer_ban_ip/delete', $url, 'SSL');
        
        $data['customer_ban_ips'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $customer_ban_ip_total = PeopleCustomerBanIp::getTotalCustomerBanIps($filter);
        
        $results = PeopleCustomerBanIp::getCustomerBanIps($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('people/customer_ban_ip/update', 'customer_ban_ip_id=' . $result['customer_ban_ip_id'] . $url, 'SSL'));
            
            $data['customer_ban_ips'][] = array('customer_ban_ip_id' => $result['customer_ban_ip_id'], 'ip' => $result['ip'], 'total' => $result['total'], 'customer' => Url::link('people/customer', 'filter_ip=' . $result['ip'], 'SSL'), 'selected' => isset(Request::p()->post['selected']) && in_array($result['customer_ban_ip_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_ip'] = Url::link('people/customer_ban_ip', 'sort=ip' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($customer_ban_ip_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('people/customer_ban_ip', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/customer_ban_ip_list', $data));
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'people/customer_ban_ip', $url);
        
        if (!isset(Request::p()->get['customer_ban_ip_id'])) {
            $data['action'] = Url::link('people/customer_ban_ip/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('people/customer_ban_ip/update', 'customer_ban_ip_id=' . Request::p()->get['customer_ban_ip_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('people/customer_ban_ip', $url, 'SSL');
        
        if (isset(Request::p()->get['customer_ban_ip_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $customer_ban_ip_info = PeopleCustomerBanIp::getCustomerBanIp(Request::p()->get['customer_ban_ip_id']);
        }
        
        if (isset(Request::p()->post['ip'])) {
            $data['ip'] = Request::p()->post['ip'];
        } elseif (!empty($customer_ban_ip_info)) {
            $data['ip'] = $customer_ban_ip_info['ip'];
        } else {
            $data['ip'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/customer_ban_ip_form', $data));
    }
    
    protected function validateForm() {
        if (!\User::hasPermission('modify', 'people/customer_ban_ip')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['ip']) < 1) || (Encode::strlen(Request::p()->post['ip']) > 40)) {
            $this->error['ip'] = Lang::get('lang_error_ip');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!\User::hasPermission('modify', 'people/customer_ban_ip')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
