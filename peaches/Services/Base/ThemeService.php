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

use Exception;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ThemeService implements ServiceProviderInterface {

	public function register(Container $app) {
		
		$file  = $app['config']->get('path.theme') . 
				 $app['config']->get('theme.name') . SEP . 
				 $app['config']->get('theme.name') . '.php';
				 
		$class = Naming::class_from_filename($file);

		$app['theme'] = function ($app) use($class) {
			return new $class;
        };
	}
}
