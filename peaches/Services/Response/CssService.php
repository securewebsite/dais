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

use Dais\Services\Providers\Response\Css;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CssService implements ServiceProviderInterface {

	public function register(Container $app) {
		$app['css'] = function ($app) {
            return new Css;
        };
	}
}
