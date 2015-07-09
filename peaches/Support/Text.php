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

namespace Dais\Support;

class Text {
    
    public  $data = array();
    private $path;
    
    public function __construct($directory = '') {
        if ($directory):
            $this->path = $directory;
        else:
            $this->path = Theme::p()->path . 'view/';
        endif;
    }
    
    public function fetch($filename) {
        $file = $this->path . $filename . '.txt';
        
        if (is_readable($file)):
            extract($this->data);
            ob_start();
            require $file;
            $content = ob_get_clean();
            
            return $content;
        else:
            trigger_error('Error: Could not load template ' . $file . '!');
        endif;
    }
}
