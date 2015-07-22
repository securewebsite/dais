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

class Currency extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/currency');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/currency');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/currency');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/currency');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleCurrency::addCurrency(Request::post());
            
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
            
            Response::redirect(Url::link('locale/currency', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/currency');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/currency');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleCurrency::editCurrency(Request::p()->get['currency_id'], Request::post());
            
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
            
            Response::redirect(Url::link('locale/currency', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/currency');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('locale/currency');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $currency_id) {
                LocaleCurrency::deleteCurrency($currency_id);
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
            
            Response::redirect(Url::link('locale/currency', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/currency');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'title';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/currency', $url);
        
        $data['insert'] = Url::link('locale/currency/insert', $url, 'SSL');
        $data['delete'] = Url::link('locale/currency/delete', $url, 'SSL');
        
        $data['currencies'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $currency_total = LocaleCurrency::getTotalCurrencies();
        
        $results = LocaleCurrency::getCurrencies($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/currency/update', 'currency_id=' . $result['currency_id'] . $url, 'SSL'));
            
            $data['currencies'][] = array('currency_id' => $result['currency_id'], 'title' => $result['title'] . (($result['code'] == Config::get('config_currency')) ? Lang::get('lang_text_default') : null), 'code' => $result['code'], 'value' => $result['value'], 'date_modified' => date(Lang::get('lang_date_format_short'), strtotime($result['date_modified'])), 'selected' => isset(Request::p()->post['selected']) && in_array($result['currency_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_title'] = Url::link('locale/currency', 'sort=title' . $url, 'SSL');
        $data['sort_code'] = Url::link('locale/currency', 'sort=code' . $url, 'SSL');
        $data['sort_value'] = Url::link('locale/currency', 'sort=value' . $url, 'SSL');
        $data['sort_date_modified'] = Url::link('locale/currency', 'sort=date_modified' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($currency_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/currency', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/currency_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/currency');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = '';
        }
        
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/currency', $url);
        
        if (!isset(Request::p()->get['currency_id'])) {
            $data['action'] = Url::link('locale/currency/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/currency/update', 'currency_id=' . Request::p()->get['currency_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/currency', $url, 'SSL');
        
        if (isset(Request::p()->get['currency_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $currency_info = LocaleCurrency::getCurrency(Request::p()->get['currency_id']);
        }
        
        if (isset(Request::p()->post['title'])) {
            $data['title'] = Request::p()->post['title'];
        } elseif (!empty($currency_info)) {
            $data['title'] = $currency_info['title'];
        } else {
            $data['title'] = '';
        }
        
        if (isset(Request::p()->post['code'])) {
            $data['code'] = Request::p()->post['code'];
        } elseif (!empty($currency_info)) {
            $data['code'] = $currency_info['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset(Request::p()->post['symbol_left'])) {
            $data['symbol_left'] = Request::p()->post['symbol_left'];
        } elseif (!empty($currency_info)) {
            $data['symbol_left'] = $currency_info['symbol_left'];
        } else {
            $data['symbol_left'] = '';
        }
        
        if (isset(Request::p()->post['symbol_right'])) {
            $data['symbol_right'] = Request::p()->post['symbol_right'];
        } elseif (!empty($currency_info)) {
            $data['symbol_right'] = $currency_info['symbol_right'];
        } else {
            $data['symbol_right'] = '';
        }
        
        if (isset(Request::p()->post['decimal_place'])) {
            $data['decimal_place'] = Request::p()->post['decimal_place'];
        } elseif (!empty($currency_info)) {
            $data['decimal_place'] = $currency_info['decimal_place'];
        } else {
            $data['decimal_place'] = '';
        }
        
        if (isset(Request::p()->post['value'])) {
            $data['value'] = Request::p()->post['value'];
        } elseif (!empty($currency_info)) {
            $data['value'] = $currency_info['value'];
        } else {
            $data['value'] = '';
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($currency_info)) {
            $data['status'] = $currency_info['status'];
        } else {
            $data['status'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/currency_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/currency')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['title']) < 3) || (Encode::strlen(Request::p()->post['title']) > 32)) {
            $this->error['title'] = Lang::get('lang_error_title');
        }
        
        if (Encode::strlen(Request::p()->post['code']) != 3) {
            $this->error['code'] = Lang::get('lang_error_code');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/currency')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('sale/order');
        
        foreach (Request::p()->post['selected'] as $currency_id) {
            $currency_info = LocaleCurrency::getCurrency($currency_id);
            
            if ($currency_info) {
                if (Config::get('config_currency') == $currency_info['code']) {
                    $this->error['warning'] = Lang::get('lang_error_default');
                }
                
                $store_total = SettingStore::getTotalStoresByCurrency($currency_info['code']);
                
                if ($store_total) {
                    $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
                }
            }
            
            $order_total = SaleOrder::getTotalOrdersByCurrencyId($currency_id);
            
            if ($order_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_order'), $order_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
