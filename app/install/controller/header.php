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

namespace Install\Controller;
use Dais\Engine\Controller;

class Header extends Controller {
    public function index() {
        $data['title'] = $this->theme->getTitle();
        $data['base'] = $this->get('http.server');
        
        $data['home'] = $this->url->link('');
        
        return $this->theme->view('header', $data);
    }
}
