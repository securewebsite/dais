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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Log extends LibraryService {
    private $filehandle;
    
    public function __construct($filename, $directory, Container $app) {
        parent::__construct($app);
        
        $file = $directory . $filename;
        $this->filehandle = fopen($file, 'a');
    }
    
    public function __destruct() {
        fclose($this->filehandle);
    }
    
    public function write($message) {
        fwrite($this->filehandle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
    }
}
