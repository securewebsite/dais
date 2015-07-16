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

class BlogLatest extends Controller {
    
    public function index($setting) {
        $data = Theme::language('widget/blog_latest');
        
        Theme::model('content/post');
        Theme::model('tool/image');
        
        $data['posts'] = array();
        
        $filter = array('sort' => 'p.date_added', 'order' => 'DESC', 'start' => 0, 'limit' => $setting['limit']);
        
        $results = ContentPost::getPosts($filter);
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = ToolImage::resize($result['image'], $setting['image_width'], $setting['image_height'], 'h');
            } else {
                $image = ToolImage::resize('placeholder.png', $setting['image_width'], $setting['image_height'], 'h');
            }
            
            $data['posts'][] = array('post_id' => $result['post_id'], 'thumb' => $image, 'name' => $result['name'], 'href' => Url::link('content/post', 'post_id=' . $result['post_id']),);
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/blog_latest', $data);
    }
}
