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

class Compare extends Controller {
    
    public function index() {
        $data = Theme::language('catalog/compare');
        
        Theme::model('catalog/product');
        
        Theme::model('tool/image');
        
        if (!isset(Session::p()->data['compare'])) {
            Session::p()->data['compare'] = array();
        }
        
        if (isset(Request::p()->get['remove'])) {
            $key = array_search(Request::p()->get['remove'], Session::p()->data['compare']);
            
            if ($key !== false) {
                unset(Session::p()->data['compare'][$key]);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_remove');
            
            Response::redirect(Url::link('catalog/compare'));
        }
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_heading_title', 'catalog/compare');
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['review_status'] = Config::get('config_review_status');
        
        $data['products'] = array();
        
        $data['attribute_groups'] = array();
        
        foreach (Session::p()->data['compare'] as $key => $product_id) {
            $product_info = CatalogProduct::getProduct($product_id);
            
            if ($product_info) {
                if ($product_info['image']) {
                    $image = ToolImage::resize($product_info['image'], Config::get('config_image_compare_width'), Config::get('config_image_compare_height'));
                } else {
                    $image = false;
                }
                
                if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                    $price = Currency::format(Tax::calculate($product_info['price'], $product_info['tax_class_id'], Config::get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$product_info['special']) {
                    $special = Currency::format(Tax::calculate($product_info['special'], $product_info['tax_class_id'], Config::get('config_tax')));
                } else {
                    $special = false;
                }
                
                if ($product_info['quantity'] <= 0) {
                    $availability = $product_info['stock_status'];
                } elseif (Config::get('config_stock_display')) {
                    $availability = $product_info['quantity'];
                } else {
                    $availability = Lang::get('lang_text_instock');
                }
                
                $attribute_data = array();
                
                $attribute_groups = CatalogProduct::getProductAttributes($product_id);
                
                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }

                $data['products'][$product_id] = array(
                    'product_id'   => $product_info['product_id'], 
                    'event_id'     => $product_info['event_id'], 
                    'name'         => $product_info['name'], 
                    'thumb'        => $image, 
                    'price'        => $price, 
                    'special'      => $special, 
                    'description'  => Encode::substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..', 
                    'model'        => $product_info['model'], 
                    'manufacturer' => $product_info['manufacturer'], 
                    'availability' => $availability, 
                    'rating'       => (int)$product_info['rating'], 
                    'reviews'      => sprintf(Lang::get('lang_text_reviews'), (int)$product_info['reviews']), 
                    'weight'       => $this->weight->format($product_info['weight'], $product_info['weight_class_id']), 
                    'length'       => $this->length->format($product_info['length'], $product_info['length_class_id']), 
                    'width'        => $this->length->format($product_info['width'], $product_info['length_class_id']), 
                    'height'       => $this->length->format($product_info['height'], $product_info['length_class_id']), 
                    'attribute'    => $attribute_data, 
                    'href'         => Url::link('catalog/product', 'path=' . $product_info['paths'] . '&product_id=' . $product_id), 
                    'remove'       => Url::link('catalog/compare', 'remove=' . $product_id)
                );
                
                foreach ($attribute_groups as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];
                    
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
            } else {
                unset(Session::p()->data['compare'][$key]);
            }
        }
        
        $data['continue'] = Url::link('shop/home');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/compare', $data));
    }
    
    public function add() {
        Theme::language('catalog/compare');
        
        $json = array();
        
        if (!isset(Session::p()->data['compare'])) {
            Session::p()->data['compare'] = array();
        }
        
        if (isset(Request::p()->post['product_id'])) {
            $product_id = Request::p()->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        Theme::model('catalog/product');
        
        $product_info = CatalogProduct::getProduct($product_id);

        if ($product_info) {
            if (!in_array(Request::p()->post['product_id'], Session::p()->data['compare'])) {
                if (count(Session::p()->data['compare']) >= 4) {
                    array_shift(Session::p()->data['compare']);
                }
                
                Session::p()->data['compare'][] = $product_id;
            }
            
            $json['success'] = sprintf(Lang::get('lang_text_success'), Url::link('catalog/product', 'path=' . $product_info['paths'] . '&product_id=' . $product_id), $product_info['name'], Url::link('catalog/compare'));
            
            $json['total'] = sprintf(Lang::get('lang_text_compare'), (isset(Session::p()->data['compare']) ? count(Session::p()->data['compare']) : 0));
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
