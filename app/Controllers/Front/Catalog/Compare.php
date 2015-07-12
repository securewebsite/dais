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
        
        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }
        
        if (isset($this->request->get['remove'])) {
            $key = array_search($this->request->get['remove'], $this->session->data['compare']);
            
            if ($key !== false) {
                unset($this->session->data['compare'][$key]);
            }
            
            $this->session->data['success'] = Lang::get('lang_text_remove');
            
            $this->response->redirect(Url::link('catalog/compare'));
        }
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_heading_title', 'catalog/compare');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['review_status'] = Config::get('config_review_status');
        
        $data['products'] = array();
        
        $data['attribute_groups'] = array();
        
        foreach ($this->session->data['compare'] as $key => $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], Config::get('config_image_compare_width'), Config::get('config_image_compare_height'));
                } else {
                    $image = false;
                }
                
                if ((Config::get('config_customer_price') && $this->customer->isLogged()) || !Config::get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], Config::get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], Config::get('config_tax')));
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
                
                $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
                
                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }
                
                $data['products'][$product_id] = array('product_id' => $product_info['product_id'], 'event_id' => $product_info['event_id'], 'name' => $product_info['name'], 'thumb' => $image, 'price' => $price, 'special' => $special, 'description' => $this->encode->substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..', 'model' => $product_info['model'], 'manufacturer' => $product_info['manufacturer'], 'availability' => $availability, 'rating' => (int)$product_info['rating'], 'reviews' => sprintf(Lang::get('lang_text_reviews'), (int)$product_info['reviews']), 'weight' => $this->weight->format($product_info['weight'], $product_info['weight_class_id']), 'length' => $this->length->format($product_info['length'], $product_info['length_class_id']), 'width' => $this->length->format($product_info['width'], $product_info['length_class_id']), 'height' => $this->length->format($product_info['height'], $product_info['length_class_id']), 'attribute' => $attribute_data, 'href' => Url::link('catalog/product', 'product_id=' . $product_id), 'remove' => Url::link('catalog/compare', 'remove=' . $product_id));
                
                foreach ($attribute_groups as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];
                    
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
            } else {
                unset($this->session->data['compare'][$key]);
            }
        }
        
        $data['continue'] = Url::link('shop/home');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('catalog/compare', $data));
    }
    
    public function add() {
        Theme::language('catalog/compare');
        
        $json = array();
        
        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        Theme::model('catalog/product');
        
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
        if ($product_info) {
            if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
                if (count($this->session->data['compare']) >= 4) {
                    array_shift($this->session->data['compare']);
                }
                
                $this->session->data['compare'][] = $this->request->post['product_id'];
            }
            
            $json['success'] = sprintf(Lang::get('lang_text_success'), Url::link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], Url::link('catalog/compare'));
            
            $json['total'] = sprintf(Lang::get('lang_text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
