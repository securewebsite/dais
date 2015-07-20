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

namespace App\Models\Admin\Locale;

use App\Models\Model;

class Language extends Model {
    
    public function addLanguage($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "language 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				code = '" . DB::escape($data['code']) . "', 
				locale = '" . DB::escape($data['locale']) . "', 
				directory = '" . DB::escape($data['directory']) . "', 
				filename = '" . DB::escape($data['filename']) . "', 
				image = '" . DB::escape($data['image']) . "', 
				sort_order = '" . DB::escape($data['sort_order']) . "', 
				status = '" . (int)$data['status'] . "'
		");
        
        $language_id = DB::getLastId();
        
        // Attribute
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "attribute_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $attribute) {
            DB::query("
				INSERT INTO " . DB::prefix() . "attribute_description 
				SET 
					attribute_id = '" . (int)$attribute['attribute_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($attribute['name']) . "'
			");
        }
        
        // Attribute Group
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "attribute_group_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $attribute_group) {
            DB::query("
				INSERT INTO " . DB::prefix() . "attribute_group_description 
				SET 
					attribute_group_id = '" . (int)$attribute_group['attribute_group_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($attribute_group['name']) . "'
			");
        }
        
        // Banner
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "banner_image_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $banner_image) {
            DB::query("
				INSERT INTO " . DB::prefix() . "banner_image_description 
				SET 
					banner_image_id = '" . (int)$banner_image['banner_image_id'] . "', 
					banner_id = '" . (int)$banner_image['banner_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . DB::escape($banner_image['title']) . "'
			");
        }
        
        // Category
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "category_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $category) {
            DB::query("
				INSERT INTO " . DB::prefix() . "category_description 
				SET 
					category_id = '" . (int)$category['category_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($category['name']) . "', 
					meta_description = '" . DB::escape($category['meta_description']) . "', 
					meta_keyword = '" . DB::escape($category['meta_keyword']) . "', 
					description = '" . DB::escape($category['description']) . "'
			");
        }
        
        // Customer Group
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "customer_group_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $customer_group) {
            DB::query("
				INSERT INTO " . DB::prefix() . "customer_group_description 
				SET 
					customer_group_id = '" . (int)$customer_group['customer_group_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($customer_group['name']) . "', 
					description = '" . DB::escape($customer_group['description']) . "'
			");
        }
        
        // Download
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "download_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $download) {
            DB::query("
				INSERT INTO " . DB::prefix() . "download_description 
				SET 
					download_id = '" . (int)$download['download_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($download['name']) . "'
			");
        }
        
        // Filter
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "filter_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $filter) {
            DB::query("
				INSERT INTO " . DB::prefix() . "filter_description 
				SET 
					filter_id = '" . (int)$filter['filter_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					filter_group_id = '" . (int)$filter['filter_group_id'] . "', 
					name = '" . DB::escape($filter['name']) . "'
			");
        }
        
        // Filter Group
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "filter_group_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $filter_group) {
            DB::query("
				INSERT INTO " . DB::prefix() . "filter_group_description 
				SET 
					filter_group_id = '" . (int)$filter_group['filter_group_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($filter_group['name']) . "'
			");
        }
        
        // Page
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "page_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $page) {
            DB::query("
				INSERT INTO " . DB::prefix() . "page_description 
				SET 
					page_id = '" . (int)$page['page_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . DB::escape($page['title']) . "', 
					description = '" . DB::escape($page['description']) . "'
			");
        }
        
        // Length
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "length_class_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $length) {
            DB::query("
				INSERT INTO " . DB::prefix() . "length_class_description 
				SET 
					length_class_id = '" . (int)$length['length_class_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . DB::escape($length['title']) . "', 
					unit = '" . DB::escape($length['unit']) . "'
			");
        }
        
        // Option
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "option_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $option) {
            DB::query("
				INSERT INTO " . DB::prefix() . "option_description 
				SET 
					option_id = '" . (int)$option['option_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($option['name']) . "'
			");
        }
        
        // Option Value
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "option_value_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $option_value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "option_value_description 
				SET 
					option_value_id = '" . (int)$option_value['option_value_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					option_id = '" . (int)$option_value['option_id'] . "', 
					name = '" . DB::escape($option_value['name']) . "'
			");
        }
        
        // Order Status
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "order_status 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $order_status) {
            DB::query("
				INSERT INTO " . DB::prefix() . "order_status 
				SET 
					order_status_id = '" . (int)$order_status['order_status_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($order_status['name']) . "'
			");
        }
        
        // Product
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "product_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $product) {
            DB::query("
				INSERT INTO " . DB::prefix() . "product_description 
				SET 
					product_id = '" . (int)$product['product_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($product['name']) . "', 
					meta_description = '" . DB::escape($product['meta_description']) . "', 
					meta_keyword = '" . DB::escape($product['meta_keyword']) . "', 
					description = '" . DB::escape($product['description']) . "', 
					tag = '" . DB::escape($product['tag']) . "'
			");
        }
        
