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

namespace Dais\Engine;

use Dais\Engine\Container;
use Dais\Engine\Action;
use Dais\Service\ActionService;
use Dais\Engine\Front;
use Dais\Engine\Theme;
use Dais\Library\Config;
use Dais\Library\Encode;
use Dais\Library\Error;
use Dais\Library\Log;
use Dais\Library\Request;
use Dais\Library\Response;
use Dais\Library\Url;

class Installer {
    public function __construct() {
        $this->data = new Container;
    }
    
    public function buildConfigRequest(array $config) {
        $configuration = array();
        
        foreach ($config['base'] as $key => $value):
            $configuration[$key] = $value;
        endforeach;
        
        unset($config['base']);
        
        /**
         * Let's detect our app fascade according to our request variables;
         * We need to hard set a route for this $request so we can pass it
         * to our IoC Request object.
         */
        $request = new Request($this->data);
        $route = null;
        $face = INSTALL_FASCADE;
        
        if (isset($request->get['_route_'])):
            $paths = explode('/', $request->get['_route_']);
            
            /**
             * The only fascade that should never exist in $paths
             * is 'front', so our fascade should be easy to detect.
             */
            if (array_key_exists($paths[0], $config)):
                $face = $paths[0];
                
                /**
                 * Set route with the alias removed
                 */
                array_shift($paths);
                
                if (!empty($paths)):
                    $route = implode('/', $paths);
                endif;
            else:
                $route = $request->get['_route_'];
            endif;
        endif;
        
        // Add fascade to config
        $configuration['active.fascade'] = $face;
        
        /**
         * Let's adjust the request to adhere to our fascade.
         */
        
        $request->server['SCRIPT_NAME'] = str_replace(PUBLIC_DIR, '', $request->server['SCRIPT_NAME']);
        $request->server['PHP_SELF']    = str_replace(PUBLIC_DIR, '', $request->server['PHP_SELF']);
        
        if (!$route):
            unset($request->get['_route_']);
            unset($request->request['_route_']);
            unset($request->server['REDIRECT_QUERY_STRING']);
            $request->server['QUERY_STRING'] = '';
            $request->server['REQUEST_URI'] = '/';
        else:
            $request->get['_route_'] = $route;
            $request->request['_route_'] = $route;
            $request->server['REDIRECT_QUERY_STRING'] = '_route_=' . $route;
            $request->server['QUERY_STRING'] = '_route_=' . $route;
            $request->server['REQUEST_URI'] = '/' . $route;
        endif;
        
        /**
         * Let's find and remove our pre-render controllers for this fascade.
         * Instead of settings those via the loop below, we'll remove them
         * and give them a specific parameter name so we can accurately
         * access them in our Theme class.
         */
        
        if (is_array($config[$face]['pre_render'])):
            $this->data['pre.controllers'] = $config[$face]['pre_render'];
            unset($config[$face]['pre_render']);
        endif;
        
        /**
         * Let's find and remove our pre-actions for this fascade.
         * Instead of settings those via the loop below, we'll remove them
         * and give them a specific parameter name so we can accurately
         * access them in our Front class.
         */
        
        if (is_array($config[$face]['pre_actions'])):
            $this->data['pre.actions'] = $config[$face]['pre_actions'];
            unset($config[$face]['pre_actions']);
        endif;
        
        /**
         * Add remaining config to configuration array
         */
        
        foreach ($config[$face] as $key => $value):
            $configuration[$key] = $value;
        endforeach;
        
        unset($config);
        
        $this->data['request'] = function ($data) use ($request) {
            return $request;
        };
        
        unset($request);
        
        foreach ($configuration as $key => $value):
            $this->data[$key] = $value;
        endforeach;
        
        $this->buildClasses();
    }
    
    protected function buildClasses() {
        
        // response
        $this->data['response'] = function ($data) {
            $response = new Response($data);
            $response->addHeader('Content-Type: text/html; charset=utf-8');
            
            return $response;
        };
        
        // url
        $this->data['url'] = function ($data) {
            return new Url($data['http.server'], '', $data);
        };

        // encoder
        $this->data['encode'] = function($data) {
            return new Encode($data);
        };
        
        // log (required by error class)
        $this->data['log'] = function ($data) {
            return new Log('error.txt', $data['path.logs'], $data);
        };
        
        // config (required by error class)
        $this->data['config'] = function ($data) {
            $config = new Config;
            $config->set('config_error_display', true);
            $config->set('config_error_log', true);
            
            return $config;
        };
        
        // Set theme name to container
        $this->data['theme.name'] = 'install';
        
        // theme
        $this->data['theme'] = function ($data) {
            return new Theme($data);
        };
        
        $this->buildAction();
    }
    
    protected function buildAction() {
        $this->data['errorhandler'] = function ($data) {
            return new Error($data);
        };
        
        set_error_handler(array(
            $this->data['errorhandler'],
            'error_handler'
        ));
        
        $controller = new Front($this->data);
        
        $error = new Action(new ActionService($this->data, 'notfound'));
        
        $upgrade = false;
        
        if (is_readable($this->data['path.database'] . 'config/db.php')):
            if (filesize($this->data['path.database'] . 'config/db.php') > 0):
                $upgrade = true;
                $lines = file($this->data['path.database'] . 'config/db.php');
                foreach ($lines as $line):
                    if (strpos(strtoupper($line) , 'DB_') !== false):
                        eval($line);
                    endif;
                endforeach;
            endif;
        endif;
        
        if (isset($this->data['request']->get['route'])):
            $action = new Action(new ActionService($this->data, $this->data['request']->get['route']));
        elseif ($upgrade):
            $action = new Action(new ActionService($this->data, 'upgrade'));
        else:
            $action = new Action(new ActionService($this->data, 'welcome'));
        endif;
        
        $controller->dispatch($action, $error);
        
        $this->data['front'] = function ($data) use ($controller) {
            return $controller;
        };
    }
    
    public function fire() {
        $this->data['front']->output();
    }
}
