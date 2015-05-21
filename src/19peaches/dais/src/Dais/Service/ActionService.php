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
use Dais\Library\Naming;

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

        $this->method = Naming::method_from_route($app, $route);

        // Method override via passed args (specific for single file routes)
        if (isset($this->args['method'])):
            $this->method = $this->args['method'];
        endif;
        

        $this->file  = Naming::file_from_route($app, $route);
        $this->class = Naming::class_from_filename($this->file);

        //var_dump($this->file);
        
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
}
