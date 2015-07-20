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

class User extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('people/user');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('people/user');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleUser::addUser(Request::post());
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
            
            Response::redirect(Url::link('people/user', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/user');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            PeopleUser::editUser(Request::p()->get['user_id'], Request::post());
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
            
            Response::redirect(Url::link('people/user', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/user');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/user');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $user_id) {
                PeopleUser::deleteUser($user_id);
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
            
            Response::redirect(Url::link('people/user', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/user');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'user_name';
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
        
        Breadcrumb::add('lang_heading_title', 'people/user', $url);
        
        $data['insert'] = Url::link('people/user/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('people/user/delete', '' . $url, 'SSL');
        
        $data['users'] = array();
        
        $filter = array(
            'sort'  => $sort, 
            'order' => $order, 
            'start' => ($page - 1) * Config::get('config_admin_limit'), 
            'limit' => Config::get('config_admin_limit')
        );
        
        $user_total = PeopleUser::getTotalUsers();
        
        $results = PeopleUser::getUsers($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('people/user/update', '' . 'user_id=' . $result['user_id'] . $url, 'SSL')
            );
            
            $data['users'][] = array(
                'user_id'    => $result['user_id'], 
                'user_name'  => $result['user_name'], 
                'status'     => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 
                'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                'selected'   => isset(Request::p()->post['selected']) && in_array($result['user_id'], Request::p()->post['selected']), 
                'action'     => $action
            );
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
        
        $data['sort_user_name']  = Url::link('people/user', '' . 'sort=user_name' . $url, 'SSL');
        $data['sort_status']     = Url::link('people/user', '' . 'sort=status' . $url, 'SSL');
        $data['sort_date_added'] = Url::link('people/user', '' . 'sort=date_added' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate(
            $user_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('people/user', '' . $url . '&page={page}', 'SSL')
        );
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/user_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('people/user');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['user_name'])) {
            $data['error_user_name'] = $this->error['user_name'];
        } else {
            $data['error_user_name'] = '';
        }
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['confirm'])) {
            $data['error_confirm'] = $this->error['confirm'];
        } else {
            $data['error_confirm'] = '';
        }
        
        if (isset($this->error['firstname'])) {
            $data['error_firstname'] = $this->error['firstname'];
        } else {
            $data['error_firstname'] = '';
        }
        
        if (isset($this->error['lastname'])) {
            $data['error_lastname'] = $this->error['lastname'];
        } else {
            $data['error_lastname'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'people/user', $url);
        
        if (!isset(Request::p()->get['user_id'])) {
            $data['action'] = Url::link('people/user/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('people/user/update', '' . 'user_id=' . Request::p()->get['user_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('people/user', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['user_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $user_info = PeopleUser::getUser(Request::p()->get['user_id']);
        }
        
        if (isset(Request::p()->post['user_name'])) {
            $data['user_name'] = Request::p()->post['user_name'];
        } elseif (!empty($user_info)) {
            $data['user_name'] = $user_info['user_name'];
        } else {
            $data['user_name'] = '';
        }
        
        if (isset(Request::p()->post['password'])) {
            $data['password'] = Request::p()->post['password'];
        } else {
            $data['password'] = '';
        }
        
        if (isset(Request::p()->post['confirm'])) {
            $data['confirm'] = Request::p()->post['confirm'];
        } else {
            $data['confirm'] = '';
        }
        
        if (isset(Request::p()->post['firstname'])) {
            $data['firstname'] = Request::p()->post['firstname'];
        } elseif (!empty($user_info)) {
            $data['firstname'] = $user_info['firstname'];
        } else {
            $data['firstname'] = '';
        }
        
        if (isset(Request::p()->post['lastname'])) {
            $data['lastname'] = Request::p()->post['lastname'];
        } elseif (!empty($user_info)) {
            $data['lastname'] = $user_info['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset(Request::p()->post['email'])) {
            $data['email'] = Request::p()->post['email'];
        } elseif (!empty($user_info)) {
            $data['email'] = $user_info['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset(Request::p()->post['user_group_id'])) {
            $data['user_group_id'] = Request::p()->post['user_group_id'];
        } elseif (!empty($user_info)) {
            $data['user_group_id'] = $user_info['user_group_id'];
        } else {
            $data['user_group_id'] = '';
        }
        
        Theme::model('people/user_group');
        
        $data['user_groups'] = PeopleUserGroup::getUserGroups();
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 0;
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/user_form', $data));
    }
    
    protected function validateForm() {
        if (!\User::hasPermission('modify', 'people/user')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['user_name']) < 3) || (Encode::strlen(Request::p()->post['user_name']) > 20)) {
            $this->error['user_name'] = Lang::get('lang_error_user_name');
        }
        
        $user_info = PeopleUser::getUserByUsername(Request::p()->post['user_name']);
        
        if (!isset(Request::p()->get['user_id'])) {
            if ($user_info) {
                $this->error['warning'] = Lang::get('lang_error_exists');
            }
        } else {
            if ($user_info && (Request::p()->get['user_id'] != $user_info['user_id'])) {
                $this->error['warning'] = Lang::get('lang_error_exists');
            }
        }
        
        if ((Encode::strlen(Request::p()->post['firstname']) < 1) || (Encode::strlen(Request::p()->post['firstname']) > 32)) {
            $this->error['firstname'] = Lang::get('lang_error_firstname');
        }
        
        if ((Encode::strlen(Request::p()->post['lastname']) < 1) || (Encode::strlen(Request::p()->post['lastname']) > 32)) {
            $this->error['lastname'] = Lang::get('lang_error_lastname');
        }

        if ((Encode::strlen(Request::p()->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', Request::p()->post['email'])):
            $this->error['email'] = Lang::get('lang_error_email');
        endif;
        
        if (Request::p()->post['password'] || (!isset(Request::p()->get['user_id']))) {
            if ((Encode::strlen(Request::p()->post['password']) < 4) || (Encode::strlen(Request::p()->post['password']) > 20)) {
                $this->error['password'] = Lang::get('lang_error_password');
            }
            
            if (Request::p()->post['password'] != Request::p()->post['confirm']) {
                $this->error['confirm'] = Lang::get('lang_error_confirm');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!\User::hasPermission('modify', 'people/user')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['selected'] as $user_id) {
            if (\User::getId() == $user_id) {
                $this->error['warning'] = Lang::get('lang_error_account');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
