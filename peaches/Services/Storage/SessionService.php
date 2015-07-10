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

namespace Dais\Services\Storage;

use Dais\Services\Providers\Storage\Session;
use Dais\Base\Container;
use Dais\Contracts\ServiceContract;

class SessionService implements ServiceContract {

	public function register(Container $app) {
        $app['session'] = function ($app) {
            $session = new Session(Config::get('path.sessions'));
            
	        switch (Config::get('active.facade')):
	            case ADMIN_FACADE:
	                $session->admin_session();
	                break;

	            case FRONT_FACADE:
	                $session->front_session();
	                break;
	        endswitch;

            return $session;
        };
	}
}
