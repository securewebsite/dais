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


namespace App\Controllers\Front\Error;

use App\Controllers\Controller;

class NotFound extends Controller {
    
    public function index() {
        $data = Theme::language('error/not_found');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset($this->request->get['route'])):
            $routes = $this->request->get;
            
            unset($routes['_route_']);
            
            $route = $routes['route'];
            
            unset($routes['route']);
            
            $url = '';
            
            if ($routes):
                $url = '&' . urldecode(http_build_query($routes, '', '&'));
            endif;
            
            if (isset($this->request->server['https']) && (($this->request->server['https'] == 'on') || ($this->request->server['https'] == '1'))):
                $connection = 'ssl';
            else:
                $connection = 'nonssl';
            endif;
            
            Breadcrumb::add('lang_breadcrumb_error', $route, $url, true, $connection);
        endif;
        
        Response::addheader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 not found');

        $data['heading_title'] = Lang::get('lang_page_title');
        $data['continue']      = Url::link('shop/home');
        $data['text_error']    = Lang::get('lang_text_error');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('error/not_found', $data));
    }
}
