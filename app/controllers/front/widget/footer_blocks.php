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

class FooterBlocks extends Controller {
    
    private $items = array();
    
    public function index() {
        Theme::model('design/layout');
        Theme::model('setting/menu');
        
        if (isset($this->request->get['route'])):
            $route = (string)$this->request->get['route'];
        else:
            $route = Theme::getstyle() . '/home';
        endif;
        
        $layout_id = DesignLayout::getLayout($route);
        
        /**
         * All routes for footers should be either shop/ or content/ by default.
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
            $position = 'content_footer';
            break;

        case 'catalog':
        case 'checkout':
        case 'shop':
        case 'payment':
            $position = 'shop_footer';
            break;

        default:
            $position = 'content_footer';
            break;
        endswitch;
        
        $data['menu_blocks'] = array();
        $menus               = array();
        $widgets             = array();
        $all_widgets         = array();
        
        $all_widgets = Config::get('footer_blocks_widget');
        
        if ($all_widgets):
            foreach ($all_widgets as $widget):
                if ($widget['position'] === $position && $widget['layout_id'] === $layout_id && $widget['status']):
                    $widgets[] = $widget;
                endif;
            endforeach;
        endif;
        
        if (empty($widgets) && $all_widgets):
            $layout_id = SettingMenu::getDefault();
            
            foreach ($all_widgets as $widget):
                if ($widget['position'] === $position && $widget['layout_id'] === $layout_id && $widget['status']):
                    $widgets[] = $widget;
                endif;
            endforeach;
        endif;
        
        if ($widgets):
            foreach ($widgets as $widget):
                if ($widget['layout_id'] == $layout_id && $widget['position'] == $position && $widget['status']):
                    $menus[] = SettingMenu::getMenu($widget['menu_id']);
                endif;
            endforeach;
        endif;
        
        /**
         * adjust boostrap column widths based on
         * total of blocks to be rendered.
         * @var int $count
         * @var int $class
         */
        
        $count = count($menus);
        switch ($count):
        case 1:
            $class = 12;
            break;

        case 2:
            $class = 6;
            break;

        case 3:
            $class = 4;
            break;

        case 4:
            $class = 3;
            break;

        case $count > 4:
            $class = 3;
            break;
        endswitch;
        
        foreach ($menus as $menu):
            $block                      = array();
            $this->items[$menu['type']] = $menu['items'];
            $block['class']             = $class;
            $block['menu_name']         = $menu['name'];
            $block['menu_items']        = call_user_func(array(__CLASS__, $menu['type']));
            $data['menu_blocks'][]      = $block;
        endforeach;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/footer_blocks', $data);
    }
    
    private function product_category() {
        Theme::model('catalog/category');
        
        $menu_items = array();
        
        $categories = CatalogCategory::getCategories(0);
        
        foreach ($categories as $category):
            $children_data = array();
            
            $children = CatalogCategory::getCategories($category['category_id']);
            
            foreach ($children as $child):
                if (in_array($child['category_id'], $this->items['product_category'])):
                    $children_data[] = array(
                        'id'   => $child['category_id'], 
                        'name' => $child['name'], 
                        'href' => Url::link('catalog/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                endif;
            endforeach;
            
            if (in_array($category['category_id'], $this->items['product_category'])):
                $menu_items[] = array(
                    'id'       => $category['category_id'], 
                    'name'     => $category['name'], 
                    'children' => $children_data, 
                    'column'   => $category['columns'] ? $category['columns'] : 1, 
                    'href'     => Url::link('catalog/category', 'path=' . $category['category_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function content_category() {
        Theme::model('content/category');
        
        $menu_items = array();
        
        $categories = ContentCategory::getCategories(0);
        
        foreach ($categories as $category):
            $children_data = array();
            
            $children = ContentCategory::getCategories($category['category_id']);
            
            foreach ($children as $child):
                if (in_array($child['category_id'], $this->items['content_category'])):
                    $children_data[] = array(
                        'id'   => $child['category_id'], 
                        'name' => $child['name'], 
                        'href' => Url::link('content/category', 'bpath=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                endif;
            endforeach;
            
            if (in_array($category['category_id'], $this->items['content_category'])):
                $menu_items[] = array(
                    'id'       => $category['category_id'], 
                    'name'     => $category['name'], 
                    'children' => $children_data, 
                    'column'   => $category['columns'] ? $category['columns'] : 1, 
                    'href'     => Url::link('content/category', 'bpath=' . $category['category_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function page() {
        Theme::model('content/page');
        
        $menu_items = array();
        
        $pages = ContentPage::getPages();
        
        foreach ($pages as $page):
            if (in_array($page['page_id'], $this->items['page'])):
                $menu_items[] = array(
                    'name' => $page['title'], 
                    'href' => Url::link('content/page', 'page_id=' . $page['page_id'])
                );
            endif;
        endforeach;
        
        return $menu_items;
    }
    
    private function post() {
        Theme::model('content/post');
        
        $menu_items = array();
        
        $posts = ContentPost::getPosts();
        
        foreach ($posts as $post):
            if (in_array($post['post_id'], $this->items['post'])):
                $menu_items[] = array(
                    'name' => $post['name'], 
                    'href' => Url::link('content/post', 'post_id=' . $post['post_id'])
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
        Theme::language('shop/footer');
        
        $menu_items = array();
        
        $items = $this->items['custom'];
        
        foreach ($items as $item):
            $link = array();
            
            /**
             * custom hack for changing Dashboard/Login text
             * safe to remove.
             */
            if ($item['name'] === Lang::get('lang_text_dashboard')):
                $item['name'] = (Customer::isLogged()) ? Lang::get('lang_text_dashboard') : Lang::get('lang_text_login');
            endif;
            
            if (strpos($item['href'], 'http') === false && strpos($item['href'], 'https') === false):
                $link['href'] = Url::link($item['href']);
                $link['name'] = $item['name'];
            else:
                $link['external'] = Url::external($item['href'], $item['name']);
            endif;
            $menu_items[] = $link;
        endforeach;
        
        return $menu_items;
    }
}
