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

namespace Front\Model\Total;
use Dais\Base\Model;

class Tax extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        foreach ($taxes as $key => $value):
            if ($value > 0):
                $total_data[] = array(
                    'code'       => 'tax', 
                    'title'      => $this->tax->getRateName($key), 
                    'text'       => $this->currency->format($value), 
                    'value'      => $value, 
                    'sort_order' => $this->config->get('tax_sort_order')
                );
                
                $total+= $value;
            endif;
        endforeach;
    }
}
