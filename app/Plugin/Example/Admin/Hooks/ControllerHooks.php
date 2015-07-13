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

namespace App\Plugin\Example\Admin\Hooks;

use App\Controllers\Controller;

class ControllerHooks extends Controller {
    
    private $script_directory;
    
    public function __construct() {
        Plugin::setPlugin('example');
        $this->script_directory = dirname(dirname(__FILE__)) . '/js/';
    }
    
    public function exampleHook($data) {
        $data = Plugin::language('examplehook', $data);
        
        $data['callback'] = 'Hook replaced callback text.';
        
        Theme::loadjs('example', $data, $this->script_directory);
        
        return $data;
    }
    
    public function preHook() {
        $data['prehook'] = 'This alert is generated by a pre-hook from the Example plugin.';
        
        Theme::loadjs('prehook', $data, $this->script_directory);
        
        return $data;
    }
}