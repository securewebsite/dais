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

namespace Front\Controller\Search;
use Dais\Engine\Controller;

class Search extends Controller {

	public function index() {
		if (isset($this->request->post['search'])):
			$this->theme->test($this->request->post['search']);
		endif;
	}
}
