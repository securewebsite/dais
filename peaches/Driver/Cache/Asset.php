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
        
        $files = glob(\Config::get('path.filecache') . '*');
        
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
        $files = glob(\Config::get('path.filecache') . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*.' . $type);
        
        if ($files):
            $file_handle = fopen($files[0], 'r');
            flock($file_handle, LOCK_SH);
            $data = fread($file_handle, filesize($files[0]));
            flock($file_handle, LOCK_UN);
            fclose($file_handle);
            return $this->is_serialized($data) ? unserialize($data) : $data;
        endif;
        
        return false;
    }
    
    public function set($key, $value, $type, $expire = 0) {
        $this->delete($key, $type);
        
        $file = \Config::get('path.filecache') . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . $type;
        
        $data = (is_array($value)) ? serialize($value) : $value;
        
        $file_handle = fopen($file, 'w');
        flock($file_handle, LOCK_EX);
        fwrite($file_handle, $data);
        fflush($file_handle);
        flock($file_handle, LOCK_UN);
        fclose($file_handle);
    }
    
    public function delete($key, $type) {
        $files = glob(\Config::get('path.filecache') . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*.' . $type);
        
        if ($files):
            foreach ($files as $file):
                if (file_exists($file)):
                    unlink($file);
                endif;
            endforeach;
        endif;
    }
    
    public function flush_cache() {
        $files = glob(\Config::get('path.filecache') . '.*');
        
        if ($files):
            foreach ($files as $file):
                if (file_exists($file) && !is_dir($file)):
                    unlink($file);
                endif;
            endforeach;
        endif;
    }

    public function get_key($key, $type) {
        
        $files = glob(\Config::get('path.filecache') . '*.' . $type);

        if ($files):
            foreach ($files as $file):
                $file = str_replace(\Config::get('path.filecache'), '', $file);
                $data = explode('.', $file);
                if ($data[0] == $key):
                    return $file;
                endif;
            endforeach;
        endif;
    }
    
    /**
     *	This function has been copied from Wordpress.
     */
    private function is_serialized($data) {
        
        // if it isn't a string, it isn't serialized
        if (!is_string($data)) return false;
        $data = trim($data);
        if ('N;' == $data) return true;
        if (!preg_match('/^([adObis]):/', $data, $badions)) return false;
        switch ($badions[1]) {
            case 'a':
            case 'O':
            case 's':
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data)) return true;
                break;

            case 'b':
            case 'i':
            case 'd':
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data)) return true;
                break;
        }
        return false;
    }
}
