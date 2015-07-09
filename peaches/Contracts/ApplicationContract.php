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

interface ApplicationContract {

	public function version();

	public function boot();

	public function registerServiceProviders(array $providers);

	public function registerProvider($provider);

	public function listLoadedServices();

	public function loadProxy($key, $class);

	public function setBasePath($basePath);

	public function basePath();

	public function get($key);

	public function set($key, $value);

	public function load($key, $class);

	public function has($key);

	public function fire();
}
