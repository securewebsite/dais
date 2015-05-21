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

namespace Dais\Library;
use Dais\Engine\Theme;

class Naming {
	public static function class_from_filename($file) {
		$segments = explode('/', str_replace(array(APP_PATH, '.php'), array('', ''), $file));
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
			$segments[$key] = strtolower($segment);
		endforeach;

		$segments = implode('/', $segments);
		
		$pieces = preg_split('/(?=[A-Z])/', $classname);
        array_shift($pieces);
        
        foreach($pieces as $key => $piece):
            $pieces[$key] = strtolower($piece);
        endforeach;

        $pieces = implode('_', $pieces);

        return $segments . SEP . $pieces;
	}

	public static function file_from_route($app, $route) {
		// build our paths
		$base_path    = APP_PATH . $app['prefix.fascade'] . 'controller' . SEP;
		$theme_path   = $app['path.theme'] . $app['theme.name'] . SEP . 'controller' . SEP;
		$plugin_path  = APP_PATH . $app['prefix.plugin'] . SEP;
		$plugin_theme = $theme_path . $app['prefix.plugin'] . SEP;
		
		// let's determine if we have a plugin
		$segments = explode(SEP, $route);

		if ($segments[0] === $app['prefix.plugin']):
			$plugin = $segments[1];
			$plugin_path .= $plugin . SEP . $app['prefix.fascade'] . 'controller' . SEP;

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
			return $base_path . $route . '.php';
		endif;
	}

	public static function method_from_route($app, $route) {
		$segments = explode(SEP, $route);

		if (count($segments) > 2):
			return $segments[2];
		else:
			return 'index';
		endif;
	}

	public static function class_for_model($model) {
		$base_path  = APP_PATH . Theme::app('prefix.fascade') . 'model' . SEP;
		$theme_path = Theme::app('path.theme') . Theme::app('theme.name') . SEP . 'model' . SEP;

        if (is_readable($file = $theme_path . $model . '.php')):
            return self::class_from_filename($file);
        else:
            return self::class_from_filename($base_path . $model . '.php');
        endif;
	}

	public static function class_for_hook($route) {
		$base_path  = APP_PATH . Theme::app('prefix.fascade') . 'controller' . SEP;
		$theme_path = Theme::app('path.theme') . Theme::app('theme.name') . SEP . 'controller' . SEP;
        
        if (is_readable($file = $theme_path . $route . '.php')):
            return self::class_from_filename($file);
        else:
            return self::class_from_filename($base_path . $route . '.php');
        endif;
	}
}
