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

class Page extends Model {
    
    public function addPage($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "page 
			SET 
                sort_order = '" . (int)$data['sort_order'] . "', 
                bottom     = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', 
                visibility = '" . (int)$data['visibility'] . "', 
                status     = '" . (int)$data['status'] . "'
		");
        
        $page_id = DB::getLastId();
        
        foreach ($data['page_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "page_description 
				SET 
                    page_id          = '" . (int)$page_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    title            = '" . DB::escape($value['title']) . "', 
                    description      = '" . DB::escape($value['description']) . "', 
                    meta_description = '" . DB::escape($value['meta_description']) . "', 
                    meta_keywords    = '" . DB::escape($value['meta_keywords']) . "'
			");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    DB::query("
                        INSERT INTO " . DB::prefix() . "tag 
                        SET 
                            section     = 'page', 
                            element_id  = '" . (int)$page_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . DB::escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->add($language_id, 'page', $page_id, $value['title']);
            $this->search->add($language_id, 'page', $page_id, $value['description']);
        }
        
        if (isset($data['page_store'])) {
            foreach ($data['page_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "page_to_store 
					SET 
						page_id  = '" . (int)$page_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        if (isset($data['page_layout'])) {
            foreach ($data['page_layout'] as $store_id => $layout) {
                if ($layout) {
                    DB::query("
						INSERT INTO " . DB::prefix() . "page_to_layout 
						SET 
                            page_id   = '" . (int)$page_id . "', 
                            store_id  = '" . (int)$store_id . "', 
                            layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
                    route ='content/page', 
                    query = 'page_id:" . (int)$page_id . "', 
                    slug  = '" . DB::escape($data['slug']) . "'
			");
        }
        
        Cache::delete('page');
        
        Theme::trigger('admin_add_page', array('page_id' => $page_id));
    }
    
    public function editPage($page_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "page 
			SET 
                sort_order = '" . (int)$data['sort_order'] . "', 
                bottom     = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', 
                visibility = '" . (int)$data['visibility'] . "', 
                status     = '" . (int)$data['status'] . "' 
			WHERE page_id  = '" . (int)$page_id . "'
		");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "page_description 
            WHERE page_id = '" . (int)$page_id . "'");
        
        foreach ($data['page_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "page_description 
				SET 
                    page_id          = '" . (int)$page_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    title            = '" . DB::escape($value['title']) . "', 
                    description      = '" . DB::escape($value['description']) . "', 
                    meta_description = '" . DB::escape($value['meta_description']) . "', 
                    meta_keywords    = '" . DB::escape($value['meta_keywords']) . "'
			");

            DB::query("
                DELETE FROM " . DB::prefix() . "tag 
                WHERE section   = 'page' 
                AND element_id  = '" . (int)$page_id . "' 
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
                            section     = 'page', 
                            element_id  = '" . (int)$page_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . DB::escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->delete('page', $page_id);

            $this->search->add($language_id, 'page', $page_id, $value['title']);
            $this->search->add($language_id, 'page', $page_id, $value['description']);
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "page_to_store 
            WHERE page_id = '" . (int)$page_id . "'");
        
        if (isset($data['page_store'])) {
            foreach ($data['page_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "page_to_store 
					SET 
						page_id  = '" . (int)$page_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "page_to_layout 
            WHERE page_id = '" . (int)$page_id . "'");
        
        if (isset($data['page_layout'])) {
            foreach ($data['page_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    DB::query("
						INSERT INTO " . DB::prefix() . "page_to_layout 
						SET 
                            page_id   = '" . (int)$page_id . "', 
                            store_id  = '" . (int)$store_id . "', 
                            layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        /**
         * We have different schema for event pages.
         * This doesn't effect us when adding a page, because
         * events create their own pages in the event model.
         * But we edit those pages here in the page model. 
         */
        
        if (isset($data['event_id'])):
            DB::query("
                DELETE FROM " . DB::prefix() . "route 
                WHERE query = 'event_page_id:" . (int)$page_id . "'");
            
            if ($data['slug']):
                DB::query("
                    INSERT INTO " . DB::prefix() . "route 
                    SET 
                        route = 'event/page', 
                        query = 'event_page_id:" . (int)$page_id . "', 
                        slug  = '" . DB::escape($data['slug']) . "'
                ");
            endif;
        else:
            DB::query("
                DELETE FROM " . DB::prefix() . "route 
                WHERE query = 'page_id:" . (int)$page_id . "'");
            
            if ($data['slug']):
                DB::query("
    				INSERT INTO " . DB::prefix() . "route 
    				SET 
                        route = 'content/page', 
                        query = 'page_id:" . (int)$page_id . "', 
                        slug  = '" . DB::escape($data['slug']) . "'
    			");
            endif;
        endif;
        
        Cache::delete('page');
        
        Theme::trigger('admin_edit_page', array('page_id' => $page_id));
    }
    
    public function deletePage($page_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "page 
            WHERE page_id = '" . (int)$page_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "page_description 
            WHERE page_id = '" . (int)$page_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "page_to_store 
            WHERE page_id = '" . (int)$page_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "page_to_layout 
            WHERE page_id = '" . (int)$page_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'page_id:" . (int)$page_id . "'");

        // event page slugs
        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'event_page_id:" . (int)$page_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "tag 
            WHERE section  = 'page' 
            AND element_id = '" . (int)$page_id . "'");
        
        $this->search->delete('page', $page_id);
        
        Cache::delete('page');
        
        Theme::trigger('admin_delete_page', array('page_id' => $page_id));
    }
    
    public function getPage($page_id) {
        $query = DB::query("
			SELECT DISTINCT *, 
			(SELECT slug 
				FROM " . DB::prefix() . "route 
				WHERE query = 'page_id:" . (int)$page_id . "') AS slug 
			FROM " . DB::prefix() . "page 
			WHERE page_id = '" . (int)$page_id . "'
		");

        if ($query->num_rows):
            $query->row['tag'] = $this->getPageTags($page_id);
        endif;

        return $query->row;
    }

    public function getEventPage($page_id) {
        $query = DB::query("
            SELECT DISTINCT *, 
            (SELECT slug 
                FROM " . DB::prefix() . "route 
                WHERE query = 'event_page_id:" . (int)$page_id . "') AS slug 
            FROM " . DB::prefix() . "page 
            WHERE page_id = '" . (int)$page_id . "'
        ");

        if ($query->num_rows):
            $query->row['tag'] = $this->getPageTags($page_id);
        endif;

        return $query->row;
    }

    public function getPageTags($page_id) {
        $query = DB::query("
            SELECT tag 
            FROM " . DB::prefix() . "tag 
            WHERE section   = 'page' 
            AND element_id  = '" . (int)$page_id . "' 
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
    
    public function getPages($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "page i 
				LEFT JOIN " . DB::prefix() . "page_description id 
				ON (i.page_id = id.page_id) 
				WHERE id.language_id = '" . (int)Config::get('config_language_id') . "'";
            
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
            
            $query = DB::query($sql);
            
            return $query->rows;
        } else {
            $page_data = Cache::get('page.' . (int)Config::get('config_language_id'));
            
            if (!$page_data) {
                $query = DB::query("
					SELECT * 
					FROM " . DB::prefix() . "page i 
					LEFT JOIN " . DB::prefix() . "page_description id 
						ON (i.page_id = id.page_id) 
					WHERE id.language_id = '" . (int)Config::get('config_language_id') . "' 
					ORDER BY id.title
				");
                
                $page_data = $query->rows;
                
                Cache::set('page.' . (int)Config::get('config_language_id'), $page_data);
            }
            
            return $page_data;
        }
    }
    
    public function getPageDescriptions($page_id) {
        $page_description_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "page_description 
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
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "page_to_store 
			WHERE page_id = '" . (int)$page_id . "'
		");
        
        foreach ($query->rows as $result) {
            $page_store_data[] = $result['store_id'];
        }
        
        return $page_store_data;
    }
    
    public function getPageLayouts($page_id) {
        $page_layout_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "page_to_layout 
			WHERE page_id = '" . (int)$page_id . "'
		");
        
        foreach ($query->rows as $result) {
            $page_layout_data[$result['store_id']] = $result['layout_id'];
        }
        
        return $page_layout_data;
    }

    public function getEventSlug($page_id) {
        $query = DB::query("
            SELECT slug 
            FROM " . DB::prefix() . "route 
            WHERE route = 'event/page' 
            AND query = 'event_page_id:" . (int)$page_id . "'
        ");

        return $query->row['slug'];
    }

    public function getEventName($event_id) {
        $query = DB::query("
            SELECT event_name 
            FROM " . DB::prefix() . "event_manager 
            WHERE event_id = '" . (int)$event_id . "'
        ");

        return $query->row['event_name'];
    }
    
    public function getTotalPages() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "page");
        
        return $query->row['total'];
    }
    
    public function getTotalPagesByLayoutId($layout_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "page_to_layout 
			WHERE layout_id = '" . (int)$layout_id . "'
		");
        
        return $query->row['total'];
    }
}
