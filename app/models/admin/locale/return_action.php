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

namespace App\Models\Admin\Locale;

use App\Models\Model;

class ReturnAction extends Model {
    
    public function addReturnAction($data) {
        foreach ($data['return_action'] as $language_id => $value):
            if (isset($return_action_id)):
                DB::query("
                    INSERT INTO " . DB::prefix() . "return_action 
                    SET 
                        return_action_id = '" . (int)$return_action_id . "', 
                        language_id      = '" . (int)$language_id . "', 
                        name             = '" . DB::escape($value['name']) . "'
                ");
            else:
                DB::query("
                    INSERT INTO " . DB::prefix() . "return_action 
                    SET 
                        language_id = '" . (int)$language_id . "', 
                        name        = '" . DB::escape($value['name']) . "'
                ");
                
                $return_action_id = DB::getLastId();
            endif;
        endforeach;
        
        Cache::delete('return_action');
    }
    
    public function editReturnAction($return_action_id, $data) {
        DB::query("
            DELETE FROM " . DB::prefix() . "return_action 
            WHERE return_action_id = '" . (int)$return_action_id . "'");
        
        foreach ($data['return_action'] as $language_id => $value):
            DB::query("
                INSERT INTO " . DB::prefix() . "return_action 
                SET 
                    return_action_id = '" . (int)$return_action_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    name             = '" . DB::escape($value['name']) . "'
            ");
        endforeach;
        
        Cache::delete('return_action');
    }
    
    public function deleteReturnAction($return_action_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "return_action 
            WHERE return_action_id = '" . (int)$return_action_id . "'");
        
        Cache::delete('return_action');
    }
    
    public function getReturnAction($return_action_id) {
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "return_action 
            WHERE return_action_id = '" . (int)$return_action_id . "' 
            AND language_id = '" . (int)Config::get('config_language_id') . "'
        ");
        
        return $query->row;
    }
    
    public function getReturnActions($data = array()) {
        if ($data):
            $sql = "
                SELECT * 
                FROM " . DB::prefix() . "return_action 
                WHERE language_id = '" . (int)Config::get('config_language_id') . "'";
            
            $sql.= " ORDER BY name";
            
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
            
            $query = DB::query($sql);
            
            return $query->rows;
        else:
            $return_action_data = Cache::get('return_action.' . (int)Config::get('config_language_id'));
            
            if (!$return_action_data):
                $query = DB::query("
                    SELECT 
                        return_action_id, 
                        name 
                    FROM " . DB::prefix() . "return_action 
                    WHERE language_id = '" . (int)Config::get('config_language_id') . "' 
                    ORDER BY name
                ");
                
                $return_action_data = $query->rows;
                
                Cache::set('return_action.' . (int)Config::get('config_language_id'), $return_action_data);
            endif;
            
            return $return_action_data;
        endif;
    }
    
    public function getReturnActionDescriptions($return_action_id) {
        $return_action_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "return_action 
            WHERE return_action_id = '" . (int)$return_action_id . "'
        ");
        
        foreach ($query->rows as $result):
            $return_action_data[$result['language_id']] = array('name' => $result['name']);
        endforeach;
        
        return $return_action_data;
    }
    
    public function getTotalReturnActions() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "return_action 
            WHERE language_id = '" . (int)Config::get('config_language_id') . "'
        ");
        
        return $query->row['total'];
    }
}
