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

require dirname(__DIR__) . '/bootstrap/start.php';

/*
|--------------------------------------------------------------------------
|	Flush the Cache for Development
|--------------------------------------------------------------------------
|
|	Here we'll flush our cache if we have the caching turned off.
|
*/

if ($app->data['active.facade'] !== INSTALL_FACADE && !$app->data['config_cache_status']):
    $app->data['cache']->flush_cache();
endif;

/*
|--------------------------------------------------------------------------
|	Fire It UP!!!!
|--------------------------------------------------------------------------
|
|	3 ... 2 ... 1 ...
|
*/

$app->fire();
