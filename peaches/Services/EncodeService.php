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


use Dais\Services\Providers\Encode;
use Dais\Services\Providers\Iconv;
use Dais\Services\Providers\Mbstring;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class EncodeService implements ServiceContract {

	public function register(Container $app) {
        $app['encode'] = function($app) {
            if (extension_loaded('mbstring')):
                mb_internal_encoding('UTF-8');
                $adapter = new Mbstring;
            elseif (function_exists('iconv')):
                $adapter = new Iconv;
            endif;

            return new Encode($adapter);
        };        
    }
}
