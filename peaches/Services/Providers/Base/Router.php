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

use Dais\Support\Naming;
use Dais\Engine\Action;

class Router {

	public function dispatch() {

		if (!is_null(Request::get('_route_'))):

			$segments   = explode('/', Request::get('_route_'));
			
			$controller = count($segments) > 1 ? $segments[0] . '/' . $segments[1] : $segments[0];

			// This handles all native files :not custom routes
			if (!is_null(Naming::file_from_route($controller))):
				Request::get('route', implode('/', $segments));

				return new Action(Request::get('route'));
			endif;
			
			// This handles any custom routes
			foreach (Routes::getCustomRoutes() as $key => $value):
                if ($key === Request::get('_route_')):
                    if (!is_null(Naming::file_from_route($value))):
                    	Request::get('route', $value);

						return new Action(Request::get('route'));
					endif;
                endif;
            endforeach;

            // This handles all slug routes
            
			
		endif;


		//exit;
	}
}
