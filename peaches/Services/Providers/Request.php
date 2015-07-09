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
}
