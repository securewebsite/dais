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

class UserPermission extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('people/user_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user_group');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('people/user_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user_group');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleUserGroup::addUserGroup(Request::post());
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
            
            Response::redirect(Url::link('people/user_permission', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/user_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user_group');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleUserGroup::editUserGroup(Request::p()->get['user_group_id'], Request::post());
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
            
            Response::redirect(Url::link('people/user_permission', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/user_group');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user_group');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $user_group_id) {
                PeopleUserGroup::deleteUserGroup($user_group_id);
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
            
            Response::redirect(Url::link('people/user_permission', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/user_group');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'name';
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
        
        Breadcrumb::add('lang_heading_title', 'people/user_permission', $url);
        
        $data['insert'] = Url::link('people/user_permission/insert', $url, 'SSL');
        $data['delete'] = Url::link('people/user_permission/delete', $url, 'SSL');
        
        $data['user_groups'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $user_group_total = PeopleUserGroup::getTotalUserGroups();
        
        $results = PeopleUserGroup::getUserGroups($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('people/user_permission/update', 'user_group_id=' . $result['user_group_id'] . $url, 'SSL'));
            
            $data['user_groups'][] = array('user_group_id' => $result['user_group_id'], 'name' => $result['name'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['user_group_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('people/user_permission', 'sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($user_group_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('people/user_permission', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/user_group_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('people/user_group');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'people/user_permission', $url);
        
        if (!isset(Request::p()->get['user_group_id'])) {
            $data['action'] = Url::link('people/user_permission/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('people/user_permission/update', 'user_group_id=' . Request::p()->get['user_group_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('people/user_permission', $url, 'SSL');
        
        if (isset(Request::p()->get['user_group_id']) && Request::p()->server['REQUEST_METHOD'] != 'POST') {
            $user_group_info = PeopleUserGroup::getUserGroup(Request::p()->get['user_group_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($user_group_info)) {
            $data['name'] = $user_group_info['name'];
        } else {
            $data['name'] = '';
        }
        
        $ignore = array(
            'common/dashboard', 
            'common/login', 
            'common/logout', 
            'common/forgotten', 
            'common/reset', 
            'error/not_found', 
            'error/permission',
            'common/footer', 
            'common/header', 
            'common/bread_crumb'
        );
        
        $plugin_files = $this->plugin->getControllers();
        
        $data['permissions'] = array();
        
        $files = Theme::getFiles();
        $files = array_merge($files, $this->plugin->getPlugins());
        
        foreach ($files as $file) {
            $filter = explode('/', dirname($file));
            
            $permission = strtolower(end($filter)) . '/' . strtolower(basename($file, '.php'));
            
            if (!in_array($permission, $ignore)) {
                $data['permissions'][] = $permission;
            }
        }
        
        foreach ($plugin_files as $plugin):
            if (!in_array($plugin, $ignore)):
                $data['permissions'][] = $plugin;
            endif;
        endforeach;
        
        if (isset(Request::p()->post['permission']['access'])) {
            $data['access'] = Request::p()->post['permission']['access'];
        } elseif (isset($user_group_info['permission']['access'])) {
            $data['access'] = $user_group_info['permission']['access'];
        } else {
            $data['access'] = array();
        }
        
        if (isset(Request::p()->post['permission']['modify'])) {
            $data['modify'] = Request::p()->post['permission']['modify'];
        } elseif (isset($user_group_info['permission']['modify'])) {
            $data['modify'] = $user_group_info['permission']['modify'];
        } else {
            $data['modify'] = array();
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/user_group_form', $data));
    }
    
    protected function validateForm() {
        if (!\User::hasPermission('modify', 'people/user_permission')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 64)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!\User::hasPermission('modify', 'people/user_permission')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('people/user');
        
        foreach (Request::p()->post['selected'] as $user_group_id) {
            $user_total = PeopleUser::getTotalUsersByGroupId($user_group_id);
            
            if ($user_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_user'), $user_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
