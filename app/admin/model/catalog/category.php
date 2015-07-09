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

namespace Admin\Model\Catalog;
use Dais\Engine\Model;

class Category extends Model {
    public function addCategory($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}category 
			SET 
                parent_id     = '" . (int)$data['parent_id'] . "', 
                top           = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', 
                columns       = '" . (int)$data['columns'] . "', 
                sort_order    = '" . (int)$data['sort_order'] . "', 
                status        = '" . (int)$data['status'] . "', 
                date_modified = NOW(), 
                date_added    = NOW()
		");
        
        $category_id = $this->db->getLastId();
        
        if (isset($data['image'])) {
            $this->db->query("
				UPDATE {$this->db->prefix}category 
				SET 
					image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE category_id = '" . (int)$category_id . "'
			");
        }
        
        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}category_description 
				SET 
                    category_id      = '" . (int)$category_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    name             = '" . $this->db->escape($value['name']) . "', 
                    meta_keyword     = '" . $this->db->escape($value['meta_keyword']) . "', 
                    meta_description = '" . $this->db->escape($value['meta_description']) . "', 
                    description      = '" . $this->db->escape($value['description']) . "'
			");

			// process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    $this->db->query("
                        INSERT INTO {$this->db->prefix}tag 
                        SET 
                            section     = 'product_category', 
                            element_id  = '" . (int)$category_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . $this->db->escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->add($language_id, 'category', $category_id, $value['name']);
            $this->search->add($language_id, 'category', $category_id, $value['description']);
        }
        
        // MySQL Hierarchical Data Closure Table Pattern
        $level = 0;
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category_path 
			WHERE category_id = '" . (int)$data['parent_id'] . "' 
			ORDER BY level ASC
		");
        
        foreach ($query->rows as $result) {
            $this->db->query("
				INSERT INTO `{$this->db->prefix}category_path` 
				SET 
                    category_id = '" . (int)$category_id . "', 
                    path_id     = '" . (int)$result['path_id'] . "', 
                    level       = '" . (int)$level . "'
			");
            
            $level++;
        }
        
        $this->db->query("
			INSERT INTO `{$this->db->prefix}category_path` 
			SET 
                category_id = '" . (int)$category_id . "', 
                path_id     = '" . (int)$category_id . "', 
                level       = '" . (int)$level . "'
		");
        
        if (isset($data['category_filter'])) {
            foreach ($data['category_filter'] as $filter_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}category_filter 
					SET 
						category_id = '" . (int)$category_id . "', 
						filter_id   = '" . (int)$filter_id . "'
				");
            }
        }
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}category_to_store 
					SET 
						category_id = '" . (int)$category_id . "', 
						store_id    = '" . (int)$store_id . "'
				");
            }
        }
        
        // Set which layout to use with this category
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("
						INSERT INTO {$this->db->prefix}category_to_layout 
						SET 
                            category_id = '" . (int)$category_id . "', 
                            store_id    = '" . (int)$store_id . "', 
                            layout_id   = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        if ($data['slug']) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}route 
				SET 
                    route ='catalog/category', 
                    query = 'category_id:" . (int)$category_id . "', 
                    slug  = '" . $this->db->escape($data['slug']) . "'
			");
        }
        
        $this->cache->delete('category');
        
        Theme::trigger('admin_add_category', array('category_id' => $category_id));
    }
    
    public function editCategory($category_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}category 
			SET 
                parent_id     = '" . (int)$data['parent_id'] . "', 
                top           = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', 
                columns       = '" . (int)$data['columns'] . "', 
                sort_order    = '" . (int)$data['sort_order'] . "', 
                status        = '" . (int)$data['status'] . "', 
                date_modified = NOW() 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        if (isset($data['image'])) {
            $this->db->query("
				UPDATE {$this->db->prefix}category 
				SET 
					image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE category_id = '" . (int)$category_id . "'
			");
        }
        
        $this->db->query("DELETE FROM {$this->db->prefix}category_description WHERE category_id = '" . (int)$category_id . "'");
        
        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}category_description 
				SET 
                    category_id      = '" . (int)$category_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    name             = '" . $this->db->escape($value['name']) . "', 
                    meta_keyword     = '" . $this->db->escape($value['meta_keyword']) . "', 
                    meta_description = '" . $this->db->escape($value['meta_description']) . "', 
                    description      = '" . $this->db->escape($value['description']) . "'
			");

			$this->db->query("
                DELETE FROM {$this->db->prefix}tag 
                WHERE section   = 'product_category' 
                AND element_id  = '" . (int)$category_id . "' 
                AND language_id = '" . (int)$language_id . "'
            ");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    $this->db->query("
                        INSERT INTO {$this->db->prefix}tag 
                        SET 
                            section     = 'product_category', 
                            element_id  = '" . (int)$category_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . $this->db->escape($tag) . "'
                    ");
                endforeach;
            endif;

            // delete
            $this->search->delete('category', $category_id);

            // insert
            $this->search->add($language_id, 'category', $category_id, $value['name']);
            $this->search->add($language_id, 'category', $category_id, $value['description']);
        }
        
        // MySQL Hierarchical Data Closure Table Pattern
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category_path 
			WHERE path_id = '" . (int)$category_id . "' 
			ORDER BY level ASC
		");
        
        if ($query->rows) {
            foreach ($query->rows as $category_path) {
                
                // Delete the path below the current one
                $this->db->query("
					DELETE FROM `{$this->db->prefix}category_path` 
					WHERE category_id = '" . (int)$category_path['category_id'] . "' 
					AND level < '" . (int)$category_path['level'] . "'
				");
                
                $path = array();
                
                // Get the nodes new parents
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}category_path 
					WHERE category_id = '" . (int)$data['parent_id'] . "' 
					ORDER BY level ASC
				");
                
                foreach ($query->rows as $result) {
                    $path[] = $result['path_id'];
                }
                
                // Get whats left of the nodes current path
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}category_path 
					WHERE category_id = '" . (int)$category_path['category_id'] . "' 
					ORDER BY level ASC
				");
                
                foreach ($query->rows as $result) {
                    $path[] = $result['path_id'];
                }
                
                // Combine the paths with a new level
                $level = 0;
                
                foreach ($path as $path_id) {
                    $this->db->query("
						REPLACE INTO `{$this->db->prefix}category_path` 
						SET 
                            category_id = '" . (int)$category_path['category_id'] . "', 
                            path_id     = '" . (int)$path_id . "', 
                            level       = '" . (int)$level . "'
					");
                    
                    $level++;
                }
            }
        } else {
            
            // Delete the path below the current one
            $this->db->query("
				DELETE 
				FROM {$this->db->prefix}category_path 
				WHERE category_id = '" . (int)$category_id . "'
			");
            
            // Fix for records with no paths
            $level = 0;
            
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}category_path 
				WHERE category_id = '" . (int)$data['parent_id'] . "' 
				ORDER BY level ASC
			");
            
            foreach ($query->rows as $result) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}category_path 
					SET 
                        category_id = '" . (int)$category_id . "', 
                        path_id     = '" . (int)$result['path_id'] . "', 
                        level       = '" . (int)$level . "'
				");
                
                $level++;
            }
            
            $this->db->query("
				REPLACE INTO {$this->db->prefix}category_path 
				SET 
                    category_id = '" . (int)$category_id . "', 
                    path_id     = '" . (int)$category_id . "', 
                    level       = '" . (int)$level . "'
			");
        }
        
        $this->db->query("
			DELETE 
			FROM {$this->db->prefix}category_filter 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        if (isset($data['category_filter'])) {
            foreach ($data['category_filter'] as $filter_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}category_filter 
					SET 
						category_id = '" . (int)$category_id . "', 
						filter_id   = '" . (int)$filter_id . "'
				");
            }
        }
        
        $this->db->query("
			DELETE 
			FROM {$this->db->prefix}category_to_store 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}category_to_store 
					SET 
						category_id = '" . (int)$category_id . "', 
						store_id    = '" . (int)$store_id . "'
				");
            }
        }
        
        $this->db->query("
			DELETE 
			FROM {$this->db->prefix}category_to_layout 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("
						INSERT INTO {$this->db->prefix}category_to_layout 
						SET 
                            category_id = '" . (int)$category_id . "', 
                            store_id    = '" . (int)$store_id . "', 
                            layout_id   = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        $this->db->query("
			DELETE 
			FROM {$this->db->prefix}route 
			WHERE query = 'category_id:" . (int)$category_id . "'
		");
        
        if ($data['slug']) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}route 
				SET 
                    route ='catalog/category', 
                    query = 'category_id:" . (int)$category_id . "', 
                    slug  = '" . $this->db->escape($data['slug']) . "'
			");
        }
        
        $this->cache->delete('category');
        
        Theme::trigger('admin_edit_category', array('category_id' => $category_id));
    }
    
    public function deleteCategory($category_id) {
        $this->db->query("
        	DELETE FROM {$this->db->prefix}category_path 
        	WHERE category_id = '" . (int)$category_id . "'
        ");
        
        $query = $this->db->query("
        	SELECT * FROM {$this->db->prefix}category_path 
        	WHERE path_id = '" . (int)$category_id . "'
        ");
        
        foreach ($query->rows as $result) {
            $this->deleteCategory($result['category_id']);
        }
        
        $this->db->query("
        	DELETE FROM {$this->db->prefix}category 
        	WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}category_description 
        	WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}category_filter 
        	WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}category_to_store 
        	WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}category_to_layout 
        	WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}product_to_category 
        	WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
        	DELETE FROM {$this->db->prefix}route 
        	WHERE query = 'category_id:" . (int)$category_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}tag 
            WHERE section  = 'product_category' 
            AND element_id = '" . (int)$category_id . "'");

        $this->search->delete('category', $category_id);
        
        $this->cache->delete('category');
        
        Theme::trigger('admin_delete_category', array('category_id' => $category_id));
    }
    
    // Function to repair any erroneous categories that are not in the category path table.
    public function repairCategories($parent_id = 0) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category 
			WHERE parent_id = '" . (int)$parent_id . "'
		");
        
        foreach ($query->rows as $category) {
            
            // Delete the path below the current one
            $this->db->query("
				DELETE 
				FROM {$this->db->prefix}category_path 
				WHERE category_id = '" . (int)$category['category_id'] . "'
			");
            
            // Fix for records with no paths
            $level = 0;
            
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}category_path 
				WHERE category_id = '" . (int)$parent_id . "' 
				ORDER BY level ASC
			");
            
            foreach ($query->rows as $result) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}category_path 
					SET 
                        category_id = '" . (int)$category['category_id'] . "', 
                        path_id     = '" . (int)$result['path_id'] . "', 
                        level       = '" . (int)$level . "'
				");
                
                $level++;
            }
            
            $this->db->query("
				REPLACE INTO {$this->db->prefix}category_path 
				SET 
                    category_id = '" . (int)$category['category_id'] . "', 
                    path_id     = '" . (int)$category['category_id'] . "', 
                    level       = '" . (int)$level . "'
			");
            
            $this->repairCategories($category['category_id']);
        }
    }
    
    public function getCategory($category_id) {
        $query = $this->db->query("
			SELECT DISTINCT *, 
			(SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') 
				FROM {$this->db->prefix}category_path cp 
				LEFT JOIN {$this->db->prefix}category_description cd1 
					ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) 
				WHERE cp.category_id = c.category_id 
				AND cd1.language_id = '" . (int)Config::get('config_language_id') . "' 
				GROUP BY cp.category_id) AS path, 
			(SELECT slug 
				FROM {$this->db->prefix}route 
				WHERE query = 'category_id:" . (int)$category_id . "') AS slug 
			FROM {$this->db->prefix}category c 
			LEFT JOIN {$this->db->prefix}category_description cd2 
				ON (c.category_id = cd2.category_id) 
			WHERE c.category_id = '" . (int)$category_id . "' 
			AND cd2.language_id = '" . (int)Config::get('config_language_id') . "'
		");

		if ($query->num_rows):
			$query->row['tag'] = $this->getProductCategoryTags($category_id);
        endif;

        return $query->row;
    }

    public function getProductCategoryTags($category_id) {
        $query = $this->db->query("
            SELECT tag 
            FROM {$this->db->prefix}tag 
            WHERE section   = 'product_category' 
            AND element_id  = '" . (int)$category_id . "' 
            AND language_id = '" . (int)Config::get('config_language_id') . "'
        ");
        
        if ($query->num_rows):
            $tags = array();
            foreach($query->rows as $row):
                $tags[] = $row['tag'];
            endforeach;
            return implode(', ', $tags);
        else:
            return false;
        endif;
    }
    
    public function getCategories($data = array()) {
        $sql = "
			SELECT cp.category_id AS category_id, 
			GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, 
			c.parent_id, 
			c.sort_order 
			FROM {$this->db->prefix}category_path cp 
			LEFT JOIN {$this->db->prefix}category c 
				ON (cp.path_id = c.category_id) 
			LEFT JOIN {$this->db->prefix}category_description cd1 
				ON (c.category_id = cd1.category_id) 
			LEFT JOIN {$this->db->prefix}category_description cd2 
				ON (cp.category_id = cd2.category_id) 
			WHERE cd1.language_id = '" . (int)Config::get('config_language_id') . "' 
			AND cd2.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        if (!empty($data['filter_name'])) {
            $sql.= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }
        
        $sql.= " GROUP BY cp.category_id ORDER BY name";
        
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
    
    public function getCategoryDescriptions($category_id) {
        $category_description_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category_description 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_description_data[$result['language_id']] = array(
				'name'             => $result['name'], 
				'meta_keyword'     => $result['meta_keyword'], 
				'meta_description' => $result['meta_description'], 
				'description'      => $result['description'],
				'tag'              => $this->getProductCategoryTags($category_id)
            );
        }
        
        return $category_description_data;
    }
    
    public function getCategoryFilters($category_id) {
        $category_filter_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category_filter 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_filter_data[] = $result['filter_id'];
        }
        
        return $category_filter_data;
    }
    
    public function getCategoryStores($category_id) {
        $category_store_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category_to_store 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_store_data[] = $result['store_id'];
        }
        
        return $category_store_data;
    }
    
    public function getCategoryLayouts($category_id) {
        $category_layout_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}category_to_layout 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_layout_data[$result['store_id']] = $result['layout_id'];
        }
        
        return $category_layout_data;
    }
    
    public function getTotalCategories() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}category");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByImageId($image_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}category 
			WHERE image_id = '" . (int)$image_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByLayoutId($layout_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}category_to_layout 
			WHERE layout_id = '" . (int)$layout_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getCategoriesByParentId($parent_id) {
        $query = $this->db->query("
			SELECT 
				c.category_id, 
				cd.name 
			FROM {$this->db->prefix}category c 
			LEFT JOIN {$this->db->prefix}category_description cd 
			ON (c.category_id = cd.category_id) 
			WHERE c.parent_id = '" . (int)$parent_id . "'");
        
        return $query->rows;
    }
}
