<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace Dais\Services\Providers\Boot;

class Request {
    
    public $get    = array();
    public $post   = array();
    public $cookie = array();
    public $files  = array();
    public $server = array();
    public $facade;
    
    public function __construct() {
        $this->get     = $this->clean($_GET);
        $this->post    = $this->clean($_POST);
        $this->request = $this->clean($_REQUEST);
        $this->cookie  = $this->clean($_COOKIE);
        $this->files   = $this->clean($_FILES);
        $this->server  = $this->clean($_SERVER);

        $route   = null;
        $face    = FRONT_FACADE;
        
        if (isset($this->get['_route_'])):
            $paths = explode('/', $this->get['_route_']);
            
            /**
             * The only facade that should never exist in $paths
             * is 'front', so our facade should be easy to detect.
             */
            if ($paths[0] === ADMIN_FACADE):
                $face = $paths[0];
                
                /**
                 * Set route with the alias removed
                 */
                array_shift($paths);
                
                if (!empty($paths)):
                    if ($face === FRONT_FACADE):
                        $route = implode('/', $paths);
                    else:
                        $route = null;
                    endif;
                endif;
            else:
                $route = $this->get['_route_'];
            endif;
        endif;

        // we'll need this to build configuarations
        $this->facade = $face;

        /**
         * Let's adjust the request to adhere to our facade.
         */
        
        $this->server['SCRIPT_NAME'] = str_replace(PUBLIC_DIR, '', $this->server['SCRIPT_NAME']);
        $this->server['PHP_SELF']    = str_replace(PUBLIC_DIR, '', $this->server['PHP_SELF']);
        
        if (!$route):
            unset($this->get['_route_']);
            unset($this->request['_route_']);
            unset($this->server['REDIRECT_QUERY_STRING']);
            $this->server['QUERY_STRING'] = '';
            $this->server['REQUEST_URI']  = '/';
        else:
            $this->get['_route_']                  = $route;
            $this->request['_route_']              = $route;
            $this->server['REDIRECT_QUERY_STRING'] = '_route_=' . $route;
            $this->server['QUERY_STRING']          = '_route_=' . $route;
            $this->server['REQUEST_URI']           = '/' . $route;
        endif;
        
        return $this;
    }
    
    public function clean($data) {
        if (is_array($data)):
            foreach ($data as $key => $value):
                unset($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            endforeach;
        else:
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        endif;
        
        return $data;
    }

    /**
     * Aliases methods for returning properties.
     */

    public function get($key, $value = null) {
        if (is_null($value)):
            return (isset($this->get[$key]) ? $this->get[$key] : null);
        endif;

        $this->get[$key] = $value;
    }

    public function post($key, $value = null) {
        if (is_null($value)):
            return (isset($this->post[$key]) ? $this->post[$key] : null);
        endif;

        $this->post[$key] = $value;
    }

    public function cookie($key, $value = null) {
        if (is_null($value)):
            return (isset($this->cookie[$key]) ? $this->cookie[$key] : null);
        endif;

        $this->cookie[$key] = $value;
    }

    public function files($key, $value = null) {
        if (is_null($value)):    
            return (isset($this->files[$key]) ? $this->files[$key] : null);
        endif;

        $this->files[$key] = $value;
    }

    public function server($key, $value = null) {
        if (is_null($value)):
            return (isset($this->server[$key]) ? $this->server[$key] : null);
        endif;

        $this->server[$key] = $value;
    }

    public function facade() {
        return $this->facade;
    }   
}
