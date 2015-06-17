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
|
|--------------------------------------------------------------------------
| 	Create Lumen API
|--------------------------------------------------------------------------
|
| 	First we need to get an application instance. This creates an instance
| 	of the application / container and bootstraps the application so it
| 	is ready to receive HTTP / Console requests from the environment.
|
*/

if (is_readable($app = dirname(__DIR__) . '/api/bootstrap/app.php')):
	require $app;
endif;

/*
|--------------------------------------------------------------------------
| 	Run The Application
|--------------------------------------------------------------------------
|
| 	Once we have the application, we can handle the incoming request
| 	through the kernel, and send the associated response back to
| 	the client's browser allowing them to enjoy the creative
| 	and wonderful application we have prepared for them.
|
*/

$app->run();
