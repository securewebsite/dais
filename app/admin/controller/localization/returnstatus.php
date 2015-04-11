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

namespace Admin\Controller\Localization;
use Dais\Engine\Controller;

class Returnstatus extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/return_status');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnstatus');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/return_status');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnstatus');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_returnstatus->addReturnStatus($this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/return_status');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnstatus');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_returnstatus->editReturnStatus($this->request->get['return_status_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/return_status');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnstatus');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $return_status_id) {
                $this->model_localization_returnstatus->deleteReturnStatus($return_status_id);
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
            
            $this->response->redirect($this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('localization/return_status');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/returnstatus', $url);
        
        $data['insert'] = $this->url->link('localization/returnstatus/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/returnstatus/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['return_statuses'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $return_status_total = $this->model_localization_returnstatus->getTotalReturnStatuses();
        
        $results = $this->model_localization_returnstatus->getReturnStatuses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/returnstatus/update', 'token=' . $this->session->data['token'] . '&return_status_id=' . $result['return_status_id'] . $url, 'SSL'));
            
            $data['return_statuses'][] = array('return_status_id' => $result['return_status_id'], 'name' => $result['name'] . (($result['return_status_id'] == $this->config->get('config_return_status_id')) ? $this->language->get('lang_text_default') : null), 'selected' => isset($this->request->post['selected']) && in_array($result['return_status_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = $this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($return_status_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/return_status_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('localization/return_status');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/returnstatus', $url);
        
        if (!isset($this->request->get['return_status_id'])) {
            $data['action'] = $this->url->link('localization/returnstatus/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/returnstatus/update', 'token=' . $this->session->data['token'] . '&return_status_id=' . $this->request->get['return_status_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['return_status'])) {
            $data['return_status'] = $this->request->post['return_status'];
        } elseif (isset($this->request->get['return_status_id'])) {
            $data['return_status'] = $this->model_localization_returnstatus->getReturnStatusDescriptions($this->request->get['return_status_id']);
        } else {
            $data['return_status'] = array();
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/return_status_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localization/returnstatus')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['return_status'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 3) || ($this->encode->strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'localization/returnstatus')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('sale/returns');
        
        foreach ($this->request->post['selected'] as $return_status_id) {
            if ($this->config->get('config_return_status_id') == $return_status_id) {
                $this->error['warning'] = $this->language->get('lang_error_default');
            }
            
            $return_total = $this->model_sale_returns->getTotalReturnsByReturnStatusId($return_status_id);
            
            if ($return_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_return'), $return_total);
            }
            
            $return_total = $this->model_sale_returns->getTotalReturnHistoriesByReturnStatusId($return_status_id);
            
            if ($return_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_return'), $return_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
