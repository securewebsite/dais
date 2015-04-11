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

namespace Front\Controller\Widget;
use Dais\Engine\Controller;

class Category extends Controller {
    public function index($setting) {
        $data = $this->theme->language('widget/category');
        
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = array();
        }
        
        if (isset($parts[0])) {
            $data['category_id'] = $parts[0];
        } else {
            $data['category_id'] = 0;
        }
        
        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }
        
        $this->theme->model('catalog/category');
        
        $this->theme->model('catalog/product');
        
        $data['categories'] = array();
        
        $categories = $this->model_catalog_category->getCategories(0);
        
        foreach ($categories as $category) {
            $total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));
            
            $children_data = array();
            
            $children = $this->model_catalog_category->getCategories($category['category_id']);
            
            foreach ($children as $child) {
                $filter = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);
                
                $product_total = $this->model_catalog_product->getTotalProducts($filter);
                
                $total+= $product_total;
                
                $children_data[] = array('category_id' => $child['category_id'], 'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''), 'href' => $this->url->link('catalog/category', 'path=' . $category['category_id'] . '_' . $child['category_id']));
            }
            
            $data['categories'][] = array('category_id' => $category['category_id'], 'name' => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''), 'children' => $children_data, 'href' => $this->url->link('catalog/category', 'path=' . $category['category_id']));
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/category', $data);
    }
}
