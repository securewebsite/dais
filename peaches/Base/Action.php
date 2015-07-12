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

namespace Dais\Base;

use Dais\Support\Naming;

final class Action {
    
    protected $file;
    protected $class;
    protected $method;
    protected $args = array();
    
    public function __construct($route, $args = array()) {
        
        if ($args):
            $this->args = $args;
        endif;

        $this->method = Naming::method_from_route($route);

        // Method override via passed args (specific for single file routes)
        if (isset($this->args['method'])):
            $this->method = $this->args['method'];
        endif;
        

        $this->file  = Naming::file_from_route($route);
        $this->class = Naming::class_from_filename($this->file);

        return $this;
    }
    
    public function execute() {
        if (substr($this->method, 0, 2) == '__'):
            return false;
        endif;

        // Run pre-controller hooks for this class
        $this->preControl();
        
        $controller = new $this->class;
        
        if (is_callable(array($controller, $this->method))):
            return call_user_func_array(array($controller, $this->method), $this->args);
        else:
            return false;
        endif;
    }

    public function preControl() {

        $callable = false;
        $hook_key = Config::get('prefix.facade') . '_controller';
        $hooks    = App::get('plugin_hooks');
        
        if (array_key_exists($hook_key, $hooks)):
            foreach ($hooks[$hook_key] as $hook):
                if ($hook['class'] === $this->class && $hook['method'] === $this->method && $hook['type'] == 'pre'):
                    $segments  = explode(SEP, $hook['callback']);
                    $method    = array_pop($segments);
                    $class     = Naming::class_from_filename(implode(SEP, $segments));
                    $arguments = isset($hook['arguments']) ? $hook['arguments'] : null;
                    
                    $callback = array(
                        'class'  => $class,
                        'method' => $method,
                        'args'   => $arguments
                    );
                    
                    $callable = function () use ($callback) {
                        $hook = new $callback['class'];
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
