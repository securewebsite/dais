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

class BlogFeatured extends Controller {
    
    public function index($setting) {
        static $widget = 0;
        
        $data = Theme::language('widget/blog_featured');
        
        $data['setting'] = $setting;
        
        Theme::model('content/post');
        Theme::model('tool/image');
        
        $data['posts'] = array();
        
        $posts = explode(',', Config::get('blog_featured_post'));
        
        if (empty($setting['limit'])) {
            $setting['limit'] = 5;
        }
        
        $posts = array_slice($posts, 0, (int)$setting['limit']);
        
        foreach ($posts as $post_id) {
            $post_info = ContentPost::getPost($post_id);
            
            if ($post_info) {
                if ($post_info['image']) {
                    $image = ToolImage::resize($post_info['image'], $setting['image_width'], $setting['image_height'], 'h');
                } else {
                    $image = ToolImage::resize('placeholder.png', $setting['image_width'], $setting['image_height'], 'h');
                }
                
                $data['posts'][] = array('post_id' => $post_info['post_id'], 'thumb' => $image, 'name' => $post_info['name'], 'href' => Url::link('content/post', 'post_id=' . $post_info['post_id']));
            }
        }
        
        $data['widget'] = $widget++;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/blog_featured', $data);
    }
}
