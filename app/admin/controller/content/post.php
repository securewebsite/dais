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

class Post extends Controller {
    private $error = array();
    
    public function index() {
        $this->theme->language('content/post');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/post');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->theme->language('content/post');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/post');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_post->addPost($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
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
            
            $this->response->redirect($this->url->link('content/post', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->theme->language('content/post');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/post');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_post->editPost($this->request->get['post_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
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
            
            $this->response->redirect($this->url->link('content/post', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->theme->language('content/post');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/post');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $post_id) {
                $this->model_content_post->deletePost($post_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
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
            
            $this->response->redirect($this->url->link('content/post', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    private function getList() {
        $data = $this->theme->language('content/post');
        
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }
        
        if (isset($this->request->get['filter_author_id'])) {
            $filter_author_id = $this->request->get['filter_author_id'];
        } else {
            $filter_author_id = null;
        }
        
        if (isset($this->request->get['filter_category_id'])) {
            $filter_category_id = $this->request->get['filter_category_id'];
        } else {
            $filter_category_id = null;
        }
        
        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }
        
        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }
        
        if (isset($this->request->get['filter_date_modified'])) {
            $filter_date_modified = $this->request->get['filter_date_modified'];
        } else {
            $filter_date_modified = null;
        }
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.post_id';
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
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_author_id'])) {
            $url.= '&filter_author_id=' . $this->request->get['filter_author_id'];
        }
        
        if (isset($this->request->get['filter_category_id'])) {
            $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['filter_date_added'])) {
            $url.= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        
        if (isset($this->request->get['filter_date_modified'])) {
            $url.= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
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
        
        $this->breadcrumb->add('lang_heading_title', 'content/post');
        
        $data['insert'] = $this->url->link('content/post/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('content/post/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['posts'] = array();
        
        $filter = array(
            'filter_name'          => $filter_name, 
            'filter_author_id'     => $filter_author_id, 
            'filter_category_id'   => $filter_category_id, 
            'filter_sub_category'  => true, 
            'filter_status'        => $filter_status, 
            'filter_date_added'    => $filter_date_added, 
            'filter_date_modified' => $filter_date_modified, 
            'sort'                 => $sort, 
            'order'                => $order, 
            'start'                => ($page - 1) * $this->config->get('config_admin_limit'), 
            'limit'                => $this->config->get('config_admin_limit')
        );
        
        $this->theme->model('tool/image');
        
        $post_total = $this->model_content_post->getTotalPosts($filter);
        $results    = $this->model_content_post->getPosts($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_edit'), 
                'href' => $this->url->link('content/post/update', 'token=' . $this->session->data['token'] . '&post_id=' . $result['post_id'] . $url, 'SSL')
            );
            
            if ($result['image'] && file_exists($this->app['path.image'] . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', 40, 40);
            }
            
            $status = (!$result['status']) ? $this->language->get('lang_text_disabled') : (($result['status'] === 2) ? $this->language->get('lang_text_draft') : $this->language->get('lang_text_posted'));
            
            $data['posts'][] = array(
                'post_id'       => $result['post_id'], 
                'image'         => $image, 
                'name'          => $result['name'], 
                'author_id'     => $result['author_id'], 
                'author_name'   => $this->model_content_post->getPostAuthor($result['author_id']), 
                'category'      => implode(', ', $this->model_content_post->getPostCategoriesNames($result['post_id'])), 
                'date_added'    => date($this->language->get('lang_date_format_short'), strtotime($result['date_added'])), 
                'date_modified' => ($result['date_modified'] != '0000-00-00 00:00:00') ? date($this->language->get('lang_date_format_short'), strtotime($result['date_modified'])) : '-', 
                'viewed'        => $result['viewed'], 'status' => $status, 
                'selected'      => isset($this->request->post['selected']) && in_array($result['post_id'], $this->request->post['selected']), 
                'action'        => $action
            );
        }
        
        $data['token'] = $this->session->data['token'];
        
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
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_author_id'])) {
            $url.= '&filter_author_id=' . $this->request->get['filter_author_id'];
        }
        
        if (isset($this->request->get['filter_category_id'])) {
            $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['filter_date_added'])) {
            $url.= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        
        if (isset($this->request->get['filter_date_modified'])) {
            $url.= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $data['sort_name']          = $this->url->link('content/post', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
        $data['sort_status']        = $this->url->link('content/post', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
        $data['sort_viewed']        = $this->url->link('content/post', 'token=' . $this->session->data['token'] . '&sort=p.viewed' . $url, 'SSL');
        $data['sort_date_added']    = $this->url->link('content/post', 'token=' . $this->session->data['token'] . '&sort=p.date_added' . $url, 'SSL');
        $data['sort_date_modified'] = $this->url->link('content/post', 'token=' . $this->session->data['token'] . '&sort=p.date_modified' . $url, 'SSL');
        $data['sort_order']         = $this->url->link('content/post', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_author_id'])) {
            $url.= '&filter_author_id=' . $this->request->get['filter_author_id'];
        }
        
        if (isset($this->request->get['filter_category_id'])) {
            $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['filter_date_added'])) {
            $url.= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        
        if (isset($this->request->get['filter_date_modified'])) {
            $url.= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }

        $data['posted_by'] = $this->config->get('blog_posted_by');
        
        $data['pagination'] = $this->theme->paginate(
            $post_total, 
            $page, 
            $this->config->get('config_admin_limit'), 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('content/post', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data['filter_name']          = $filter_name;
        $data['filter_author_id']     = $filter_author_id;
        $data['filter_category_id']   = $filter_category_id;
        $data['filter_status']        = $filter_status;
        $data['filter_date_added']    = $filter_date_added;
        $data['filter_date_modified'] = $filter_date_modified;
        
        $data['authors'] = $this->model_content_post->getAuthors();
        
        $this->theme->model('content/category');
        
        $data['categories'] = $this->model_content_category->getCategories();
        
        $data['sort']  = $sort;
        $data['order'] = $order;

        $this->theme->loadjs('javascript/content/post_list', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/post_list', $data));
    }
    
    private function getForm() {
        $data = $this->theme->language('content/post');
        
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
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = array();
        }
        
        if (isset($this->error['meta_description'])) {
            $data['error_meta_description'] = $this->error['meta_description'];
        } else {
            $data['error_meta_description'] = array();
        }
        
        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = array();
        }
        
        if (isset($this->error['date_available'])) {
            $data['error_date_available'] = $this->error['date_available'];
        } else {
            $data['error_date_available'] = '';
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
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
        
        $this->breadcrumb->add('lang_heading_title', 'content/post');
        
        if (!isset($this->request->get['post_id'])) {
            $data['action'] = $this->url->link('content/post/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('content/post/update', 'token=' . $this->session->data['token'] . '&post_id=' . $this->request->get['post_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('content/post', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['post_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $post_info = $this->model_content_post->getPost($this->request->get['post_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['post_description'])) {
            $data['post_description'] = $this->request->post['post_description'];
        } elseif (isset($this->request->get['post_id'])) {
            $data['post_description'] = $this->model_content_post->getPostDescriptions($this->request->get['post_id']);
        } else {
            $data['post_description'] = array();
        }
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['post_store'])) {
            $data['post_store'] = $this->request->post['post_store'];
        } elseif (isset($this->request->get['post_id'])) {
            $data['post_store'] = $this->model_content_post->getPostStores($this->request->get['post_id']);
        } else {
            $data['post_store'] = array(0);
        }
        
        if (isset($this->request->post['slug'])) {
            $data['slug'] = $this->request->post['slug'];
        } elseif (!empty($post_info)) {
            $data['slug'] = $post_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset($this->request->post['author_id'])) {
            $data['author_id'] = $this->request->post['author_id'];
        } elseif (!empty($post_info)) {
            $data['author_id'] = $post_info['author_id'];
        } else {
            $data['author_id'] = $this->config->get('blog_default_author');
        }
        
        $authors = $this->model_content_post->getAuthors();

        $data['posted_by'] = $this->config->get('blog_posted_by');
        
        foreach ($authors as $author):
            if ($author['author_id'] === $data['author_id']):
                $data['author'] = $author['name'];
            else:
                $data['author'] = '';
            endif;
        endforeach;
        
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($post_info)) {
            $data['image'] = $post_info['image'];
        } else {
            $data['image'] = '';
        }
        
        $this->theme->model('tool/image');
        
        if (isset($this->request->post['image']) && file_exists($this->app['path.image'] . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($post_info) && $post_info['image'] && file_exists($this->app['path.image'] . $post_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($post_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        if (isset($this->request->post['date_available'])) {
            $data['date_available'] = $this->request->post['date_available'];
        } elseif (!empty($post_info)) {
            $data['date_available'] = date('Y-m-d', strtotime($post_info['date_available']));
        } else {
            $data['date_available'] = date('Y-m-d', time() - 86400);
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($post_info)) {
            $data['sort_order'] = $post_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }
        
        if (isset($this->request->post['visibility'])) {
            $data['visibility'] = $this->request->post['visibility'];
        } elseif (!empty($post_info)) {
            $data['visibility'] = $post_info['visibility'];
        } else {
            $data['visibility'] = 0;
        }
        
        $this->theme->model('people/customergroup');
        
        $data['customer_groups'] = $this->model_people_customergroup->getCustomerGroups();
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($post_info)) {
            $data['status'] = $post_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        if (isset($this->request->post['post_image'])) {
            $post_images = $this->request->post['product_image'];
        } elseif (isset($this->request->get['post_id'])) {
            $post_images = $this->model_content_post->getPostImages($this->request->get['post_id']);
        } else {
            $post_images = array();
        }
        
        $data['post_images'] = array();
        
        foreach ($post_images as $post_image) {
            if ($post_image['image'] && file_exists($this->app['path.image'] . $post_image['image'])) {
                $image = $post_image['image'];
            } else {
                $image = 'placeholder.png';
            }
            
            $data['post_images'][] = array('image' => $image, 'thumb' => $this->model_tool_image->resize($image, 100, 100), 'sort_order' => $post_image['sort_order']);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        $this->theme->model('content/category');
        
        $data['categories'] = $this->model_content_category->getCategories(0);
        
        if (isset($this->request->post['post_category'])) {
            $data['post_category'] = $this->request->post['post_category'];
        } elseif (isset($this->request->get['post_id'])) {
            $data['post_category'] = $this->model_content_post->getPostCategories($this->request->get['post_id']);
        } else {
            $data['post_category'] = array();
        }
        
        if (isset($this->request->post['post_related'])) {
            $posts = $this->request->post['post_related'];
        } elseif (isset($this->request->get['post_id'])) {
            $posts = $this->model_content_post->getPostRelated($this->request->get['post_id']);
        } else {
            $posts = array();
        }
        
        $data['posts_related'] = array();
        
        foreach ($posts as $post_id) {
            $related_info = $this->model_content_post->getPost($post_id);
            
            if ($related_info) {
                $data['posts_related'][] = array('post_id' => $related_info['post_id'], 'name' => $related_info['name']);
            }
        }
        
        if ($this->user->getGroupId() == $this->config->get('blog_admin_group_id')) {
            $data['is_admin_group'] = true;
        } else {
            $data['is_admin_group'] = false;
        }
        
        if (isset($this->request->post['post_layout'])) {
            $data['post_layout'] = $this->request->post['post_layout'];
        } elseif (isset($this->request->get['post_id'])) {
            $data['post_layout'] = $this->model_content_post->getPostLayouts($this->request->get['post_id']);
        } else {
            $data['post_layout'] = array();
        }
        
        $this->theme->loadjs('javascript/content/post_form', $data);
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/post_form', $data));
    }
    
    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'content/post')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['post_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 1) || ($this->encode->strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
            
            if (($this->encode->strlen($value['description']) < 5)) {
                $this->error['description'][$language_id] = $this->language->get('lang_error_description');
            }
        }
        
        if (isset($this->request->post['slug']) && $this->encode->strlen($this->request->post['slug']) > 0):
            $this->theme->model('tool/utility');
            $query = $this->model_tool_utility->findSlugByName($this->request->post['slug']);
            
            if (isset($this->request->get['post_id'])):
                if (isset($query)):
                    if ($query != 'post_id:' . $this->request->get['post_id']):
                        $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                    endif;
                endif;
            else:
                if (isset($query)):
                    $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                endif;
            endif;
        else:
            $this->error['slug'] = $this->language->get('lang_error_slug');
        endif;
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_warning');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'content/post')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_category_id'])) {
            $this->theme->model('content/post');
            
            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            
            if (isset($this->request->get['filter_category_id'])) {
                $filter_category_id = $this->request->get['filter_category_id'];
            } else {
                $filter_category_id = '';
            }
            
            if (isset($this->request->get['filter_sub_category'])) {
                $filter_sub_category = $this->request->get['filter_sub_category'];
            } else {
                $filter_sub_category = '';
            }
            
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 20;
            }
            
            $filter = array('filter_name' => $filter_name, 'filter_category_id' => $filter_category_id, 'filter_sub_category' => $filter_sub_category, 'start' => 0, 'limit' => $limit);
            
            $results = $this->model_content_post->getPosts($filter);
            
            foreach ($results as $result) {
                
                $json[] = array('post_id' => $result['post_id'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function autoauthor() {
        $json = array();
        
        $filter = array(
            'start'       => 0, 
            'limit'       => 20
        );
        
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_user_name'])):
            $this->theme->model('people/user');
            
            if (isset($this->request->get['filter_name'])) $filter['filter_name'] = $this->request->get['filter_name']; 
            if (isset($this->request->get['filter_user_name'])) $filter['filter_user_name'] = $this->request->get['filter_user_name'];
            
            $results = $this->model_people_user->getUsers($filter);
            
            foreach ($results as $result):
                if ($this->config->get('blog_posted_by') == 'lastname firstname'):
                    $name = $result['lastname'] . ' ' . $result['firstname'];
                else:
                    $name = $result['firstname'] . ' ' . $result['lastname'];
                endif;

                $json[] = array(
                    'user_id'   => $result['user_id'],
                    'user_name' => $result['user_name'],
                    'name'      => strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8'))
                );
            endforeach;
        endif;
        
        $sort_order = array();
        
        foreach ($json as $key => $value):
            $sort_order[$key] = $value['name'];
        endforeach;
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function slug() {
        $this->language->load('content/post');
        $this->theme->model('tool/utility');
        
        $json = array();
        
        if (!isset($this->request->get['name']) || $this->encode->strlen($this->request->get['name']) < 1):
            $json['error'] = $this->language->get('lang_error_name_first');
        else:
            
            // build slug
            $slug = $this->url->build_slug($this->request->get['name']);
            
            // check that the slug is globally unique
            $query = $this->model_tool_utility->findSlugByName($slug);
            
            if ($query):
                if (isset($this->request->get['post_id'])):
                    if ($query != 'post_id:' . $this->request->get['post_id']):
                        $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                    else:
                        $json['slug'] = $slug;
                    endif;
                else:
                    $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                endif;
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }

    public function description() {
        $json = array();

        if (isset($this->request->post['description']))
            $json['success'] = $this->keyword->getDescription($this->request->post['description']);

        $this->response->setOutput(json_encode($json));
    }

    public function keyword() {
        $json = array();

        if (isset($this->request->post['keywords'])):
            // let's clean up the data first
            $keywords        = $this->keyword->getDescription($this->request->post['keywords']);
            $json['success'] = $this->keyword->getKeywords($keywords);
        endif;

        $this->response->setOutput(json_encode($json));
    }
}
