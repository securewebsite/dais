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
		$base_path    = Config::get('path.app') . 'controllers' . SEP . Config::get('prefix.facade');
		$theme_path   = Config::get('path.theme') . Config::get('theme.name') . SEP . 'controllers' . SEP;
		$plugin_path  = Config::get('path.app') . Config::get('prefix.plugin') . SEP;
		$plugin_theme = $theme_path . Config::get('prefix.plugin') . SEP;

		// let's determine if we have a plugin
		$segments = explode(SEP, $route);

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
		endif;

		return 'index';
	}

	public static function class_for_model($model) {
		$base_path  = Config::get('path.app') . 'models' . SEP . Config::get('prefix.facade');
		$theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'models' . SEP;

        if (is_readable($file = $theme_path . $model . '.php')):
            return static::class_from_filename($file);
        else:
            return static::class_from_filename($base_path . $model . '.php');
        endif;
	}

	public static function class_for_plugin_model($plugin, $model) {
		$base_path   = Config::get('path.app') . 'models' . SEP . Config::get('prefix.facade');
		$plugin_path = Config::get('path.app') . Config::get('prefix.plugin') . SEP . $plugin . SEP . Config::get('prefix.facade') . 'model' . SEP;

		if (is_readable($file = $plugin_path . $model . '.php')):
            return static::class_from_filename($file);
        else:
            return static::class_from_filename($base_path . $model . '.php');
        endif;
	}

	public static function class_for_hook($route) {
		$base_path  = Config::get('path.app') . 'controllers' . SEP . Config::get('prefix.facade');
		$theme_path = Config::get('path.theme') . Config::get('theme.name') . SEP . 'controllers' . SEP;
        
        if (is_readable($file = $theme_path . $route . '.php')):
            return static::class_from_filename($file);
        else:
            return static::class_from_filename($base_path . $route . '.php');
        endif;
	}

	public static function studly_case($word) {
		return str_replace(' ', '', ucwords(str_replace(['/', '_', '-'], ' ', $word)));
	}

	public static function train_case ($word) {
		return strtolower(preg_replace('/(?|([a-z\d])([A-Z])|([^\^])([A-Z][a-z]))/', '$1_$2', $word));
	}

	public static function model_key($model) {
		return 'model_' . str_replace(SEP, '_', $model);
	}

	public static function model_alias($class) {
		$segments = explode('\\', $class);

		$file   = array_pop($segments);
		$prefix = array_pop($segments);

		$segments[] = 'Facades';
		$segments[] = $prefix . $file;

		return implode('\\', $segments);
	}

	/*
    This method is used in conjunction with the config_ucfirst
    configuration variable to rewrite urls to capitalize the
    first letter of each word in the slug for seo.
    
    Example:
    
    Product Slug: apple-iphone-5-and-waterproof-case
    New Url Slug: Apple-Iphone-5-and-Waterproof-Case
    
    call :: $this->url->cap_slug($slug)
    */
    
    public static function cap_slug($word) {
        $keyword = null;
        
        if (substr_count($word, '-') > 0):
            $arr  = [];
            $data = explode('-', $word);
            
            foreach ($data as $key):
                if (!empty($key)):
                    $arr[] = ucfirst(strtolower($key));
                endif;
            endforeach;
            
            $keyword = implode('-', $arr);
        else:
            $keyword = ucfirst(strtolower(trim($word, '-')));
        endif;
        
        $keyword = str_replace('And', 'and', $keyword);
        $keyword = str_replace('For', 'for', $keyword);
        $keyword = str_replace('Or', 'or', $keyword);
        
        return $keyword;
    }

    /*
    This method was created to automate the building of route slugs via
    the dashboard slug() method. Will take the passed in name of product,
    category, manufacturer or page and return a lowercase hyphenated and
    sanitized slug.
    
    Example:
    
    Product Name: Apple iPhone 5 & WaterProof Case
    Returned Slug: apple-iphone-5-and-waterproof-case
    
    call :: $this->url->build_slug($string)
    */
    
    public static function build_slug($string) {
        $string = static::sanitize_name($string);
        
        $string = str_replace('&amp', '&', $string);
        $string = str_replace('&quot', '"', $string);
        $string = str_replace('&', '-and-', $string);
        $string = str_replace(' / ', ' ', $string);
        $string = str_replace('/', ' ', $string);
        
        // convert measurement quotes
        $string = str_replace('"', '-inch-', $string);
        $string = str_replace("'", "-foot-", $string);
        
        // punctuation
        $string = trim(preg_replace('/[^\w\d_ -]/si', '', $string));
        $string = str_replace(' - ', '-', $string);
        $string = str_replace(' ', '-', $string);
        $string = str_replace('--', '-', $string);
        $string = str_replace('-------', '-', $string);
        
        return strtolower($string);
    }

    /*
    This method allows the dynamic addition of category paths for all urls
    when the top-level flag is unset.
    
    No changes need to be made calls to url->link()
    */
    
    
    /*
    This function was created to remove special chars and sanitize foreign letters
    for route slug creation for entry into the database.
    call ::  $this->url->sanitize ($string)
    */
    
    public static function sanitize_name($string) {
        $normalize = array(
            'Š' => 'S',
            'š' => 's',
            'Ð' => 'Dj',
            'Ž' => 'Z',
            'ž' => 'z',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'ƒ' => 'f',
            '"&#xA0;' => "'"
        );
        
        $string = str_replace(', ', ',', $string);
        $string = str_replace(',', ', ', $string);
        $string = str_replace('. ', '.', $string);
        $string = str_replace('.', '. ', $string);
        $string = str_replace('/ ', '/', $string);
        $string = str_replace(' /', '/', $string);
        $string = str_replace('/', ' / ', $string);
        
        $string = ucwords(strtolower($string));
        
        return strtr($string, $normalize);
    }
}
