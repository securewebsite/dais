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

/**
 * At present there are 4 types of searches.
 * 1. Products
 * 2. Posts
 * 3. Pages
 * 4. Customers
 */

class Search extends LibraryService {

	private $results;

	public function __construct(Container $app) {
		parent::__construct($app);
	}

	public function search_all ($data) {
		$db = parent::$app['db'];


	}

	public function tags ($tag) {
		$results = array();

		// products
		// posts
		// pages
		// customers
	}

	protected function search_products($data) {

	}

	protected function search_posts($data) {

	}

	protected function search_pages($data) {

	}

	protected function search_customers($data) {

	}
	
}
