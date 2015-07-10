<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Dais\Facades;

use Dais\Base\Container;

abstract class Facade {
    
    protected static $container;

    public static function setContainer(Container $container) {

        static::$container = $container;
    }

    public static function getInstance() {

        if (!(static::$container instanceof Container)):
            throw new \RuntimeException('The Proxy Subject cannot be retrieved because the Container is not set.');
        endif;

        return static::$container->get(static::getInstanceIdentifier());
    }

    public static function getInstanceIdentifier() {

        throw new \BadMethodCallException('The' . __METHOD__ . ' method must be implemented by a subclass.');
    }

    public static function __callStatic($method, $args) {
        
        return call_user_func_array(array(static::getInstance(), $method), $args);
    }
}
