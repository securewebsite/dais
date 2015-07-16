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

namespace App\Controllers\Front\Content;

use App\Controllers\Controller;

class SiteMap extends Controller {
    
    public function index() {
        $data = Theme::language('content/site_map');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_heading_title', 'content/site_map');
        
        Theme::model('catalog/category');
        Theme::model('catalog/product');
        
        $data['categories'] = array();
        
        $categories_1 = CatalogCategory::getCategories(0);
        
        foreach ($categories_1 as $category_1) {
            $level_2_data = array();
            
            $categories_2 = CatalogCategory::getCategories($category_1['category_id']);
            
            foreach ($categories_2 as $category_2) {
                $level_3_data = array();
                
                $categories_3 = CatalogCategory::getCategories($category_2['category_id']);
                
                foreach ($categories_3 as $category_3) {
                    $level_3_data[] = array('name' => $category_3['name'], 'href' => Url::link('catalog/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id']));
                }
                
                $level_2_data[] = array('name' => $category_2['name'], 'children' => $level_3_data, 'href' => Url::link('catalog/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id']));
            }
            
            $data['categories'][] = array('name' => $category_1['name'], 'children' => $level_2_data, 'href' => Url::link('catalog/category', 'path=' . $category_1['category_id']));
        }
        
        $data['special'] = Url::link('catalog/special');
        $data['account'] = Url::link('account/dashboard', '', 'SSL');
        $data['edit'] = Url::link('account/edit', '', 'SSL');
        $data['password'] = Url::link('account/password', '', 'SSL');
        $data['address'] = Url::link('account/address', '', 'SSL');
        $data['history'] = Url::link('account/order', '', 'SSL');
        $data['download'] = Url::link('account/download', '', 'SSL');
        $data['cart'] = Url::link('checkout/cart');
        $data['checkout'] = Url::link('checkout/checkout', '', 'SSL');
        $data['search'] = Url::link('catalog/search');
        $data['contact'] = Url::link('content/contact');
        
        Theme::model('content/page');
        
        $data['pages'] = array();
        
        foreach (ContentPage::getPages() as $result) {
            $data['pages'][] = array('title' => $result['title'], 'href' => Url::link('content/page', 'page_id=' . $result['page_id']));
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('content/site_map', $data));
    }
}
