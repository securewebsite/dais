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

class BlogHotTopics extends Controller {
    
    public function index($setting) {
        static $widget = 0;
        
        $data = Theme::language('widget/blog_hot_topics');
        
        Theme::model('content/post');
        Theme::model('tool/image');
        
        $data['recent_posts'] = array();
        
        if ($setting['limit'] == 0) {
            $limit = 10;
        } else {
            $limit = $setting['limit'];
        }
        
        $results = ContentPost::getLatestPosts($limit);
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = ToolImage::resize($result['image'], 40, 30, 'h');
                } else {
                    $image = ToolImage::resize('placeholder.png', 40, 30, 'h');
                }
                
                $data['recent_posts'][] = array('post_id' => $result['post_id'], 'name' => $result['name'], 'pic' => $image, 'href' => Url::link('content/post', 'post_id=' . $result['post_id'], 'SSL'));
            }
        }
        
        $data['most_viewed'] = array();
        
        $results = ContentPost::getPopularPosts($limit);
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = ToolImage::resize($result['image'], 40, 30, 'h');
                } else {
                    $image = ToolImage::resize('placeholder.png', 40, 30, 'h');
                }
                
                $data['most_viewed'][] = array('post_id' => $result['post_id'], 'name' => $result['name'], 'pic' => $image, 'href' => Url::link('content/post', 'post_id=' . $result['post_id'], 'SSL'));
            }
        }
        
        $data['most_discussed'] = array();
        
        $results = ContentPost::getMostCommentedPosts($limit);
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = ToolImage::resize($result['image'], 40, 30, 'h');
                } else {
                    $image = ToolImage::resize('placeholder.png', 40, 30, 'h');
                }
                
                $data['most_discussed'][] = array('post_id' => $result['post_id'], 'name' => $result['name'], 'pic' => $image, 'href' => Url::link('content/post', 'post_id=' . $result['post_id'], 'SSL'));
            }
        }
        
        $data['widget'] = $widget++;
        
        Theme::loadjs('javascript/widget/blog_hot_topics', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/blog_hot_topics', $data);
    }
}
