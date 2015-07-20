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

namespace App\Models\Admin\Catalog;

use App\Models\Model;

class Filter extends Model {
    
    public function addFilter($data) {
        DB::query("
            INSERT INTO `" . DB::prefix() . "filter_group` 
            SET sort_order = '" . (int)$data['sort_order'] . "'");
        
        $filter_group_id = DB::getLastId();
        
        foreach ($data['filter_group_description'] as $language_id => $value) {
            DB::query("
                INSERT INTO " . DB::prefix() . "filter_group_description 
                SET 
                    filter_group_id = '" . (int)$filter_group_id . "', 
                    language_id = '" . (int)$language_id . "', 
                    name = '" . DB::escape($value['name']) . "'");
        }
        
        if (isset($data['filter'])) {
            foreach ($data['filter'] as $filter) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "filter 
                    SET 
                        filter_group_id = '" . (int)$filter_group_id . "', 
                        sort_order = '" . (int)$filter['sort_order'] . "'");
                
                $filter_id = DB::getLastId();
                
                foreach ($filter['filter_description'] as $language_id => $filter_description) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "filter_description 
                        SET 
                            filter_id = '" . (int)$filter_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            filter_group_id = '" . (int)$filter_group_id . "', 
                            name = '" . DB::escape($filter_description['name']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_add_filter', array('filter_id' => $filter_id));
    }
    
    public function editFilter($filter_group_id, $data) {
        DB::query("
            UPDATE `" . DB::prefix() . "filter_group` 
            SET sort_order = '" . (int)$data['sort_order'] . "' 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "filter_group_description 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");
        
        foreach ($data['filter_group_description'] as $language_id => $value) {
            DB::query("
                INSERT INTO " . DB::prefix() . "filter_group_description 
                SET 
                    filter_group_id = '" . (int)$filter_group_id . "', 
                    language_id = '" . (int)$language_id . "', 
                    name = '" . DB::escape($value['name']) . "'");
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "filter 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "filter_description 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");
        
        if (isset($data['filter'])) {
            foreach ($data['filter'] as $filter) {
                if ($filter['filter_id']) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "filter 
                        SET 
                            filter_id = '" . (int)$filter['filter_id'] . "', 
                            filter_group_id = '" . (int)$filter_group_id . "', 
                            sort_order = '" . (int)$filter['sort_order'] . "'");
                } else {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "filter 
                        SET 
                            filter_group_id = '" . (int)$filter_group_id . "', 
                            sort_order = '" . (int)$filter['sort_order'] . "'");
                }
                
                $filter_id = DB::getLastId();
                
                foreach ($filter['filter_description'] as $language_id => $filter_description) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "filter_description 
                        SET 
                            filter_id = '" . (int)$filter_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            filter_group_id = '" . (int)$filter_group_id . "', 
                            name = '" . DB::escape($filter_description['name']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_edit_filter', array('filter_id' => $filter_id));
    }
    
    public function deleteFilter($filter_group_id) {
        DB::query("
            DELETE FROM `" . DB::prefix() . "filter_group` 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");

        DB::query("
            DELETE FROM `" . DB::prefix() . "filter_group_description` 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");

        DB::query("
            DELETE FROM `" . DB::prefix() . "filter` 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");

        DB::query("
            DELETE FROM `" . DB::prefix() . "filter_description` 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");
        
        Theme::trigger('admin_delete_filter');
    }
    
    public function getFilterGroup($filter_group_id) {
        $query = DB::query("
            SELECT * 
            FROM `" . DB::prefix() . "filter_group` fg 
            LEFT JOIN " . DB::prefix() . "filter_group_description fgd 
            ON (fg.filter_group_id = fgd.filter_group_id) 
            WHERE fg.filter_group_id = '" . (int)$filter_group_id . "' 
            AND fgd.language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row;
    }
    
    public function getFilterGroups($data = array()) {
        $sql = "
            SELECT * 
            FROM `" . DB::prefix() . "filter_group` fg 
            LEFT JOIN " . DB::prefix() . "filter_group_description fgd 
            ON (fg.filter_group_id = fgd.filter_group_id) 
            WHERE fgd.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        $sort_data = array('fgd.name', 'fg.sort_order');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY fgd.name";
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
    
    public function getFilterGroupDescriptions($filter_group_id) {
        $filter_group_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "filter_group_description 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");
        
        foreach ($query->rows as $result) {
            $filter_group_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $filter_group_data;
    }
    
    public function getFilter($filter_id) {
        $query = DB::query("
            SELECT *, 
            (SELECT name 
                FROM " . DB::prefix() . "filter_group_description fgd 
                WHERE f.filter_group_id = fgd.filter_group_id 
                AND fgd.language_id = '" . (int)Config::get('config_language_id') . "') AS `group` 
            FROM " . DB::prefix() . "filter f 
            LEFT JOIN " . DB::prefix() . "filter_description fd 
            ON (f.filter_id = fd.filter_id) 
            WHERE f.filter_id = '" . (int)$filter_id . "' 
            AND fd.language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row;
    }
    
    public function getFilters($data) {
        $sql = "
            SELECT *, 
            (SELECT name 
                FROM " . DB::prefix() . "filter_group_description fgd 
                WHERE f.filter_group_id = fgd.filter_group_id 
                AND fgd.language_id = '" . (int)Config::get('config_language_id') . "') AS `group` 
            FROM " . DB::prefix() . "filter f 
            LEFT JOIN " . DB::prefix() . "filter_description fd 
            ON (f.filter_id = fd.filter_id) 
            WHERE fd.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        if (!empty($data['filter_name'])) {
            $sql.= " AND fd.name LIKE '" . DB::escape($data['filter_name']) . "%'";
        }
        
        $sql.= " ORDER BY f.sort_order ASC";
        
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
    
    public function getFilterDescriptions($filter_group_id) {
        $filter_data = array();
        
        $filter_query = DB::query("
            SELECT * FROM " . DB::prefix() . "filter 
            WHERE filter_group_id = '" . (int)$filter_group_id . "'");
        
        foreach ($filter_query->rows as $filter) {
            $filter_description_data = array();
            
            $filter_description_query = DB::query("
                SELECT * FROM " . DB::prefix() . "filter_description 
                WHERE filter_id = '" . (int)$filter['filter_id'] . "'");
            
            foreach ($filter_description_query->rows as $filter_description) {
                $filter_description_data[$filter_description['language_id']] = array('name' => $filter_description['name']);
            }
            
            $filter_data[] = array('filter_id' => $filter['filter_id'], 'filter_description' => $filter_description_data, 'sort_order' => $filter['sort_order']);
        }
        
        return $filter_data;
    }
    
    public function getTotalFilterGroups() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM `" . DB::prefix() . "filter_group`");
        
        return $query->row['total'];
    }
}
