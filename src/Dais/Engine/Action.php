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
use Dais\Engine\Container;
use Dais\Interfaces\ActionServiceInterface;

final class Action {
    
    protected $file;
    protected $class;
    protected $method;
    protected $args = array();
    
    public function __construct(ActionServiceInterface $action) {
        $this->file   = $action->get('file');
        $this->method = $action->get('method');
        $this->class  = $action->get('class');
        $this->args   = $action->get('args');
    }
    
    public function execute(Container $app) {
        if (substr($this->method, 0, 2) == '__'):
            return false;
        endif;
        
        $controller = new $this->class($app);
        
        if (is_callable(array($controller, $this->method))):
            return call_user_func_array(array($controller, $this->method), $this->args);
        else:
            return false;
        endif;
    }
}
