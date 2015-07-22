<?php

/*
|--------------------------------------------------------------------------
|	Dais
|--------------------------------------------------------------------------
|
|	This file is part of the Dais Framework package.
|   
|	(c) Vince Kronlein <vince@dais.io>
|   
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|   
*/

namespace Dais\Services\Providers\Boot;

use Pimple\Container;

class Finder {

	protected static $instance;

	protected $basePath;
	protected $appPath;
	protected $themePath;
	protected $pluginPath;
	protected $file;
	protected $class;

	public function __construct(Container $app) {
		static::$instance = $app;

		$this->basePath   = $app->basePath();
		$this->appPath    = $app['config']->get('path.app');
		$this->themePath  = $app['theme']->getPath();
		$this->pluginPath = $app['config']->get('path.plugin');
	}

	public function find($route, $type = 'controller') {
		switch($type):
			case 'controller':
				return $this->getClass($route);
				break;
			case 'model':
				return $this->getModel($route);
				break;
		endswitch;
	}

	public function make($route, $type = 'controller') {
		switch($type):
			case 'controller':
				$class = $this->c($route);
				return new $class;
				break;
			case 'model':
				$class = $this->m($route);
				return new $class;
				break;
		endswitch;
	}

	public function getClass($route) {
		/*
		|--------------------------------------------------------------------------
		|	Controller CLass
		|--------------------------------------------------------------------------
		|	
		|	Build our file from the passed in route and return it's class.
		|
		*/
	
		if ($file = $this->file_from_route($route)):
			return $this->class_from_filename($file);
		endif;

		return false;
	}

	public function getModel($route) {

	}

	public function class_from_filename($file) {
		$segments = explode('/', str_replace(array($this->basePath, '.php'), array('', ''), $file));
		
		if ($segments[0] === ''):
			array_shift($segments);
		endif;

		$filename = array_pop($segments);
		
		foreach ($segments as $key => $segment):
			$segments[$key] = ucfirst($segment);
		endforeach;

		$segments = implode('\\', $segments);
		$pieces   = explode('_', $filename);
		
		foreach($pieces as $key => $piece):
			$pieces[$key] = ucfirst($piece);
		endforeach;

		$pieces = implode($pieces);

		return $segments . '\\' . $pieces;
	}

	public function file_from_route($route) {
		/*
		|--------------------------------------------------------------------------
		|	Set Paths
		|--------------------------------------------------------------------------
		*/
		
		$path   = 'controllers' . SEP;
		$module = static::$instance['config']->get('prefix.facade');
		$prefix = static::$instance['config']->get('prefix.plugin');
		
		/*
		|--------------------------------------------------------------------------
		|	Plugin Finder
		|--------------------------------------------------------------------------
		|	
		|	Determine if we have a theme overidden plugin file, or a normal
		|	plugin controller. 
		|
		*/
		
		$segments = explode(SEP, $route);
		unset($route);

		if ($segments[0] === $prefix):
			$plugin      = $segments[1];
			$plugin_path = $this->pluginPath . $plugin . SEP . $module . $path;
			$theme_path  = $this->themePath . $path . $prefix . SEP;

			if (is_readable($file = $theme_path . $plugin . '.php')):
				return $file;
			else:
				return $plugin_path . $plugin . '.php';
			endif;
		endif;

		if (count($segments) > 2):
			array_pop($segments);
		endif;

		$route = implode('/', $segments);
		
		/*
		|--------------------------------------------------------------------------
		|	Theme Finder
		|--------------------------------------------------------------------------
		*/
	
		if (is_readable($theme = $this->themePath . $path . $route . '.php')):
			return $theme;
		endif;

		/*
		|--------------------------------------------------------------------------
		|	Core Finder
		|--------------------------------------------------------------------------
		*/
		
		if (is_readable($core = $this->appPath . $path . $module . $route . '.php')):
			return $core;
		endif;

		return false;
	}
}
