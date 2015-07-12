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

namespace Dais\Services\Base;

use Dais\Services\Providers\Base\Router;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RouterService implements ServiceProviderInterface {

	public function register(Container $app) {
		$app['router'] = function ($app) {
            return new Router;
        };
	}
}
