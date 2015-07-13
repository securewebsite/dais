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

namespace App\Controllers\Front\Widget;
use App\Controllers\Controller;

class Featured extends Controller {
    public function index($setting) {
        $data = $this->theme->language('widget/featured');
        
        $this->theme->model('catalog/product');
        
        $this->theme->model('tool/image');
        
        $data['products'] = array();
        
        $products = explode(',', $this->config->get('featured_product'));
        
        if (empty($setting['limit'])) {
            $setting['limit'] = 5;
        }
        
        $products = array_slice($products, 0, (int)$setting['limit']);
        
        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
                    $data['image_width'] = $setting['image_width'];
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
                
                if ($this->config->get('config_review_status')) {
                    $rating = $product_info['rating'];
                } else {
                    $rating = false;
                }
                
                $data['products'][] = array('product_id' => $product_info['product_id'], 'event_id' => $product_info['event_id'], 'thumb' => $image, 'name' => $product_info['name'], 'price' => $price, 'special' => $special, 'rating' => $rating, 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$product_info['reviews']), 'href' => $this->url->link('catalog/product', 'product_id=' . $product_info['product_id']));
            }
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/featured', $data);
    }
}
