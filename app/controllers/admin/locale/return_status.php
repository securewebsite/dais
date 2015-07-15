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

namespace App\Controllers\Admin\Locale;

use App\Controllers\Controller;

class ReturnStatus extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/return_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_status');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/return_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_status');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_return_status->addReturnStatus($this->request->post);
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
            
            Response::redirect(Url::link('locale/return_status', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/return_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_status');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_locale_return_status->editReturnStatus($this->request->get['return_status_id'], $this->request->post);
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
            
            Response::redirect(Url::link('locale/return_status', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/return_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_status');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $return_status_id) {
                $this->model_locale_return_status->deleteReturnStatus($return_status_id);
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
            
            Response::redirect(Url::link('locale/return_status', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/return_status');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/return_status', $url);
        
        $data['insert'] = Url::link('locale/return_status/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('locale/return_status/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['return_statuses'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $return_status_total = $this->model_locale_return_status->getTotalReturnStatuses();
        
        $results = $this->model_locale_return_status->getReturnStatuses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/return_status/update', 'token=' . $this->session->data['token'] . '&return_status_id=' . $result['return_status_id'] . $url, 'SSL'));
            
            $data['return_statuses'][] = array('return_status_id' => $result['return_status_id'], 'name' => $result['name'] . (($result['return_status_id'] == Config::get('config_return_status_id')) ? Lang::get('lang_text_default') : null), 'selected' => isset($this->request->post['selected']) && in_array($result['return_status_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('locale/return_status', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($return_status_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/return_status', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('locale/return_status_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/return_status');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/return_status', $url);
        
        if (!isset($this->request->get['return_status_id'])) {
            $data['action'] = Url::link('locale/return_status/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/return_status/update', 'token=' . $this->session->data['token'] . '&return_status_id=' . $this->request->get['return_status_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/return_status', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        Theme::model('locale/language');
        
        $data['languages'] = $this->model_locale_language->getLanguages();
        
        if (isset($this->request->post['return_status'])) {
            $data['return_status'] = $this->request->post['return_status'];
        } elseif (isset($this->request->get['return_status_id'])) {
            $data['return_status'] = $this->model_locale_return_status->getReturnStatusDescriptions($this->request->get['return_status_id']);
        } else {
            $data['return_status'] = array();
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('locale/return_status_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/return_status')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['return_status'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/return_status')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('sale/returns');
        
        foreach ($this->request->post['selected'] as $return_status_id) {
            if (Config::get('config_return_status_id') == $return_status_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $return_total = $this->model_sale_returns->getTotalReturnsByReturnStatusId($return_status_id);
            
            if ($return_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_return'), $return_total);
            }
            
            $return_total = $this->model_sale_returns->getTotalReturnHistoriesByReturnStatusId($return_status_id);
            
            if ($return_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_return'), $return_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
