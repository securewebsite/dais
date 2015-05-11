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

class Weight extends LibraryService {
    private $weights = array();
    
    public function __construct(Container $app) {
        parent::__construct($app);
        
        $key = 'default.store.weights';
        $rows = $app['cache']->get($key);
        
        if (is_bool($rows)):
            $weight_class_query = $app['db']->query("
                SELECT * 
                FROM {$app['db']->prefix}weight_class wc 
                LEFT JOIN {$app['db']->prefix}weight_class_description wcd 
                    ON (wc.weight_class_id = wcd.weight_class_id) 
                WHERE wcd.language_id = '" . (int)$app['config_language_id'] . "'
            ");
            
            $rows = $weight_class_query->rows;
            $app['cache']->set($key, $rows);
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
