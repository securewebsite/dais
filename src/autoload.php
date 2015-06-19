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



/*
|--------------------------------------------------------------------------
|   Dais Framework Autoloader
|--------------------------------------------------------------------------
|
|   This autoloader loads all the Dais Framework classes and is written
|   as a simple closure.  No need for a named function.
|   
*/

spl_autoload_register(function ($class) {
    if (is_readable($file = dirname(FRAMEWORK) . SEP . str_replace('\\', SEP, $class) . '.php')):

        /*
        |--------------------------------------------------------------------------
        |   Override Framework Files
        |--------------------------------------------------------------------------
        |
        |   All of our autoloaded framework classes are passed through this 
        |   statement so that they can be overriden by developers.
        |
        */

        if (substr($file, 0, strlen(FRAMEWORK)) == FRAMEWORK):
            $override = OVERRIDE . substr($file, strlen(dirname(FRAMEWORK)));
        endif;

        if (is_readable($override)):
            require $override;
        else:
            require $file;
        endif;

        return true;
    endif;
});

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
    $classname = \Dais\Library\Naming::file_from_classname($class);
    
    if (is_readable($file = APP_PATH . str_replace('\\', SEP, $classname) . '.php')):
        require $file;
    else:
        return;
    endif;
});
