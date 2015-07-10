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

class Currency {

    private $code;
    private $currencies = array();

    public function __construct() {
        $key  = 'default.store.currency';
        $rows = Cache::get($key);
        
        if (is_bool($rows)):
            $query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "currency");
            
            $rows = $query->rows;
            Cache::set($key, $rows);
        endif;
        unset($key);
        
        foreach ($rows as $result):
            $this->currencies[$result['code']] = array(
                'currency_id'   => $result['currency_id'],
                'title'         => $result['title'],
                'symbol_left'   => $result['symbol_left'],
                'symbol_right'  => $result['symbol_right'],
                'decimal_place' => $result['decimal_place'],
                'value'         => $result['value']
            );
        endforeach;
        
        if (isset(Request::p()->get['currency']) && (array_key_exists(Request::p()->get['currency'], $this->currencies))):
            $this->set(Request::p()->get['currency']);
        elseif ((isset(Session::p()->data['currency'])) && (array_key_exists(Session::p()->data['currency'], $this->currencies))):
            $this->set(Session::p()->data['currency']);
        elseif ((isset(Request::p()->cookie['currency'])) && (array_key_exists(Request::p()->cookie['currency'], $this->currencies))):
            $this->set(Request::p()->cookie['currency']);
        else:
            $this->set(Config::get('config_currency'));
        endif;
    }
    
    public function set($currency) {
        $this->code = $currency;
        
        if (!isset(Session::p()->data['currency']) || (Session::p()->data['currency'] != $currency)):
            Session::p()->data['currency'] = $currency;
        endif;
        
        if (!isset(Request::p()->cookie['currency']) || (Request::p()->cookie['currency'] != $currency)):
            setcookie('currency', $currency, time() + 60 * 60 * 24 * 30, '/', Request::p()->server['HTTP_HOST']);
        endif;
    }
    
    public function format($number, $currency = '', $value = '', $format = true) {
        if ($currency && $this->has($currency)):
            $symbol_left   = $this->currencies[$currency]['symbol_left'];
            $symbol_right  = $this->currencies[$currency]['symbol_right'];
            $decimal_place = $this->currencies[$currency]['decimal_place'];
        else:
            $symbol_left   = $this->currencies[$this->code]['symbol_left'];
            $symbol_right  = $this->currencies[$this->code]['symbol_right'];
            $decimal_place = $this->currencies[$this->code]['decimal_place'];
            
            $currency      = $this->code;
        endif;
        
        if ($value):
            $value = $value;
        else:
            $value = $this->currencies[$currency]['value'];
        endif;
        
        if ($value):
            $value = (float)$number * $value;
        else:
            $value = $number;
        endif;
        
        $string = '';
        
        if (($symbol_left) && ($format)):
            $string.= $symbol_left;
        endif;
        
        if ($format):
            $decimal_point = Lang::get('lang_decimal_point');
        else:
            $decimal_point = '.';
        endif;
        
        if ($format):
            $thousand_point = Lang::get('lang_thousand_point');
        else:
            $thousand_point = '';
        endif;
        
        $string.= number_format(round($value, (int)$decimal_place) , (int)$decimal_place, $decimal_point, $thousand_point);
        
        if (($symbol_right) && ($format)):
            $string.= $symbol_right;
        endif;
        
        return $string;
    }
    
    public function convert($value, $from, $to) {
        if (isset($this->currencies[$from])):
            $from = $this->currencies[$from]['value'];
        else:
            $from = 0;
        endif;
        
        if (isset($this->currencies[$to])):
            $to = $this->currencies[$to]['value'];
        else:
            $to = 0;
        endif;
        
        return $value * ($to / $from);
    }
    
    public function getId($currency = '') {
        if (!$currency):
            return $this->currencies[$this->code]['currency_id'];
        elseif ($currency && isset($this->currencies[$currency])):
            return $this->currencies[$currency]['currency_id'];
        else:
            return 0;
        endif;
    }
    
    public function getSymbolLeft($currency = '') {
        if (!$currency):
            return $this->currencies[$this->code]['symbol_left'];
        elseif ($currency && isset($this->currencies[$currency])):
            return $this->currencies[$currency]['symbol_left'];
        else:
            return '';
        endif;
    }
    
    public function getSymbolRight($currency = '') {
        if (!$currency):
            return $this->currencies[$this->code]['symbol_right'];
        elseif ($currency && isset($this->currencies[$currency])):
            return $this->currencies[$currency]['symbol_right'];
        else:
            return '';
        endif;
    }
    
    public function getDecimalPlace($currency = '') {
        if (!$currency):
            return $this->currencies[$this->code]['decimal_place'];
        elseif ($currency && isset($this->currencies[$currency])):
            return $this->currencies[$currency]['decimal_place'];
        else:
            return 0;
        endif;
    }
    
    public function getCode() {
        return $this->code;
    }
    
    public function getValue($currency = '') {
        if (!$currency):
            return $this->currencies[$this->code]['value'];
        elseif ($currency && isset($this->currencies[$currency])):
            return $this->currencies[$currency]['value'];
        else:
            return 0;
        endif;
    }
    
    public function has($currency) {
        return isset($this->currencies[$currency]);
    }
}
