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

use Dais\Services\Providers\Boot\Request;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RequestService implements ServiceProviderInterface {

    public function register(Container $app) {

        $app['request'] = function ($app) {
            return new Request;
        };
    }
}
