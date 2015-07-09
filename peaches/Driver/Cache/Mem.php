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

use Memcache;
use Dais\Contracts\CacheContract;

class Mem implements CacheContract {
    private $expire;
    private $cache;
    
    public function __construct() {
        $this->expire = \Config::get('cache.time');
        $this->cache  = new Memcache;
        $this->connect();
    }
    
    public function get($key, $type = false) {
        if (!\Config::get('cache.status')):
            return false;
        endif;
        
        return $this->cache->get(\Config::get('cache.prefix') . $key);
    }
    
    public function set($key, $value, $type = false, $expire = false) {
        if (!\Config::get('cache.status')):
            return false;
        endif;
        
        $compress = is_bool($value) || is_int($value) || is_float($value) ? false : MEMCACHE_COMPRESSED;
        
        if (!$this->replace($key, $value)):
            return $this->cache->set(\Config::get('cache.prefix') . $key, $value, $compress, $this->expire);
        endif;
    }
    
    public function delete($key, $type = false) {
        $this->cache->delete(\Config::get('cache.prefix') . $key);
    }
    
    public function flush_cache() {
        $this->cache->flush();
    }

    private function replace($key, $value) {
        $compress = is_bool($value) || is_int($value) || is_float($value) ? false : MEMCACHE_COMPRESSED;
        
        return $this->cache->replace(\Config::get('cache.prefix') . $key, $value, $compress, $this->expire);
    }

    public function connect() {
        return @$this->cache->pconnect(\Config::get('cache.hostname'), \Config::get('cache.port'));
    }
    
    public function check() {
        $test = new Memcache;
        return @$test->connect(\Config::get('cache.hostname'), \Config::get('cache.port'));
    }
}
