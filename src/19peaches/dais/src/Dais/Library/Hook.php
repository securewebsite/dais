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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;
use Dais\Service\PluginServiceModel;

class Hook extends LibraryService {
    
    private $hooks = array();
    
    public function __construct(Container $app, PluginServiceModel $model) {
        parent::__construct($app);
        
        $this->model = $model;
        $this->registerHooks();
    }
    
    public function registerHooks() {
        $hooks = $this->model->getHookHandlers();
        
        foreach ($hooks as $hook):
            $handlers     = unserialize($hook['handlers']);
            $parts        = explode('_', $hook['hook']);
            $class_locale = '';
            $theme_locale = parent::$app['path.theme'] . parent::$app['theme.name'] . '/' . end($parts);
            
            foreach ($parts as $part):
                $class_locale.= $this->format($part) . '\\';
            endforeach;
            unset($parts);
            
            foreach ($handlers as $handler):
                if (!array_key_exists($hook['hook'], $this->hooks)):
                    $this->hooks[$hook['hook']] = array();
                endif;
                
                $theme_path = $theme_locale . '/' . $handler['class'];
                
                if (is_readable($theme_path . '.php')):
                    $class_path = '';
                    
                    $theme_file = str_replace(dirname(parent::$app['path.application']) . '/', '', $theme_path);
                    $parts      = explode('/', $theme_file);
                    
                    foreach ($parts as $part):
                        $class_path.= ucfirst($part) . '\\';
                    endforeach;
                    unset($parts);
                else:
                    $class_path = '';
                    $parts      = explode('/', $handler['class']);
                    
                    foreach ($parts as $part):
                        $class_path.= $this->format($part) . '\\';
                    endforeach;
                    unset($parts);
                    
                    $class_path = $class_locale . $class_path;
                endif;
                
                $class_path  = rtrim($class_path, '\\');
                $plugin_path = 'Plugin/' . $this->format($handler['plugin']);
                
                $parts = explode('/', $handler['file']);
                
                foreach ($parts as $part):
                    $plugin_path.= '/' . $this->format($part);
                endforeach;
                unset($parts);
                
                $plugin_path.= '/' . $handler['callback'];
                
                $handler_array = array(
                    'class'     => $class_path,
                    'method'    => $handler['method'],
                    'type'      => $handler['type'],
                    'callback'  => $plugin_path,
                    'arguments' => isset($handler['args']) ? $handler['args'] : null
                );
                
                $this->hooks[$hook['hook']][] = $handler_array;
            endforeach;
        endforeach;
        
        parent::$app['plugin_hooks'] = $this->hooks;
    }
    
    public function unregisterHooks() {
    }
    
    public function listen($class, $method, $data = array()) {
        
        /**
         * We have to check for admin fascade naming. Our plugins should
         * always be using the name "admin" but our ADMIN_FASCADE could
         * be different. Lets correct this.
         */
        $fascade = ((parent::$app['active.fascade'] === ADMIN_FASCADE) && (ADMIN_FASCADE !== 'admin')) ? 'admin' : parent::$app['active.fascade'];
        $key = $fascade . '_controller';
        
        if (array_key_exists($key, $this->hooks)):
            foreach ($this->hooks[$key] as $hook):
                if ($hook['class'] === $class && $hook['method'] === $method && $hook['type'] === 'post'):
                    $mthd = basename($hook['callback']);
                    $cls  = rtrim(str_replace($mthd, '', $hook['callback']) , '/');
                    $cls  = str_replace('/', '\\', $cls);
                    
                    if (!empty($hook['arguments'])):
                        $data = array_merge($data, $hook['arguments']);
                    endif;
                    
                    $hook = new $cls(parent::$app);
                    
                    if (is_callable(array($hook, $mthd))):
                        $data = call_user_func_array(array($hook, $mthd) , array($data));
                    endif;
                endif;
            endforeach;
        endif;
        
        return $data;
    }
    
    private function format($file) {
        return ucfirst(str_replace('_', '', strtolower($file)));
    }
}
