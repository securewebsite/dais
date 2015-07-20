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

class Layout extends Model {
    
    public function addLayout($data) {
        DB::query("
            INSERT INTO " . DB::prefix() . "layout 
            SET name = '" . DB::escape($data['name']) . "'");
        
        $layout_id = DB::getLastId();
        
        if (isset($data['layout_route'])) {
            foreach ($data['layout_route'] as $layout_route) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "layout_route 
                    SET 
                        layout_id = '" . (int)$layout_id . "', 
                        store_id = '" . (int)$layout_route['store_id'] . "', 
                        route = '" . DB::escape($layout_route['route']) . "'");
            }
        }
        
        Theme::trigger('admin_add_layout', array('layout_id' => $layout_id));
    }
    
    public function editLayout($layout_id, $data) {
        DB::query("
            UPDATE " . DB::prefix() . "layout 
            SET 
                name = '" . DB::escape($data['name']) . "' 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "layout_route 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        if (isset($data['layout_route'])) {
            foreach ($data['layout_route'] as $layout_route) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "layout_route 
                    SET 
                        layout_id = '" . (int)$layout_id . "', 
                        store_id = '" . (int)$layout_route['store_id'] . "', 
                        route = '" . DB::escape($layout_route['route']) . "'");
            }
        }
        
        Theme::trigger('admin_edit_layout', array('layout_id' => $layout_id));
    }
    
    public function deleteLayout($layout_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "layout 
            WHERE layout_id = '" . (int)$layout_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "layout_route 
            WHERE layout_id = '" . (int)$layout_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "category_to_layout 
            WHERE layout_id = '" . (int)$layout_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "product_to_layout 
            WHERE layout_id = '" . (int)$layout_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "page_to_layout 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        Theme::trigger('admin_delete_layout', array('layout_id' => $layout_id));
    }
    
    public function getLayout($layout_id) {
        $query = DB::query("
            SELECT DISTINCT * FROM " . DB::prefix() . "layout 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        return $query->row;
    }
    
    public function getLayouts($data = array()) {
        $sql = "
            SELECT * 
            FROM " . DB::prefix() . "layout";
        
        $sort_data = array('name');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY name";
        }
        
        if (isset($data['order']) && ($data['order'] == 'desc')) {
            $sql.= " DESC";
        } else {
            $sql.= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function getLayoutRoutes($layout_id) {
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "layout_route 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        return $query->rows;
    }
    
    public function getTotalLayouts() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "layout");
        
        return $query->row['total'];
    }
}
