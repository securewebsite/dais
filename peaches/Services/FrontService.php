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

namespace Dais\Services;

use Dais\Engine\Front;
use Dais\Engine\Action;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class FrontService implements ServiceContract {

	public function register(Container $app) {
		
		$app['front'] = function ($app) {
            $front = new Front;

            $error = new Action('error/not_found');

	        switch (Config::get('active.facade')):
	            case FRONT_FACADE:
	                $default = new Action (Config::get('config_site_style') . '/home');
	                break;
	            case ADMIN_FACADE:
	                $default = new Action('common/dashboard');
	                break;
	        endswitch;
	        
	        if (isset(Request::p()->get['route'])):
	            $action = new Action(Request::p()->get['route']);
	        else:
	            $action = $default;
	        endif;

	        $front->dispatch($action, $error);

            return $front;
        };
	}
}
