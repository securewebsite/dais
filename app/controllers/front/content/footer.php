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

namespace App\Controllers\Front\Content;

use App\Controllers\Controller;

class Footer extends Controller {
    
    public function index() {
        $data = Theme::language('content/footer');
        
        $data['powered'] = sprintf(Lang::get('lang_text_powered'), date('Y', time()), Config::get('config_name'));
        $data['google_analytics'] = html_entity_decode(Config::get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        
        $route = 'content/home';
        
        if (isset(Request::p()->get['route'])):
            $route = Request::p()->get['route'];
        endif;
        
        $data['route'] = $route;
        
        if (Config::get('config_customer_online')):
            Theme::model('tool/online');
            
            if (isset(Request::p()->server['REMOTE_ADDR'])):
                $ip = Request::p()->server['REMOTE_ADDR'];
            else:
                $ip = '';
            endif;
            
            if (isset(Request::p()->server['HTTP_HOST']) && isset(Request::p()->server['REQUEST_URI'])):
                $url = 'http://' . Request::p()->server['HTTP_HOST'] . Request::p()->server['REQUEST_URI'];
            else:
                $url = '';
            endif;
            
            if (isset(Request::p()->server['HTTP_REFERER'])):
                $referer = Request::p()->server['HTTP_REFERER'];
            else:
                $referer = '';
            endif;
            
            ToolOnline::whosonline($ip, Customer::getId(), $url, $referer);
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);

        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))):
            $server = Config::get('config_ssl');
        else:
            $server = Config::get('config_url');
        endif;

        $key                   = JS::compile();
        $data['js_link']       = $server . 'asset/js/' . Filecache::get_key($key, 'js');
        $data['javascript']    = Theme::controller('common/javascript');
        $data['footer_blocks'] = Theme::controller('widget/footer_blocks');
        
        return View::make('content/footer', $data);
    }
}
