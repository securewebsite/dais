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

class Language extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/language');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/language');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/language');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/language');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleLanguage::addLanguage(Request::post());
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
            
            Response::redirect(Url::link('locale/language', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/language');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/language');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleLanguage::editLanguage(Request::p()->get['language_id'], Request::post());
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
            
            Response::redirect(Url::link('locale/language', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/language');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/language');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $language_id) {
                LocaleLanguage::deleteLanguage($language_id);
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
            
            Response::redirect(Url::link('locale/language', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/language');
        
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
        
        Breadcrumb::add('lang_heading_title', 'locale/language', $url);
        
        $data['insert'] = Url::link('locale/language/insert', $url, 'SSL');
        $data['delete'] = Url::link('locale/language/delete', $url, 'SSL');
        
        $data['languages'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $language_total = LocaleLanguage::getTotalLanguages();
        
        $results = LocaleLanguage::getLanguages($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/language/update', 'language_id=' . $result['language_id'] . $url, 'SSL'));
            
            $data['languages'][] = array('language_id' => $result['language_id'], 'name' => $result['name'] . (($result['code'] == Config::get('config_language')) ? Lang::get('lang_text_default') : null), 'code' => $result['code'], 'sort_order' => $result['sort_order'], 'selected' => isset(Request::p()->post['selected']) && in_array($result['language_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('locale/language', 'sort=name' . $url, 'SSL');
        $data['sort_code'] = Url::link('locale/language', 'sort=code' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('locale/language', 'sort=sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($language_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/language', $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/language_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/language');
        
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
        
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }
        
        if (isset($this->error['locale'])) {
            $data['error_locale'] = $this->error['locale'];
        } else {
            $data['error_locale'] = '';
        }
        
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
        }
        
        if (isset($this->error['directory'])) {
            $data['error_directory'] = $this->error['directory'];
        } else {
            $data['error_directory'] = '';
        }
        
        if (isset($this->error['filename'])) {
            $data['error_filename'] = $this->error['filename'];
        } else {
            $data['error_filename'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'locale/language', $url);
        
        if (!isset(Request::p()->get['language_id'])) {
            $data['action'] = Url::link('locale/language/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/language/update', 'language_id=' . Request::p()->get['language_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/language', $url, 'SSL');
        
        if (isset(Request::p()->get['language_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $language_info = LocaleLanguage::getLanguage(Request::p()->get['language_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($language_info)) {
            $data['name'] = $language_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['code'])) {
            $data['code'] = Request::p()->post['code'];
        } elseif (!empty($language_info)) {
            $data['code'] = $language_info['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset(Request::p()->post['locale'])) {
            $data['locale'] = Request::p()->post['locale'];
        } elseif (!empty($language_info)) {
            $data['locale'] = $language_info['locale'];
        } else {
            $data['locale'] = '';
        }
        
        if (isset(Request::p()->post['image'])) {
            $data['image'] = Request::p()->post['image'];
        } elseif (!empty($language_info)) {
            $data['image'] = $language_info['image'];
        } else {
            $data['image'] = '';
        }
        
        if (isset(Request::p()->post['directory'])) {
            $data['directory'] = Request::p()->post['directory'];
        } elseif (!empty($language_info)) {
            $data['directory'] = $language_info['directory'];
        } else {
            $data['directory'] = '';
        }
        
        if (isset(Request::p()->post['filename'])) {
            $data['filename'] = Request::p()->post['filename'];
        } elseif (!empty($language_info)) {
            $data['filename'] = $language_info['filename'];
        } else {
            $data['filename'] = '';
        }
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($language_info)) {
            $data['sort_order'] = $language_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($language_info)) {
            $data['status'] = $language_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/language_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/language')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 32)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if (Encode::strlen(Request::p()->post['code']) < 2) {
            $this->error['code'] = Lang::get('lang_error_code');
        }
        
        if (!Request::p()->post['locale']) {
            $this->error['locale'] = Lang::get('lang_error_locale');
        }
        
        if (!Request::p()->post['directory']) {
            $this->error['directory'] = Lang::get('lang_error_directory');
        }
        
        if (!Request::p()->post['filename']) {
            $this->error['filename'] = Lang::get('lang_error_filename');
        }
        
        if ((Encode::strlen(Request::p()->post['image']) < 3) || (Encode::strlen(Request::p()->post['image']) > 32)) {
            $this->error['image'] = Lang::get('lang_error_image');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/language')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('sale/order');
        
        foreach (Request::p()->post['selected'] as $language_id) {
            $language_info = LocaleLanguage::getLanguage($language_id);
            
            if ($language_info) {
                if (Config::get('config_language') == $language_info['code']) {
                    $this->error['warning'] = Lang::get('lang_error_default');
                }
                
                if (Config::get('config_admin_language') == $language_info['code']) {
                    $this->error['warning'] = Lang::get('lang_error_admin');
                }
                
                $store_total = SettingStore::getTotalStoresByLanguage($language_info['code']);
                
                if ($store_total) {
                    $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
                }
            }
            
            $order_total = SaleOrder::getTotalOrdersByLanguageId($language_id);
            
            if ($order_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_order'), $order_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
