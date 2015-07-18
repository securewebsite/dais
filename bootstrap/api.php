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

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Dotenv::load(dirname(__DIR__) . DIRECTORY_SEPARATOR);

/*
|--------------------------------------------------------------------------
| 	Create The Application
|--------------------------------------------------------------------------
|
| 	Here we will load the environment and create the application instance
| 	that serves as the central piece of this framework. We'll use this
| 	application as an "IoC" container and router for this framework.
|
*/

$api = new Dais\Api(
	realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR)
);

$api->withFacades();
$api->withEloquent();

/*
|--------------------------------------------------------------------------
| 	Register Container Bindings
|--------------------------------------------------------------------------
|
| 	Now we will register a few bindings in the service container. We will
| 	register the exception handler and the console kernel. You may add
| 	your own bindings here if you like or you can make another file.
|
*/

$api->singleton(
    'Illuminate\Contracts\Debug\ExceptionHandler',
    'Api\Exceptions\Handler'
);

$api->singleton(
    'Illuminate\Contracts\Console\Kernel',
    'Api\Console\Kernel'
);

/*
|--------------------------------------------------------------------------
| 	Register Middleware
|--------------------------------------------------------------------------
|
| 	Next, we will register the middleware with the application. These can
| 	be global middleware that run before and after each request into a
| 	route or middleware that'll be assigned to some specific routes.
|
*/

$api->middleware([
	//'Illuminate\Cookie\Middleware\EncryptCookies',
	//'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
	//'Illuminate\Session\Middleware\StartSession',
	//'Illuminate\View\Middleware\ShareErrorsFromSession',
	//'Laravel\Lumen\Http\Middleware\VerifyCsrfToken',
]);

// $api->routeMiddleware([

// ]);

/*
|--------------------------------------------------------------------------
| 	Register Service Providers
|--------------------------------------------------------------------------
|
| 	Here we will register all of the application's service providers which
| 	are used to bind services into the container. Service providers are
| 	totally optional, so you are not required to uncomment this line.
|
*/

// $api->register('Api\Providers\AppServiceProvider');

/*
|--------------------------------------------------------------------------
| 	Load The Application Routes
|--------------------------------------------------------------------------
|
| 	Next we will include the routes file so that they can all be added to
| 	the application. This will provide all of the URLs the application
| 	can respond to, as well as the controllers that may handle them.
|
*/

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'routes.php';

return $api;
