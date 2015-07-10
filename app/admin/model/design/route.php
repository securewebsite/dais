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

namespace Admin\Model\Design;
use Dais\Base\Model;

class Route extends Model {
    public function editRoutes($data) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}custom_route
        ");

        if (!empty($data['custom_route'])):
            foreach($data['custom_route'] as $route):
                $this->db->query("
                    INSERT INTO {$this->db->prefix}custom_route 
                    SET route = '" . $this->db->escape($route['route']) . "', 
                    slug      = '" . $this->db->escape($route['slug']) . "'
                ");
            endforeach;
        endif;
    }

    public function getCustomRoutes($data = array()) {
        $sql = "
            SELECT * 
            FROM {$this->db->prefix}custom_route ORDER BY route ASC";
        
        if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = 20;
            endif;
            
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }

	public function getTotalRoutes() {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}custom_route");
        
        return $query->row['total'];
    }
}
