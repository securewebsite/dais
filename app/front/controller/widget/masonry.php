<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace Front\Controller\Widget;
use Dais\Engine\Controller;

class Masonry extends Controller {
    public function index($setting) {
        static $widget = 0;
        
        $data = $this->theme->language('widget/masonry');
        
        $this->javascript->register('masonry.min', 'bootstrap.min')->register('imagesloaded.min', 'masonry.min');
        
        $data['heading_title'] = $this->language->get('lang_heading_' . $setting['product_type']);
        
        $data['text_empty'] = sprintf($this->language->get('lang_text_empty') , $setting['product_type']);
        
        $this->theme->model('catalog/product');
        $this->theme->model('tool/image');
        
        $data['button'] = $setting['button'];
        $data['span'] = $setting['span'];
        
        $data['class_row'] = ($setting['span'] == 1) ? 'slim-row' : 'row';
        
        $class_col = array(
            1 => 'slim-col-xs-4 slim-col-sm-2 slim-col-md-1',
            2 => 'col-xs-6 col-sm-3 col-md-2',
            3 => 'col-xs-12 col-sm-4 col-md-3',
            4 => 'col-xs-12 col-sm-6 col-md-4',
            6 => 'col-xs-12 col-sm-6'
        );
        
        $data['class_col'] = $class_col[$setting['span']];
        
        if (!$setting['height']) {
            $data['class_1'] = 'masonry';
            $data['class_2'] = 'thumbnail';
            $data['class_3'] = '';
        } else {
            $data['class_1'] = 'block';
            $data['class_2'] = 'spacer';
            $data['class_3'] = 'thumbnail';
        }
        
        $key = 'products.masonry.' . (int)$widget;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)) {
            $image_width = 60 + (($setting['span'] - 1) * 100);
            
            $masonry_products = array();
            
            if ($setting['product_type'] == 'featured') {
                $results = array();
                
                $products = explode(',', $this->config->get('featured_product'));
                
                if (empty($setting['limit'])) {
                    $setting['limit'] = 5;
                }
                
                $products = array_slice($products, 0, (int)$setting['limit']);
                
                foreach ($products as $product_id) {
                    $product_info = $this->model_catalog_product->getProduct($product_id);
                    
                    if ($product_info) {
                        $results[] = $product_info;
                    }
                }
            } elseif ($setting['product_type'] == 'special') {
                $results = $this->model_catalog_product->getProductSpecials(array(
                    'sort' => 'pd.name',
                    'order' => 'ASC',
                    'start' => 0,
                    'limit' => $setting['limit']
                ));
            } elseif ($setting['product_type'] == 'bestseller') {
                $results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);
            } else {
                $results = $this->model_catalog_product->getProducts(array(
                    'sort' => 'p.date_added',
                    'order' => 'DESC',
                    'start' => 0,
                    'limit' => $setting['limit']
                ));
            }
            
            $display_price = $this->config->get('config_customer_price') && $this->customer->isLogged() || !$this->config->get('config_customer_price');
            
            $chars = $setting['span'] * 40;
            
            foreach ($results as $result) {
                if ($result['image'] && file_exists($this->app['path.image'] . $result['image'])) {
                    if ($setting['height']) {
                        $height = $setting['height'];
                    } else {
                        $size = getimagesize($this->app['path.image'] . $result['image']);
                        
                        $height = ceil(((int)$image_width / $size[0]) * $size[1]);
                    }
                    
                    $image = $this->model_tool_image->resize($result['image'], (int)$image_width, $height);
                    
                } else {
                    $image = '';
                }
                
                if ($setting['description'] && $result['description']) {
                    $description = $this->formatDescription($result['description'], $chars);
                } else {
                    $description = false;
                }
                
                if ($display_price && !number_format($result['price'])) {
                    $price = $this->language->get('lang_text_free');
                } elseif ($display_price) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ($display_price && (float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }
                
                if ($this->config->get('config_review_status') && $setting['span'] > 1) {
                    $rating = $result['rating'];
                } else {
                    $rating = false;
                }
                
                $masonry_products[] = array(
                    'product_id'  => $result['product_id'],
                    'event_id'    => $result['event_id'],
                    'thumb'       => $image,
                    'name'        => $result['name'],
                    'description' => $description,
                    'price'       => $price,
                    'special'     => $special,
                    'rating'      => $rating,
                    'reviews'     => sprintf($this->language->get('lang_text_reviews') , (int)$result['reviews']) ,
                    'href'        => $this->url->link('catalog/product', 'product_id=' . $result['product_id']) ,
                );
            }
            
            $cachefile = $masonry_products;
            $this->cache->set($key, $cachefile);
        }
        
        $data['products'] = $cachefile;
        
        $data['widget'] = $widget++;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/masonry', $data);
    }
    
    protected function formatDescription($description, $chars = 100) {
        $description = preg_replace('/<[^>]+>/i', ' ', html_entity_decode($description, ENT_QUOTES, 'UTF-8'));
        
        if ($this->encode->strlen($description) > $chars) {
            return trim($this->encode->substr($description, 0, $chars)) . '...';
        } else {
            return $description;
        }
    }
}
