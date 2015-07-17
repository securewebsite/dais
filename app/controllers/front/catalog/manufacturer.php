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

class Manufacturer extends Controller {
    
    public function index() {
        $data = Theme::language('catalog/manufacturer');
        
        Theme::model('catalog/manufacturer');
        Theme::model('tool/image');
        
        JS::register('storage.min', 'jquery.min');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_brand', 'catalog/manufacturer');
        
        $data['categories'] = array();
        
        $results = CatalogManufacturer::getManufacturers();
        
        foreach ($results as $result) {
            if (is_numeric(Encode::substr($result['name'], 0, 1))) {
                $key = '0 - 9';
            } else {
                $key = Encode::substr(Encode::strtoupper($result['name']), 0, 1);
            }
            
            if (!isset($data['manufacturers'][$key])) {
                $data['categories'][$key]['name'] = $key;
            }
            
            $data['categories'][$key]['manufacturer'][] = array('name' => $result['name'], 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']));
        }
        
        $data['continue'] = Url::link('shop/home');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('catalog/manufacturer_list', $data));
    }
    
    public function info() {
        $data = Theme::language('catalog/manufacturer');
        
        Theme::model('catalog/manufacturer');
        Theme::model('catalog/product');
        Theme::model('tool/image');
        
        JS::register('storage.min', 'jquery.min');
        
        if (isset(Request::p()->get['manufacturer_id'])) {
            $manufacturer_id = (int)Request::p()->get['manufacturer_id'];
        } else {
            $manufacturer_id = 0;
        }
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'ASC';
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
        
        Breadcrumb::add('lang_text_brand', 'catalog/manufacturer');
        
        $data['image_width'] = Config::get('config_image_product_width');
        
        $manufacturer_info = CatalogManufacturer::getManufacturer($manufacturer_id);
        
        if ($manufacturer_info) {
            Theme::setTitle($manufacturer_info['name']);
            
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
            
            Breadcrumb::add($manufacturer_info['name'], 'catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . $url);
            
            $data['heading_title'] = $manufacturer_info['name'];
            
            $data['text_compare'] = sprintf(Lang::get('lang_text_compare'), (isset(Session::p()->data['compare']) ? count(Session::p()->data['compare']) : 0));
            
            $data['compare'] = Url::link('catalog/compare');
            
            $data['products'] = array();
            
            $filter = array('filter_manufacturer_id' => $manufacturer_id, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit);
            
            $product_total = CatalogProduct::getTotalProducts($filter);
            
            $results = CatalogProduct::getProducts($filter);
            
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
                
                $data['products'][] = array('product_id' => $result['product_id'], 'event_id' => $result['event_id'], 'thumb' => $image, 'name' => $result['name'], 'description' => Encode::substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..', 'price' => $price, 'special' => $special, 'tax' => $tax, 'rating' => $rating, 'reviews' => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 'href' => Url::link('catalog/product', 'product_id=' . $result['product_id'] . $url));
            }
            
            $url = '';
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            $data['sorts'] = array();
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_default'), 'value' => 'p.sort_order-ASC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_name_asc'), 'value' => 'pd.name-ASC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=pd.name&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_name_desc'), 'value' => 'pd.name-DESC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=pd.name&order=DESC' . $url));
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_price_asc'), 'value' => 'p.price-ASC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=p.price&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_price_desc'), 'value' => 'p.price-DESC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=p.price&order=DESC' . $url));
            
            if (Config::get('config_review_status')) {
                $data['sorts'][] = array('text' => Lang::get('lang_text_rating_desc'), 'value' => 'rating-DESC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=rating&order=DESC' . $url));
                
                $data['sorts'][] = array('text' => Lang::get('lang_text_rating_asc'), 'value' => 'rating-ASC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=rating&order=ASC' . $url));
            }
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_model_asc'), 'value' => 'p.model-ASC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=p.model&order=ASC' . $url));
            
            $data['sorts'][] = array('text' => Lang::get('lang_text_model_desc'), 'value' => 'p.model-DESC', 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . '&sort=p.model&order=DESC' . $url));
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            $data['limits'] = array();
            
            $limits = array_unique(array(Config::get('config_catalog_limit'), 32, 64, 88, 112));
            
            sort($limits);
            
            foreach ($limits as $value) {
                $data['limits'][] = array('text' => $value, 'value' => $value, 'href' => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . $url . '&limit=' . $value));
            }
            
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
            
            $data['pagination'] = Theme::paginate($product_total, $page, $limit, Lang::get('lang_text_pagination'), Url::link('catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . $url . '&page={page}'));
            
            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;
            
            $cookie = 'list';
            
            if (isset(Request::p()->cookie['display'])):
                $cookie = Request::p()->cookie['display'];
            endif;
            
            $data['display'] = $cookie;
            
            $data['continue'] = Url::link('shop/home');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::render('catalog/manufacturer_info', $data));
        } else {
            $url = '';
            
            if (isset(Request::p()->get['manufacturer_id'])) {
                $url.= '&manufacturer_id=' . Request::p()->get['manufacturer_id'];
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
            
            Breadcrumb::add('lang_text_error', 'catalog/manufacturer', $url);
            
            Theme::setTitle(Lang::get('lang_text_error'));
            
            $data['heading_title'] = Lang::get('lang_text_error');
            
            $data['continue'] = Url::link('shop/home');
            
            Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::render('error/not_found', $data));
        }
    }
}
