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

namespace Dais\Services\Providers\Base;

class Router {

	protected static $current;
	protected static $route;

	public function dispatch() {

		if (!is_null(Request::get('_route_'))):

			static::$current = Request::get('_route_');

			$segments   = explode('/', static::$current);
			
			$controller = count($segments) > 1 ? $segments[0] . '/' . $segments[1] : $segments[0];

			// This handles all of our search routing
            if ($segments[0] == 'search'):
                Request::get('route', 'search/search');

                static::$route = 'search/search';

                if (end($segments) !== 'search'):
                    Request::post('search', end($segments));
                endif;
            endif;
			
			// This handles all native files :not custom routes
			if (!static::$route):
				if (!is_null(Naming::file_from_route($controller))):
					$args = (count($segments) % 2) ? static::to_assoc(3) : static::to_assoc(2);
					
					foreach($args as $key => $value):
						Request::get($key, $value);
					endforeach;
					
				endif;
			endif;
			
			// This handles any custom routes
			if (!static::$route):
				foreach (Routes::getCustomRoutes() as $key => $value):
	                if ($key === static::$current):
	                    if (!is_null(Naming::file_from_route($value))):
	                    	static::$route = $value;
						endif;
	                endif;
	            endforeach;
            endif;

            // This handles all slug routes
            if (!static::$route):
	            $result = $this->iterate($segments);
				
				if (!empty($result)):
					static::$route = $result['controller'];
				endif;
			endif;
			
		endif;

		$error = new Action('error/not_found');

        switch (Config::get('active.facade')):
            case FRONT_FACADE:
                $default = new Action (Config::get('config_site_style') . '/home');
                break;
            case ADMIN_FACADE:
                $default = new Action('common/dashboard');
                break;
        endswitch;
        
        $route = (static::$route) ? static::$route : 'error/not_found';
        
        Request::get('route', $route);

        $actions['action'] = (static::$route) ? new Action(static::$route) : $default;
        $actions['error']  = $error;

        return $actions;
	}

	private function iterate($search) {
		
		$routes = Routes::allRoutes();
		
		$result = [];

		// Blog and Product Category Holders
		$blog    = false;
		$bpath   = '';

		$product = false;
		$path    = '';
		
		foreach($search as $segment):
			foreach($routes as $route):
				if ($route['slug'] === $segment):
					$items = explode(':', $route['query']);
					$result['controller'] = $route['route'];
					switch ($items[0]):
						case 'blog_category_id':
							$blog   = true;
							$bpath .= '_' . $items[1];
							break;
						case 'category_id':
							$product = true;
							$path   .= '_' . $items[1];
							break;
						case 'post_id':
							Request::get('post_id', $items[1]);
							break;
						case 'product_id':
							Request::get('product_id', $items[1]);
							break;
						case 'manufacturer_id':
							Request::get('manufacturer_id', $items[1]);
							break;
						case 'event_page_id':
							Request::get('event_page_id', $items[1]);
							break;
						case 'page_id':
							Request::get('page_id', $items[1]);
							break;
					endswitch;
				endif;
			endforeach;
		endforeach;

		if ($blog):
			Request::get('bpath', ltrim($bpath, '_'));
		endif;

		if ($product):
			Request::get('path',  ltrim($path, '_'));
		endif;

		return $result;
	}

	public static function to_assoc($offset = 0) {
		$segments  = explode('/', static::$current);
		$arguments = [];
		$route     = [];

		for ($i = 0; $i < $offset; $i++):
			$route[] = array_shift($segments);
		endfor;
		
		$length = count($segments);

		static::$route = implode('/', $route);

		for ($i = 0; $i < $length; $i = $i + 2):
			$arguments[str_replace('-', '_', $segments[$i])] = $segments[$i + 1];
		endfor;
		
		return $arguments;
	}
}
