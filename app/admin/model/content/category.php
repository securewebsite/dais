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

namespace Admin\Model\Content;
use Dais\Engine\Model;

class Category extends Model {
    public function addCategory($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}blog_category 
			SET 
				parent_id = '" . (int)$data['parent_id'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_modified = NOW(), 
				date_added = NOW()
		");
        
        $category_id = $this->db->getLastId();
        
        if (isset($data['image'])) {
            $this->db->query("
				UPDATE {$this->db->prefix}blog_category 
				SET 
					image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE category_id = '" . (int)$category_id . "'
			");
        }
        
        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}blog_category_description 
				SET 
					category_id = '" . (int)$category_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . $this->db->escape($value['name']) . "', 
					meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', 
					meta_description = '" . $this->db->escape($value['meta_description']) . "', 
					description = '" . $this->db->escape($value['description']) . "'
			");
        }
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}blog_category_to_store 
					SET 
						category_id = '" . (int)$category_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("
						INSERT INTO {$this->db->prefix}blog_category_to_layout 
						SET 
							category_id = '" . (int)$category_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        if ($data['slug']) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}route 
				SET 
					route='content/category', 
					query = 'blog_category_id:" . (int)$category_id . "', 
					slug = '" . $this->db->escape($data['slug']) . "'
			");
        }
        
        $this->cache->delete('post.category');
        $this->cache->delete('post.categories');
        
        $this->theme->trigger('admin_blog_add_category', array('blog_category_id' => $category_id));
    }
    
    public function editCategory($category_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}blog_category 
			SET 
				parent_id = '" . (int)$data['parent_id'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_modified = NOW() 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        if (isset($data['image'])) {
            $this->db->query("
				UPDATE {$this->db->prefix}blog_category 
				SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE category_id = '" . (int)$category_id . "'
			");
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category_description 
            WHERE category_id = '" . (int)$category_id . "'");
        
        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}blog_category_description 
				SET 
					category_id = '" . (int)$category_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . $this->db->escape($value['name']) . "', 
					meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', 
					meta_description = '" . $this->db->escape($value['meta_description']) . "', 
					description = '" . $this->db->escape($value['description']) . "'
			");
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category_to_store 
            WHERE category_id = '" . (int)$category_id . "'");
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}blog_category_to_store 
					SET 
						category_id = '" . (int)$category_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category_to_layout 
            WHERE category_id = '" . (int)$category_id . "'");
        
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("
						INSERT INTO {$this->db->prefix}blog_category_to_layout 
						SET 
							category_id = '" . (int)$category_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}route 
            WHERE query = 'blog_category_id:" . (int)$category_id . "'");
        
        if ($data['slug']) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}route 
				SET 
					route = 'content/category', 
					query = 'blog_category_id:" . (int)$category_id . "', 
					slug = '" . $this->db->escape($data['slug']) . "'
			");
        }
        
        $this->cache->delete('post.category');
        $this->cache->delete('post.categories');
        
        $this->theme->trigger('admin_blog_edit_category', array('blog_category_id' => $category_id));
    }
    
    public function deleteCategory($category_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category 
            WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category_description 
            WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category_to_store 
            WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_category_to_layout 
            WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_post_to_category 
            WHERE category_id = '" . (int)$category_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}route 
            WHERE query = 'blog_category_id:" . (int)$category_id . "'");
        
        $query = $this->db->query("
			SELECT category_id 
			FROM {$this->db->prefix}blog_category 
			WHERE parent_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $this->deleteCategory($result['category_id']);
        }
        
        $this->cache->delete('post.category');
        $this->cache->delete('post.categories');
        
        $this->theme->trigger('admin_blog_delete_category', array('blog_category_id' => $category_id));
    }
    
    public function getCategory($category_id) {
        $query = $this->db->query("
			SELECT DISTINCT *, 
			(SELECT slug FROM {$this->db->prefix}route WHERE query = 'blog_category_id:" . (int)$category_id . "') AS slug 
			FROM {$this->db->prefix}blog_category 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        return $query->row;
    }
    
    public function getCategories($parent_id = 0) {
        $category_data = $this->cache->get('blog_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id);
        
        if (!$category_data) {
            $category_data = array();
            
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}blog_category c 
				LEFT JOIN {$this->db->prefix}blog_category_description cd 
					ON (c.category_id = cd.category_id) 
				WHERE c.parent_id = '" . (int)$parent_id . "' 
				AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				ORDER BY c.sort_order, cd.name ASC
			");
            
            foreach ($query->rows as $result) {
                $category_data[] = array(
                    'category_id' => $result['category_id'], 
                    'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')), 
                    'status'      => $result['status'], 
                    'sort_order'  => $result['sort_order']
                );
                
                $category_data = array_merge($category_data, $this->getCategories($result['category_id']));
            }
            
            $this->cache->set('blog_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id, $category_data);
        }
        
        return $category_data;
    }
    
    public function getPath($category_id) {
        $query = $this->db->query("
			SELECT name, parent_id 
			FROM {$this->db->prefix}blog_category c 
			LEFT JOIN {$this->db->prefix}blog_category_description cd 
				ON (c.category_id = cd.category_id) 
			WHERE c.category_id = '" . (int)$category_id . "' 
			AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			ORDER BY c.sort_order, cd.name ASC
		");
        
        if ($query->row['parent_id']) {
            return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) . $this->language->get('lang_text_separator') . $query->row['name'];
        } else {
            return $query->row['name'];
        }
    }
    
    public function getCategoryDescriptions($category_id) {
        $category_description_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}blog_category_description 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_description_data[$result['language_id']] = array(
                'name'             => $result['name'], 
                'meta_keyword'     => $result['meta_keyword'], 
                'meta_description' => $result['meta_description'], 
                'description'      => $result['description']
            );
        }
        
        return $category_description_data;
    }
    
    public function getCategoryStores($category_id) {
        $category_store_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}blog_category_to_store 
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
			FROM {$this->db->prefix}blog_category_to_layout 
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
			FROM {$this->db->prefix}blog_category
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByImageId($image_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}blog_category 
			WHERE image_id = '" . (int)$image_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByLayoutId($layout_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}blog_category_to_layout 
			WHERE layout_id = '" . (int)$layout_id . "'
		");
        
        return $query->row['total'];
    }
}
