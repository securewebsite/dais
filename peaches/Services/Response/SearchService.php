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

use Dais\Services\Providers\Response\Search;
use Dais\Base\Container;
use Dais\Contracts\ServiceContract;

class SearchService implements ServiceContract {

	public function register(Container $app) {
		$app['search'] = function ($app) {
            return new Search;
        };
	}
}
