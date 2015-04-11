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
use Dais\Engine\Controller;

class Comment extends Controller {
    private $error = array();
    
    public function index() {
        $this->theme->language('content/comment');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/comment');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->theme->language('content/comment');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/comment');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_comment->addComment($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
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
            
            $this->response->redirect($this->url->link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->theme->language('content/comment');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/comment');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_comment->editComment($this->request->get['comment_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
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
            
            $this->response->redirect($this->url->link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->theme->language('content/comment');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/comment');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $comment_id) {
                $this->model_content_comment->deleteComment($comment_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
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
            
            $this->response->redirect($this->url->link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    private function getList() {
        $data = $this->theme->language('content/comment');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'content/comment');
        
        $data['insert'] = $this->url->link('content/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('content/comment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['comments'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $comment_total = $this->model_content_comment->getTotalComments();
        $results = $this->model_content_comment->getComments($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('content/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'] . $url, 'SSL'));
            
            $data['comments'][] = array('comment_id' => $result['comment_id'], 'name' => $result['name'], 'author' => $result['author'], 'rating' => $result['rating'], 'status' => ($result['status'] ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled')), 'date_added' => date($this->language->get('lang_date_format_short'), strtotime($result['date_added'])), 'selected' => isset($this->request->post['selected']) && in_array($result['comment_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_post'] = $this->url->link('content/comment', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
        $data['sort_author'] = $this->url->link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.author' . $url, 'SSL');
        $data['sort_rating'] = $this->url->link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
        $data['sort_date_added'] = $this->url->link('content/comment', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($comment_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('content/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/comment_list', $data));
    }
    
    private function getForm() {
        $data = $this->theme->language('content/comment');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'content/comment');
        
        if (!isset($this->request->get['comment_id'])) {
            $data['action'] = $this->url->link('content/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('content/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('content/comment', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $comment_info = $this->model_content_comment->getComment($this->request->get['comment_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('content/post');
        
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
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/comment_form', $data));
    }
    
    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'content/comment')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['post_id']) {
            $this->error['post'] = $this->language->get('lang_error_post');
        }
        
        if (($this->encode->strlen($this->request->post['author']) < 3) || ($this->encode->strlen($this->request->post['author']) > 64)) {
            $this->error['author'] = $this->language->get('lang_error_author');
        }
        
        if ($this->encode->strlen($this->request->post['text']) < 1) {
            $this->error['text'] = $this->language->get('lang_error_text');
        }
        
        if (!isset($this->request->post['rating'])) {
            $this->error['rating'] = $this->language->get('lang_error_rating');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'content/comment')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
