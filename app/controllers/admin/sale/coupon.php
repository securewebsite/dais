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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_coupon->addCoupon($this->request->post);
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
            
            Response::redirect(Url::link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('sale/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/coupon');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_coupon->editCoupon($this->request->get['coupon_id'], $this->request->post);
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
            
            Response::redirect(Url::link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('sale/coupon');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/coupon');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $coupon_id) {
                $this->model_sale_coupon->deleteCoupon($coupon_id);
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
            
            Response::redirect(Url::link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('sale/coupon');
        
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
        
        Breadcrumb::add('lang_heading_title', 'sale/coupon', $url);
        
        $data['insert'] = Url::link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('sale/coupon/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['coupons'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $coupon_total = $this->model_sale_coupon->getTotalCoupons();
        
        $results = $this->model_sale_coupon->getCoupons($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&coupon_id=' . $result['coupon_id'] . $url, 'SSL'));
            
            $data['coupons'][] = array('coupon_id' => $result['coupon_id'], 'name' => $result['name'], 'code' => $result['code'], 'discount' => $result['discount'], 'date_start' => date(Lang::get('lang_date_format_short'), strtotime($result['date_start'])), 'date_end' => date(Lang::get('lang_date_format_short'), strtotime($result['date_end'])), 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'selected' => isset($this->request->post['selected']) && in_array($result['coupon_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . '&sort=name' . $url);
        $data['sort_code'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . '&sort=code' . $url);
        $data['sort_discount'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . '&sort=discount' . $url);
        $data['sort_date_start'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . '&sort=date_start' . $url);
        $data['sort_date_end'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . '&sort=date_end' . $url);
        $data['sort_status'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . '&sort=status' . $url);
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($coupon_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('sale/coupon', 'token=' . $this->session->data['token'] . $url . '&page={page}'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('sale/coupon_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('sale/coupon');
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->get['coupon_id'])) {
            $data['coupon_id'] = $this->request->get['coupon_id'];
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
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        Breadcrumb::add('lang_heading_title', 'sale/coupon', $url);
        
        if (!isset($this->request->get['coupon_id'])) {
            $data['action'] = Url::link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['coupon_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
            $coupon_info = $this->model_sale_coupon->getCoupon($this->request->get['coupon_id']);
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($coupon_info)) {
            $data['name'] = $coupon_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['code'])) {
            $data['code'] = $this->request->post['code'];
        } elseif (!empty($coupon_info)) {
            $data['code'] = $coupon_info['code'];
        } else {
            $data['code'] = '';
        }
        
        if (isset($this->request->post['type'])) {
            $data['type'] = $this->request->post['type'];
        } elseif (!empty($coupon_info)) {
            $data['type'] = $coupon_info['type'];
        } else {
            $data['type'] = '';
        }
        
        if (isset($this->request->post['discount'])) {
            $data['discount'] = $this->request->post['discount'];
        } elseif (!empty($coupon_info)) {
            $data['discount'] = $coupon_info['discount'];
        } else {
            $data['discount'] = '';
        }
        
        if (isset($this->request->post['logged'])) {
            $data['logged'] = $this->request->post['logged'];
        } elseif (!empty($coupon_info)) {
            $data['logged'] = $coupon_info['logged'];
        } else {
            $data['logged'] = '';
        }
        
        if (isset($this->request->post['shipping'])) {
            $data['shipping'] = $this->request->post['shipping'];
        } elseif (!empty($coupon_info)) {
            $data['shipping'] = $coupon_info['shipping'];
        } else {
            $data['shipping'] = '';
        }
        
        if (isset($this->request->post['total'])) {
            $data['total'] = $this->request->post['total'];
        } elseif (!empty($coupon_info)) {
            $data['total'] = $coupon_info['total'];
        } else {
            $data['total'] = '';
        }
        
        if (isset($this->request->post['coupon_product'])) {
            $products = $this->request->post['coupon_product'];
        } elseif (isset($this->request->get['coupon_id'])) {
            $products = $this->model_sale_coupon->getCouponProducts($this->request->get['coupon_id']);
        } else {
            $products = array();
        }
        
        Theme::model('catalog/product');
        
        $data['coupon_product'] = array();
        
        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($product_info) {
                $data['coupon_product'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
            }
        }
        
        if (isset($this->request->post['coupon_category'])) {
            $categories = $this->request->post['coupon_category'];
        } elseif (isset($this->request->get['coupon_id'])) {
            $categories = $this->model_sale_coupon->getCouponCategories($this->request->get['coupon_id']);
        } else {
            $categories = array();
        }
        
        Theme::model('catalog/category');
        
        $data['coupon_category'] = array();
        
        foreach ($categories as $category_id) {
            $category_info = $this->model_catalog_category->getCategory($category_id);
            
            if ($category_info) {
                $data['coupon_category'][] = array('category_id' => $category_info['category_id'], 'name' => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']);
            }
        }
        
        if (isset($this->request->post['date_start'])) {
            $data['date_start'] = $this->request->post['date_start'];
        } elseif (!empty($coupon_info)) {
            $data['date_start'] = date('Y-m-d', strtotime($coupon_info['date_start']));
        } else {
            $data['date_start'] = date('Y-m-d', time());
        }
        
        if (isset($this->request->post['date_end'])) {
            $data['date_end'] = $this->request->post['date_end'];
        } elseif (!empty($coupon_info)) {
            $data['date_end'] = date('Y-m-d', strtotime($coupon_info['date_end']));
        } else {
            $data['date_end'] = date('Y-m-d', time());
        }
        
        if (isset($this->request->post['uses_total'])) {
            $data['uses_total'] = $this->request->post['uses_total'];
        } elseif (!empty($coupon_info)) {
            $data['uses_total'] = $coupon_info['uses_total'];
        } else {
            $data['uses_total'] = 1;
        }
        
        if (isset($this->request->post['uses_customer'])) {
            $data['uses_customer'] = $this->request->post['uses_customer'];
        } elseif (!empty($coupon_info)) {
            $data['uses_customer'] = $coupon_info['uses_customer'];
        } else {
            $data['uses_customer'] = 1;
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($coupon_info)) {
            $data['status'] = $coupon_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('sale/coupon_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'sale/coupon')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 128)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if ((Encode::strlen($this->request->post['code']) < 3) || (Encode::strlen($this->request->post['code']) > 10)) {
            $this->error['code'] = Lang::get('lang_error_code');
        }
        
        $coupon_info = $this->model_sale_coupon->getCouponByCode($this->request->post['code']);
        
        if ($coupon_info) {
            if (!isset($this->request->get['coupon_id'])) {
                $this->error['warning'] = Lang::get('lang_error_exists');
            } elseif ($coupon_info['coupon_id'] != $this->request->get['coupon_id']) {
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
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['histories'] = array();
        
        $results = $this->model_sale_coupon->getCouponHistories($this->request->get['coupon_id'], ($page - 1) * 10, 10);
        
        foreach ($results as $result) {
            $data['histories'][] = array('order_id' => $result['order_id'], 'customer' => $result['customer'], 'amount' => $result['amount'], 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])));
        }
        
        $history_total = $this->model_sale_coupon->getTotalCouponHistories($this->request->get['coupon_id']);
        
        $data['pagination'] = Theme::paginate($history_total, $page, 10, Lang::get('lang_text_pagination'), Url::link('sale/coupon/history', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . '&page={page}', 'SSL'));
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(Theme::view('sale/coupon_history', $data));
    }
}
