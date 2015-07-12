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

class Rss extends Controller {
    public function index() {
        
        $output = '<?xml version="1.0" encoding="UTF-8" ?>';
        $output.= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
        $output.= '<channel>';
        $output.= '<title>' . Config::get('config_name') . '</title>';
        $output.= '<description>' . Config::get('config_meta_description') . '</description>';
        $output.= '<link>' . Config::get('http.server') . '</link>';
        
        Theme::model('content/category');
        Theme::model('content/post');
        Theme::model('tool/image');
        
        $posts = $this->model_content_post->getPosts();
        
        foreach ($posts as $post) {
            if ($post['description']) {
                $output.= '<item>';
                $output.= '<title>' . $post['name'] . '</title>';
                $output.= '<link>' . Url::link('content/post', 'post_id=' . $post['post_id']) . '</link>';
                $output.= '<description>' . $post['description'] . '</description>';
                $output.= '<g:condition>new</g:condition>';
                $output.= '<g:id>' . $post['post_id'] . '</g:id>';
                
                if ($post['image']) {
                    $output.= '<g:image_link>' . $this->model_tool_image->resize($post['image'], 500, 500) . '</g:image_link>';
                } else {
                    $output.= '<g:image_link>' . $this->model_tool_image->resize('no_image.jpg', 500, 500) . '</g:image_link>';
                }
                
                $output.= '</item>';
            }
        }
        
        $output.= '</channel>';
        $output.= '</rss>';
        
        $this->response->addHeader('Content-Type: application/rss+xml');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->response->setOutput($output);
    }
    
    protected function getPath($parent_id, $current_path = '') {
        $category_info = $this->model_content_category->getCategory($parent_id);
        
        if ($category_info) {
            if (!$current_path) {
                $new_path = $category_info['category_id'];
            } else {
                $new_path = $category_info['category_id'] . '_' . $current_path;
            }
            
            $path = $this->getPath($category_info['parent_id'], $new_path);
            
            if ($path) {
                return $path;
            } else {
                return $new_path;
            }
        }
    }
}
