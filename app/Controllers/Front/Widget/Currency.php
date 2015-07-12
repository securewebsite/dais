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
        if (isset($this->request->post['currency_code'])) {
            $this->currency->set($this->request->post['currency_code']);
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            
            if (isset($this->request->post['redirect'])) {
                $this->response->redirect($this->request->post['redirect']);
            } else {
                $this->response->redirect(Url::link('shop/home'));
            }
        }
        
        $data = Theme::language('widget/currency');
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $connection = 'SSL';
        } else {
            $connection = 'NONSSL';
        }
        
        $data['action'] = Url::link('widget/currency', '', $connection);
        
        $data['currency_code'] = $this->currency->getCode();
        
        Theme::model('locale/currency');
        
        $data['currencies'] = array();
        
        $results = $this->model_locale_currency->getCurrencies();
        
        foreach ($results as $result) {
            if ($result['status']) {
                $data['currencies'][] = array('title' => $result['title'], 'code' => $result['code'], 'symbol_left' => $result['symbol_left'], 'symbol_right' => $result['symbol_right']);
            }
        }
        
        if (!isset($this->request->get['route'])) {
            $data['redirect'] = Url::link('shop/home');
        } else {
            $routes = $this->request->get;
            
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
        
        return Theme::view('widget/currency', $data);
    }
}
