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

final class Javascript {
    
    private $registered  = array();
    private $queued      = array();
    private $complete    = array();
    private $controllers = array();
    private $script_data = array();
    private $last_file;
    private $directory;
    private $script_directory;
    public  $cache_key;
    
    public function __construct() {
        $this->directory        = \Config::get('path.asset') . \Config::get('theme.name') . '/js/';
        $this->script_directory = \Config::get('path.theme') . \Config::get('theme.name') . '/view/';
    }
    
    public function register($name, $dep = null, $last = false) {
        if ((array_key_exists($dep, $this->registered) || !isset($dep)) && !$last):
            if (is_readable($this->directory . $name . '.js')):
                $this->registered[basename($name) ] = array(
                    'file' => $name . '.js',
                );
            endif;
        elseif ($last):
            $this->last_file = $name;
        else:
            if (is_readable($this->directory . $name . '.js')):
                $this->queued[] = array(
                    'name' => $name,
                    'file' => $name . '.js',
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
                    $this->registered[basename($script['name']) ] = array(
                        'file' => $script['file']
                    );
                    unset($this->queued[$key]);
                endif;
            endforeach;
        endif;
    }
    
    public function compile() {
        $this->collate();
        unset($this->queued);
        
        if (isset($this->last_file)):
            $this->registered[$this->last_file] = array(
                'file' => $this->last_file . '.js'
            );
            unset($this->last_file);
        endif;
        
        foreach ($this->registered as $script):
            $this->complete[] = $script['file'];
        endforeach;
        
        $prefix = \Config::get('active.facade');
        $key    = 'javascript.' . $prefix . '.' . md5(str_replace('.js', '', implode('|', $this->complete)));
        
        $this->cache_key = md5($key);
        
        $cachefile = \Filecache::get_asset($this->cache_key, 'js');
        
        if (is_bool($cachefile)):
            $cached = '';
            foreach ($this->complete as $file):
                $cached .= file_get_contents($this->directory . '/' . $file);
            endforeach;
            
            $cachefile = $cached;
            \Filecache::set_asset($this->cache_key, $cachefile, 'js');
        endif;
        
        unset($this->registered);
        
        return $this->cache_key;
    }
    
    public function reset() {
        $this->registered = array();
        $this->queued     = array();
        $this->complete   = array();
        $this->last_file  = '';
    }
    
    public function load($file, $data, $path = '') {
        $script_path = ($path) ? $path : $this->script_directory;
        
        if (!empty($this->script_data)):
            $this->script_data = array_merge($this->script_data, $data);
        else:
            $this->script_data = $data;
        endif;
        
        $this->controllers[] = $script_path . $file . '.js';
    }
    
    public function fetch() {
        return array(
            'data'  => $this->script_data,
            'files' => $this->controllers
        );
    }
}
