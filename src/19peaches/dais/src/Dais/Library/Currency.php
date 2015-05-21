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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Currency extends LibraryService {
    private $code;
    private $currencies = array();
    
    public function __construct(Container $app) {
        parent::__construct($app);
        
        $key  = 'default.store.currency';
        $rows = $app['cache']->get($key);
        
        if (is_bool($rows)):
            $query = $app['db']->query("
                SELECT * 
                FROM {$app['db']->prefix}currency");
            
            $rows = $query->rows;
            $app['cache']->set($key, $rows);
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
        
        if (isset($app['request']->get['currency']) && (array_key_exists($app['request']->get['currency'], $this->currencies))):
            $this->set($app['request']->get['currency']);
        elseif ((isset($app['session']->data['currency'])) && (array_key_exists($app['session']->data['currency'], $this->currencies))):
            $this->set($app['session']->data['currency']);
        elseif ((isset($app['request']->cookie['currency'])) && (array_key_exists($app['request']->cookie['currency'], $this->currencies))):
            $this->set($app['request']->cookie['currency']);
        else:
            $this->set($app['config_currency']);
        endif;
    }
    
    public function set($currency) {
        $request = parent::$app['request'];
        $session = parent::$app['session'];
        
        $this->code = $currency;
        
        if (!isset($session->data['currency']) || ($session->data['currency'] != $currency)):
            $session->data['currency'] = $currency;
        endif;
        
        if (!isset($request->cookie['currency']) || ($request->cookie['currency'] != $currency)):
            setcookie('currency', $currency, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
        endif;
    }
    
    public function format($number, $currency = '', $value = '', $format = true) {
        $language = parent::$app['language'];
        
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
            $decimal_point = $language->get('lang_decimal_point');
        else:
            $decimal_point = '.';
        endif;
        
        if ($format):
            $thousand_point = $language->get('lang_thousand_point');
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
