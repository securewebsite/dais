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

class Page extends Model {
    public function getPage($page_id) {
        $key = 'page.' . $page_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT DISTINCT * 
				FROM " . DB::prefix() . "page i 
				LEFT JOIN " . DB::prefix() . "page_description id 
					ON (i.page_id = id.page_id) 
				LEFT JOIN " . DB::prefix() . "page_to_store i2s 
					ON (i.page_id = i2s.page_id) 
				WHERE i.page_id = '" . (int)$page_id . "' 
				AND id.language_id = '" . (int)Config::get('config_language_id') . "' 
				AND i2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND i.status = '1'
			");
            
            if ($query->num_rows):
                $query->row['tag'] = $this->getPageTags($page_id);
            
                $cachefile = $query->row;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getPages() {
        $key = 'pages.all.' . (int)Config::get('config_store_id');
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "page i 
				LEFT JOIN " . DB::prefix() . "page_description id 
					ON (i.page_id = id.page_id) 
				LEFT JOIN " . DB::prefix() . "page_to_store i2s 
					ON (i.page_id = i2s.page_id) 
				WHERE id.language_id = '" . (int)Config::get('config_language_id') . "' 
				AND i2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND i.status = '1' 
                AND i.event_id = '0' 
				ORDER BY i.sort_order, LCASE(id.title) ASC
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
    
    public function getPageLayoutId($page_id) {
        $key = 'page.layoutid.' . $page_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "page_to_layout 
				WHERE page_id = '" . (int)$page_id . "' 
				AND store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['layout_id'];
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, (int)0);
                return 0;
            endif;
        endif;
        
        return $cachefile;
    }

    public function getEventPage($page_id) {
        $data     = array();
        $page     = $this->getPage($page_id);
        $event_id = $page['event_id'];

        foreach ($page as $key => $value):
            $data[$key] = $value;
        endforeach;

        Theme::model('catalog/product');
        $event = CatalogProduct::getEvent($event_id);

        foreach($event as $key => $value):
            $data[$key] = $value;
        endforeach;

        $presenter = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "presenter 
            WHERE presenter_id = '" . (int)$event['presenter_id'] . "'
        ");
        
        $data['presenter'] = $presenter->row;
        
        return $data;        
    }
}
