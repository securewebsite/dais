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

define('DATE_LOCALE', 'America/Phoenix');
define('FRAMEWORK', dirname(__DIR__) . '/vendor/Dais/');

/*
|--------------------------------------------------------------------------
|	Fascade Keys
|--------------------------------------------------------------------------
|
|	Set your fascade keys here according to your path, these are used 
|	dynamically to determine what area of the application is to be routed.
|	This is here mostly so you can rename your install and admin routes.
|
|	For instance if you want to change the route for install to "update",
|	you'll need to rename your assets directory to "update" and change the
|	install fascade key.
|
*/

define('FRONT_FASCADE', 'front');
define('ADMIN_FASCADE', 'manage');
define('INSTALL_FASCADE', 'install');
define('USE_TWIG', false);

/**
 * Let's include our framework start file so we can properly
 * detect our server settings.
 */

require FRAMEWORK . 'start.php';

/*
|--------------------------------------------------------------------------
|	Base Paths and Misc Config Settings
|--------------------------------------------------------------------------
|
|	Build some base config settings that are standard across all sections 
|	of the application, and set some base paths that don't depend on our 
|	fascade. If you want to move directories around make sure you set
|	these to follow the correct path.
|
*/

define('APP_PATH', $_SERVER['DOCUMENT_ROOT'] . '/app/');
define('STORAGE', APP_PATH . 'storage/');
define('PUBLIC_DIR', 'public/');

$base = array(
	'cache.prefix'   => md5($_SERVER['SERVER_NAME'] . str_replace('.', '', VERSION)),
	'cache.hostname' => 'localhost',
	'cache.port'     => 11211,
	'cache.time'     => 86400,
	'path.app_path'  => APP_PATH,
	'path.framework' => FRAMEWORK,
	'path.database'  => APP_PATH . 'database/',
	'path.download'  => APP_PATH . 'download/',
	'path.override'  => APP_PATH . 'override/',
	'path.plugin'    => APP_PATH . 'plugin/',
	'path.storage'   => STORAGE,
	'path.cache'     => STORAGE . 'cache/',
	'path.logs'      => STORAGE . 'logs/',
	'path.sessions'  => STORAGE . 'sessions/',
	'path.views'     => STORAGE . 'views/',
	'prefix.plugin'  => 'plugin'
);

// Pushing this to a definition so it can be 
// used to implement the override functionality.
define('OVERRIDE', dirname(APP_PATH) . '/' . basename($base['path.override']));

$config['base'] = $base;

// DO NOT CHANGE THE NAME OF THIS KEY

/*
|--------------------------------------------------------------------------
|	Fascade Paths
|--------------------------------------------------------------------------
|
|	This is where we set paths for our app which will be pulled into the 
|	Application, then built into the config object in the IoC container.
|	Once again these can be changed, but if you do, you'll need to update
|	Dais\Engine\Application to search for the correct key in the array.
|
*/

$front = array(
	'http.server'      => 'http://' . $_SERVER['SERVER_NAME'] . '/',
	'https.server'     => 'http://' . $_SERVER['SERVER_NAME'] . '/',
	'http.public'      => 'http://' . $_SERVER['SERVER_NAME'] . '/',
	'path.application' => APP_PATH . 'front/',
	'path.language'    => APP_PATH . 'front/language/',
	'path.theme'       => APP_PATH . 'theme/front/',
	'path.public'      => dirname(__DIR__) . '/' . PUBLIC_DIR,
	'path.image'       => dirname(__DIR__) . '/' . PUBLIC_DIR . 'image/',
	'path.asset'       => dirname(__DIR__) . '/' . PUBLIC_DIR . 'asset/',
	'prefix.fascade'   => 'Front\\'
);

$config[FRONT_FASCADE] = $front;

$admin = array(
	'http.server'      => 'http://' . $_SERVER['SERVER_NAME'] . '/' . ADMIN_FASCADE . '/',
	'http.public'      => 'http://' . $_SERVER['SERVER_NAME'] . '/',
	'https.server'     => 'http://' . $_SERVER['SERVER_NAME'] . '/' . ADMIN_FASCADE . '/',
	'https.public'     => 'http://' . $_SERVER['SERVER_NAME'] . '/',
	'path.application' => APP_PATH . 'admin/',
	'path.language'    => APP_PATH . 'admin/language/',
	'path.theme'       => APP_PATH . 'theme/admin/',
	'path.image'       => dirname(__DIR__) . '/' . PUBLIC_DIR . 'image/',
	'path.asset'       => dirname(__DIR__) . '/' . PUBLIC_DIR . 'asset/',
	'prefix.fascade'   => 'Admin\\'
);

$config[ADMIN_FASCADE] = $admin;

$install = array(
	'http.server'      => 'http://' . $_SERVER['SERVER_NAME'] . '/install/',
	'https.server'     => 'http://' . $_SERVER['SERVER_NAME'] . '/install/',
	'http.public'      => 'http://' . $_SERVER['SERVER_NAME'] . '/',
	'path.application' => APP_PATH . 'install/',
	'path.language'    => APP_PATH . 'install/language/',
	'path.theme'       => APP_PATH . 'theme/install/',
	'path.dais'         => $_SERVER['DOCUMENT_ROOT'] . '/',
	'path.asset'       => dirname(__DIR__) . '/' . PUBLIC_DIR . 'asset/',
	'prefix.fascade'   => 'Install\\'
);

$config[INSTALL_FASCADE] = $install;

/*
|--------------------------------------------------------------------------
|	Pre-Render Controllers
|--------------------------------------------------------------------------
|	
|	Include our pre-render controllers file.
|
*/

require __DIR__ . '/controllers.php';

/*
|--------------------------------------------------------------------------
|	Custom Routes
|--------------------------------------------------------------------------
|
|	Set up your custom routes that you'd like implemented in the Routes
|	class. 
*/

$custom_routes = array(
	'contact'  => 'content/contact',
	'sitemap'  => 'content/sitemap',
	'login'    => 'account/login',
	'logout'   => 'account/logout',
	'register' => 'account/register',
	'blog'     => 'content/home',
	'shop'     => 'shop/home',
	'queue'    => 'common/queue',
	'calendar' => 'content/calendar'
);

$config[FRONT_FASCADE]['custom.routes'] = $custom_routes;
