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
        Theme::setTitle(Config::get('config_title'));
        Theme::setDescription(Config::get('config_meta_description'));
        
        Theme::setOgType('product');
        Theme::setOgDescription(html_entity_decode(Config::get('config_meta_description'), ENT_QUOTES, 'UTF-8'));
        
        $data['heading_title'] = Config::get('config_title');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        Theme::unset_controller('breadcrumb');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('shop/home', $data));
    }
}
