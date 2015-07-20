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

class Header extends Controller {
    
    public function index() {
        $data['title'] = Theme::getTitle();
        
        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))):
            $server = Config::get('config_ssl');
        else:
            $server = Config::get('config_url');
        endif;
        
        if (isset(Session::p()->data['error']) && !empty(Session::p()->data['error'])):
            $data['error'] = Session::p()->data['error'];
            unset(Session::p()->data['error']);
        else:
            $data['error'] = '';
        endif;
        
        $data['base']        = $server;
        $data['description'] = Theme::getDescription();
        $data['keywords']    = Theme::getKeywords();
        $data['links']       = Theme::getLinks();
        $data['lang']        = Lang::get('lang_code');
        $data['direction']   = Lang::get('lang_direction');
        $data['name']        = Config::get('config_name');
        
        if (Config::get('config_icon') && file_exists(Config::get('path.image') . Config::get('config_icon'))):
            $data['icon'] = $server . 'image/' . Config::get('config_icon');
        else:
            $data['icon'] = '';
        endif;
        
        if (Config::get('config_logo') && file_exists(Config::get('path.image') . Config::get('config_logo'))):
            $data['logo'] = $server . 'image/' . Config::get('config_logo');
        else:
            $data['logo'] = '';
        endif;
        
        // add our social graph here
        // set open graph props dynamically
        if (isset(Request::p()->get['_route_'])):
            $canonical_route = Request::p()->get['_route_'];
        else:
            $canonical_route = '';
        endif;
        
        Theme::setCanonical($data['base'] . $canonical_route);
        Theme::setOgTitle($data['title']);
        Theme::setOgSite(Config::get('config_name'));
        Theme::setOgUrl($data['base'] . $canonical_route);
        
        // set these as defaults, but these need to be updated in each controller
        // to set specific types and images when needed.
        
        if (!Theme::getOgType()):
            Theme::setOgType('website');
        endif;
        
        // og:image should always be at least 200px by 200px
        if (!Theme::getOgImage()):
            Theme::setOgImage($server . 'image/data/site-thumb.jpg');
        endif;
        
        // og:description set to meta description if not present
        if (!Theme::getOgDescription()):
            Theme::setOgDescription($data['description']);
        endif;
        
        // push these now to the header file
        $data['canonical']      = Theme::getCanonical();
        $data['og_image']       = Theme::getOgImage();
        $data['og_type']        = Theme::getOgType();
        $data['og_site_name']   = Theme::getOgSite();
        $data['og_title']       = Theme::getOgTitle();
        $data['og_url']         = Theme::getOgUrl();
        $data['og_description'] = Theme::getOgDescription();
        
        $data = Theme::language('content/header', $data);
        
        $data['text_wishlist'] = sprintf(Lang::get('lang_text_wishlist'), (isset(Session::p()->data['wishlist']) ? count(Session::p()->data['wishlist']) : 0));
        $data['text_welcome']  = sprintf(Lang::get('lang_text_welcome'), Url::link('account/login', '', 'SSL'), Url::link('account/register', '', 'SSL'));
        $data['text_logged']   = sprintf(Lang::get('lang_text_logged'), Url::link('account/dashboard', '', 'SSL'), Customer::getFirstName(), Url::link('account/logout', '', 'SSL'));
        
        if (Theme::getstyle() === 'shop'):
            $data['home']           = Url::link('shop/home');
            $data['alternate']      = Url::link('content/home');
            $data['text_alternate'] = Lang::get('lang_text_blog');
            $data['text_nav']       = Lang::get('lang_nav_blog');
        else:
            $data['home']           = Url::link('content/home');
            $data['alternate']      = Url::link('shop/home');
            $data['text_alternate'] = Lang::get('lang_text_shop');
            $data['text_nav']       = Lang::get('lang_nav_shop');
        endif;
        
        $data['blog_link'] = false;
        
        if (Config::get('config_home_page')):
            $data['blog_link'] = Url::link('content/home');
        endif;
        
        $homeroute = false;
        $data['schema_type'] = 'Article';
        
        if (!isset(Request::p()->get['route']) || Request::p()->get['route'] == 'content/home'):
            $homeroute = true;
        endif;
        
        if ($homeroute):
            $data['schema_type'] = 'Website';
        endif;
        
        $data['wishlist']      = Url::link('account/wishlist', '', 'SSL');
        $data['logged']        = Customer::isLogged();
        $data['account']       = Url::link('account/dashboard', '', 'SSL');
        $data['shopping_cart'] = Url::link('checkout/cart');
        $data['checkout']      = Url::link('checkout/checkout', '', 'SSL');
        
        $status = true;
        
        if (isset(Request::p()->server['HTTP_USER_AGENT'])):
            $robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim(Config::get('config_robots'))));
            foreach ($robots as $robot):
                if ($robot && strpos(Request::p()->server['HTTP_USER_AGENT'], trim($robot)) !== false):
                    $status = false;
                    break;
                endif;
            endforeach;
        endif;
        
        // Search
        if (isset(Request::p()->get['search'])):
            $data['search'] = Request::p()->get['search'];
        else:
            $data['search'] = '';
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $key  = CSS::compile();
        
        $data['css_link'] = $server . 'asset/css/' . Filecache::get_key($key, 'css');
        $data['language'] = Theme::controller('widget/language');
        $data['currency'] = Theme::controller('widget/currency');
        $data['cart']     = Theme::controller('shop/cart');
        $data['menu']     = Theme::controller('widget/header_menu');
        
        return View::make('content/header', $data);
    }
}
