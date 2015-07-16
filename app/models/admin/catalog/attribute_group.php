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

class AttributeGroup extends Model {
    
    public function addAttributeGroup($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "attribute_group 
			SET sort_order = '" . (int)$data['sort_order'] . "'");
        
        $attribute_group_id = DB::getLastId();
        
        foreach ($data['attribute_group_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "attribute_group_description 
				SET 
					attribute_group_id = '" . (int)$attribute_group_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "'");
        }
        
        Theme::trigger('admin_add_attribute_group', array('attribute_group_id' => $attribute_group_id));
    }
    
    public function editAttributeGroup($attribute_group_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "attribute_group 
			SET 
				sort_order = '" . (int)$data['sort_order'] . "' 
			WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
        
        DB::query("
			DELETE FROM " . DB::prefix() . "attribute_group_description 
			WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
        
        foreach ($data['attribute_group_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "attribute_group_description 
				SET 
					attribute_group_id = '" . (int)$attribute_group_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "'");
        }
        
        Theme::trigger('admin_edit_attribute_group', array('attribute_group_id' => $attribute_group_id));
    }
    
    public function deleteAttributeGroup($attribute_group_id) {
        DB::query("
			DELETE FROM " . DB::prefix() . "attribute_group 
			WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
        
        DB::query("
			DELETE FROM " . DB::prefix() . "attribute_group_description 
			WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
        
        Theme::trigger('admin_delete_attribute_group', array('attribute_group_id' => $attribute_group_id));
    }
    
    public function getAttributeGroup($attribute_group_id) {
        $query = DB::query("
			SELECT * FROM " . DB::prefix() . "attribute_group 
			WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
        
        return $query->row;
    }
    
    public function getAttributeGroups($data = array()) {
        $params = array();
        $sql = "
			SELECT * 
			FROM " . DB::prefix() . "attribute_group ag 
			LEFT JOIN " . DB::prefix() . "attribute_group_description agd 
			ON (ag.attribute_group_id = agd.attribute_group_id) 
			WHERE agd.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        $sort_data = array('agd.name', 'ag.sort_order');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY agd.name";
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
        
        $query = DB::query($sql, $params);
        
        return $query->rows;
    }
    
    public function getAttributeGroupDescriptions($attribute_group_id) {
        $attribute_group_data = array();
        
        $query = DB::query("SELECT * FROM " . DB::prefix() . "attribute_group_description WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
        
        foreach ($query->rows as $result) {
            $attribute_group_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $attribute_group_data;
    }
    
    public function getTotalAttributeGroups() {
        $query = DB::query("SELECT COUNT(*) AS total FROM " . DB::prefix() . "attribute_group");
        
        return $query->row['total'];
    }
}
