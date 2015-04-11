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

class Bloglatest extends Controller {
    public function index($setting) {
        $data = $this->theme->language('widget/bloglatest');
        
        $this->theme->model('content/post');
        $this->theme->model('tool/image');
        
        $data['posts'] = array();
        
        $filter = array('sort' => 'p.date_added', 'order' => 'DESC', 'start' => 0, 'limit' => $setting['limit']);
        
        $results = $this->model_content_post->getPosts($filter);
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height'], 'h');
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $setting['image_width'], $setting['image_height'], 'h');
            }
            
            $data['posts'][] = array('post_id' => $result['post_id'], 'thumb' => $image, 'name' => $result['name'], 'href' => $this->url->link('content/post', 'post_id=' . $result['post_id']),);
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/bloglatest', $data);
    }
}
