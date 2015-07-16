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

namespace App\Models\Front\Total;
use App\Models\Model;

class Tax extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        foreach ($taxes as $key => $value):
            if ($value > 0):
                $total_data[] = array(
                    'code'       => 'tax', 
                    'title'      => Tax::getRateName($key), 
                    'text'       => Currency::format($value), 
                    'value'      => $value, 
                    'sort_order' => Config::get('tax_sort_order')
                );
                
                $total+= $value;
            endif;
        endforeach;
    }
}
