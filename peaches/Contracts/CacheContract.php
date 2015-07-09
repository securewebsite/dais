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

namespace Dais\Contracts;

interface CacheContract {

	public function get($key, $type);

	public function set($key, $value, $type, $expire);

	public function delete($key, $type);

	public function flush_cache();
}
