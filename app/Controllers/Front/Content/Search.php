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

class Search extends Controller {
    public function index() {
        $data = Theme::language('content/search');
        
        Theme::model('content/category');
        Theme::model('content/post');
        Theme::model('tool/image');
        
        if (Theme::getStyle() === 'shop'):
            Breadcrumb::add(Config::get('config_name'), 'content/home');
        endif;
        
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = '';
        }
        
        if (isset($this->request->get['filter_tag'])) {
            $filter_tag = $this->request->get['filter_tag'];
        } else {
            $filter_tag = '';
        }
        
        if (isset($this->request->get['filter_description'])) {
            $filter_description = $this->request->get['filter_description'];
        } else {
            $filter_description = '';
        }
        
        if (isset($this->request->get['filter_category_id'])) {
            $filter_category_id = $this->request->get['filter_category_id'];
        } else {
            $filter_category_id = 0;
        }
        
        if (isset($this->request->get['filter_sub_category'])) {
            $filter_sub_category = $this->request->get['filter_sub_category'];
        } else {
            $filter_sub_category = '';
        }
        
        if (isset($this->request->get['filter_author_id'])) {
            $filter_author_id = $this->request->get['filter_author_id'];
        } else {
            $filter_author_id = '';
        }
        
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
            $limit = Config::get('config_catalog_limit');
        }
        
        if (isset($this->request->get['filter_name'])) {
            Theme::setTitle(Lang::get('lang_heading_title') . ' - ' . $this->request->get['filter_name']);
        } else {
            Theme::setTitle(Lang::get('lang_heading_title'));
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_tag'])) {
            $url.= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_description'])) {
            $url.= '&filter_description=' . $this->request->get['filter_description'];
        }
        
        if (isset($this->request->get['filter_category_id'])) {
            $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
        }
        
        if (isset($this->request->get['filter_sub_category'])) {
            $url.= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
        }
        
        if (isset($this->request->get['filter_author_id'])) {
            $url.= '&filter_author_id=' . $this->request->get['filter_author_id'];
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
        
        Breadcrumb::add('lang_heading_title', 'content/search', $url);
        
        if (isset($this->request->get['filter_name'])) {
            $data['heading_title'] = Lang::get('lang_heading_title') . ' - ' . $this->request->get['filter_name'];
        } else {
            $data['heading_title'] = Lang::get('lang_heading_title');
        }
        
        Theme::model('content/category');
        
        // 3 Level Category Search
        $data['categories'] = array();
        
        $categories_1 = $this->model_content_category->getCategories(0);
        
        foreach ($categories_1 as $category_1) {
            $level_2_data = array();
            
            $categories_2 = $this->model_content_category->getCategories($category_1['category_id']);
            
            foreach ($categories_2 as $category_2) {
                $level_3_data = array();
                
                $categories_3 = $this->model_content_category->getCategories($category_2['category_id']);
                
                foreach ($categories_3 as $category_3) {
                    $level_3_data[] = array('category_id' => $category_3['category_id'], 'name' => $category_3['name'],);
                }
                
                $level_2_data[] = array('category_id' => $category_2['category_id'], 'name' => $category_2['name'], 'children' => $level_3_data);
            }
            
            $data['categories'][] = array('category_id' => $category_1['category_id'], 'name' => $category_1['name'], 'children' => $level_2_data);
        }
        
        $data['posts'] = array();
        
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag']) || isset($this->request->get['filter_author_id']) || isset($this->request->get['filter_category_id'])) {
            
            $filter = array('filter_name' => $filter_name, 'filter_tag' => $filter_tag, 'filter_description' => $filter_description, 'filter_category_id' => $filter_category_id, 'filter_sub_category' => $filter_sub_category, 'filter_author_id' => $filter_author_id, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit);
            
            $post_total = $this->model_content_post->getTotalPosts($filter);
            $results = $this->model_content_post->getPosts($filter);
            
            foreach ($results as $result) {
                $categories = $this->model_content_category->getCategoriesByPostId($result['post_id']);
                
                $posted_in = array();
                $posted_in_categories = '';
                
                if ($categories) {
                    foreach ($categories as $category) {
                        $posted_in[] = sprintf(Lang::get('lang_text_posted_categories'), $category['href'], $category['name']);
                    }
                }
                
                if (!empty($posted_in)):
                    $posted_in_categories = implode(", ", $posted_in);
                endif;
                
                $comment_text = ($result['comments'] == 1) ? rtrim(Lang::get('lang_text_comments'), 's') : Lang::get('lang_text_comments');
                
                $data['posts'][] = array('post_id' => $result['post_id'], 'author_name' => $result['author_name'], 'name' => $result['name'], 'blurb' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..', 'views' => sprintf(Lang::get('lang_text_views'), (int)$result['viewed']), 'comments' => sprintf($comment_text, (int)$result['comments']), 'href' => Url::link('content/post', 'post_id=' . $result['post_id']), 'author_href' => Url::link('content/search', '&filter_author_id=' . $result['author_id']), 'date_added' => date(Lang::get('lang_post_date'), strtotime($result['date_added'])), 'categories' => $posted_in_categories);
            }
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_tag'])) {
                $url.= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_description'])) {
                $url.= '&filter_description=' . $this->request->get['filter_description'];
            }
            
            if (isset($this->request->get['filter_category_id'])) {
                $url.= '&filter_category_id=' . $this->request->get['filter_category_id'];
            }
            
            if (isset($this->request->get['filter_sub_category'])) {
                $url.= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
            }
            
            if (isset($this->request->get['filter_author_id'])) {
                $url.= '&filter_author_id=' . $this->request->get['filter_author_id'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['pagination'] = Theme::paginate($post_total, $page, $limit, Lang::get('lang_text_pagination'), Url::link('content/search', $url . '&page={page}'));
        }
        
        $data['filter_name'] = $filter_name;
        $data['filter_tag'] = $filter_tag;
        $data['filter_description'] = $filter_description;
        $data['filter_category_id'] = $filter_category_id;
        $data['filter_sub_category'] = $filter_sub_category;
        $data['filter_author_id'] = $filter_author_id;
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['limit'] = $limit;
        
        Theme::loadjs('javascript/content/search', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('content/search', $data));
    }
}
