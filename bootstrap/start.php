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

define('SEP', DIRECTORY_SEPARATOR);
define('DAIS_START', microtime(true));

/*
|--------------------------------------------------------------------------
|   Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
|   Composer provides a convenient, automatically generated class loader
|   for our application. We just need to utilize it! We'll require it
|   into the script here so that we do not have to worry about the
|   loading of any our classes "manually". Feels great to relax.
|
*/

require dirname(__DIR__) . SEP . 'vendor' . SEP . 'autoload.php';

/*
|--------------------------------------------------------------------------
|   Environment and Paths
|--------------------------------------------------------------------------
|
|   Lets require our paths and configuration array so we can boot this baby
|   up and change the world as we know it!
|
*/

Dotenv::load(dirname(__DIR__) . SEP);

// convert our global $_ENV to a more elegant array
$env = array();

foreach($_ENV as $key => $value):
    $env[strtolower(str_replace('_', '.', $key))] = $value;
endforeach;

require __DIR__ . SEP . 'paths.php';

/*
|--------------------------------------------------------------------------
|   API??
|--------------------------------------------------------------------------
|
|   If our API is called we need to build the Lumen api application
|   and return the api app only.
|
*/

if (preg_match('/^\/(' . API_FACADE . ')/', $_SERVER['REQUEST_URI'])):
    if (is_readable($api = __DIR__ . SEP . 'api.php')):
        require $api;
        $api->run();
        exit;
    endif;
endif;

/*
|--------------------------------------------------------------------------
|   Register the Dais Autoloader
|--------------------------------------------------------------------------
|
|   Let's make sure we can load up some classes or our users aren't gonna
|   have much of an experience with our super cool application.
|
*/

if ($loader = dirname(FRAMEWORK) . SEP . 'autoload.php'):
    require $loader;
endif;

/*
|--------------------------------------------------------------------------
|   Installer??
|--------------------------------------------------------------------------
|
|   If our install facade is called let's make sure we stay within the
|   installer application.  We'll let the installer app work out whether
|   we need to do an upgrade or new install.
|
*/

if (preg_match('/^\/(' . INSTALL_FACADE . ')/', $_SERVER['REQUEST_URI'])):
    $app = new Dais\Engine\Installer;
    return $app->buildConfigRequest($config);
else:
    
    /**
     *  We also need to redirect calls to the app when no db config
     *  file exists.
     */
    if (!isset($env) || empty($env['db.database'])):
        header('Location: ' . INSTALL_FACADE);
        //throw new \Exception('No database config is set in your environment.');
    endif;
endif;

/*
|--------------------------------------------------------------------------
|   Assemble Application
|--------------------------------------------------------------------------
|   Here we'll instantiate our application class and push through our 
|   config array so that we can set it to the IoC container.
|
*/

$app = new Dais\Application;

return $app->buildConfigRequest($config);
