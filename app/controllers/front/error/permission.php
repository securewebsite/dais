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

class Permission extends Controller {
    
    public function index() {
        $data = Theme::language('error/permission');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset(Request::p()->get['route'])):
            $routes = Request::get();
            unset($routes['_route_']);
            
            $route = $routes['route'];
            unset($routes['route']);
            
            $url = '';
            
            if ($routes):
                $url = '&' . urldecode(http_build_query($routes, '', '&'));
            endif;
            
            if (isset(Request::p()->server['https']) && ((Request::p()->server['https'] == 'on') || (Request::p()->server['https'] == '1'))):
                $connection = 'ssl';
            else:
                $connection = 'nonssl';
            endif;
            
            Breadcrumb::add('lang_heading_title', $route, $url, true, $connection);
        endif;
        
        $data['continue'] = Url::link(Theme::getstyle() . '/home');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);

        Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . '/1.1 401 Unauthorized');
        Response::setOutput(View::make('error/permission', $data));
    }
}
