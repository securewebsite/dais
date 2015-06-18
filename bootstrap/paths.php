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

define('DATE_LOCALE', 'America/Phoenix');
date_default_timezone_set(DATE_LOCALE);

define('SEP', DIRECTORY_SEPARATOR);

define('FRAMEWORK', dirname(__DIR__) . SEP . 'src' . SEP . '19peaches' . SEP . 'dais' . SEP . 'src' . SEP . 'Dais' . SEP);

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

define('APP_PATH', dirname(__DIR__) . SEP . 'app' . SEP);
define('STORAGE', APP_PATH . 'storage' . SEP);
define('PUBLIC_DIR', 'public' . SEP);

/**
 * Let's set some environment variables.
 * Require our file, declare some environments, then detect.
 * 
 * All developers need to fill in the array with their dev
 * details in order for the application and Egress cli to
 * function properly.
 */

if ($file = FRAMEWORK . 'Environment.php'):
	require $file;
endif;

$environments = file_get_contents(__DIR__ . '/environment.json');
$environments = json_decode($environments, true);

$env = \Dais\Environment::detectEnvironments($environments);

define('ENV', $env['environment']);

$base = array(
	'cache.prefix'   => md5($env['machine'] . str_replace('.', '', VERSION)),
	'cache.hostname' => 'localhost',
	'cache.port'     => 11211,
	'cache.time'     => 86400,
	'path.app_path'  => APP_PATH,
	'path.framework' => FRAMEWORK,
	'path.api'       => dirname(APP_PATH) . SEP . 'api' . SEP,
	'path.database'  => APP_PATH . 'database' . SEP,
	'path.download'  => APP_PATH . 'download' . SEP,
	'path.override'  => APP_PATH . 'override' . SEP,
	'path.plugin'    => APP_PATH . 'plugin' . SEP,
	'path.storage'   => STORAGE,
	'path.cache'     => STORAGE . 'cache' . SEP,
	'path.logs'      => STORAGE . 'logs' . SEP,
	'path.sessions'  => STORAGE . 'sessions' . SEP,
	'path.views'     => STORAGE . 'views' . SEP,
	'prefix.plugin'  => 'plugin'
);

// Pushing this to a definition so it can be 
// used to implement the override functionality.
define('OVERRIDE', dirname(APP_PATH) . SEP . basename($base['path.override']));

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
	'http.server'      => 'http://' . $env['machine'] . '/',
	'https.server'     => 'http://' . $env['machine'] . '/',
	'http.public'      => 'http://' . $env['machine'] . '/',
	'path.application' => APP_PATH . 'front' . SEP,
	'path.language'    => APP_PATH . 'front' . SEP . 'language' . SEP,
	'path.theme'       => APP_PATH . 'theme' . SEP . 'front' . SEP,
	'path.public'      => dirname(__DIR__) . SEP . PUBLIC_DIR,
	'path.image'       => dirname(__DIR__) . SEP . PUBLIC_DIR . 'image' . SEP,
	'path.asset'       => dirname(__DIR__) . SEP . PUBLIC_DIR . 'asset' . SEP,
	'prefix.facade'    => 'front' . SEP
);

$config[FRONT_FACADE] = $front;

$admin = array(
	'http.server'      => 'http://' . $env['machine'] . '/' . ADMIN_FACADE . '/',
	'http.public'      => 'http://' . $env['machine'] . '/',
	'https.server'     => 'http://' . $env['machine'] . '/' . ADMIN_FACADE . '/',
	'https.public'     => 'http://' . $env['machine'] . '/',
	'path.application' => APP_PATH . 'admin' . SEP,
	'path.language'    => APP_PATH . 'admin' . SEP . 'language' . SEP,
	'path.theme'       => APP_PATH . 'theme' . SEP . 'admin' . SEP,
	'path.image'       => dirname(__DIR__) . SEP . PUBLIC_DIR . 'image' . SEP,
	'path.asset'       => dirname(__DIR__) . SEP . PUBLIC_DIR . 'asset' . SEP,
	'prefix.facade'    => 'admin' . SEP
);

$config[ADMIN_FACADE] = $admin;

$install = array(
	'http.server'      => 'http://' . $env['machine'] . '/' . INSTALL_FACADE . '/',
	'https.server'     => 'http://' . $env['machine'] . '/' . INSTALL_FACADE . '/',
	'http.public'      => 'http://' . $env['machine'] . '/',
	'path.application' => APP_PATH . 'install' . SEP,
	'path.language'    => APP_PATH . 'install' . SEP . 'language' . SEP,
	'path.theme'       => APP_PATH . 'theme' . SEP . 'install' . SEP,
	'path.dais'        => dirname(__DIR__) . SEP,
	'path.asset'       => dirname(__DIR__) . SEP . PUBLIC_DIR . 'asset' . SEP,
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
