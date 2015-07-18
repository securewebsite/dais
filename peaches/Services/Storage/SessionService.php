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

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Dais\Driver\Session\FileHandler;
use Dais\Driver\Session\DatabaseHandler;
use Dais\Services\Providers\Storage\Session;

class SessionService implements ServiceProviderInterface {

	public function register(Container $app) {
        
		$session = new Session($app['config']->get('path.sessions'));
            
        switch ($app['config']->get('active.facade')):
            case ADMIN_FACADE:
                $session->admin_session(new FileHandler);
                break;

            case FRONT_FACADE:
                $session->front_session(new DatabaseHandler);
                break;
        endswitch;

        $app['session'] = function ($app) use($session) {
            return $session;
        };
	}
}
