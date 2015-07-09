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

namespace Dais\Services\Providers;

use Dais\Engine\Container;
use Dais\Support\Naming;

class Hook {
    
    private $hooks = array();
    
    public function __construct() {
        $this->registerHooks();
    }
    
    public function registerHooks() {
        $hooks = \PluginModel::getHookHandlers();
        
        foreach ($hooks as $hook):
            $handlers     = unserialize($hook['handlers']);
            $class_locale = str_replace('_', SEP, $hook['hook']);
            $theme_locale = \Config::get('path.theme') . \Config::get('theme.name') . SEP . basename($class_locale) . SEP;
            
            foreach ($handlers as $handler):
                if (!array_key_exists($hook['hook'], $this->hooks)):
                    $this->hooks[$hook['hook']] = array();
                endif;

                // let's set our arguments if we have any
                if (isset($handler['args'])):
                    $arguments = $handler['args'];
                    unset($handler['args']);
                endif;
                
                $theme_path = $theme_locale . $handler['class'];
                $file_path  = \Config::get('path.app') . $class_locale . SEP;
                
                if (is_readable($theme_path . '.php')):
                    $class_path = Naming::class_from_filename($theme_path);
                else:
                    if (is_readable($file = $file_path . $handler['class'] . '.php')):
                        $class_path = Naming::class_from_filename($file);
                    else:
                        return;
                    endif;
                endif;

                unset($handler['class']);

                $method = $handler['method'];
                unset($handler['method']);

                $type = $handler['type'];
                unset($handler['type']);

                $plugin = implode(SEP, $handler);

                $plugin_path = \Config::get('prefix.plugin') . SEP . $plugin;
                
                $handler_array = array(
                    'class'     => $class_path,
                    'method'    => $method,
                    'type'      => $type,
                    'callback'  => $plugin_path,
                    'arguments' => isset($arguments) ? $arguments : null
                );
                
                $this->hooks[$hook['hook']][] = $handler_array;
            endforeach;
        endforeach;
        
        App::set('plugin_hooks', $this->hooks);
    }
    
    public function unregisterHooks() {
    }
    
    public function listen($class, $method, $data = array()) {
        $key = trim(\Config::get('prefix.facade'), '/') . '_controller';
        
        if (array_key_exists($key, $this->hooks)):
            foreach ($this->hooks[$key] as $hook):
                if ($hook['class'] === $class && $hook['method'] === $method && $hook['type'] === 'post'):
                    $segments = explode(SEP, $hook['callback']);
                    $method   = array_pop($segments);
                    $class    = Naming::class_from_filename(implode(SEP, $segments));
                    
                    if (!empty($hook['arguments'])):
                        $data = array_merge($data, $hook['arguments']);
                    endif;
                    
                    $hook = new $class;
                    
                    if (is_callable(array($hook, $method))):
                        $data = call_user_func_array(array($hook, $method) , array($data));
                    endif;
                endif;
            endforeach;
        endif;
        
        return $data;
    }

    public function preControl() {
        
        // call hooks from container
        App::get('hooks');
        
        $callable = false;
        $hook_key = \Config::get('prefix.facade') . '_controller';
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
