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

namespace App\Controllers\Admin\Catalog;

use App\Controllers\Controller;

class Recurring extends Controller {
    
    private $error = array();
    
    public function index() {
        Theme::language('catalog/recurring');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/recurring');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function add() {
        Theme::language('catalog/recurring');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/recurring');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogRecurring::addRecurring($this->request->post);
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
            
            Response::redirect(Url::link('catalog/recurring', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function edit() {
        Theme::language('catalog/recurring');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/recurring');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogRecurring::editRecurring($this->request->get['recurring_id'], $this->request->post);
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
            
            Response::redirect(Url::link('catalog/recurring', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Theme::language('catalog/recurring');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/recurring');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $recurring_id) {
                CatalogRecurring::deleteRecurring($recurring_id);
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
            
            Response::redirect(Url::link('catalog/recurring', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function copy() {
        Theme::language('catalog/recurring');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('catalog/recurring');
        
        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $recurring_id) {
                CatalogRecurring::copyRecurring($recurring_id);
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
            
            Response::redirect(Url::link('catalog/recurring', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/recurring');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'r.sort_order';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/recurring');
        
        $data['insert'] = Url::link('catalog/recurring/add', '' . $url, 'SSL');
        $data['copy'] = Url::link('catalog/recurring/copy', '' . $url, 'SSL');
        $data['delete'] = Url::link('catalog/recurring/delete', '' . $url, 'SSL');
        
        $data['recurrings'] = array();
        
        $filter_data = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_limit_admin'), 'limit' => Config::get('config_limit_admin'));
        
        $recurring_total = CatalogRecurring::getTotalRecurrings($filter_data);
        
        $results = CatalogRecurring::getRecurrings($filter_data);
        
        foreach ($results as $result) {
            $data['recurrings'][] = array('recurring_id' => $result['recurring_id'], 'name' => $result['name'], 'sort_order' => $result['sort_order'], 'edit' => Url::link('catalog/recurring/edit', '' . '&recurring_id=' . $result['recurring_id'] . $url, 'SSL'));
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
        
        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
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
        
        $data['sort_name'] = Url::link('catalog/recurring', '' . '&sort=pd.name' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('catalog/recurring', '' . '&sort=p.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($recurring_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/recurring', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('catalog/recurring_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/recurring');
        
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/recurring');
        
        if (!isset($this->request->get['recurring_id'])) {
            $data['action'] = Url::link('catalog/recurring/add', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/recurring/edit', '' . '&recurring_id=' . $this->request->get['recurring_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/recurring', '' . $url, 'SSL');
        
        if (isset($this->request->get['recurring_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $recurring_info = CatalogRecurring::getRecurring($this->request->get['recurring_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset($this->request->post['recurring_description'])) {
            $data['recurring_description'] = $this->request->post['recurring_description'];
        } elseif (!empty($recurring_info)) {
            $data['recurring_description'] = CatalogRecurring::getRecurringDescription($recurring_info['recurring_id']);
        } else {
            $data['recurring_description'] = array();
        }
        
        if (isset($this->request->post['price'])) {
            $data['price'] = $this->request->post['price'];
        } elseif (!empty($recurring_info)) {
            $data['price'] = $recurring_info['price'];
        } else {
            $data['price'] = 0;
        }
        
        $data['frequencies'] = array();
        
        $data['frequencies'][] = array('text' => Lang::get('lang_text_day'), 'value' => 'day');
        
        $data['frequencies'][] = array('text' => Lang::get('lang_text_week'), 'value' => 'week');
        
        $data['frequencies'][] = array('text' => Lang::get('lang_text_semi_month'), 'value' => 'semi_month');
        
        $data['frequencies'][] = array('text' => Lang::get('lang_text_month'), 'value' => 'month');
        
        $data['frequencies'][] = array('text' => Lang::get('lang_text_year'), 'value' => 'year');
        
        if (isset($this->request->post['frequency'])) {
            $data['frequency'] = $this->request->post['frequency'];
        } elseif (!empty($recurring_info)) {
            $data['frequency'] = $recurring_info['frequency'];
        } else {
            $data['frequency'] = '';
        }
        
        if (isset($this->request->post['duration'])) {
            $data['duration'] = $this->request->post['duration'];
        } elseif (!empty($recurring_info)) {
            $data['duration'] = $recurring_info['duration'];
        } else {
            $data['duration'] = 0;
        }
        
        if (isset($this->request->post['cycle'])) {
            $data['cycle'] = $this->request->post['cycle'];
        } elseif (!empty($recurring_info)) {
            $data['cycle'] = $recurring_info['cycle'];
        } else {
            $data['cycle'] = 1;
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($recurring_info)) {
            $data['status'] = $recurring_info['status'];
        } else {
            $data['status'] = 0;
        }
        
        if (isset($this->request->post['trial_price'])) {
            $data['trial_price'] = $this->request->post['trial_price'];
        } elseif (!empty($recurring_info)) {
            $data['trial_price'] = $recurring_info['trial_price'];
        } else {
            $data['trial_price'] = 0.00;
        }
        
        if (isset($this->request->post['trial_frequency'])) {
            $data['trial_frequency'] = $this->request->post['trial_frequency'];
        } elseif (!empty($recurring_info)) {
            $data['trial_frequency'] = $recurring_info['trial_frequency'];
        } else {
            $data['trial_frequency'] = '';
        }
        
        if (isset($this->request->post['trial_duration'])) {
            $data['trial_duration'] = $this->request->post['trial_duration'];
        } elseif (!empty($recurring_info)) {
            $data['trial_duration'] = $recurring_info['trial_duration'];
        } else {
            $data['trial_duration'] = '0';
        }
        
        if (isset($this->request->post['trial_cycle'])) {
            $data['trial_cycle'] = $this->request->post['trial_cycle'];
        } elseif (!empty($recurring_info)) {
            $data['trial_cycle'] = $recurring_info['trial_cycle'];
        } else {
            $data['trial_cycle'] = '1';
        }
        if (isset($this->request->post['trial_status'])) {
            $data['trial_status'] = $this->request->post['trial_status'];
        } elseif (!empty($recurring_info)) {
            $data['trial_status'] = $recurring_info['trial_status'];
        } else {
            $data['trial_status'] = 0;
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($recurring_info)) {
            $data['sort_order'] = $recurring_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('catalog/recurring_form', $data));
    }
    
    protected function validateForm() {
        Theme::language('catalog/recurring');
        
        if (!User::hasPermission('modify', 'catalog/recurring')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['recurring_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = Lang::get('lang_error_warning');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        Theme::language('catalog/recurring');
        
        if (!User::hasPermission('modify', 'catalog/recurring')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $recurring_id) {
            $product_total = CatalogProduct::getTotalProductsByRcurringId($recurring_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateCopy() {
        Theme::language('catalog/recurring');
        
        if (!User::hasPermission('modify', 'catalog/recurring')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
