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

namespace Dais\Services\Response;

use Dais\Services\Providers\Response\Javascript;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class JavascriptService implements ServiceProviderInterface {

	public function register(Container $app) {
		$app['javascript'] = function ($app) {
            return new Javascript;
        };
	}
}
