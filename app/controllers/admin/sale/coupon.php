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

namespace App\Controllers\Admin\Sale;

use App\Controllers\Controller;

class Coupon extends Controller {
    
    private $error = array();
    
    public function index() {
        Theme::language('sale/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/coupon');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Theme::language('sale/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/coupon');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            SaleCoupon::addCoupon(Request::post());
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
            
            Response::redirect(Url::link('sale/coupon', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('sale/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/coupon');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            SaleCoupon::editCoupon(Request::p()->get['coupon_id'], Request::post());
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
            
            Response::redirect(Url::link('sale/coupon', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('sale/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/coupon');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $coupon_id) {
                SaleCoupon::deleteCoupon($coupon_id);
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
            
            Response::redirect(Url::link('sale/coupon', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('sale/coupon');
        
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
        
        Breadcrumb::add('lang_heading_title', 'sale/coupon', $url);
        
        $data['insert'] = Url::link('sale/coupon/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('sale/coupon/delete', '' . $url, 'SSL');
        
        $data['coupons'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $coupon_total = SaleCoupon::getTotalCoupons();
        
        $results = SaleCoupon::getCoupons($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('sale/coupon/update', '' . 'coupon_id=' . $result['coupon_id'] . $url, 'SSL'));
            
            $data['coupons'][] = array('coupon_id' => $result['coupon_id'], 'name' => $result['name'], 'code' => $result['code'], 'discount' => $result['discount'], 'date_start' => date(Lang::get('lang_date_format_short'), strtotime($result['date_start'])), 'date_end' => date(Lang::get('lang_date_format_short'), strtotime($result['date_end'])), 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'selected' => isset(Request::p()->post['selected']) && in_array($result['coupon_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('sale/coupon', '' . 'sort=name' . $url);
        $data['sort_code'] = Url::link('sale/coupon', '' . 'sort=code' . $url);
        $data['sort_discount'] = Url::link('sale/coupon', '' . 'sort=discount' . $url);
        $data['sort_date_start'] = Url::link('sale/coupon', '' . 'sort=date_start' . $url);
        $data['sort_date_end'] = Url::link('sale/coupon', '' . 'sort=date_end' . $url);
        $data['sort_status'] = Url::link('sale/coupon', '' . 'sort=status' . $url);
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($coupon_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('sale/coupon', '' . $url . '&page={page}'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('sale/coupon_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('sale/coupon');
        
        if (isset(Request::p()->get['coupon_id'])) {
            $data['coupon_id'] = Request::p()->get['coupon_id'];
        } else {
            $data['coupon_id'] = 0;
        }
        
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
        
        if (isset($this->error['date_start'])) {
            $data['error_date_start'] = $this->error['date_start'];
        } else {
            $data['error_date_start'] = '';
        }
        
        if (isset($this->error['date_end'])) {
            $data['error_date_end'] = $this->error['date_end'];
        } else {
            $data['error_date_end'] = '';
        }
        
        $url = '';
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        Breadcrumb::add('lang_heading_title', 'sale/coupon', $url);
        
        if (!isset(Request::p()->get['coupon_id'])) {
            $data['action'] = Url::link('sale/coupon/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('sale/coupon/update', '' . 'coupon_id=' . Request::p()->get['coupon_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('sale/coupon', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['coupon_id']) && (!Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $coupon_info = SaleCoupon::getCoupon(Request::p()->get['coupon_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($coupon_info)) {
            $data['name'] = $coupon_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['code'])) {
            $data['code'] = Request::p()->post['code'];
        } elseif (!empty($coupon_info)) {
            $data['code'] = $coupon_info['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset(Request::p()->post['type'])) {
            $data['type'] = Request::p()->post['type'];
        } elseif (!empty($coupon_info)) {
            $data['type'] = $coupon_info['type'];
        } else {
            $data['type'] = '';
        }
        
        if (isset(Request::p()->post['discount'])) {
            $data['discount'] = Request::p()->post['discount'];
        } elseif (!empty($coupon_info)) {
            $data['discount'] = $coupon_info['discount'];
        } else {
            $data['discount'] = '';
        }
        
        if (isset(Request::p()->post['logged'])) {
            $data['logged'] = Request::p()->post['logged'];
        } elseif (!empty($coupon_info)) {
            $data['logged'] = $coupon_info['logged'];
        } else {
            $data['logged'] = '';
        }
        
        if (isset(Request::p()->post['shipping'])) {
            $data['shipping'] = Request::p()->post['shipping'];
        } elseif (!empty($coupon_info)) {
            $data['shipping'] = $coupon_info['shipping'];
        } else {
            $data['shipping'] = '';
        }
        
        if (isset(Request::p()->post['total'])) {
            $data['total'] = Request::p()->post['total'];
        } elseif (!empty($coupon_info)) {
            $data['total'] = $coupon_info['total'];
        } else {
            $data['total'] = '';
        }
        
        if (isset(Request::p()->post['coupon_product'])) {
            $products = Request::p()->post['coupon_product'];
        } elseif (isset(Request::p()->get['coupon_id'])) {
            $products = SaleCoupon::getCouponProducts(Request::p()->get['coupon_id']);
        } else {
            $products = array();
        }
        
        Theme::model('catalog/product');
        
        $data['coupon_product'] = array();
        
        foreach ($products as $product_id) {
            $product_info = CatalogProduct::getProduct($product_id);
            
            if ($product_info) {
                $data['coupon_product'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
            }
        }
        
        if (isset(Request::p()->post['coupon_category'])) {
            $categories = Request::p()->post['coupon_category'];
        } elseif (isset(Request::p()->get['coupon_id'])) {
            $categories = SaleCoupon::getCouponCategories(Request::p()->get['coupon_id']);
        } else {
            $categories = array();
        }
        
        Theme::model('catalog/category');
        
        $data['coupon_category'] = array();
        
        foreach ($categories as $category_id) {
            $category_info = CatalogCategory::getCategory($category_id);
            
            if ($category_info) {
                $data['coupon_category'][] = array('category_id' => $category_info['category_id'], 'name' => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']);
            }
        }
        
        if (isset(Request::p()->post['date_start'])) {
            $data['date_start'] = Request::p()->post['date_start'];
        } elseif (!empty($coupon_info)) {
            $data['date_start'] = date('Y-m-d', strtotime($coupon_info['date_start']));
        } else {
            $data['date_start'] = date('Y-m-d', time());
        }
        
        if (isset(Request::p()->post['date_end'])) {
            $data['date_end'] = Request::p()->post['date_end'];
        } elseif (!empty($coupon_info)) {
            $data['date_end'] = date('Y-m-d', strtotime($coupon_info['date_end']));
        } else {
            $data['date_end'] = date('Y-m-d', time());
        }
        
        if (isset(Request::p()->post['uses_total'])) {
            $data['uses_total'] = Request::p()->post['uses_total'];
        } elseif (!empty($coupon_info)) {
            $data['uses_total'] = $coupon_info['uses_total'];
        } else {
            $data['uses_total'] = 1;
        }
        
        if (isset(Request::p()->post['uses_customer'])) {
            $data['uses_customer'] = Request::p()->post['uses_customer'];
        } elseif (!empty($coupon_info)) {
            $data['uses_customer'] = $coupon_info['uses_customer'];
        } else {
            $data['uses_customer'] = 1;
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($coupon_info)) {
            $data['status'] = $coupon_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('sale/coupon_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'sale/coupon')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 128)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if ((Encode::strlen(Request::p()->post['code']) < 3) || (Encode::strlen(Request::p()->post['code']) > 10)) {
            $this->error['code'] = Lang::get('lang_error_code');
        }
        
        $coupon_info = SaleCoupon::getCouponByCode(Request::p()->post['code']);
        
        if ($coupon_info) {
            if (!isset(Request::p()->get['coupon_id'])) {
                $this->error['warning'] = Lang::get('lang_error_exists');
            } elseif ($coupon_info['coupon_id'] != Request::p()->get['coupon_id']) {
                $this->error['warning'] = Lang::get('lang_error_exists');
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'sale/coupon')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function history() {
        $data = Theme::language('sale/coupon');
        
        Theme::model('sale/coupon');
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $data['histories'] = array();
        
        $results = SaleCoupon::getCouponHistories(Request::p()->get['coupon_id'], ($page - 1) * 10, 10);
        
        foreach ($results as $result) {
            $data['histories'][] = array('order_id' => $result['order_id'], 'customer' => $result['customer'], 'amount' => $result['amount'], 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])));
        }
        
        $history_total = SaleCoupon::getTotalCouponHistories(Request::p()->get['coupon_id']);
        
        $data['pagination'] = Theme::paginate($history_total, $page, 10, Lang::get('lang_text_pagination'), Url::link('sale/coupon/history', '' . 'coupon_id=' . Request::p()->get['coupon_id'] . '&page={page}', 'SSL'));
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('sale/coupon_history', $data));
    }
}
