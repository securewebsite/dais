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

use Dais\Services\Providers\Response\Response;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ResponseService implements ServiceProviderInterface {

	public function register(Container $app) {
		$app['response'] = function ($app) {
            $response = new Response;
	        $response->addHeader('Content-Type: text/html; charset=utf-8');
	        $response->setCompression(Config::get('config_compression'));

            return $response;
        };
	}
}
