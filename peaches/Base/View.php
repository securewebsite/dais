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

namespace Dais\Base;

class View {

    private $directory;
    private $file;
    private $data;
    
    public function __construct($directory) {
        $this->directory = $directory;
    }
    
    public function make($template, array $data = []) {
        $this->data = $data;
        $this->file = $this->directory . 'view/' . $template . '.tpl';
        
        return $this->output();
    }
    
    private function output() {
        if (is_readable($this->file)):
            extract($this->data);
            ob_start();
            require $this->file;
            $output = ob_get_contents();
            ob_end_clean();
            
            return $output;
        else:
            trigger_error('Error: Could not load template ' . $this->file . '!');
        endif;
    }
}
