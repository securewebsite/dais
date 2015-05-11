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
use Dais\Service\LibraryService;
use Memcache;

class Mem extends LibraryService {
    private $expire;
    private $cache;
    
    public function __construct($expire, $app) {
        parent::__construct($app);
        
        $this->expire = $expire;
        $this->cache = new Memcache;
    }
    
    public function connect() {
        return $this->cache->pconnect(parent::$app['cache.hostname'], parent::$app['cache.port']);
    }
    
    public function get($key) {
        if (!parent::$app['config_cache_status']):
            return false;
        endif;
        
        return $this->cache->get(parent::$app['cache.prefix'] . $key);
    }
    
    public function set($key, $value) {
        if (!parent::$app['config_cache_status']):
            return false;
        endif;
        
        $compress = is_bool($value) || is_int($value) || is_float($value) ? false : MEMCACHE_COMPRESSED;
        
        if (!$this->replace($key, $value)) return $this->cache->set(parent::$app['cache.prefix'] . $key, $value, $compress, $this->expire);
    }
    
    public function replace($key, $value) {
        $compress = is_bool($value) || is_int($value) || is_float($value) ? false : MEMCACHE_COMPRESSED;
        
        return $this->cache->replace(parent::$app['cache.prefix'] . $key, $value, $compress, $this->expire);
    }
    
    public function delete($key) {
        $this->cache->delete(parent::$app['cache.prefix'] . $key);
    }
    
    public function flush_cache() {
        $this->cache->flush();
    }
    
    public function check() {
        $test = new Memcache;
        return @$test->connect(parent::$app['cache.hostname'], parent::$app['cache.port']);
    }
}
