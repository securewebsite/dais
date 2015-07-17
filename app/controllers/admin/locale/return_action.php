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

class ReturnAction extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/return_action');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_action');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/return_action');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_action');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleReturnAction::addReturnAction(Request::post());
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
            
            Response::redirect(Url::link('locale/return_action', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/return_action');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_action');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleReturnAction::editReturnAction(Request::p()->get['return_action_id'], Request::post());
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
            
            Response::redirect(Url::link('locale/return_action', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/return_action');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/return_action');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $return_action_id) {
                LocaleReturnAction::deleteReturnAction($return_action_id);
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
            
            Response::redirect(Url::link('locale/return_action', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/return_action');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'name';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'ASC';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/return_action', $url);
        
        $data['insert'] = Url::link('locale/return_action/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('locale/return_action/delete', '' . $url, 'SSL');
        
        $data['return_actions'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $return_action_total = LocaleReturnAction::getTotalReturnActions();
        
        $results = LocaleReturnAction::getReturnActions($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/return_action/update', '' . 'return_action_id=' . $result['return_action_id'] . $url, 'SSL'));
            
            $data['return_actions'][] = array('return_action_id' => $result['return_action_id'], 'name' => $result['name'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['return_action_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_name'] = Url::link('locale/return_action', '' . 'sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($return_action_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/return_action', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('locale/return_action_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/return_action');
        
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/return_action', $url);
        
        if (!isset(Request::p()->get['return_action_id'])) {
            $data['action'] = Url::link('locale/return_action/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/return_action/update', '' . 'return_action_id=' . Request::p()->get['return_action_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/return_action', '' . $url, 'SSL');
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['return_action'])) {
            $data['return_action'] = Request::p()->post['return_action'];
        } elseif (isset(Request::p()->get['return_action_id'])) {
            $data['return_action'] = LocaleReturnAction::getReturnActionDescriptions(Request::p()->get['return_action_id']);
        } else {
            $data['return_action'] = array();
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('locale/return_action_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/return_action')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['return_action'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/return_action')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('sale/returns');
        
        foreach (Request::p()->post['selected'] as $return_action_id) {
            $return_total = SaleReturns::getTotalReturnsByReturnActionId($return_action_id);
            
            if ($return_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_return'), $return_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
