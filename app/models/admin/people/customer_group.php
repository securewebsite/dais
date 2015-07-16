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

namespace App\Models\Admin\People;

use App\Models\Model;

class CustomerGroup extends Model {
    
    public function addCustomerGroup($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "customer_group 
			SET 
				approval = '" . (int)$data['approval'] . "', 
				company_id_display = '" . (int)$data['company_id_display'] . "', 
				company_id_required = '" . (int)$data['company_id_required'] . "', 
				tax_id_display = '" . (int)$data['tax_id_display'] . "', 
				tax_id_required = '" . (int)$data['tax_id_required'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "'
		");
        
        $customer_group_id = DB::getLastId();
        
        foreach ($data['customer_group_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "customer_group_description 
				SET 
					customer_group_id = '" . (int)$customer_group_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "', 
					description = '" . DB::escape($value['description']) . "'
			");
        }
        
        Cache::delete('customer_group');
    }
    
    public function editCustomerGroup($customer_group_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "customer_group 
			SET 
				approval = '" . (int)$data['approval'] . "', 
				company_id_display = '" . (int)$data['company_id_display'] . "', 
				company_id_required = '" . (int)$data['company_id_required'] . "', 
				tax_id_display = '" . (int)$data['tax_id_display'] . "', 
				tax_id_required = '" . (int)$data['tax_id_required'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "' 
			WHERE customer_group_id = '" . (int)$customer_group_id . "'
		");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "customer_group_description 
            WHERE customer_group_id = '" . (int)$customer_group_id . "'");
        
        foreach ($data['customer_group_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "customer_group_description 
				SET 
					customer_group_id = '" . (int)$customer_group_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "', 
					description = '" . DB::escape($value['description']) . "'
			");
        }
        
        Cache::delete('customer_group');
    }
    
    public function deleteCustomerGroup($customer_group_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "customer_group 
            WHERE customer_group_id = '" . (int)$customer_group_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "customer_group_description 
            WHERE customer_group_id = '" . (int)$customer_group_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "product_discount 
            WHERE customer_group_id = '" . (int)$customer_group_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "product_special 
            WHERE customer_group_id = '" . (int)$customer_group_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "product_reward 
            WHERE customer_group_id = '" . (int)$customer_group_id . "'");
        
        Cache::delete('customer_group');
    }
    
    public function getCustomerGroup($customer_group_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "customer_group cg 
			LEFT JOIN " . DB::prefix() . "customer_group_description cgd 
				ON (cg.customer_group_id = cgd.customer_group_id) 
			WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' 
			AND cgd.language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getCustomerGroups($data = array()) {
        $sql = "
			SELECT * 
			FROM " . DB::prefix() . "customer_group cg 
			LEFT JOIN " . DB::prefix() . "customer_group_description cgd 
				ON (cg.customer_group_id = cgd.customer_group_id) 
			WHERE cgd.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        $sort_data = array('cgd.name', 'cg.sort_order');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY cg.sort_order";
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
    
    public function getCustomerGroupDescriptions($customer_group_id) {
        $customer_group_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "customer_group_description 
			WHERE customer_group_id = '" . (int)$customer_group_id . "'
		");
        
        foreach ($query->rows as $result) {
            $customer_group_data[$result['language_id']] = array('name' => $result['name'], 'description' => $result['description']);
        }
        
        return $customer_group_data;
    }
    
    public function getTotalCustomerGroups() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_group");
        
        return $query->row['total'];
    }
    
    public function getCustomerGroupName($customer_group_id) {
        $query = DB::query("
			SELECT name 
			FROM " . DB::prefix() . "customer_group_description 
			WHERE customer_group_id = '" . (int)$customer_group_id . "'");
        
        return $query->row['name'];
    }
}
