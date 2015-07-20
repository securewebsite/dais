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
        
        if (isset(Request::p()->get['filter'])) {
            $category_filter = Request::p()->get['filter'];
        } else {
            $category_filter = '';
        }
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        if (isset(Request::p()->get['limit'])) {
            $limit = Request::p()->get['limit'];
        } else {
            $limit = Config::get('config_catalog_limit');
        }
        
        if (isset(Request::p()->get['path'])) {
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            $path = '';
            
            $parts = explode('_', (string)Request::p()->get['path']);
            
            $category_id = (int)array_pop($parts);
            
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path.= '_' . (int)$path_id;
                }
                
                $category_info = CatalogCategory::getCategory($path_id);
                
                if ($category_info) {
                    Breadcrumb::add($category_info['name'], 'catalog/category', 'path=' . $path . $url);
                }
            }
        } else {
            $category_id = 0;
        }
        
        $category_info = CatalogCategory::getCategory($category_id);
        
        if ($category_info) {
            Theme::setTitle($category_info['name']);
            Theme::setDescription($category_info['meta_description']);
            Theme::setKeywords($category_info['meta_keyword']);
            
            Theme::setOgType('product.group');
            
            $data['heading_title'] = $category_info['name'];
            
            $data['text_compare'] = sprintf(Lang::get('lang_text_compare'), (isset(Session::p()->data['compare']) ? count(Session::p()->data['compare']) : 0));
            
            // Set the last category breadcrumb
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            Breadcrumb::add($category_info['name'], 'catalog/category', 'path=' . Request::p()->get['path']);
            
            if ($category_info['image']) {
                $data['thumb'] = ToolImage::resize($category_info['image'], Config::get('config_image_category_width'), Config::get('config_image_category_height'));
                Theme::setOgImage(ToolImage::resize($category_info['image'], 200, 200, 'h'));
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
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
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
            
            $results = CatalogCategory::getCategories($category_id);
            
            foreach ($results as $result) {
                $filter = array(
                    'filter_category_id'  => $result['category_id'], 
                    'filter_sub_category' => true
                );
                
                $show_product = '';
                
                if (Config::get('config_product_count')):
                    $product_total = CatalogProduct::getTotalProducts($filter);
                    $show_product  = ' (' . $product_total . ')';
                endif;
                
                $data['categories'][] = array(
                    'name' => $result['name'] . $show_product, 
                    'href' => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '_' . $result['category_id'] . $url)
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
            
            $product_total = CatalogProduct::getTotalProducts($filter);
            $results       = CatalogProduct::getProducts($filter);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = ToolImage::resize($result['image'], Config::get('config_image_product_width'), Config::get('config_image_product_height'));
                } else {
                    $image = false;
                }
                
                if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                    $price = Currency::format(Tax::calculate($result['price'], $result['tax_class_id'], Config::get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$result['special']) {
                    $special = Currency::format(Tax::calculate($result['special'], $result['tax_class_id'], Config::get('config_tax')));
                } else {
                    $special = false;
                }
                
                if (Config::get('config_tax')) {
                    $tax = Currency::format((float)$result['special'] ? $result['special'] : $result['price']);
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
                    'description' => Encode::substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..', 
                    'price'       => $price, 
                    'special'     => $special, 
                    'tax'         => $tax, 
                    'rating'      => $rating, 
                    'reviews'     => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 
                    'href'        => Url::link('catalog/product', 'product_id=' . $result['product_id'] . $url)
                );
            }
            
            $url = '';
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            $data['sorts'] = array();
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_default'), 
                'value' => 'p.sort_order-asc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=p.sort_order&order=asc' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_name_asc'), 
                'value' => 'pd.name-asc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=pd.name&order=asc' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_name_desc'), 
                'value' => 'pd.name-desc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=pd.name&order=desc' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_price_asc'), 
                'value' => 'p.price-asc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=p.price&order=asc' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_price_desc'), 
                'value' => 'p.price-desc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=p.price&order=desc' . $url)
            );
            
            if (Config::get('config_review_status')) {
                $data['sorts'][] = array(
                    'text'  => Lang::get('lang_text_rating_desc'), 
                    'value' => 'rating-desc', 
                    'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=rating&order=desc' . $url)
                );
                
                $data['sorts'][] = array(
                    'text'  => Lang::get('lang_text_rating_asc'), 
                    'value' => 'rating-asc', 
                    'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=rating&order=asc' . $url)
                );
            }
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_model_asc'), 
                'value' => 'p.model-asc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=p.model&order=asc' . $url)
            );
            
            $data['sorts'][] = array(
                'text'  => Lang::get('lang_text_model_desc'), 
                'value' => 'p.model-desc', 
                'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . '&sort=p.model&order=desc' . $url)
            );
            
            $data['image_width'] = Config::get('config_image_product_width');
            
            $url = '';
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
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
                    'href'  => Url::link('catalog/category', 'path=' . Request::p()->get['path'] . $url . '&limit=' . $value)
                );
            }
            
            $url = '';
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            $data['pagination'] = Theme::paginate(
                $product_total, 
                $page, 
                $limit, 
                Lang::get('lang_text_pagination'), 
                Url::link('catalog/category', 'path=' . Request::p()->get['path'] . $url . '&page={page}')
            );
            
            $data['sort']  = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;
            
            $data['continue'] = Url::link('shop/home');
            
            $cookie = 'list';
            
            if (isset(Request::p()->cookie['display'])):
                $cookie = Request::p()->cookie['display'];
            endif;
            
            $data['display'] = $cookie;
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('catalog/category', $data));
        } else {
            $url = '';
            
            if (isset(Request::p()->get['path'])) {
                $url.= '&path=' . Request::p()->get['path'];
            }
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            Breadcrumb::add('lang_text_error', 'catalog/category', $url);
            
            Theme::setTitle(Lang::get('lang_text_error'));
            
            $data['heading_title'] = Lang::get('lang_text_error');
            
            $data['continue'] = Url::link('shop/home');
            
            Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('error/not_found', $data));
        }
    }
}
