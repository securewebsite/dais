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

class Userpermission extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('people/user_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user_group');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('people/user_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user_group');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_user_group->addUserGroup($this->request->post);
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
            
            $this->response->redirect($this->url->link('people/userpermission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('people/user_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user_group');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_people_user_group->editUserGroup($this->request->get['user_group_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('people/userpermission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('people/user_group');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('people/user_group');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $user_group_id) {
                $this->model_people_user_group->deleteUserGroup($user_group_id);
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
            
            $this->response->redirect($this->url->link('people/userpermission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('people/user_group');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
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
        
        $this->breadcrumb->add('lang_heading_title', 'people/userpermission', $url);
        
        $data['insert'] = $this->url->link('people/userpermission/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('people/userpermission/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['user_groups'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $user_group_total = $this->model_people_user_group->getTotalUserGroups();
        
        $results = $this->model_people_user_group->getUserGroups($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('people/userpermission/update', 'token=' . $this->session->data['token'] . '&user_group_id=' . $result['user_group_id'] . $url, 'SSL'));
            
            $data['user_groups'][] = array('user_group_id' => $result['user_group_id'], 'name' => $result['name'], 'selected' => isset($this->request->post['selected']) && in_array($result['user_group_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = $this->url->link('people/userpermission', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($user_group_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('people/userpermission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('people/user_group_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('people/user_group');
        
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'people/userpermission', $url);
        
        if (!isset($this->request->get['user_group_id'])) {
            $data['action'] = $this->url->link('people/userpermission/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('people/userpermission/update', 'token=' . $this->session->data['token'] . '&user_group_id=' . $this->request->get['user_group_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('people/userpermission', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['user_group_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
            $user_group_info = $this->model_people_user_group->getUserGroup($this->request->get['user_group_id']);
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($user_group_info)) {
            $data['name'] = $user_group_info['name'];
        } else {
            $data['name'] = '';
        }
        
        $ignore = array('common/dashboard', 'common/login', 'common/logout', 'common/forgotten', 'common/reset', 'error/notfound', 'error/permission', 'common/footer', 'common/header', 'common/breadcrumb');
        
        $plugin_files = $this->plugin->getControllers();
        
        $data['permissions'] = array();
        
        $files = $this->theme->getFiles();
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
        
        if (isset($this->request->post['permission']['access'])) {
            $data['access'] = $this->request->post['permission']['access'];
        } elseif (isset($user_group_info['permission']['access'])) {
            $data['access'] = $user_group_info['permission']['access'];
        } else {
            $data['access'] = array();
        }
        
        if (isset($this->request->post['permission']['modify'])) {
            $data['modify'] = $this->request->post['permission']['modify'];
        } elseif (isset($user_group_info['permission']['modify'])) {
            $data['modify'] = $user_group_info['permission']['modify'];
        } else {
            $data['modify'] = array();
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('people/user_group_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'people/userpermission')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'people/userpermission')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('people/user');
        
        foreach ($this->request->post['selected'] as $user_group_id) {
            $user_total = $this->model_people_user->getTotalUsersByGroupId($user_group_id);
            
            if ($user_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_user'), $user_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
