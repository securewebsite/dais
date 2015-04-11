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

namespace Front\Model\Checkout;
use Dais\Engine\Model;

class Giftcardtheme extends Model {
    public function getGiftcardTheme($giftcard_theme_id) {
        $key = md5('giftcard.themeid.' . $giftcard_theme_id);
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}giftcard_theme vt 
				LEFT JOIN {$this->db->prefix}giftcard_theme_description vtd 
				ON (vt.giftcard_theme_id = vtd.giftcard_theme_id) 
				WHERE vt.giftcard_theme_id = '" . (int)$giftcard_theme_id . "' 
				AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "'
			");
            
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
    
    public function getGiftcardThemes($data = array()) {
        if (!empty($data)):
            $key = 'giftcard.themes.all.' . md5(serialize($data));
            $cachefile = $this->cache->get($key);
            
            if (is_bool($cachefile)):
                $sql = "
					SELECT * 
					FROM {$this->db->prefix}giftcard_theme vt 
					LEFT JOIN {$this->db->prefix}giftcard_theme_description vtd 
						ON (vt.giftcard_theme_id = vtd.giftcard_theme_id) 
					WHERE vtd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
					ORDER BY vtd.name";
                
                if (isset($data['order']) && ($data['order'] == 'DESC')):
                    $sql.= " DESC";
                else:
                    $sql.= " ASC";
                endif;
                
                if (isset($data['start']) || isset($data['limit'])):
                    if ($data['start'] < 0):
                        $data['start'] = 0;
                    endif;
                    
                    if ($data['limit'] < 1):
                        $data['limit'] = 20;
                    endif;
                    
                    $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
                endif;
                
                $query = $this->db->query($sql);
                
                if ($query->num_rows):
                    $cachefile = $query->rows;
                    $this->cache->set($key, $cachefile);
                else:
                    $this->cache->set($key, array());
                    return array();
                endif;
            endif;
            unset($key);
        else:
            $key = 'giftcard.themes.all.' . (int)$this->config->get('config_store_id');
            $cachefile = $this->cache->get($key);
            
            if (is_bool($cachefile)):
                $query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}giftcard_theme vt 
					LEFT JOIN {$this->db->prefix}giftcard_theme_description vtd 
						ON (vt.giftcard_theme_id = vtd.giftcard_theme_id) 
					WHERE vtd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
					ORDER BY vtd.name
				");
                
                if ($query->num_rows):
                    $cachefile = $query->rows;
                    $this->cache->set($key, $cachefile);
                else:
                    $this->cache->set($key, array());
                    return array();
                endif;
            endif;
        endif;
        
        return $cachefile;
    }
}
