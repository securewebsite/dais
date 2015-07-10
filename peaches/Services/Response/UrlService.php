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

use Dais\Services\Providers\Response\Url;
use Dais\Base\Container;
use Dais\Contracts\ServiceContract;

class UrlService implements ServiceContract {

	public function register (Container $app) {
		$app['url'] = function ($app) {
            $url    = Config::get('config_url');
            $secure = Config::get('config_secure');
            $ssl    = Config::get('config_ssl');
            
            return new Url($url, $secure ? $ssl : $url);
        };
	}
}
