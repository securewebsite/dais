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

class User extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('people/user');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('people/user');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_user->addUser($this->request->post);
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
            
            $this->response->redirect($this->url->link('people/user', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('people/user');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_user->editUser($this->request->get['user_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('people/user', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('people/user');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $user_id) {
                $this->model_people_user->deleteUser($user_id);
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
            
            $this->response->redirect($this->url->link('people/user', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('people/user');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'user_name';
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
        
        $this->breadcrumb->add('lang_heading_title', 'people/user', $url);
        
        $data['insert'] = $this->url->link('people/user/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('people/user/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['users'] = array();
        
        $filter = array(
            'sort'  => $sort, 
            'order' => $order, 
            'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            'limit' => $this->config->get('config_admin_limit')
        );
        
        $user_total = $this->model_people_user->getTotalUsers();
        
        $results = $this->model_people_user->getUsers($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_edit'), 
                'href' => $this->url->link('people/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $result['user_id'] . $url, 'SSL')
            );
            
            $data['users'][] = array(
                'user_id'    => $result['user_id'], 
                'user_name'  => $result['user_name'], 
                'status'     => ($result['status'] ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled')), 
                'date_added' => date($this->language->get('lang_date_format_short'), strtotime($result['date_added'])), 
                'selected'   => isset($this->request->post['selected']) && in_array($result['user_id'], $this->request->post['selected']), 
                'action'     => $action
            );
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
        
        $data['sort_user_name']  = $this->url->link('people/user', 'token=' . $this->session->data['token'] . '&sort=user_name' . $url, 'SSL');
        $data['sort_status']     = $this->url->link('people/user', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        $data['sort_date_added'] = $this->url->link('people/user', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate(
            $user_total, 
            $page, 
            $this->config->get('config_admin_limit'), 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('people/user', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('people/user_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('people/user');
        
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'people/user', $url);
        
        if (!isset($this->request->get['user_id'])) {
            $data['action'] = $this->url->link('people/user/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('people/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $this->request->get['user_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('people/user', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['user_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $user_info = $this->model_people_user->getUser($this->request->get['user_id']);
        }
        
        if (isset($this->request->post['user_name'])) {
            $data['user_name'] = $this->request->post['user_name'];
        } elseif (!empty($user_info)) {
            $data['user_name'] = $user_info['user_name'];
        } else {
            $data['user_name'] = '';
        }
        
        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
        }
        
        if (isset($this->request->post['confirm'])) {
            $data['confirm'] = $this->request->post['confirm'];
        } else {
            $data['confirm'] = '';
        }
        
        if (isset($this->request->post['firstname'])) {
            $data['firstname'] = $this->request->post['firstname'];
        } elseif (!empty($user_info)) {
            $data['firstname'] = $user_info['firstname'];
        } else {
            $data['firstname'] = '';
        }
        
        if (isset($this->request->post['lastname'])) {
            $data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($user_info)) {
            $data['lastname'] = $user_info['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($user_info)) {
            $data['email'] = $user_info['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset($this->request->post['user_group_id'])) {
            $data['user_group_id'] = $this->request->post['user_group_id'];
        } elseif (!empty($user_info)) {
            $data['user_group_id'] = $user_info['user_group_id'];
        } else {
            $data['user_group_id'] = '';
        }
        
        $this->theme->model('people/user_group');
        
        $data['user_groups'] = $this->model_people_user_group->getUserGroups();
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 0;
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('people/user_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'people/user')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['user_name']) < 3) || ($this->encode->strlen($this->request->post['user_name']) > 20)) {
            $this->error['user_name'] = $this->language->get('lang_error_user_name');
        }
        
        $user_info = $this->model_people_user->getUserByUsername($this->request->post['user_name']);
        
        if (!isset($this->request->get['user_id'])) {
            if ($user_info) {
                $this->error['warning'] = $this->language->get('lang_error_exists');
            }
        } else {
            if ($user_info && ($this->request->get['user_id'] != $user_info['user_id'])) {
                $this->error['warning'] = $this->language->get('lang_error_exists');
            }
        }
        
        if (($this->encode->strlen($this->request->post['firstname']) < 1) || ($this->encode->strlen($this->request->post['firstname']) > 32)) {
            $this->error['firstname'] = $this->language->get('lang_error_firstname');
        }
        
        if (($this->encode->strlen($this->request->post['lastname']) < 1) || ($this->encode->strlen($this->request->post['lastname']) > 32)) {
            $this->error['lastname'] = $this->language->get('lang_error_lastname');
        }

        if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])):
            $this->error['email'] = $this->language->get('lang_error_email');
        endif;
        
        if ($this->request->post['password'] || (!isset($this->request->get['user_id']))) {
            if (($this->encode->strlen($this->request->post['password']) < 4) || ($this->encode->strlen($this->request->post['password']) > 20)) {
                $this->error['password'] = $this->language->get('lang_error_password');
            }
            
            if ($this->request->post['password'] != $this->request->post['confirm']) {
                $this->error['confirm'] = $this->language->get('lang_error_confirm');
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'people/user')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['selected'] as $user_id) {
            if ($this->user->getId() == $user_id) {
                $this->error['warning'] = $this->language->get('lang_error_account');
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
