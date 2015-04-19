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

class Category extends Controller {
    public function index() {
        $data = $this->theme->language('catalog/category');
        
        $this->theme->model('catalog/category');
        $this->theme->model('catalog/product');
        $this->theme->model('tool/image');
        
        $this->javascript->register('storage.min', 'jquery.min');
        
        if (isset($this->request->get['filter'])) {
            $category_filter = $this->request->get['filter'];
        } else {
            $category_filter = '';
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
        
        if (isset($this->request->get['path'])) {
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
            
            $path = '';
            
            $parts = explode('_', (string)$this->request->get['path']);
            
            $category_id = (int)array_pop($parts);
            
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path.= '_' . (int)$path_id;
                }
                
                $category_info = $this->model_catalog_category->getCategory($path_id);
                
                if ($category_info) {
                    $this->breadcrumb->add($category_info['name'], 'catalog/category', 'path=' . $path . $url);
                }
            }
        } else {
            $category_id = 0;
        }
        
        $category_info = $this->model_catalog_category->getCategory($category_id);
        
        if ($category_info) {
            $this->theme->setTitle($category_info['name']);
            $this->theme->setDescription($category_info['meta_description']);
            $this->theme->setKeywords($category_info['meta_keyword']);
            
            $this->theme->setOgType('product.group');
            
            $data['heading_title'] = $category_info['name'];
            
            $data['text_compare'] = sprintf($this->language->get('lang_text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            
            // Set the last category breadcrumb
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
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $this->breadcrumb->add($category_info['name'], 'catalog/category', 'path=' . $this->request->get['path']);
            
            if ($category_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                $this->theme->setOgImage($this->model_tool_image->resize($category_info['image'], 200, 200, 'h'));
            } else {
                $data['thumb'] = false;
            }
            
            if ($category_info['description']):
                $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
                $this->theme->setOgDescription(html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8'));
            else:
                $data['description'] = false;
            endif;
            
            $data['compare'] = $this->url->link('catalog/compare');
            
            $url = '';
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
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

            $data['tags'] = false;

            if (isset($category_info['tag'])):
                $tags = explode(',', $category_info['tag']);
                
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => $this->url->link('search/tag', 'tag=' . trim($tag))
                    );
                endforeach;
            endif;
            
            $data['categories'] = array();
            
            $results = $this->model_catalog_category->getCategories($category_id);
            
            foreach ($results as $result) {
                $filter = array('filter_category_id' => $result['category_id'], 'filter_sub_category' => true);
                
                $show_product = '';
                
                if ($this->config->get('config_product_count')):
                    $product_total = $this->model_catalog_product->getTotalProducts($filter);
                    $show_product = ' (' . $product_total . ')';
                endif;
                
                $data['categories'][] = array('name' => $result['name'] . $show_product, 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url));
            }
            
            $data['products'] = array();
            
            $filter = array('filter_category_id' => $category_id, 'filter_filter' => $category_filter, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit);
            
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
                
                $data['products'][] = array('product_id' => $result['product_id'], 'event_id' => $result['event_id'], 'thumb' => $image, 'name' => $result['name'], 'description' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..', 'price' => $price, 'special' => $special, 'tax' => $tax, 'rating' => $rating, 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$result['reviews']), 'href' => $this->url->link('catalog/product', 'product_id=' . $result['product_id'] . $url));
            }
            
            $url = '';
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['sorts'] = array();
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_default'), 'value' => 'p.sort_order-ASC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_name_asc'), 'value' => 'pd.name-ASC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_name_desc'), 'value' => 'pd.name-DESC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url));
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_price_asc'), 'value' => 'p.price-ASC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_price_desc'), 'value' => 'p.price-DESC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url));
            
            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array('text' => $this->language->get('lang_text_rating_desc'), 'value' => 'rating-DESC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url));
                
                $data['sorts'][] = array('text' => $this->language->get('lang_text_rating_asc'), 'value' => 'rating-ASC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url));
            }
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_model_asc'), 'value' => 'p.model-ASC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_model_desc'), 'value' => 'p.model-DESC', 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url));
            
            $data['image_width'] = $this->config->get('config_image_product_width');
            
            $url = '';
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
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
                $data['limits'][] = array('text' => $value, 'value' => $value, 'href' => $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value));
            }
            
            $url = '';
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
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
            
            $data['pagination'] = $this->theme->paginate($product_total, $page, $limit, $this->language->get('lang_text_pagination'), $this->url->link('catalog/category', 'path=' . $this->request->get['path'] . $url . '&page={page}'));
            
            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;
            
            $data['continue'] = $this->url->link('shop/home');
            
            $cookie = 'list';
            
            if (isset($this->request->cookie['display'])):
                $cookie = $this->request->cookie['display'];
            endif;
            
            $data['display'] = $cookie;
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $this->theme->set_controller('header', 'shop/header');
            $this->theme->set_controller('footer', 'shop/footer');
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('catalog/category', $data));
        } else {
            $url = '';
            
            if (isset($this->request->get['path'])) {
                $url.= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
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
            
            $this->breadcrumb->add('lang_text_error', 'catalog/category', $url);
            
            $this->theme->setTitle($this->language->get('lang_text_error'));
            
            $data['heading_title'] = $this->language->get('lang_text_error');
            
            $data['continue'] = $this->url->link('shop/home');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $this->theme->set_controller('header', 'shop/header');
            $this->theme->set_controller('footer', 'shop/footer');
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('error/notfound', $data));
        }
    }
}
