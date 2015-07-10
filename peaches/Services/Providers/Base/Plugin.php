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

namespace Dais\Services\Providers\Base;

use Dais\Base\Container;
use Dais\Base\Controller;
use Dais\Base\View;
use Dais\Support\Naming;

class Plugin extends Controller {
    
    private     $plugins = array();
    private     $controllers = array();
    private     $locale;
    protected   $directory;
    protected   $plugin_name;
    
    public function __construct() {
        $this->locale = Config::get('active.facade') . SEP;
        
        /**
         * We need to manage the path for plugins since
         * our ADMIN_FACADE may not be named "admin".
         * Plugin admin areas should always be named "admin".
         */
        if ((Config::get('active.facade') === ADMIN_FACADE) && (ADMIN_FACADE !== 'admin')):
            $this->locale = str_replace(Config::get('active.facade'), 'admin', $this->locale);
        endif;
        
        $this->directory = Config::get('path.plugin');
        
        $files = glob($this->directory . '*', GLOB_ONLYDIR);
        
        foreach ($files as $file):
            $this->plugins[] = $file;
        endforeach;
        
        unset($files);
        
        $files = glob($this->directory . '*' . SEP . '*' . SEP . 'controller' . SEP . '*.php');
        
        foreach ($files as $key => $file):
            $path  = str_replace(Config::get('path.app'), '', rtrim($file, '.php'));
            
            $slugs = explode(SEP, $path);
            
            if ($slugs[0] !== end($slugs)):
                $this->controllers[] = Config::get('prefix.plugin') . SEP . $slugs[0] . SEP . end($slugs);
            endif;
        endforeach;
        
        unset($files);
    }
    
    public function set($key, $value) {
        App::set($key, $value);
    }
    
    public function setPlugin($plugin) {
        $this->plugin_name = $plugin;
    }
    
    public function install($plugin) {
        $class      = 'Plugin\\' . $this->format($plugin) . '\Register';
        $controller = new $class;
        
        if (is_callable(array($controller, 'add'))):
            $controller->add();
        endif;
    }
    
    public function uninstall($plugin) {
        $class      = 'Plugin\\' . $this->format($plugin) . '\Register';
        $controller = new $class;
        
        if (is_callable(array($controller, 'remove'))):
            $controller->remove();
        endif;
    }
    
    public function listen($class, $method, $data = array()) {
        return \Hook::listen($class, $method, $data);
    }
    
    public function trigger($event, $data = array()) {
        return \Event::trigger($event, $data);
    }
    
    public function getPlugins() {
        return $this->plugins;
    }
    
    public function getControllers() {
        return $this->controllers;
    }
    
    private function format($file) {
        return ucfirst(str_replace('_', '', strtolower($file)));
    }
    
    public function model($model) {
        $items = $this->build_model($model);
        $key   = $items['key'];
        
        if (!App::offsetExists($key)):
            $class = $items['class'];
            App::load($key, $class);
        endif;
    }
    
    public function language($plugin, $data = array()) {
        $_ = array();
        
        $locale   = Lang::getDirectory();
        
        $plugin_locale = (isset($this->plugin_name)) ? $this->plugin_name : $plugin;
        
        $lang = Lang::fetch();
        
        if (!empty($data)):
            $lang = array_merge($lang, $data);
        endif;
        
        $file = $this->directory . $plugin_locale . SEP . $this->locale . 'language' . SEP . $locale . SEP . $plugin . '.php';
        
        if (is_readable($file)):
            $class = Naming::class_from_filename($file);
            $_     = $class::lang();
        endif;
        
        foreach ($_ as $key => $value):
            Lang::set($key, $value);
        endforeach;
        
        return array_merge($lang, $_);
    }
    
    public function view($template, $data = array()) {
        $dir  = $this->directory . $this->plugin_name . SEP . $this->locale;
        $view = new View($dir);
        
        return $view->render($template, $data);
    }
    
    private function build_model($model) {
        $data        = array();
        $data['key'] = 'model_' . str_replace('/', '_', $model);
        
        $parts = explode('/', $model);
        $path  = '';
        
        foreach ($parts as $part):
            $path.= ucfirst(str_replace('_', '', $part)) . '/';
        endforeach;
        
        $path = str_replace('/', '\\', rtrim($path, '/'));
        
        if (is_readable($this->directory . $this->plugin_name . '/' . $this->locale . 'model/' . $model . '.php')):
            $class = 'Plugin\\' . ucfirst($this->plugin_name) . Config::get('prefix.facade') . 'Model\\' . $path;
        else:
            return \Theme::model($model);
        endif;
        
        $data['class'] = $class;
        
        return $data;
    }
}
