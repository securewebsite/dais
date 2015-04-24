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

class Headermenu extends Controller {
    private $items = array();
    
    public function index() {
        $this->theme->model('design/layout');
        $this->theme->model('setting/menu');
        
        if (isset($this->request->get['route'])):
            $route = (string)$this->request->get['route'];
        else:
            $route = $this->theme->style . '/home';
        endif;
        
        $layout_id = $this->model_design_layout->getLayout($route);
        
        /**
         * All routes for headers should be either shop/ or content/ by default.
         * Split the route and use the first piece with trailing slash
         * and fetch all ids for the layout slug.
         */
        
        $routes = explode('/', $route);
        
        switch ($routes[0]):
        case 'account':
        case 'affiliate':
        case 'content':
        case 'error':
        case 'feed':
        case 'tool':
            $position = 'content_header';
            break;

        case 'catalog':
        case 'checkout':
        case 'shop':
        case 'payment':
            $position = 'shop_header';
            break;

        default:
            $position = 'content_header';
            break;
        endswitch;
        
        $data['menu_items'] = array();
        $menus = array();
        $widgets = array();
        $all_widgets = array();
        
        $all_widgets = $this->config->get('headermenu_widget');
        
        if ($all_widgets):
            foreach ($all_widgets as $widget):
                if ($widget['position'] === $position && $widget['layout_id'] === $layout_id && $widget['status']):
                    $widgets[] = $widget;
                endif;
            endforeach;
        endif;
        
        if (empty($widgets) && $all_widgets):
            $layout_id = $this->model_setting_menu->getDefault();
            
            foreach ($all_widgets as $widget):
                if ($widget['position'] === $position && $widget['layout_id'] === $layout_id && $widget['status']):
                    $widgets[] = $widget;
                endif;
            endforeach;
        endif;
        
        if ($widgets):
            foreach ($widgets as $widget):
                if ($widget['layout_id'] == $layout_id && $widget['position'] == $position && $widget['status']):
                    $menus[] = $this->model_setting_menu->getMenu($widget['menu_id']);
                endif;
            endforeach;
        endif;
        
        foreach ($menus as $menu):
            $this->items[$menu['type']] = $menu['items'];
            $data['menu_items'] = array_merge($data['menu_items'], call_user_func(array(__CLASS__, $menu['type'])));
        endforeach;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/headermenu', $data);
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
                $link['external'] = $this->url->external($item['href'], $item['name']);
            endif;
            $menu_items[] = $link;
        endforeach;
        
        return $menu_items;
    }
}
