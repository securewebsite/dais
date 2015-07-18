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

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Dais\Services\Providers\Storage\Encode;
use Dais\Services\Providers\Utility\Iconv;
use Dais\Services\Providers\Utility\Mbstring;

class EncodeService implements ServiceProviderInterface {

	public function register(Container $app) {
        if (extension_loaded('mbstring')):
            mb_internal_encoding('UTF-8');
            $adapter = new Mbstring;
        elseif (function_exists('iconv')):
            $adapter = new Iconv;
        endif;
            
        $app['encode'] = function($app) use($adapter) {
            return new Encode($adapter);
        };        
    }
}
