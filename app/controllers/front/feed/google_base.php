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


namespace App\Controllers\Front\Feed;

use App\Controllers\Controller;

class GoogleBase extends Controller {
    
    public function index() {
        if (Config::get('google_base_status')) {
            $output = '<?xml version="1.0" encoding="UTF-8" ?>';
            $output.= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
            $output.= '<channel>';
            $output.= '<title>' . Config::get('config_name') . '</title>';
            $output.= '<description>' . Config::get('config_meta_description') . '</description>';
            $output.= '<link>' . Config::get('http.server') . '</link>';
            
            Theme::model('catalog/category');
            Theme::model('catalog/product');
            Theme::model('tool/image');
            
            $products = CatalogProduct::getProducts();
            
            foreach ($products as $product) {
                if ($product['description']) {
                    $output.= '<item>';
                    $output.= '<title>' . $product['name'] . '</title>';
                    $output.= '<link>' . Url::link('catalog/product', 'path=' . $product['paths'] . '&product_id=' . $product['product_id']) . '</link>';
                    $output.= '<description>' . $product['description'] . '</description>';
                    $output.= '<g:brand>' . html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . '</g:brand>';
                    $output.= '<g:condition>new</g:condition>';
                    $output.= '<g:id>' . $product['product_id'] . '</g:id>';
                    
                    if ($product['image']) {
                        $output.= '<g:image_link>' . ToolImage::resize($product['image'], 500, 500) . '</g:image_link>';
                    } else {
                        $output.= '<g:image_link>' . ToolImage::resize('placeholder.png', 500, 500) . '</g:image_link>';
                    }
                    
                    $output.= '<g:mpn>' . $product['model'] . '</g:mpn>';
                    
                    $currencies = array('USD', 'EUR', 'GBP');
                    
                    if (in_array(Currency::getCode(), $currencies)) {
                        $currency_code = Currency::getCode();
                        $currency_value = Currency::getValue();
                    } else {
                        $currency_code = 'USD';
                        $currency_value = Currency::getValue('USD');
                    }
                    
                    if ((float)$product['special']) {
                        $output.= '<g:price>' . Currency::format(Tax::calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false) . '</g:price>';
                    } else {
                        $output.= '<g:price>' . Currency::format(Tax::calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false) . '</g:price>';
                    }
                    
                    $categories = CatalogProduct::getCategories($product['product_id']);
                    
                    foreach ($categories as $category) {
                        $path = $this->getPath($category['category_id']);
                        
                        if ($path) {
                            $string = '';
                            
                            foreach (explode('_', $path) as $path_id) {
                                $category_info = CatalogCategory::getCategory($path_id);
                                
                                if ($category_info) {
                                    if (!$string) {
                                        $string = $category_info['name'];
                                    } else {
                                        $string.= ' &gt; ' . $category_info['name'];
                                    }
                                }
                            }
                            
                            $output.= '<g:product_type>' . $string . '</g:product_type>';
                        }
                    }
                    
                    $output.= '<g:quantity>' . $product['quantity'] . '</g:quantity>';
                    $output.= '<g:upc>' . $product['upc'] . '</g:upc>';
                    $output.= '<g:weight>' . Weight::format($product['weight'], $product['weight_class_id']) . '</g:weight>';
                    $output.= '<g:availability>' . ($product['quantity'] ? 'in stock' : 'out of stock') . '</g:availability>';
                    $output.= '</item>';
                }
            }
            
            $output.= '</channel>';
            $output.= '</rss>';
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::addHeader('Content-Type: application/rss+xml');
            Response::setOutput($output);
        }
    }
    
    protected function getPath($parent_id, $current_path = '') {
        $category_info = CatalogCategory::getCategory($parent_id);
        
        if ($category_info) {
            if (!$current_path) {
                $new_path = $category_info['category_id'];
            } else {
                $new_path = $category_info['category_id'] . '_' . $current_path;
            }
            
            $path = $this->getPath($category_info['parent_id'], $new_path);
            
            if ($path) {
                return $path;
            } else {
                return $new_path;
            }
        }
    }
}
