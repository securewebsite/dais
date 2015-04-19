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

namespace Front\Controller\Catalog;
use Dais\Engine\Controller;

class Search extends Controller {
    public function index() {
        $data = $this->theme->language('catalog/search');
        
        $this->theme->model('catalog/category');
        $this->theme->model('catalog/product');
        $this->theme->model('tool/image');
        
        $this->javascript->register('storage.min', 'jquery.min');
        
        if (isset($this->request->get['search'])) {
            $search = $this->request->get['search'];
        } else {
            $search = '';
        }
        
        if (isset($this->request->get['tag'])) {
            $tag = $this->request->get['tag'];
        } else {
            $tag = '';
        }
        
        if (isset($this->request->get['description'])) {
            $description = $this->request->get['description'];
        } else {
            $description = '';
        }
        
        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        } else {
            $category_id = 0;
        }
        
        if (isset($this->request->get['sub_category'])) {
            $sub_category = $this->request->get['sub_category'];
        } else {
            $sub_category = '';
        }
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
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
        
        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }
        
        if (isset($this->request->get['search'])) {
            $this->theme->setTitle($this->language->get('lang_heading_title') . ' - ' . $this->request->get['search']);
        } else {
            $this->theme->setTitle($this->language->get('lang_heading_title'));
        }
        
        $url = '';
        
        if (isset($this->request->get['search'])) {
            $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['tag'])) {
            $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['description'])) {
            $url.= '&description=' . $this->request->get['description'];
        }
        
        if (isset($this->request->get['category_id'])) {
            $url.= '&category_id=' . $this->request->get['category_id'];
        }
        
        if (isset($this->request->get['sub_category'])) {
            $url.= '&sub_category=' . $this->request->get['sub_category'];
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
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/search', $url);
        
        if (isset($this->request->get['search'])) {
            $data['heading_title'] = $this->language->get('lang_heading_title') . ' - ' . $this->request->get['search'];
        } else {
            $data['heading_title'] = $this->language->get('lang_heading_title');
        }
        
        $data['text_compare'] = sprintf($this->language->get('lang_text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        
        $data['compare'] = $this->url->link('catalog/compare');
        
        $this->theme->model('catalog/category');
        
        // 3 Level Category Search
        $data['categories'] = array();
        
        $categories_1 = $this->model_catalog_category->getCategories(0);
        
        foreach ($categories_1 as $category_1) {
            $level_2_data = array();
            
            $categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
            
            foreach ($categories_2 as $category_2) {
                $level_3_data = array();
                
                $categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
                
                foreach ($categories_3 as $category_3) {
                    $level_3_data[] = array(
                        'category_id' => $category_3['category_id'], 
                        'name'        => $category_3['name']
                    );
                }
                
                $level_2_data[] = array(
                    'category_id' => $category_2['category_id'], 
                    'name'        => $category_2['name'], 
                    'children'    => $level_3_data
                );
            }
            
            $data['categories'][] = array(
                'category_id' => $category_1['category_id'], 
                'name'        => $category_1['name'], 
                'children'    => $level_2_data
            );
        }
        
        $data['image_width'] = $this->config->get('config_image_product_width');
        
        $data['products'] = array();
        
        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $filter = array(
                'filter_name'         => $search, 
                'filter_tag'          => $tag, 
                'filter_description'  => $description, 
                'filter_category_id'  => $category_id, 
                'filter_sub_category' => $sub_category, 
                'sort'                => $sort, 
                'order'               => $order, 
                'start'               => ($page - 1) * $limit, 
                'limit'               => $limit
            );
            
            $product_total = $this->model_catalog_product->getTotalProducts($filter);
            
            $results = $this->model_catalog_product->getProducts($filter);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                } else {
                    $image = false;
                }
                
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }
                
                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                } else {
                    $tax = false;
                }
                
                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }
                
                $data['products'][] = array(
                    'product_id'  => $result['product_id'], 
                    'event_id'    => $result['event_id'], 
                    'thumb'       => $image, 
                    'name'        => $result['name'], 
                    'description' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..', 
                    'price'       => $price, 
                    'special'     => $special, 
                    'tax'         => $tax, 
                    'rating'      => $rating, 
                    'reviews'     => sprintf($this->language->get('lang_text_reviews'), (int)$result['reviews']), 
                    'href'        => $this->url->link('catalog/product', 'product_id=' . $result['product_id'])
                );
            }
            
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['sorts'] = array();
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_default'), 
                'value' => 'p.sort_order-ASC', 
                'href'  => $this->url->link('catalog/search', 'sort=p.sort_order&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_name_asc'), 
                'value' => 'pd.name-ASC', 
                'href'  => $this->url->link('catalog/search', 'sort=pd.name&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_name_desc'), 
                'value' => 'pd.name-DESC', 
                'href'  => $this->url->link('catalog/search', 'sort=pd.name&order=DESC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_price_asc'), 
                'value' => 'p.price-ASC', 
                'href'  => $this->url->link('catalog/search', 'sort=p.price&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_price_desc'), 
                'value' => 'p.price-DESC', 
                'href'  => $this->url->link('catalog/search', 'sort=p.price&order=DESC' . $url)
            );
            
            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text'  => $this->language->get('lang_text_rating_desc'), 
                    'value' => 'rating-DESC', 
                    'href'  => $this->url->link('catalog/search', 'sort=rating&order=DESC' . $url)
                );
                
                $data['sorts'][] = array(
                    'text'  => $this->language->get('lang_text_rating_asc'), 
                    'value' => 'rating-ASC', 
                    'href'  => $this->url->link('catalog/search', 'sort=rating&order=ASC' . $url)
                );
            }
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_model_asc'), 
                'value' => 'p.model-ASC', 
                'href'  => $this->url->link('catalog/search', 'sort=p.model&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => $this->language->get('lang_text_model_desc'), 
                'value' => 'p.model-DESC', 
                'href'  => $this->url->link('catalog/search', 'sort=p.model&order=DESC' . $url)
            );
            
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            $data['limits'] = array();
            
            $limits = array_unique(array($this->config->get('config_catalog_limit'), 32, 64, 88, 112));
            
            sort($limits);
            
            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text'  => $value, 
                    'value' => $value, 
                    'href'  => $this->url->link('catalog/search', $url . '&limit=' . $value)
                );
            }
            
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['pagination'] = $this->theme->paginate(
                $product_total, 
                $page, 
                $limit, 
                $this->language->get('lang_text_pagination'), 
                $this->url->link('catalog/search', $url . '&page={page}')
            );
        }
        
        $data['search']       = ($tag) ? $tag : $search;
        $data['description']  = $description;
        $data['category_id']  = $category_id;
        $data['sub_category'] = $sub_category;
        
        $data['sort']         = $sort;
        $data['order']        = $order;
        $data['limit']        = $limit;
        
        $cookie = 'list';
        
        if (isset($this->request->cookie['display'])):
            $cookie = $this->request->cookie['display'];
        endif;
        
        $data['display'] = $cookie;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/search', $data));
    }
}
