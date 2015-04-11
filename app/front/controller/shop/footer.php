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

namespace Front\Controller\Shop;
use Dais\Engine\Controller;

class Footer extends Controller {
    public function index() {
        $data = $this->theme->language('shop/footer');
        
        $data['powered'] = sprintf($this->language->get('lang_text_powered'), date('Y', time()), $this->config->get('config_name'));
        $data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        
        $route = 'shop/home';
        
        if (isset($this->request->get['route'])):
            $route = $this->request->get['route'];
        endif;
        
        $data['route'] = $route;
        
        if ($this->config->get('config_customer_online')):
            $this->theme->model('tool/online');
            
            if (isset($this->request->server['REMOTE_ADDR'])):
                $ip = $this->request->server['REMOTE_ADDR'];
            else:
                $ip = '';
            endif;
            
            if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])):
                $url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
            else:
                $url = '';
            endif;
            
            if (isset($this->request->server['HTTP_REFERER'])):
                $referer = $this->request->server['HTTP_REFERER'];
            else:
                $referer = '';
            endif;
            
            $this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
        endif;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['js_link'] = $this->url->link('common/javascript/render', '&js=' . $this->javascript->compile(), 'SSL');
        $data['javascript'] = $this->theme->controller('common/javascript');
        $data['footer_blocks'] = $this->theme->controller('widget/footerblocks');
        
        return $this->theme->view('shop/footer', $data);
    }
}
