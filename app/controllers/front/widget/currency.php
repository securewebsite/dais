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

class Currency extends Controller {
    
    public function index() {
        if (isset(Request::p()->post['currency_code'])) {
            \Currency::set(Request::p()->post['currency_code']);
            
            unset(Session::p()->data['shipping_method']);
            unset(Session::p()->data['shipping_methods']);
            
            if (isset(Request::p()->post['redirect'])) {
                Response::redirect(Request::p()->post['redirect']);
            } else {
                Response::redirect(Url::link('shop/home'));
            }
        }
        
        $data = Theme::language('widget/currency');
        
        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))) {
            $connection = 'SSL';
        } else {
            $connection = 'NONSSL';
        }
        
        $data['action'] = Url::link('widget/currency', '', $connection);
        
        $data['currency_code'] = \Currency::getCode();
        
        Theme::model('locale/currency');
        
        $data['currencies'] = array();
        
        $results = LocaleCurrency::getCurrencies();
        
        foreach ($results as $result) {
            if ($result['status']) {
                $data['currencies'][] = array('title' => $result['title'], 'code' => $result['code'], 'symbol_left' => $result['symbol_left'], 'symbol_right' => $result['symbol_right']);
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
        
        return View::render('widget/currency', $data);
    }
}
