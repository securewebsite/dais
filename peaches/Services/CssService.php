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

use Dais\Services\Providers\Css;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class CssService implements ServiceContract {

	public function register(Container $app) {
		$app['css'] = function ($app) {
            return new Css;
        };
	}
}
