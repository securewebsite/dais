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

namespace App\Models\Admin\Module;

use App\Models\Model;

class Menu extends Model {
    
    public function addMenu($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "menu 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				type = '" . DB::escape($data['type']) . "', 
				items = '" . DB::escape(serialize($data['menu_item'])) . "', 
				status = '" . (int)$data['status'] . "'
		");
        
        Cache::delete('menu');
    }
    
    public function editMenu($menu_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "menu 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				type = '" . DB::escape($data['type']) . "', 
				items = '" . DB::escape(serialize($data['menu_item'])) . "', 
				status = '" . (int)$data['status'] . "' 
			WHERE menu_id = '" . (int)$menu_id . "'
		");
        
        Cache::delete('menu');
    }
    
    public function deleteMenu($menu_id) {
        DB::query("DELETE FROM " . DB::prefix() . "menu WHERE menu_id = '" . (int)$menu_id . "'");
        
        Cache::delete('menu');
    }
    
    public function getTotalMenus() {
        $query = DB::query("
			SELECT COUNT(menu_id) AS total 
			FROM " . DB::prefix() . "menu");
        
        return $query->row['total'];
    }
    
    public function getMenus($data = array()) {
        $menu_data = array();
        
        $sql = "
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "menu 
			GROUP BY type, menu_id";
        
        if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = Config::get('config_admin_limit');
            endif;
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;
        
        $query = DB::query($sql);
        
        foreach ($query->rows as $row):
            foreach ($row as $key => $value):
                if ($key == 'items'):
                    $row[$key] = unserialize($value);
                else:
                    $row[$key] = $value;
                endif;
            endforeach;
            $menu_data[] = $row;
        endforeach;
        
        return $menu_data;
    }
    
    public function getMenu($menu_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "menu 
			WHERE menu_id = '" . (int)$menu_id . "'
		");
        
        foreach ($query->row as $key => $value):
            if ($key == 'items'):
                $query->row[$key] = unserialize($value);
            endif;
        endforeach;
        
        return $query->row;
    }
}
