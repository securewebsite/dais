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
|	Turn Up the Heat!
|--------------------------------------------------------------------------
|
|	Build our application and get ready to dazzle your clients with all
|	your awesomeness!
|
*/

require dirname(__DIR__) . '/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
|	Flush the Cache for Development
|--------------------------------------------------------------------------
|
|	Here we'll flush our cache if we have the caching turned off.
|
*/

if (Config::get('config_cache_status')):
    Cache::flush_cache();
endif;

/*
|--------------------------------------------------------------------------
|   Error Handler
|--------------------------------------------------------------------------
|
|   Let's set our error handler to use our staic error class.
|
*/

set_error_handler(array('Dais\Support\Error', 'error_handler'));

/*
|--------------------------------------------------------------------------
|	Fire It UP!!!!
|--------------------------------------------------------------------------
|
|	3 ... 2 ... 1 ...
|
*/

App::fire();
