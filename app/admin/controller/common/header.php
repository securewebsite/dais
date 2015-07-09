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

namespace Admin\Controller\Common;
use Dais\Engine\Controller;

class Header extends Controller {
    public function index() {
        $data['title'] = Theme::getTitle();
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))):
            $data['base'] = Config::get('https.server');
        else:
            $data['base'] = Config::get('http.server');
        endif;
        
        $data['links']     = Theme::getLinks();
        $data['lang']      = Lang::get('lang_code');
        $data['direction'] = Lang::get('lang_direction');
        
        CSS::register('dais.min')
            ->register('editor.min', 'dais.min');
        
        $data = Theme::language('common/header', $data);
        
        if (!User::isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])):
            $data['logged']    = '';
            $data['dashboard'] = Url::link('common/login', '', 'SSL');
        else:
            $data['logged'] = true;
        endif;
        
        $data             = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data['menu']     = Theme::controller('common/menu');

        $key              = CSS::compile();
        $data['css_link'] = Config::get('https.public') . 'asset/' . Config::get('theme.name') . '/compiled/' . Filecache::get_key($key, 'css');
        
        return Theme::view('common/header', $data);
    }
}
