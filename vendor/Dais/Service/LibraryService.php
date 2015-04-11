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

namespace Dais\Service;
use Dais\Engine\Container;

abstract class LibraryService {
    
    protected static $app;
    
    public function __construct(Container $app) {
        self::$app = $app;
    }
    
    public function __get($key) {
        return self::$app[$key];
    }
    
    /**
     * Use the parent::$app[$key] = $value method
     * to add any key/value parameters to the container.
     */
    public function __set($key, $value) {
        self::$app[$key] = $value;
    }
    
    /**
     * Use the parent::push($key, $class) method to create
     * a new service on the container. $class to be the full
     * namespace to the class to instantiate.
     */
    public function push($key, $class) {
        self::$app[$key] = function ($app) use ($class) {
            return new $class($app);
        };
    }
}
