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

namespace App\Models\Front\Content;
use App\Models\Model;

class Category extends Model {
    public function getCategory($category_id) {
        $key = 'post.category.' . $category_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT DISTINCT * 
				FROM " . DB::prefix() . "blog_category c 
				LEFT JOIN " . DB::prefix() . "blog_category_description cd 
					ON (c.category_id = cd.category_id) 
				LEFT JOIN " . DB::prefix() . "blog_category_to_store c2s 
					ON (c.category_id = c2s.category_id) 
				WHERE c.category_id = '" . (int)$category_id . "' 
				AND cd.language_id = '" . (int)Config::get('config_language_id') . "' 
				AND c2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND c.status = '1'
			");
            
            if ($query->num_rows):
                $query->row['tag'] = $this->getBlogCategoryTags($category_id);
                $cachefile = $query->row;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
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
        $key = 'post.categories.' . $parent_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "blog_category c 
				LEFT JOIN " . DB::prefix() . "blog_category_description cd 
					ON (c.category_id = cd.category_id) 
				LEFT JOIN " . DB::prefix() . "blog_category_to_store c2s 
					ON (c.category_id = c2s.category_id) 
				WHERE c.parent_id = '" . (int)$parent_id . "' 
				AND cd.language_id = '" . (int)Config::get('config_language_id') . "' 
				AND c2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND c.status = '1' 
				ORDER BY c.sort_order, LCASE(cd.name)
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCategoriesByParentId($category_id) {
        $category_data = array();
        
        $category_query = DB::query("
			SELECT category_id 
			FROM " . DB::prefix() . "blog_category 
			WHERE parent_id = '" . (int)$category_id . "'
		");
        
        foreach ($category_query->rows as $category):
            $category_data[] = $category['category_id'];
            
            $children = $this->getCategoriesByParentId($category['category_id']);
            
            if ($children):
                $category_data = array_merge($children, $category_data);
            endif;
        endforeach;
        
        return $category_data;
    }
    
    public function getCategoryLayoutId($category_id) {
        $key = 'post.category.layout.' . $category_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "blog_category_to_layout 
				WHERE category_id = '" . (int)$category_id . "' 
				AND store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['layout_id'];
                Cache::set($key, $cachefile);
            else:
                $cachefile = Config::get('config_layout_category');
                Cache::set($key, $cachefile);
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCategoriesByPostId($post_id) {
        $key = 'post.categories.by.postid.' . $post_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $category_data = array();
            
            $query = DB::query("
				SELECT category_id 
				FROM " . DB::prefix() . "blog_post_to_category 
				WHERE post_id = '" . (int)$post_id . "'
			");
            
            if ($query->num_rows):
                foreach ($query->rows as $category):
                    $category_info = $this->getCategory($category['category_id']);
                    
                    if ($category_info):
                        if (Config::get('config_top_level')):
                            $path = $category_info['category_id'];
                        else:
                            $path = $this->buildCategoryPath($category_info['category_id']);
                        endif;
                        
                        $category_data[] = array(
                            'category_id' => $category_info['category_id'], 
                            'name'        => $category_info['name'], 
                            'href'        => Url::link('content/category', 'bpath=' . $path, 'SSL')
                        );
                    endif;
                endforeach;
                
                $cachefile = $category_data;
                Cache::set($key, $cachefile);
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getTotalCategoriesByCategoryId($parent_id = 0) {
        $key = 'post.categories.by.categoryid.' . $post_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT COUNT(*) AS total 
				FROM " . DB::prefix() . "blog_category c 
				LEFT JOIN " . DB::prefix() . "blog_category_to_store c2s 
					ON (c.category_id = c2s.category_id) 
				WHERE c.parent_id = '" . (int)$parent_id . "' 
				AND c2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND c.status = '1'
			");
            
            $cachefile = $query->row['total'];
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function buildCategoryPath($category_id, $path = '', $run = true) {
        $query = DB::query("
			SELECT parent_id 
			FROM " . DB::prefix() . "blog_category 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        $parent_id = $query->row['parent_id'];
        
        if ($run):
            $path.= $category_id;
        endif;
        
        if ($parent_id == 0):
            return $path;
        else:
            $path = $parent_id . '_' . $path;
            return $this->buildCategoryPath($parent_id, $path, false);
        endif;
    }
}
