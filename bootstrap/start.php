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

// Directory separator
define('SEP', DIRECTORY_SEPARATOR);

// App start up time
define('DAIS_START', microtime(true));

/*
|--------------------------------------------------------------------------
|   Front Component Directory
|--------------------------------------------------------------------------
|	
|	The name of your front facing component directory. If you rename the
|	directory make sure you change it here. Best practice is to leave this
|	directory as is.
|
*/

define('FRONT_FACADE', 'front');

/*
|--------------------------------------------------------------------------
|   Admin Component Directory
|--------------------------------------------------------------------------
|	
|	The name of your admin facing component. For security you can change
|	this constant here, but do not rename the directory itself. The app
|	will automatically reroute requests for this constant to the admin
|	directory.
|
*/

define('ADMIN_FACADE', 'manage');

/*
|--------------------------------------------------------------------------
|   API Component Directory
|--------------------------------------------------------------------------
|	
|	DO NOT CHANGE.
|
*/

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

//Dais\Support\Autoload::register();


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
 * $app->registerServiceProviders([
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

//var_dump($app);exit;

return $app;
