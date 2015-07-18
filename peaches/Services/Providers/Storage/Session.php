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

namespace Dais\Services\Providers\Storage;

use Dais\Driver\Session\FileHandler;
use Dais\Driver\Session\DatabaseHandler;

class Session {
    
    public  $data = array();
    private $path;
    
    public function __construct($session_path) {
        $this->path = $session_path;
    }
    
    public function admin_session(FileHandler $handler) {
        if (!session_id()):
            ini_set('session.use_only_cookies', 'On');
            ini_set('session.use_trans_sid', 'Off');
            ini_set('session.cookie_httponly', 'On');
            ini_set('session.save_path', $this->path);
            
            session_set_cookie_params(0, '/manage');

            session_set_save_handler(
                array($handler, 'open'),
                array($handler, 'close'),
                array($handler, 'read'),
                array($handler, 'write'),
                array($handler, 'destroy'),
                array($handler, 'gc')
            );

            session_start();
        endif;

        $_SESSION['name'] = 'DAISADMIN';
        
        $this->data = & $_SESSION;
    }
    
    public function front_session(DatabaseHandler $handler) {
        if (!session_id()):
            ini_set('session.use_only_cookies', 'On');
            ini_set('session.use_trans_sid', 'Off');
            ini_set('session.cookie_httponly', 'On');
            ini_set('session.save_path', $this->path);
            
            session_set_cookie_params(0, '/');
            
            session_set_save_handler(
                array($handler, 'open'),
                array($handler, 'close'),
                array($handler, 'read'),
                array($handler, 'write'),
                array($handler, 'destroy'),
                array($handler, 'gc')
            );
            
            session_start();
        endif;

        $_SESSION['name'] = 'DAISPUBLIC';
        
        $this->data = & $_SESSION;
    }
    
    public function getId() {
        return session_id();
    }

    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }
    
    public function set($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function has($key) {
        return isset($this->data[$key]);
    }
}
