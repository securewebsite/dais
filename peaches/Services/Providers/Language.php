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

namespace Dais\Services\Providers;

use Dais\Support\Naming;

class Language {
    
    private $default = 'english';
    private $directory;
    private $data = array();
    
    public function __construct($directory) {
        $this->directory = $directory;

        // let's set our facade path for use when loading
        switch(\Config::get('active.facade')):
            case ADMIN_FACADE:
                $this->facade = \Config::get('path.theme') . \Config::get('config_admin_theme');
                break;
            case FRONT_FACADE:
                $this->facade = \Config::get('path.theme') . \Config::get('config_theme');
                break;
        endswitch;
    }
    
    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }
    
    public function set($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function load($filename) {
        $_ = array();

        /**
         * We need to work out whether we have a base language file for our current
         * facade and theme.  If we do, we'll use this one, else we'll fallback
         * to the default base file.
         */

        $language_dir = $this->facade . SEP . 'language' . SEP;
        
        // grab our base file
        if (is_readable($file = $language_dir . $this->default . SEP . $filename . '.php')):
            $class = Naming::class_from_filename($file);
            $_     = $class::lang();
        else:
            $class = Naming::class_from_filename(\Config::get('path.language') . $this->default . SEP . $filename . '.php');
            $_     = $class::lang();
        endif;
        
        /**
         * We need to do the same for our requested individual language file. Use theme version
         * first, then fallback to default.
         */
        
        if (is_readable($file = $language_dir . $this->directory . SEP . $filename . '.php')):
            $class = Naming::class_from_filename($file);
            $_     = $class::lang();
        else:
            $class = Naming::class_from_filename(\Config::get('path.language') . $this->directory . SEP . $filename . '.php');
            $_     = $class::lang();
        endif;
        
        $this->data = array_merge($this->data, $_);
        
        return $this->data;
    }
    
    public function getDirectory() {
        return $this->directory;
    }
    
    public function fetch() {
        return $this->data;
    }
}
