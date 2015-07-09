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

namespace Dais\Driver\Cache;

use Dais\Contracts\CacheContract;

class Apc implements CacheContract {
    
    private $expire;
    
    public function __construct() {
        $this->expire = \Config::get('cache.time');
    }
    
    public function get($key, $type = false) {
        if (!\Config::get('cache.status')):
            return false;
        endif;
        
        return apc_fetch(\Config::get('cache.prefix') . $key);
    }
    
    public function set($key, $value, $type = false, $expire = false) {
         if (!\Config::get('cache.status')):
            return false;
        endif;
        
        return apc_store(\Config::get('cache.prefix') . $key, $value, $this->expire);
    }
    
    public function delete($key, $type = false) {
        apc_delete(\Config::get('cache.prefix') . $key);
    }
    
    public function flush_cache() {
        apc_clear_cache();
    }
}
