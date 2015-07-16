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

namespace App\Models\Admin\Content;

use App\Models\Model;

class Category extends Model {
    
    public function addCategory($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "blog_category 
			SET 
				parent_id = '" . (int)$data['parent_id'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_modified = NOW(), 
				date_added = NOW()
		");
        
        $category_id = DB::getLastId();
        
        if (isset($data['image'])) {
            DB::query("
				UPDATE " . DB::prefix() . "blog_category 
				SET 
					image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE category_id = '" . (int)$category_id . "'
			");
        }
        
        foreach ($data['category_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "blog_category_description 
				SET 
                    category_id      = '" . (int)$category_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    name             = '" . DB::escape($value['name']) . "', 
                    meta_keyword     = '" . DB::escape($value['meta_keyword']) . "', 
                    meta_description = '" . DB::escape($value['meta_description']) . "', 
                    description      = '" . DB::escape($value['description']) . "'
			");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    DB::query("
                        INSERT INTO " . DB::prefix() . "tag 
                        SET 
                            section     = 'blog_category', 
                            element_id  = '" . (int)$category_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . DB::escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->add($language_id, 'blog_category', $category_id, $value['name']);
            $this->search->add($language_id, 'blog_category', $category_id, $value['description']);
        }
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_category_to_store 
					SET 
						category_id = '" . (int)$category_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    DB::query("
						INSERT INTO " . DB::prefix() . "blog_category_to_layout 
						SET 
							category_id = '" . (int)$category_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
					route='content/category', 
					query = 'blog_category_id:" . (int)$category_id . "', 
					slug = '" . DB::escape($data['slug']) . "'
			");
        }
        
        Cache::delete('post.category');
        Cache::delete('post.categories');
        
        Theme::trigger('admin_blog_add_category', array('blog_category_id' => $category_id));
    }
    
    public function editCategory($category_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "blog_category 
			SET 
				parent_id = '" . (int)$data['parent_id'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_modified = NOW() 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        if (isset($data['image'])) {
            DB::query("
				UPDATE " . DB::prefix() . "blog_category 
				SET image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE category_id = '" . (int)$category_id . "'
			");
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category_description 
            WHERE category_id = '" . (int)$category_id . "'");
        
        foreach ($data['category_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "blog_category_description 
				SET 
                    category_id      = '" . (int)$category_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    name             = '" . DB::escape($value['name']) . "', 
                    meta_keyword     = '" . DB::escape($value['meta_keyword']) . "', 
                    meta_description = '" . DB::escape($value['meta_description']) . "', 
                    description      = '" . DB::escape($value['description']) . "'
			");

            DB::query("
                DELETE FROM " . DB::prefix() . "tag 
                WHERE section   = 'blog_category' 
                AND element_id  = '" . (int)$category_id . "' 
                AND language_id = '" . (int)$language_id . "'
            ");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    DB::query("
                        INSERT INTO " . DB::prefix() . "tag 
                        SET 
                            section     = 'blog_category', 
                            element_id  = '" . (int)$category_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . DB::escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->delete('blog_category', $category_id);

            $this->search->add($language_id, 'blog_category', $category_id, $value['name']);
            $this->search->add($language_id, 'blog_category', $category_id, $value['description']);
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category_to_store 
            WHERE category_id = '" . (int)$category_id . "'");
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_category_to_store 
					SET 
						category_id = '" . (int)$category_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category_to_layout 
            WHERE category_id = '" . (int)$category_id . "'");
        
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    DB::query("
						INSERT INTO " . DB::prefix() . "blog_category_to_layout 
						SET 
							category_id = '" . (int)$category_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'blog_category_id:" . (int)$category_id . "'");
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
					route = 'content/category', 
					query = 'blog_category_id:" . (int)$category_id . "', 
					slug = '" . DB::escape($data['slug']) . "'
			");
        }
        
        Cache::delete('post.category');
        Cache::delete('post.categories');
        
        Theme::trigger('admin_blog_edit_category', array('blog_category_id' => $category_id));
    }
    
    public function deleteCategory($category_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category 
            WHERE category_id = '" . (int)$category_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category_description 
            WHERE category_id = '" . (int)$category_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category_to_store 
            WHERE category_id = '" . (int)$category_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_category_to_layout 
            WHERE category_id = '" . (int)$category_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_category 
            WHERE category_id = '" . (int)$category_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'blog_category_id:" . (int)$category_id . "'");
        
        $query = DB::query("
			SELECT category_id 
			FROM " . DB::prefix() . "blog_category 
			WHERE parent_id = '" . (int)$category_id . "'
		");

        DB::query("
            DELETE FROM " . DB::prefix() . "tag 
            WHERE section  = 'blog_category' 
            AND element_id = '" . (int)$category_id . "'");
        
        foreach ($query->rows as $result) {
            $this->deleteCategory($result['category_id']);
        }
        
        $this->search->delete('blog_category', $category_id);
        
        Cache::delete('post.category');
        Cache::delete('post.categories');
        
        Theme::trigger('admin_blog_delete_category', array('blog_category_id' => $category_id));
    }
    
    public function getCategory($category_id) {
        $query = DB::query("
			SELECT DISTINCT *, 
			(SELECT slug FROM " . DB::prefix() . "route WHERE query = 'blog_category_id:" . (int)$category_id . "') AS slug 
			FROM " . DB::prefix() . "blog_category 
			WHERE category_id = '" . (int)$category_id . "'
		");

        if ($query->num_rows):
            $query->row['tag'] = $this->getBlogCategoryTags($category_id);
        endif;

        return $query->row;
    }

    public function getBlogCategoryTags($category_id) {
        $query = DB::query("
            SELECT tag 
            FROM " . DB::prefix() . "tag 
            WHERE section   = 'blog_category' 
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
    
    public function getCategories($parent_id = 0) {
        $category_data = Cache::get('blog_category.' . (int)Config::get('config_language_id') . '.' . (int)$parent_id);
        
        if (!$category_data) {
            $category_data = array();
            
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "blog_category c 
				LEFT JOIN " . DB::prefix() . "blog_category_description cd 
					ON (c.category_id = cd.category_id) 
				WHERE c.parent_id = '" . (int)$parent_id . "' 
				AND cd.language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY c.sort_order, cd.name ASC
			");
            
            foreach ($query->rows as $result) {
                $category_data[] = array(
                    'category_id' => $result['category_id'], 
                    'name'        => $this->getPath($result['category_id'], Config::get('config_language_id')), 
                    'status'      => $result['status'], 
                    'sort_order'  => $result['sort_order']
                );
                
                $category_data = array_merge($category_data, $this->getCategories($result['category_id']));
            }
            
            Cache::set('blog_category.' . (int)Config::get('config_language_id') . '.' . (int)$parent_id, $category_data);
        }
        
        return $category_data;
    }
    
    public function getPath($category_id) {
        $query = DB::query("
			SELECT name, parent_id 
			FROM " . DB::prefix() . "blog_category c 
			LEFT JOIN " . DB::prefix() . "blog_category_description cd 
				ON (c.category_id = cd.category_id) 
			WHERE c.category_id = '" . (int)$category_id . "' 
			AND cd.language_id = '" . (int)Config::get('config_language_id') . "' 
			ORDER BY c.sort_order, cd.name ASC
		");
        
        if ($query->row['parent_id']) {
            return $this->getPath($query->row['parent_id'], Config::get('config_language_id')) . Lang::get('lang_text_separator') . $query->row['name'];
        } else {
            return $query->row['name'];
        }
    }
    
    public function getCategoryDescriptions($category_id) {
        $category_description_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_category_description 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_description_data[$result['language_id']] = array(
                'name'             => $result['name'], 
                'meta_keyword'     => $result['meta_keyword'], 
                'meta_description' => $result['meta_description'], 
                'description'      => $result['description'],
                'tag'              => $this->getBlogCategoryTags($category_id)
            );
        }
        
        return $category_description_data;
    }
    
    public function getCategoryStores($category_id) {
        $category_store_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_category_to_store 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_store_data[] = $result['store_id'];
        }
        
        return $category_store_data;
    }
    
    public function getCategoryLayouts($category_id) {
        $category_layout_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_category_to_layout 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result) {
            $category_layout_data[$result['store_id']] = $result['layout_id'];
        }
        
        return $category_layout_data;
    }
    
    public function getTotalCategories() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_category
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByImageId($image_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_category 
			WHERE image_id = '" . (int)$image_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByLayoutId($layout_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_category_to_layout 
			WHERE layout_id = '" . (int)$layout_id . "'
		");
        
        return $query->row['total'];
    }
}
