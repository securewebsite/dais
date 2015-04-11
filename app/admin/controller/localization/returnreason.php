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

class Returnreason extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('localization/return_reason');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnreason');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('localization/return_reason');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnreason');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_returnreason->addReturnReason($this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/returnreason', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('localization/return_reason');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnreason');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localization_returnreason->editReturnReason($this->request->get['return_reason_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('localization/returnreason', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('localization/return_reason');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('localization/returnreason');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $return_reason_id) {
                $this->model_localization_returnreason->deleteReturnReason($return_reason_id);
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
            
            $this->response->redirect($this->url->link('localization/returnreason', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('localization/return_reason');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/returnreason', $url);
        
        $data['insert'] = $this->url->link('localization/returnreason/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('localization/returnreason/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['return_reasons'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $return_reason_total = $this->model_localization_returnreason->getTotalReturnReasons();
        
        $results = $this->model_localization_returnreason->getReturnReasons($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('localization/returnreason/update', 'token=' . $this->session->data['token'] . '&return_reason_id=' . $result['return_reason_id'] . $url, 'SSL'));
            
            $data['return_reasons'][] = array('return_reason_id' => $result['return_reason_id'], 'name' => $result['name'], 'selected' => isset($this->request->post['selected']) && in_array($result['return_reason_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = $this->url->link('localization/returnreason', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($return_reason_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('localization/returnreason', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/return_reason_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('localization/return_reason');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'localization/returnreason', $url);
        
        if (!isset($this->request->get['return_reason_id'])) {
            $data['action'] = $this->url->link('localization/returnreason/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('localization/returnreason/update', 'token=' . $this->session->data['token'] . '&return_reason_id=' . $this->request->get['return_reason_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('localization/returnreason', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['return_reason'])) {
            $data['return_reason'] = $this->request->post['return_reason'];
        } elseif (isset($this->request->get['return_reason_id'])) {
            $data['return_reason'] = $this->model_localization_returnreason->getReturnReasonDescriptions($this->request->get['return_reason_id']);
        } else {
            $data['return_reason'] = array();
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('localization/return_reason_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localization/returnreason')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['return_reason'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 3) || ($this->encode->strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'localization/returnreason')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('sale/returns');
        
        foreach ($this->request->post['selected'] as $return_reason_id) {
            $return_total = $this->model_sale_returns->getTotalReturnsByReturnReasonId($return_reason_id);
            
            if ($return_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_return'), $return_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
