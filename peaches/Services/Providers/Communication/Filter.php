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

namespace Dais\Services\Providers\Communication;

class Filter {

    public function uri($filters) {
		$uri     = '';
		$url     = array();

		foreach($filters as $filter):
			if (isset(Request::get($filter))):
				$url[$filter] = Request::get($filter);
			endif;
		endforeach;

		$url = http_build_query($url);

		if ($url):
    		$uri .= '&' . $url;
    	endif;

    	return $uri;
    }

    public function map($filters, $default = array()) {
		$data    = array();
		
		foreach ($filters as $filter):
			if (isset(Request::get($filter))):
				$data[$filter] = Request::get($filter);
			else:
				$data[$filter] = (!empty($default) && array_key_exists($filter, $default)) ? $default[$filter] : null;
			endif;
		endforeach;

		return $data;
    }

    public function unsort($filters) {
    	if (($key = array_search('sort', $filters)) !== false):
            unset($filters[$key]);
        endif;

        if (($key = array_search('order', $filters)) !== false):
            unset($filters[$key]);
        endif;

        return $filters;
    }

    public function unpage($filters) {
    	if (($key = array_search('page', $filters)) !== false):
            unset($filters[$key]);
        endif;

        return $filters;
    }
}
