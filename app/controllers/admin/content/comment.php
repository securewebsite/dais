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

namespace App\Controllers\Admin\Content;

use App\Controllers\Controller;

class Comment extends Controller {
    
    private $error = array();
    
    public function index() {
        Theme::language('content/comment');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/comment');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Theme::language('content/comment');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/comment');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ContentComment::addComment(Request::post());
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
            
            Response::redirect(Url::link('content/comment', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Theme::language('content/comment');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/comment');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ContentComment::editComment(Request::p()->get['comment_id'], Request::post());
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
            
            Response::redirect(Url::link('content/comment', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Theme::language('content/comment');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/comment');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $comment_id) {
                ContentComment::deleteComment($comment_id);
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
            
            Response::redirect(Url::link('content/comment', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    private function getList() {
        $data = Theme::language('content/comment');
        
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'content/comment');
        
        $data['insert'] = Url::link('content/comment/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('content/comment/delete', '' . $url, 'SSL');
        
        $data['comments'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $comment_total = ContentComment::getTotalComments();
        $results = ContentComment::getComments($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('content/comment/update', '' . 'comment_id=' . $result['comment_id'] . $url, 'SSL'));
            
            $data['comments'][] = array('comment_id' => $result['comment_id'], 'name' => $result['name'], 'author' => $result['author'], 'rating' => $result['rating'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'selected' => isset(Request::p()->post['selected']) && in_array($result['comment_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        $data['sort_post'] = Url::link('content/comment', '' . 'sort=pd.name' . $url, 'SSL');
        $data['sort_author'] = Url::link('content/comment', '' . 'sort=r.author' . $url, 'SSL');
        $data['sort_rating'] = Url::link('content/comment', '' . 'sort=r.rating' . $url, 'SSL');
        $data['sort_status'] = Url::link('content/comment', '' . 'sort=r.status' . $url, 'SSL');
        $data['sort_date_added'] = Url::link('content/comment', '' . 'sort=r.date_added' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($comment_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('content/comment', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('content/comment_list', $data));
    }
    
    private function getForm() {
        $data = Theme::language('content/comment');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['post'])) {
            $data['error_post'] = $this->error['post'];
        } else {
            $data['error_post'] = '';
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'content/comment');
        
        if (!isset(Request::p()->get['comment_id'])) {
            $data['action'] = Url::link('content/comment/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('content/comment/update', '' . 'comment_id=' . Request::p()->get['comment_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('content/comment', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['comment_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $comment_info = ContentComment::getComment(Request::p()->get['comment_id']);
        }
        
        Theme::model('content/post');
        
        if (isset(Request::p()->post['post_id'])) {
            $data['post_id'] = Request::p()->post['post_id'];
        } elseif (!empty($comment_info)) {
            $data['post_id'] = $comment_info['post_id'];
        } else {
            $data['post_id'] = '';
        }
        
        if (isset(Request::p()->post['post'])) {
            $data['post'] = Request::p()->post['post'];
        } elseif (!empty($comment_info)) {
            $data['post'] = $comment_info['post'];
        } else {
            $data['post'] = '';
        }
        
        if (isset(Request::p()->post['author'])) {
            $data['author'] = Request::p()->post['author'];
        } elseif (!empty($comment_info)) {
            $data['author'] = $comment_info['author'];
        } else {
            $data['author'] = '';
        }
        
        if (isset(Request::p()->post['text'])) {
            $data['text'] = Request::p()->post['text'];
        } elseif (!empty($comment_info)) {
            $data['text'] = $comment_info['text'];
        } else {
            $data['text'] = '';
        }
        
        if (isset(Request::p()->post['rating'])) {
            $data['rating'] = Request::p()->post['rating'];
        } elseif (!empty($comment_info)) {
            $data['rating'] = $comment_info['rating'];
        } else {
            $data['rating'] = '';
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($comment_info)) {
            $data['status'] = $comment_info['status'];
        } else {
            $data['status'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('content/comment_form', $data));
    }
    
    private function validateForm() {
        if (!User::hasPermission('modify', 'content/comment')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['post_id']) {
            $this->error['post'] = Lang::get('lang_error_post');
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
    
    private function validateDelete() {
        if (!User::hasPermission('modify', 'content/comment')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
