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

class Search extends LibraryService {

	private $results;

	public function __construct(Container $app) {
		parent::__construct($app);
	}

	public function search_all ($data) {
		$db = parent::$app['db'];

		
	}
}
