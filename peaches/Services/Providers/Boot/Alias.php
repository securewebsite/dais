<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Dais\Services\Providers\Boot;

class Alias {
    
    private $aliases;
    private $isRegistered  = false;
    private $rootNamespace = false;

    public function __construct(array $aliases = array()) {
        $this->aliases = $aliases;
    }

    public function addAlias($alias, $fqcn) {

        // Ensure aliases are only added once
        if (isset($this->aliases[$alias])):
            throw new \RuntimeException("The alias, {$alias}, has already been added and cannot be modified.");
        endif;

        $this->aliases[$alias] = $fqcn;

        return $this;
    }

    public function isRegistered() {
        return $this->isRegistered;
    }

    public function load($fqcn) {

        // Determine the alias and namespace from the requested class
        $alias     = $fqcn;
        $namespace = '';

        if (false !== ($pos = strrpos($fqcn, '\\'))):
            $namespace = substr($alias, 0, $pos + 1);
            $alias     = substr($alias, $pos + 1);
        endif;

        // If the alias has been registered, handle it
        if (isset($this->aliases[$alias])):
            // Determine what namespace the alias should be loaded into, depending on the root namespace
            $namespace = ($this->rootNamespace === true) ? $namespace : $this->rootNamespace;

            // Create the class alias
            class_alias($this->aliases[$alias], $namespace . $alias);
        endif;
    }

    public function register($rootNamespace = false) {
        // Do nothing if the Alias Loader is already registered
        if ($this->isRegistered):
            return true;
        endif;

        // If a specific Root Namespace was provided, normalize it to end in a backslash
        if ($rootNamespace):
            $this->rootNamespace = is_string($rootNamespace) ? rtrim($rootNamespace, '\\') . '\\' : $rootNamespace;
        endif;

        // Register the `load()` method of this object as an autoloader
        return $this->isRegistered = spl_autoload_register(array($this, 'load'));
    }

    public function getAliases() {
        return $this->aliases;
    }
}
