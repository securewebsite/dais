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

class Compare extends Controller {
    public function index() {
        $data = $this->theme->language('catalog/compare');
        
        $this->theme->model('catalog/product');
        
        $this->theme->model('tool/image');
        
        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }
        
        if (isset($this->request->get['remove'])) {
            $key = array_search($this->request->get['remove'], $this->session->data['compare']);
            
            if ($key !== false) {
                unset($this->session->data['compare'][$key]);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_remove');
            
            $this->response->redirect($this->url->link('catalog/compare'));
        }
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/compare');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['review_status'] = $this->config->get('config_review_status');
        
        $data['products'] = array();
        
        $data['attribute_groups'] = array();
        
        foreach ($this->session->data['compare'] as $key => $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_compare_width'), $this->config->get('config_image_compare_height'));
                } else {
                    $image = false;
                }
                
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }
                
                if ($product_info['quantity'] <= 0) {
                    $availability = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $availability = $product_info['quantity'];
                } else {
                    $availability = $this->language->get('lang_text_instock');
                }
                
                $attribute_data = array();
                
                $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
                
                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }
                
                $data['products'][$product_id] = array('product_id' => $product_info['product_id'], 'event_id' => $product_info['event_id'], 'name' => $product_info['name'], 'thumb' => $image, 'price' => $price, 'special' => $special, 'description' => $this->encode->substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..', 'model' => $product_info['model'], 'manufacturer' => $product_info['manufacturer'], 'availability' => $availability, 'rating' => (int)$product_info['rating'], 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$product_info['reviews']), 'weight' => $this->weight->format($product_info['weight'], $product_info['weight_class_id']), 'length' => $this->length->format($product_info['length'], $product_info['length_class_id']), 'width' => $this->length->format($product_info['width'], $product_info['length_class_id']), 'height' => $this->length->format($product_info['height'], $product_info['length_class_id']), 'attribute' => $attribute_data, 'href' => $this->url->link('catalog/product', 'product_id=' . $product_id), 'remove' => $this->url->link('catalog/compare', 'remove=' . $product_id));
                
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
        
        $data['continue'] = $this->url->link('shop/home');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/compare', $data));
    }
    
    public function add() {
        $this->theme->language('catalog/compare');
        
        $json = array();
        
        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        $this->theme->model('catalog/product');
        
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
        if ($product_info) {
            if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
                if (count($this->session->data['compare']) >= 4) {
                    array_shift($this->session->data['compare']);
                }
                
                $this->session->data['compare'][] = $this->request->post['product_id'];
            }
            
            $json['success'] = sprintf($this->language->get('lang_text_success'), $this->url->link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('catalog/compare'));
            
            $json['total'] = sprintf($this->language->get('lang_text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
