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

class Zone extends Model {
    public function getZone($zone_id) {
        $key = 'zone.' . $zone_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "zone 
				WHERE zone_id = '" . (int)$zone_id . "' 
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
    
    public function getZonesByCountryId($country_id) {
        $key = 'zones.country.' . $country_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "zone 
				WHERE country_id = '" . (int)$country_id . "' 
				AND status = '1' 
				ORDER BY name
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
