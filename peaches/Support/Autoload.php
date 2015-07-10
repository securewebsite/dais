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

namespace Dais\Support;

class Autoload {

    public static function register() {
        /*
        |--------------------------------------------------------------------------
        |   Application Autoloader
        |--------------------------------------------------------------------------
        |
        |   This autoloader loads all of our classes from within the app directory.
        |   Once again, no need for a named method, just use a simple closure.
        |   
        */

        spl_autoload_register(function ($class) {
            $classname = Naming::file_from_classname($class);
            
            if (is_readable($file = APP_PATH . str_replace('\\', SEP, $classname) . '.php')):
                require $file;
            else:
                return;
            endif;
        });
    }
}
