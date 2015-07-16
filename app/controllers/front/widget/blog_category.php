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

class BlogCategory extends Controller {
    
    public function index($setting) {
        $data = Theme::language('widget/blog_category');
        
        if (isset($this->request->get['bpath'])) {
            $parts = explode('_', (string)$this->request->get['bpath']);
        } else {
            $parts = array();
        }
        
        if (isset($parts[0])) {
            $data['blog_category_id'] = $parts[0];
        } else {
            $data['blog_category_id'] = 0;
        }
        
        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }
        
        Theme::model('content/category');
        
        $data['blog_categories'] = array();
        
        $blog_categories = ContentCategory::getCategories(0);
        
        foreach ($blog_categories as $blog_category) {
            
            $children_data = array();
            
            $children = ContentCategory::getCategories($blog_category['category_id']);
            
            foreach ($children as $child) {
                $children_data[] = array('category_id' => $child['category_id'], 'name' => $child['name'], 'href' => Url::link('content/category', 'bpath=' . $blog_category['category_id'] . '_' . $child['category_id']));
            }
            
            $data['blog_categories'][] = array('category_id' => $blog_category['category_id'], 'name' => $blog_category['name'], 'children' => $children_data, 'href' => Url::link('content/category', 'bpath=' . $blog_category['category_id']));
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/blog_category', $data);
    }
}
