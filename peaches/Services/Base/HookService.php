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

namespace Dais\Services\Base;

use Dais\Services\Providers\Base\Hook;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HookService implements ServiceProviderInterface {

	public function register(Container $app) {
		$hook = new Hook;
        $hooks = $hook->registerHooks();
        $app->set('plugin_hooks', $hooks);

		$app['hooks'] = function ($app) use ($hook) {
            return $hook;
        };
	}
}