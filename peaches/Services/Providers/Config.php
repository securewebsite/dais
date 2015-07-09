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

namespace Dais\Services\Providers;

class Config {
    private $data = array();
    
    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }
    
    public function set($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function has($key) {
        return isset($this->data[$key]);
    }

    public function drop($key) {
        if ($this->has($key)):
            unset($this->data[$key]);
        endif;
    }
}
