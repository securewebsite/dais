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

use Dais\Services\Providers\Db;
use Dais\Driver\Database\Mpdo;
use Dais\Driver\Database\Mysqli;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class DatabaseService implements ServiceContract {

	public function register(Container $app) {
        $app['db'] = function ($app) {
			switch(env('DB_DRIVER')):
                case 'mpdo':
                case 'mysql':
                    $driver = new Mpdo;
                    break;
                case 'mysqli':
                    $driver = new Mysqli; 
                    break;
            endswitch;

            return new Db($driver);
		};
	}
}
