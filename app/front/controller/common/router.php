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

namespace Front\Controller\Common;

use Dais\Engine\Controller;
use Dais\Engine\Action;
use NoahBuscher\Macaw\Macaw;

class Router extends Controller {

	public function index() {
		
		Macaw::get('/', function() {
			$home = Config::get('config_site_style') . '/home';
			Request::get('route', $home);
		});

		Macaw::get('/(:any)', function($slug) {
			$result = $this->iterate($slug);
			//var_dump($result);
			if (!empty($result)):
				
				Request::get('route', $result[0]);
				
				if (isset($result[1])):
					Request::get($result[1], $result[2]);
				endif;
				
			endif;
			
		});

		Macaw::dispatch();

		if(is_null(Request::get('route'))):
			Request::get('route', 'error/not_found');
		endif;

		return new Action(Request::get('route'));
	}

	private function iterate($search) {
		
		$routes = Routes::allRoutes();
		
		$result = [];
		
		foreach($routes as $route):
			if ($route['slug'] === $search):
				$result[] = $route['route'];
				if (!isset($route['query'])):
					// this is a custom route
					return $result;
				endif;
				$items    = explode(':', $route['query']);
				$result[] = $items[0];
				$result[] = $items[1];
			endif;
		endforeach;

		return $result;
	}
}
