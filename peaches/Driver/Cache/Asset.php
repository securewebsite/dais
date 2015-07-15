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

namespace Dais\Driver\Cache;

use Dais\Contracts\CacheContract;

class Asset implements CacheContract {
    private $expire;
    
    public function __construct($expire) {
        $this->expire = $expire;
        
        $files = glob(Config::get('path.filecache') . '*' . SEP . '.*');
        
        if ($files):
            foreach ($files as $file):
                $time = filemtime($file);
                if (($time + $this->expire) < time()):
                    if (file_exists($file)):
                        unlink($file);
                    endif;
                endif;
            endforeach;
        endif;
    }
    
    public function get($key, $type) {
        $file = Config::get('path.filecache') . $type . SEP . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . $type;
        
        if (is_readable($file)):
            $file_handle = fopen($file, 'r');
            flock($file_handle, LOCK_SH);
            $data = fread($file_handle, filesize($file));
            flock($file_handle, LOCK_UN);
            fclose($file_handle);
            return $data;
        endif;
        
        return false;
    }
    
    public function set($key, $value, $type, $expire = 0) {
        $this->delete($key, $type);
        
        $file = Config::get('path.filecache') . $type . SEP . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . $type;
        
        $file_handle = fopen($file, 'w');
        flock($file_handle, LOCK_EX);
        fwrite($file_handle, $value);
        fflush($file_handle);
        flock($file_handle, LOCK_UN);
        fclose($file_handle);
    }
    
    public function delete($key, $type) {
        $file = Config::get('path.filecache') . $type . SEP . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . $type;
        
        if (is_readable($file)):
            unlink($file);
        endif;
    }
    
    public function flush_cache() {
        $files = glob(Config::get('path.filecache') . '*' . SEP . '.*');
        
        if ($files):
            foreach ($files as $file):
                if (file_exists($file) && !is_dir($file)):
                    unlink($file);
                endif;
            endforeach;
        endif;
    }

    public function get_key($key, $type) {
        $file = Config::get('path.filecache') . $type . SEP . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . $type;
        
        if (is_readable($file)):
            return str_replace(Config::get('path.filecache') . $type . SEP, '', $file);
        endif;
    }
}
