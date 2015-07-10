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

class Length {
    
    private $lengths = array();
    
    public function __construct() {
        $key    = 'default.store.lengths';
        $rows   = Cache::get($key);
        
        if (is_bool($rows)):
            $length_class_query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "length_class mc 
                LEFT JOIN " . DB::prefix() . "length_class_description mcd 
                ON (mc.length_class_id = mcd.length_class_id) 
                WHERE mcd.language_id = '" . (int)Config::get('config_language_id') . "'
            ");
            $rows = $length_class_query->rows;
            Cache::set($key, $rows);
        endif;
        
        foreach ($rows as $result):
            $this->lengths[$result['length_class_id']] = array(
                'length_class_id' => $result['length_class_id'],
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
        
        if (isset($this->lengths[$from])):
            $from = $this->lengths[$from]['value'];
        else:
            $from = 0;
        endif;
        
        if (isset($this->lengths[$to])):
            $to = $this->lengths[$to]['value'];
        else:
            $to = 0;
        endif;
        
        return $value * ($to / $from);
    }
    
    public function format($value, $length_class_id, $decimal_point = '.', $thousand_point = ',') {
        if (isset($this->lengths[$length_class_id])):
            return number_format($value, 2, $decimal_point, $thousand_point) . $this->lengths[$length_class_id]['unit'];
        else:
            return number_format($value, 2, $decimal_point, $thousand_point);
        endif;
    }
    
    public function getUnit($length_class_id) {
        if (isset($this->lengths[$length_class_id])):
            return $this->lengths[$length_class_id]['unit'];
        else:
            return '';
        endif;
    }
}
