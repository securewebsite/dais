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

namespace App\Models\Front\Setting;
use App\Models\Model;

class Setting extends Model {
    public function getSetting($group, $store_id = 0) {
        $key = $group . '.setting.' . $store_id;
        $rows = $this->cache->get($key);
        
        $data = array();
        
        if (is_bool($rows)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "setting 
				WHERE store_id = '" . (int)$store_id . "' 
				AND section = '" . DB::escape($group) . "'
			");
            
            $rows = $query->rows;
            $this->cache->set($key, $rows);
        endif;
        
        foreach ($rows as $result):
            if (!$result['serialized']):
                $data[$result['item']] = $result['data'];
            else:
                $data[$result['item']] = unserialize($result['data']);
            endif;
        endforeach;
        
        return $data;
    }
}
