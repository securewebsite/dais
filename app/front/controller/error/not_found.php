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


namespace Front\Controller\Error;
use Dais\Engine\Controller;

class NotFound extends Controller {
    public function index() {
        $data = $this->theme->language('error/not_found');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
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
            
            $this->breadcrumb->add('lang_breadcrumb_error', $route, $url, true, $connection);
        endif;
        
        $this->response->addheader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 not found');

        $data['heading_title'] = $this->language->get('lang_page_title');
        $data['continue']      = $this->url->link('shop/home');
        $data['text_error']    = $this->language->get('lang_text_error');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('error/not_found', $data));
    }
}
