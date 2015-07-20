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

namespace App\Models\Admin\Sale;

use App\Models\Model;

class GiftCardTheme extends Model {
    
    public function addGiftcardTheme($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "gift_card_theme 
			SET 
				image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "'
		");
        
        $gift_card_theme_id = DB::getLastId();
        
        foreach ($data['gift_card_theme_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "gift_card_theme_description 
				SET 
                    gift_card_theme_id = '" . (int)$gift_card_theme_id . "', 
                    language_id       = '" . (int)$language_id . "', 
                    name              = '" . DB::escape($value['name']) . "'
			");
        }
        
        Cache::delete('gift_card');
    }
    
    public function editGiftcardTheme($gift_card_theme_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "gift_card_theme 
			SET 
				image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
			WHERE gift_card_theme_id = '" . (int)$gift_card_theme_id . "'
		");
        
        DB::query("DELETE FROM " . DB::prefix() . "gift_card_theme_description WHERE gift_card_theme_id = '" . (int)$gift_card_theme_id . "'");
        
        foreach ($data['gift_card_theme_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "gift_card_theme_description 
				SET 
                    gift_card_theme_id = '" . (int)$gift_card_theme_id . "', 
                    language_id       = '" . (int)$language_id . "', 
                    name              = '" . DB::escape($value['name']) . "'
			");
        }
        
        Cache::delete('gift_card');
    }
    
    public function deleteGiftcardTheme($gift_card_theme_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "gift_card_theme 
            WHERE gift_card_theme_id = '" . (int)$gift_card_theme_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "gift_card_theme_description 
            WHERE gift_card_theme_id = '" . (int)$gift_card_theme_id . "'");
        
        Cache::delete('gift_card');
    }
    
    public function getGiftcardTheme($gift_card_theme_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "gift_card_theme vt 
			LEFT JOIN " . DB::prefix() . "gift_card_theme_description vtd 
				ON (vt.gift_card_theme_id = vtd.gift_card_theme_id) 
			WHERE vt.gift_card_theme_id = '" . (int)$gift_card_theme_id . "' 
			AND vtd.language_id = '" . (int)Config::get('config_language_id') . "'
		");
        
        return $query->row;
    }
    
    public function getGiftcardThemes($data = array()) {
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "gift_card_theme vt 
				LEFT JOIN " . DB::prefix() . "gift_card_theme_description vtd 
					ON (vt.gift_card_theme_id = vtd.gift_card_theme_id) 
				WHERE vtd.language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY vtd.name
			";
            
            if (isset($data['order']) && ($data['order'] == 'desc')) {
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
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "gift_card_theme vt 
				LEFT JOIN " . DB::prefix() . "gift_card_theme_description vtd 
					ON (vt.gift_card_theme_id = vtd.gift_card_theme_id) 
				WHERE vtd.language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY vtd.name
			");
            
            return $query->rows;
        }
    }
    
    public function getGiftcardThemeDescriptions($gift_card_theme_id) {
        $gift_card_theme_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "gift_card_theme_description 
			WHERE gift_card_theme_id = '" . (int)$gift_card_theme_id . "'
		");
        
        foreach ($query->rows as $result) {
            $gift_card_theme_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $gift_card_theme_data;
    }
    
    public function getTotalGiftcardThemes() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "gift_card_theme");
        
        return $query->row['total'];
    }
}
