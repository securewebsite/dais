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

namespace Admin\Model\Module;
use Dais\Base\Model;

class Menu extends Model {
    public function addMenu($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}menu 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				type = '" . $this->db->escape($data['type']) . "', 
				items = '" . $this->db->escape(serialize($data['menu_item'])) . "', 
				status = '" . (int)$data['status'] . "'
		");
        
        $this->cache->delete('menu');
    }
    
    public function editMenu($menu_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}menu 
			SET 
				name = '" . $this->db->escape($data['name']) . "', 
				type = '" . $this->db->escape($data['type']) . "', 
				items = '" . $this->db->escape(serialize($data['menu_item'])) . "', 
				status = '" . (int)$data['status'] . "' 
			WHERE menu_id = '" . (int)$menu_id . "'
		");
        
        $this->cache->delete('menu');
    }
    
    public function deleteMenu($menu_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}menu WHERE menu_id = '" . (int)$menu_id . "'");
        
        $this->cache->delete('menu');
    }
    
    public function getTotalMenus() {
        $query = $this->db->query("
			SELECT COUNT(menu_id) AS total 
			FROM {$this->db->prefix}menu");
        
        return $query->row['total'];
    }
    
    public function getMenus($data = array()) {
        $menu_data = array();
        
        $sql = "
			SELECT DISTINCT * 
			FROM {$this->db->prefix}menu 
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
        
        $query = $this->db->query($sql);
        
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
        $query = $this->db->query("
			SELECT DISTINCT * 
			FROM {$this->db->prefix}menu 
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
