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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Cache extends LibraryService {
    private $cache;
    
    public function __construct($cache, Container $app) {
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
}
