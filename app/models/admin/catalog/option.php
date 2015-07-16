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

class Option extends Model {
    
    public function addOption($data) {
        DB::query("
            INSERT INTO `" . DB::prefix() . "option` 
            SET 
                type = '" . DB::escape($data['type']) . "', 
                sort_order = '" . (int)$data['sort_order'] . "'");
        
        $option_id = DB::getLastId();
        
        foreach ($data['option_description'] as $language_id => $value) {
            DB::query("
                INSERT INTO " . DB::prefix() . "option_description 
                SET 
                    option_id = '" . (int)$option_id . "', 
                    language_id = '" . (int)$language_id . "', 
                    name = '" . DB::escape($value['name']) . "'");
        }
        
        if (isset($data['option_value'])) {
            foreach ($data['option_value'] as $option_value) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "option_value 
                    SET 
                        option_id = '" . (int)$option_id . "', 
                        image = '" . DB::escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', 
                        sort_order = '" . (int)$option_value['sort_order'] . "'");
                
                $option_value_id = DB::getLastId();
                
                foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "option_value_description 
                        SET 
                            option_value_id = '" . (int)$option_value_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            option_id = '" . (int)$option_id . "', 
                            name = '" . DB::escape($option_value_description['name']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_add_option', array('option_id' => $option_id));
    }
    
    public function editOption($option_id, $data) {
        DB::query("
            UPDATE `" . DB::prefix() . "option` 
            SET 
                type = '" . DB::escape($data['type']) . "', 
                sort_order = '" . (int)$data['sort_order'] . "' 
            WHERE option_id = '" . (int)$option_id . "'");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "option_description 
            WHERE option_id = '" . (int)$option_id . "'");
        
        foreach ($data['option_description'] as $language_id => $value) {
            DB::query("
                INSERT INTO " . DB::prefix() . "option_description 
                SET 
                    option_id = '" . (int)$option_id . "', 
                    language_id = '" . (int)$language_id . "', 
                    name = '" . DB::escape($value['name']) . "'");
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "option_value 
            WHERE option_id = '" . (int)$option_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "option_value_description 
            WHERE option_id = '" . (int)$option_id . "'");
        
        if (isset($data['option_value'])) {
            foreach ($data['option_value'] as $option_value) {
                if ($option_value['option_value_id']) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "option_value 
                        SET 
                            option_value_id = '" . (int)$option_value['option_value_id'] . "', 
                            option_id = '" . (int)$option_id . "', 
                            image = '" . DB::escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', 
                            sort_order = '" . (int)$option_value['sort_order'] . "'");
                } else {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "option_value 
                        SET 
                            option_id = '" . (int)$option_id . "', 
                            image = '" . DB::escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', 
                            sort_order = '" . (int)$option_value['sort_order'] . "'");
                }
                
                $option_value_id = DB::getLastId();
                
                foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "option_value_description 
                        SET 
                            option_value_id = '" . (int)$option_value_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            option_id = '" . (int)$option_id . "', 
                            name = '" . DB::escape($option_value_description['name']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_edit_option', array('option_id' => $option_id));
    }
    
    public function deleteOption($option_id) {
        DB::query("
            DELETE FROM `" . DB::prefix() . "option` 
            WHERE option_id = '" . (int)$option_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "option_description 
            WHERE option_id = '" . (int)$option_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "option_value 
            WHERE option_id = '" . (int)$option_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "option_value_description 
            WHERE option_id = '" . (int)$option_id . "'");
        
        Theme::trigger('admin_delete_option', array('option_id' => $option_id));
    }
    
    public function getOption($option_id) {
        $query = DB::query("
            SELECT * 
            FROM `" . DB::prefix() . "option` o 
            LEFT JOIN " . DB::prefix() . "option_description od 
            ON (o.option_id = od.option_id) 
            WHERE o.option_id = '" . (int)$option_id . "' 
            AND od.language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row;
    }
    
    public function getOptions($data = array()) {
        $sql = "
            SELECT * 
            FROM `" . DB::prefix() . "option` o 
            LEFT JOIN " . DB::prefix() . "option_description od 
            ON (o.option_id = od.option_id) 
            WHERE od.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $sql.= " AND od.name LIKE '" . DB::escape($data['filter_name']) . "%'";
        }
        
        $sort_data = array('od.name', 'o.type', 'o.sort_order');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY od.name";
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
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function getOptionDescriptions($option_id) {
        $option_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "option_description 
            WHERE option_id = '" . (int)$option_id . "'");
        
        foreach ($query->rows as $result) {
            $option_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $option_data;
    }
    
    public function getOptionValue($option_value_id) {
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "option_value ov 
            LEFT JOIN " . DB::prefix() . "option_value_description ovd 
            ON (ov.option_value_id = ovd.option_value_id) 
            WHERE ov.option_value_id = '" . (int)$option_value_id . "' 
            AND ovd.language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row;
    }
    
    public function getOptionValues($option_id) {
        $option_value_data = array();
        
        $option_value_query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "option_value ov 
            LEFT JOIN " . DB::prefix() . "option_value_description ovd 
            ON (ov.option_value_id = ovd.option_value_id) 
            WHERE ov.option_id = '" . (int)$option_id . "' 
            AND ovd.language_id = '" . (int)Config::get('config_language_id') . "' 
            ORDER BY ov.sort_order ASC");
        
        foreach ($option_value_query->rows as $option_value) {
            $option_value_data[] = array(
                'option_value_id' => $option_value['option_value_id'], 
                'name'            => $option_value['name'], 
                'image'           => $option_value['image'], 
                'sort_order'      => $option_value['sort_order']
            );
        }
        
        return $option_value_data;
    }
    
    public function getOptionValueDescriptions($option_id) {
        $option_value_data = array();
        
        $option_value_query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "option_value 
            WHERE option_id = '" . (int)$option_id . "'");
        
        foreach ($option_value_query->rows as $option_value) {
            $option_value_description_data = array();
            
            $option_value_description_query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "option_value_description 
                WHERE option_value_id = '" . (int)$option_value['option_value_id'] . "'");
            
            foreach ($option_value_description_query->rows as $option_value_description) {
                $option_value_description_data[$option_value_description['language_id']] = array('name' => $option_value_description['name']);
            }
            
            $option_value_data[] = array(
                'option_value_id'          => $option_value['option_value_id'], 
                'option_value_description' => $option_value_description_data, 
                'image'                    => $option_value['image'], 
                'sort_order'               => $option_value['sort_order']
            );
        }
        
        return $option_value_data;
    }
    
    public function getTotalOptions() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM `" . DB::prefix() . "option`");
        
        return $query->row['total'];
    }
}
