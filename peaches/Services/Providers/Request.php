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

class Request {
    
    public $get    = array();
    public $post   = array();
    public $cookie = array();
    public $files  = array();
    public $server = array();
    
    public function __construct() {
        $this->get     = $this->clean($_GET);
        $this->post    = $this->clean($_POST);
        $this->request = $this->clean($_REQUEST);
        $this->cookie  = $this->clean($_COOKIE);
        $this->files   = $this->clean($_FILES);
        $this->server  = $this->clean($_SERVER);
        
        return $this;
    }
    
    public function clean($data) {
        if (is_array($data)):
            foreach ($data as $key => $value):
                unset($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            endforeach;
        else:
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        endif;
        
        return $data;
    }

    /**
     * Aliases methods for returning properties.
     */

    public function get($key, $value = null) {
        if (is_null($value)):
            return (isset($this->get[$key]) ? $this->get[$key] : null);
        endif;

        $this->get[$key] = $value;
    }

    public function post($key, $value = null) {
        if (is_null($value)):
            return (isset($this->post[$key]) ? $this->post[$key] : null);
        endif;

        $this->post[$key] = $value;
    }

    public function cookie($key, $value = null) {
        if (is_null($value)):
            return (isset($this->cookie[$key]) ? $this->cookie[$key] : null);
        endif;

        $this->cookie[$key] = $value;
    }

    public function files($key, $value = null) {
        if (is_null($value)):    
            return (isset($this->files[$key]) ? $this->files[$key] : null);
        endif;

        $this->files[$key] = $value;
    }

    public function server($key, $value = null) {
        if (is_null($value)):
            return (isset($this->server[$key]) ? $this->server[$key] : null);
        endif;

        $this->server[$key] = $value;
    }    
}
