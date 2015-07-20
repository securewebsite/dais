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

namespace App\Controllers\Front\Widget;

use App\Controllers\Controller;

class Language extends Controller {
    
    public function index() {
        if (isset(Request::p()->post['language_code'])) {
            Session::p()->data['language'] = Request::p()->post['language_code'];
            
            if (isset(Request::p()->post['redirect'])) {
                Response::redirect(Request::p()->post['redirect']);
            } else {
                Response::redirect(Url::link('shop/home'));
            }
        }
        
        $data = Theme::language('widget/language');
        
        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))) {
            $connection = 'SSL';
        } else {
            $connection = 'NONSSL';
        }
        
        $data['action'] = Url::link('widget/language', '', $connection);
        
        $data['language_code'] = Session::p()->data['language'];
        
        Theme::model('locale/language');
        
        $data['languages'] = array();
        
        $results = LocaleLanguage::getLanguages();
        
        foreach ($results as $result) {
            if ($result['status']) {
                $data['languages'][] = array('name' => $result['name'], 'code' => $result['code'], 'image' => $result['image']);
            }
        }
        
        if (!isset(Request::p()->get['route'])) {
            $data['redirect'] = Url::link('shop/home');
        } else {
            $routes = Request::get();
            
            unset($routes['_route_']);
            
            $route = $routes['route'];
            
            unset($routes['route']);
            
            $url = '';
            
            if ($routes) {
                $url = '&' . urldecode(http_build_query($routes, '', '&'));
            }
            
            $data['redirect'] = Url::link($route, $url, $connection);
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('widget/language', $data);
    }
}
