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

namespace Dais;

use Laravel\Lumen\Application;

class Api extends Application {

	public function __construct($basePath = null) {
		parent::__construct($basePath);
	}

	public function version() {
		return 'Peach (' . env('APP_VERSION') . ') (Dais Components 1.0.*)';
	}
}
