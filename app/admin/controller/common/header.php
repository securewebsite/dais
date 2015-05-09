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
        $data['title'] = $this->theme->getTitle();
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))):
            $data['base'] = $this->app['https.server'];
        else:
            $data['base'] = $this->app['http.server'];
        endif;
        
        $data['links']     = $this->theme->getLinks();
        $data['lang']      = $this->language->get('lang_code');
        $data['direction'] = $this->language->get('lang_direction');
        
        $this->css->register('dais.min')->register('editor.min', 'dais.min');
        
        $data = $this->theme->language('common/header', $data);
        
        if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])):
            $data['logged']    = '';
            $data['dashboard'] = $this->url->link('common/login', '', 'SSL');
        else:
            $data['logged'] = true;
        endif;
        
        $data             = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data['menu']     = $this->theme->controller('common/menu');

        $key              = $this->css->compile();
        $data['css_link'] = $this->app['https.public'] . 'asset/' . $this->app['theme.name'] . '/compiled/' . $this->app['filecache']->get_key($key, 'css');
        
        return $this->theme->view('common/header', $data);
    }
}
