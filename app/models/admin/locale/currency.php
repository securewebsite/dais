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

class Currency extends Model {
    
    public function addCurrency($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "currency 
			SET 
                title         = '" . DB::escape($data['title']) . "', 
                code          = '" . DB::escape($data['code']) . "', 
                symbol_left   = '" . DB::escape($data['symbol_left']) . "', 
                symbol_right  = '" . DB::escape($data['symbol_right']) . "', 
                decimal_place = '" . DB::escape($data['decimal_place']) . "', 
                value         = '" . DB::escape($data['value']) . "', 
                status        = '" . (int)$data['status'] . "', 
                date_modified = NOW()
		");
        
        if (Config::get('config_currency_auto')):
            $this->updateCurrencies(true);
        endif;
        
        Cache::delete('currency');
        Cache::delete('default.store.currency');
    }
    
    public function editCurrency($currency_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "currency 
			SET 
                title         = '" . DB::escape($data['title']) . "', 
                code          = '" . DB::escape($data['code']) . "', 
                symbol_left   = '" . DB::escape($data['symbol_left']) . "', 
                symbol_right  = '" . DB::escape($data['symbol_right']) . "', 
                decimal_place = '" . DB::escape($data['decimal_place']) . "', 
                value         = '" . DB::escape($data['value']) . "', 
                status        = '" . (int)$data['status'] . "', 
                date_modified = NOW() 
			WHERE currency_id = '" . (int)$currency_id . "'
		");
        
        Cache::delete('currency');
        Cache::delete('default.store.currency');
    }
    
    public function deleteCurrency($currency_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "currency 
            WHERE currency_id = '" . (int)$currency_id . "'");
        
        Cache::delete('currency');
        Cache::delete('default.store.currency');
    }
    
    public function getCurrency($currency_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "currency 
			WHERE currency_id = '" . (int)$currency_id . "'
		");
        
        return $query->row;
    }
    
    public function getCurrencyByCode($currency) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "currency 
			WHERE code = '" . DB::escape($currency) . "'
		");
        
        return $query->row;
    }
    
    public function getCurrencies($data = array()) {
        if ($data):
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "currency";
            
            $sort_data = array('title', 'code', 'value', 'date_modified');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)):
                $sql.= " ORDER BY {$data['sort']}";
            else:
                $sql.= " ORDER BY title";
            endif;
            
            if (isset($data['order']) && ($data['order'] == 'desc')):
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
            $currency_data = array();
            
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "currency 
				ORDER BY title ASC
			");
            
            foreach ($query->rows as $result):
                $currency_data[$result['code']] = array(
                    'currency_id'   => $result['currency_id'], 
                    'title'         => $result['title'], 
                    'code'          => $result['code'], 
                    'symbol_left'   => $result['symbol_left'], 
                    'symbol_right'  => $result['symbol_right'], 
                    'decimal_place' => $result['decimal_place'], 
                    'value'         => $result['value'], 
                    'status'        => $result['status'], 
                    'date_modified' => $result['date_modified']);
            endforeach;
            
            return $currency_data;
        endif;
    }
    
    public function updateCurrencies($force = false) {
        if (extension_loaded('curl')):
            $data = array();
            
            if ($force):
                $query = DB::query("
					SELECT * 
					FROM " . DB::prefix() . "currency 
					WHERE code != '" . DB::escape(Config::get('config_currency')) . "'
				");
            else:
                $query = DB::query("
					SELECT * 
					FROM " . DB::prefix() . "currency 
					WHERE code != '" . DB::escape(Config::get('config_currency')) . "' 
					AND date_modified < '" . DB::escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'
				");
            endif;
            
            foreach ($query->rows as $result):
                $data[] = Config::get('config_currency') . $result['code'] . '=X';
            endforeach;
            
            $curl = curl_init();
            
            curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $data) . '&f=sl1&e=.csv');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            
            $content = curl_exec($curl);
            
            curl_close($curl);
            
            $lines = explode("\n", trim($content));
            
            foreach ($lines as $line):
                $currency = Encode::substr($line, 4, 3);
                $value = Encode::substr($line, 11, 6);
                
                if ((float)$value):
                    DB::query("
						UPDATE " . DB::prefix() . "currency 
						SET 
							value = '" . (float)$value . "', 
							date_modified = '" . DB::escape(date('Y-m-d H:i:s')) . "' 
						WHERE code = '" . DB::escape($currency) . "'
					");
                endif;
            endforeach;
            
            DB::query("
				UPDATE " . DB::prefix() . "currency 
				SET 
					value = '1.00000', 
					date_modified = '" . DB::escape(date('Y-m-d H:i:s')) . "' 
				WHERE code = '" . DB::escape(Config::get('config_currency')) . "'
			");
            
            Cache::delete('currency');
        endif;
    }
    
    public function getTotalCurrencies() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "currency");
        
        return $query->row['total'];
    }
}
