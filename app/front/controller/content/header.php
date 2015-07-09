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

namespace Front\Controller\Content;
use Dais\Engine\Controller;

class Header extends Controller {
    public function index() {
        $data['title'] = $this->theme->getTitle();
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))):
            $server = $this->config->get('config_ssl');
        else:
            $server = $this->config->get('config_url');
        endif;
        
        if (isset($this->session->data['error']) && !empty($this->session->data['error'])):
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        else:
            $data['error'] = '';
        endif;
        
        $this->css->register('dais')
            ->register('plugin', 'dais')
            ->register('blog', 'plugin')
            ->register('calendar', 'blog')
            ->register('video', 'calendar', true);
        
        $data['base']        = $server;
        $data['description'] = $this->theme->getDescription();
        $data['keywords']    = $this->theme->getKeywords();
        $data['links']       = $this->theme->getLinks();
        $data['lang']        = $this->language->get('lang_code');
        $data['direction']   = $this->language->get('lang_direction');
        $data['name']        = $this->config->get('config_name');
        
        if ($this->config->get('config_icon') && file_exists(Config::get('path.image') . $this->config->get('config_icon'))):
            $data['icon'] = $server . 'image/' . $this->config->get('config_icon');
        else:
            $data['icon'] = '';
        endif;
        
        if ($this->config->get('config_logo') && file_exists(Config::get('path.image') . $this->config->get('config_logo'))):
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        else:
            $data['logo'] = '';
        endif;
        
        // add our social graph here
        // set open graph props dynamically
        if (isset($this->request->get['_route_'])):
            $canonical_route = $this->request->get['_route_'];
        else:
            $canonical_route = '';
        endif;
        
        $this->theme->setCanonical($data['base'] . $canonical_route);
        $this->theme->setOgTitle($data['title']);
        $this->theme->setOgSite($this->config->get('config_name'));
        $this->theme->setOgUrl($data['base'] . $canonical_route);
        
        // set these as defaults, but these need to be updated in each controller
        // to set specific types and images when needed.
        
        if (!$this->theme->getOgType()):
            $this->theme->setOgType('website');
        endif;
        
        // og:image should always be at least 200px by 200px
        if (!$this->theme->getOgImage()):
            $this->theme->setOgImage($server . 'image/data/site-thumb.jpg');
        endif;
        
        // og:description set to meta description if not present
        if (!$this->theme->getOgDescription()):
            $this->theme->setOgDescription($data['description']);
        endif;
        
        // push these now to the header file
        $data['canonical']      = $this->theme->getCanonical();
        $data['og_image']       = $this->theme->getOgImage();
        $data['og_type']        = $this->theme->getOgType();
        $data['og_site_name']   = $this->theme->getOgSite();
        $data['og_title']       = $this->theme->getOgTitle();
        $data['og_url']         = $this->theme->getOgUrl();
        $data['og_description'] = $this->theme->getOgDescription();
        
        $data = $this->theme->language('content/header', $data);
        
        $data['text_wishlist'] = sprintf($this->language->get('lang_text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $data['text_welcome']  = sprintf($this->language->get('lang_text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
        $data['text_logged']   = sprintf($this->language->get('lang_text_logged'), $this->url->link('account/dashboard', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
        
        if ($this->theme->style === 'shop'):
            $data['home']           = $this->url->link('shop/home');
            $data['alternate']      = $this->url->link('content/home');
            $data['text_alternate'] = $this->language->get('lang_text_blog');
            $data['text_nav']       = $this->language->get('lang_nav_blog');
        else:
            $data['home']           = $this->url->link('content/home');
            $data['alternate']      = $this->url->link('shop/home');
            $data['text_alternate'] = $this->language->get('lang_text_shop');
            $data['text_nav']       = $this->language->get('lang_nav_shop');
        endif;
        
        $data['blog_link'] = false;
        
        if ($this->config->get('config_home_page')):
            $data['blog_link'] = $this->url->link('content/home');
        endif;
        
        $homeroute = false;
        $data['schema_type'] = 'Article';
        
        if (!isset($this->request->get['route']) || $this->request->get['route'] == 'content/home'):
            $homeroute = true;
        endif;
        
        if ($homeroute):
            $data['schema_type'] = 'Website';
        endif;
        
        $data['wishlist']      = $this->url->link('account/wishlist', '', 'SSL');
        $data['logged']        = $this->customer->isLogged();
        $data['account']       = $this->url->link('account/dashboard', '', 'SSL');
        $data['shopping_cart'] = $this->url->link('checkout/cart');
        $data['checkout']      = $this->url->link('checkout/checkout', '', 'SSL');
        
        $status = true;
        
        if (isset($this->request->server['HTTP_USER_AGENT'])):
            $robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));
            foreach ($robots as $robot):
                if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false):
                    $status = false;
                    break;
                endif;
            endforeach;
        endif;
        
        // A dirty hack to try to set a cookie for the multi-store feature
        $this->theme->model('setting/store');
        
        $data['stores'] = array();
        
        if ($this->config->get('config_shared') && $status):
            $data['stores'][] = $server . 'asset/' . strtolower($this->theme->name) . '/js/crossdomain.php?session_id=' . $this->session->getId();
            $stores = $this->model_setting_store->getStores();
            foreach ($stores as $store):
                $data['stores'][] = $store['url'] . 'asset/' . strtolower($this->theme->name) . '/js/crossdomain.php?session_id=' . $this->session->getId();
            endforeach;
        endif;
        
        // Search
        if (isset($this->request->get['search'])):
            $data['search'] = $this->request->get['search'];
        else:
            $data['search'] = '';
        endif;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $key  = $this->css->compile();
        
        $data['css_link'] = $server . 'asset/' . Config::get('theme.name') . '/compiled/' . Filecache::get_key($key, 'css');
        $data['language'] = $this->theme->controller('widget/language');
        $data['currency'] = $this->theme->controller('widget/currency');
        $data['cart']     = $this->theme->controller('shop/cart');
        $data['menu']     = $this->theme->controller('widget/header_menu');
        
        return $this->theme->view('content/header', $data);
    }
}
