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

namespace Dais\Engine;
use Dais\Engine\Container;

abstract class Model {
    
    protected $app;
    
    public function __construct(Container $app) {
        $this->app = $app;
    }
    
    public function __get($key) {
        return $this->app[$key];
    }
    
    public function __set($key, $value) {
        $this->app[$key] = $value;
    }
}
