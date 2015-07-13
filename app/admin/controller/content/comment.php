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

namespace Admin\Controller\Content;
use Dais\Base\Controller;

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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_comment->addComment($this->request->post);
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
            
            Response::redirect(Url::link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Theme::language('content/comment');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/comment');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_comment->editComment($this->request->get['comment_id'], $this->request->post);
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
            
            Response::redirect(Url::link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Theme::language('content/comment');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/comment');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $comment_id) {
                $this->model_content_comment->deleteComment($comment_id);
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
            
            Response::redirect(Url::link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    private function getList() {
        $data = Theme::language('content/comment');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'r.date_added';
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
        
        Breadcrumb::add('lang_heading_title', 'content/comment');
        
        $data['insert'] = Url::link('content/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('content/comment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['comments'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $comment_total = $this->model_content_comment->getTotalComments();
        $results = $this->model_content_comment->getComments($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('content/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'] . $url, 'SSL'));
            
            $data['comments'][] = array('comment_id' => $result['comment_id'], 'name' => $result['name'], 'author' => $result['author'], 'rating' => $result['rating'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'selected' => isset($this->request->post['selected']) && in_array($result['comment_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_post'] = Url::link('content/comment', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
        $data['sort_author'] = Url::link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.author' . $url, 'SSL');
        $data['sort_rating'] = Url::link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, 'SSL');
        $data['sort_status'] = Url::link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
        $data['sort_date_added'] = Url::link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($comment_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('content/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('content/comment_list', $data));
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'content/comment');
        
        if (!isset($this->request->get['comment_id'])) {
            $data['action'] = Url::link('content/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('content/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $comment_info = $this->model_content_comment->getComment($this->request->get['comment_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        Theme::model('content/post');
        
        if (isset($this->request->post['post_id'])) {
            $data['post_id'] = $this->request->post['post_id'];
        } elseif (!empty($comment_info)) {
            $data['post_id'] = $comment_info['post_id'];
        } else {
            $data['post_id'] = '';
        }
        
        if (isset($this->request->post['post'])) {
            $data['post'] = $this->request->post['post'];
        } elseif (!empty($comment_info)) {
            $data['post'] = $comment_info['post'];
        } else {
            $data['post'] = '';
        }
        
        if (isset($this->request->post['author'])) {
            $data['author'] = $this->request->post['author'];
        } elseif (!empty($comment_info)) {
            $data['author'] = $comment_info['author'];
        } else {
            $data['author'] = '';
        }
        
        if (isset($this->request->post['text'])) {
            $data['text'] = $this->request->post['text'];
        } elseif (!empty($comment_info)) {
            $data['text'] = $comment_info['text'];
        } else {
            $data['text'] = '';
        }
        
        if (isset($this->request->post['rating'])) {
            $data['rating'] = $this->request->post['rating'];
        } elseif (!empty($comment_info)) {
            $data['rating'] = $comment_info['rating'];
        } else {
            $data['rating'] = '';
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($comment_info)) {
            $data['status'] = $comment_info['status'];
        } else {
            $data['status'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('content/comment_form', $data));
    }
    
    private function validateForm() {
        if (!User::hasPermission('modify', 'content/comment')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['post_id']) {
            $this->error['post'] = Lang::get('lang_error_post');
        }
        
        if ((Encode::strlen($this->request->post['author']) < 3) || (Encode::strlen($this->request->post['author']) > 64)) {
            $this->error['author'] = Lang::get('lang_error_author');
        }
        
        if (Encode::strlen($this->request->post['text']) < 1) {
            $this->error['text'] = Lang::get('lang_error_text');
        }
        
        if (!isset($this->request->post['rating'])) {
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
