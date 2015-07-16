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

class Total extends Model {
    public function getTotal(&$total_data, &$total, &$taxes) {
        Lang::load('total/total');
        
        $total_data[] = array(
			'code'       => 'total', 
			'title'      => Lang::get('lang_text_total'), 
			'text'       => Currency::format(max(0, $total)), 
			'value'      => max(0, $total), 
			'sort_order' => Config::get('total_sort_order')
        );
    }
}