        // Product Attribute
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "product_attribute 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $product_attribute) {
            DB::query("
				INSERT INTO " . DB::prefix() . "product_attribute 
				SET 
					product_id = '" . (int)$product_attribute['product_id'] . "', 
					attribute_id = '" . (int)$product_attribute['attribute_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					text = '" . DB::escape($product_attribute['text']) . "'
			");
        }
        
        // Return Action
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_action 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $return_action) {
            DB::query("
				INSERT INTO " . DB::prefix() . "return_action 
				SET 
					return_action_id = '" . (int)$return_action['return_action_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($return_action['name']) . "'
			");
        }
        
        // Return Reason
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_reason 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $return_reason) {
            DB::query("
				INSERT INTO " . DB::prefix() . "return_reason 
				SET 
					return_reason_id = '" . (int)$return_reason['return_reason_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($return_reason['name']) . "'
			");
        }
        
        // Return Status
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "return_status 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $return_status) {
            DB::query("
				INSERT INTO " . DB::prefix() . "return_status 
				SET 
					return_status_id = '" . (int)$return_status['return_status_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($return_status['name']) . "'
			");
        }
        
        // Stock Status
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "stock_status 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $stock_status) {
            DB::query("
				INSERT INTO " . DB::prefix() . "stock_status 
				SET 
					stock_status_id = '" . (int)$stock_status['stock_status_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($stock_status['name']) . "'
			");
        }
        
        // Giftcard Theme
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "gift_card_theme_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $gift_card_theme) {
            DB::query("
				INSERT INTO " . DB::prefix() . "gift_card_theme_description 
				SET 
					gift_card_theme_id = '" . (int)$gift_card_theme['gift_card_theme_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($gift_card_theme['name']) . "'
			");
        }
        
        // Weight Class
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "weight_class_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $weight_class) {
            DB::query("
				INSERT INTO " . DB::prefix() . "weight_class_description 
				SET 
					weight_class_id = '" . (int)$weight_class['weight_class_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . DB::escape($weight_class['title']) . "', 
					unit = '" . DB::escape($weight_class['unit']) . "'
			");
        }
        
        // Recurring
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "recurring_description 
			WHERE language_id = '" . (int)Config::get('config_language_id') . "'");
        
        foreach ($query->rows as $recurring) {
            DB::query("
				INSERT INTO " . DB::prefix() . "recurring_description 
				SET 
					recurring_id = '" . (int)$recurring['recurring_id'] . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($recurring['name']));
        }
        
        Cache::flush_cache();
    }
    
    public function editLanguage($language_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "language 
			SET 
				name = '" . DB::escape($data['name']) . "', 
				code = '" . DB::escape($data['code']) . "', 
				locale = '" . DB::escape($data['locale']) . "', 
				directory = '" . DB::escape($data['directory']) . "', 
				filename = '" . DB::escape($data['filename']) . "', 
				image = '" . DB::escape($data['image']) . "', 
				sort_order = '" . DB::escape($data['sort_order']) . "', 
				status = '" . (int)$data['status'] . "' 
			WHERE language_id = '" . (int)$language_id . "'
		");
        
        Cache::delete('language');
        Cache::delete('languages');
    }
    
    public function deleteLanguage($language_id) {
        DB::query("DELETE FROM " . DB::prefix() . "language WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "attribute_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "attribute_group_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "banner_image_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "category_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "customer_group_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "download_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "filter_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "filter_group_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "page_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "length_class_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "option_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "option_value_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "order_status WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "product_attribute WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "product_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "return_action WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "return_reason WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "return_status WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "stock_status WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "gift_card_theme_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "weight_class_description WHERE language_id = '" . (int)$language_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "recurring_description WHERE language_id = '" . (int)$language_id . "'");
        
        Cache::flush_cache();
    }
    
    public function getLanguage($language_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "language 
			WHERE language_id = '" . (int)$language_id . "'
		");
        
        return $query->row;
    }
    
    public function getLanguages($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "language";
            
            $sort_data = array('name', 'code', 'sort_order');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql.= " ORDER BY {$data['sort']}";
            } else {
                $sql.= " ORDER BY sort_order, name";
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
        } else {
            
            $language_data = array();
            
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "language 
				ORDER BY sort_order, name
			");
            
            foreach ($query->rows as $result) {
                $language_data[$result['code']] = array('language_id' => $result['language_id'], 'name' => $result['name'], 'code' => $result['code'], 'locale' => $result['locale'], 'image' => $result['image'], 'directory' => $result['directory'], 'filename' => $result['filename'], 'sort_order' => $result['sort_order'], 'status' => $result['status']);
            }
            
            return $language_data;
        }
    }
    
    public function getTotalLanguages() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "language");
        
        return $query->row['total'];
    }
}
