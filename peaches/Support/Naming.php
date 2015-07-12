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

namespace Dais\Support;

class Naming {
	public static function class_from_filename($file) {
		$segments = explode('/', str_replace(array(App::basePath(), '.php'), array('', ''), $file));
		
		if ($segments[0] === ''):
			array_shift($segments);
		endif;

		$filename = array_pop($segments);
		
		foreach ($segments as $key => $segment):
			$segments[$key] = ucfirst($segment);
		endforeach;

		$segments = implode('\\', $segments);

		$pieces = explode('_', $filename);
		
		foreach($pieces as $key => $piece):
			$pieces[$key] = ucfirst($piece);
		endforeach;

		$pieces = implode($pieces);

		return $segments . '\\' . $pieces;
	}

	public static function file_from_classname ($class) {
		$segments  = explode('\\', $class);
		$classname = array_pop($segments);
		
		foreach($segments as $key => $segment):
			$segments[$key] = $segment;
		endforeach;

		$segments = implode('/', $segments);
		
		$pieces = preg_split('/(?=[A-Z])/', $classname);
        array_shift($pieces);
        
        foreach($pieces as $key => $piece):
            $pieces[$key] = $piece;
        endforeach;

        $pieces = implode('_', $pieces);

        return $segments . SEP . $pieces;
	}

	public static function file_from_route($route) {
		// build our paths
		$base_path    = Config::get('path.app') . 'Controllers' . SEP . Config::get('prefix.facade');
		$theme_path   = Config::get('path.theme') . Config::get('theme.name') . SEP . 'Controllers' . SEP;
		$plugin_path  = Config::get('path.app') . Config::get('prefix.plugin') . SEP;
		$plugin_theme = $theme_path . Config::get('prefix.plugin') . SEP;

		// let's determine if we have a plugin
		$segments = explode(SEP, $route);

		foreach($segments as $key => $segment):
			$pieces = explode('_', $segment);
			
			if (count($pieces) > 1):
				
				unset($segments[$key]);
				
				foreach($pieces as $key => $piece):
					$pieces[$key] = ucfirst($piece);
				endforeach;

				$pieces = implode($pieces);
				
				$segment = $pieces;
			endif;

			$segments[$key] = ucfirst($segment);
		endforeach;

		if ($segments[0] === Config::get('prefix.plugin')):
			$plugin = $segments[1];
			$plugin_path .= $plugin . SEP . Config::get('prefix.facade') . 'controller' . SEP;

			if (is_readable($file = $plugin_theme . $plugin . '.php')):
				return $file;
			else:
				return $plugin_path . $plugin . '.php';
			endif;
		endif; // plugins handled
		
		if (count($segments) === 3):
			array_pop($segments);
		endif;

		$route = implode(SEP, $segments);

		if (is_readable($file = $theme_path . $route . '.php')):
			return $file;
		else:
			// only return the file if it's readable
			return is_readable($base_path . $route . '.php') ? $base_path . $route . '.php' : null;
		endif;
	}

	public static function method_from_route($route) {
		$segments = explode(SEP, $route);

		if (count($segments) > 2):
			return $segments[2];
		else:
			return 'index';
		endif;
	}

	public static function class_for_model($model) {
		$base_path  = Config::get('path.app') . 'Models' . SEP . Config::get('prefix.facade');
		$theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'Models' . SEP;

        if (is_readable($file = $theme_path . $model . '.php')):
            return self::class_from_filename($file);
        else:
            return self::class_from_filename($base_path . $model . '.php');
        endif;
	}

	public static function class_for_hook($route) {
		$base_path  = Config::get('path.app') . 'Controllers' . SEP . Config::get('prefix.facade');
		$theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'Controllers' . SEP;
        
        if (is_readable($file = $theme_path . $route . '.php')):
            return self::class_from_filename($file);
        else:
            return self::class_from_filename($base_path . $route . '.php');
        endif;
	}
}
