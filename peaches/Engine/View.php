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

class View {
    private $directory;
    private $file;
    private $data;
    
    public function __construct($directory = false) {
        if ($directory):
            $this->directory = $directory;
        else:
            $this->directory = Config::get('path.theme') . Config::get('theme.name') . SEP;
        endif;
    }
    
    public function render($template, $data = array()) {
        $this->data = $data;
        $this->file = $this->directory . 'view' . SEP . $template . '.tpl';
        
        return $this->output();
    }
    
    public function setDirectory($directory) {
        $this->directory = $directory;
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
