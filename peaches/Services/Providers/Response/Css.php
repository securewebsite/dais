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

namespace Dais\Services\Providers\Response;

class Css {
    
    private $registered = array();
    private $queued = array();
    private $complete = array();
    private $last_file;
    private $directory;
    public  $cache_key;
    
    public function __construct() {
        $this->directory = Config::get('path.asset') . Config::get('theme.name') . '/css/';
    }
    
    public function register($name, $dep = null, $last = false) {
        if ((array_key_exists($dep, $this->registered) || !isset($dep)) && !$last):
            if (is_readable($this->directory . $name . '.css')):
                $this->registered[basename($name) ] = array('file' => $name . '.css',);
            endif;
        elseif ($last):
            $this->last_file = $name;
        else:
            if (is_readable($this->directory . $name . '.css')):
                $this->queued[] = array(
                    'name' => $name, 
                    'file' => $name . '.css', 
                    'dep'  => $dep, 
                    'last' => $last
                );
            endif;
        endif;
        
        $this->collate();
        
        return $this;
    }
    
    private function collate() {
        if (!empty($this->queued)):
            foreach ($this->queued as $key => $script):
                if (array_key_exists($script['dep'], $this->registered)):
                    $this->registered[basename($script['name']) ] = array('file' => $script['file']);
                    unset($this->queued[$key]);
                endif;
            endforeach;
        endif;
    }
    
    public function compile() {
        $this->collate();
        unset($this->queued);
        
        if (isset($this->last_file)):
            $this->registered[$this->last_file] = array('file' => $this->last_file . '.css');
            unset($this->last_file);
        endif;
        
        foreach ($this->registered as $style):
            $this->complete[] = $style['file'];
        endforeach;
        
        $prefix = Config::get('active.facade');
        $key = 'css.' . $prefix . '.' . md5(str_replace('.css', '', implode('|', $this->complete)));
        
        $this->cache_key = md5($key);
        
        $cachefile = Filecache::get_asset($this->cache_key, 'css');
        
        if (is_bool($cachefile)):
            $cached = '';
            
            foreach ($this->complete as $file):
                $cached .= file_get_contents($this->directory . $file);
            endforeach;
            
            $cachefile = $cached;
            Filecache::set_asset($this->cache_key, $cachefile, 'css');
        endif;
        
        unset($this->registered);
        unset($this->complete);
        
        return $this->cache_key;
    }
    
    public function reset() {
        $this->registered = array();
        $this->queued     = array();
        $this->complete   = array();
        $this->last_file  = '';
    }
}
