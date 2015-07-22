<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace Dais\Services\Providers\Response;

class Url {
    
    private $domain;
    private $ssl;
    
    public function __construct($domain, $ssl = '') { 
        $this->domain = $domain;
        $this->ssl    = $ssl;
    }
    
    public function external($href, $text, $rel = 'nofollow', $target = '_blank') {
        $link = '<a href="' . $href . '" title="' . $text . '" rel="' . $rel . '" target="' . $target . '">' . $text . '</a>';
        
        return $link;
    }
    
    public function link($route, $arguments = '', $secure = false) {
        if (!$secure):
            $uri = $this->domain;
        else:
            $uri = $this->ssl;
        endif;
        
        parse_str($arguments, $args);

        $custom = \Routes::getCustomRoutes();
        $slugs  = \Routes::getSlugs();

        $url = false;

        if (array_key_exists($route, $slugs) && Config::get('active.facade') === FRONT_FACADE):
            $url = $this->writePublic($args);
        endif;

        if (in_array($route, $custom)):
            $url = array_search($route, $custom);
        endif;

        if (!$url):
            $url = $route;

            foreach($args as $key => $value):
                $url .= '/' . strtolower($key) . '/' . strtolower($value);
            endforeach;
        endif;

        $link = $uri . $url;

        if (Config::get('active.facade') === FRONT_FACADE):
            if (Theme::getStyle() === 'shop'):
                $link = str_replace('/shop', '', $link);
            else:
                if (!Config::get('config_home_page')):
                    $link = str_replace('/blog', '', $link);
                endif;
            endif;
        endif;
        
        return str_replace('_', '-', $link);
    }
    
    /*
    Moved the rewrite function from the router to the url class in order to
    simplify and make the rewiter more logical.
    
    Routing is routing and url creation is url creation, no need to mix the two.
    */
    protected function writePublic($args) {
        $slugs = \Routes::getSlugs();
        $url   = '';

        if (!empty($args)):
                
            // Blog Categories
            if (array_key_exists('bpath', $args)):
                $url .= $slugs['content/category'][$args['bpath']];
                unset($args['bpath']);
            endif;
            
            // Product Categories
            if (array_key_exists('path', $args)):
                $url .= $slugs['catalog/category'][$args['path']];
                unset($args['path']);
            endif;

            // Articles
            if (array_key_exists('post_id', $args)):
                // purge categories
                if (!Config::get('config_top_level')):
                    $url .= '/' . $slugs['content/post'][$args['post_id']];
                else:
                    $url = $slugs['content/post'][$args['post_id']];
                endif;
                
                unset($args['post_id']);
            endif;
            
            // Products
            if (array_key_exists('product_id', $args)):
                // purge categories
                if (!Config::get('config_top_level')):
                    $url .= '/' . $slugs['catalog/product'][$args['product_id']];
                else:
                    $url = $slugs['catalog/product'][$args['product_id']];
                endif;
                
                unset($args['product_id']);
            endif;

            // Manufacturers
            if (array_key_exists('manufacturer_id', $args)):
                $url .= $slugs['catalog/manufacturer/info'][$args['manufacturer_id']];
                unset($args['manufacturer_id']);
            endif;

            // Pages
            if (array_key_exists('page_id', $args)):
                $url .= $slugs['content/page'][$args['page_id']];
                unset($args['page_id']);
            endif;

            // Events
            if (array_key_exists('event_page_id', $args)):
                $url .= $slugs['event/page'][$args['event_page_id']];
                unset($args['event_page_id']);
            endif;

            // Affiliates
            if (array_key_exists('affiliate_id', $args)):
                if (in_array($args['affiliate_id'], $slugs['content/home'])):
                    $url .= $slugs['content/home'][$args['affiliate_id']];
                endif;
                unset($args['affiliate_id']);
            endif;

            // all our slugs have been processed, anything remaining in
            // $args are genuine arguments. Process them and add them to the url
            
            foreach($args as $key => $value):
                $url .= '/' . strtolower($key) . '/' . strtolower($value);
            endforeach;
        endif;

        return $url;
    }
}
