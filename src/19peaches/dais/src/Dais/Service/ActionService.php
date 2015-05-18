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

namespace Dais\Service;
use Dais\Engine\Container;
use Dais\Interfaces\ActionServiceInterface;

class ActionService implements ActionServiceInterface {
    
    protected $file;
    protected $class;
    protected $method;
    protected $args = array();
    protected $fascade;
    
    public function __construct(Container $app, $route, $args = array()) {
        
        if ($args):
            $this->args = $args;
        endif;
        
        $this->build_file($app, $route);
        $this->class = $this->build_class();
        
        /**
         *  No pre-controller hooks for our installer.
         */
        if ($this->fascade !== INSTALL_FASCADE):
            $this->buildPrecontrollerHooks($app);
        endif;
    }
    
    public function get($key) {
        return $this->{$key};
    }
    
    protected function build_file(Container $app, $route) {
        $path = '';
        $plugin = '';
        $parts = explode('/', str_replace('../', '', (string)$route));
        
        /**
         * Plugin specific items because plugins work a bit differently
         * than normal controllers.
         */
        if ($parts[0] === $app['prefix.plugin']):
            $plugin = str_replace('_', '', strtolower($parts[1]));
            array_shift($parts);
            if ($parts[0] === $plugin && count($parts) > 1):
                array_shift($parts);
            endif;
        endif;
        
        $this->fascade = (($app['active.fascade'] === ADMIN_FASCADE) && (ADMIN_FASCADE !== 'admin')) ? 'admin' : $app['active.fascade'];
        
        foreach ($parts as $key => $part):
            if ($key < 2):
                $path.= $part . '/';
                array_shift($parts);
            endif;
            continue;
        endforeach;
        
        $path = rtrim($path, '/');
        
        $method = array_shift($parts);
        
        if ($method):
            $this->method = $method;
        else:
            $this->method = 'index';
        endif;
        
        // Method override via passed args (specific for single file routes)
        if (isset($this->args['method'])):
            $this->method = $this->args['method'];
        endif;
        
        if (is_readable($file = $app['path.theme'] . $app['theme.name'] . '/controller/' . str_replace(array('../', '..\\', '..') , '', $path) . '.php')):
            $this->file = $file;
        elseif (is_readable($file = $app['path.plugin'] . $plugin . '/' . $this->fascade . '/controller/' . str_replace(array('../', '..\\', '..') , '', $path) . '.php')):
            $this->file = $file;
        else:
            $this->file = $app['path.application'] . 'controller/' . str_replace(array('../', '..\\', '..') , '', $path) . '.php';
        endif;
    }
    
    protected function buildPrecontrollerHooks(Container $app) {
        
        // call hooks from container
        $app['hooks'];
        
        $callable = false;
        $hook_key = $this->fascade . '_controller';
        
        $hooks    = $app['plugin_hooks'];
        
        if (array_key_exists($hook_key, $hooks)):
            foreach ($hooks[$hook_key] as $hook):
                if ($hook['class'] === $this->class && $hook['method'] === $this->method && $hook['type'] == 'pre'):
                    
                    $mthd = basename($hook['callback']);
                    $cls  = rtrim(str_replace($mthd, '', $hook['callback']) , '/');
                    
                    $callback = array(
                        'class'  => str_replace('/', '\\', $cls) ,
                        'method' => $mthd,
                        'args'   => $hook['arguments']
                    );
                    
                    $callable = function () use ($callback, $app) {
                        $hook = new $callback['class']($app);
                        if (is_callable(array($hook, $callback['method']))):
                            return call_user_func_array(array($hook, $callback['method']) , array($callback['args']));
                        endif;
                    };
                endif;
                
                if ($callable):
                    $this->args[] = $callable();
                endif;
            endforeach;
        endif;
    }
    
    // determine class name
    protected function build_class() {
        
        $file  = str_replace(APP_PATH, '', str_replace('.php', '', $this->file));
        $class = '';
        
        $parts = explode('/', $file);
        foreach ($parts as $part):
            $class.= ucfirst($part) . '\\';
        endforeach;
        
        return rtrim($class, '\\');
    }
}
