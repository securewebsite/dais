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

class Bloghottopics extends Controller {
    public function index($setting) {
        static $widget = 0;
        
        $data = $this->theme->language('widget/bloghottopics');
        
        $this->theme->model('content/post');
        $this->theme->model('tool/image');
        
        $data['recent_posts'] = array();
        
        if ($setting['limit'] == 0) {
            $limit = 10;
        } else {
            $limit = $setting['limit'];
        }
        
        $results = $this->model_content_post->getLatestPosts($limit);
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 40, 30, 'h');
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', 40, 30, 'h');
                }
                
                $data['recent_posts'][] = array('post_id' => $result['post_id'], 'name' => $result['name'], 'pic' => $image, 'href' => $this->url->link('content/post', 'post_id=' . $result['post_id'], 'SSL'));
            }
        }
        
        $data['most_viewed'] = array();
        
        $results = $this->model_content_post->getPopularPosts($limit);
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 40, 30, 'h');
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', 40, 30, 'h');
                }
                
                $data['most_viewed'][] = array('post_id' => $result['post_id'], 'name' => $result['name'], 'pic' => $image, 'href' => $this->url->link('content/post', 'post_id=' . $result['post_id'], 'SSL'));
            }
        }
        
        $data['most_discussed'] = array();
        
        $results = $this->model_content_post->getMostCommentedPosts($limit);
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 40, 30, 'h');
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', 40, 30, 'h');
                }
                
                $data['most_discussed'][] = array('post_id' => $result['post_id'], 'name' => $result['name'], 'pic' => $image, 'href' => $this->url->link('content/post', 'post_id=' . $result['post_id'], 'SSL'));
            }
        }
        
        $data['widget'] = $widget++;
        
        $this->theme->loadjs('javascript/widget/bloghottopics', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/bloghottopics', $data);
    }
}
