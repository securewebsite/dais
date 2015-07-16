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

namespace App\Models\Admin\Setting;

use App\Models\Model;

class Store extends Model {
    
    public function addStore($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "store 
			SET 
				name = '" . DB::escape($data['config_name']) . "', 
				`url` = '" . DB::escape($data['config_url']) . "', 
				`ssl` = '" . DB::escape($data['config_ssl']) . "'
		");
        
        $store_id = DB::getLastId();
        
        Cache::delete('stores');
        
        Theme::trigger('admin_add_store', array('store_id' => $store_id));
        
        return $store_id;
    }
    
    public function editStore($store_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "store 
			SET 
				name = '" . DB::escape($data['config_name']) . "', 
				`url` = '" . DB::escape($data['config_url']) . "', 
				`ssl` = '" . DB::escape($data['config_ssl']) . "' 
			WHERE store_id = '" . (int)$store_id . "'
		");
        
        Cache::delete('stores');
        
        Theme::trigger('admin_edit_store', array('store_id' => $store_id));
    }
    
    public function deleteStore($store_id) {
        DB::query("DELETE FROM " . DB::prefix() . "store WHERE store_id = '" . (int)$store_id . "'");
        
        Cache::delete('stores');
        
        Theme::trigger('admin_delete_store', array('store_id' => $store_id));
    }
    
    public function getStore($store_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "store 
			WHERE store_id = '" . (int)$store_id . "'
		");
        
        return $query->row;
    }
    
    public function getStores($data = array()) {
        $store_data = Cache::get('store');
        
        if (!$store_data) {
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "store 
				ORDER BY url");
            
            $store_data = $query->rows;
            
            Cache::set('store', $store_data);
        }
        
        return $store_data;
    }
    
    public function getTotalStores() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "store");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByLayoutId($layout_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_layout_id' 
			AND data = '" . (int)$layout_id . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByLanguage($language) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_language' 
			AND data = '" . DB::escape($language) . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByCurrency($currency) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_currency' 
			AND data = '" . DB::escape($currency) . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByCountryId($country_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_country_id' 
			AND data = '" . (int)$country_id . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByZoneId($zone_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_zone_id' 
			AND data = '" . (int)$zone_id . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByCustomerGroupId($customer_group_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_customer_group_id' 
			AND data = '" . (int)$customer_group_id . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalStoresByPageId($page_id) {
        $account_query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_account_id' 
			AND data = '" . (int)$page_id . "' 
			AND store_id != '0'
		");
        
        $checkout_query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_checkout_id' 
			AND data = '" . (int)$page_id . "' 
			AND store_id != '0'
		");
        
        return ($account_query->row['total'] + $checkout_query->row['total']);
    }
    
    public function getTotalStoresByOrderStatusId($order_status_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "setting 
			WHERE item = 'config_order_status_id' 
			AND data = '" . (int)$order_status_id . "' 
			AND store_id != '0'
		");
        
        return $query->row['total'];
    }
}
