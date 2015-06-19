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
|
|--------------------------------------------------------------------------
|	Environment Constants
|--------------------------------------------------------------------------
|
|	Let's set a couple constants so that we don't always have to reference 
|	the container. Just in case we want to implement something unexpected.
|
*/

define('VERSION', '1.0.1');

define('DATE_LOCALE', env('APP_TIMEZONE'));
date_default_timezone_set(DATE_LOCALE);

define('FRAMEWORK', dirname(__DIR__) . SEP . 'peaches' . SEP . 'Dais' . SEP);

/*
|--------------------------------------------------------------------------
|	Facade Keys
|--------------------------------------------------------------------------
|
|	Set your facade keys here according to your path, these are used 
|	dynamically to determine what area of the application is to be routed.
|	This is here mostly so you can rename your install and admin routes.
|
|	For instance if you want to change the route for install to "update",
|	you'll need to rename your assets directory to "update" and change the
|	install facade key.
|
*/

define('FRONT_FACADE', 'front');
define('ADMIN_FACADE', 'manage');
define('INSTALL_FACADE', 'install');
define('API_FACADE', 'api');
define('USE_TWIG', false);

/**
 * Let's include our framework start file so we can properly
 * detect our server settings.
 */

if ($file = FRAMEWORK . 'Start.php'):
	require $file;
endif;

/*
|--------------------------------------------------------------------------
|	Base Paths and Misc Config Settings
|--------------------------------------------------------------------------
|
|	Build some base config settings that are standard across all sections 
|	of the application, and set some base paths that don't depend on our 
|	facade. If you want to move directories around make sure you set
|	these to follow the correct path.
|
*/

define('HOME', dirname(__DIR__) . SEP);
define('APP_PATH', HOME . 'app' . SEP);
define('STORAGE', HOME . 'storage' . SEP);
define('PUBLIC_DIR', 'public' . SEP);

$base = array(
	'cache.prefix'   => md5($env['app.env'] . str_replace('.', '', VERSION)),
	'cache.hostname' => 'localhost',
	'cache.port'     => 11211,
	'cache.time'     => 86400,
	'path.app_path'  => APP_PATH,
	'path.framework' => FRAMEWORK,
	'path.database'  => HOME . 'database' . SEP,
	'path.download'  => APP_PATH . 'download' . SEP,
	'path.override'  => HOME . 'override' . SEP,
	'path.plugin'    => APP_PATH . 'plugin' . SEP,
	'path.storage'   => STORAGE,
	'path.cache'     => STORAGE . 'framework' . SEP . 'cache' . SEP,
	'path.logs'      => STORAGE . 'logs' . SEP,
	'path.views'     => STORAGE . 'framework' . SEP . 'views' . SEP,
	'prefix.plugin'  => 'plugin'
);

// Pushing this to a definition so it can be 
// used to implement the override functionality.
define('OVERRIDE', HOME . basename($base['path.override']));

// DO NOT CHANGE THE NAME OF THIS KEY

$config['base'] = $base;

/*
|--------------------------------------------------------------------------
|	Facade Paths
|--------------------------------------------------------------------------
|
|	This is where we set paths for our app which will be pulled into the 
|	Application, then built into the config object in the IoC container.
|	Once again these can be changed, but if you do, you'll need to update
|	Dais\Engine\Application to search for the correct key in the array.
|
*/

$front = array(
	'http.server'      => 'http://' . $env['app.env'] . '/',
	'https.server'     => 'http://' . $env['app.env'] . '/',
	'http.public'      => 'http://' . $env['app.env'] . '/',
	'path.application' => APP_PATH . 'front' . SEP,
	'path.language'    => APP_PATH . 'front' . SEP . 'language' . SEP,
	'path.theme'       => APP_PATH . 'theme' . SEP . 'front' . SEP,
	'path.public'      => HOME . PUBLIC_DIR,
	'path.image'       => HOME . PUBLIC_DIR . 'image' . SEP,
	'path.sessions'    => STORAGE . 'framework' . SEP . 'sessions' . SEP . 'front' . SEP,
	'path.asset'       => HOME . PUBLIC_DIR . 'asset' . SEP,
	'prefix.facade'    => 'front' . SEP
);

$config[FRONT_FACADE] = $front;

$admin = array(
	'http.server'      => 'http://' . $env['app.env'] . '/' . ADMIN_FACADE . '/',
	'http.public'      => 'http://' . $env['app.env'] . '/',
	'https.server'     => 'http://' . $env['app.env'] . '/' . ADMIN_FACADE . '/',
	'https.public'     => 'http://' . $env['app.env'] . '/',
	'path.application' => APP_PATH . 'admin' . SEP,
	'path.language'    => APP_PATH . 'admin' . SEP . 'language' . SEP,
	'path.theme'       => APP_PATH . 'theme' . SEP . 'admin' . SEP,
	'path.image'       => HOME . PUBLIC_DIR . 'image' . SEP,
	'path.sessions'    => STORAGE . 'framework' . SEP . 'sessions' . SEP . 'admin' . SEP,
	'path.asset'       => HOME . PUBLIC_DIR . 'asset' . SEP,
	'prefix.facade'    => 'admin' . SEP
);

$config[ADMIN_FACADE] = $admin;

$install = array(
	'http.server'      => 'http://' . $env['app.env'] . '/' . INSTALL_FACADE . '/',
	'https.server'     => 'http://' . $env['app.env'] . '/' . INSTALL_FACADE . '/',
	'http.public'      => 'http://' . $env['app.env'] . '/',
	'path.application' => APP_PATH . 'install' . SEP,
	'path.language'    => APP_PATH . 'install' . SEP . 'language' . SEP,
	'path.theme'       => APP_PATH . 'theme' . SEP . 'install' . SEP,
	'path.dais'        => HOME,
	'path.asset'       => HOME . PUBLIC_DIR . 'asset' . SEP,
	'prefix.facade'    => 'install' . SEP
);

$config[INSTALL_FACADE] = $install;

/*
|--------------------------------------------------------------------------
|	Pre-Render Controllers
|--------------------------------------------------------------------------
|	
|	Include our pre-render controllers file.
|
*/

require __DIR__ . SEP . 'controllers.php';
