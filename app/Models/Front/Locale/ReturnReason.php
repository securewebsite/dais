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

namespace App\Models\Front\Locale;
use App\Models\Model;

class ReturnReason extends Model {
    public function getReturnReason($return_reason_id) {
        $key = 'return.reason.' . $return_reason_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}return_reason 
				WHERE return_reason_id = '" . (int)$return_reason_id . "' 
				AND language_id = '" . (int)Config::get('config_language_id') . "'
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
    
    public function getReturnReasons($data = array()) {
        if ($data) {
            $sql = "SELECT * 
				    FROM {$this->db->prefix}return_reason 
					WHERE language_id = '" . (int)Config::get('config_language_id') . "'";
            
            $sql.= " ORDER BY name";
            
            if (isset($data['return']) && ($data['return'] == 'DESC')) {
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
            
            $cachefile = $query->rows;
        } else {
            $key = 'return.reasons.all.' . (int)Config::get('config_store_id');
            $cachefile = $this->cache->get($key);
            
            if (is_bool($cachefile)) {
                $query = $this->db->query("
					SELECT return_reason_id, name 
					FROM {$this->db->prefix}return_reason 
					WHERE language_id = '" . (int)Config::get('config_language_id') . "' 
					ORDER BY name
				");
                
                if ($query->num_rows):
                    $cachefile = $query->rows;
                    $this->cache->set($key, $cachefile);
                else:
                    $this->cache->set($key, array());
                    return array();
                endif;
            }
        }
        
        return $cachefile;
    }
    
    public function getReturnReasonDescriptions($return_reason_id) {
        $key = 'return.reasons.descriptions.' . $return_reason_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $return_reason_data = array();
            
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}return_reason 
				WHERE return_reason_id = '" . (int)$return_reason_id . "'
			");
            
            foreach ($query->rows as $result):
                $return_reason_data[$result['language_id']] = array('name' => $result['name']);
            endforeach;
            
            $cachefile = $return_reason_data;
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getTotalReturnReasons() {
        $key = 'return.reasons.total.' . (int)Config::get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT COUNT(*) AS total 
				FROM {$this->db->prefix}return_reason 
				WHERE language_id = '" . (int)Config::get('config_language_id') . "'
			");
            $cachefile = $query->row['total'];
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
}
