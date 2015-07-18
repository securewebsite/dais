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

use Foil\Foil;
use Pimple\Container;
use Foil\Extensions\Uri;
use Pimple\ServiceProviderInterface;

class ViewService implements ServiceProviderInterface {
 
	public function register(Container $app) {

        $app['foil.options'] = [
            'ext'            => 'tpl',
            'template_class' => 'Dais\Base\View',
            'folders'        => [$app['theme']->getPath() . 'view'],
        ];

        $app['foil.boostrap'] = function(Container $app) {
            return Foil::boot($app['foil.options']);
        };

        $app['foil.uri.options'] = [
            'host'   => env('APP_ENV'),
        ];

        $app['foil.uri'] = function(Container $app) {
            return new Uri();
        };

        $app['foil'] = function(Container $app) {
            $engine = $app['foil.boostrap']->engine();
            $engine->loadExtension($app['foil.uri'], $app['foil.uri.options']);

            return $engine;
        };
    } 
}
