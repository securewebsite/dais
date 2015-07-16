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

class Category extends Controller {
    
    public function index($setting) {
        $data = Theme::language('widget/category');
        
        if (isset($this->request->get['path'])):
            $parts = explode('_', (string)$this->request->get['path']);
        else:
            $parts = array();
        endif;
        
        if (isset($parts[0])):
            $data['category_id'] = $parts[0];
        else:
            $data['category_id'] = 0;
        endif;
        
        if (isset($parts[1])):
            $data['child_id'] = $parts[1];
        else:
            $data['child_id'] = 0;
        endif;
        
        Theme::model('catalog/category');
        Theme::model('catalog/product');
        
        $data['categories'] = array();
        
        $categories = CatalogCategory::getCategories(0);

        $show_total = false;
        
        foreach ($categories as $category):
            if (Config::get('config_product_count')):
                $total = CatalogProduct::getTotalProducts(array('filter_category_id' => $category['category_id']));
                $show_total  = ' (' . $total . ')';
            endif;

            $children_data = array();
            $children      = CatalogCategory::getCategories($category['category_id']);
            
            foreach ($children as $child):
                $filter = array(
                    'filter_category_id'  => $child['category_id'], 
                    'filter_sub_category' => true
                );

                $show_product = false;
                
                if (Config::get('config_product_count')):
                    $product_total = CatalogProduct::getTotalProducts($filter);
                    $total         += $product_total;
                    $show_product  = ' (' . $product_total . ')';
                endif;
                
                $children_data[] = array(
                    'category_id' => $child['category_id'], 
                    'name'        => $child['name'] . $show_product, 
                    'href'        => Url::link('catalog/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                );
            endforeach;
            
            $data['categories'][] = array(
                'category_id' => $category['category_id'], 
                'name'        => $category['name'] . $show_total, 
                'children'    => $children_data, 
                'href'        => Url::link('catalog/category', 'path=' . $category['category_id'])
            );
        endforeach;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/category', $data);
    }
}
