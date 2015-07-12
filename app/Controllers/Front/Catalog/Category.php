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

namespace App\Controllers\Front\Catalog;
use App\Controllers\Controller;

class Category extends Controller {
    public function index() {
        $data = Theme::language('catalog/category');
        
        Theme::model('catalog/category');
        Theme::model('catalog/product');
        Theme::model('tool/image');
        
        JS::register('storage.min', 'jquery.min');
        
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
            $limit = Config::get('config_catalog_limit');
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
                    Breadcrumb::add($category_info['name'], 'catalog/category', 'path=' . $path . $url);
                }
            }
        } else {
            $category_id = 0;
        }
        
        $category_info = $this->model_catalog_category->getCategory($category_id);
        
        if ($category_info) {
            Theme::setTitle($category_info['name']);
            Theme::setDescription($category_info['meta_description']);
            Theme::setKeywords($category_info['meta_keyword']);
            
            Theme::setOgType('product.group');
            
            $data['heading_title'] = $category_info['name'];
            
            $data['text_compare'] = sprintf(Lang::get('lang_text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            
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
            
            Breadcrumb::add($category_info['name'], 'catalog/category', 'path=' . $this->request->get['path']);
            
            if ($category_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], Config::get('config_image_category_width'), Config::get('config_image_category_height'));
                Theme::setOgImage($this->model_tool_image->resize($category_info['image'], 200, 200, 'h'));
            } else {
                $data['thumb'] = false;
            }
            
            if ($category_info['description']):
                $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
                Theme::setOgDescription(html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8'));
            else:
                $data['description'] = false;
            endif;
            
            $data['compare'] = Url::link('catalog/compare');
            
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

            if (!empty($category_info['tag'])):
                $tags = explode(',', $category_info['tag']);
                
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => Url::link('search/search', 'search=' . trim($tag))
                    );
                endforeach;
            endif;
            
            $data['categories'] = array();
            
            $results = $this->model_catalog_category->getCategories($category_id);
            
            foreach ($results as $result) {
                $filter = array(
                    'filter_category_id'  => $result['category_id'], 
                    'filter_sub_category' => true
                );
                
                $show_product = '';
                
                if (Config::get('config_product_count')):
                    $product_total = $this->model_catalog_product->getTotalProducts($filter);
                    $show_product  = ' (' . $product_total . ')';
                endif;
                
                $data['categories'][] = array(
                    'name' => $result['name'] . $show_product, 
                    'href' => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                );
            }
            
            $data['products'] = array();
            
            $filter = array(
                'filter_category_id' => $category_id, 
                'filter_filter'      => $category_filter, 
                'sort'               => $sort, 
                'order'              => $order, 
                'start'              => ($page - 1) * $limit, 
                'limit'              => $limit
            );
            
            $product_total = $this->model_catalog_product->getTotalProducts($filter);
            $results       = $this->model_catalog_product->getProducts($filter);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], Config::get('config_image_product_width'), Config::get('config_image_product_height'));
                } else {
                    $image = false;
                }
                
                if ((Config::get('config_customer_price') && $this->customer->isLogged()) || !Config::get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], Config::get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], Config::get('config_tax')));
                } else {
                    $special = false;
                }
                
                if (Config::get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                } else {
                    $tax = false;
                }
                
                if (Config::get('config_review_status')) {
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
                    'reviews'     => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 
                    'href'        => Url::link('catalog/product', 'product_id=' . $result['product_id'] . $url)
                );
            }
            
            $url = '';
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }
            
            $data['sorts'] = array();
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_default'), 
                'value' => 'p.sort_order-ASC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_name_asc'), 
                'value' => 'pd.name-ASC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_name_desc'), 
                'value' => 'pd.name-DESC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_price_asc'), 
                'value' => 'p.price-ASC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_price_desc'), 
                'value' => 'p.price-DESC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
            );
            
            if (Config::get('config_review_status')) {
                $data['sorts'][] = array(
                    'text'  => Lang::get('lang_text_rating_desc'), 
                    'value' => 'rating-DESC', 
                    'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                );
                
                $data['sorts'][] = array(
                    'text'  => Lang::get('lang_text_rating_asc'), 
                    'value' => 'rating-ASC', 
                    'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                );
            }
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_model_asc'), 
                'value' => 'p.model-ASC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_model_desc'), 
                'value' => 'p.model-DESC', 
                'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
            );
            
            $data['image_width'] = Config::get('config_image_product_width');
            
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
            
            $limits = array_unique(array(
                Config::get('config_catalog_limit'), 
                32, 
                64, 
                88, 
                112
            ));
            
            sort($limits);
            
            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text'  => $value, 
                    'value' => $value, 
                    'href'  => Url::link('catalog/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                );
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
            
            $data['pagination'] = Theme::paginate(
                $product_total, 
                $page, 
                $limit, 
                Lang::get('lang_text_pagination'), 
                Url::link('catalog/category', 'path=' . $this->request->get['path'] . $url . '&page={page}')
            );
            
            $data['sort']  = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;
            
            $data['continue'] = Url::link('shop/home');
            
            $cookie = 'list';
            
            if (isset($this->request->cookie['display'])):
                $cookie = $this->request->cookie['display'];
            endif;
            
            $data['display'] = $cookie;
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('catalog/category', $data));
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
            
            Breadcrumb::add('lang_text_error', 'catalog/category', $url);
            
            Theme::setTitle(Lang::get('lang_text_error'));
            
            $data['heading_title'] = Lang::get('lang_text_error');
            
            $data['continue'] = Url::link('shop/home');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('error/not_found', $data));
        }
    }
}
