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
        if (isset($this->request->post['language_code'])) {
            $this->session->data['language'] = $this->request->post['language_code'];
            
            if (isset($this->request->post['redirect'])) {
                Response::redirect($this->request->post['redirect']);
            } else {
                Response::redirect(Url::link('shop/home'));
            }
        }
        
        $data = Theme::language('widget/language');
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $connection = 'SSL';
        } else {
            $connection = 'NONSSL';
        }
        
        $data['action'] = Url::link('widget/language', '', $connection);
        
        $data['language_code'] = $this->session->data['language'];
        
        Theme::model('locale/language');
        
        $data['languages'] = array();
        
        $results = LocaleLanguage::getLanguages();
        
        foreach ($results as $result) {
            if ($result['status']) {
                $data['languages'][] = array('name' => $result['name'], 'code' => $result['code'], 'image' => $result['image']);
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
        
        return View::render('widget/language', $data);
    }
}
