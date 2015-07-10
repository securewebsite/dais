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

namespace Dais\Base;
use Dais\Contracts\ServiceContract;

class Container implements \ArrayAccess {
    
    private $factories;
    private $protected;
    private $values     = array();
    private $frozen     = array();
    private $raw        = array();
    private $keys       = array();
    
    public function __construct(array $values = array()) {
        
        $this->factories = new \SplObjectStorage();
        $this->protected = new \SplObjectStorage();
        
        foreach ($values as $key => $value):
            $this->offsetSet($key, $value);
        endforeach;
    }
    
    public function offsetSet($id, $value) {
        
        if (isset($this->frozen[$id])):
            throw new \RuntimeException(sprintf('Cannot override frozen service "%s".', $id));
        endif;
        
        $this->values[$id] = $value;
        $this->keys[$id] = true;
    }
    
    public function offsetGet($id) {
        
        if (!isset($this->keys[$id])):
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        endif;
        
        if (isset($this->raw[$id]) || !is_object($this->values[$id]) || isset($this->protected[$this->values[$id]]) || !method_exists($this->values[$id], '__invoke')):
            
            return $this->values[$id];
        endif;
        
        if (isset($this->factories[$this->values[$id]])):
            return $this->values[$id]($this);
        endif;
        
        $raw = $this->values[$id];
        $val = $this->values[$id] = $raw($this);
        $this->raw[$id] = $raw;
        
        $this->frozen[$id] = true;
        
        return $val;
    }
    
    public function offsetExists($id) {
        
        return isset($this->keys[$id]);
    }
    
    public function offsetUnset($id) {
        
        if (isset($this->keys[$id])):
            if (is_object($this->values[$id])):
                unset($this->factories[$this->values[$id]], $this->protected[$this->values[$id]]);
            endif;
            
            unset($this->values[$id], $this->frozen[$id], $this->raw[$id], $this->keys[$id]);
        endif;
    }
    
    public function factory($callable) {
        
        if (!is_object($callable) || !method_exists($callable, '__invoke')):
            throw new \InvalidArgumentException('Service definition is not a Closure or invokable object.');
        endif;
        
        $this->factories->attach($callable);
        
        return $callable;
    }
    
    public function protect($callable) {
        
        if (!is_object($callable) || !method_exists($callable, '__invoke')):
            throw new \InvalidArgumentException('Callable is not a Closure or invokable object.');
        endif;
        
        $this->protected->attach($callable);
        
        return $callable;
    }
    
    public function raw($id) {
        
        if (!isset($this->keys[$id])):
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        endif;
        
        if (isset($this->raw[$id])):
            return $this->raw[$id];
        endif;
        
        return $this->values[$id];
    }
    
    public function extend($id, $callable) {
        
        if (!isset($this->keys[$id])):
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        endif;
        
        if (!is_object($this->values[$id]) || !method_exists($this->values[$id], '__invoke')):
            throw new \InvalidArgumentException(sprintf('Identifier "%s" does not contain an object definition.', $id));
        endif;
        
        if (!is_object($callable) || !method_exists($callable, '__invoke')):
            throw new \InvalidArgumentException('Extension service definition is not a Closure or invokable object.');
        endif;
        
        $factory = $this->values[$id];
        
        $extended = function ($c) use ($callable, $factory) {
            return $callable($factory($c), $c);
        };
        
        if (isset($this->factories[$factory])):
            $this->factories->detach($factory);
            $this->factories->attach($extended);
        endif;
        
        return $this[$id] = $extended;
    }
    
    public function keys() {
        
        return array_keys($this->values);
    }
    
    public function register(ServiceContract $provider, array $values = array()) {
        
        $provider->register($this);
        
        foreach ($values as $key => $value):
            $this[$key] = $value;
        endforeach;
        
        return $this;
    }
}
