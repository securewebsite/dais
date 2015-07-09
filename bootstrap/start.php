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
define('FRONT_FACADE', 'front');
define('ADMIN_FACADE', 'manage');
define('API_FACADE',   'api');

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

//require __DIR__ . SEP . 'paths.php';

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

// if ($loader = dirname(__DIR__) . SEP . 'peaches' . SEP . 'Dais' . SEP . 'autoload.php'):
//     require $loader;
// endif;

$autoload = new Dais\Autoload;


/**
 *  We also need to redirect calls to the app when no db config
 *  file exists.
 */
if (!isset($_ENV) || empty($_ENV['DB_DATABASE'])):
    throw new \Exception('No database config is set in your environment.');
endif;


/*
|--------------------------------------------------------------------------
|   Assemble Application
|--------------------------------------------------------------------------
|   Here we'll instantiate our application class and push through our 
|   config array so that we can set it to the IoC container.
|
|   Once we instantiate our application here we can now call it statically
|   via it's Facade ie: App::someMethod();
|
*/

$app = new Dais\Application(
    realpath(__DIR__ . '/../')
);
//var_dump($app);exit;
/*
|--------------------------------------------------------------------------
|   Register Your Service Providers
|--------------------------------------------------------------------------
|
|   Feel free to add your own service providers in the array below.
|   This includes third party service providers from other vendors.
|
|   If you're creating a service to interact with native services, or
|   you're overriding an existing service, ensure you place your services
|   and providers in the override directory.
|
*/

/**
 * App::registerServiceProviders([
 *    Dais\Services\MyCoolNewService::class,
 * ]);
*/

/*
|--------------------------------------------------------------------------
|   Boot Up the App
|--------------------------------------------------------------------------
|
|   Now that you've added any additional services we can boot the app and
|   intantiate all of our services and facades.
|   
*/

$app->boot();

return $app;
