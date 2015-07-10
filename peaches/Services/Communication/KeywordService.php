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

namespace Dais\Services\Communication;

use Dais\Services\Providers\Communication\Keyword;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class KeywordService implements ServiceContract {

	public function register(Container $app) {
		$app['keyword'] = function ($app) {
            return new Keyword;
        };
	}
}
