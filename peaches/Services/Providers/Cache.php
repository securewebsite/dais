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

use Dais\Contracts\CacheContract;

class Cache {
    private $cache;
    
    public function __construct(CacheContract $cache) {
        $this->cache = $cache;
    }
    
    public function get($key) {
        return $this->cache->get($key);
    }
    
    public function set($key, $value) {
        return $this->cache->set($key, $value);
    }
    
    public function delete($key) {
        return $this->cache->delete($key);
    }
    
    public function flush_cache() {
        return $this->cache->flush_cache();
    }

    /**
     * Asset driver specific
     */
    public function get_key($key, $type) {
        return $this->cache->get_key($key, $type);
    }

    public function set_asset($key, $value, $type) {
        return $this->cache->set($key, $value, $type);
    }

    public function get_asset($key, $type) {
        return $this->cache->get($key, $type);
    }

    public function delete_asset($key, $type) {
        return $this->cache->delete($key, $type);
    }
}
