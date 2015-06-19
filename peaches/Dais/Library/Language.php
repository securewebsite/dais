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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;
use Dais\Library\Naming;

class Language extends LibraryService {
    private $default = 'english';
    private $directory;
    private $data = array();
    private $base;
    
    public function __construct($directory = '', $base, Container $app) {
        parent::__construct($app);
        
        $this->directory = $directory;
        $this->base = $base;
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
        
        switch (parent::$app['active.facade']):
        case ADMIN_FACADE:
            $language_dir = parent::$app['path.theme'] . parent::$app['config_admin_theme'] . SEP . 'language' . SEP;
            break;

        case FRONT_FACADE:
            $language_dir = parent::$app['path.theme'] . parent::$app['config_theme'] . SEP . 'language' . SEP;
            break;
        endswitch;
        
        // grab our base file
        if (is_readable($file = $language_dir . $this->default . SEP . $filename . '.php')):
            $class = Naming::class_from_filename($file);
            $_     = $class::lang();
        else:
            $class = Naming::class_from_filename($this->base . $this->default . SEP . $filename . '.php');
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
            $class = Naming::class_from_filename($this->base . $this->directory . SEP . $filename . '.php');
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
