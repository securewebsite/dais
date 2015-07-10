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

namespace Front\Model\Checkout;
use Dais\Base\Model;

class Recurring extends Model {
    public function create($item, $order_id, $description) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order_recurring` 
			SET 
				`order_id`              = '" . (int)$order_id . "', 
				`date_added`            = NOW(), 
				`status`                = 6, 
				`product_id`            = '" . (int)$item['product_id'] . "', 
				`product_name`          = '" . $this->db->escape($item['name']) . "', 
				`product_quantity`      = '" . $this->db->escape($item['quantity']) . "', 
				`recurring_id`          = '" . (int)$item['recurring']['recurring_id'] . "', 
				`recurring_name`        = '" . $this->db->escape($item['recurring']['name']) . "', 
				`recurring_description` = '" . $this->db->escape($description) . "', 
				`recurring_frequency`   = '" . $this->db->escape($item['recurring']['frequency']) . "', 
				`recurring_cycle`       = '" . (int)$item['recurring']['cycle'] . "', 
				`recurring_duration`    = '" . (int)$item['recurring']['duration'] . "', 
				`recurring_price`       = '" . (float)$item['recurring']['price'] . "', 
				`trial`                 = '" . (int)$item['recurring']['trial'] . "', 
				`trial_frequency`       = '" . $this->db->escape($item['recurring']['trial_frequency']) . "', 
				`trial_cycle`           = '" . (int)$item['recurring']['trial_cycle'] . "', 
				`trial_duration`        = '" . (int)$item['recurring']['trial_duration'] . "', 
				`trial_price`           = '" . (float)$item['recurring']['trial_price'] . "', 
				`reference`             = ''");
        
        return $this->db->getLastId();
    }
    
    public function addReference($recurring_id, $ref) {
        $this->db->query("
			UPDATE {$this->db->prefix}order_recurring 
			SET reference = '" . $this->db->escape($ref) . "' 
			WHERE order_recurring_id = '" . (int)$recurring_id . "'");
        
        if ($this->db->countAffected() > 0):
            return true;
        else:
            return false;
        endif;
    }
}
