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

use Dais\Engine\Action;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class ActionService implements ServiceContract {

	public function register(Container $app) {
		App::registerProxy('Action', 'Dais\Facades\Action');

		$app['action'] = function($app) {
			return new Action;
		};
	}
}
