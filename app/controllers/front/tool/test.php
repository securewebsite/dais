<?php

namespace App\Controllers\Front\Tool;

use App\Controllers\Controller;

class Test extends Controller {

	public function index() {

		$route      = 'account/address/update';
		$arguments  = 'address_id=1';

		parse_str($arguments, $args);

		$custom = Routes::getCustomRoutes();
		$slugs  = Routes::getSlugs();
        
        $url = false;

        if (array_key_exists($route, $slugs)):
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

		Response::test($url);
        


	}

	protected function writePublic($args) {
		$slugs = Routes::getSlugs();
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
