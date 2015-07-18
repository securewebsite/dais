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

namespace Dais\Driver\Session;

use SessionHandlerInterface;

class FileHandler implements SessionHandlerInterface  {

    private $savePath;
    
    public function open($savePath, $sessionName) {
        register_shutdown_function('session_write_close');

        $this->savePath = $savePath;
        
        if (!is_dir($this->savePath)):
            mkdir($this->savePath, 0777);
        endif;

        return true;
    }

    public function close() {
        return $this->gc(ini_get('session.gc_maxlifetime'));
    }

    public function read($id) {
        return (string)file_get_contents($this->savePath . 'dais_sess_' . $id);
    }
   
    public function write($id, $data) {
        return file_put_contents($this->savePath . 'dais_sess_' . $id, $data) === false ? false : true;
    }
    
    public function destroy($id) {
        $file = $this->savePath . 'dais_sess_' . $id;
    
        if (file_exists($file)):
            unlink($file);
        endif;

        return true;
    }

    public function gc($maxlifetime) {
        foreach (glob($this->savePath . 'dais_sess_' . '*') as $file):
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)):
                unlink($file);
            endif;
        endforeach;

        return true;
    }
}
