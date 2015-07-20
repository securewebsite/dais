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

class Review extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('catalog/review');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/review');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('catalog/review');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/review');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogReview::addReview(Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/review', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/review');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/review');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogReview::editReview(Request::p()->get['review_id'], Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/review', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/review');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/review');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $review_id) {
                CatalogReview::deleteReview($review_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/review', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/review');
        
        if (isset(Request::p()->get['filter_status'])):
            $filter_status = Request::p()->get['filter_status'];
        else:
            $filter_status = 1;
        endif;
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'r.date_added';
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
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'catalog/review', $url);
        
        $data['insert'] = Url::link('catalog/review/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('catalog/review/delete', '' . $url, 'SSL');
        
        $data['reviews'] = array();
        
        $filter = array('filter_status' => $filter_status, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $review_total = CatalogReview::getTotalReviews($filter);
        
        $results = CatalogReview::getReviews($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('catalog/review/update', '' . 'review_id=' . $result['review_id'] . $url, 'SSL'));
            
            $data['reviews'][] = array('review_id' => $result['review_id'], 'name' => $result['name'], 'author' => $result['author'], 'rating' => $result['rating'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'selected' => isset(Request::p()->post['selected']) && in_array($result['review_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if ($order == 'asc') {
            $url.= '&order=desc';
        } else {
            $url.= '&order=asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_product'] = Url::link('catalog/review', '' . 'sort=pd.name' . $url, 'SSL');
        $data['sort_author'] = Url::link('catalog/review', '' . 'sort=r.author' . $url, 'SSL');
        $data['sort_rating'] = Url::link('catalog/review', '' . 'sort=r.rating' . $url, 'SSL');
        $data['sort_status'] = Url::link('catalog/review', '' . 'sort=r.status' . $url, 'SSL');
        $data['sort_date_added'] = Url::link('catalog/review', '' . 'sort=r.date_added' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($review_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/review', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['filter_status'] = $filter_status;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/review_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/review');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['product'])) {
            $data['error_product'] = $this->error['product'];
        } else {
            $data['error_product'] = '';
        }
        
        if (isset($this->error['author'])) {
            $data['error_author'] = $this->error['author'];
        } else {
            $data['error_author'] = '';
        }
        
        if (isset($this->error['text'])) {
            $data['error_text'] = $this->error['text'];
        } else {
            $data['error_text'] = '';
        }
        
        if (isset($this->error['rating'])) {
            $data['error_rating'] = $this->error['rating'];
        } else {
            $data['error_rating'] = '';
        }
        
        $url = '';
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'catalog/review', $url);
        
        if (!isset(Request::p()->get['review_id'])) {
            $data['action'] = Url::link('catalog/review/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/review/update', '' . 'review_id=' . Request::p()->get['review_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/review', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['review_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $review_info = CatalogReview::getReview(Request::p()->get['review_id']);
        }
        
        Theme::model('catalog/product');
        
        if (isset(Request::p()->post['product_id'])) {
            $data['product_id'] = Request::p()->post['product_id'];
        } elseif (!empty($review_info)) {
            $data['product_id'] = $review_info['product_id'];
        } else {
            $data['product_id'] = '';
        }
        
        if (isset(Request::p()->post['product'])) {
            $data['product'] = Request::p()->post['product'];
        } elseif (!empty($review_info)) {
            $data['product'] = $review_info['product'];
        } else {
            $data['product'] = '';
        }
        
        if (isset(Request::p()->post['author'])) {
            $data['author'] = Request::p()->post['author'];
        } elseif (!empty($review_info)) {
            $data['author'] = $review_info['author'];
        } else {
            $data['author'] = '';
        }
        
        if (isset(Request::p()->post['text'])) {
            $data['text'] = Request::p()->post['text'];
        } elseif (!empty($review_info)) {
            $data['text'] = $review_info['text'];
        } else {
            $data['text'] = '';
        }
        
        if (isset(Request::p()->post['rating'])) {
            $data['rating'] = Request::p()->post['rating'];
        } elseif (!empty($review_info)) {
            $data['rating'] = $review_info['rating'];
        } else {
            $data['rating'] = '';
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($review_info)) {
            $data['status'] = $review_info['status'];
        } else {
            $data['status'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/review_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/review')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['product_id']) {
            $this->error['product'] = Lang::get('lang_error_product');
        }
        
        if ((Encode::strlen(Request::p()->post['author']) < 3) || (Encode::strlen(Request::p()->post['author']) > 64)) {
            $this->error['author'] = Lang::get('lang_error_author');
        }
        
        if (Encode::strlen(Request::p()->post['text']) < 1) {
            $this->error['text'] = Lang::get('lang_error_text');
        }
        
        if (!isset(Request::p()->post['rating'])) {
            $this->error['rating'] = Lang::get('lang_error_rating');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'catalog/review')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
