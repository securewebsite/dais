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

class Category extends Controller {
    public function index() {
        $data = $this->theme->language('content/category');
        
        if ($this->theme->style === 'shop'):
            $this->breadcrumb->add($this->config->get('config_name'), 'content/home');
        endif;
        
        $this->theme->model('content/category');
        $this->theme->model('content/post');
        $this->theme->model('tool/image');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.date_added';
        }
        
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }
        
        if (isset($this->request->get['bpath'])) {
            $path = '';
            
            $parts = explode('_', (string)$this->request->get['bpath']);
            
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path.= '_' . (int)$path_id;
                }
                
                $category_info = $this->model_content_category->getCategory($path_id);
                
                if ($category_info) {
                    $this->breadcrumb->add($category_info['name'], 'content/category', 'bpath=' . $path);
                }
            }
            
            $category_id = (int)array_pop($parts);
        } else {
            $category_id = 0;
        }
        
        $category_info = $this->model_content_category->getCategory($category_id);
        
        if ($category_info) {
            $this->theme->setTitle($category_info['name']);
            $this->theme->setDescription($category_info['meta_description']);
            $this->theme->setKeywords($category_info['meta_keyword']);
            
            $this->theme->setOgType('article');
            
            $data['heading_title'] = $category_info['name'];
            
            if ($category_info['image']) {
                $data['thumb'] = IMAGE_URL . $category_info['image'];
                 // remove resizing and allow img-responsive to handle sizing
                $this->theme->setOgImage($this->model_tool_image->resize($category_info['image'], 200, 200, 'h'));
            } else {
                $data['thumb'] = '';
            }
            
            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $this->theme->setOgDescription(html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8'));
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['categories'] = array();
            
            $results = $this->model_content_category->getCategories($category_id);
            
            foreach ($results as $result) {
                $filter = array('filter_category_id' => $result['category_id'], 'filter_sub_category' => true);
                
                $post_total = $this->model_content_post->getTotalPosts($filter);
                
                if ($result['image']):
                    $img = $this->model_tool_image->resize($result['image'], 189, 142, 'h');
                else:
                    $img = IMAGE_URL . 'placeholder.png';
                endif;
                
                $data['categories'][] = array('name' => $result['name'] . ($this->config->get('config_post_count') ? ' (' . $post_total . ')' : ''), 'href' => $this->url->link('content/category', 'bpath=' . $this->request->get['bpath'] . '_' . $result['category_id'] . $url), 'pic' => $img);
                
                unset($filter);
            }
            
            $data['posts'] = array();
            
            $filter = array('filter_category_id' => $category_id, 'filter_sub_category' => true, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit);
            
            $post_total = $this->model_content_post->getTotalPosts($filter);
            $results = $this->model_content_post->getPosts($filter);
            
            unset($filter);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = IMAGE_URL . $result['image'];
                     // remove resizing and allow img-responsive to handle sizing
                    
                } else {
                    $image = '';
                }
                
                if ($this->config->get('blog_comment_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }
                
                $categories = $this->model_content_category->getCategoriesByPostId($result['post_id']);
                
                $posted_in = array();
                $posted_in_categories = '';
                
                if ($categories) {
                    foreach ($categories as $category) {
                        $posted_in[] = sprintf($this->language->get('lang_text_posted_categories'), $category['href'], $category['name']);
                    }
                }
                
                if (!empty($posted_in)):
                    $posted_in_categories = implode(", ", $posted_in);
                endif;
                
                $comment_text = ($result['comments'] == 1) ? rtrim($this->language->get('lang_text_comments'), 's') : $this->language->get('lang_text_comments');
                
                $data['posts'][] = array('post_id' => $result['post_id'], 'author_name' => $result['author_name'], 'thumb' => $image, 'name' => $result['name'], 'short' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 450) . '..', 'blurb' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..', 'rating' => $rating, 'views' => sprintf($this->language->get('lang_text_views'), (int)$result['viewed']), 'comments' => sprintf($comment_text, (int)$result['comments']), 'href' => $this->url->link('content/post', 'bpath=' . $this->request->get['bpath'] . '&post_id=' . $result['post_id']), 'comments_href' => $this->url->link('content/post', 'post_id=' . $result['post_id'] . '&to_comments=1'), 'author_href' => $this->url->link('content/search', '&filter_author_id=' . $result['author_id']), 'date_added' => date($this->language->get('lang_post_date'), strtotime($result['date_added'])), 'categories' => $posted_in_categories);
            }
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['pagination'] = $this->theme->paginate($post_total, $page, $limit, $this->language->get('lang_text_pagination'), $this->url->link('content/category', 'bpath=' . $this->request->get['bpath'] . $url . '&page={page}'));
            
            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;
            
            $data['continue'] = $this->url->link('content/home');
            
            // Search
            
            if (isset($this->request->get['filter_name'])) {
                $data['filter_name'] = $this->request->get['filter_name'];
            } else {
                $data['filter_name'] = '';
            }
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('content/category', $data));
        } else {
            $url = '';
            
            if (isset($this->request->get['bpath'])) {
                $url.= '&bpath=' . $this->request->get['bpath'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $this->breadcrumb->add('lang_text_error', 'content/category', $url);
            
            $this->theme->setTitle($this->language->get('lang_text_error'));
            
            $data['heading_title'] = $this->language->get('lang_text_error');
            
            $data['continue'] = $this->url->link('content/home');
            
            // Search
            
            if (isset($this->request->get['filter_name'])) {
                $data['filter_name'] = $this->request->get['filter_name'];
            } else {
                $data['filter_name'] = '';
            }
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('error/notfound', $data));
        }
    }
}
