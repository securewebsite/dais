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

namespace Dais\Services\Boot;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Dais\Services\Providers\Boot\Config;

class ConfigService implements ServiceProviderInterface {

	public function register(Container $app) {
		// convert our global $_ENV to a more elegant array for paths
        $env = array();

        foreach($_ENV as $key => $value):
            $env[strtolower(str_replace('_', '.', $key))] = $value;
        endforeach;
        
        $app['config'] = function ($app) use($env) {
            return new Config($app, $env);
        };
	}
}
