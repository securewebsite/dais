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

namespace App\Models\Front\Account;
use App\Models\Model;

class CustomerGroup extends Model {
    public function getCustomerGroup($customer_group_id) {
        $key = 'customer_group.' . $customer_group_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT DISTINCT * 
				FROM " . DB::prefix() . "customer_group cg 
				LEFT JOIN " . DB::prefix() . "customer_group_description cgd 
				ON (cg.customer_group_id = cgd.customer_group_id) 
				WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' 
				AND cgd.language_id = '" . (int)Config::get('config_language_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCustomerGroups() {
        $key = 'customer_group.all.' . (int)Config::get('config_store_id');
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "customer_group cg 
				LEFT JOIN " . DB::prefix() . "customer_group_description cgd 
				ON (cg.customer_group_id = cgd.customer_group_id) 
				WHERE cgd.language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY cg.sort_order ASC, cgd.name ASC
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
}
