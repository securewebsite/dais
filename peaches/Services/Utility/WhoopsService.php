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

namespace Dais\Services\Utility;

use Whoops\Run;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Whoops\Handler\PrettyPageHandler;

class WhoopsService implements ServiceProviderInterface {

	public function register(Container $app) {
		
		$whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();

		$app['whoops'] = function($app) use($whoops) {
            return $whoops;
        };
	}
}