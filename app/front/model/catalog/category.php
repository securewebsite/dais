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

namespace Front\Model\Catalog;
use Dais\Engine\Model;

class Category extends Model {
    public function getCategory($category_id) {
        $key = 'category.category.' . $category_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT DISTINCT * 
				FROM {$this->db->prefix}category c 
				LEFT JOIN {$this->db->prefix}category_description cd 
					ON (c.category_id = cd.category_id) 
				LEFT JOIN {$this->db->prefix}category_to_store c2s 
					ON (c.category_id = c2s.category_id) 
				WHERE c.category_id = '" . (int)$category_id . "' 
				AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
				AND c.status = '1'
			");
            
            if ($query->num_rows):
                $query->row['tag'] = $this->getProductCategoryTags($category_id);
                $cachefile = $query->row;
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }

    public function getProductCategoryTags($category_id) {
        $query = $this->db->query("
            SELECT tag 
            FROM {$this->db->prefix}tag 
            WHERE section   = 'product_category' 
            AND element_id  = '" . (int)$category_id . "' 
            AND language_id = '" . (int)$this->config->get('config_language_id') . "'
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
        $key = 'category.categories.' . $parent_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}category c 
				LEFT JOIN {$this->db->prefix}category_description cd 
					ON (c.category_id = cd.category_id) 
				LEFT JOIN {$this->db->prefix}category_to_store c2s 
					ON (c.category_id = c2s.category_id) 
				WHERE c.parent_id = '" . (int)$parent_id . "' 
				AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  
				AND c.status = '1' 
				ORDER BY c.sort_order, LCASE(cd.name)
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCategoryFilters($category_id) {
        $implode = array();
        
        $query = $this->db->query("
			SELECT filter_id 
			FROM {$this->db->prefix}category_filter 
			WHERE category_id = '" . (int)$category_id . "'
		");
        
        foreach ($query->rows as $result):
            $implode[] = (int)$result['filter_id'];
        endforeach;
        
        $filter_group_data = array();
        
        if ($implode):
            $filter_group_query = $this->db->query("
				SELECT DISTINCT 
					f.filter_group_id, 
					fgd.name, 
					fg.sort_order 
				FROM {$this->db->prefix}filter f 
				LEFT JOIN {$this->db->prefix}filter_group fg 
					ON (f.filter_group_id = fg.filter_group_id) 
				LEFT JOIN {$this->db->prefix}filter_group_description fgd 
					ON (fg.filter_group_id = fgd.filter_group_id) 
				WHERE f.filter_id IN (" . implode(',', $implode) . ") 
				AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				GROUP BY f.filter_group_id 
				ORDER BY fg.sort_order, LCASE(fgd.name)
			");
            
            foreach ($filter_group_query->rows as $filter_group):
                $filter_data = array();
                
                $filter_query = $this->db->query("
					SELECT DISTINCT 
						f.filter_id, 
						fd.name 
					FROM {$this->db->prefix}filter f 
					LEFT JOIN {$this->db->prefix}filter_description fd 
						ON (f.filter_id = fd.filter_id) 
					WHERE f.filter_id IN (" . implode(',', $implode) . ") 
					AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' 
					AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
					ORDER BY f.sort_order, LCASE(fd.name)
				");
                
                foreach ($filter_query->rows as $filter):
                    $filter_data[] = array('filter_id' => $filter['filter_id'], 'name' => $filter['name']);
                endforeach;
                
                if ($filter_data):
                    $filter_group_data[] = array('filter_group_id' => $filter_group['filter_group_id'], 'name' => $filter_group['name'], 'filter' => $filter_data);
                endif;
            endforeach;
        endif;
        
        return $filter_group_data;
    }
    
    public function getCategoryLayoutId($category_id) {
        $key = 'category.category.layout.' . $category_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}category_to_layout 
				WHERE category_id = '" . (int)$category_id . "' 
				AND store_id = '" . (int)$this->config->get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['layout_id'];
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, 0);
                return false;
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getTotalCategoriesByCategoryId($parent_id = 0) {
        $key = 'category.categories.total.' . $parent_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT COUNT(*) AS total 
				FROM {$this->db->prefix}category c 
				LEFT JOIN {$this->db->prefix}category_to_store c2s 
				ON (c.category_id = c2s.category_id) 
				WHERE c.parent_id = '" . (int)$parent_id . "' 
				AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
				AND c.status = '1'
			");
            
            $cachefile = $query->row['total'];
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
}
