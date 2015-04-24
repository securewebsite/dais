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

namespace Front\Controller\Common;
use Dais\Engine\Controller;
use Dais\Engine\Action;
use Dais\Service\ActionService;

class Router extends Controller {
    
    public function index() {
        if (isset($this->request->get['_route_'])):
            $parts = explode('/', $this->request->get['_route_']);
            $slugs = $parts;
            
            // Search Routes
            if (!isset($this->request->get['route'])):
                if ($parts[0] == 'search'):
                    // we do have a search 
                    if (count($parts) > 2):
                        // this is a tag
                        $this->request->get['route'] = 'search/tag';
                        $this->request->post['tag']  = $parts[2];
                    else:
                        $this->request->get['route']   = 'search/search';
                        $this->request->post['search'] = end($parts);
                    endif;
                endif;
            endif;

            // Custom Routes
            if (!isset($this->request->get['route'])):
                foreach ($this->customRoutes() as $key => $value):
                    if ($this->request->get['_route_'] == $key):
                        $this->request->get['route'] = $value;
                    endif;
                endforeach;
            endif;
            
            // Slug Routes
            $routes = $this->get('routes');
            
            if (!isset($this->request->get['route'])):
                foreach ($slugs as $slug):
                    $slug = strtolower($slug);
                    foreach ($routes as $route => $details):
                        foreach ($details as $item):
                            if (in_array($slug, $item)):
                                $this->request->get['route'] = $route;
                                if ($item['slug'] === $slug):
                                    $url = explode(':', $item['query']);
                                    if ($url[0] == 'category_id'):
                                        if (!isset($this->request->get['path'])):
                                            $this->request->get['path'] = $url[1];
                                        else:
                                            $this->request->get['path'].= '_' . $url[1];
                                        endif;
                                        if (isset($this->request->get['product_id'])):
                                            $this->request->get['route'] = 'catalog/product';
                                        endif;
                                    elseif ($url[0] == 'manufacturer_id'):
                                        if (isset($this->request->get['product_id'])):
                                            $this->request->get['route'] = 'catalog/product';
                                        endif;
                                        $this->request->get[$url[0]] = $url[1];
                                    elseif ($url[0] == 'event_page_id'):
                                        $this->request->get['route'] = 'event/page';
                                        $this->request->get[$url[0]] = $url[1];
                                    elseif ($url[0] == 'page_id'):
                                        if (isset($slugs[2]) && $slugs[2] == 'info'):
                                            $this->request->get['route'] = 'content/page/info';
                                        endif;
                                        $this->request->get[$url[0]] = $url[1];
                                    elseif ($url[0] == 'blog_category_id'):
                                        if (!isset($this->request->get['bpath'])):
                                            $this->request->get['bpath'] = $url[1];
                                        else:
                                            $this->request->get['bpath'].= '_' . $url[1];
                                        endif;
                                        if (isset($this->request->get['post_id'])):
                                            $this->request->get['route'] = 'content/post';
                                        endif;
                                    elseif ($url[0] == 'post_id'):
                                        $this->request->get['route'] = 'content/post';
                                        $this->request->get[$url[0]] = $url[1];
                                    elseif ($url[0] == 'affiliate_id'): // affiliate routes
                                        if (!isset($this->request->cookie['referrer'])):
                                            setcookie('referrer', $url[1], time() + ((3600 * 24) * 365), '/');
                                        endif;
                                    else:
                                        $this->request->get[$url[0]] = $url[1];
                                    endif;
                                endif;
                            endif;
                        endforeach;
                    endforeach;
                endforeach;
            endif;
            
            unset($slugs);
            
            // Native Routes
            if (!isset($this->request->get['route'])):
                if (count($parts) > 3) array_pop($parts);
                
                // plugin routes have to be manipulated
                $plugin = end($parts);
                
                // a native route will always have at least 2 segments
                if (count($parts) > 1):
                    $seek = $parts[0] . '/' . $parts[1];
                    
                    if (is_readable($this->app['path.plugin'] . $plugin . '/front/controller/' . $plugin . '.php')):
                        $this->request->get['route'] = $this->request->get['_route_'];
                    elseif (is_readable($this->app['path.theme'] . $this->app['theme.name'] . '/controller/' . $seek . '.php')):
                        $this->request->get['route'] = implode('/', $parts);
                    elseif (is_readable($this->app['path.application'] . 'controller/' . $seek . '.php')):
                        $this->request->get['route'] = implode('/', $parts);
                    endif;
                endif;
            endif;
            
            unset($parts);
            
            // No route found
            if (!isset($this->request->get['route'])):
                $this->request->get['route'] = 'error/notfound';
            endif;
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        if (isset($this->request->get['route'])):
            return new Action(new ActionService($this->app, $this->request->get['route']));
        endif;
    }
    
    public function customRoutes() {
        $routes = $this->get('custom_routes');
        $routes = $this->theme->listen(__CLASS__, __FUNCTION__, $routes);
        
        return $routes;
    }
}
