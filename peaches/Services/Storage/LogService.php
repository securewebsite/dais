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

namespace Dais\Services\Storage;

use Dais\Services\Providers\Storage\Log;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogService implements ServiceProviderInterface {

	public function register(Container $app) {
		$app['log'] = function ($app) {
            return new Log(Config::get('config_error_filename'), Config::get('path.logs'));
        };
	}
}
