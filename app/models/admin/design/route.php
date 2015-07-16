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

namespace App\Models\Admin\Design;

use App\Models\Model;

class Route extends Model {
    
    public function editRoutes($data) {
        DB::query("
            DELETE FROM " . DB::prefix() . "custom_route
        ");

        if (!empty($data['custom_route'])):
            foreach($data['custom_route'] as $route):
                DB::query("
                    INSERT INTO " . DB::prefix() . "custom_route 
                    SET route = '" . DB::escape($route['route']) . "', 
                    slug      = '" . DB::escape($route['slug']) . "'
                ");
            endforeach;
        endif;
    }

    public function getCustomRoutes($data = array()) {
        $sql = "
            SELECT * 
            FROM " . DB::prefix() . "custom_route ORDER BY route ASC";
        
        if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = 20;
            endif;
            
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;
        
        $query = DB::query($sql);
        
        return $query->rows;
    }

	public function getTotalRoutes() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "custom_route");
        
        return $query->row['total'];
    }
}
