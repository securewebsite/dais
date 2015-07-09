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

use Dais\Services\Providers\Cache;
use Dais\Driver\Cache\Apc;
use Dais\Driver\Cache\File;
use Dais\Driver\Cache\Mem;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class CacheService implements ServiceContract {

	public function register(Container $app) {
        $app['cache'] = function($app) {
            switch (Config::get('config_cache_type_id')):
                case 'apc':
                    $driver = new Apc;
                    break;
                case 'mem':
                    $driver = new Mem;
                    $driver->connect();
                    break;
                case 'file':
                    $driver = new File;
                    break;
            endswitch;

            return new Cache($driver);
        };
	}
}
