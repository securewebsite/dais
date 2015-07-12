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

namespace App\Controllers\Front\Shop;
use App\Controllers\Controller;

class Footer extends Controller {
    public function index() {
        $data = Theme::language('shop/footer');
        
        $data['powered'] = sprintf(Lang::get('lang_text_powered'), date('Y', time()), Config::get('config_name'));
        $data['google_analytics'] = html_entity_decode(Config::get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        
        $route = 'shop/home';
        
        if (isset($this->request->get['route'])):
            $route = $this->request->get['route'];
        endif;
        
        $data['route'] = $route;
        
        if (Config::get('config_customer_online')):
            Theme::model('tool/online');
            
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

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))):
            $server = Config::get('config_ssl');
        else:
            $server = Config::get('config_url');
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);

        $key             = JS::compile();
        $data['js_link'] = $server . 'asset/' . Config::get('theme.name') . '/compiled/' . Filecache::get_key($key, 'js');

        $data['javascript']    = Theme::controller('common/javascript');
        $data['footer_blocks'] = Theme::controller('widget/footer_blocks');
        
        return Theme::view('shop/footer', $data);
    }
}
