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

use Dais\Services\Proxy\ProxyManager;
use Dais\Services\Proxy\ContainerAdapter;
use Dais\Engine\Container;

class Proxy {

	private $proxy;

	public function __construct(Container $app) {
		$this->proxy = new ProxyManager(new ContainerAdapter($app));
		$this->proxy->addProxy('Proxy', 'Dais\Facades\Proxy');
		$this->proxy->enable(ProxyManager::ROOT_NAMESPACE_ANY);
		
		return $this->proxy;
	}

	public function enable() {
		return $this->proxy->enable(ProxyManager::ROOT_NAMESPACE_ANY);
	}

	public function add($key, $class) {
		return $this->proxy->addProxy($key, $class);
	}
}
