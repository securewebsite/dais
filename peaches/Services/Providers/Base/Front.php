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

final class Front {

    private $pre_action = array();
    private $error;
    
    public function __construct() {
        
        foreach (Config::get('pre.actions') as $pre_action):
            $this->pre_action[] = new Action($pre_action);
        endforeach;
    }
    
    public function addPreAction($pre_action) {
        $this->pre_action[] = $pre_action;
    }
    
    public function dispatch($action, $error) {
        $this->error = $error;
        
        foreach ($this->pre_action as $pre_action):
            $result = $this->execute($pre_action);
            if ($result):
                $action = $result;
                break;
            endif;
        endforeach;
        
        while ($action):
            $action = $this->execute($action);
        endwhile;
    }
    
    private function execute($action) {
        $result = $action->execute();
        
        if (is_object($result)):
            $action = $result;
        elseif ($result === false):
            $action = $this->error;
            $this->error = '';
        else:
            $action = false;
        endif;
        
        return $action;
    }
    
    public function output() {
        Response::output();
    }
}
