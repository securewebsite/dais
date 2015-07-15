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

/*
|--------------------------------------------------------------------------
|   Stolen from \Illuminate\Foundation\AliasLoader (modified) Laravel 5
|--------------------------------------------------------------------------  
*/

namespace Dais\Support;

class Alias {
    
    protected $aliases;

    protected $registered = false;

    protected $rootNamespace = false;

    protected static $instance;

    private function __construct($aliases) {
        $this->aliases = $aliases;
    }

    public static function getInstance(array $aliases = []) {
        if (is_null(static::$instance)):
            return static::$instance = new static($aliases);
        endif;

        $aliases = array_merge(static::$instance->getAliases(), $aliases);

        static::$instance->setAliases($aliases);

        return static::$instance;
    }

    public function load($fqcn) {
        $alias     = $fqcn;
        $namespace = '';

        if (false !== ($pos = strrpos($fqcn, '\\'))):
            $namespace = substr($alias, 0, $pos + 1);
            $alias     = substr($alias, $pos + 1);
        endif;


        if (isset($this->aliases[$alias])):
            $namespace = ($this->rootNamespace === true) ? $namespace : $this->rootNamespace;
            return class_alias($this->aliases[$alias], $namespace . $alias);
        endif;
    }

    public function alias($class, $alias) {
        $this->aliases[$class] = $alias;
    }

    public function register($rootNamespace = false) {
        if (!$this->registered):
            if ($rootNamespace):
	            $this->rootNamespace = is_string($rootNamespace) ? rtrim($rootNamespace, '\\') . '\\' : $rootNamespace;
	        endif;

            $this->prependToLoaderStack();

            $this->registered = true;
        endif;
    }

    protected function prependToLoaderStack() {
        spl_autoload_register([$this, 'load']);
    }

    public function getAliases() {
        return $this->aliases;
    }

    public function setAliases(array $aliases) {
        $this->aliases = $aliases;
    }

    public function isRegistered() {
        return $this->registered;
    }

    public function setRegistered($value) {
        $this->registered = $value;
    }

    public static function setInstance($loader) {
        static::$instance = $loader;
    }

    private function __clone() {}
}
