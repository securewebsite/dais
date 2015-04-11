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

namespace Plugin\Example\Admin\Events;
use Dais\Engine\Container;
use Dais\Engine\Plugin;

class Adminevent extends Plugin {
    public function __construct(Container $app) {
        parent::__construct($app);
        parent::setPlugin('example');
    }
    
    // Add call back methods for events below
    public function editProduct($data) {
        
        // triggered on admin_edit_product
        
        $this->response->redirect($this->url->link('tool/errorlog', 'token=' . $this->session->data['token'], 'SSL'));
    }
}
