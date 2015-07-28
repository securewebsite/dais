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

namespace App\Models\Front\Locale;
use App\Models\Model;

class Country extends Model {
    public function getCountry($country_id) {
        $key = 'country.' . $country_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "country 
				WHERE country_id = '" . (int)$country_id . "' 
				AND status = '1'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCountries() {
        $key = 'countries.all';
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "country 
				WHERE status = '1' 
				ORDER BY name ASC
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
}
