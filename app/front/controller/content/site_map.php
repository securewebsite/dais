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

namespace Front\Controller\Content;
use Dais\Base\Controller;

class SiteMap extends Controller {
    public function index() {
        $data = $this->theme->language('content/site_map');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_heading_title', 'content/site_map');
        
        $this->theme->model('catalog/category');
        $this->theme->model('catalog/product');
        
        $data['categories'] = array();
        
        $categories_1 = $this->model_catalog_category->getCategories(0);
        
        foreach ($categories_1 as $category_1) {
            $level_2_data = array();
            
            $categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
            
            foreach ($categories_2 as $category_2) {
                $level_3_data = array();
                
                $categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
                
                foreach ($categories_3 as $category_3) {
                    $level_3_data[] = array('name' => $category_3['name'], 'href' => $this->url->link('catalog/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id']));
                }
                
                $level_2_data[] = array('name' => $category_2['name'], 'children' => $level_3_data, 'href' => $this->url->link('catalog/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id']));
            }
            
            $data['categories'][] = array('name' => $category_1['name'], 'children' => $level_2_data, 'href' => $this->url->link('catalog/category', 'path=' . $category_1['category_id']));
        }
        
        $data['special'] = $this->url->link('catalog/special');
        $data['account'] = $this->url->link('account/dashboard', '', 'SSL');
        $data['edit'] = $this->url->link('account/edit', '', 'SSL');
        $data['password'] = $this->url->link('account/password', '', 'SSL');
        $data['address'] = $this->url->link('account/address', '', 'SSL');
        $data['history'] = $this->url->link('account/order', '', 'SSL');
        $data['download'] = $this->url->link('account/download', '', 'SSL');
        $data['cart'] = $this->url->link('checkout/cart');
        $data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
        $data['search'] = $this->url->link('catalog/search');
        $data['contact'] = $this->url->link('content/contact');
        
        $this->theme->model('content/page');
        
        $data['pages'] = array();
        
        foreach ($this->model_content_page->getPages() as $result) {
            $data['pages'][] = array('title' => $result['title'], 'href' => $this->url->link('content/page', 'page_id=' . $result['page_id']));
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/site_map', $data));
    }
}
