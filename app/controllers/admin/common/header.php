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

namespace App\Controllers\Admin\Common;

use App\Controllers\Controller;

class Header extends Controller {
    
    public function index() {
        $data['title'] = Theme::getTitle();
        
        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))):
            $data['base'] = Config::get('https.server');
        else:
            $data['base'] = Config::get('http.server');
        endif;
        
        $data['links']     = Theme::getLinks();
        $data['lang']      = Lang::get('lang_code');
        $data['direction'] = Lang::get('lang_direction');
        
        $data = Theme::language('common/header', $data);
        
        if (!User::isLogged() || !Response::match()):
            $data['logged']    = '';
            $data['dashboard'] = Url::link('common/login', '', 'SSL');
        else:
            $data['logged'] = true;
        endif;
        
        $data             = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data['menu']     = Theme::controller('common/menu');
        
        $key              = CSS::compile();
        $data['css_link'] = Config::get('https.public') . 'asset/css/' . Filecache::get_key($key, 'css');
        
        return View::make('common/header', $data);
    }
}
