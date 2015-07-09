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

namespace Dais\Services\Providers;

class Session {
    
    public $data = array();
    private $path;
    
    public function __construct($session_path) {
        $this->path = $session_path;
    }
    
    public function admin_session() {
        if (!session_id()):
            ini_set('session.use_only_cookies', 'On');
            ini_set('session.use_trans_sid', 'Off');
            ini_set('session.cookie_httponly', 'On');
            ini_set('session.save_path', $this->path);
            
            session_set_cookie_params(0, '/manage');
            session_start();
        endif;
        
        $this->data = & $_SESSION;
    }
    
    public function front_session() {
        if (!session_id()):
            ini_set('session.use_only_cookies', 'On');
            ini_set('session.use_trans_sid', 'Off');
            ini_set('session.cookie_httponly', 'On');
            ini_set('session.save_path', $this->path);
            
            session_set_cookie_params(0, '/');
            session_start();
        endif;
        
        $this->data = & $_SESSION;
    }
    
    function getId() {
        return session_id();
    }
}
