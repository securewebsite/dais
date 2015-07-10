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

namespace Dais\Services\Boot;

use Dais\Services\Providers\Boot\Request;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class RequestService implements ServiceContract {

	private $request;

    public function register(Container $app) {
        $this->request = new Request;
        
        $configs = $this->build($app['boot.config']);

        App::removeBootConfig();
        App::setSettingConfig($configs);
        
        $app['request'] = function ($app) {
            return $this->request;
        };
    }

	private function build($config) {
		$configuration = array();

        foreach ($config['base'] as $key => $value):
            $configuration[$key] = $value;
        endforeach;
        
        unset($config['base']);

        /**
         * Let's detect our app facade according to our request variables;
         * We need to hard set a route for this $request so we can pass it
         * to our IoC Request object.
         */
        $route   = null;
        $face    = FRONT_FACADE;
        
        if (isset($this->request->get['_route_'])):
            $paths = explode('/', $this->request->get['_route_']);
            
            /**
             * The only facade that should never exist in $paths
             * is 'front', so our facade should be easy to detect.
             */
            if (array_key_exists($paths[0], $config)):
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
                $route = $this->request->get['_route_'];
            endif;
        endif;
        
        // Add facade to config
        $configuration['active.facade'] = $face;

        /**
         * Let's adjust the request to adhere to our facade.
         */
        
        $this->request->server['SCRIPT_NAME'] = str_replace(PUBLIC_DIR, '', $this->request->server['SCRIPT_NAME']);
        $this->request->server['PHP_SELF']    = str_replace(PUBLIC_DIR, '', $this->request->server['PHP_SELF']);
        
        if (!$route):
            unset($this->request->get['_route_']);
            unset($this->request->request['_route_']);
            unset($this->request->server['REDIRECT_QUERY_STRING']);
            $this->request->server['QUERY_STRING'] = '';
            $this->request->server['REQUEST_URI']  = '/';
        else:
            $this->request->get['_route_']                  = $route;
            $this->request->request['_route_']              = $route;
            $this->request->server['REDIRECT_QUERY_STRING'] = '_route_=' . $route;
            $this->request->server['QUERY_STRING']          = '_route_=' . $route;
            $this->request->server['REQUEST_URI']           = '/' . $route;
        endif;


        
        /**
         * Let's find and remove our pre-render controllers for this facade.
         * Instead of settings those via the loop below, we'll remove them
         * and give them a specific parameter name so we can accurately
         * access them in our Theme class.
         */
        
        if (is_array($config[$face]['pre_render'])):
            $configuration['pre.controllers'] = $config[$face]['pre_render'];
            unset($config[$face]['pre_render']);
        endif;
        
        /**
         * Let's find and remove our pre-actions for this facade.
         * Instead of settings those via the loop below, we'll remove them
         * and give them a specific parameter name so we can accurately
         * access them in our Front class.
         */
        
        if (is_array($config[$face]['pre_actions'])):
            $configuration['pre.actions'] = $config[$face]['pre_actions'];
            unset($config[$face]['pre_actions']);
        endif;
        
        /**
         * Add remaining config to configuration array
         */
        
        foreach ($config[$face] as $key => $value):
            $configuration[$key] = $value;
        endforeach;

        unset($config);
        
        return $configuration;
	}
}
