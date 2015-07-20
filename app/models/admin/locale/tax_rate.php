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

namespace App\Models\Admin\Locale;

use App\Models\Model;

class TaxRate extends Model {
    
    public function addTaxRate($data) {
        DB::query("INSERT INTO " . DB::prefix() . "tax_rate SET name = '" . DB::escape($data['name']) . "', rate = '" . (float)$data['rate'] . "', `type` = '" . DB::escape($data['type']) . "', geo_zone_id = '" . (int)$data['geo_zone_id'] . "', date_added = NOW(), date_modified = NOW()");
        
        $tax_rate_id = DB::getLastId();
        
        if (isset($data['tax_rate_customer_group'])) {
            foreach ($data['tax_rate_customer_group'] as $customer_group_id) {
                DB::query("INSERT INTO " . DB::prefix() . "tax_rate_to_customer_group SET tax_rate_id = '" . (int)$tax_rate_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
            }
        }
    }
    
    public function editTaxRate($tax_rate_id, $data) {
        DB::query("UPDATE " . DB::prefix() . "tax_rate SET name = '" . DB::escape($data['name']) . "', rate = '" . (float)$data['rate'] . "', `type` = '" . DB::escape($data['type']) . "', geo_zone_id = '" . (int)$data['geo_zone_id'] . "', date_modified = NOW() WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
        
        DB::query("DELETE FROM " . DB::prefix() . "tax_rate_to_customer_group WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
        
        if (isset($data['tax_rate_customer_group'])) {
            foreach ($data['tax_rate_customer_group'] as $customer_group_id) {
                DB::query("INSERT INTO " . DB::prefix() . "tax_rate_to_customer_group SET tax_rate_id = '" . (int)$tax_rate_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
            }
        }
    }
    
    public function deleteTaxRate($tax_rate_id) {
        DB::query("DELETE FROM " . DB::prefix() . "tax_rate WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
        DB::query("DELETE FROM " . DB::prefix() . "tax_rate_to_customer_group WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
    }
    
    public function getTaxRate($tax_rate_id) {
        $query = DB::query("SELECT tr.tax_rate_id, tr.name AS name, tr.rate, tr.type, tr.geo_zone_id, gz.name AS geo_zone, tr.date_added, tr.date_modified FROM " . DB::prefix() . "tax_rate tr LEFT JOIN " . DB::prefix() . "geo_zone gz ON (tr.geo_zone_id = gz.geo_zone_id) WHERE tr.tax_rate_id = '" . (int)$tax_rate_id . "'");
        
        return $query->row;
    }
    
    public function getTaxRates($data = array()) {
        $sql = "SELECT tr.tax_rate_id, tr.name AS name, tr.rate, tr.type, gz.name AS geo_zone, tr.date_added, tr.date_modified FROM " . DB::prefix() . "tax_rate tr LEFT JOIN " . DB::prefix() . "geo_zone gz ON (tr.geo_zone_id = gz.geo_zone_id)";
        
        $sort_data = array('tr.name', 'tr.rate', 'tr.type', 'gz.name', 'tr.date_added', 'tr.date_modified');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY tr.name";
        }
        
        if (isset($data['order']) && ($data['order'] == 'desc')) {
            $sql.= " DESC";
        } else {
            $sql.= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function getTaxRateCustomerGroups($tax_rate_id) {
        $tax_customer_group_data = array();
        
        $query = DB::query("SELECT * FROM " . DB::prefix() . "tax_rate_to_customer_group WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
        
        foreach ($query->rows as $result) {
            $tax_customer_group_data[] = $result['customer_group_id'];
        }
        
        return $tax_customer_group_data;
    }
    
    public function getTotalTaxRates() {
        $query = DB::query("SELECT COUNT(*) AS total FROM " . DB::prefix() . "tax_rate");
        
        return $query->row['total'];
    }
    
    public function getTotalTaxRatesByGeoZoneId($geo_zone_id) {
        $query = DB::query("SELECT COUNT(*) AS total FROM " . DB::prefix() . "tax_rate WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        return $query->row['total'];
    }
}
