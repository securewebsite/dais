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

namespace Dais\Engine;

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
        
        Hook::preControl();
        
        return $this;
    }
    
    public function execute() {
        if (substr($this->method, 0, 2) == '__'):
            return false;
        endif;
        
        $controller = new $this->class;
        
        if (is_callable(array($controller, $this->method))):
            return call_user_func_array(array($controller, $this->method), $this->args);
        else:
            return false;
        endif;
    }
}
