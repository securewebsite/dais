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
                $this->response->redirect($this->request->post['redirect']);
            } else {
                $this->response->redirect($this->url->link('shop/home'));
            }
        }
        
        $data = $this->theme->language('widget/language');
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $connection = 'SSL';
        } else {
            $connection = 'NONSSL';
        }
        
        $data['action'] = $this->url->link('widget/language', '', $connection);
        
        $data['language_code'] = $this->session->data['language'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = array();
        
        $results = $this->model_localization_language->getLanguages();
        
        foreach ($results as $result) {
            if ($result['status']) {
                $data['languages'][] = array('name' => $result['name'], 'code' => $result['code'], 'image' => $result['image']);
            }
        }
        
        if (!isset($this->request->get['route'])) {
            $data['redirect'] = $this->url->link('shop/home');
        } else {
            $routes = $this->request->get;
            
            unset($routes['_route_']);
            
            $route = $routes['route'];
            
            unset($routes['route']);
            
            $url = '';
            
            if ($routes) {
                $url = '&' . urldecode(http_build_query($routes, '', '&'));
            }
            
            $data['redirect'] = $this->url->link($route, $url, $connection);
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/language', $data);
    }
}
