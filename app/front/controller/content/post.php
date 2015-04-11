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

namespace Front\Controller\Content;
use Dais\Engine\Controller;
use Front\Controller\Tool\Captcha;

class Post extends Controller {
    
    public function index() {
        $data = $this->theme->language('content/post');
        
        if ($this->theme->style === 'shop'):
            $this->breadcrumb->add($this->config->get('config_name'), 'content/home');
        endif;
        
        $this->theme->model('content/category');
        
        if (isset($this->request->get['bpath'])) {
            $path = '';
            
            foreach (explode('_', $this->request->get['bpath']) as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path.= '_' . $path_id;
                }
                
                $category_info = $this->model_content_category->getCategory($path_id);
                
                if ($category_info) {
                    $this->breadcrumb->add($category_info['name'], 'content/category', 'bpath=' . $path);
                }
            }
        }
        
        $this->theme->model('content/author');
        
        if (isset($this->request->get['author_id'])) {
            $author_info = $this->model_content_author->getAuthor($this->request->get['author_id']);
            
            if ($author_info) {
                $this->breadcrumb->add($author_info['name'], 'content/search', 'author_id=' . $this->request->get['author_id']);
            }
        }
        
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . $this->request->get['filter_name'];
            }
            
            if (isset($this->request->get['filter_tag'])) {
                $url.= '&filter_tag=' . $this->request->get['filter_tag'];
            }
            
            if (isset($this->request->get['filter_description'])) {
                $url.= '&filter_description=' . $this->request->get['filter_description'];
            }
            
            if (isset($this->request->get['filter_category_id'])) {
                $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
            }
            
            $this->breadcrumb->add('lang_text_search', 'content/search', $url);
        }
        
        if (isset($this->request->get['post_id'])) {
            $post_id = (int)$this->request->get['post_id'];
        } else {
            $post_id = 0;
        }
        
        $this->theme->model('content/post');
        
        $post_info = $this->model_content_post->getPost($post_id);
        
        if ($post_info) {
            $url = '';
            
            if ($this->customer->isLogged()):
                if ($post_info['visibility'] > $this->customer->customer_group_id):
                    $this->response->redirect($this->url->link('error/permission', '', 'SSL'));
                endif;
            else:
                if ($post_info['visibility'] > $this->config->get('config_free_customer')):
                    $this->response->redirect($this->url->link('error/permission', '', 'SSL'));
                endif;
            endif;
            
            if (isset($this->request->get['path'])) {
                $url.= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['author_id'])) {
                $url.= '&author_id=' . $this->request->get['author_id'];
            }
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . $this->request->get['filter_name'];
            }
            
            if (isset($this->request->get['filter_tag'])) {
                $url.= '&filter_tag=' . $this->request->get['filter_tag'];
            }
            
            if (isset($this->request->get['filter_description'])) {
                $url.= '&filter_description=' . $this->request->get['filter_description'];
            }
            
            if (isset($this->request->get['filter_category_id'])) {
                $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
            }
            
            $this->breadcrumb->add($post_info['name'], 'content/post', $url . '&post_id=' . $this->request->get['post_id']);
            
            $this->theme->setTitle($this->config->get('config_name') . ' - ' . $post_info['name']);
            $this->theme->setDescription($post_info['meta_description']);
            $this->theme->setKeywords($post_info['meta_keyword']);
            
            $this->theme->setOgType('article');
            $this->theme->setOgDescription(html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8'));
            
            $data['heading_title'] = $post_info['name'];
            
            $this->theme->model('content/comment');
            
            $data['tab_comment'] = sprintf($this->language->get('lang_tab_comment'), $this->model_content_comment->getTotalCommentsByPostId($this->request->get['post_id']));
            
            $data['post_id'] = $this->request->get['post_id'];
            $data['author_id'] = $post_info['author_id'];
            
            $this->theme->model('tool/image');
            
            if ($post_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($post_info['image'], $this->config->get('blog_image_post_width'), $this->config->get('blog_image_post_height'));
                $this->theme->setOgImage($this->model_tool_image->resize($post_info['image'], 200, 200, 'h'));
            } else {
                $data['thumb'] = '';
            }
            
            $data['images'] = array();
            
            $results = $this->model_content_post->getPostImages($this->request->get['post_id']);
            
            foreach ($results as $result) {
                $data['images'][] = array('popup' => $this->model_tool_image->resize($result['image'], $this->config->get('blog_image_popup_width'), $this->config->get('blog_image_popup_height')), 'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('blog_image_additional_width'), $this->config->get('blog_image_additional_height')));
            }
            
            $data['comment_allowed'] = false;
            
            if ($this->config->get('blog_comment_status')):
                if ($this->customer->isLogged()):
                    $data['comment_allowed'] = true;
                else:
                    if ($this->config->get('blog_comment_logged')):
                        $data['comment_allowed'] = true;
                    endif;
                endif;
            endif;
            
            $data['comment_status'] = $this->config->get('blog_comment_status');
            $data['comments'] = sprintf($this->language->get('lang_text_comments'), (int)$post_info['comments']);
            $data['rating'] = (int)$post_info['rating'];
            $data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
            
            $data['posts'] = array();
            
            $results = $this->model_content_post->getPostRelated($this->request->get['post_id']);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('blog_image_related_width'), $this->config->get('blog_image_related_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('blog_image_related_width'), $this->config->get('blog_image_related_height'));
                }
                
                if ($this->config->get('blog_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }
                
                $data['posts'][] = array('post_id' => $result['post_id'], 'thumb' => $image, 'name' => $result['name'], 'short_description' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 80) . '..', 'rating' => $rating, 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$result['reviews']), 'href' => $this->url->link('content/post', 'post_id=' . $result['post_id']),);
            }
            
            $data['tags'] = array();
            
            $tags = explode(',', $post_info['tag']);
            
            foreach ($tags as $tag) {
                $data['tags'][] = array('tag' => trim($tag), 'href' => $this->url->link('content/search', 'filter_tag=' . trim($tag)));
            }
            
            if (isset($this->request->get['to_comments'])) {
                $data['to_comments'] = true;
            } else {
                $data['to_comments'] = false;
            }
            
            $data['prev_post'] = array();
            
            $prev_post_id = $this->model_content_post->getPrevPostId($this->request->get['post_id']);
            
            if ($prev_post_id) {
                $prev_post_info = $this->model_content_post->getPost($prev_post_id);
                
                if ($prev_post_info) {
                    $data['prev_post'] = array('post_id' => $prev_post_info['post_id'], 'name' => $prev_post_info['name'], 'prev_thumb' => $this->model_tool_image->resize($prev_post_info['image'], 50, 50), 'href' => $this->url->link('content/post', 'post_id=' . $prev_post_info['post_id']));
                }
            }
            
            $data['next_post'] = array();
            
            $next_post_id = $this->model_content_post->getNextPostId($this->request->get['post_id']);
            
            if ($next_post_id) {
                $next_post_info = $this->model_content_post->getPost($next_post_id);
                
                if ($next_post_info) {
                    $data['next_post'] = array('post_id' => $next_post_info['post_id'], 'name' => $next_post_info['name'], 'next_thumb' => $this->model_tool_image->resize($next_post_info['image'], 50, 50), 'href' => $this->url->link('content/post', 'post_id=' . $next_post_info['post_id']));
                }
            }
            
            $this->model_content_post->updateViewed($this->request->get['post_id']);
            
            $categories = $this->model_content_category->getCategoriesByPostId($this->request->get['post_id']);
            
            $posted_in = array();
            
            if ($categories) {
                foreach ($categories as $category) {
                    $posted_in[] = sprintf($this->language->get('lang_text_posted_categories'), $category['href'], $category['name']);
                }
            }
            
            $data['posted_in_categories'] = implode(", ", $posted_in);
            $data['author_href'] = $this->url->link('content/search', 'filter_author_id=' . $post_info['author_id'], 'SSL');
            $data['author_name'] = $post_info['author_name'];
            $data['date_added'] = date($this->language->get('lang_post_date'), strtotime($post_info['date_added']));
            
            $comment_text = ($post_info['comments'] == 1) ? rtrim($this->language->get('lang_text_comments'), 's') : $this->language->get('lang_text_comments');
            
            if ($post_info['comments'] > 0) {
                $data['text_comments'] = sprintf($comment_text, $post_info['comments']);
            } else {
                $data['text_comments'] = $this->language->get('lang_text_no_comments');
            }
            
            $data['text_views'] = sprintf($this->language->get('lang_text_views'), $post_info['viewed']);
            
            // Search
            
            if (isset($this->request->get['filter_name'])) {
                $data['filter_name'] = $this->request->get['filter_name'];
            } else {
                $data['filter_name'] = '';
            }
            
            $this->theme->loadjs('javascript/content/post', $data);
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('content/post', $data));
        } else {
            $url = '';
            
            if (isset($this->request->get['path'])) {
                $url.= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['author_id'])) {
                $url.= '&author_id=' . $this->request->get['author_id'];
            }
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . $this->request->get['filter_name'];
            }
            
            if (isset($this->request->get['filter_tag'])) {
                $url.= '&filter_tag=' . $this->request->get['filter_tag'];
            }
            
            if (isset($this->request->get['filter_description'])) {
                $url.= '&filter_description=' . $this->request->get['filter_description'];
            }
            
            if (isset($this->request->get['filter_category_id'])) {
                $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
            }
            
            $this->breadcrumb->add('lang_text_error', 'content/post', $url . '&post_id=' . $post_id);
            
            $this->theme->setTitle($this->language->get('lang_text_error'));
            
            $data['heading_title'] = $this->language->get('lang_text_error');
            
            $data['continue'] = $this->url->link('content/home');
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('error/notfound', $data));
        }
    }
    
    public function comment() {
        $this->language->load('content/post');
        
        $this->theme->model('content/comment');
        
        $data['text_on'] = $this->language->get('lang_text_on');
        $data['text_no_comments'] = $this->language->get('lang_text_no_comments');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['comments'] = array();
        
        $comment_total = $this->model_content_comment->getTotalCommentsByPostId($this->request->get['post_id']);
        
        $results = $this->model_content_comment->getCommentsByPostId($this->request->get['post_id'], ($page - 1) * 5, 5);
        
        foreach ($results as $result) {
            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                $http = 'https://';
            } else {
                $http = 'http://';
            }
            
            $image = $http . 'www.gravatar.com/avatar/' . md5(strtolower($result['email'])) . '?s=50';
            
            $data['comments'][] = array(
                'author'     => $result['author'], 
                'image'      => $image, 
                'href'       => $result['website'] ? $result['website'] : false, 
                'text'       => strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 
                'rating'     => (int)$result['rating'], 
                'comments'   => sprintf($this->language->get('lang_text_comments'), (int)$comment_total), 
                'date_added' => date($this->language->get('lang_post_date'), strtotime($result['date_added']))
            );
        }
        
        $data['pagination'] = $this->theme->paginate(
            $comment_total, 
            $page, 5, 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('content/post/comment', 'post_id=' . $this->request->get['post_id'] . '&page={page}')
        );
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('content/comment', $data));
    }
    
    public function write() {
        $this->language->load('content/post');
        $this->theme->model('content/comment');
        
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('lang_error_name');
            }
            
            if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
                $json['error'] = $this->language->get('lang_error_email');
            }
            
            if (($this->encode->strlen($this->request->post['text']) < 25) || ($this->encode->strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('lang_error_text');
            }
            
            if (empty($this->request->post['rating'])) {
                $json['error'] = $this->language->get('lang_error_rating');
            }
            
            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
                $json['error'] = $this->language->get('lang_error_captcha');
            }
            
            if (!isset($json['error'])) {
                $this->model_content_comment->addComment($this->request->get['post_id'], $this->request->post);
                
                if ($this->config->get('blog_comment_require_approve')) {
                    $json['success'] = $this->language->get('lang_text_success_approve_required');
                } else {
                    $json['success'] = $this->language->get('lang_text_success_no_approve_required');
                }
                
                $json['require_approve'] = $this->config->get('blog_comment_require_approve');
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function captcha() {
        $captcha = new Captcha;
        
        $this->session->data['captcha'] = $captcha->getCode();
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $captcha->showImage();
    }
}
