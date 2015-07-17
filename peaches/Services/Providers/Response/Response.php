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

namespace Dais\Services\Providers\Response;

class Response {
    
    private $headers = array();
    private $level   = 0;
    private $output;
    private $token;
    
    public function __construct() {
        if (isset(Session::p()->data['token'])):
            $this->token = Session::p()->data['token'];
        endif;
    }

    public function addHeader($header) {
        $this->headers[] = $header;
    }
    
    public function redirect($url, $status = 302) {
        header('Status: ' . $status);
        header('Location: ' . str_replace(array(
            '&amp;',
            "\n",
            "\r"
        ) , array(
            '&',
            '',
            ''
        ) , $url));
    }
    
    public function setCompression($level) {
        $this->level = $level;
    }
    
    public function setOutput($output) {
        $this->output = $output;
    }
    
    public function getOutput() {
        return $this->output;
    }
    
    private function compress($data, $level = 0) {
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)):
            $encoding = 'gzip';
        endif;
        
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)):
            $encoding = 'x-gzip';
        endif;
        
        if (!isset($encoding)):
            return $data;
        endif;
        
        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')):
            return $data;
        endif;
        
        if (headers_sent()):
            return $data;
        endif;
        
        if (connection_status()):
            return $data;
        endif;
        
        $this->addHeader('Content-Encoding: ' . $encoding);
        
        return gzencode($data, (int)$level);
    }
    
    public function output() {
        if ($this->output):
            if ($this->level):
                $output = $this->compress($this->output, $this->level);
            else:
                $output = $this->output;
            endif;
            
            if (!headers_sent()):
                foreach ($this->headers as $header):
                    header($header, true);
                endforeach;
            endif;
            
            echo ($output);
        endif;
    }

    public function makeToken() {
        $token = md5(mt_rand());

        $this->token = $token;

        Session::p()->data['token'] = $token;
        User::setToken($token);
    }

    public function match() {
        $user    = !is_null(User::getToken()) ? User::getToken() : false;
        $session = isset(Session::p()->data['token']) ? Session::p()->data['token'] : false;

        if (($user !== $this->token) || ($session !== $this->token) || ($session !== $user) || (!$this->token) || (!$user) || (!$session)):
            return false;
        endif;

        return true;
    }

    public function getToken() {
        return $this->token;
    }

    public function test($data, $quit = true) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        if ($quit):
            exit;
        endif;
    }
}
