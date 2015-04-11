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

namespace Plugin\Example\Admin\Controller;
use Dais\Engine\Container;
use Dais\Engine\Plugin;

class Example extends Plugin {
    public function __construct(Container $app) {
        parent::__construct($app);
        parent::setPlugin('example');
    }
    
    public function index() {
        $data = $this->language('example');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_text_plugin', 'module/plugin');
        $this->breadcrumb->add('lang_heading_title', 'plugin/example');
        
        $data['header']     = $this->theme->controller('common/header');
        $data['breadcrumb'] = $this->theme->controller('common/breadcrumb');
        $data['footer']     = $this->theme->controller('common/footer');
        
        $this->response->setOutput($this->view('example', $data));
    }
}
