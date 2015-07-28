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

class Menu extends Model {
    public function getMenu($menu_id) {
        $key = 'menu.' . $menu_id;
        $row = Cache::get($key);
        
        if (is_bool($row)):
            $query = DB::query("
				SELECT DISTINCT * 
				FROM " . DB::prefix() . "menu 
				WHERE menu_id = '" . (int)$menu_id . "' 
				AND status = '1'
			");
            
            $row = $query->row;
            Cache::set($key, $row);
        endif;
        unset($key);
        
        foreach ($row as $key => $value):
            if ($key == 'items'):
                $row[$key] = unserialize($value);
            else:
                $row[$key] = $value;
            endif;
        endforeach;
        
        return $row;
    }
    
    public function getDefault() {
        $key = 'menu.default.layoutid';
        $row = Cache::get($key);
        
        if (is_bool($row)):
            $query = DB::query("
				SELECT layout_id 
				FROM " . DB::prefix() . "layout 
				WHERE name = 'default'
			");
            
            $row = $query->row['layout_id'];
            Cache::set($key, $row);
        endif;
        
        return $row;
    }
    
    public function getLayouts($route) {
        $key = 'menu.layouts.' . str_replace('/', '.', rtrim($route, '/'));
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $layouts = array();
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "layout_route 
				WHERE route 
				LIKE '" . DB::escape($route) . "%'
			");
            
            foreach ($query->rows as $row):
                $layouts[] = $row['layout_id'];
            endforeach;
            
            $cachefile = $layouts;
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
}
