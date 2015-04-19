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

namespace Front\Model\Content;
use Dais\Engine\Model;

class Page extends Model {
    public function getPage($page_id) {
        $key = 'page.' . $page_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT DISTINCT * 
				FROM {$this->db->prefix}page i 
				LEFT JOIN {$this->db->prefix}page_description id 
					ON (i.page_id = id.page_id) 
				LEFT JOIN {$this->db->prefix}page_to_store i2s 
					ON (i.page_id = i2s.page_id) 
				WHERE i.page_id = '" . (int)$page_id . "' 
				AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
				AND i.status = '1'
			");

            $query->row['tag'] = $this->getPageTags($page_id);
            
            if ($query->num_rows):
                $cachefile = $query->row;
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getPages() {
        $key = 'pages.all.' . (int)$this->config->get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}page i 
				LEFT JOIN {$this->db->prefix}page_description id 
					ON (i.page_id = id.page_id) 
				LEFT JOIN {$this->db->prefix}page_to_store i2s 
					ON (i.page_id = i2s.page_id) 
				WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
				AND i.status = '1' 
				ORDER BY i.sort_order, LCASE(id.title) ASC
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
    
    public function getPageLayoutId($page_id) {
        $key = 'page.layoutid.' . $page_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}page_to_layout 
				WHERE page_id = '" . (int)$page_id . "' 
				AND store_id = '" . (int)$this->config->get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['layout_id'];
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, (int)0);
                return 0;
            endif;
        endif;
        
        return $cachefile;
    }
}
