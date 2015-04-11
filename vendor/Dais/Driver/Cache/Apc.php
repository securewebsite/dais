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

class Apc extends LibraryService {
    private $expire;
    
    public function __construct($expire, $app) {
        parent::__construct($app);
        
        $this->expire = $expire;
    }
    
    public function get($key) {
        if (!parent::$app['config_cache_status']):
            return false;
        endif;
        
        return apc_fetch(parent::$app['cache.prefix'] . $key);
    }
    
    public function set($key, $value) {
        if (!parent::$app['config_cache_status']):
            return false;
        endif;
        
        return apc_store(parent::$app['cache.prefix'] . $key, $value, $this->expire);
    }
    
    public function delete($key) {
        apc_delete(parent::$app['cache.prefix'] . $key);
    }
    
    public function flush_cache() {
        apc_clear_cache();
    }
    
    public function getExpire() {
        return $this->expire;
    }
}
