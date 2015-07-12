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
        $this->db->query("
            INSERT INTO {$this->db->prefix}layout 
            SET name = '" . $this->db->escape($data['name']) . "'");
        
        $layout_id = $this->db->getLastId();
        
        if (isset($data['layout_route'])) {
            foreach ($data['layout_route'] as $layout_route) {
                $this->db->query("
                    INSERT INTO {$this->db->prefix}layout_route 
                    SET 
                        layout_id = '" . (int)$layout_id . "', 
                        store_id = '" . (int)$layout_route['store_id'] . "', 
                        route = '" . $this->db->escape($layout_route['route']) . "'");
            }
        }
        
        Theme::trigger('admin_add_layout', array('layout_id' => $layout_id));
    }
    
    public function editLayout($layout_id, $data) {
        $this->db->query("
            UPDATE {$this->db->prefix}layout 
            SET 
                name = '" . $this->db->escape($data['name']) . "' 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}layout_route 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        if (isset($data['layout_route'])) {
            foreach ($data['layout_route'] as $layout_route) {
                $this->db->query("
                    INSERT INTO {$this->db->prefix}layout_route 
                    SET 
                        layout_id = '" . (int)$layout_id . "', 
                        store_id = '" . (int)$layout_route['store_id'] . "', 
                        route = '" . $this->db->escape($layout_route['route']) . "'");
            }
        }
        
        Theme::trigger('admin_edit_layout', array('layout_id' => $layout_id));
    }
    
    public function deleteLayout($layout_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}layout 
            WHERE layout_id = '" . (int)$layout_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}layout_route 
            WHERE layout_id = '" . (int)$layout_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}category_to_layout 
            WHERE layout_id = '" . (int)$layout_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}product_to_layout 
            WHERE layout_id = '" . (int)$layout_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}page_to_layout 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        Theme::trigger('admin_delete_layout', array('layout_id' => $layout_id));
    }
    
    public function getLayout($layout_id) {
        $query = $this->db->query("
            SELECT DISTINCT * FROM {$this->db->prefix}layout 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        return $query->row;
    }
    
    public function getLayouts($data = array()) {
        $sql = "
            SELECT * 
            FROM {$this->db->prefix}layout";
        
        $sort_data = array('name');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY name";
        }
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
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
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getLayoutRoutes($layout_id) {
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}layout_route 
            WHERE layout_id = '" . (int)$layout_id . "'");
        
        return $query->rows;
    }
    
    public function getTotalLayouts() {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}layout");
        
        return $query->row['total'];
    }
}
