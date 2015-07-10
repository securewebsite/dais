<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace Dais\Services\Providers\Utility;

class Weight {
    
    private $weights = array();
    
    public function __construct() {
        $key    = 'default.store.weights';
        $rows   = Cache::get($key);
        
        if (is_bool($rows)):
            $weight_class_query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "weight_class wc 
                LEFT JOIN " . DB::prefix() . "weight_class_description wcd 
                    ON (wc.weight_class_id = wcd.weight_class_id) 
                WHERE wcd.language_id = '" . (int)Config::get('config_language_id') . "'
            ");
            
            $rows = $weight_class_query->rows;
            Cache::set($key, $rows);
        endif;
        unset($key);
        
        foreach ($rows as $result):
            $this->weights[$result['weight_class_id']] = array(
                'weight_class_id' => $result['weight_class_id'],
                'title'           => $result['title'],
                'unit'            => $result['unit'],
                'value'           => $result['value']
            );
        endforeach;
    }
    
    public function convert($value, $from, $to) {
        if ($from == $to):
            return $value;
        endif;
        
        if (isset($this->weights[$from])):
            $from = $this->weights[$from]['value'];
        else:
            $from = 1;
        endif;
        
        if (isset($this->weights[$to])):
            $to = $this->weights[$to]['value'];
        else:
            $to = 1;
        endif;
        
        return $value * ($to / $from);
    }
    
    public function format($value, $weight_class_id, $decimal_point = '.', $thousand_point = ',') {
        if (isset($this->weights[$weight_class_id])):
            return number_format($value, 2, $decimal_point, $thousand_point) . $this->weights[$weight_class_id]['unit'];
        else:
            return number_format($value, 2, $decimal_point, $thousand_point);
        endif;
    }
    
    public function getUnit($weight_class_id) {
        if (isset($this->weights[$weight_class_id])):
            return $this->weights[$weight_class_id]['unit'];
        else:
            return '';
        endif;
    }
}
