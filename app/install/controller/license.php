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

class License extends Controller {
    public function index() {
        
        $this->theme->setTitle('Dais Install || Step 1 - License');
        
        if (!is_readable($this->get('path.application') . 'dais.sql')):
            $this->response->redirect($this->url->link('welcome'));
        endif;
        
        $data['action'] = $this->url->link('preinstallation');
        
        $data['header'] = $this->theme->controller('header');
        $data['footer'] = $this->theme->controller('footer');
        
        $this->response->setOutput($this->theme->view('license', $data));
    }
}
