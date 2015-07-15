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


namespace App\Controllers\Front\Shop;
use App\Controllers\Controller;

class Home extends Controller {
    public function index() {
        $this->theme->setTitle($this->config->get('config_title'));
        $this->theme->setDescription($this->config->get('config_meta_description'));
        
        $this->theme->setOgType('product');
        $this->theme->setOgDescription(html_entity_decode($this->config->get('config_meta_description'), ENT_QUOTES, 'UTF-8'));
        
        $data['heading_title'] = $this->config->get('config_title');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->setController('header', 'shop/header');
        $this->theme->setController('footer', 'shop/footer');
        $this->theme->unsetController('breadcrumb');
        
        $data = $this->theme->renderControllers($data);
        
        $this->response->setOutput($this->theme->view('shop/home', $data));
    }
}
