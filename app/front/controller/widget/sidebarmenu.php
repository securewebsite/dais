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

class Sidebarmenu extends Controller {
    private $items = array();
    
    public function index() {
        $settings = func_get_args();
        $settings = $settings[0];
        
        $this->theme->model('setting/menu');
        $menu = $this->model_setting_menu->getMenu($settings['menu_id']);
        
        $data['menu_blocks'] = array();
        
        $path  = false;
        $bpath = false;
        
        if (isset($this->request->get['path'])):
            $parts = explode('_', (string)$this->request->get['path']);
            $path  = true;
        elseif (isset($this->request->get['bpath'])):
            $parts = explode('_', (string)$this->request->get['bpath']);
            $bpath = true;
        else:
            $parts = array();
        endif;
        
        if (isset($parts[0])):
            $menu_item_id = $parts[0];
        else:
            $menu_item_id = 0;
        endif;
        
        if (isset($parts[1])):
            $child_id = $parts[1];
        else:
            $child_id = 0;
        endif;
        
        if (isset($layout_id) && $layout_id !== $menu['layout_id']):
            continue;
        endif;
        $block                      = array();
        $this->items[$menu['type']] = $menu['items'];
        $block['menu_name']         = $menu['name'];
        
        /**
         * This is required to deliniate active links since
         * all variables are the same in the template.
         * Only really matters if you have a product category
         * AND content category menu at the same time.
         */
        if ($menu['type'] === 'product_category' && $bpath === true):
            $block['menu_item_id']  = 0;
            $block['menu_child_id'] = 0;
        elseif ($menu['type'] === 'content_category' && $path === true):
            $block['menu_item_id']  = 0;
            $block['menu_child_id'] = 0;
        else:
            $block['menu_item_id']  = $menu_item_id;
            $block['menu_child_id'] = $child_id;
        endif;
        $block['menu_items']   = call_user_func(array(__CLASS__, $menu['type']));
        $data['menu_blocks'][] = $block;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/sidebar', $data);
    }
    
    private function product_category() {
        $this->theme->model('catalog/category');
        
        $menu_items = array();
        
        $categories = $this->model_catalog_category->getCategories(0);
        
        foreach ($categories as $category):
            $children_data = array();
            
            $children = $this->model_catalog_category->getCategories($category['category_id']);
            
            foreach ($children as $child):
                if (in_array($child['category_id'], $this->items['product_category'])):
                    $children_data[] = array(
                        'id'   => $child['category_id'], 
                        'name' => $child['name'], 
                        'href' => $this->url->link('catalog/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                endif;
            endforeach;
            
            if (in_array($category['category_id'], $this->items['product_category'])):
                $menu_items[] = array(
                    'id'       => $category['category_id'], 
                    'name'     => $category['name'], 
                    'children' => $children_data, 
                    'column'   => $category['columns'] ? $category['columns'] : 1, 
                    'href'     => $this->url->link('catalog/category', 'path=' . $category['category_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function content_category() {
        $this->theme->model('content/category');
        
        $menu_items = array();
        
        $categories = $this->model_content_category->getCategories(0);
        
        foreach ($categories as $category):
            $children_data = array();
            
            $children = $this->model_content_category->getCategories($category['category_id']);
            
            foreach ($children as $child):
                if (in_array($child['category_id'], $this->items['content_category'])):
                    $children_data[] = array(
                        'id'   => $child['category_id'], 
                        'name' => $child['name'], 
                        'href' => $this->url->link('content/category', 'bpath=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                endif;
            endforeach;
            
            if (in_array($category['category_id'], $this->items['content_category'])):
                $menu_items[] = array(
                    'id'       => $category['category_id'], 
                    'name'     => $category['name'], 
                    'children' => $children_data, 
                    'column'   => $category['columns'] ? $category['columns'] : 1, 
                    'href'     => $this->url->link('content/category', 'bpath=' . $category['category_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function page() {
        $this->theme->model('content/page');
        
        $menu_items = array();
        
        $pages = $this->model_content_page->getPages();
        
        foreach ($pages as $page):
            if (in_array($page['page_id'], $this->items['page'])):
                $menu_items[] = array(
                    'name' => $page['title'], 
                    'href' => $this->url->link('content/page', 'page_id=' . $page['page_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function post() {
        $this->theme->model('content/post');
        
        $menu_items = array();
        
        $posts = $this->model_content_post->getPosts();
        
        foreach ($posts as $post):
            if (in_array($post['post_id'], $this->items['post'])):
                $menu_items[] = array(
                    'name' => $post['name'], 
                    'href' => $this->url->link('content/post', 'post_id=' . $post['post_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function custom() {
        
        /**
         * custom hack for changing Dashboard/Login text
         * safe to remove.
         */
        $this->theme->language('shop/footer');
        
        $menu_items = array();
        
        $items = $this->items['custom'];
        
        foreach ($items as $item):
            $link = array();
            
            /**
             * custom hack for changing Dashboard/Login text
             * safe to remove.
             */
            if ($item['name'] === $this->language->get('lang_text_dashboard')):
                $item['name'] = ($this->customer->isLogged()) ? $this->language->get('lang_text_dashboard') : $this->language->get('lang_text_login');
            endif;
            
            if (strpos($item['href'], 'http') === false && strpos($item['href'], 'https') === false):
                $link['href'] = $this->url->link($item['href']);
                $link['name'] = $item['name'];
            else:
                $link['external'] = $this->externalSidebar($item['href'], $item['name']);
            endif;
            $menu_items[] = $link;
        endforeach;
        
        return $menu_items;
    }
    
    private function externalSidebar($href, $text, $rel = 'nofollow', $target = '_blank') {
        $link = '<a class="list-group-item" href="' . $href . '" title="' . $text . '" rel="' . $rel . '" target="' . $target . '">' . $text . '
					<span class="pull-right"><i class="fa fa-bars"></i></span></a>';
        
        return $link;
    }
}
