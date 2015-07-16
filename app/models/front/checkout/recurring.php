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

namespace App\Models\Front\Checkout;
use App\Models\Model;

class Recurring extends Model {
    public function create($item, $order_id, $description) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order_recurring` 
			SET 
				`order_id`              = '" . (int)$order_id . "', 
				`date_added`            = NOW(), 
				`status`                = 6, 
				`product_id`            = '" . (int)$item['product_id'] . "', 
				`product_name`          = '" . DB::escape($item['name']) . "', 
				`product_quantity`      = '" . DB::escape($item['quantity']) . "', 
				`recurring_id`          = '" . (int)$item['recurring']['recurring_id'] . "', 
				`recurring_name`        = '" . DB::escape($item['recurring']['name']) . "', 
				`recurring_description` = '" . DB::escape($description) . "', 
				`recurring_frequency`   = '" . DB::escape($item['recurring']['frequency']) . "', 
				`recurring_cycle`       = '" . (int)$item['recurring']['cycle'] . "', 
				`recurring_duration`    = '" . (int)$item['recurring']['duration'] . "', 
				`recurring_price`       = '" . (float)$item['recurring']['price'] . "', 
				`trial`                 = '" . (int)$item['recurring']['trial'] . "', 
				`trial_frequency`       = '" . DB::escape($item['recurring']['trial_frequency']) . "', 
				`trial_cycle`           = '" . (int)$item['recurring']['trial_cycle'] . "', 
				`trial_duration`        = '" . (int)$item['recurring']['trial_duration'] . "', 
				`trial_price`           = '" . (float)$item['recurring']['trial_price'] . "', 
				`reference`             = ''");
        
        return DB::getLastId();
    }
    
    public function addReference($recurring_id, $ref) {
        DB::query("
			UPDATE " . DB::prefix() . "order_recurring 
			SET reference = '" . DB::escape($ref) . "' 
			WHERE order_recurring_id = '" . (int)$recurring_id . "'");
        
        if (DB::countAffected() > 0):
            return true;
        else:
            return false;
        endif;
    }
}
