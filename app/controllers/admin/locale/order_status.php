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

class OrderStatus extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/order_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/order_status');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/order_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/order_status');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleOrderStatus::addOrderStatus(Request::post());
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
            
            Response::redirect(Url::link('locale/order_status', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/order_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/order_status');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleOrderStatus::editOrderStatus(Request::p()->get['order_status_id'], Request::post());
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
            
            Response::redirect(Url::link('locale/order_status', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/order_status');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/order_status');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $order_status_id) {
                LocaleOrderStatus::deleteOrderStatus($order_status_id);
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
            
            Response::redirect(Url::link('locale/order_status', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/order_status');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/order_status', $url);
        
        $data['insert'] = Url::link('locale/order_status/insert', $url, 'SSL');
        $data['delete'] = Url::link('locale/order_status/delete', $url, 'SSL');
        
        $data['order_statuses'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $order_status_total = LocaleOrderStatus::getTotalOrderStatuses();
        
        $results = LocaleOrderStatus::getOrderStatuses($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/order_status/update', 'order_status_id=' . $result['order_status_id'] . $url, 'SSL'));
            
            $data['order_statuses'][] = array('order_status_id' => $result['order_status_id'], 'name' => $result['name'] . (($result['order_status_id'] == Config::get('config_order_status_id')) ? Lang::get('lang_text_default') : null), 'selected' => isset(Request::p()->post['selected']) && in_array($result['order_status_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('locale/order_status', 'sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($order_status_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/order_status', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/order_status_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/order_status');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/order_status', $url);
        
        if (!isset(Request::p()->get['order_status_id'])) {
            $data['action'] = Url::link('locale/order_status/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/order_status/update', 'order_status_id=' . Request::p()->get['order_status_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/order_status', $url, 'SSL');
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['order_status'])) {
            $data['order_status'] = Request::p()->post['order_status'];
        } elseif (isset(Request::p()->get['order_status_id'])) {
            $data['order_status'] = LocaleOrderStatus::getOrderStatusDescriptions(Request::p()->get['order_status_id']);
        } else {
            $data['order_status'] = array();
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/order_status_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/order_status')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['order_status'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/order_status')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('sale/order');
        
        foreach (Request::p()->post['selected'] as $order_status_id) {
            if (Config::get('config_order_status_id') == $order_status_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            if (Config::get('config_download_status_id') == $order_status_id) {
                $this->error['warning'] = Lang::get('lang_error_download');
            }
            
            $store_total = SettingStore::getTotalStoresByOrderStatusId($order_status_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
            
            $order_total = SaleOrder::getTotalOrderHistoriesByOrderStatusId($order_status_id);
            
            if ($order_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_order'), $order_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
