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

define('DAIS_START', microtime(true));
define('VERSION', '1.0.11');

/*
|--------------------------------------------------------------------------
|	Environment and Paths
|--------------------------------------------------------------------------
|
|	Lets require our paths and configuration array so we can boot this baby
|	up and change the world as we know it!
|
*/

require dirname(__FILE__) . '/bootstrap/paths.php';

if ($app = dirname(__FILE__) . '/' . PUBLIC_DIR . 'index.php'):
    require $app;
endif;
