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

use Dais\Base\View;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ViewService implements ServiceProviderInterface {
    
       public function register(Container $app) {
            $app['view'] = function (Container $app) {
                return new View(Theme::getPath());
            };
       } 
}
