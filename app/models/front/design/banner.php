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

namespace App\Models\Front\Design;
use App\Models\Model;

class Banner extends Model {
    public function getBanner($banner_id) {
        $key = 'banner.' . $banner_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "banner_image bi 
				LEFT JOIN " . DB::prefix() . "banner_image_description bid 
				ON (bi.banner_image_id  = bid.banner_image_id) 
				WHERE bi.banner_id = '" . (int)$banner_id . "' 
				AND bid.language_id = '" . (int)Config::get('config_language_id') . "'
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
