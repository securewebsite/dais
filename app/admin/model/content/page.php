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

class Page extends Model {
    public function addPage($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}page 
			SET 
				sort_order = '" . (int)$data['sort_order'] . "', 
				bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', 
				visibility = '" . (int)$data['visibility'] . "', 
				status = '" . (int)$data['status'] . "'
		");
        
        $page_id = $this->db->getLastId();
        
        foreach ($data['page_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}page_description 
				SET 
					page_id = '" . (int)$page_id . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . $this->db->escape($value['title']) . "', 
					description = '" . $this->db->escape($value['description']) . "', 
					meta_description = '" . $this->db->escape($value['meta_description']) . "', 
					meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'
			");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    $this->db->query("
                        INSERT INTO {$this->db->prefix}tag 
                        SET 
                            section     = 'page', 
                            element_id  = '" . (int)$page_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . $this->db->escape($tag) . "'
                    ");
                endforeach;
            endif;
        }
        
        if (isset($data['page_store'])) {
            foreach ($data['page_store'] as $store_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}page_to_store 
					SET 
						page_id = '" . (int)$page_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        if (isset($data['page_layout'])) {
            foreach ($data['page_layout'] as $store_id => $layout) {
                if ($layout) {
                    $this->db->query("
						INSERT INTO {$this->db->prefix}page_to_layout 
						SET 
							page_id = '" . (int)$page_id . "', 
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
					route='content/page', 
					query = 'page_id:" . (int)$page_id . "', 
					slug = '" . $this->db->escape($data['slug']) . "'
			");
        }
        
        $this->cache->delete('page');
        
        $this->theme->trigger('admin_add_page', array('page_id' => $page_id));
    }
    
    public function editPage($page_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}page 
			SET 
				sort_order = '" . (int)$data['sort_order'] . "', 
				bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', 
				visibility = '" . (int)$data['visibility'] . "', 
				status = '" . (int)$data['status'] . "' 
				WHERE page_id = '" . (int)$page_id . "'
			");
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}page_description 
            WHERE page_id = '" . (int)$page_id . "'");
        
        foreach ($data['page_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}page_description 
				SET 
					page_id = '" . (int)$page_id . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" . $this->db->escape($value['title']) . "', 
					description = '" . $this->db->escape($value['description']) . "', 
					meta_description = '" . $this->db->escape($value['meta_description']) . "', 
					meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'
			");

            $this->db->query("
                DELETE FROM {$this->db->prefix}tag 
                WHERE section   = 'page' 
                AND element_id  = '" . (int)$page_id . "' 
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
                            section     = 'page', 
                            element_id  = '" . (int)$page_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . $this->db->escape($tag) . "'
                    ");
                endforeach;
            endif;
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}page_to_store 
            WHERE page_id = '" . (int)$page_id . "'");
        
        if (isset($data['page_store'])) {
            foreach ($data['page_store'] as $store_id) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}page_to_store 
					SET 
						page_id = '" . (int)$page_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}page_to_layout 
            WHERE page_id = '" . (int)$page_id . "'");
        
        if (isset($data['page_layout'])) {
            foreach ($data['page_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("
						INSERT INTO {$this->db->prefix}page_to_layout 
						SET 
							page_id = '" . (int)$page_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}route 
            WHERE query = 'page_id:" . (int)$page_id . "'");
        
        if ($data['slug']) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}route 
				SET 
					route = 'content/page', 
					query = 'page_id:" . (int)$page_id . "', 
					slug = '" . $this->db->escape($data['slug']) . "'
				");
        }
        
        $this->cache->delete('page');
        
        $this->theme->trigger('admin_edit_page', array('page_id' => $page_id));
    }
    
    public function deletePage($page_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}page 
            WHERE page_id = '" . (int)$page_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}page_description 
            WHERE page_id = '" . (int)$page_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}page_to_store 
            WHERE page_id = '" . (int)$page_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}page_to_layout 
            WHERE page_id = '" . (int)$page_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}route 
            WHERE query = 'page_id:" . (int)$page_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}tag 
            WHERE section  = 'page' 
            AND element_id = '" . (int)$page_id . "'");
        
        $this->cache->delete('page');
        
        $this->theme->trigger('admin_delete_page', array('page_id' => $page_id));
    }
    
    public function getPage($page_id) {
        $query = $this->db->query("
			SELECT DISTINCT *, 
			(SELECT slug 
				FROM {$this->db->prefix}route 
				WHERE query = 'page_id:" . (int)$page_id . "') AS slug 
			FROM {$this->db->prefix}page 
			WHERE page_id = '" . (int)$page_id . "'
		");

        if ($query->num_rows):
            $query->row['tag'] = $this->getPageTags($page_id);
        endif;

        return $query->row;
    }

    public function getPageTags($page_id) {
        $query = $this->db->query("
            SELECT tag 
            FROM {$this->db->prefix}tag 
            WHERE section   = 'page' 
            AND element_id  = '" . (int)$page_id . "' 
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
    
    public function getPages($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM {$this->db->prefix}page i 
				LEFT JOIN {$this->db->prefix}page_description id 
				ON (i.page_id = id.page_id) 
				WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            
            $sort_data = array('id.title', 'i.sort_order');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql.= " ORDER BY {$data['sort']}";
            } else {
                $sql.= " ORDER BY id.title";
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
            
            $query = $this->db->query($sql);
            
            return $query->rows;
        } else {
            $page_data = $this->cache->get('page.' . (int)$this->config->get('config_language_id'));
            
            if (!$page_data) {
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}page i 
					LEFT JOIN {$this->db->prefix}page_description id 
						ON (i.page_id = id.page_id) 
					WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' 
					ORDER BY id.title
				");
                
                $page_data = $query->rows;
                
                $this->cache->set('page.' . (int)$this->config->get('config_language_id'), $page_data);
            }
            
            return $page_data;
        }
    }
    
    public function getPageDescriptions($page_id) {
        $page_description_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}page_description 
			WHERE page_id = '" . (int)$page_id . "'
		");
        
        foreach ($query->rows as $result) {
            $page_description_data[$result['language_id']] = array(
                'title'            => $result['title'], 
                'description'      => $result['description'], 
                'meta_description' => $result['meta_description'], 
                'meta_keywords'    => $result['meta_keywords'],
                'tag'              => $this->getPageTags($page_id)
            );
        }
        
        return $page_description_data;
    }
    
    public function getPageStores($page_id) {
        $page_store_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}page_to_store 
			WHERE page_id = '" . (int)$page_id . "'
		");
        
        foreach ($query->rows as $result) {
            $page_store_data[] = $result['store_id'];
        }
        
        return $page_store_data;
    }
    
    public function getPageLayouts($page_id) {
        $page_layout_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}page_to_layout 
			WHERE page_id = '" . (int)$page_id . "'
		");
        
        foreach ($query->rows as $result) {
            $page_layout_data[$result['store_id']] = $result['layout_id'];
        }
        
        return $page_layout_data;
    }
    
    public function getTotalPages() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}page");
        
        return $query->row['total'];
    }
    
    public function getTotalPagesByLayoutId($layout_id) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}page_to_layout 
			WHERE layout_id = '" . (int)$layout_id . "'
		");
        
        return $query->row['total'];
    }
}
