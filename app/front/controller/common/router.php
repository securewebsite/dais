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
use Dais\Support\Naming;

class Router extends Controller {

	public function index() {
		if (!is_null(Request::get('_route_'))):

			$segments = explode('/', Request::get('_route_'));

			if (!is_null(Naming::file_from_route($segments[0] . '/' . $segments[1]))):
				Request::get('route', implode('/', $segments));
			endif;

			
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

	private function isPlugin() {

	}

	private function isNative() {

	}
}
