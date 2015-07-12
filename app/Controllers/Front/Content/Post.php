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

namespace App\Controllers\Front\Content;
use App\Controllers\Controller;
use Front\Controller\Tool\Captcha;

class Post extends Controller {
    
    public function index() {
        $data = Theme::language('content/post');
        
        if (Theme::getStyle() === 'shop'):
            Breadcrumb::add(Config::get('config_name'), 'content/home');
        endif;
        
        Theme::model('content/category');
        
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
                    Breadcrumb::add($category_info['name'], 'content/category', 'bpath=' . $path);
                }
            }
        }
        
        Theme::model('content/author');
        
        if (isset($this->request->get['author_id'])) {
            $author_info = $this->model_content_author->getAuthor($this->request->get['author_id']);
            
            if ($author_info) {
                Breadcrumb::add($author_info['name'], 'content/search', 'author_id=' . $this->request->get['author_id']);
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
            
            Breadcrumb::add('lang_text_search', 'content/search', $url);
        }
        
        if (isset($this->request->get['post_id'])) {
            $post_id = (int)$this->request->get['post_id'];
        } else {
            $post_id = 0;
        }
        
        Theme::model('content/post');
        
        $post_info = $this->model_content_post->getPost($post_id);
        
        if ($post_info) {
            $url = '';
            
            if ($this->customer->isLogged()):
                if ($post_info['visibility'] > $this->customer->customer_group_id):
                    $this->response->redirect(Url::link('error/permission', '', 'SSL'));
                endif;
            else:
                if ($post_info['visibility'] < Config::get('config_default_visibility')):
                    $this->response->redirect(Url::link('error/permission', '', 'SSL'));
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
            
            Breadcrumb::add($post_info['name'], 'content/post', $url . '&post_id=' . $this->request->get['post_id']);
            
            Theme::setTitle(Config::get('config_name') . ' - ' . $post_info['name']);
            Theme::setDescription($post_info['meta_description']);
            Theme::setKeywords($post_info['meta_keyword']);
            
            Theme::setOgType('article');
            Theme::setOgDescription(html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8'));
            
            $data['heading_title'] = $post_info['name'];
            
            Theme::model('content/comment');
            
            $data['tab_comment'] = sprintf(Lang::get('lang_tab_comment'), $this->model_content_comment->getTotalCommentsByPostId($this->request->get['post_id']));
            
            $data['post_id']   = $this->request->get['post_id'];
            $data['author_id'] = $post_info['author_id'];
            
            Theme::model('tool/image');
            
            if ($post_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($post_info['image'], Config::get('blog_image_post_width'), Config::get('blog_image_post_height'));
                Theme::setOgImage($this->model_tool_image->resize($post_info['image'], 200, 200, 'h'));
            } else {
                $data['thumb'] = '';
            }
            
            $data['images'] = array();
            
            $results = $this->model_content_post->getPostImages($this->request->get['post_id']);
            
            foreach ($results as $result) {
                $data['images'][] = array(
                    'popup' => $this->model_tool_image->resize($result['image'], Config::get('blog_image_popup_width'), Config::get('blog_image_popup_height')), 
                    'thumb' => $this->model_tool_image->resize($result['image'], Config::get('blog_image_additional_width'), Config::get('blog_image_additional_height'))
                );
            }
            
            $data['comment_allowed'] = false;
            
            if (Config::get('blog_comment_status')):
                if ($this->customer->isLogged()):
                    $data['comment_allowed'] = true;
                else:
                    if (Config::get('blog_comment_logged')):
                        $data['comment_allowed'] = true;
                    endif;
                endif;
            endif;
            
            $data['comment_status'] = Config::get('blog_comment_status');
            $data['comments']       = sprintf(Lang::get('lang_text_comments'), (int)$post_info['comments']);
            $data['rating']         = (int)$post_info['rating'];
            $data['description']    = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
            
            $data['posts'] = array();
            
            $results = $this->model_content_post->getPostRelated($this->request->get['post_id']);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], Config::get('blog_image_related_width'), Config::get('blog_image_related_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', Config::get('blog_image_related_width'), Config::get('blog_image_related_height'));
                }
                
                if (Config::get('blog_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }
                
                $data['posts'][] = array(
                    'post_id'           => $result['post_id'], 
                    'thumb'             => $image, 
                    'name'              => $result['name'], 
                    'short_description' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 80) . '..', 
                    'rating'            => $rating, 
                    'reviews'           => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 
                    'href'              => Url::link('content/post', 'post_id=' . $result['post_id'])
                );
            }
            
            $data['tags'] = false;
            
            if (!empty($post_info['tag'])):
                $tags = explode(',', $post_info['tag']);
                
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => Url::link('search/search', 'search=' . trim($tag))
                    );
                endforeach;

            endif;
            
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
                    $data['prev_post'] = array('post_id' => $prev_post_info['post_id'], 'name' => $prev_post_info['name'], 'prev_thumb' => $this->model_tool_image->resize($prev_post_info['image'], 50, 50), 'href' => Url::link('content/post', 'post_id=' . $prev_post_info['post_id']));
                }
            }
            
            $data['next_post'] = array();
            
            $next_post_id = $this->model_content_post->getNextPostId($this->request->get['post_id']);
            
            if ($next_post_id) {
                $next_post_info = $this->model_content_post->getPost($next_post_id);
                
                if ($next_post_info) {
                    $data['next_post'] = array('post_id' => $next_post_info['post_id'], 'name' => $next_post_info['name'], 'next_thumb' => $this->model_tool_image->resize($next_post_info['image'], 50, 50), 'href' => Url::link('content/post', 'post_id=' . $next_post_info['post_id']));
                }
            }
            
            $this->model_content_post->updateViewed($this->request->get['post_id']);
            
            $categories = $this->model_content_category->getCategoriesByPostId($this->request->get['post_id']);
            
            $posted_in = array();
            
            if ($categories) {
                foreach ($categories as $category) {
                    $posted_in[] = sprintf(Lang::get('lang_text_posted_categories'), $category['href'], $category['name']);
                }
            }
            
            $data['posted_in_categories'] = implode(", ", $posted_in);
            $data['author_href']          = Url::link('content/search', 'filter_author_id=' . $post_info['author_id'], 'SSL');
            $data['author_name']          = $post_info['author_name'];
            $data['date_added']           = date(Lang::get('lang_post_date'), strtotime($post_info['date_added']));
            
            $comment_text = ($post_info['comments'] == 1) ? rtrim(Lang::get('lang_text_comments'), 's') : Lang::get('lang_text_comments');
            
            if ($post_info['comments'] > 0) {
                $data['text_comments'] = sprintf($comment_text, $post_info['comments']);
            } else {
                $data['text_comments'] = Lang::get('lang_text_no_comments');
            }
            
            $data['text_views'] = sprintf(Lang::get('lang_text_views'), $post_info['viewed']);
            
            // Search
            
            if (isset($this->request->get['filter_name'])) {
                $data['filter_name'] = $this->request->get['filter_name'];
            } else {
                $data['filter_name'] = '';
            }
            
            Theme::loadjs('javascript/content/post', $data);
            
            $data             = Theme::listen(__CLASS__, __FUNCTION__, $data);
            $data['share_bar'] = Theme::controller('common/share_bar', array('post', $data));
            $data             = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('content/post', $data));
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
            
            Breadcrumb::add('lang_text_error', 'content/post', $url . '&post_id=' . $post_id);
            
            Theme::setTitle(Lang::get('lang_text_error'));
            
            $data['heading_title'] = Lang::get('lang_text_error');
            
            $data['continue'] = Url::link('content/home');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('error/not_found', $data));
        }
    }
    
    public function comment() {
        Lang::load('content/post');
        
        Theme::model('content/comment');
        
        $data['text_on'] = Lang::get('lang_text_on');
        $data['text_no_comments'] = Lang::get('lang_text_no_comments');
        
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
                'comments'   => sprintf(Lang::get('lang_text_comments'), (int)$comment_total), 
                'date_added' => date(Lang::get('lang_post_date'), strtotime($result['date_added']))
            );
        }
        
        $data['pagination'] = Theme::paginate(
            $comment_total, 
            $page, 5, 
            Lang::get('lang_text_pagination'), 
            Url::link('content/post/comment', 'post_id=' . $this->request->get['post_id'] . '&page={page}')
        );
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput(Theme::view('content/comment', $data));
    }
    
    public function write() {
        Lang::load('content/post');
        Theme::model('content/comment');
        
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 25)) {
                $json['error'] = Lang::get('lang_error_name');
            }
            
            if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
                $json['error'] = Lang::get('lang_error_email');
            }
            
            if (($this->encode->strlen($this->request->post['text']) < 25) || ($this->encode->strlen($this->request->post['text']) > 1000)) {
                $json['error'] = Lang::get('lang_error_text');
            }
            
            if (empty($this->request->post['rating'])) {
                $json['error'] = Lang::get('lang_error_rating');
            }
            
            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
                $json['error'] = Lang::get('lang_error_captcha');
            }
            
            if (!isset($json['error'])) {
                $this->model_content_comment->addComment($this->request->get['post_id'], $this->request->post);
                
                if (Config::get('blog_comment_require_approve')) {
                    $json['success'] = Lang::get('lang_text_success_approve_required');
                } else {
                    $json['success'] = Lang::get('lang_text_success_no_approve_required');
                }
                
                $json['require_approve'] = Config::get('blog_comment_require_approve');
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function captcha() {
        $captcha = new Captcha;
        
        $this->session->data['captcha'] = $captcha->getCode();
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $captcha->showImage();
    }
}
